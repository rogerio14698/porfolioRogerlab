<div id="dynamic-section" data-section="{{ $section }}" data-page-title="{{ $pageTitle ?? 'Inicio' }}">
    @if ($section === 'home')
        @include('components.textoAbout')
    @elseif ($section === 'about')
        @include('components.about')
    @elseif ($section === 'projects')
        @include('components.projects')
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