<nav class="nav">
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-list" aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>

    @if (request()->routeIs('services.*') || ($section ?? '') === 'servicesStore')
        {{-- Navegador Específico para la Tienda y Estudio de Servicios Freelance --}}
        <ul id="nav-list" class="nav-list-services">
            <li><a href="{{ route('welcome', ['lang' => app()->getLocale()]) }}">{{ __('services.nav_portal') }}</a></li>
            <li><a href="{{ route('services.index', ['lang' => app()->getLocale()]) }}" aria-current="page">{{ __('services.nav_services') }}</a></li>
            <li><a href="#catalog-heading">{{ __('services.nav_solutions') }}</a></li>
            <li><a href="#mantenimiento-web">{{ __('services.nav_maintenance') }}</a></li>
            <li><a href="#plans-heading">{{ __('services.nav_pricing') }}</a></li>
            <li><a href="#contacto-servicios">{{ __('services.nav_quote') }}</a></li>
            <li><a href="{{ route('home', ['lang' => app()->getLocale()]) }}" class="nav-switch-portfolio">{{ __('services.nav_to_portfolio') }}</a></li>
        </ul>
    @else
        {{-- Navegador Exclusivo para el Portfolio y Secciones del Perfil --}}
        <ul id="nav-list" class="nav-list-portfolio">
            <li><a href="{{ route('welcome', ['lang' => app()->getLocale()]) }}">{{ __('services.nav_portal') }}</a></li>
            <li><a href="{{ route('home', ['lang' => app()->getLocale()]) }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.home">Inicio</a></li>
            <li><a href="{{ route('projects', ['lang' => app()->getLocale()]) }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.projects">Proyectos</a></li>
            <li><a href="{{ route('about', ['lang' => app()->getLocale()]) }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.about">Sobre mí</a></li>
            <li><a href="{{ route('mi-periodo-practicas') }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.fct">Prácticas FCT</a></li>
            <li><a href="{{ route('contact') }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.contact">Contacto</a></li>
            <li><a href="{{ route('blog', ['lang' => app()->getLocale()]) }}" data-i18n="nav.blog">Blog</a></li>
            <li><a href="{{ route('services.index', ['lang' => app()->getLocale()]) }}" class="nav-switch-services">{{ __('services.nav_to_services') }}</a></li>
        </ul>
    @endif

    <div class="sectionLanguageBar">
        @include('components.secltLanguage')
    </div>
</nav>