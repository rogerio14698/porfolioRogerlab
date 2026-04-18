<main class="contenedor contenidoMain">
    @include('components.nav')
    @include('components.aside')
    @include('components.sectionContent', [
        'section' => $section,
        'pageTitle' => $pageTitle ?? ('RogerLab | Desarrollador Web Freelance en ' . config('seo.city')),
        'pageMetaDescription' => $pageMetaDescription ?? ('Desarrollo web profesional en ' . config('seo.city') . ' y ' . config('seo.region') . '. Especialista en paginas web, landing pages y aplicaciones web a medida para negocios.'),
    ])

</main>