<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\SiteProfile;
use App\Models\User;
use App\Services\UploadImageOptimizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
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

    private function payload(): array
    {
        $profile = SiteProfile::current();
        $data = $profile->only([
            'translations', 'research_enabled', 'photo_enabled', 'research_route',
        ]);
        foreach (range(1, 3) as $area) {
            $data["offer{$area}_project_ids"] = $profile->projectsForArea($area)->get()->modelKeys();
        }

        return $data;
    }

    private function image(): UploadedFile
    {
        return UploadedFile::fake()->image('portrait.png', 320, 400);
    }

    public function test_profile_and_dashboard_require_owner_for_reads_writes_and_deletions(): void
    {
        foreach (['/admin', '/admin/profile'] as $url) {
            $this->get($url)->assertRedirect(route('login', ['lang' => 'es']));
        }
        $this->put('/admin/profile', $this->payload())->assertRedirect();
        $this->delete('/admin/profile/photo', ['confirm_delete' => 1])->assertRedirect();
        $this->actingAs(User::factory()->create());
        $this->get('/admin')->assertForbidden();
        $this->get('/admin/profile')->assertForbidden();
        $this->put('/admin/profile', $this->payload())->assertForbidden();
        $this->delete('/admin/profile/photo', ['confirm_delete' => 1])->assertForbidden();
        $this->delete('/admin/profile/exploration', ['confirm_delete' => 1])->assertForbidden();
    }

    public function test_owner_can_edit_localized_profile_and_public_metadata_without_template_changes(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload();
        foreach (config('blog.locales') as $locale) {
            foreach (['role', 'bio1', 'bio2', 'offer1_body', 'research_body', 'seo_title', 'seo_description', 'about_seo_title'] as $field) {
                $data['translations'][$locale][$field] = "Updated $field $locale";
            }
        }
        $data['research_route'] = 'projects';
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseCount('site_profiles', 1);
        foreach (config('blog.locales') as $locale) {
            $home = $this->get('/home?lang='.$locale)->assertOk();
            foreach (['role', 'bio1', 'bio2', 'offer1_body', 'research_body'] as $field) {
                $home->assertSee("Updated $field $locale");
            }
            $home->assertSee('<title>Updated seo_title '.$locale.'</title>', false)
                ->assertSee('name="description" content="Updated seo_description '.$locale.'"', false)
                ->assertSee('property="og:title" content="Updated seo_title '.$locale.'"', false)
                ->assertDontSee('data-i18n="home.intro.body.part1"', false);
            $this->get('/about?lang='.$locale)->assertOk()->assertSee('Updated about_seo_title '.$locale)
                ->assertSee('Updated research_body '.$locale);
        }
    }

    public function test_home_explains_three_contributions_with_evidence_instead_of_a_skill_pile(): void
    {
        $response = $this->get('/home?lang=es')->assertOk()
            ->assertSee('Qué puedo aportar')->assertSee('Desarrollo web a medida')
            ->assertSee('Mantenimiento y SEO técnico')->assertSee('Automatización con n8n')
            ->assertSee('Abierto a empleo y proyectos freelance')
            ->assertSee('Soy titulado en Desarrollo de Aplicaciones Web')
            ->assertDontSee('class="heroStack"', false)
            ->assertDontSee('WordPress');
        $this->assertSame(3, substr_count($response->getContent(), 'class="contribution"'));
        $project = SiteProfile::current()->projectsForArea(3)->firstOrFail();
        $url = route('projects.show', ['project' => $project->slug, 'lang' => 'es']);
        $response->assertSee($url, false);
        $project->update(['is_featured' => false, 'is_published' => false]);
        $this->get('/home')->assertDontSee($url, false);
        $this->get('/about?lang=en')->assertSee('Everyday tools')->assertSee('PHP / Laravel');
    }

    public function test_seo_is_localized_server_rendered_and_has_matching_structured_data(): void
    {
        foreach (config('blog.locales') as $locale) {
            $profile = SiteProfile::current();
            foreach (['home', 'about'] as $route) {
                $url = route($route, ['lang' => $locale]);
                $response = $this->get($url)->assertOk()
                    ->assertSee('<html lang="'.$locale.'">', false)
                    ->assertSee('<link rel="canonical" href="'.$url.'">', false);
                foreach (config('blog.locales') as $alternate) {
                    $response->assertSee('hreflang="'.$alternate.'" href="'.route($route, ['lang' => $alternate]).'"', false);
                }
                preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $response->getContent(), $matches);
                $schema = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
                $this->assertSame($profile->text('bio1', $locale), $schema['@graph'][0]['description']);
                $this->assertSame($locale, $schema['@graph'][2]['inLanguage']);
                $this->assertSame($url, $schema['@graph'][2]['url']);
                $this->assertSame($route === 'home' ? 'WebPage' : 'AboutPage', $schema['@graph'][2]['@type']);
                $this->assertCount($route === 'home' ? 6 : 3, $schema['@graph']);
                if ($route === 'home') {
                    $this->assertSame($profile->text('offer1_title', $locale), $schema['@graph'][3]['name']);
                    $this->assertSame('Service', $schema['@graph'][3]['@type']);
                }
            }
        }
        $sitemap = $this->get('/sitemap.xml')->assertOk();
        foreach (config('blog.locales') as $locale) {
            $sitemap->assertSee(route('about', ['lang' => $locale]));
        }
    }

    public function test_evidence_migration_preserves_existing_individual_selections(): void
    {
        $migration = require database_path('migrations/2026_10_23_150000_create_profile_project_evidence.php');
        $migration->down();
        $ids = Project::orderByDesc('id')->limit(2)->pluck('id')->all();
        SiteProfile::whereKey(1)->update([
            'offer1_project_id' => $ids[0], 'offer2_project_id' => null, 'offer3_project_id' => $ids[1],
        ]);
        $migration->up();
        $profile = SiteProfile::current();
        $this->assertSame([$ids[0]], $profile->projectsForArea(1)->get()->modelKeys());
        $this->assertSame([], $profile->projectsForArea(2)->get()->modelKeys());
        $this->assertSame([$ids[1]], $profile->projectsForArea(3)->get()->modelKeys());
    }

    public function test_multiple_projects_can_be_selected_per_area_with_linked_covers_and_text_fallbacks(): void
    {
        $this->actingAs($this->owner());
        $covered = SiteProfile::current()->projectsForArea(1)->firstOrFail();
        $covered->update(['position' => 0]);
        $textOnly = $covered->replicate();
        $translations = $textOnly->translations;
        foreach (config('blog.locales') as $locale) {
            $translations[$locale]['title'] = "Text evidence $locale";
        }
        $textOnly->fill([
            'slug' => 'text-only-evidence', 'translations' => $translations, 'media' => [],
            'is_featured' => false, 'position' => 99,
        ])->save();
        $draft = $textOnly->replicate()->fill(['slug' => 'draft-evidence', 'is_published' => false]);
        $draft->save();
        $future = $textOnly->replicate()->fill(['slug' => 'future-evidence', 'published_at' => now()->addDay()]);
        $future->save();

        $data = $this->payload();
        $data['offer1_project_ids'] = [$textOnly->id, $covered->id, $draft->id, $future->id];
        $data['offer2_project_ids'] = [$textOnly->id];
        $data['offer3_project_ids'] = [];
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors();
        $this->assertCount(4, SiteProfile::current()->projectsForArea(1)->get());
        $this->assertSame([$textOnly->id], SiteProfile::current()->projectsForArea(2)->get()->modelKeys());
        $this->assertSame([], SiteProfile::current()->projectsForArea(3)->get()->modelKeys());
        foreach (config('blog.locales') as $locale) {
            $response = $this->get('/home?lang='.$locale)->assertOk();
            preg_match_all('/<a class="contribution__project".*?<\/a>/s', $response->getContent(), $matches);
            $this->assertCount(3, $matches[0]);
            $this->assertStringContainsString($covered->coverUrl(), $matches[0][0]);
            $this->assertStringContainsString('loading="lazy"', $matches[0][0]);
            $this->assertStringContainsString(route('projects.show', ['project' => $covered->slug, 'lang' => $locale]), $matches[0][0]);
            foreach ([$matches[0][1], $matches[0][2]] as $link) {
                $this->assertStringContainsString("Text evidence $locale", $link);
                $this->assertStringContainsString(route('projects.show', ['project' => $textOnly->slug, 'lang' => $locale]), $link);
                $this->assertStringNotContainsString('<img', $link);
            }
        }
        $this->get('/admin/profile')->assertOk()
            ->assertSee('name="offer1_project_ids[]" value="'.$draft->id.'"', false);

        $draft->update(['is_published' => true]);
        $html = $this->get('/home')->assertOk()->getContent();
        $this->assertSame(4, substr_count($html, 'class="contribution__project"'));
        $textOnly->delete();
        $this->assertDatabaseMissing('profile_project_evidence', ['project_id' => $textOnly->id]);
        $this->assertSame(2, substr_count($this->get('/home')->getContent(), 'class="contribution__project"'));
    }

    public function test_unchecking_every_project_clears_only_that_area_and_can_be_saved_again(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload();
        $original = $data['offer1_project_ids'];
        unset($data['offer1_project_ids']);
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors();
        $profile = SiteProfile::current();
        $this->assertSame([], $profile->projectsForArea(1)->get()->modelKeys());
        foreach ([2, 3] as $area) {
            $this->assertSame($data["offer{$area}_project_ids"], $profile->projectsForArea($area)->get()->modelKeys());
        }
        $data['offer1_project_ids'] = $original;
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors();
        $this->assertSame($original, SiteProfile::current()->projectsForArea(1)->get()->modelKeys());
    }

    public function test_invalid_project_lists_are_rejected_without_changing_selections(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload();
        $original = $data['offer1_project_ids'];
        foreach ([
            ['value' => 'not-an-array', 'error' => 'offer1_project_ids'],
            ['value' => [$original[0], $original[0]], 'error' => 'offer1_project_ids.0'],
            ['value' => [999999], 'error' => 'offer1_project_ids.0'],
            ['value' => ['invalid'], 'error' => 'offer1_project_ids.0'],
        ] as $case) {
            $data['offer1_project_ids'] = $case['value'];
            $this->from('/admin/profile')->put('/admin/profile', $data)->assertSessionHasErrors($case['error']);
            $this->get('/admin/profile')->assertOk();
            $this->assertSame($original, SiteProfile::current()->projectsForArea(1)->get()->modelKeys());
        }
        unset($data['offer1_project_ids']);
        $data['translations']['es']['role'] = '';
        $this->from('/admin/profile')->put('/admin/profile', $data)->assertSessionHasErrors('translations.es.role');
        $html = $this->get('/admin/profile')->assertOk()->getContent();
        preg_match_all('/<input type="checkbox" name="offer1_project_ids\[\]"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0]);
        foreach ($matches[0] as $checkbox) {
            $this->assertStringNotContainsString('checked', $checkbox);
        }
    }

    public function test_validations_preserve_profile_and_reject_invalid_destinations_uploads_and_translations(): void
    {
        $this->actingAs($this->owner());
        $before = SiteProfile::current()->translations;
        $data = $this->payload();
        $data['translations']['en']['bio1'] = '';
        $data['translations']['pt']['seo_description'] = str_repeat('x', 171);
        $data['translations']['fr'] = ['bio1' => 'Unexpected locale'];
        $data['research_route'] = 'javascript:alert(1)';
        $data['offer1_project_ids'] = [99999];
        $data['photo'] = UploadedFile::fake()->create('portrait.svg', 1, 'image/svg+xml');
        $this->put('/admin/profile', $data)->assertSessionHasErrors([
            'translations.en.bio1', 'translations.pt.seo_description', 'translations',
            'research_route', 'offer1_project_ids.0', 'photo',
        ]);
        $this->assertSame($before, SiteProfile::current()->translations);
        $this->assertSame([], Storage::disk('blog')->allFiles());
        $data = $this->payload();
        $data['translations']['es']['research_body'] = '';
        $this->put('/admin/profile', $data)->assertSessionHasErrors('translations.es.research_body');
    }

    public function test_research_can_be_hidden_deleted_and_recreated_without_changing_other_content(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload();
        $data['research_enabled'] = false;
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors();
        $this->get('/home')->assertDontSee('Ahora estoy explorando');
        $this->get('/about')->assertDontSee('Pagos con Stripe');
        $this->delete('/admin/profile/exploration')->assertSessionHasErrors('confirm_delete');
        $this->delete('/admin/profile/exploration', ['confirm_delete' => 1])->assertSessionHasNoErrors();
        $this->assertSame('', SiteProfile::current()->text('research_body'));
        $data['translations']['es']['research_body'] = 'Nueva investigación';
        $data['research_enabled'] = true;
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors();
        $this->get('/home')->assertSee('Nueva investigación');
        $this->get('/about')->assertSee('Nueva investigación');
    }

    public function test_photo_can_be_uploaded_replaced_hidden_deleted_and_recreated(): void
    {
        $this->actingAs($this->owner());
        $this->get('/profile/photo')->assertNotFound();
        $this->put('/admin/profile', $this->payload() + ['photo' => $this->image()])->assertSessionHasNoErrors();
        $profile = SiteProfile::current();
        $old = $profile->photo_path;
        Storage::disk('blog')->assertExists($old);
        $this->assertStringEndsWith('.webp', $old);
        $this->get('/profile/photo')->assertOk()->assertHeader('content-type', 'image/webp')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->get('/home')->assertSee($profile->photoUrl(), false);
        $this->put('/admin/profile', $this->payload() + ['photo' => $this->image()])->assertSessionHasNoErrors();
        Storage::disk('blog')->assertMissing($old);
        $path = SiteProfile::current()->photo_path;
        $data = $this->payload();
        $data['photo_enabled'] = false;
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors();
        $this->get('/profile/photo')->assertNotFound();
        Storage::disk('blog')->assertExists($path);
        $this->get('/home')->assertDontSee('class="heroFoto"', false);
        $this->delete('/admin/profile/photo')->assertSessionHasErrors('confirm_delete');
        $this->delete('/admin/profile/photo', ['confirm_delete' => 1])->assertSessionHasNoErrors();
        Storage::disk('blog')->assertMissing($path);
        $this->assertNull(SiteProfile::current()->photoUrl());
        $data['photo_enabled'] = true;
        $this->put('/admin/profile', $data)->assertSessionHasErrors('photo');
        $this->put('/admin/profile', $data + ['photo' => $this->image()])->assertSessionHasNoErrors();
        $this->get('/profile/photo')->assertOk();
    }

    public function test_image_processing_failure_does_not_replace_existing_photo_or_profile(): void
    {
        $this->actingAs($this->owner());
        $this->mock(UploadImageOptimizer::class)->shouldReceive('store')->once()->andThrow(
            \Illuminate\Validation\ValidationException::withMessages(['photo' => 'Optimisation unavailable'])
        );
        $data = $this->payload();
        $data['translations']['es']['bio1'] = 'Must not persist';
        $this->put('/admin/profile', $data + ['photo' => $this->image()])->assertSessionHasErrors('photo');
        $this->assertNotSame('Must not persist', SiteProfile::current()->text('bio1'));
        $this->assertNull(SiteProfile::current()->photo_path);
    }

    public function test_plain_text_is_escaped_in_html_and_safely_encoded_in_json_ld(): void
    {
        $this->actingAs($this->owner());
        $data = $this->payload();
        $data['translations']['es']['bio1'] = '</script><script>alert("test")</script>';
        $this->put('/admin/profile', $data)->assertSessionHasNoErrors();
        $this->get('/home')->assertSee($data['translations']['es']['bio1'])
            ->assertDontSee('</script><script>alert', false);
    }

    public function test_all_admin_editors_share_clear_navigation_and_private_responses(): void
    {
        $this->actingAs($this->owner());
        foreach (['/admin', '/admin/profile', '/admin/projects', '/admin/projects/create', '/admin/skills',
            '/admin/skills/create', '/admin/carousel', '/admin/blog', '/admin/blog/create'] as $url) {
            $response = $this->get($url)->assertOk()
                ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
                ->assertSee('class="admin-shell"', false)
                ->assertSee('class="admin-navigation"', false)
                ->assertSee(route('admin.profile.edit', ['lang' => 'es']), false)
                ->assertDontSee('<canvas', false);
            $this->assertSame(1, preg_match_all('/<h1(?:\s|>)/', $response->getContent()));
        }
    }
}
