<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crea la tabla para almacenar la configuración y los textos editables de la tienda/sección de servicios freelance.
     */
    public function up(): void
    {
        Schema::create('service_settings', function (Blueprint $table) {
            $table->id();
            $table->json('translations'); // Textos en español, inglés y portugués
            $table->json('services_catalog')->nullable(); // Catálogo de servicios configurados (webs, mantenimiento, n8n, etc.)
            $table->json('pricing_plans')->nullable(); // Planes de pago único, mensual y bolsa de horas
            $table->string('notification_email')->default('rogeriolucas14698@gmail.com'); // Correo de aviso de solicitudes
            $table->string('whatsapp_number')->default('+34600000000'); // Número para contacto directo por WhatsApp
            $table->timestamps();
        });

        // Insertar datos iniciales por defecto con textos profesionales y persuasivos
        DB::table('service_settings')->insert([
            'id' => 1,
            'translations' => json_encode([
                'es' => [
                    'hero_eyebrow' => 'ROGERLAB • ESTUDIO DE INGENIERÍA & DESARROLLO WEB',
                    'hero_title' => 'Soluciones Web Exclusivas & Mantenimiento Especializado',
                    'hero_subtitle' => 'Diseño y desarrollo de sitios web de alto rendimiento, optimización técnica, automatizaciones inteligentes con n8n y soporte continuo para negocios y profesionales exigentes.',
                    'badge_open_stack' => 'Abierto a cualquier stack tecnológico: Laravel, PHP, Node.js, Vue, React, Python, WordPress headless y arquitecturas personalizadas.',
                    'services_section_title' => 'Catálogo de Soluciones Digitales',
                    'services_section_desc' => 'Desarrollos artesanales donde el rendimiento, la estética de lujo y la robustez técnica se unen para impulsar tu negocio.',
                    'maintenance_section_title' => 'Mantenimiento & Soporte de Webs Existentes',
                    'maintenance_section_desc' => '¿Ya tienes una web y necesitas que funcione sin fallos, segura y rápida? Me encargo de actualizarla, optimizarla y resolver problemas técnicos.',
                    'plans_section_title' => 'Modalidades de Contratación Flexibles',
                    'plans_section_desc' => 'Transparencia absoluta y adaptabilidad a la escala de tu proyecto.',
                    'cta_title' => '¿Listo para elevar tu presencia digital?',
                    'cta_desc' => 'Analicemos tu proyecto o las necesidades de tu sitio web sin compromiso.',
                    'seo_title' => 'Servicios Freelance de Desarrollo Web y Mantenimiento | RogerLab',
                    'seo_description' => 'Contrata servicios profesionales de desarrollo web a medida con Laravel, mantenimiento de páginas existentes, automatización con n8n y e-commerce de alto nivel en Gijón y remoto.',
                ],
                'en' => [
                    'hero_eyebrow' => 'ROGERLAB • WEB ENGINEERING & CRAFT DEVELOPMENT',
                    'hero_title' => 'Bespoke Web Solutions & Dedicated Maintenance',
                    'hero_subtitle' => 'High-performance web design and engineering, technical optimization, intelligent workflows with n8n, and ongoing support for ambitious businesses.',
                    'badge_open_stack' => 'Open to any tech stack: Laravel, PHP, Node.js, Vue, React, Python, headless architectures, and custom integrations.',
                    'services_section_title' => 'Digital Solutions Catalog',
                    'services_section_desc' => 'Handcrafted digital experiences combining luxury aesthetics, speed, and rock-solid technical foundations.',
                    'maintenance_section_title' => 'Maintenance & Care for Existing Websites',
                    'maintenance_section_desc' => 'Already have a website? Keep it secure, lightning-fast, and bug-free with dedicated maintenance and continuous improvements.',
                    'plans_section_title' => 'Flexible Engagement Models',
                    'plans_section_desc' => 'Clear terms adapted to your project scope and operational needs.',
                    'cta_title' => 'Ready to elevate your digital presence?',
                    'cta_desc' => 'Let us review your project or website requirements with no obligations.',
                    'seo_title' => 'Freelance Web Development & Maintenance Services | RogerLab',
                    'seo_description' => 'Hire bespoke web development, maintenance for existing sites, n8n automations, and custom e-commerce by a dedicated full-stack engineer.',
                ],
                'pt' => [
                    'hero_eyebrow' => 'ROGERLAB • ENGENHARIA & DESENVOLVIMENTO WEB',
                    'hero_title' => 'Soluções Web Exclusivas & Manutenção Dedicada',
                    'hero_subtitle' => 'Desenvolvimento de sites de alta performance, otimização técnica, automações com n8n e suporte contínuo para negócios exigentes.',
                    'badge_open_stack' => 'Aberto a qualquer ecossistema tecnológico: Laravel, PHP, Node.js, Vue, React, Python e arquiteturas sob medida.',
                    'services_section_title' => 'Catálogo de Soluções Digitais',
                    'services_section_desc' => 'Desenvolvimentos artesanais onde performance, estética refinada e robustez técnica se encontram.',
                    'maintenance_section_title' => 'Manutenção & Suporte para Sites Existentes',
                    'maintenance_section_desc' => 'Já possui um site e precisa dele sempre seguro, veloz e sem erros? Cuido de toda a infraestrutura técnica.',
                    'plans_section_title' => 'Modelos de Contratação Flexíveis',
                    'plans_section_desc' => 'Total transparência e adaptabilidade ao tamanho e ambição do seu projeto.',
                    'cta_title' => 'Pronto para transformar sua presença digital?',
                    'cta_desc' => 'Vamos avaliar o seu projeto ou as necessidades do seu site atual.',
                    'seo_title' => 'Serviços Freelance de Desenvolvimento Web e Manutenção | RogerLab',
                    'seo_description' => 'Contrate desenvolvimento web sob medida com Laravel, manutenção de sites, automações n8n e e-commerce avançado.',
                ],
            ]),
            'services_catalog' => json_encode([
                [
                    'id' => 'webs_a_medida',
                    'icon' => 'code',
                    'title' => 'Creación de Webs Personalizadas',
                    'short_desc' => 'Sitios web corporativos, landing pages de alta conversión y plataformas web a medida sin plantillas pesadas.',
                    'features' => [
                        'Arquitectura Full Stack ultrarrápida (Laravel / Node / React / Vue)',
                        'Diseño visual exclusivo, responsive y adaptativo',
                        'SEO técnico y Core Web Vitals optimizados al 100%',
                        'Panel de control / CMS a medida intuitivo y seguro',
                    ],
                    'delivery_time' => '2 a 4 semanas',
                    'recommended_for' => 'Empresas, despachos profesionales y marcas que buscan diferenciarse con calidad prémium.',
                ],
                [
                    'id' => 'mantenimiento_soporte',
                    'icon' => 'shield-check',
                    'title' => 'Mantenimiento & Seguridad Web',
                    'short_desc' => 'Cuidado integral de sitios web ya existentes para evitar caídas, hackeos y problemas de rendimiento.',
                    'features' => [
                        'Actualizaciones seguras de CMS (WordPress, Laravel, PHP, plugins)',
                        'Copias de seguridad automáticas y monitorización 24/7',
                        'Optimización de tiempos de carga y velocidad de respuesta',
                        'Resolución prioritaria de incidencias y parches de seguridad',
                    ],
                    'delivery_time' => 'Continuo / Mensual',
                    'recommended_for' => 'Negocios que no pueden permitirse caídas ni fallos en su web en producción.',
                ],
                [
                    'id' => 'automatizacion_n8n',
                    'icon' => 'cpu',
                    'title' => 'Automatización con n8n & IA',
                    'short_desc' => 'Conecta tus aplicaciones, sincroniza datos de clientes y automatiza tareas repetitivas para ahorrar cientos de horas.',
                    'features' => [
                        'Integración de CRM, correo, formularios y hojas de cálculo',
                        'Flujos automáticos con webhooks, APIs y modelos de IA',
                        'Procesamiento y sincronización de leads en tiempo real',
                        'Infraestructura n8n alojada de forma privada y segura',
                    ],
                    'delivery_time' => '1 a 2 semanas',
                    'recommended_for' => 'Empresas que desean escalar operaciones sin aumentar costes de personal manual.',
                ],
                [
                    'id' => 'ecommerce_custom',
                    'icon' => 'shopping-bag',
                    'title' => 'E-Commerce a Medida',
                    'short_desc' => 'Tiendas online diseñadas para convertir, con pasarelas de pago seguras y gestión de catálogo ágil.',
                    'features' => [
                        'Checkout de fricción mínima (Stripe, Redsýs, PayPal, Bizum)',
                        'Gestión personalizada de stock, variantes y facturación',
                        'Carga instantánea de catálogo de productos',
                        'Integración con plataformas logísticas y de mensajería',
                    ],
                    'delivery_time' => '3 a 6 semanas',
                    'recommended_for' => 'Marcas que venden productos exclusivos y necesitan una experiencia de compra impecable.',
                ],
                [
                    'id' => 'auditoria_seo_rendimiento',
                    'icon' => 'sparkles',
                    'title' => 'Auditoría Técnica, SEO & Rendimiento',
                    'short_desc' => 'Diagnóstico profundo de tu web actual para detectar cuellos de botella, errores de indexación y pérdidas de clientes.',
                    'features' => [
                        'Informe exhaustivo de Core Web Vitals y velocidad',
                        'Análisis de código, bases de datos y seguridad',
                        'Estrategia de arquitectura de información y SEO On-page',
                        'Plan de acción directo con mejoras listas para ejecutar',
                    ],
                    'delivery_time' => '3 a 5 días laborables',
                    'recommended_for' => 'Webs que han perdido tráfico o que cargan lento perjudicando sus ventas.',
                ],
            ]),
            'pricing_plans' => json_encode([
                [
                    'id' => 'pago_unico',
                    'title' => 'Por Proyecto / Hito',
                    'tagline' => 'Para nuevos proyectos o rediseños completos',
                    'price' => 'Presupuesto a Medida',
                    'period' => 'pago por fases acordadas',
                    'description' => 'Alcance definido desde el primer día, sin sorpresas ni costes ocultos.',
                    'items' => [
                        'Briefing y análisis de requerimientos en profundidad',
                        'Diseño visual de alta fidelidad y prototipado',
                        'Desarrollo Full Stack con código limpio y comentado',
                        'Despliegue en producción y garantía post-lanzamiento',
                    ],
                ],
                [
                    'id' => 'suscripcion_mensual',
                    'title' => 'Mantenimiento Mensual',
                    'tagline' => 'Tranquilidad técnica continua',
                    'price' => 'Desde 79€',
                    'period' => '/ mes (sin permanencia)',
                    'description' => 'Tu web siempre actualizada, monitorizada y protegida por un desarrollador dedicado.',
                    'items' => [
                        'Backups periódicos en la nube',
                        'Actualizaciones de seguridad y dependencias',
                        'Horas mensuales reservadas para cambios o mejoras',
                        'Soporte prioritario por email y WhatsApp',
                    ],
                ],
                [
                    'id' => 'bolsa_horas',
                    'title' => 'Bolsa de Horas',
                    'tagline' => 'Soporte e intervenciones bajo demanda',
                    'price' => 'Packs de 10h / 20h',
                    'period' => 'a consumir a tu ritmo',
                    'description' => 'Ideal para resolver bugs puntuales, agregar nuevas secciones o integrar APIs.',
                    'items' => [
                        'Desarrollo en cualquier stack o tecnología',
                        'Reporte transparente de tiempo invertido',
                        'Sin caducidad mensual inmediata',
                        'Atención directa y ágil con el desarrollador',
                    ],
                ],
            ]),
            'notification_email' => 'rogeriolucas14698@gmail.com',
            'whatsapp_number' => '+34600000000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_settings');
    }
};
