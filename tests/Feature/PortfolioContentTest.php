<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Storage::fake('blog');
    }

    private function owner(): User
    {
        return User::factory()->create(['email' => config('blog.owner_email')]);
    }

    private function payload(string $slug = 'test-project', string $status = 'published'): array
    {
        $translations = [];
        foreach (config('blog.locales') as $locale) {
            $translations[$locale] = [
                'title' => "Project $locale", 'summary' => "Summary $locale",
                'content' => "Full content $locale\n\nSecond paragraph.", 'image_alt' => "Screenshot $locale",
                'category' => "Category $locale", 'period' => '2026',
                'seo_title' => "SEO project $locale", 'seo_description' => "SEO description $locale",
            ];
        }

        return [
            'slug' => $slug, 'translations' => $translations, 'status' => $status,
            'position' => 0, 'is_featured' => 1, 'technologies' => "Laravel\nPHP",
            'repository_url' => 'https://github.com/example/project', 'website_url' => 'https://example.test',
        ];
    }

    private function project(string $slug = 'test-project', bool $published = true): Project
    {
        $data = $this->payload($slug);
        unset($data['status']);

        return Project::create($data + ['is_published' => $published, 'published_at' => $published ? now()->subMinute() : null]);
    }

    private function image(): UploadedFile
    {
        return UploadedFile::fake()->createWithContent('capture.png', base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a6XcAAAAASUVORK5CYII='
        ));
    }

    public function test_migration_preserves_nine_skills_and_seven_projects_in_three_languages(): void
    {
        $this->assertDatabaseCount('skills', 9);
        $this->assertDatabaseCount('projects', 7);
        foreach (Project::all() as $project) {
            foreach (config('blog.locales') as $locale) {
                $this->assertNotEmpty($project->localized('title', $locale));
                $this->assertNotEmpty($project->localized('content', $locale));
            }
        }
        $this->assertCount(11, Project::where('slug', 'gestor-contenido')->sole()->media);
        $this->assertCount(10, Project::where('slug', 'gestor-fichaje')->sole()->media);
        $this->get('/projects')->assertSee('workFlow-BusquedaEmpleo.json')->assertSee('https://apipokemon.rogerlab.es/pokemon/raichu');
    }

    public function test_private_content_management_requires_owner_and_disallows_public_preview(): void
    {
        $draft = $this->project('private-project', false);
        foreach (['/admin/projects', '/admin/skills', "/admin/projects/{$draft->id}/preview"] as $url) {
            $this->get($url)->assertRedirect(route('login', ['lang' => 'es']));
        }
        $this->actingAs(User::factory()->create());
        $this->get('/admin/projects')->assertForbidden();
        $this->post('/admin/projects', $this->payload())->assertForbidden();
        $this->post('/admin/skills', [])->assertForbidden();
        $this->get('/projects/private-project')->assertNotFound();
    }

    public function test_owner_can_manage_and_order_skills_without_editing_templates(): void
    {
        $this->actingAs($this->owner());
        $data = ['position' => 0, 'status' => 'published', 'translations' => [
            'es' => ['label' => 'Nueva habilidad'], 'en' => ['label' => 'New skill'], 'pt' => ['label' => 'Nova competência'],
        ]];
        $this->post('/admin/skills', $data)->assertSessionHasNoErrors()->assertRedirect();
        $skill = Skill::orderByDesc('id')->first();
        $this->get('/home?lang=en')->assertSee('New skill')->assertDontSee('Nueva habilidad');
        $this->get("/admin/skills/{$skill->id}/edit")->assertOk()->assertSee('New skill');
        $this->put("/admin/skills/{$skill->id}", array_replace($data, ['status' => 'draft']))->assertSessionHasNoErrors();
        $this->get('/home')->assertDontSee('Nueva habilidad');
        $this->delete("/admin/skills/{$skill->id}")->assertSessionHasErrors('confirm_delete');
        $this->delete("/admin/skills/{$skill->id}", ['confirm_delete' => 1])->assertRedirect();
        $this->assertModelMissing($skill);
    }

    public function test_skills_require_all_translations_to_publish_but_not_to_save_a_draft(): void
    {
        $this->actingAs($this->owner());
        $data = ['position' => 1, 'status' => 'published', 'translations' => [
            'es' => ['label' => 'Skill'], 'en' => ['label' => ''], 'pt' => ['label' => ''],
        ]];
        $this->post('/admin/skills', $data)->assertSessionHasErrors(['translations.en.label', 'translations.pt.label']);
        $this->post('/admin/skills', array_replace($data, ['status' => 'draft']))->assertSessionHasNoErrors();
    }

    public function test_owner_can_create_edit_preview_publish_unpublish_and_delete_projects(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload('new-project', 'draft');
        $this->get('/admin/projects/create')->assertOk()->assertSee('name="translations[en][seo_title]"', false);
        $this->post('/admin/projects', $data)->assertSessionHasNoErrors()->assertRedirect();
        $project = Project::where('slug', 'new-project')->sole();
        $this->get("/admin/projects/{$project->id}/edit")->assertOk();
        $this->get("/admin/projects/{$project->id}/preview?lang=en")->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')->assertSee('noindex,nofollow');
        $this->get('/projects/new-project')->assertNotFound();
        $data['status'] = 'published';
        $this->put("/admin/projects/{$project->id}", $data)->assertSessionHasNoErrors();
        $this->get('/projects/new-project?lang=pt')->assertOk()->assertSee('Project pt')->assertSee('Full content pt');
        $data['status'] = 'draft';
        $this->put("/admin/projects/{$project->id}", $data)->assertSessionHasNoErrors();
        $this->get('/projects/new-project')->assertNotFound();
        $this->delete("/admin/projects/{$project->id}", ['confirm_delete' => 1])->assertRedirect();
        $this->assertModelMissing($project);
    }

    public function test_publishing_requires_translations_and_rejects_invalid_urls_slugs_and_media(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload();
        $data['translations']['en']['summary'] = '';
        $data['translations']['pt']['content'] = '';
        $data['website_url'] = 'javascript:alert(1)';
        $data['repository_url'] = 'ftp://example.test/file';
        $data['slug'] = '../invalid';
        $data['uploads'] = [UploadedFile::fake()->create('unsafe.svg', 1, 'image/svg+xml')];
        $this->post('/admin/projects', $data)->assertSessionHasErrors([
            'translations.en.summary', 'translations.pt.content', 'website_url', 'repository_url', 'slug', 'uploads.0',
        ]);
        $this->assertDatabaseCount('projects', 7);
        $duplicate = $this->payload('portfolio');
        $this->post('/admin/projects', $duplicate)->assertSessionHasErrors('slug');
    }

    public function test_a_project_draft_only_needs_the_spanish_title(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload('incomplete-draft', 'draft');
        $data['translations'] = ['es' => ['title' => 'Draft'], 'en' => [], 'pt' => []];
        $this->post('/admin/projects', $data)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', ['slug' => 'incomplete-draft', 'is_published' => false]);
        $data['status'] = 'published';
        $project = Project::where('slug', 'incomplete-draft')->sole();
        $this->put("/admin/projects/{$project->id}", $data)->assertSessionHasErrors([
            'translations.es.summary', 'translations.en.title', 'translations.pt.image_alt',
        ]);
    }

    public function test_uploads_are_private_for_drafts_and_can_be_published_removed_and_deleted(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload('image-project', 'draft');
        $this->post('/admin/projects', $data + ['uploads' => [$this->image()]])->assertSessionHasNoErrors();
        $project = Project::where('slug', 'image-project')->sole();
        $path = $project->media[0]['path'];
        $url = route('projects.image', ['project' => $project, 'index' => 0]);
        Storage::disk('blog')->assertExists($path);
        $this->assertSame([0], $project->galleryIndexes());
        $this->get($url)->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        auth()->logout();
        $this->get($url)->assertNotFound();
        $this->actingAs(User::factory()->create())->get($url)->assertNotFound();
        $owner = User::where('email', config('blog.owner_email'))->sole();
        $this->actingAs($owner);
        $data['status'] = 'published';
        $this->put("/admin/projects/{$project->id}", $data)->assertSessionHasNoErrors();
        auth()->logout();
        $this->get($url)->assertOk()->assertHeader('Cache-Control', 'no-store, private');
        $this->actingAs($owner);
        $this->put("/admin/projects/{$project->id}", $data + ['remove_media' => [0]])->assertSessionHasNoErrors();
        Storage::disk('blog')->assertMissing($path);
        $this->get($url)->assertNotFound();
    }

    public function test_cover_selection_and_custom_image_alts_are_preserved(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload('cover-project');
        $this->post('/admin/projects', $data + ['uploads' => [$this->image(), $this->image()]])->assertSessionHasNoErrors();
        $project = Project::where('slug', 'cover-project')->sole();
        $this->put("/admin/projects/{$project->id}", $data + [
            'cover_index' => 1, 'media_alt' => [1 => ['es' => 'Detalle real', 'en' => 'Real detail', 'pt' => 'Detalhe real']],
        ])->assertSessionHasNoErrors();
        $this->assertSame(1, $project->fresh()->cover_index);
        $this->get('/projects/cover-project?lang=en')->assertSee('alt="Real detail"', false);
        $this->put("/admin/projects/{$project->id}", $data + ['cover_index' => 1, 'remove_media' => [1]])->assertSessionHasErrors('cover_index');
        $this->put("/admin/projects/{$project->id}", $data + ['cover_index' => 'new'])->assertSessionHasErrors('cover_index');
        $this->put("/admin/projects/{$project->id}", $data + ['cover_index' => 'new', 'uploads' => [$this->image()]])->assertSessionHasNoErrors();
        $this->assertSame(2, $project->fresh()->cover_index);
    }

    public function test_twenty_image_limit_and_foreign_media_indexes_are_enforced(): void
    {
        $project = $this->project();
        $project->media = array_fill(0, 20, ['disk' => 'asset', 'path' => 'img/LogoPorfolio.jpg']);
        $project->save();
        $this->actingAs($this->owner());
        $this->put("/admin/projects/{$project->id}", $this->payload() + ['uploads' => [$this->image()]])->assertSessionHasErrors('uploads');
        $this->put("/admin/projects/{$project->id}", $this->payload() + ['remove_media' => [999]])->assertSessionHasErrors('remove_media.0');
        $this->put("/admin/projects/{$project->id}", $this->payload() + ['media_alt' => [999 => ['es' => 'Invalid']]])->assertSessionHasErrors('media_alt');
    }

    public function test_discovery_interleaves_only_published_featured_projects_and_articles_with_a_bound(): void
    {
        Project::query()->update(['is_featured' => false]);
        $project = $this->project('featured-project');
        $this->project('draft-project', false);
        $future = $this->project('future-project');
        $future->update(['published_at' => now()->addDay()]);
        $owner = $this->owner();
        for ($index = 0; $index < 6; $index++) {
            Blog::create([
                'title' => "Article $index", 'content' => "Body $index", 'link' => "article-$index",
                'author_id' => $owner->id, 'is_published' => true, 'published_at' => now()->subMinutes($index + 1),
            ]);
        }
        Blog::create(['title' => 'Private article', 'content' => 'Hidden', 'link' => 'private-article', 'author_id' => $owner->id]);
        $response = $this->get('/home')->assertOk();
        $response->assertSeeInOrder(['Project es', 'Article 0', 'Article 1', 'Article 2', 'Article 3']);
        $response->assertDontSee('Article 4')->assertDontSee('Private article')->assertDontSee('future-project');
        $this->assertSame(5, substr_count($response->getContent(), 'class="discovery__slide"'));
        $project->update(['is_featured' => false]);
        $this->get('/home')->assertDontSee('featured-project');
    }

    public function test_empty_or_single_item_discovery_does_not_require_javascript(): void
    {
        Project::query()->update(['is_featured' => false]);
        Blog::query()->delete();
        $this->get('/home')->assertOk()->assertDontSee('data-discovery>', false);
        $this->project();
        $this->get('/home')->assertOk()->assertSee('Project es')->assertSee('tabindex="0"', false);
    }

    public function test_discovery_has_indicators_and_icon_playback_with_localized_accessible_names(): void
    {
        foreach (['es' => 'Pausar carrusel', 'en' => 'Pause carousel', 'pt' => 'Pausar carrossel'] as $locale => $label) {
            $this->get("/home?lang=$locale")->assertOk()
                ->assertSee('aria-label="'.$label.'"', false)
                ->assertSee('data-discovery-playback hidden', false)
                ->assertSee('data-discovery-navigation hidden', false)
                ->assertSee('data-discovery-index="0"', false)
                ->assertSee('aria-current="true"', false)
                ->assertSee('class="heroHeadline"', false)
                ->assertDontSee('discovery-title')
                ->assertDontSee('discovery__header')
                ->assertDontSee('discovery__footer')
                ->assertDontSee('data-discovery-step')
                ->assertDontSee('data-discovery-status');
        }
    }

    public function test_project_seo_and_sitemap_are_localized_and_exclude_drafts_and_future_content(): void
    {
        $project = $this->project();
        $this->project('secret-draft', false);
        $this->project('future-project')->update(['published_at' => now()->addDay()]);
        $response = $this->get('/projects/test-project?lang=en')->assertOk();
        $response->assertSee('<html lang="en">', false)
            ->assertSee('<title>SEO project en</title>', false)
            ->assertSee('content="SEO description en"', false)
            ->assertSee('rel="canonical" href="'.route('projects.show', ['project' => 'test-project', 'lang' => 'en']).'"', false)
            ->assertSee('hreflang="pt"', false)
            ->assertSee('property="og:image"', false)->assertSee('name="twitter:image"', false);
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $response->getContent(), $matches);
        $schema = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('CreativeWork', $schema['@type']);
        $this->assertSame('Project en', $schema['name']);
        $this->assertSame('en', $schema['inLanguage']);
        $this->assertSame(['Laravel', 'PHP'], $schema['keywords']);
        $this->get('/sitemap.xml')->assertSee('projects/test-project?lang=en')->assertDontSee('secret-draft')->assertDontSee('future-project');
        $this->get('/projects/future-project')->assertNotFound();
        $this->get('/projects?lang=en&page=2')->assertSee(
            'rel="canonical" href="'.e(route('projects', ['page' => 2, 'lang' => 'en'])).'"', false
        );
        $this->get('/projects/test-project?lang=bad')->assertOk()->assertSee('<html lang="es">', false);
    }

    public function test_public_text_is_escaped_and_partial_responses_include_correct_metadata(): void
    {
        $project = $this->project();
        $translations = $project->translations;
        $translations['es']['content'] = '<script>alert("unsafe")</script>';
        $project->update(['translations' => $translations]);
        $this->get('/projects/test-project', ['X-Partial-Navigation' => 'true'])
            ->assertOk()->assertSee('&lt;script&gt;', false)->assertDontSee('<script>alert', false)
            ->assertSee('data-server-language="es"', false)->assertSee('"@type": "CreativeWork"', false);
        $this->get('/projects', ['X-Partial-Navigation' => 'true'])->assertSee('"@type": "CollectionPage"', false);
    }
}
