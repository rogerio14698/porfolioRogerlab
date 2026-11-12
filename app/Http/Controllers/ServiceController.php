<?php

namespace App\Http\Controllers;

use App\Mail\ServiceInquiryMail;
use App\Models\ServiceSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * ServiceController:
 * Controla la vista de bienvenida split-screen estilo Dior ('welcome'),
 * la tienda y catálogo de servicios freelance ('servicios'),
 * y el procesamiento de solicitudes de clientes con notificación a rogeriolucas14698@gmail.com.
 */
class ServiceController extends Controller
{
    /**
     * Landing split-screen estilo Dior:
     * Divide la pantalla en Portfolio (imgPortfolio.jpg) y Estudio Freelance (imgFreelance.jpg).
     */
    public function welcome()
    {
        $settings = ServiceSetting::current();

        $titles = [
            'es' => 'RogerLab | Taller Digital & Estudio de Desarrollo Web DAW',
            'en' => 'RogerLab | Digital Workshop & Bespoke Web Engineering Studio',
            'pt' => 'RogerLab | Oficina Digital & Estúdio de Desenvolvimento Web DAW',
        ];

        $descs = [
            'es' => 'Bienvenido a RogerLab. Descubre el portfolio de proyectos y el estudio de servicios web freelance a medida, mantenimiento técnico y automatización.',
            'en' => 'Welcome to RogerLab. Discover the projects portfolio and bespoke web development services studio, technical maintenance and automation.',
            'pt' => 'Bem-vindo ao RogerLab. Conheça o portfólio de projetos e o estúdio de serviços web sob medida, manutenção técnica e automação.',
        ];

        $locale = app()->getLocale();
        $pageTitle = $titles[$locale] ?? $titles['es'];
        $pageDesc = $descs[$locale] ?? $descs['es'];

        return renderSection(
            'welcomeDior',
            $pageTitle,
            $pageDesc,
            200,
            null,
            [
                'settings' => $settings,
                'ogImage' => asset('img/referencia4.jpeg'),
                ...$this->alternates('welcome'),
            ]
        );
    }

    /**
     * Tienda y catálogo completo de servicios freelance DAW.
     */
    public function index()
    {
        $settings = ServiceSetting::current();

        $pageTitle = $settings->text('seo_title') ?: 'Servicios de Desarrollo Web & Mantenimiento Especializado | RogerLab';
        $pageDesc = $settings->text('seo_description') ?: 'Soluciones web completas: desarrollo de webs a medida con Laravel, mantenimiento de sitios existentes, automatización con n8n y e-commerce personalizado.';

        return renderSection(
            'servicesStore',
            $pageTitle,
            $pageDesc,
            200,
            null,
            [
                'settings' => $settings,
                'services' => $settings->services_catalog ?? [],
                'plans' => $settings->pricing_plans ?? [],
                'ogImage' => asset('img/referencia4.jpeg'),
                'schemaJsonLd' => $this->servicesSchema($settings),
                ...$this->alternates('services.index'),
            ]
        );
    }

    /**
     * Procesa la solicitud o consulta de contratación de un servicio,
     * enviando notificación inmediata al correo de Rogerio y permitiendo contacto por WhatsApp.
     */
    public function submitInquiry(Request $request): RedirectResponse
    {
        // Validación de seguridad Cloudflare Turnstile anti-spam
        if (! $this->turnstilePassed($request)) {
            return back()
                ->withErrors(['security' => 'No se pudo validar la verificación de seguridad de Cloudflare. Inténtalo de nuevo.'])
                ->withInput($request->except('cf-turnstile-response'))
                ->withFragment('contacto-servicios');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'service_id' => ['nullable', 'string', 'max:60'],
            'service_name' => ['nullable', 'string', 'max:150'],
            'plan_name' => ['nullable', 'string', 'max:100'],
            'budget' => ['nullable', 'string', 'max:80'],
            'description' => ['required', 'string', 'min:10', 'max:3000'],
            'website_url' => ['nullable', 'string', 'max:250'], // Para clientes con webs existentes
        ]);

        $settings = ServiceSetting::current();
        $targetEmail = $settings->notification_email ?: 'rogeriolucas14698@gmail.com';

        $inquiryData = array_merge($validated, [
            'notification_email' => $targetEmail,
        ]);

        try {
            Mail::send(new ServiceInquiryMail($inquiryData));
        } catch (\Throwable $e) {
            // Se registra en logs pero no detiene la experiencia del usuario
            report($e);
        }

        return redirect()
            ->route('services.index', ['lang' => app()->getLocale()])
            ->with('service_success', '¡Gracias por contactar! He recibido tu solicitud en mi correo. Te responderé en menos de 24 horas con una propuesta a medida.')
            ->withFragment('contacto-servicios');
    }

    /**
     * Valida el token de Cloudflare Turnstile para evitar bots y spam.
     */
    protected function turnstilePassed(Request $request): bool
    {
        if (app()->environment('testing')) {
            return true;
        }

        if (app()->isLocal() && blank(config('services.turnstile.secret_key'))) {
            return true;
        }

        $token = $request->string('cf-turnstile-response')->toString();
        if (blank($token)) {
            return false;
        }

        $response = Http::asForm()
            ->timeout(10)
            ->post(config('services.turnstile.verify_url'), [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

        if (! $response->ok()) {
            return false;
        }

        $result = $response->json();
        $expectedHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        return (bool) data_get($result, 'success')
            && (! $expectedHost || data_get($result, 'hostname') === $expectedHost);
    }

    /**
     * Genera datos estructurados Schema.org para SEO profesional de servicios.
     */
    private function servicesSchema(ServiceSetting $settings): array
    {
        $profile = config('seo.profile');
        $url = route('services.index', ['lang' => app()->getLocale()]);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => 'RogerLab - Estudio de Desarrollo Web & Mantenimiento',
            'url' => $url,
            'image' => asset($profile['image'] ?? 'img/cv-foto.jpeg'),
            'description' => $settings->text('seo_description'),
            'telephone' => $profile['telephone'] ?? '',
            'email' => $settings->notification_email ?: 'rogeriolucas14698@gmail.com',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => config('seo.city', 'Gijón'),
                'addressRegion' => config('seo.region', 'Asturias'),
                'addressCountry' => 'ES',
            ],
            'priceRange' => '€€',
            'openingHours' => 'Mo-Fr 09:00-19:00',
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Catálogo de Servicios Digitales RogerLab',
                'itemListElement' => collect($settings->services_catalog ?? [])->map(fn($item, $index) => [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => $item['title'] ?? '',
                        'description' => $item['short_desc'] ?? '',
                    ],
                ])->all(),
            ],
        ];
    }

    /**
     * Genera enlaces canónicos y de idiomas alternativos (es, en, pt).
     */
    private function alternates(string $route): array
    {
        $links = [];
        foreach (config('blog.locales') as $locale) {
            $links[$locale] = route($route, ['lang' => $locale]);
        }
        $links['x-default'] = $links['es'];

        return [
            'canonicalUrl' => route($route, ['lang' => app()->getLocale()]),
            'hreflangLinks' => $links,
        ];
    }
}
