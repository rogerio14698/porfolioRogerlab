{{--
    Vista: portfolio/admin-services.blade.php
    Descripción: Panel de administración exclusivo para la Tienda y Servicios Freelance.
    Permite modificar todos los textos, el catálogo de servicios, planes de precios,
    correo de notificación (rogeriolucas14698@gmail.com) y teléfono de WhatsApp.
--}}
<section class="blog blog-admin">
    <header class="blog-header">
        <h1>Tienda & Servicios Freelance</h1>
        <p>Configura los textos promocionales, los servicios activos, tarifas y canales de notificación para clientes.</p>
    </header>

    @if (session('status'))
        <div class="service-alert-success" style="margin-bottom: 2rem;">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.services.update', ['lang' => app()->getLocale()]) }}" class="blog-editor">
        @csrf
        @method('PUT')

        {{-- Canales de Notificación y Contacto --}}
        <fieldset class="admin-group-card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <legend style="color: #10b981; font-weight: 600; padding: 0 0.5rem;">Canales de Contacto & Notificaciones</legend>

            <div class="field" style="margin-bottom: 1.25rem;">
                <label for="notification_email" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Email de Notificación de Solicitudes (donde recibirás los clientes):</label>
                <input type="email" id="notification_email" name="notification_email" value="{{ old('notification_email', $settings->notification_email) }}" required style="width: 100%; max-width: 500px; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                <p style="font-size: 0.85rem; color: #9ca3af; margin-top: 0.25rem;">Se enviará una alerta automática con todos los datos del cliente a esta dirección.</p>
            </div>

            <div class="field">
                <label for="whatsapp_number" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Número de WhatsApp para contacto directo (con prefijo internacional):</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}" required style="width: 100%; max-width: 500px; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
            </div>
        </fieldset>

        {{-- Textos de la Tienda (Traducciones ES, EN, PT) --}}
        @foreach (config('blog.locales') as $loc)
            <details class="admin-language-panel" @if ($loc === 'es') open @endif style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                <summary style="cursor: pointer; font-weight: 600; color: #10b981; font-size: 1.1rem; padding-bottom: 0.5rem;">
                    Textos de la Tienda · {{ strtoupper($loc) }} ({{ __('blog.'.$loc) }})
                </summary>

                <div style="margin-top: 1rem;">
                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_hero_eyebrow" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Subtítulo de marca superior (Eyebrow):</label>
                        <input type="text" id="trans_{{ $loc }}_hero_eyebrow" name="translations[{{ $loc }}][hero_eyebrow]" value="{{ old('translations.'.$loc.'.hero_eyebrow', $settings->text('hero_eyebrow', $loc)) }}" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_hero_title" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Título Hero de la Tienda / Estudio:</label>
                        <input type="text" id="trans_{{ $loc }}_hero_title" name="translations[{{ $loc }}][hero_title]" value="{{ old('translations.'.$loc.'.hero_title', $settings->text('hero_title', $loc)) }}" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_hero_subtitle" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Descripción Hero / Propuesta de Valor:</label>
                        <textarea id="trans_{{ $loc }}_hero_subtitle" name="translations[{{ $loc }}][hero_subtitle]" rows="3" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ old('translations.'.$loc.'.hero_subtitle', $settings->text('hero_subtitle', $loc)) }}</textarea>
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_badge_open_stack" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Declaración de Apertura Tecnológica (Cualquier Stack):</label>
                        <textarea id="trans_{{ $loc }}_badge_open_stack" name="translations[{{ $loc }}][badge_open_stack]" rows="2" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ old('translations.'.$loc.'.badge_open_stack', $settings->text('badge_open_stack', $loc)) }}</textarea>
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_services_section_title" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Título de la sección de Catálogo:</label>
                        <input type="text" id="trans_{{ $loc }}_services_section_title" name="translations[{{ $loc }}][services_section_title]" value="{{ old('translations.'.$loc.'.services_section_title', $settings->text('services_section_title', $loc)) }}" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_services_section_desc" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Descripción de Catálogo:</label>
                        <textarea id="trans_{{ $loc }}_services_section_desc" name="translations[{{ $loc }}][services_section_desc]" rows="2" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ old('translations.'.$loc.'.services_section_desc', $settings->text('services_section_desc', $loc)) }}</textarea>
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_maintenance_section_title" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Título de Mantenimiento para Webs Existentes:</label>
                        <input type="text" id="trans_{{ $loc }}_maintenance_section_title" name="translations[{{ $loc }}][maintenance_section_title]" value="{{ old('translations.'.$loc.'.maintenance_section_title', $settings->text('maintenance_section_title', $loc)) }}" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_maintenance_section_desc" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Descripción de Mantenimiento:</label>
                        <textarea id="trans_{{ $loc }}_maintenance_section_desc" name="translations[{{ $loc }}][maintenance_section_desc]" rows="2" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ old('translations.'.$loc.'.maintenance_section_desc', $settings->text('maintenance_section_desc', $loc)) }}</textarea>
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_plans_section_title" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Título de la sección de Planes:</label>
                        <input type="text" id="trans_{{ $loc }}_plans_section_title" name="translations[{{ $loc }}][plans_section_title]" value="{{ old('translations.'.$loc.'.plans_section_title', $settings->text('plans_section_title', $loc)) }}" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_plans_section_desc" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Descripción de Planes:</label>
                        <textarea id="trans_{{ $loc }}_plans_section_desc" name="translations[{{ $loc }}][plans_section_desc]" rows="2" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ old('translations.'.$loc.'.plans_section_desc', $settings->text('plans_section_desc', $loc)) }}</textarea>
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_cta_title" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Título de Llamada a la Acción (CTA Formulario):</label>
                        <input type="text" id="trans_{{ $loc }}_cta_title" name="translations[{{ $loc }}][cta_title]" value="{{ old('translations.'.$loc.'.cta_title', $settings->text('cta_title', $loc)) }}" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_cta_desc" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Descripción de Llamada a la Acción:</label>
                        <textarea id="trans_{{ $loc }}_cta_desc" name="translations[{{ $loc }}][cta_desc]" rows="2" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ old('translations.'.$loc.'.cta_desc', $settings->text('cta_desc', $loc)) }}</textarea>
                    </div>

                    <div class="field" style="margin-bottom: 1.25rem;">
                        <label for="trans_{{ $loc }}_seo_title" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Título SEO (Meta Title · {{ strtoupper($loc) }}):</label>
                        <input type="text" id="trans_{{ $loc }}_seo_title" name="translations[{{ $loc }}][seo_title]" value="{{ old('translations.'.$loc.'.seo_title', $settings->text('seo_title', $loc)) }}" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field">
                        <label for="trans_{{ $loc }}_seo_description" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Descripción SEO (Meta Description · {{ strtoupper($loc) }}):</label>
                        <textarea id="trans_{{ $loc }}_seo_description" name="translations[{{ $loc }}][seo_description]" rows="2" style="width: 100%; padding: 0.75rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ old('translations.'.$loc.'.seo_description', $settings->text('seo_description', $loc)) }}</textarea>
                    </div>
                </div>
            </details>
        @endforeach

        {{-- CRUD del Catálogo de Servicios --}}
        <fieldset class="admin-group-card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <legend style="color: #10b981; font-weight: 600; padding: 0 0.5rem;">CRUD de Servicios Ofrecidos</legend>
            <p style="font-size: 0.85rem; color: #9ca3af; margin-bottom: 1.5rem;">Edita los títulos, descripciones, plazos, lista de características e idoneidad de cada servicio que ofreces.</p>

            @foreach ($settings->services_catalog ?? [] as $index => $srv)
                <div class="service-crud-item" style="background: rgba(0,0,0,0.25); border: 1px solid #1f2c27; border-radius: 6px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    <input type="hidden" name="services_catalog[{{ $index }}][id]" value="{{ $srv['id'] ?? '' }}" />
                    <input type="hidden" name="services_catalog[{{ $index }}][icon]" value="{{ $srv['icon'] ?? 'code' }}" />

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div class="field">
                            <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Título del Servicio:</label>
                            <input type="text" name="services_catalog[{{ $index }}][title]" value="{{ $srv['title'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                        </div>
                        <div class="field">
                            <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Plazo / Entrega Estimada:</label>
                            <input type="text" name="services_catalog[{{ $index }}][delivery_time]" value="{{ $srv['delivery_time'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                        </div>
                    </div>

                    <div class="field" style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Descripción Corta:</label>
                        <input type="text" name="services_catalog[{{ $index }}][short_desc]" value="{{ $srv['short_desc'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Qué incluye (una característica por línea):</label>
                        <textarea name="services_catalog[{{ $index }}][features]" rows="3" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ is_array($srv['features'] ?? null) ? implode("\n", $srv['features']) : ($srv['features'] ?? '') }}</textarea>
                    </div>

                    <div class="field">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Ideal para:</label>
                        <input type="text" name="services_catalog[{{ $index }}][recommended_for]" value="{{ $srv['recommended_for'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>
                </div>
            @endforeach
        </fieldset>

        {{-- CRUD de Modalidades de Contratación / Planes --}}
        <fieldset class="admin-group-card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <legend style="color: #10b981; font-weight: 600; padding: 0 0.5rem;">CRUD de Modalidades de Contratación / Planes</legend>
            <p style="font-size: 0.85rem; color: #9ca3af; margin-bottom: 1.5rem;">Configura las opciones de Pago Único, Mantenimiento Mensual y Bolsa de Horas.</p>

            @foreach ($settings->pricing_plans ?? [] as $pIndex => $plan)
                <div class="plan-crud-item" style="background: rgba(0,0,0,0.25); border: 1px solid #1f2c27; border-radius: 6px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    <input type="hidden" name="pricing_plans[{{ $pIndex }}][id]" value="{{ $plan['id'] ?? '' }}" />

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div class="field">
                            <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Nombre del Plan:</label>
                            <input type="text" name="pricing_plans[{{ $pIndex }}][title]" value="{{ $plan['title'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                        </div>
                        <div class="field">
                            <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Precio Visible:</label>
                            <input type="text" name="pricing_plans[{{ $pIndex }}][price]" value="{{ $plan['price'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                        </div>
                        <div class="field">
                            <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Período / Formato:</label>
                            <input type="text" name="pricing_plans[{{ $pIndex }}][period]" value="{{ $plan['period'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                        </div>
                    </div>

                    <div class="field" style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Lema o Subtítulo:</label>
                        <input type="text" name="pricing_plans[{{ $pIndex }}][tagline]" value="{{ $plan['tagline'] ?? '' }}" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;" />
                    </div>

                    <div class="field" style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Descripción:</label>
                        <textarea name="pricing_plans[{{ $pIndex }}][description]" rows="2" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ $plan['description'] ?? '' }}</textarea>
                    </div>

                    <div class="field">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Puntos incluidos (uno por línea):</label>
                        <textarea name="pricing_plans[{{ $pIndex }}][items]" rows="3" style="width: 100%; padding: 0.6rem; border-radius: 4px; background: #0c1210; border: 1px solid #23312c; color: #fff;">{{ is_array($plan['items'] ?? null) ? implode("\n", $plan['items']) : ($plan['items'] ?? '') }}</textarea>
                    </div>
                </div>
            @endforeach
        </fieldset>

        <div class="blog-editor-actions" style="margin-top: 2rem;">
            <button type="submit" class="blog-button" style="padding: 0.85rem 2rem; font-weight: 600;">Guardar Cambios de la Tienda</button>
            <a href="{{ route('services.index', ['lang' => app()->getLocale()]) }}" target="_blank" class="blog-link" style="margin-left: 1.5rem;">Ver Tienda Pública ↗</a>
        </div>
    </form>
</section>
