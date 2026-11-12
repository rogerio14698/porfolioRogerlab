<?php

namespace Tests\Feature;

use App\Models\ServiceSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests específicos para la localización y traducción de la landing Dior y Servicios.
 */
class ServiceLocalizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    /**
     * Comprueba que la landing Dior en portugués (?lang=pt) muestra los textos correspondientes.
     */
    public function test_dior_welcome_renders_portuguese_translations(): void
    {
        $response = $this->get('/?lang=pt');
        $response->assertStatus(200);
        $response->assertSee('O Portfólio');
        $response->assertSee('Serviços Web DAW');
        $response->assertSee('Descobrir Portfólio');
        $response->assertSee('Ver Catálogo de Serviços');
    }

    /**
     * Comprueba que la landing Dior en inglés (?lang=en) muestra los textos correspondientes.
     */
    public function test_dior_welcome_renders_english_translations(): void
    {
        $response = $this->get('/?lang=en');
        $response->assertStatus(200);
        $response->assertSee('The Portfolio');
        $response->assertSee('DAW Web Services');
        $response->assertSee('Discover Portfolio');
        $response->assertSee('View Services Catalog');
    }

    /**
     * Comprueba que la tienda de servicios en portugués (?lang=pt) muestra los textos editables en PT.
     */
    public function test_services_store_renders_portuguese_settings(): void
    {
        $response = $this->get('/servicios?lang=pt');
        $response->assertStatus(200);
        $response->assertSee('Soluções Web Exclusivas & Manutenção Dedicada');
        $response->assertSee('Aberto a qualquer ecossistema tecnológico');
        $response->assertSee('Pedir Orçamento');
    }
}
