<div id="dynamic-section" data-section="{{ $section }}"
    data-page-title="{{ $pageTitle ?? 'RogerLab | Desarrollador Full Stack titulado en DAW' }}"
    data-meta-description="{{ $pageMetaDescription ?? 'Portfolio de Rogério Lucas, desarrollador Full Stack titulado en DAW. Proyectos con Laravel, PHP, JavaScript, bases de datos, Docker y AWS orientados a código mantenible y trabajo en equipo.' }}">
    @if ($section === 'home')
        @include('components.textoAbout')
    @elseif ($section === 'about')
        @include('components.about')
    @elseif ($section === 'miPeriodoPracticas')
        @include('components.miPeriodoPracticas')
    @elseif ($section === 'articles')
        @include('components.articles')
    @elseif ($section === 'projects')
        @include('components.projects')
    @elseif ($section === 'juegos')
        @include('components.juegos')
    @elseif ($section === 'ahorcado')
        @include('components.games.ahorcado.juegoAhorcado')
    @elseif ($section === 'contact')
        @include('components.contact')
        {{--Esto ya no es el navegador, son las diferentes secciones de uso de la web --}}
        {{--Tambien renderizan en el contenido principal --}}
    @elseif ($section === 'privacyPolicy')
        @include('components.privacyPolicy')
    @elseif ($section === 'termsOfService')
        @include('components.termsOfService')
    @elseif ($section === 'cookiesPrivacy')
        @include('components.cookiesPrivacy')
    @else
        @include('components.notFound')
    @endif
</div> 