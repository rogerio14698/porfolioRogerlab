<section class="seccionAboutMe">
    <h2 data-i18n="about.learning.title">¿Cómo aprendí a desarrollar?</h2>
    <p data-i18n="about.learning.body_1">
        Desde siempre me ha llamado la atención este mundo, y siempre he trasteado en foros y videos por internet y
        haciendo pequeños proyectos
        personales que eran más que nada pruebas.
    </p>
    <p data-i18n="about.learning.body_2">
        Durante mis practicas participe en proyectos reales dentro de empresa, colaborando en tareas de desarrollo,
        revision de flujos y mejora de estructuras internas, lo que me ayudo a trabajar con mas criterio tecnico,
        organizacion y enfoque profesional.
    </p>
    <p data-i18n="about.learning.body_3">
        Después quise aprofundizar y empecé a hacer cursos en Udemy y
        posteriormente el grado en Desarrollo de Aplicaciones Web.
    </p>
    <button type="button" data-pdf-url="{{ asset('documentacion/Informe%20de%20Seguimiento%20de%20Pr%C3%A1cticas%20en%20Empresa%20(FCT).pdf') }}" onclick="window.open(this.dataset.pdfUrl, '_blank', 'noopener,noreferrer')"><span data-i18n="about.learning.button">Ver informe de practicas</span> <span>&rarr;</span></button>
    <br>
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
    @include('components.btnEnlaceRepositorio')
</section>