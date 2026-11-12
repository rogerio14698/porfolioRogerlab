{{--
    Vista: components/servicesStore.blade.php
    Descripción: Tienda y Estudio de Servicios Freelance de RogerLab.
    Incluye:
    - Cabecera editorial con declaración de principios y apertura tecnológica a cualquier stack.
    - Catálogo de servicios (Webs personalizadas, mantenimiento de webs existentes, automatizaciones con n8n, e-commerce, auditoría).
    - Sección específica para clientes que ya tienen web y necesitan soporte o mejoras.
    - Modalidades de contratación: Pago por proyecto, suscripción mensual y bolsa de horas.
    - Formulario interactivo de propuesta que notifica a rogeriolucas14698@gmail.com con opción de enlace a WhatsApp.
--}}
<section class="services-store" id="servicios-estudio" aria-label="Estudio de Servicios Digitales y Desarrollo Web">
    {{-- Notificación de éxito si se ha enviado el formulario --}}
    @if (session('service_success'))
        <div class="service-alert-success" role="alert">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <div>
                <strong>{{ __('services.alert_success_title') }}</strong>
                <p>{{ session('service_success') }}</p>
            </div>
        </div>
    @endif

    {{-- Hero de Servicios: Elegancia editorial & fiabilidad --}}
    <header class="services-hero">
        <span class="services-eyebrow">{{ $settings->text('hero_eyebrow') }}</span>
        <h1 class="services-main-title">{{ $settings->text('hero_title') }}</h1>
        <p class="services-subtitle">{{ $settings->text('hero_subtitle') }}</p>

        {{-- Banner de apertura tecnológica: no nos cerramos a ningún stack --}}
        <div class="services-open-stack-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
            <span>{{ $settings->text('badge_open_stack') }}</span>
        </div>

        <div class="services-hero-cta">
            <a href="#contacto-servicios" class="service-primary-btn">
                <span>{{ __('services.request_quote') }}</span>
            </a>
            @php
                $cleanWhatsapp = preg_replace('/[^0-9]/', '', $settings->whatsapp_number ?? '34600000000');
                $waText = urlencode("Hola Rogerio, he visto tu estudio web en RogerLab y me gustaría consultar sobre vuestros servicios.");
            @endphp
            <a href="https://wa.me/{{ $cleanWhatsapp }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="service-whatsapp-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.66c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.15-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.17-.25.25-.42.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.64 4.2 3.7.59.25 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.11-.22-.17-.47-.29"/></svg>
                <span>{{ __('services.whatsapp_direct') }}</span>
            </a>
        </div>
    </header>

    {{-- Catálogo de Servicios Principales --}}
    <section class="services-catalog-section" aria-labelledby="catalog-heading">
        <div class="section-intro-header">
            <h2 id="catalog-heading" class="section-title">{{ $settings->text('services_section_title') }}</h2>
            <p class="section-description">{{ $settings->text('services_section_desc') }}</p>
        </div>

        <div class="services-grid">
            @foreach ($services as $service)
                <article class="service-card" data-service-id="{{ $service['id'] ?? '' }}">
                    <div class="service-card-header">
                        <span class="service-badge-tag">{{ $service['delivery_time'] ?? 'A medida' }}</span>
                        <h3 class="service-title">{{ $service['title'] ?? '' }}</h3>
                        <p class="service-desc">{{ $service['short_desc'] ?? '' }}</p>
                    </div>

                    <div class="service-features-list">
                        <h4>{{ __('services.includes_heading') }}</h4>
                        <ul>
                            @foreach ($service['features'] ?? [] as $feat)
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    <span>{{ $feat }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if (!empty($service['recommended_for']))
                        <div class="service-recommended">
                            <strong>{{ __('services.ideal_for') }}</strong> {{ $service['recommended_for'] }}
                        </div>
                    @endif

                    <div class="service-card-action">
                        <a href="#contacto-servicios" class="service-btn-select" data-select-service="{{ $service['title'] ?? '' }}">
                            <span>{{ __('services.choose_service') }}</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Módulo Especial: Mantenimiento & Solución para Clientes que YA tienen web --}}
    <section class="maintenance-special-block" id="mantenimiento-web">
        <div class="maintenance-inner">
            <div class="maintenance-text">
                <span class="maintenance-kicker">Soporte Técnico de Élite</span>
                <h2>{{ $settings->text('maintenance_section_title') }}</h2>
                <p>{{ $settings->text('maintenance_section_desc') }}</p>
                <div class="maintenance-bullets">
                    <div class="m-bullet">
                        <strong>¿Tu web actual carga lenta?</strong>
                        <p>Optimizo imágenes, código, consultas a base de datos y cache para obtener puntuaciones 90+ en PageSpeed.</p>
                    </div>
                    <div class="m-bullet">
                        <strong>¿Problemas con PHP, plugins o base de datos?</strong>
                        <p>Diagnóstico de logs, reparación de pantallas en blanco, actualización segura y refactorización de código heredado.</p>
                    </div>
                    <div class="m-bullet">
                        <strong>¿Vulnerabilidades o miedo a perder datos?</strong>
                        <p>Copias de seguridad programadas fuera del servidor y blindaje frente a ataques automatizados.</p>
                    </div>
                </div>
            </div>
            <div class="maintenance-card-cta">
                <div class="m-cta-box">
                    <h3>{{ __('services.review_cta_title') }}</h3>
                    <p>{{ __('services.review_cta_desc') }}</p>
                    <a href="#contacto-servicios" class="service-primary-btn" data-prefill-service="Mantenimiento y Auditoría de Web Existente">
                        <span>{{ __('services.request_audit') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Planes y Modelos de Contratación --}}
    <section class="pricing-plans-section" aria-labelledby="plans-heading">
        <div class="section-intro-header">
            <h2 id="plans-heading" class="section-title">{{ $settings->text('plans_section_title') }}</h2>
            <p class="section-description">{{ $settings->text('plans_section_desc') }}</p>
        </div>

        <div class="plans-grid">
            @foreach ($plans as $plan)
                <article class="plan-card @if(($plan['id'] ?? '') === 'suscripcion_mensual') plan-card-featured @endif">
                    @if (($plan['id'] ?? '') === 'suscripcion_mensual')
                        <div class="plan-featured-ribbon">Recomendado para webs activas</div>
                    @endif
                    <div class="plan-header">
                        <h3 class="plan-title">{{ $plan['title'] ?? '' }}</h3>
                        <p class="plan-tagline">{{ $plan['tagline'] ?? '' }}</p>
                        <div class="plan-price-wrap">
                            <span class="plan-price">{{ $plan['price'] ?? '' }}</span>
                            <span class="plan-period">{{ $plan['period'] ?? '' }}</span>
                        </div>
                        <p class="plan-description">{{ $plan['description'] ?? '' }}</p>
                    </div>

                    <ul class="plan-items-list">
                        @foreach ($plan['items'] ?? [] as $item)
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="plan-action">
                        <a href="#contacto-servicios" class="plan-btn" data-select-plan="{{ $plan['title'] ?? '' }}">
                            <span>{{ __('services.choose_plan') }}</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Formulario de Solicitud y Contacto Directo --}}
    <section class="service-inquiry-section" id="contacto-servicios" aria-labelledby="inquiry-heading">
        <div class="inquiry-container">
            <div class="inquiry-header">
                <span class="inquiry-eyebrow">{{ __('services.inquiry_eyebrow') }}</span>
                <h2 id="inquiry-heading">{{ $settings->text('cta_title') }}</h2>
                <p>{{ $settings->text('cta_desc') }} Recibiré tu consulta directamente en mi correo personal y te responderé con un presupuesto claro y plazos exactos.</p>
            </div>

            @if ($errors->any())
                <div class="service-alert-error" role="alert" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px; padding: 1rem 1.5rem; margin-bottom: 2rem; color: #ef4444;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('services.inquiry') }}" method="POST" class="service-inquiry-form" id="serviceInquiryForm">
                @csrf

                <div class="form-row-dual">
                    <div class="form-group">
                        <label for="client_name">{{ __('services.form_name') }}</label>
                        <input type="text" id="client_name" name="name" required placeholder="Ej: Sandra Pérez o Estudio Creativo" value="{{ old('name') }}" />
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="client_email">{{ __('services.form_email') }}</label>
                        <input type="email" id="client_email" name="email" required placeholder="tucorreo@empresa.com" value="{{ old('email') }}" />
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row-dual">
                    <div class="form-group">
                        <label for="client_phone">{{ __('services.form_phone') }}</label>
                        <input type="tel" id="client_phone" name="phone" placeholder="+34 600 000 000" value="{{ old('phone') }}" />
                    </div>

                    <div class="form-group">
                        <label for="client_website">{{ __('services.form_website') }}</label>
                        <input type="url" id="client_website" name="website_url" placeholder="https://tuwebactual.com" value="{{ old('website_url') }}" />
                    </div>
                </div>

                <div class="form-row-dual">
                    <div class="form-group">
                        <label for="service_select">{{ __('services.form_service') }}</label>
                        <select id="service_select" name="service_name">
                            <option value="Creación de Web a Medida">Creación de Web a Medida</option>
                            <option value="Mantenimiento & Seguridad Web">Mantenimiento & Seguridad Web Existente</option>
                            <option value="Automatización con n8n & IA">Automatización de Procesos (n8n / APIs)</option>
                            <option value="E-Commerce Personalizado">E-Commerce Personalizado</option>
                            <option value="Auditoría SEO & Rendimiento">Auditoría SEO & Rendimiento</option>
                            <option value="Otro tipo de desarrollo / Stack personalizado">Otro tipo de desarrollo / Stack personalizado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="plan_select">{{ __('services.form_plan') }}</label>
                        <select id="plan_select" name="plan_name">
                            <option value="Presupuesto por Proyecto">Presupuesto por Proyecto (Pago Único)</option>
                            <option value="Mantenimiento Mensual">Mantenimiento Mensual Recurrente</option>
                            <option value="Bolsa de Horas">Bolsa de Horas de Soporte</option>
                            <option value="No estoy seguro, necesito asesoramiento">No estoy seguro, necesito asesoramiento</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="client_description">{{ __('services.form_description') }}</label>
                    <textarea id="client_description" name="description" rows="5" required placeholder="Describe qué tipo de web quieres, qué problema tiene tu web actual, o qué proceso te gustaría automatizar...">{{ old('description') }}</textarea>
                    @error('description') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                {{-- Widget de Cloudflare Turnstile para protección anti-spam --}}
                <div class="contactTurnstile" data-turnstile-widget data-sitekey="{{ config('services.turnstile.site_key') }}"
                    data-theme="auto" data-action="services" style="margin: 0.5rem auto 1rem auto; display: flex; justify-content: center;"></div>

                <div class="form-footer-action">
                    <button type="submit" class="submit-inquiry-btn">
                        <span>{{ __('services.form_submit') }}</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                    <p class="privacy-note">{{ __('services.form_privacy') }}</p>
                </div>
            </form>
        </div>
    </section>
</section>
