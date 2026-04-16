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
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&family=Poiret+One&display=swap" rel="stylesheet">
    <!--Enlace a la carpeta de public/css -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
    <canvas id="mainShaderBg" aria-hidden="true"></canvas>
    <div class="mainContent contenedor">
        @yield('content')
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
