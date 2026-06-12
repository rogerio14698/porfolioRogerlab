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
        por lo que verás que mis repositorios mantienen una estructura clara y organizada.
    </p>
    <br>
    <h2 data-i18n="about.specialization.title">¿En qué me estoy especializando ahora?</h2>
    <p data-i18n="about.specialization.body_1">
        El aprendizaje en este sector nunca termina. Actualmente, estoy profundizando
        en tecnologías como React y Node.js para perfeccionar mi perfil Full Stack.
    </p>
    <p data-i18n="about.specialization.body_2">
        Mi objetivo a corto plazo es dominar el despliegue de aplicaciones en la nube
        y seguir colaborando en proyectos de código abierto que aporten valor a la comunidad.
    </p>
    <h2 data-i18n="about.repository.title">¿Puedo usar tus códigos del repositorio?</h2>
    <p data-i18n="about.repository.body_1">
        Claro, son proyectos funcionales,
        al principio imponen respecto pero una vez puesto ya los puedes manejar
    </p>
    
    @include('components.projects.pdf')
    
</section>