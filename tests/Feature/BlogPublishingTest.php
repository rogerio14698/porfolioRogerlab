<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminBlogController;
use App\Http\Requests\SaveBlogRequest;
use App\Models\Blog;
use App\Models\User;
use App\Services\BlogOwnerCredentials;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class BlogPublishingTest extends TestCase
{
    use RefreshDatabase;

    private string $environmentDirectory;

    private string $initialPassword = 'test-only-password-123';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Storage::fake('blog');
        $this->environmentDirectory = storage_path('framework/testing/blog-'.Str::uuid());
        File::ensureDirectoryExists($this->environmentDirectory);
        $this->app->useEnvironmentPath($this->environmentDirectory)->loadEnvironmentFrom('.env');
        File::put($this->environmentDirectory.'/.env', "KEEP=value\nBLOG_INITIAL_PASSWORD=\"{$this->initialPassword}\"\nAFTER=preserved\n");
    }

    protected function tearDown(): void
    {
        if (isset($this->environmentDirectory)) {
            File::deleteDirectory($this->environmentDirectory);
        }
        parent::tearDown();
    }

    private function owner(): User
    {
        return User::factory()->create(['email' => config('blog.owner_email')]);
    }

    private function image(string $name = 'photo.png'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAADElEQVQImWNgYGAAAAAEAAGjChXjAAAAAElFTkSuQmCC'
        ));
    }

    private function payload(string $status = 'draft'): array
    {
        $translations = [];
        foreach (config('blog.locales') as $locale) {
            $translations[$locale] = [
                'title' => 'Title '.$locale,
                'content' => "Content {$locale}\nSecond paragraph.",
                'seo_title' => 'SEO '.$locale,
                'seo_description' => 'Description '.$locale,
                'seo_keywords' => 'Laravel, PHP',
            ];
        }

        return ['link' => 'test-post', 'status' => $status, 'translations' => $translations];
    }

    private function postRecord(bool $published = false): Blog
    {
        $owner = User::where('email', config('blog.owner_email'))->first() ?? $this->owner();
        $data = $this->payload();

        return Blog::create([
            'title' => 'Title es', 'content' => 'Content es', 'link' => 'post-'.Str::lower(Str::random(10)),
            'author_id' => $owner->id, 'translations' => $data['translations'],
            'is_published' => $published, 'published_at' => $published ? now()->subMinute() : null,
        ]);
    }

    public function test_first_valid_login_hashes_password_and_removes_only_the_environment_secret(): void
    {
        $this->post('/login', ['email' => config('blog.owner_email'), 'password' => $this->initialPassword])
            ->assertRedirect(route('admin.dashboard', ['lang' => 'es']));
        $user = User::sole();
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($this->initialPassword, $user->password);
        $this->assertTrue(Hash::check($this->initialPassword, $user->password));
        $this->assertSame("KEEP=value\nAFTER=preserved\n", File::get($this->app->environmentFilePath()));
        $this->get('/admin/blog')->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_wrong_or_nonowner_login_cannot_bootstrap_an_account_or_remove_password(): void
    {
        foreach ([
            ['email' => config('blog.owner_email'), 'password' => 'incorrect-password'],
            ['email' => 'someone@example.test', 'password' => $this->initialPassword],
        ] as $credentials) {
            $this->post('/login', $credentials)->assertSessionHasErrors('email');
        }
        $this->assertDatabaseCount('users', 0);
        $this->assertStringContainsString('BLOG_INITIAL_PASSWORD=', File::get($this->app->environmentFilePath()));
    }

    public function test_existing_owner_cannot_reset_password_by_reintroducing_environment_secret(): void
    {
        $owner = $this->owner();
        $oldHash = $owner->password;
        $this->post('/login', ['email' => $owner->email, 'password' => $this->initialPassword])
            ->assertSessionHasErrors('email');
        $this->assertSame($oldHash, $owner->fresh()->password);
        $this->post('/login', ['email' => $owner->email, 'password' => 'password'])->assertRedirect();
        $this->assertStringNotContainsString('BLOG_INITIAL_PASSWORD=', File::get($this->app->environmentFilePath()));
    }

    public function test_secret_removal_handles_multiline_quotes_comments_and_export_without_touching_other_keys(): void
    {
        $path = $this->app->environmentFilePath();
        File::put($path, "KEEP=ok\r\nexport BLOG_INITIAL_PASSWORD=\"line one\nline two\" # initial\r\nAFTER=yes\r\n");
        app(BlogOwnerCredentials::class)->removeInitialPassword();
        $this->assertSame("KEEP=ok\r\nAFTER=yes\r\n", File::get($path));
    }

    public function test_short_or_blank_initial_password_never_creates_an_account(): void
    {
        foreach (['', 'short'] as $password) {
            File::put($this->app->environmentFilePath(), "BLOG_INITIAL_PASSWORD={$password}\n");
            $this->assertNull(app(BlogOwnerCredentials::class)->authenticate(config('blog.owner_email'), $password));
        }
        $this->assertDatabaseCount('users', 0);
    }

    public function test_login_is_throttled_and_no_registration_route_exists(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', ['email' => 'other@example.test', 'password' => 'wrong-password'])->assertStatus(302);
        }
        $this->post('/login', ['email' => 'other@example.test', 'password' => 'wrong-password'])->assertStatus(429);
        $this->get('/register')->assertNotFound();
        $this->post('/register')->assertStatus(405);
    }

    public function test_guest_and_nonowner_cannot_use_any_publishing_endpoint(): void
    {
        $post = $this->postRecord();
        $this->get('/admin/blog')->assertRedirect(route('login', ['lang' => 'es']));
        $other = User::factory()->create();
        $this->actingAs($other);
        foreach (['/admin/blog', '/admin/blog/create', "/admin/blog/{$post->id}/edit", "/admin/blog/{$post->id}/preview"] as $url) {
            $this->get($url)->assertForbidden();
        }
        $this->post('/admin/blog', $this->payload())->assertForbidden();
        $this->put("/admin/blog/{$post->id}", $this->payload())->assertForbidden();
        $this->delete("/admin/blog/{$post->id}", ['confirm_delete' => 1])->assertForbidden();
    }

    public function test_owner_can_render_all_panel_pages_and_logout(): void
    {
        $post = $this->postRecord();
        $this->actingAs($post->author_id ? User::findOrFail($post->author_id) : $this->owner());
        foreach (['/admin/blog', '/admin/blog/create', "/admin/blog/{$post->id}/edit", "/admin/blog/{$post->id}/preview"] as $url) {
            $this->get($url)->assertOk()->assertSee('noindex,nofollow', false);
        }
        $this->post('/logout')->assertRedirect(route('blog'));
        $this->assertGuest();
    }

    public function test_drafts_and_their_images_are_private_and_excluded_from_sitemap(): void
    {
        $post = $this->postRecord();
        Storage::disk('blog')->put('images/test.png', 'private');
        $image = $post->images()->create(['path' => 'images/test.png', 'alt' => ['es' => 'Privada'], 'position' => 0]);
        $this->get('/blog/'.$post->link)->assertNotFound();
        $this->get('/blog/media/'.$image->id)->assertNotFound();
        $this->get('/blog')->assertOk()->assertDontSee($post->localized('title'));
        $this->get('/sitemap.xml')->assertOk()->assertDontSee($post->link);
        $this->actingAs(User::findOrFail($post->author_id))->get('/blog/media/'.$image->id)->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private');
    }

    public function test_published_posts_have_localized_content_seo_schema_canonical_and_logo_fallback(): void
    {
        $post = $this->postRecord(true);
        $this->get('/blog/'.$post->link.'?lang=en')->assertOk()
            ->assertSee('<title>SEO en</title>', false)
            ->assertSee('Content en')
            ->assertSee('content="Description en"', false)
            ->assertSee('type="application/ld+json"', false)
            ->assertSee('"@type": "BlogPosting"', false)
            ->assertSee('"inLanguage": "en"', false)
            ->assertSee('img/LogoPorfolio.jpg', false)
            ->assertSee('data-server-language="en"', false)
            ->assertSee('lang=en', false);
        $this->get('/sitemap.xml')->assertOk()->assertSee($post->link)->assertSee('lang=pt', false);
    }

    public function test_post_text_and_metadata_are_escaped_and_json_cannot_break_out_of_script(): void
    {
        $post = $this->postRecord(true);
        $translations = $post->translations;
        $translations['es']['title'] = '</title><script>alert(1)</script>';
        $translations['es']['content'] = '<img src=x onerror=alert(1)>';
        $translations['es']['seo_title'] = $translations['es']['title'];
        $translations['es']['seo_description'] = '"><script>alert(2)</script>';
        $post->update(['translations' => $translations]);
        $this->get('/blog/'.$post->link)->assertOk()
            ->assertDontSee('<script>alert(', false)
            ->assertDontSee('<img src=x', false)
            ->assertSee('&lt;script&gt;', false)
            ->assertSee('\\u003C/script\\u003E', false);
    }

    public function test_blog_index_has_a_real_social_image_and_reciprocal_language_urls(): void
    {
        $image = getimagesize(public_path(config('blog.social_image')));
        $this->assertSame([1200, 630], [$image[0], $image[1]]);
        $this->assertSame('image/png', $image['mime']);

        foreach (config('blog.locales') as $locale) {
            $url = route('blog', ['lang' => $locale]);
            $response = $this->get($url)->assertOk()
                ->assertSee('<html lang="'.$locale.'">', false)
                ->assertSee('<link rel="canonical" href="'.$url.'">', false)
                ->assertSee('<meta property="og:url" content="'.$url.'">', false)
                ->assertSee('<meta property="og:image" content="'.asset(config('blog.social_image')).'">', false)
                ->assertSee('<meta name="twitter:image" content="'.asset(config('blog.social_image')).'">', false)
                ->assertSee('<meta property="og:image:width" content="1200">', false)
                ->assertSee('<meta property="og:image:height" content="630">', false);

            foreach (config('blog.locales') as $alternate) {
                $response->assertSee('<link rel="alternate" hreflang="'.$alternate.'" href="'.route('blog', ['lang' => $alternate]).'">', false);
            }
            $response->assertSee('<link rel="alternate" hreflang="x-default" href="'.route('blog', ['lang' => 'es']).'">', false);
        }
    }

    public function test_blog_pagination_has_clean_canonical_and_alternate_urls(): void
    {
        $response = $this->get('/blog?lang=en&page=2&utm_source=test')->assertOk();
        foreach (['es', 'en', 'pt', 'x-default'] as $alternate) {
            $locale = $alternate === 'x-default' ? 'es' : $alternate;
            $url = route('blog', ['lang' => $locale, 'page' => 2]);
            $response->assertSee('<link rel="alternate" hreflang="'.$alternate.'" href="'.e($url).'">', false);
        }
        $url = e(route('blog', ['lang' => 'en', 'page' => 2]));
        $response->assertSee('<link rel="canonical" href="'.$url.'">', false)
            ->assertSee('<meta property="og:url" content="'.$url.'">', false)
            ->assertSee('<meta name="twitter:url" content="'.$url.'">', false);
        $this->get('/blog?lang=en&page=1')->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('blog', ['lang' => 'en']).'">', false);
    }

    public function test_public_blog_language_does_not_depend_on_a_previous_session(): void
    {
        $post = $this->postRecord(true);
        foreach (['/blog', '/blog/'.$post->link] as $path) {
            $this->withSession(['blog.locale' => 'en'])->get($path)->assertOk()
                ->assertSee('<html lang="es">', false);
            $this->get($path.'?lang=pt')->assertOk()->assertSee('<html lang="pt">', false);
            $this->get($path.'?lang=invalid')->assertOk()->assertSee('<html lang="es">', false);
        }
    }

    public function test_post_social_metadata_and_json_ld_use_its_own_image_and_localized_fields(): void
    {
        $post = $this->postRecord(true);
        $image = $post->images()->create(['path' => 'images/cover.png', 'alt' => ['es' => 'Portada'], 'position' => 0]);
        $cover = route('blog.image', $image);
        foreach (config('blog.locales') as $locale) {
            $canonical = route('blog.show', ['blog' => $post->link, 'lang' => $locale]);
            $response = $this->get($canonical)->assertOk()
                ->assertSee('<link rel="canonical" href="'.e($canonical).'">', false)
                ->assertSee('<meta property="og:image" content="'.$cover.'">', false)
                ->assertSee('<meta name="twitter:image" content="'.$cover.'">', false)
                ->assertSee('<link rel="alternate" hreflang="x-default" href="'.e(route('blog.show', ['blog' => $post->link, 'lang' => 'es'])).'">', false);
            foreach (config('blog.locales') as $alternate) {
                $response->assertSee('<link rel="alternate" hreflang="'.$alternate.'" href="'.e(route('blog.show', ['blog' => $post->link, 'lang' => $alternate])).'">', false);
            }
            preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $response->getContent(), $matches);
            $schema = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame('BlogPosting', $schema['@type']);
            $this->assertSame('Title '.$locale, $schema['headline']);
            $this->assertSame('Description '.$locale, $schema['description']);
            $this->assertSame($locale, $schema['inLanguage']);
            $this->assertSame($canonical, $schema['url']);
            $this->assertSame([$cover], $schema['image']);
            $this->assertSame(config('seo.profile.name'), $schema['author']['name']);
            $this->assertSame($post->published_at->toIso8601String(), $schema['datePublished']);
            $this->assertSame($post->updated_at->toIso8601String(), $schema['dateModified']);
        }
    }

    public function test_slug_migration_preserves_content_and_old_url_redirects_permanently(): void
    {
        $post = $this->postRecord(true);
        $post->update(['link' => 'porfolio']);
        $migration = require database_path('migrations/2026_10_19_160000_correct_portfolio_blog_slug.php');
        $migration->up();
        $this->assertSame('portfolio', $post->fresh()->link);
        $this->assertSame($post->content, $post->fresh()->content);
        $this->assertSame($post->translations, $post->fresh()->translations);
        $this->get('/blog/porfolio?lang=en&utm_source=old')
            ->assertStatus(301)
            ->assertRedirect(route('blog.show', ['blog' => 'portfolio', 'lang' => 'en', 'utm_source' => 'old']));
        $this->get('/blog/portfolio?lang=en')->assertOk()->assertSee('Content en');
        $this->get('/sitemap.xml')->assertOk()->assertSee('/blog/portfolio', false)->assertDontSee('/blog/porfolio', false);
        $migration->up();
        $migration->down();
        $this->assertSame('portfolio', $post->fresh()->link);
    }

    public function test_slug_migration_reports_collisions_without_overwriting_either_post(): void
    {
        $old = $this->postRecord(true);
        $old->update(['link' => 'porfolio']);
        $new = $this->postRecord(true);
        $new->update(['link' => 'portfolio']);
        $migration = require database_path('migrations/2026_10_19_160000_correct_portfolio_blog_slug.php');

        try {
            $migration->up();
            $this->fail('Expected a slug collision to be reported.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString('both slugs already exist', $exception->getMessage());
        }
        $this->assertSame('porfolio', $old->fresh()->link);
        $this->assertSame('portfolio', $new->fresh()->link);
    }

    public function test_legacy_redirect_does_not_expose_drafts_and_the_old_slug_is_reserved(): void
    {
        $post = $this->postRecord();
        $post->update(['link' => 'portfolio']);
        $this->get('/blog/porfolio')->assertNotFound();
        $post->update(['is_published' => true, 'published_at' => now()->addDay()]);
        $this->get('/blog/porfolio')->assertNotFound();
        $data = $this->payload();
        $data['link'] = 'porfolio';
        $this->actingAs(User::findOrFail($post->author_id))->post('/admin/blog', $data)
            ->assertSessionHasErrors('link');
    }

    public function test_old_url_keeps_serving_the_post_until_the_slug_migration_runs(): void
    {
        $post = $this->postRecord(true);
        $post->update(['link' => 'porfolio']);
        $this->get('/blog/porfolio?lang=en')->assertOk()->assertSee('Content en');
    }

    public function test_sitemap_lists_every_blog_index_language_and_author_links_are_nofollow(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();
        foreach (config('blog.locales') as $locale) {
            $response->assertSee('<loc>'.route('blog', ['lang' => $locale]).'</loc>', false);
            $this->get('/blog?lang='.$locale)->assertOk()
                ->assertSee('rel="nofollow" href="'.route('login', ['lang' => $locale]).'"', false);
        }
    }

    public function test_owner_can_save_a_draft_without_images_and_empty_upload_row(): void
    {
        $data = $this->payload();
        $data['translations']['en']['title'] = null;
        $data['translations']['en']['content'] = null;
        $data['uploads'] = [['alt' => ['es' => null, 'en' => null, 'pt' => null]]];
        $this->actingAs($this->owner())->post('/admin/blog', $data)->assertSessionHasNoErrors()->assertRedirect();
        $post = Blog::sole();
        $this->assertFalse($post->is_published);
        $this->assertNull($post->published_at);
        $this->assertCount(0, $post->images);
    }

    public function test_publication_requires_all_language_titles_and_content(): void
    {
        $data = $this->payload('published');
        $data['translations']['pt']['content'] = '';
        $this->actingAs($this->owner())->post('/admin/blog', $data)
            ->assertSessionHasErrors('translations.pt.content');
        $this->assertDatabaseCount('blogs', 0);
    }

    public function test_uploads_require_alts_in_all_languages_and_reject_nonimages(): void
    {
        $data = $this->payload();
        $data['uploads'] = [['file' => $this->image(), 'alt' => ['es' => 'Foto']]];
        $this->actingAs($this->owner())->post('/admin/blog', $data)
            ->assertSessionHasErrors(['uploads.0.alt.en', 'uploads.0.alt.pt']);
        $data['uploads'] = [['file' => UploadedFile::fake()->create('document.pdf', 20, 'application/pdf'), 'alt' => ['es' => 'a', 'en' => 'a', 'pt' => 'a']]];
        $this->post('/admin/blog', $data)->assertSessionHasErrors('uploads.0.file');
        $this->assertDatabaseCount('blogs', 0);
    }

    public function test_one_and_multiple_images_are_stored_privately_and_public_carousel_uses_localized_alts(): void
    {
        $owner = $this->owner();
        $data = $this->payload('published');
        $data['uploads'] = [
            ['file' => $this->image('first.png'), 'alt' => ['es' => 'Primera', 'en' => 'First', 'pt' => 'Primeira']],
        ];
        $this->actingAs($owner)->post('/admin/blog', $data)->assertSessionHasNoErrors();
        $post = Blog::sole();
        $first = $post->images->sole();
        Storage::disk('blog')->assertExists($first->path);
        $this->get('/blog/'.$post->link)->assertOk()->assertDontSee('data-gallery-next', false);
        $data['existing_images'] = [$first->id => ['alt' => $first->alt]];
        $data['uploads'][0]['file'] = $this->image('second.png');
        $this->put("/admin/blog/{$post->id}", $data)->assertSessionHasNoErrors();
        $this->assertCount(2, $post->fresh()->images);
        $this->get('/blog/'.$post->link.'?lang=en')->assertOk()
            ->assertSee('data-gallery-next', false)->assertSee('alt="First"', false);
        $this->get('/blog/media/'.$first->id)->assertOk()->assertHeader('X-Content-Type-Options', 'nosniff');
        $data['status'] = 'draft';
        unset($data['uploads']);
        $data['existing_images'] = $post->fresh()->images->mapWithKeys(fn ($image) => [$image->id => ['alt' => $image->alt]])->all();
        $this->put("/admin/blog/{$post->id}", $data)->assertSessionHasNoErrors();
        auth()->logout();
        $this->get('/blog/media/'.$first->id)->assertNotFound();
    }

    public function test_image_limits_and_size_are_enforced(): void
    {
        $data = $this->payload();
        $data['uploads'] = array_map(fn () => [
            'file' => $this->image(),
            'alt' => ['es' => 'a', 'en' => 'a', 'pt' => 'a'],
        ], range(1, 11));
        $this->actingAs($this->owner())->post('/admin/blog', $data)->assertSessionHasErrors('uploads');
        $data['uploads'] = [[
            'file' => $this->image('big.png')->size(5121),
            'alt' => ['es' => 'a', 'en' => 'a', 'pt' => 'a'],
        ]];
        $this->post('/admin/blog', $data)->assertSessionHasErrors('uploads.0.file');
        $this->assertDatabaseCount('blogs', 0);
    }

    public function test_edit_and_delete_remove_files_and_cannot_remove_another_posts_image(): void
    {
        $post = $this->postRecord();
        $other = $this->postRecord();
        foreach ([$post, $other] as $record) {
            $path = 'images/'.$record->id.'.jpg';
            Storage::disk('blog')->put($path, 'image');
            $record->images()->create(['path' => $path, 'alt' => ['es' => 'a', 'en' => 'a', 'pt' => 'a'], 'position' => 0]);
        }
        $data = $this->payload();
        $data['remove_images'] = [$other->images->sole()->id];
        $data['existing_images'] = [$post->images->sole()->id => ['alt' => $post->images->sole()->alt]];
        $this->actingAs(User::findOrFail($post->author_id))->put("/admin/blog/{$post->id}", $data)
            ->assertSessionHasErrors('remove_images.0');
        $this->delete("/admin/blog/{$post->id}")->assertSessionHasErrors('confirm_delete');
        $this->delete("/admin/blog/{$post->id}", ['confirm_delete' => 1])->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('blogs', ['id' => $post->id]);
        Storage::disk('blog')->assertMissing('images/'.$post->id.'.jpg');
        Storage::disk('blog')->assertExists('images/'.$other->id.'.jpg');
    }

    public function test_reset_command_uses_hidden_confirmation_and_removes_initial_secret(): void
    {
        $this->artisan('blog:reset-password')
            ->expectsQuestion('New owner password (12-72 characters)', 'replacement-password-123')
            ->expectsQuestion('Confirm password', 'replacement-password-123')
            ->assertSuccessful();
        $this->assertTrue(Hash::check('replacement-password-123', User::sole()->password));
        $this->assertStringNotContainsString('BLOG_INITIAL_PASSWORD=', File::get($this->app->environmentFilePath()));
    }

    public function test_save_rechecks_the_final_image_limit_after_request_validation(): void
    {
        $post = $this->postRecord();
        for ($position = 0; $position < 10; $position++) {
            $post->images()->create([
                'path' => "images/{$position}.png",
                'alt' => ['es' => 'a', 'en' => 'a', 'pt' => 'a'],
                'position' => $position,
            ]);
        }
        $request = Mockery::mock(SaveBlogRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($this->payload());
        $request->shouldReceive('file')->with('uploads', [])->andReturn([['file' => $this->image()]]);
        try {
            app(AdminBlogController::class)->update($request, $post);
            $this->fail('The transactional image count must reject this upload.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('uploads', $exception->errors());
        }
        $this->assertSame(10, $post->images()->count());
        $this->assertSame([], Storage::disk('blog')->allFiles());
    }
}
