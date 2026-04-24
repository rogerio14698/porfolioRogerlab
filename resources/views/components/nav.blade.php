<nav class="nav">
    <ul>
        <li><a href="{{ route('home') }}" data-partial-nav data-i18n="nav.home">Inicio</a></li>
        <li><a href="{{ route('about') }}" data-partial-nav data-i18n="nav.about">Sobre mi</a></li>
        <li><a href="{{ route('articles') }}" data-partial-nav data-i18n="nav.articles">Articulos</a></li>
        <li><a href="{{ route('projects') }}" data-partial-nav data-i18n="nav.projects">Proyectos</a></li>
        <li><a href="{{ route('juegos') }}" data-partial-nav data-i18n="nav.juegos">Juegos JavaScript</a></li>
        <li><a href="{{ route('contact') }}" data-partial-nav data-i18n="nav.contact">Contacto</a></li>
    </ul>
    <div class="sectionLanguageBar">
        @include('components.secltLanguage')
    </div>
</nav>