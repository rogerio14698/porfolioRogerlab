<main class="contenedor contenidoMain">
    {{--     @include('components.nav')--}}
    @include('components.aside')
    @include('components.sectionContent', [
        'section' => $section,
        'pageTitle' => $pageTitle ?? 'RogerLab | Desarrollador Full Stack titulado en DAW',
        'pageMetaDescription' => $pageMetaDescription ??
        'Portfolio de Rogério Lucas, desarrollador Full Stack titulado en DAW. Proyectos con Laravel, PHP, JavaScript, bases de datos, Docker y AWS orientados a código mantenible y trabajo en equipo.',
    ])
</main>