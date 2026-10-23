<nav class="nav">
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-list" aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <ul id="nav-list">
        <li><a href="{{ route('home', ['lang' => app()->getLocale()]) }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.home">Inicio</a></li>
        <li><a href="{{ route('projects', ['lang' => app()->getLocale()]) }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.projects">Proyectos</a></li>
        <li><a href="{{ route('about', ['lang' => app()->getLocale()]) }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.about">Sobre mí</a></li>
        <li><a href="{{ route('mi-periodo-practicas') }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.fct">Prácticas FCT</a></li>
        <li><a href="{{ route('contact') }}" @unless(request()->routeIs('blog*', 'admin.*', 'login*')) data-partial-nav @endunless data-i18n="nav.contact">Contacto</a></li>
        <li><a href="{{ route('blog', ['lang' => app()->getLocale()]) }}" data-i18n="nav.blog">Blog</a></li>
        {{-- Aqui en un futuro lo pondré si lo necesito, pero como ventana desplegable de proyectos, de momento no --}}
        {{--         <li><a href="{{ route('juegos') }}" data-partial-nav data-i18n="nav.juegos">Juegos JavaScript</a></li>--}}
    </ul>
    <div class="sectionLanguageBar">
        @include('components.secltLanguage')
    </div>
</nav>