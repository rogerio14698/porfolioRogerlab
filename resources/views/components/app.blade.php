<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>

    <!--Carga de font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap" rel="stylesheet">
    <!--Enlace a la carpeta de public/css -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body class="layout">
    <canvas id="mainShaderBg" aria-hidden="false"></canvas>
    @yield('nav')
    <main class="mainContent">
        @yield('content')
    </main>

    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>