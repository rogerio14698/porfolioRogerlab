<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $profile = config('seo.profile');
        $defaultTitle = "{$profile['name']} | {$profile['job_title']} en Gijón";
        $defaultDescription = $profile['description'];
        $defaultOgImage = asset($profile['image']);
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Person',
                    '@id' => "{$profile['portfolio']}#person",
                    'name' => $profile['name'],
                    'jobTitle' => $profile['job_title'],
                    'description' => $profile['description'],
                    'url' => $profile['portfolio'],
                    'image' => $defaultOgImage,
                    'email' => $profile['email'],
                    'telephone' => $profile['telephone'],
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => config('seo.city'),
                        'addressRegion' => config('seo.region'),
                        'addressCountry' => config('seo.country'),
                    ],
                    'sameAs' => [$profile['linkedin'], $profile['github']],
                    'knowsAbout' => isset($skills) ? $skills->map(fn ($skill) => $skill->label())->all() : $profile['skills'],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => "{$profile['portfolio']}#website",
                    'name' => 'RogerLab',
                    'url' => $profile['portfolio'],
                    'description' => $profile['description'],
                    'author' => ['@id' => "{$profile['portfolio']}#person"],
                ],
            ],
        ];
    @endphp
    <title>@yield('title', $defaultTitle)</title>
    <meta name="description" content="@yield('meta_description', $defaultDescription)">
    @hasSection('meta_keywords')
        <meta name="keywords" content="@yield('meta_keywords')">
    @endif
    <meta name="author" content="{{ $profile['name'] }}">
    <meta name="robots" content="@yield('robots_meta', 'index,follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    @foreach ($hreflangLinks ?? [] as $lang => $href)
        <link rel="alternate" hreflang="{{ $lang }}" href="{{ $href }}">
    @endforeach
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="RogerLab">
    <meta property="og:locale" content="{{ ['es' => 'es_ES', 'en' => 'en_GB', 'pt' => 'pt_PT'][app()->getLocale()] ?? 'es_ES' }}">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', $defaultTitle)">
    <meta property="og:description" content="@yield('og_description', $defaultDescription)">
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">
    @if (isset($ogImageWidth, $ogImageHeight))
        <meta property="og:image:width" content="{{ $ogImageWidth }}">
        <meta property="og:image:height" content="{{ $ogImageHeight }}">
    @endif
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
            {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
        </script>
    @endif

    <link rel="preload" href="{{ asset('fonts/big-shoulders-latin-600-v4.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('fonts/public-sans-latin-v21.woff2') }}" as="font" type="font/woff2" crossorigin>
    <!--Enlace a la carpeta de public/css -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <!--Fin del enlace a la carpeta de public/css -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicon/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">
</head>

<body data-theme="dark">
    <canvas id="mainShaderBg" aria-hidden="true"></canvas>
    <div class="mainContent contenedor">
        @include('components.header')
        @include('components.nav')
        @yield('content')
        @include('components.footer')
    </div>
    @vite('resources/js/app.ts')
</body>

</html>
