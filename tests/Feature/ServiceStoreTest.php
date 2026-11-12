<?php

namespace Tests\Feature;

use App\Mail\ServiceInquiryMail;
use App\Models\ServiceSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Tests de integración y funcionalidad para el Portal Dior y la Tienda de Servicios Freelance.
 */
class ServiceStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    /**
     * Comprueba que la landing Dior carga correctamente en la raíz con código HTTP 200.
     */
    public function test_dior_welcome_portal_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('El Portfolio');
        $response->assertSee('Servicios Web DAW');
    }

    /**
     * Comprueba que la tienda y catálogo de servicios freelance carga con sus planes y servicios.
     */
    public function test_services_store_page_renders_with_catalog_and_plans(): void
    {
        $response = $this->get('/servicios');
        $response->assertStatus(200);
        $response->assertSee('Mantenimiento');
        $response->assertSee('Automatización con n8n');
        $response->assertSee('E-Commerce a Medida');
        $response->assertSee('Bolsa de Horas');
    }

    /**
     * Comprueba que el envío del formulario de propuesta envía el correo a rogeriolucas14698@gmail.com.
     */
    public function test_submitting_service_inquiry_sends_email_notification(): void
    {
        Mail::fake();

        $response = $this->post('/servicios/solicitud', [
            'name' => 'Sandra García',
            'email' => 'cliente.prueba@empresa.com',
            'phone' => '+34 611 222 333',
            'service_name' => 'Creación de Web a Medida',
            'plan_name' => 'Presupuesto por Proyecto',
            'description' => 'Necesitamos una web corporativa rápida y optimizada para captar clientes.',
        ]);

        $response->assertRedirect(route('services.index', ['lang' => 'es']) . '#contacto-servicios');
        $response->assertSessionHas('service_success');

        Mail::assertSent(ServiceInquiryMail::class, function ($mail) {
            return $mail->hasTo('rogeriolucas@rogerlab.es')
                && $mail->inquiryData['name'] === 'Sandra García';
        });
    }

    /**
     * Comprueba que desde /admin se puede editar la configuración y textos de la tienda.
     */
    public function test_admin_can_update_service_store_settings(): void
    {
        $owner = User::factory()->create(['email' => config('blog.owner_email')]);

        $response = $this->actingAs($owner)->put('/admin/services', [
            'notification_email' => 'rogeriolucas14698@gmail.com',
            'whatsapp_number' => '+34699887766',
            'translations' => [
                'es' => [
                    'hero_eyebrow' => 'ROGERLAB • ESTUDIO EXCLUSIVO',
                    'hero_title' => 'Nuevas Soluciones Web Premium',
                    'hero_subtitle' => 'Desarrollo artesanal para proyectos exigentes.',
                    'badge_open_stack' => 'Abierto a cualquier tecnología.',
                    'maintenance_section_title' => 'Mantenimiento Experto',
                    'maintenance_section_desc' => 'Cuidamos de tu web existente.',
                    'seo_title' => 'Servicios Web Gijón | RogerLab',
                    'seo_description' => 'Desarrollo web a medida y soporte en Asturias.',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.services.edit', ['lang' => 'es']));
        $this->assertEquals('Nuevas Soluciones Web Premium', ServiceSetting::current()->text('hero_title'));
    }
}
