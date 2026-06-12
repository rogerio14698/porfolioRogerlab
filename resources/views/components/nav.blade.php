<nav class="nav">
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-list" aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <ul id="nav-list">
        <li><a href="{{ route('home') }}" data-partial-nav data-i18n="nav.home">Inicio</a></li>
        <li><a href="{{ route('about') }}" data-partial-nav data-i18n="nav.about">Skills</a></li>
        <li><a href="{{ route('mi-periodo-practicas') }}" data-partial-nav data-i18n="nav.fct">Practicas FCT</a></li>
        <li><a href="{{ route('projects') }}" data-partial-nav data-i18n="nav.projects">Proyectos</a></li>
        <li><a href="{{ route('contact') }}" data-partial-nav data-i18n="nav.contact">Contacto</a></li>
        <li><a href="{{ route('articles') }}" data-partial-nav data-i18n="nav.articles">Blog</a></li>
        {{-- Aqui en un futuro lo pondré si lo necesito, pero como ventana desplegable de proyectos, de momento no --}}
        {{--         <li><a href="{{ route('juegos') }}" data-partial-nav data-i18n="nav.juegos">Juegos JavaScript</a></li>--}}
    </ul>
    <div class="sectionLanguageBar">
        @include('components.secltLanguage')
    </div>
</nav>