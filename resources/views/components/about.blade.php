<section class="seccionAboutMe">
    {{--Aqui va la seccion de conociminetos --}}
    @include('components.conocimientos')

    {{-- Esta sección la tengo que dar una vuelta ver como estructuro esto. --}}
    <h2 data-i18n="about.methodology.title">¿Cuál es mi metodología de trabajo?</h2>
    <p data-i18n="about.methodology.body_1">
        No me limito a escribir código. Primero intento entender el problema, después propongo
        una solución simple y finalmente reviso si esa solución va a ser mantenible por otras personas además de mí.
    </p>
    <p data-i18n="about.methodology.body_2">
        Trabajo con control de versiones, procuro documentar las decisiones importantes y doy valor
        a un código que se pueda leer, revisar y extender sin fricción innecesaria.
    </p>
    <br>
    <h2 data-i18n="about.specialization.title">¿En qué me estoy especializando ahora?</h2>
    <p data-i18n="about.specialization.body_1">
        Ahora mismo estoy profundizando en Laravel, en la calidad del backend PHP y en la parte
        operativa que rodea a una aplicación web: despliegue, estructura del proyecto,
        trazabilidad de errores y mantenimiento.
    </p>
    <p data-i18n="about.specialization.body_2">
        A corto plazo quiero seguir ganando experiencia en empresa, fortalecer mis bases en
        arquitectura y testing y participar en equipos donde pueda aprender de desarrolladores con más recorrido.
    </p>

{{--     <h2 data-i18n="about.repository.title">¿Puedo usar tus códigos del repositorio?</h2>
    <p data-i18n="about.repository.body_1">
        Claro, son proyectos funcionales,
        al principio imponen respecto pero una vez puesto ya los puedes manejar
    </p>
    
     @include('components.projects.pdf')
     
     --}}
    
   
    
</section>