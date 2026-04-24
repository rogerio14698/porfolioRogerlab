<div id="dynamic-section" data-section="{{ $section }}"
    data-page-title="{{ $pageTitle ?? ('RogerLab | Desarrollador Web Freelance en ' . config('seo.city')) }}"
    data-meta-description="{{ $pageMetaDescription ?? ('Desarrollo web profesional en ' . config('seo.city') . ' y ' . config('seo.region') . '. Especialista en paginas web, landing pages y aplicaciones web a medida para negocios.') }}">
    @if ($section === 'home')
        @include('components.textoAbout')
    @elseif ($section === 'about')
        @include('components.about')
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