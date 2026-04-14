@extends('components.app')

@section('title', 'Inicio')

@section('nav')
    @include('components.nav')
@endsection

@section('content')
    <section id="landing" class="landing">
        <h1>Hola, soy Roger</h1>
        <p>Soy un desarollador web junior full stack <br>A menudo subo contenido a mi blog sobre las diferentes tecnologías
            web que utilizo y las experiencias que tengo en proyectos</p>
    </section>

    <section id="publications" class="publications">
        <h2>Publicaciones</h2>
        <p>Aquí puedes ver algunas de mis publicaciones más recientes:</p>

        <div class="postMainCard">
            <div class="card">
                <h3>Publicación 1</h3>
                <p>Descripción breve de la publicación 1.</p>
                <a href="#">Leer más</a>
            </div>
            <div class="card">
                <h3>Publicación 2</h3>
                <p>Descripción breve de la publicación 2.</p>
                <a href="#">Leer más</a>
            </div>
        </div>
    </section>

    <section id="projects" class="projects">
        <h2>Proyectos</h2>
        <p>Aquí puedes ver algunos de mis proyectos más recientes:</p>
        <div class="projectMainCard">
            <div class="cardProject">
                <h3>Proyecto 1</h3>
                <p>Descripción breve del proyecto 1.</p>
                <a href="#">Ver proyecto</a>
            </div>
            <div class="cardProject">
                <h3>Proyecto 2</h3>
                <p>Descripción breve del proyecto 2.</p>
                <a href="#">Ver proyecto</a>
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <h2>Sobre mí</h2>
        <p>Soy un apasionado del desarrollo web con experiencia en HTML, CSS, JavaScript y frameworks como Laravel. Me
            encanta aprender nuevas tecnologías y compartir mis conocimientos a través de mi blog.</p>
    </section>

    <section id="contact" class="contact">
        <h2>Contacto</h2>
        <p>Si deseas ponerte en contacto conmigo, puedes enviarme un correo electrónico a <a href="mailto:tuemail@example.com">tuemail@example.com</a>.</p>
    </section>

    @include('components.footer')

@endsection