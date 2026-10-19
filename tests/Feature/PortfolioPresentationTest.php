<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioPresentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_pages_have_one_primary_heading_and_shared_controls(): void
    {
        $this->withoutVite();

        foreach ([
            '/home', '/about', '/projects', '/contact', '/mi-periodo-practicas',
            '/blog', '/privacy-policy', '/terms-of-service', '/cookies-privacy',
        ] as $path) {
            $response = $this->get($path);
            $response->assertOk()
                ->assertSee('data-language-option="es"', false)
                ->assertSee('data-language-option="en"', false)
                ->assertSee('data-language-option="pt"', false)
                ->assertSee('aria-controls="nav-list"', false)
                ->assertSee('class="themeBtn', false)
                ->assertSee('<canvas id="mainShaderBg" aria-hidden="true">', false)
                ->assertSee('id="backgroundMotionToggle"', false)
                ->assertSee('aria-labelledby="darkThemeLabel"', false)
                ->assertSee('aria-labelledby="lightThemeLabel"', false)
                ->assertSee('data-i18n="theme.dark"', false)
                ->assertSee('data-i18n="theme.light"', false)
                ->assertSee('data-motion-label="play"', false)
                ->assertSee('data-motion-label="pause"', false)
                ->assertSee('data-motion-label="reduced"', false)
                ->assertSee('data-motion-label="unavailable"', false);

            $this->assertSame(
                1,
                preg_match_all('/<h1(?:\s|>)/', $response->getContent()),
                "Expected exactly one h1 on {$path}",
            );
        }
    }

    public function test_projects_preserve_all_cases_gallery_hooks_and_destinations(): void
    {
        $this->withoutVite();
        $response = $this->get('/projects');

        $response->assertOk()
            ->assertSee('data-gallery="gestor-fichaje"', false)
            ->assertSee('data-count="9"', false)
            ->assertSee('data-gallery="gestor-contenido"', false)
            ->assertSee('data-count="10"', false)
            ->assertSee('https://github.com/rogerio14698/n8n-LinkedingJob', false)
            ->assertSee('workFlow-BusquedaEmpleo.json', false)
            ->assertSee('https://apipokemon.rogerlab.es/pokemon/raichu', false);

        $this->assertSame(7, substr_count($response->getContent(), 'class="cardProject project-card"'));
    }

    public function test_contact_preserves_post_endpoint_fields_and_verification_widget(): void
    {
        $this->withoutVite();
        $response = $this->get('/contact');

        $response->assertOk()
            ->assertSee('method="POST"', false)
            ->assertSee('action="'.route('contact.submit').'"', false)
            ->assertSee('name="_token"', false)
            ->assertSee('data-turnstile-widget', false);

        foreach (['name', 'subject', 'email', 'message'] as $field) {
            $response->assertSee('for="'.$field.'"', false)
                ->assertSee('id="'.$field.'"', false);
        }
    }

    public function test_partial_navigation_keeps_the_section_contract(): void
    {
        $this->get('/about', [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-Partial-Navigation' => 'true',
        ])->assertOk()
            ->assertSee('id="dynamic-section"', false)
            ->assertSee('data-section="about"', false)
            ->assertSee('data-i18n="nav.about"', false)
            ->assertSee('<html', false);
    }

    public function test_internship_narrative_has_translation_hooks(): void
    {
        $this->withoutVite();
        $response = $this->get('/mi-periodo-practicas');

        $response->assertOk();
        foreach ([
            'intro.start', 'skills.title', 'skills.technical.label', 'skills.technical.body',
            'skills.operations.label', 'skills.operations.body', 'skills.development.label',
            'skills.development.body', 'skills.team.label', 'skills.team.body',
            'contribution.title', 'contribution.body1', 'contribution.body2',
        ] as $key) {
            $response->assertSee('data-i18n="practicas.'.$key.'"', false);
        }
        $response->assertSee('data-i18n-aria-label="practicas.modal.close"', false);
    }

    public function test_home_has_valid_person_and_website_schema_and_consistent_public_labels(): void
    {
        $this->withoutVite();
        $response = $this->get('/home')->assertOk()
            ->assertSee('RogerLab. Todos los derechos reservados.')
            ->assertSee('Prácticas FCT')
            ->assertSee('Política de privacidad')
            ->assertSee('Términos del servicio')
            ->assertSee('Política de cookies')
            ->assertSee('aria-hidden="true"></i> LinkedIn', false)
            ->assertSee('aria-hidden="true"></i> GitHub', false)
            ->assertDontSee('Roger Lab');
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $response->getContent(), $matches);
        $schema = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('https://schema.org', $schema['@context']);
        $this->assertSame('Person', $schema['@graph'][0]['@type']);
        $this->assertSame(config('seo.profile.name'), $schema['@graph'][0]['name']);
        $this->assertSame('WebSite', $schema['@graph'][1]['@type']);
        $this->assertSame('RogerLab', $schema['@graph'][1]['name']);
    }

    public function test_both_robots_responses_exclude_private_pages(): void
    {
        $dynamic = $this->get('/robots.txt')->assertOk()->getContent();
        $static = file_get_contents(public_path('robots.txt'));
        foreach (['/login', '/logout', '/admin', '/contact/verify/'] as $path) {
            $this->assertStringContainsString('Disallow: '.$path, $dynamic);
            $this->assertStringContainsString('Disallow: '.$path, $static);
        }
    }
}
