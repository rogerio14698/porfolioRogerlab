<section class="seccionAboutMe">
    {{--Aqui va la seccion de conociminetos --}}
    @include('components.conocimientos')

    {{-- Esta sección la tengo que dar una vuelta ver como estructuro esto. --}}
    <h2 data-i18n="about.methodology.title">¿Cuál es mi metodología de trabajo?</h2>
    <p data-i18n="about.methodology.body_1">
        No me limito a escribir código; me gusta entender el "porqué" de cada solución.
        Intento seguir buenas prácticas como el desarrollo de código limpio (Clean Code)
        y me enfoco en crear soluciones que sean escalables y fáciles de mantener.
    </p>
    <p data-i18n="about.methodology.body_2">
        Creo firmemente en la documentación y en el control de versiones,
        por lo que verás que mis repositorios mantengo una estructura con los commits organizada y clara.
    </p>
    <br>
    <h2 data-i18n="about.specialization.title">¿En qué me estoy especializando ahora?</h2>
    <p data-i18n="about.specialization.body_1">
        Ahora estoy aprofundizando en Laravel, quiero empezar a trabajar con el e-commerce de Laravel
        y con Laravel Spark. También me está llamando la atención el mundo del hacking ético y la seguridad.

        Por otro lado, escapando de la programación web, me esta interesando el mundo de la seguridad en RFID, NFC y hadware hacking de forma 
        práctica, técnica y aplicable.
    </p>
    <p data-i18n="about.specialization.body_2">
        Mi objetivo a corto plazo es dominar el despliegue de aplicaciones en la nube, aprofundiar en Laravel 
        Y buscar colaboraciónes en proyectos que me parezcan interesantes.
    </p>

{{--     <h2 data-i18n="about.repository.title">¿Puedo usar tus códigos del repositorio?</h2>
    <p data-i18n="about.repository.body_1">
        Claro, son proyectos funcionales,
        al principio imponen respecto pero una vez puesto ya los puedes manejar
    </p>
    
     @include('components.projects.pdf')
     
     --}}
    
   
    
</section>