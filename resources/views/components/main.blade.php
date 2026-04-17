<main class="contenedor contenidoMain">
    @include('components.nav')
    @include('components.aside')
    @include('components.sectionContent', [
        'section' => $section,
        'pageTitle' => $pageTitle ?? 'Inicio',
    ])

</main>