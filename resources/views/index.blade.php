@extends('components.app')

@section('title', 'Inicio')

@section('nav')
    @include('components.nav')
@endsection

@section('content')

    <!-- Theme toggle vertical buttons -->
    <div class="themeToggle">
        <button class="themeBtn active" data-theme="dark">
            <span class="themeBtnLabel">Dark</span>
            <span class="themeBtnIndicator"></span>
        </button>
        <button class="themeBtn" data-theme="light">
            <span class="themeBtnLabel">Light</span>
            <span class="themeBtnIndicator"></span>
        </button>
    </div>

    <nav class="navInner">
        <div class="navText ">
            <h1>Rogerio Lucas</h1>
            <p>Full Stack Web developer</p>
        </div>
        <ul class="navLinks">
            <li><a href="#projects">Projects</a></li>
            <li><a href="#info">Info</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>


    <section id="landing" class="textoLanding">
        <p>I enjoy web development because it allows me to transform ideas into practical solutions,
            and my goal is to deliver agile, effective, and high-quality work to every challenge that arises.
            I relish analyzing projects, streamlining what isn't working, improving existing systems, and ensuring
            things are clearer, more stable, and easier to maintain from day one.</p>

    </section>
@endsection