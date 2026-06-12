<section class="hero">
    {{-- columna izquierda foto o avatar --}}
    <div class="heroMedia">
        <img src="{{ asset('img/cv-foto.jpeg') }}" alt="Foto-de-Rogerio-Lucas" class="heroFoto">
        <span class="heroName">Desarrollador Full Stack . Titulado en DAW</span>
        <h1> Construyo aplicaciones web estables, escalables y fáciles de mantener</h1>

        {{-- Columna derecha contenido --}}

        {{-- CTAs --}}
        <div class="heroeActions">
            <a href="{{ route('projects') }}" class="btn btn-primary"> Ver Proyectos </a>
            <a href="{{ route('contact') }}" class="btn btn-secondary"> Hablemos</a>
            <a href="{{ route('pdf-cv.english') }}" target="_blank" rel="noopener noreferrer"
                class="contactPdfLink">Cv-English</a>
            <a href="{{ route('pdf-cv.spanish') }}" target="_blank" rel="noopener noreferrer"
                class="contactPdfLink">Cv-Spanish</a>
        </div>

        {{-- Stack principal --}}
        <div class="heroStack">
            <span> PHP / Laravel </span>
            <span> JavaScript / Typescript </span>
            <span> MySQL / PostgreSQL </span>
            <span> Git</span>
            <span> Docker </span>
        </div>

    </div>

    <div class="textoAbout">
        <p data-i18n="home.intro.body.part1">
            Hola, soy Rogério Lucas. Me dedico al desarrollo Full Stack con un enfoque muy claro: picar código
            limpio,
            estructurado y que resuelva problemas reales sin complicar las cosas. Me muevo cómodamente en todo el
            ciclo
            de
            una aplicación, desde diseñar bases de datos y refactorizar lógica en el backend con Laravel, hasta
            optimizar el
            rendimiento en el frontend o pelearme con la configuración de contenedores en Docker. No busco
            simplemente
            que
            las cosas funcionen; me importa que sean estables, escalables y fáciles de mantener en producción.
        </p>
        <br>
        <br>
        <p data-i18n="home.intro.body.part2">
            Acabo de terminar mi formación superior en DAW y de foguearme en entornos reales gestionando desde
            despliegues en AWS
            hasta interacciones complejas con bases de datos. Si buscas a alguien que sepa analizar código heredado,
            solucionar bugs sin romper nada por el camino y aportar valor al equipo desde el primer día, echa un
            vistazo
            a
            mis proyectos o hablemos.
        </p>
    </div>




</section>
