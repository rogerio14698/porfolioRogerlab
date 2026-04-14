<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>


    <!--Carga de font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!--Enlace a la carpeta de public/css -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">



</head>

<body class="container">
    @yield('nav')
    <main class="mainContent">
        @yield('content')
    </main>
    <footer class="footerContent">
        @yield('footer')
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>