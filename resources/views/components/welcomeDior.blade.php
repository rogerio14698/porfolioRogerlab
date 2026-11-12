{{-- 
    Vista: components/welcomeDior.blade.php
    Descripción: Landing dividida estilo Dior (Split-Screen High-End)
    Combina las dos imágenes exclusivas (imgPortfolio y imgFreelance) con hover orgánico interactivo,
    tipografía editorial de lujo y llamadas a la acción claras para guiar al usuario
    entre el Portfolio y el Estudio de Servicios Freelance.
--}}
<section class="dior-split-portal" id="diorPortal" aria-label="Portal de entrada RogerLab">
    {{-- Barra superior flotante minimalista --}}
    <header class="dior-topbar">
        <a href="{{ route('welcome', ['lang' => app()->getLocale()]) }}" class="dior-brand" aria-label="{{ __('services.portal_brand') }}">
            {{ __('services.portal_brand') }}
        </a>
        <div class="dior-topbar-actions">
            @include('components.secltLanguage')
            <a href="{{ route('contact', ['lang' => app()->getLocale()]) }}" class="dior-pill-link">{{ __('services.contact') }}</a>
        </div>
    </header>

    {{-- Contenedor dividido 50/50 con expansión al cursor --}}
    <div class="dior-split-container">
        {{-- Lado 1: Portfolio (imgPortfolio.jpg) --}}
        <article class="dior-split-panel dior-panel-portfolio" id="panelPortfolio" tabindex="0" role="region" aria-label="{{ __('services.portfolio_title') }}">
            <div class="dior-bg-wrapper">
                <img src="{{ asset('img/imgPortfolio.jpg') }}" alt="RogerLab Portfolio" class="dior-bg-image" loading="eager" />
                <div class="dior-overlay"></div>
            </div>

            <div class="dior-content-box">
                <span class="dior-kicker">{{ __('services.portfolio_kicker') }}</span>
                <h1 class="dior-title">{{ __('services.portfolio_title') }}</h1>
                <p class="dior-description">
                    {{ __('services.portfolio_desc') }}
                </p>
                <div class="dior-btn-wrapper">
                    <a href="{{ route('home', ['lang' => app()->getLocale()]) }}" class="dior-btn dior-btn-primary">
                        <span>{{ __('services.portfolio_cta') }}</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </article>

        {{-- Divisor central con insignia monograma --}}
        <div class="dior-divider" aria-hidden="true">
            <span class="dior-monogram">R_L</span>
        </div>

        {{-- Lado 2: Estudio Freelance y Servicios DAW (imgFreelance.jpg) --}}
        <article class="dior-split-panel dior-panel-freelance" id="panelFreelance" tabindex="0" role="region" aria-label="{{ __('services.services_title') }}">
            <div class="dior-bg-wrapper">
                <img src="{{ asset('img/imgFreelance.jpg') }}" alt="RogerLab Freelance Services" class="dior-bg-image" loading="eager" />
                <div class="dior-overlay"></div>
            </div>

            <div class="dior-content-box">
                <span class="dior-kicker">{{ __('services.services_kicker') }}</span>
                <h2 class="dior-title">{{ __('services.services_title') }}</h2>
                <p class="dior-description">
                    {{ __('services.services_desc') }}
                </p>
                <div class="dior-btn-wrapper">
                    <a href="{{ route('services.index', ['lang' => app()->getLocale()]) }}" class="dior-btn dior-btn-gold">
                        <span>{{ __('services.services_cta') }}</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </article>
    </div>

    {{-- Pie minimalista de la landing con créditos y aviso de calidad --}}
    <footer class="dior-bottom-footer">
        <p>{{ __('services.portal_footer') }}</p>
    </footer>
</section>
