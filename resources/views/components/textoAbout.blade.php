<section class="hero">
    <div class="heroMedia">
        <div class="heroCopy">
            <h1>{{ __('portfolio.identity_name') }}</h1>
            <p class="heroHeadline">{{ __('portfolio.identity_role') }}</p>
            <div class="heroeActions">
                <a href="{{ route('pdf-cv.english') }}" target="_blank" rel="noopener noreferrer" class="contactPdfLink"
                    data-i18n="hero.cta.cv_en">CV English</a>
                <a href="{{ route('pdf-cv.spanish') }}" target="_blank" rel="noopener noreferrer" class="contactPdfLink"
                    data-i18n="hero.cta.cv_es">CV Español</a>
            </div>

            <div class="heroStack">
                @foreach ($skills as $skill)
                    <span>{{ $skill->label() }}</span>
                @endforeach
            </div>

        </div>
        <img src="{{ asset('img/cv-foto.jpeg') }}"
            srcset="{{ asset('img/cv-foto-480-v1.webp') }} 480w, {{ asset('img/cv-foto-960-v1.webp') }} 960w"
            sizes="(min-width: 1480px) 534px, (min-width: 768px) 38vw, 93vw"
            alt="Rogerio Lucas Viana, desarrollador web Full Stack Junior especializado en Laravel y JavaScript"
            class="heroFoto" width="1170" height="2080" fetchpriority="high">
    </div>

    @include('portfolio.discover')

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
