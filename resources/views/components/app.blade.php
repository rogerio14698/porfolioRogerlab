<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $defaultTitle = 'RogerLab | Desarrollador Web Freelance en ' . config('seo.city');
        $defaultDescription = 'Desarrollo web a medida en ' . config('seo.city') . ' y ' . config('seo.region') . '. Especialista en aplicaciones web, rendimiento y optimizacion de conversion para negocios.';
        $defaultOgImage = asset('img/profileIMG.png');
    @endphp
    <title>@yield('title', 'RogerLab | Desarrollador Web Freelance en ' . config('seo.city'))</title>
    <meta name="description" content="@yield('meta_description', 'Desarrollo web a medida en ' . config('seo.city') . ' y ' . config('seo.region') . '. Especialista en aplicaciones web, rendimiento y optimizacion de conversion para negocios.')">
    <meta name="robots" content="@yield('robots_meta', 'index,follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    @foreach (($hreflangLinks ?? []) as $lang => $href)
        <link rel="alternate" hreflang="{{ $lang }}" href="{{ $href }}">
    @endforeach
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', $defaultTitle)">
    <meta property="og:description" content="@yield('og_description', $defaultDescription)">
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:url" content="@yield('twitter_url', url()->current())">
    <meta name="twitter:title" content="@yield('twitter_title', $defaultTitle)">
    <meta name="twitter:description" content="@yield('twitter_description', $defaultDescription)">
    <meta name="twitter:image" content="@yield('twitter_image', $defaultOgImage)">
    <meta name="theme-color" content="#222222">
    @hasSection('schema_json_ld')
        @yield('schema_json_ld')
    @else
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Organization",
                "name": "{{ config('app.name') }}",
                "url": "{{ url('/') }}",
                "logo": "{{ asset('img/logoPortfolio.png') }}"
            }
        </script>
    @endif

    <!--Carga de font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&family=Poiret+One&display=swap"rel="stylesheet">
    <!-- google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira+Stencil:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!--Enlace a la carpeta de public/css -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">
</head>

<body data-theme="dark">
    <canvas id="mainShaderBg" aria-hidden="true"></canvas>

    <div class="mainContent contenedor">
        @include('components.header')
        @yield('content')

        @include('components.footer')
    </div>
    <script src="{{ asset('js/theme.js') }}" defer></script>
    <script src="{{ asset('js/animaciones.js') }}" defer></script>
    <script src="{{ asset('js/partial-navigation.js') }}" defer></script>
    <script src="{{ asset('js/language-switcher.js') }}" defer></script>
    <script src="{{ asset('js/ahorcado.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>