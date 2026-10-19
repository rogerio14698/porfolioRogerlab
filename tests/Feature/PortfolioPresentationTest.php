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
                ->assertDontSee('<canvas', false);

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
}
