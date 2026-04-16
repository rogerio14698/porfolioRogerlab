@extends('components.app')

@section('title', 'Inicio')

@section('content')

    <header class="contenedor titulo">
        <h1>Rogerio Lucas</h1>
        <p>Full Stack Junior Developer cambio</p>
    </header>


    <main class="contenedor contenidoMain">
        <nav class="nav">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Projects</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <aside class="asideLeft">
            <button class="themeBtn  active" data-theme="dark">Dark theme <span class="figurabtnDark"></span></button>
            <button class="themeBtn " data-theme="light">Light theme <span class="figurabtnLight"></span></button>
        </aside>
        <section class="textoAbout">
            <p>I enjoy web development because it allows me to transform ideas into practical solutions,
                and my goal is to deliver agile, effective, and high-quality work to every challenge that arises.
                I relish analyzing projects, streamlining what isn't working, improving existing systems, and ensuring
                things are clearer, more stable, and easier to maintain from day one.
            </p>
        </section>

    </main>

@endsection
