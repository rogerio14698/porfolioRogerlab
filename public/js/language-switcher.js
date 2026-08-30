(function () {
    'use strict';

    var STORAGE_KEY = 'rogerlab.language';
    var DEFAULT_LANGUAGE = 'es';
    var SUPPORTED_LANGUAGES = ['es', 'en', 'pt'];
    var SECTION_SELECTOR = '#dynamic-section';

    var translations = {
        es: {
            'nav.home': 'Inicio',
            'nav.about': 'Sobre mí',
            'nav.fct': 'Prácticas FCT',
            'nav.articles': 'Blog',
            'nav.projects': 'Proyectos',
            'nav.juegos': 'Juegos JavaScript',
            'nav.contact': 'Contacto',
            'hero.role': 'Desarrollador Full Stack | Titulado en DAW',
            'hero.title': 'Busco incorporarme a un equipo donde construir software web mantenible',
            'hero.cta.projects': 'Ver proyectos',
            'hero.cta.contact': 'Contactar',
            'hero.cta.cv_en': 'CV English',
            'hero.cta.cv_es': 'CV Español',
            'conocimientos.title.desarrollo': 'Desarrollo Backend y Frontend',
            'conocimientos.title.frameworks': 'Frameworks y Librerías',
            'conocimientos.title.datos': 'Bases de Datos y Servidores',
            'conocimientos.title.herramientas': 'Herramientas y DevOps',
            'conocimientos.title.cloud': 'Cloud Computing',
            'conocimientos.title.entornos': 'Entornos de Desarrollo y OS',
            'pdf.title': 'Currículum',
            'practicas.modal.title': 'Seguimiento detallado de prácticas:',
            'practicas.modal.open': 'Ver seguimiento',
            'games.back': 'Volver a juegos',
            'games.hangman.card.alt': 'Juego del ahorcado',
            'games.hangman.card.title': 'Juego del ahorcado',
            'games.hangman.card.body_1': 'Este juego del ahorcado pone a prueba tu vocabulario y rapidez mental: debes adivinar la palabra oculta letra por letra antes de completar el dibujo. Incluye una interfaz clara, feedback inmediato en cada intento y una experiencia pensada para jugar de forma fluida desde cualquier dispositivo.',
            'games.hangman.card.body_2': 'Lo desarrollé como parte de mi portafolio para demostrar lógica de programación, manejo del estado del juego y organización del código en componentes reutilizables. El objetivo fue combinar funcionalidad, rendimiento y una presentación visual consistente con el resto del sitio.',
            'games.hangman.card.cta': 'Jugar al ahorcado',
            'games.hangman.input_placeholder': 'Escribe una letra',
            'games.hangman.try': 'Intentar',
            'games.hangman.restart': 'Reiniciar juego',
            'games.dungeon.card.alt': 'Mazmorra impía',
            'games.dungeon.card.title': 'Mazmorra impía',
            'games.dungeon.card.cta': 'Jugar a Mazmorra impía',
            //Este texto de abajo es la animacion//
            'home.intro.body.part1': 'Hola, soy Rogério Lucas. Soy desarrollador Full Stack y trabajo cómodo entre backend y frontend, con especial interés en Laravel, PHP y JavaScript. Me centro en escribir código claro, entender el problema antes de plantear una solución y dejar una base que el equipo pueda mantener sin fricción. He trabajado con bases de datos, refactorización de lógica existente, integraciones y despliegues sobre Linux con Docker y AWS.',
            'home.intro.body.part2': 'He finalizado el Grado Superior de Desarrollo de Aplicaciones Web (DAW), una titulación oficial homologada en España, y ahora mi objetivo es incorporarme a una empresa donde seguir creciendo junto a un equipo técnico. Me interesa aportar desde el primer día en mantenimiento evolutivo, resolución de incidencias, mejora de rendimiento y desarrollo de nuevas funcionalidades. En este portfolio enseño proyectos y prácticas que reflejan cómo trabajo.',

            'articles.visits.title': 'Qué valoro en un equipo de desarrollo para mi siguiente etapa',
            'articles.visits.intro': 'Al buscar una oportunidad estable en empresa, estos son los factores que más peso tienen para mí:',
            'articles.visits.item_1': 'Buenas prácticas reales: revisiones de código, ramas claras y criterios técnicos consistentes.',
            'articles.visits.item_2': 'Contexto de producto: entender para qué existe cada funcionalidad ayuda a tomar mejores decisiones.',
            'articles.visits.item_3': 'Aprendizaje acompañado: feedback directo, documentación útil y compañeros con los que contrastar soluciones.',
            'articles.visits.item_4': 'Responsabilidad progresiva: empezar aportando en tareas concretas y ganar autonomía con resultados.',
            'articles.pricing.title': 'Qué puedo aportar como perfil junior tras terminar DAW',
            'articles.pricing.intro': 'Mi valor no pasa por vender humo ni por prometer experiencia que no tengo. Lo que sí puedo aportar hoy es una base sólida en estas áreas:',
            'articles.pricing.item_1': 'Backend web: Laravel, PHP, routing, validación, bases de datos relacionales y mantenimiento de lógica existente.',
            'articles.pricing.item_2': 'Frontend funcional: JavaScript, maquetación cuidada, interacción de interfaz y atención al rendimiento.',
            'articles.pricing.item_3': 'Entorno de trabajo: Git, Docker, Linux, despliegues y capacidad para moverme en código heredado con criterio.',
            'articles.pricing.note': 'A esto sumo una actitud directa: documentar lo importante, preguntar cuando falta contexto y priorizar soluciones mantenibles.',
            'articles.landing.title': 'Proyecto académico vs proyecto real: qué cambia',
            'articles.landing.head_1': 'Contexto',
            'articles.landing.head_2': 'Qué suele pasar',
            'articles.landing.head_3': 'Qué exige de mí',
            'articles.landing.row_1_col_1': 'Proyecto académico',
            'articles.landing.row_1_col_2': 'El alcance está más acotado y los requisitos suelen ser estables.',
            'articles.landing.row_1_col_3': 'Orden, fundamentos técnicos y capacidad para entregar una solución completa.',
            'articles.landing.row_2_col_1': 'Proyecto real',
            'articles.landing.row_2_col_2': 'Hay código heredado, prioridades cambiantes y decisiones condicionadas por negocio y tiempo.',
            'articles.landing.row_2_col_3': 'Adaptación, comunicación y criterio para mejorar sin romper lo que ya funciona.',
            'articles.hiring.title': 'Aprendizajes al entrar en una aplicación existente',
            'articles.hiring.intro': 'Trabajar sobre software ya construido me ha dejado claras varias ideas:',
            'articles.hiring.item_1': 'Antes de tocar nada, hay que entender el flujo actual y el impacto real del cambio.',
            'articles.hiring.item_2': 'Los nombres, convenciones y pequeños detalles importan mucho cuando varias personas mantienen la misma base.',
            'articles.hiring.item_3': 'Resolver una incidencia rápido está bien; dejar el sistema más claro después es mejor.',
            'articles.hiring.item_4': 'La comunicación con el equipo evita retrabajo y suele ser tan importante como la propia solución técnica.',
            'articles.scaling.title': 'Menos picar código, más soluciones que escalan',
            'articles.scaling.intro': 'Cuanto más aprendo, más claro veo que escalar no consiste en producir más líneas de código, sino en resolver mejor los problemas adecuados.',
            'articles.scaling.item_1': 'Empieza por el problema: antes de programar, aclara objetivo, restricciones y criterio de éxito.',
            'articles.scaling.item_2': 'Diseña arquitectura simple: una solución clara suele rendir mejor que una brillante pero difícil de mantener.',
            'articles.scaling.item_3': 'Automatiza lo repetible: tests, validaciones y procesos previsibles reducen errores evitables.',
            'articles.scaling.item_4': 'Mide antes de optimizar: el rendimiento útil se mejora con datos, no con intuiciones.',
            'articles.scaling.item_5': 'Piensa en equipo: documentación, legibilidad y convenciones ahorran tiempo a todos.',
            'articles.scaling.note': 'Ese es el tipo de desarrollo en el que quiero seguir creciendo: menos ruido y más impacto real.',
            'privacy.title': 'Política de privacidad',
            'privacy.intro': 'Esta política de privacidad explica qué información puede recogerse cuando utilizas este portfolio, cómo se usa y cómo se protege.',
            'privacy.section_1.title': '1. Información que recogemos',
            'privacy.section_1.body': 'Dependiendo de cómo interactúes con la web, podemos recoger datos personales limitados que se facilitan voluntariamente a través de formularios o comunicaciones.',
            'privacy.section_1.item_1': 'Nombre o identificador profesional.',
            'privacy.section_1.item_2': 'Datos de contacto, como una dirección de correo electrónico.',
            'privacy.section_1.item_3': 'Información de uso relacionada con preferencias del sitio o analítica.',
            'privacy.section_1.item_4': 'Cualquier mensaje enviado a través del formulario de contacto.',
            'privacy.section_2.title': '2. Cómo se usa la información',
            'privacy.section_2.body': 'La información se utiliza únicamente para fines directamente relacionados con el funcionamiento y la mejora de la experiencia del portfolio.',
            'privacy.section_2.item_1': 'Responder a mensajes o consultas profesionales.',
            'privacy.section_2.item_2': 'Mejorar el contenido, la usabilidad y el rendimiento del sitio.',
            'privacy.section_2.item_3': 'Revisar analítica anonimizada o datos de preferencias.',
            'privacy.section_2.item_4': 'Mantener registros internos cuando sea necesario.',
            'privacy.section_3.title': '3. Protección de datos',
            'privacy.section_3.body': 'Se aplican medidas técnicas y organizativas razonables para reducir el riesgo de acceso no autorizado, uso indebido o divulgación de cualquier dato compartido a través de esta web.',
            'privacy.section_4.title': '4. Servicios y enlaces externos',
            'privacy.section_4.body': 'Este sitio puede enlazar a servicios externos como GitHub, LinkedIn o demos en vivo. Esos sitios tienen sus propias prácticas de privacidad y este portfolio no se responsabiliza de cómo terceros gestionan tu información.',
            'privacy.section_5.title': '5. Tus derechos',
            'privacy.section_5.body': 'Si has compartido información personal y quieres solicitar aclaración, corrección o eliminación, puedes hacerlo a través de los canales de contacto publicados en el sitio.',
            'privacy.meta': 'Última actualización: abril de 2026',
            'terms.title': 'Términos del servicio',
            'terms.intro': 'Al acceder a este portfolio, aceptas utilizar su contenido de forma responsable y conforme a las condiciones descritas a continuación.',
            'terms.section_1.title': '1. Uso del contenido',
            'terms.section_1.body': 'Los proyectos, fragmentos de código y diseños mostrados en este portfolio tienen únicamente fines demostrativos. Salvo que se indique explícitamente mediante una licencia abierta o un aviso escrito, la propiedad intelectual pertenece al titular del sitio.',
            'terms.section_1.item_1': 'Puedes revisar el trabajo publicado para referencia personal.',
            'terms.section_1.item_2': 'No puedes extraer, copiar, redistribuir ni comercializar el contenido sin permiso previo por escrito.',
            'terms.section_2.title': '2. Renuncia de garantías',
            'terms.section_2.body': 'La información de esta web se ofrece "tal cual". Aunque el portfolio se mantiene con cuidado, no se garantiza que los materiales estén siempre completos, actualizados, libres de errores o sean adecuados para uso en producción.',
            'terms.section_3.title': '3. Limitación de responsabilidad',
            'terms.section_3.body': 'En ningún caso el titular del sitio será responsable de daños directos, indirectos, incidentales o consecuentes derivados del uso o imposibilidad de uso de la información, ejemplos de código o proyectos mostrados en esta web.',
            'terms.section_4.title': '4. Cookies y seguimiento',
            'terms.section_4.body': 'Este sitio puede usar cookies para mejorar la experiencia, recordar preferencias o recopilar información anónima de tráfico. Al seguir navegando, aceptas este uso de acuerdo con la Política de Privacidad y la Política de Cookies.',
            'terms.section_5.title': '5. Enlaces externos',
            'terms.section_5.body': 'Este sitio puede incluir enlaces a webs de terceros como repositorios, perfiles profesionales o demos. Esos enlaces se ofrecen solo por comodidad y el titular no se responsabiliza de su contenido o disponibilidad.',
            'terms.meta': 'Última actualización: abril de 2026',
            'cookies.title': 'Política de cookies',
            'cookies.meta': 'Última actualización: 17 de abril de 2026',
            'cookies.intro': 'Esta política de cookies explica cómo este portfolio usa cookies y tecnologías similares, por qué se utilizan y qué opciones tienes para controlarlas.',
            'cookies.section_1.title': '1. Qué son las cookies',
            'cookies.section_1.body': 'Las cookies son pequeños archivos de texto almacenados en tu dispositivo cuando visitas una web. Ayudan a que los sitios funcionen correctamente, recuerden preferencias y entiendan cómo interactúan los visitantes con el contenido.',
            'cookies.section_2.title': '2. Cómo se usan las cookies',
            'cookies.section_2.body': 'Este sitio puede usar cookies propias o de terceros para funcionamiento técnico, medición de rendimiento y almacenamiento de preferencias.',
            'cookies.table.head_1': 'Tipo de cookie',
            'cookies.table.head_2': 'Descripción',
            'cookies.table.row_1_col_1': 'Esenciales',
            'cookies.table.row_1_col_2': 'Necesarias para el funcionamiento básico de la web, como la seguridad o la entrega estable de las páginas.',
            'cookies.table.row_2_col_1': 'Analíticas',
            'cookies.table.row_2_col_2': 'Se usan para entender cómo interactúan los visitantes con el sitio y mejorar la calidad del contenido.',
            'cookies.table.row_3_col_1': 'Preferencias',
            'cookies.table.row_3_col_2': 'Recuerdan ajustes como el tema, el idioma u otras preferencias de experiencia.',
            'cookies.section_3.title': '3. Control de cookies',
            'cookies.section_3.body': 'Puedes decidir si aceptas o rechazas cookies desde la configuración de tu navegador. Desactivar algunas cookies puede afectar al funcionamiento correcto de ciertas áreas de la web.',
            'cookies.section_4.title': '4. Cookies de terceros',
            'cookies.section_4.body': 'En algunos casos, servicios externos de confianza como plataformas de analítica pueden colocar cookies para ayudar a medir el tráfico y mejorar la experiencia general.',
            'cookies.section_5.title': '5. Más información',
            'cookies.section_5.body': 'Si necesitas más información sobre el uso de cookies en esta web, puedes ponerte en contacto a través de los canales principales disponibles en el portfolio.',
            'projects.library.alt': 'Logo del proyecto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Diseño y desarrollo',
            'projects.library.body_1': 'Proyecto final de DAW donde diseñé e implementé una aplicación de gestión bibliotecaria con Laravel, PHP, Eloquent ORM y MySQL para cubrir ciclo completo de catálogo, préstamos y devoluciones.',
            'projects.library.body_2': 'Definí el modelo relacional, organicé la arquitectura MVC y apliqué validaciones de negocio para asegurar consistencia de datos y facilitar mantenimiento evolutivo.',
            'projects.content.alt': 'Logo del proyecto Gestor de Contenido',
            'projects.content.title': 'Gestor de Contenido',
            'projects.content.meta': 'Feb. 2026 | Desarrollo',
            'projects.content.body_1': 'Proyecto interno en entorno empresarial orientado a gestión de contenido: trabajé sobre una base Laravel/PHP con MySQL para estabilizar flujos de edición y publicación.',
            'projects.content.body_2': 'Analicé lógica heredada, ajusté reglas de negocio y refiné componentes de interfaz en Blade + JavaScript para reducir fricción operativa en futuras iteraciones del equipo.',
            'projects.juegoRol.alt': 'Logo del proyecto Juego de Rol',
            'projects.juegoRol.title': 'Juego de Rol',
            'projects.juegoRol.meta': 'May. 2026 | Desarrollo y diseño',
            'projects.juegoRol.body_1': 'Videojuego modular en Vanilla JavaScript con separación explícita de dominio (mapa, combate, personajes y estado), orientado a escalabilidad funcional.',
            'projects.juegoRol.body_2': 'Implementé una capa de presentación desacoplada con plantillas HTML y manejo de eventos para permitir nuevas mecánicas sin degradar legibilidad ni mantenibilidad.',
            'projects.time.alt': 'Logo del proyecto Gestor de Fichaje',
            'projects.time.title': 'Gestor de Fichaje',
            'projects.time.meta': 'Ene. 2026 | Desarrollo',
            'projects.time.body_1': 'Aplicación de control horario enfocada en trazabilidad de jornadas e incidencias; colaboré sobre backend PHP/Laravel y persistencia MySQL para asegurar registros fiables.',
            'projects.time.body_2': 'Revisé procesos críticos de negocio, depuré reglas de fichaje y mejoré la capa de interfaz con Blade + JavaScript para acelerar la operación diaria del usuario final.',
            'projects.portfolio.alt': 'Logo del portfolio Roger Lab',
            'projects.portfolio.title': 'Portfolio Web',
            'projects.portfolio.meta': 'Abr. 2026 | Diseño y desarrollo',
            'projects.portfolio.body_1': 'Desarrollé este portfolio como producto full-stack con Laravel, Blade, Vanilla JavaScript, CSS y arquitectura de componentes para presentar proyectos con foco técnico y de negocio.',
            'projects.portfolio.body_2': 'Implementé navegación parcial, i18n ES/EN/PT y formularios con validación para demostrar decisiones de arquitectura orientadas a rendimiento, mantenibilidad y experiencia de usuario.',
            'projects.apipokemon.alt': 'Logo del proyecto API Pokemon',
            'projects.apipokemon.title': 'API Pokemon Pokedex Shiny',
            'projects.apipokemon.meta': 'Jun. 2026 | Desarrollo full stack',
            'projects.apipokemon.body_1': 'Proyecto full-stack de integración REST con Laravel: diseñé endpoints internos, validación de entrada y un servicio de consumo PokeAPI para generar fichas completas por nombre o ID.',
            'projects.apipokemon.body_2': 'Estructuré transformación de datos anidados, renderizado por componentes Blade y filtros de galería en JavaScript para entregar una Pokedex rápida, legible y preparada para escalar funcionalidades.',
            'projects.n8n-linkedin.alt': 'Logo del proyecto n8n LinkedIn',
            'projects.n8n-linkedin.title': 'N8n LinkedIn Workflow Búsqueda Empleo',
            'projects.n8n-linkedin.meta': 'Agosto 2026 | Automatización de Búsqueda Empleo (HTTP)',
            'projects.n8n-linkedin.body_1': 'Proyecto de automatización de búsqueda de empleos en n8n, en el cual hice un flujo de trabajo que realiza búsquedas de empleo en LinkedIn vía Browserless y extrae por código la información necesaria para facilitar la candidatura.',
            'projects.n8n-linkedin.body_2': 'También implementé un filtro de match score para priorizar las ofertas que mejor se ajustan a los datos del CV.',
            'projects.n8n-linkedin.body_3': 'El proyecto integra además las APIs de Google Drive, Google Sheets y Google Docs para almacenar datos y generar cartas de presentación personalizadas para cada oferta, acelerando el proceso sin perder profesionalidad.',
            'projects.n8n-linkedin.preview_alt': 'Captura del proyecto N8n LinkedIn Workflow Búsqueda Empleo',
            'projects.n8n-linkedin.download': 'Descargar flujo de trabajo',

            'about.methodology.title': '¿Cuál es mi metodología de trabajo?',
            'about.methodology.body_1': 'No me limito a escribir código. Primero intento entender el problema, después propongo una solución simple y finalmente reviso si esa solución va a ser mantenible por otras personas además de mí.',
            'about.methodology.body_2': 'Trabajo con control de versiones, procuro documentar las decisiones importantes y doy valor a un código que se pueda leer, revisar y extender sin fricción innecesaria.',
            'about.specialization.title': '¿En qué me estoy especializando ahora?',
            'about.specialization.body_1': 'Ahora mismo estoy profundizando en Laravel, en la calidad del backend PHP y en la parte operativa que rodea a una aplicación web: despliegue, estructura del proyecto, trazabilidad de errores y mantenimiento.',
            'about.specialization.body_2': 'A corto plazo quiero seguir ganando experiencia en empresa, fortalecer mis bases en arquitectura y testing y participar en equipos donde pueda aprender de desarrolladores con más recorrido.',
            'about.repository.title': '¿Se puede revisar mi código del repositorio?',
            'about.repository.body_1': 'Sí. Los repositorios están publicados para enseñar cómo estructuro soluciones, qué nivel tengo ahora mismo y cómo afronto proyectos académicos, personales y de prácticas.',
            'about.repository.button': 'Repositorio',
            'about.website.button': 'Web',
            'contact.title': 'Contacto profesional',
            'contact.form.company': 'Empresa',
            'contact.form.name': 'Nombre',
            'contact.form.subject': 'Asunto',
            'contact.form.email': 'Correo electrónico',
            'contact.form.message': 'Mensaje',
            'contact.form.subject_placeholder': 'Quiero hablar contigo sobre una vacante',
            'contact.form.email_placeholder': 'ejemplo@email.com',
            'contact.form.message_placeholder': 'Cuéntame el puesto, el equipo, el stack o el motivo del contacto y te respondo lo antes posible.',
            'contact.form.notice': 'Antes de que el mensaje llegue al administrador, debes confirmar tu dirección de correo mediante un enlace de verificación.',
            'contact.form.submit': 'Enviar mensaje',
            'footer.rights': '© {year} Roger Lab. Todos los derechos reservados.',
            'footer.privacy': 'Política de privacidad',
            'footer.terms': 'Términos del servicio',
            'footer.cookies': 'Política de cookies'
        },
        en: {
            'nav.home': 'Home',
            'nav.about': 'About me',
            'nav.fct': 'FCT Internship',
            'nav.articles': 'Blog',
            'nav.projects': 'Projects',
            'nav.juegos': 'JavaScript Games',
            'nav.contact': 'Contact',
            'hero.role': 'Full Stack Developer | DAW graduate',
            'hero.title': 'I am looking to join a team where I can build maintainable web software',
            'hero.cta.projects': 'View projects',
            'hero.cta.contact': 'Contact me',
            'hero.cta.cv_en': 'CV English',
            'hero.cta.cv_es': 'CV Spanish',
            'conocimientos.title.desarrollo': 'Backend and Frontend Development',
            'conocimientos.title.frameworks': 'Frameworks and Libraries',
            'conocimientos.title.datos': 'Databases and Servers',
            'conocimientos.title.herramientas': 'Tools and DevOps',
            'conocimientos.title.cloud': 'Cloud Computing',
            'conocimientos.title.entornos': 'Development Environments and OS',
            'pdf.title': 'Resume',
            'practicas.modal.title': 'Detailed internship tracking:',
            'practicas.modal.open': 'View tracking',
            'games.back': 'Back to games',
            'games.hangman.card.alt': 'Hangman game',
            'games.hangman.card.title': 'Hangman game',
            'games.hangman.card.body_1': 'This hangman game tests your vocabulary and mental speed: you must guess the hidden word letter by letter before completing the drawing. It includes a clear interface, immediate feedback on every attempt, and an experience designed to play smoothly from any device.',
            'games.hangman.card.body_2': 'I developed it as part of my portfolio to showcase programming logic, game state management, and code organization into reusable components. The goal was to combine functionality, performance, and a visual presentation consistent with the rest of the site.',
            'games.hangman.card.cta': 'Play hangman',
            'games.hangman.input_placeholder': 'Type a letter',
            'games.hangman.try': 'Try',
            'games.hangman.restart': 'Restart game',
            'games.dungeon.card.alt': 'Impious dungeon',
            'games.dungeon.card.title': 'Impious dungeon',
            'games.dungeon.card.cta': 'Play Impious dungeon',
            //Este texto de abajo es la animacion//
            'home.intro.body.part1': `Hi, I'm Rogério Lucas. I'm a Full Stack developer who is comfortable across backend and frontend work, with a strong interest in Laravel, PHP, and JavaScript. I focus on writing clear code, understanding the problem before suggesting a solution, and leaving a base that the team can maintain without friction. I have worked with databases, refactoring existing logic, integrations, and Linux-based deployments using Docker and AWS.`,
            'home.intro.body.part2': `I have completed the Higher Vocational Training in Web Application Development (DAW), an officially recognized qualification in Spain, and my current goal is to join a company where I can keep growing with an experienced technical team. I want to contribute from day one in maintenance work, bug fixing, performance improvements, and new feature development. This portfolio shows projects and internship work that reflect how I approach software development.`,

            'articles.visits.title': 'What I value in a development team for my next step',
            'articles.visits.intro': 'As I look for a stable role in a company, these are the factors that matter most to me:',
            'articles.visits.item_1': 'Real engineering practices: code reviews, clear branching, and consistent technical standards.',
            'articles.visits.item_2': 'Product context: understanding why a feature exists leads to better technical decisions.',
            'articles.visits.item_3': 'Supported learning: direct feedback, useful documentation, and teammates to validate ideas with.',
            'articles.visits.item_4': 'Progressive responsibility: start by contributing in focused tasks and earn autonomy through results.',
            'articles.pricing.title': 'What I can contribute as a junior profile after DAW',
            'articles.pricing.intro': 'My value is not about pretending to have more experience than I do. What I can honestly contribute today is a solid base in these areas:',
            'articles.pricing.item_1': 'Web backend: Laravel, PHP, routing, validation, relational databases, and maintenance of existing logic.',
            'articles.pricing.item_2': 'Functional frontend: JavaScript, careful layout work, interface interactions, and attention to performance.',
            'articles.pricing.item_3': 'Working environment: Git, Docker, Linux, deployments, and the ability to move through legacy code with care.',
            'articles.pricing.note': 'I also bring a straightforward way of working: document what matters, ask when context is missing, and prioritize maintainable solutions.',
            'articles.landing.title': 'Academic project vs real project: what changes',
            'articles.landing.head_1': 'Context',
            'articles.landing.head_2': 'What usually happens',
            'articles.landing.head_3': 'What it requires from me',
            'articles.landing.row_1_col_1': 'Academic project',
            'articles.landing.row_1_col_2': 'Scope is more limited and requirements are usually stable.',
            'articles.landing.row_1_col_3': 'Order, technical fundamentals, and the ability to deliver a complete solution.',
            'articles.landing.row_2_col_1': 'Real project',
            'articles.landing.row_2_col_2': 'There is legacy code, changing priorities, and decisions constrained by business and time.',
            'articles.landing.row_2_col_3': 'Adaptability, communication, and judgment to improve things without breaking what already works.',
            'articles.hiring.title': 'Lessons from entering an existing application',
            'articles.hiring.intro': 'Working on software that is already built has made several things very clear to me:',
            'articles.hiring.item_1': 'Before changing anything, you need to understand the current flow and the real impact of the change.',
            'articles.hiring.item_2': 'Naming, conventions, and small details matter a lot when several people maintain the same codebase.',
            'articles.hiring.item_3': 'Fixing an issue quickly is good; leaving the system clearer afterwards is better.',
            'articles.hiring.item_4': 'Communication with the team avoids rework and is often as important as the technical solution itself.',
            'articles.scaling.title': 'Less coding, more solutions that scale',
            'articles.scaling.intro': 'The more I learn, the clearer it becomes that scaling is not about producing more lines of code, but about solving the right problems better.',
            'articles.scaling.item_1': 'Start with the problem: clarify the goal, constraints, and success criteria before coding.',
            'articles.scaling.item_2': 'Design simple architecture: a clear solution usually performs better than a clever one that is hard to maintain.',
            'articles.scaling.item_3': 'Automate repeatable work: tests, validations, and predictable processes reduce avoidable mistakes.',
            'articles.scaling.item_4': 'Measure before optimizing: useful performance work is guided by data, not by intuition.',
            'articles.scaling.item_5': 'Think as a team: documentation, readability, and conventions save time for everyone.',
            'articles.scaling.note': 'That is the kind of development environment I want to keep growing in: less noise and more real impact.',
            'privacy.title': 'Privacy Policy',
            'privacy.intro': 'This Privacy Policy explains what information may be collected when you use this portfolio website, how that information is used, and how it is protected.',
            'privacy.section_1.title': '1. Information We Collect',
            'privacy.section_1.body': 'Depending on how you interact with the website, we may collect limited personal data voluntarily provided through forms or communications.',
            'privacy.section_1.item_1': 'Name or professional identifier.',
            'privacy.section_1.item_2': 'Contact details such as an email address.',
            'privacy.section_1.item_3': 'Usage information related to site preferences or analytics.',
            'privacy.section_1.item_4': 'Any message content submitted through the contact form.',
            'privacy.section_2.title': '2. How the Information Is Used',
            'privacy.section_2.body': 'Information is used only for purposes directly related to operating and improving the portfolio experience.',
            'privacy.section_2.item_1': 'Responding to messages or professional inquiries.',
            'privacy.section_2.item_2': 'Improving content, usability, and site performance.',
            'privacy.section_2.item_3': 'Reviewing anonymized analytics or preference data.',
            'privacy.section_2.item_4': 'Maintaining internal records when necessary.',
            'privacy.section_3.title': '3. Data Protection',
            'privacy.section_3.body': 'Reasonable technical and organizational measures are applied to reduce the risk of unauthorized access, misuse, or disclosure of any data shared through this website.',
            'privacy.section_4.title': '4. External Services and Links',
            'privacy.section_4.body': 'This website may link to external services such as GitHub, LinkedIn, or live demos. Those websites have their own privacy practices, and this portfolio is not responsible for how third parties manage your information.',
            'privacy.section_5.title': '5. Your Rights',
            'privacy.section_5.body': 'If you have shared personal information and want to request clarification, correction, or deletion, you may do so through the contact channels published on the site.',
            'privacy.meta': 'Last Updated: April 2026',
            'terms.title': 'Terms of Service',
            'terms.intro': 'By accessing this portfolio, you agree to use its content responsibly and in accordance with the conditions described below.',
            'terms.section_1.title': '1. Use of Content',
            'terms.section_1.body': 'The projects, source code snippets, and designs displayed on this portfolio are for demonstration purposes only. Unless explicitly stated through an open-source license or written notice, the intellectual property belongs to the site owner.',
            'terms.section_1.item_1': 'You may review the published work for personal reference.',
            'terms.section_1.item_2': 'You may not scrape, copy, redistribute, or commercialize the content without prior written permission.',
            'terms.section_2.title': '2. Disclaimer of Warranties',
            'terms.section_2.body': 'The information on this website is provided on an "as is" basis. While the portfolio is maintained with care, no guarantee is made that the materials are always complete, current, bug-free, or suitable for production use.',
            'terms.section_3.title': '3. Limitation of Liability',
            'terms.section_3.body': 'Under no circumstances shall the site owner be liable for any direct, indirect, incidental, or consequential damages resulting from the use of, or inability to use, the information, code samples, or projects shown on this website.',
            'terms.section_4.title': '4. Cookies and Tracking',
            'terms.section_4.body': 'This website may use cookies to improve user experience, remember preferences, or gather anonymous traffic insights. By continuing to browse the site, you acknowledge this use in accordance with the Privacy Policy and Cookie Policy.',
            'terms.section_5.title': '5. External Links',
            'terms.section_5.body': 'This website may include links to third-party websites such as repositories, professional profiles, or live demos. Those links are provided for convenience only, and the site owner is not responsible for their content or availability.',
            'terms.meta': 'Last Updated: April 2026',
            'cookies.title': 'Cookie Policy',
            'cookies.meta': 'Last updated: April 17, 2026',
            'cookies.intro': 'This Cookie Policy explains how this portfolio website uses cookies and similar technologies, why they are used, and what options you have to control them.',
            'cookies.section_1.title': '1. What Are Cookies?',
            'cookies.section_1.body': 'Cookies are small text files stored on your device when you visit a website. They help websites function correctly, remember preferences, and understand how visitors interact with content.',
            'cookies.section_2.title': '2. How Cookies Are Used',
            'cookies.section_2.body': 'This website may use first-party or third-party cookies for technical operation, performance measurement, and preference storage.',
            'cookies.table.head_1': 'Type of Cookie',
            'cookies.table.head_2': 'Description',
            'cookies.table.row_1_col_1': 'Essential',
            'cookies.table.row_1_col_2': 'Required for basic website operation, such as security or stable page delivery.',
            'cookies.table.row_2_col_1': 'Analytics',
            'cookies.table.row_2_col_2': 'Used to understand how visitors interact with the site and improve content quality.',
            'cookies.table.row_3_col_1': 'Preferences',
            'cookies.table.row_3_col_2': 'Remember settings such as theme, language, or other user experience preferences.',
            'cookies.section_3.title': '3. Cookie Control',
            'cookies.section_3.body': 'You can decide whether to accept or reject cookies through your browser settings. Disabling some cookies may affect the proper operation of certain areas of the website.',
            'cookies.section_4.title': '4. Third-Party Cookies',
            'cookies.section_4.body': 'In some cases, trusted third-party services such as analytics platforms may place cookies to help measure traffic and improve the overall experience.',
            'cookies.section_5.title': '5. More Information',
            'cookies.section_5.body': 'If you need more information about the use of cookies on this website, you can get in touch through the main contact channels available in the portfolio.',
            'projects.library.alt': 'DAW Library project logo',
            'projects.library.title': 'DAW Library',
            'projects.library.meta': 'Apr. 2023 | Design and development',
            'projects.library.body_1': 'Final DAW project where I designed and implemented a library management application using Laravel, PHP, Eloquent ORM, and MySQL to support catalog, loan, and return workflows end to end.',
            'projects.library.body_2': 'I defined the relational model, structured the MVC architecture, and applied business validation rules to keep data integrity and enable maintainable future iterations.',
            'projects.content.alt': 'Content Manager project logo',
            'projects.content.title': 'Content Manager',
            'projects.content.meta': 'Feb. 2026 | Development',
            'projects.content.body_1': 'Internal business application focused on content operations: I worked on a Laravel/PHP + MySQL codebase to stabilize editing and publishing workflows.',
            'projects.content.body_2': 'I analyzed legacy logic, refined business rules, and improved Blade + JavaScript UI components to reduce operational friction for upcoming team releases.',
            'projects.juegoRol.alt': 'Role-playing game project logo',
            'projects.juegoRol.title': 'Role-playing Game',
            'projects.juegoRol.meta': 'May 2026 | Development & Design',
            'projects.juegoRol.body_1': 'Modular game built in Vanilla JavaScript with explicit domain separation (map, combat, characters, and state), designed for functional scalability.',
            'projects.juegoRol.body_2': 'I implemented a decoupled presentation layer with HTML templates and event-driven flows so new mechanics can be added without degrading readability or maintainability.',
            'projects.time.alt': 'Time Tracking project logo',
            'projects.time.title': 'Time Tracking Manager',
            'projects.time.meta': 'Jan. 2026 | Development',
            'projects.time.body_1': 'Time-tracking application focused on attendance traceability and incident logging; I contributed on PHP/Laravel backend flows and MySQL persistence to keep records reliable.',
            'projects.time.body_2': 'I reviewed critical business processes, debugged attendance rules, and improved the Blade + JavaScript interface layer to speed up day-to-day user operations.',
            'projects.portfolio.alt': 'Roger Lab portfolio logo',
            'projects.portfolio.title': 'Web Portfolio',
            'projects.portfolio.meta': 'Apr. 2026 | Design and development',
            'projects.portfolio.body_1': 'I built this portfolio as a full-stack product using Laravel, Blade, Vanilla JavaScript, and CSS component architecture to present projects with technical and business context.',
            'projects.portfolio.body_2': 'I implemented partial navigation, ES/EN/PT i18n, and validated contact workflows to demonstrate architecture decisions focused on performance, maintainability, and UX clarity.',
            'projects.apipokemon.alt': 'API Pokemon project logo',
            'projects.apipokemon.title': 'API Pokemon Pokedex Shiny',
            'projects.apipokemon.meta': 'Jun. 2026 | Full stack development',
            'projects.apipokemon.body_1': 'Full-stack REST integration project with Laravel: I designed internal endpoints, input validation, and a PokeAPI consumption service to generate complete Pokemon profiles by name or ID.',
            'projects.apipokemon.body_2': 'I structured nested-data transformations, Blade component rendering, and JavaScript gallery filters to deliver a fast, readable Pokedex ready for feature expansion.',
            'projects.n8n-linkedin.alt': 'n8n LinkedIn project logo',
            'projects.n8n-linkedin.title': 'N8n LinkedIn Job Search Workflow',
            'projects.n8n-linkedin.meta': 'August 2026 | Job Search Automation (HTTP)',
            'projects.n8n-linkedin.body_1': 'n8n job-search automation project featuring a workflow that searches LinkedIn listings through Browserless and extracts the key data needed to streamline each application.',
            'projects.n8n-linkedin.body_2': 'I also implemented a match-score filter to prioritize the offers that best align with the CV profile.',
            'projects.n8n-linkedin.body_3': 'The workflow integrates Google Drive, Google Sheets, and Google Docs APIs to store data and generate personalized cover letters for each opportunity, making the process faster without losing professionalism.',
            'projects.n8n-linkedin.preview_alt': 'Screenshot of the N8n LinkedIn Job Search Workflow project',
            'projects.n8n-linkedin.download': 'Download workflow',

            'about.methodology.title': 'What is my working methodology?',
            'about.methodology.body_1': `I do not just write code. First I try to understand the problem, then I propose a simple solution, and finally I check whether that solution will be maintainable by other people besides me.`, 
            'about.methodology.body_2': 'I work with version control, try to document important decisions, and value code that can be read, reviewed, and extended without unnecessary friction.',
            'about.specialization.title': 'What am I specializing in right now?',
            'about.specialization.body_1': `Right now I am going deeper into Laravel, backend PHP quality, and the operational side around web applications: deployment, project structure, error traceability, and maintenance.`,
            'about.specialization.body_2': `In the short term I want to keep gaining experience inside a company, strengthen my foundations in architecture and testing, and work in teams where I can learn from more experienced developers.`,
            'about.repository.title': 'Can my repository code be reviewed?',
            'about.repository.body_1': 'Yes. The repositories are public to show how I structure solutions, what my current level is, and how I approach academic, personal, and internship projects.',
            'about.repository.button': 'Repository',
            'about.website.button': 'Web',
            'contact.title': 'Professional contact',
            'contact.form.company': 'Company',
            'contact.form.name': 'Name',
            'contact.form.subject': 'Subject',
            'contact.form.email': 'Email',
            'contact.form.message': 'Message',
            'contact.form.subject_placeholder': 'I would like to talk to you about a role',
            'contact.form.email_placeholder': 'example@email.com',
            'contact.form.message_placeholder': 'Tell me about the role, the team, the stack, or the reason for getting in touch and I will reply as soon as possible.',
            'contact.form.notice': 'Before the message reaches the administrator, you must confirm your email address through a verification link.',
            'contact.form.submit': 'Send message',
            'footer.rights': '© {year} Roger Lab. All rights reserved.',
            'footer.privacy': 'Privacy Policy',
            'footer.terms': 'Terms of Service',
            'footer.cookies': 'Cookie Policy'
        },
        pt: {
            'nav.home': 'Início',
            'nav.about': 'Sobre mim',
            'nav.fct': 'Estágio FCT',
            'nav.articles': 'Blog',
            'nav.projects': 'Projetos',
            'nav.juegos': 'Jogos JavaScript',
            'nav.contact': 'Contacto',
            'hero.role': 'Desenvolvedor Full Stack | Formado em DAW',
            'hero.title': 'Procuro integrar uma equipa onde possa construir software web sustentável',
            'hero.cta.projects': 'Ver projetos',
            'hero.cta.contact': 'Contactar',
            'hero.cta.cv_en': 'CV English',
            'hero.cta.cv_es': 'CV Espanhol',
            'conocimientos.title.desarrollo': 'Desenvolvimento Backend e Frontend',
            'conocimientos.title.frameworks': 'Frameworks e Bibliotecas',
            'conocimientos.title.datos': 'Bases de Dados e Servidores',
            'conocimientos.title.herramientas': 'Ferramentas e DevOps',
            'conocimientos.title.cloud': 'Cloud Computing',
            'conocimientos.title.entornos': 'Ambientes de Desenvolvimento e SO',
            'pdf.title': 'Currículo',
            'practicas.modal.title': 'Acompanhamento detalhado do estágio:',
            'practicas.modal.open': 'Ver acompanhamento',
            'games.back': 'Voltar aos jogos',
            'games.hangman.card.title': 'Jogo da forca',
            'games.hangman.card.body_1': 'Este jogo da forca põe à prova o teu vocabulário e rapidez mental: tens de adivinhar a palavra escondida letra a letra antes de completar o desenho. Inclui uma interface clara, feedback imediato em cada tentativa e uma experiência pensada para jogar de forma fluida em qualquer dispositivo.',
            'games.hangman.card.body_2': 'Desenvolvi-o como parte do meu portfólio para demonstrar lógica de programação, gestão do estado do jogo e organização do código em componentes reutilizáveis. O objetivo foi combinar funcionalidade, desempenho e uma apresentação visual consistente com o resto do site.',
            'games.hangman.card.cta': 'Jogar forca',
            'games.hangman.input_placeholder': 'Escreve uma letra',
            'games.hangman.try': 'Tentar',
            'games.hangman.restart': 'Reiniciar jogo',
            'games.dungeon.card.alt': 'Masmorra ímpia',
            'games.dungeon.card.title': 'Masmorra ímpia',
            'games.dungeon.card.cta': 'Jogar Masmorra ímpia',
            //Este texto de abajo es la animacion//
            'home.intro.body.part1': 'Olá, sou Rogério Lucas. Sou desenvolvedor Full Stack e sinto-me confortável entre backend e frontend, com interesse especial em Laravel, PHP e JavaScript. Procuro escrever código claro, entender o problema antes de propor uma solução e deixar uma base que a equipa consiga manter sem fricção. Já trabalhei com bases de dados, refatoração de lógica existente, integrações e deploys em Linux com Docker e AWS.',
            'home.intro.body.part2': 'Concluí o Grau Superior em Desenvolvimento de Aplicações Web (DAW), uma qualificação oficialmente reconhecida em Espanha, e agora quero entrar numa empresa onde possa continuar a crescer com uma equipa técnica experiente. Quero contribuir desde o primeiro dia em manutenção evolutiva, correção de erros, melhoria de desempenho e desenvolvimento de novas funcionalidades. Este portfólio mostra projetos e estágio que refletem a minha forma de trabalhar.',

            'articles.visits.title': 'O que valorizo numa equipa de desenvolvimento para a minha próxima etapa',
            'articles.visits.intro': 'Ao procurar uma oportunidade estável numa empresa, estes são os fatores que mais pesam para mim:',
            'articles.visits.item_1': 'Boas práticas reais: revisões de código, branches claras e critérios técnicos consistentes.',
            'articles.visits.item_2': 'Contexto de produto: perceber porque existe cada funcionalidade ajuda a tomar melhores decisões.',
            'articles.visits.item_3': 'Aprendizagem acompanhada: feedback direto, documentação útil e colegas com quem validar soluções.',
            'articles.visits.item_4': 'Responsabilidade progressiva: começar por tarefas concretas e ganhar autonomia com resultados.',
            'articles.pricing.title': 'O que posso aportar como perfil júnior depois de concluir DAW',
            'articles.pricing.intro': 'O meu valor não está em fingir experiência que ainda não tenho. O que posso aportar hoje, com honestidade, é uma base sólida nestas áreas:',
            'articles.pricing.item_1': 'Backend web: Laravel, PHP, routing, validação, bases de dados relacionais e manutenção de lógica existente.',
            'articles.pricing.item_2': 'Frontend funcional: JavaScript, cuidado na maquetização, interações de interface e atenção ao desempenho.',
            'articles.pricing.item_3': 'Ambiente de trabalho: Git, Docker, Linux, deploys e capacidade para navegar em código legado com critério.',
            'articles.pricing.note': 'Junto a isso trago uma forma direta de trabalhar: documentar o importante, perguntar quando falta contexto e priorizar soluções sustentáveis.',
            'articles.landing.title': 'Projeto académico vs projeto real: o que muda',
            'articles.landing.head_1': 'Contexto',
            'articles.landing.head_2': 'O que costuma acontecer',
            'articles.landing.head_3': 'O que exige de mim',
            'articles.landing.row_1_col_1': 'Projeto académico',
            'articles.landing.row_1_col_2': 'O âmbito é mais limitado e os requisitos costumam ser estáveis.',
            'articles.landing.row_1_col_3': 'Organização, fundamentos técnicos e capacidade de entregar uma solução completa.',
            'articles.landing.row_2_col_1': 'Projeto real',
            'articles.landing.row_2_col_2': 'Existe código legado, prioridades a mudar e decisões condicionadas por negócio e tempo.',
            'articles.landing.row_2_col_3': 'Adaptação, comunicação e critério para melhorar sem partir o que já funciona.',
            'articles.hiring.title': 'Aprendizagens ao entrar numa aplicação existente',
            'articles.hiring.intro': 'Trabalhar sobre software já construído deixou-me estas ideias bem claras:',
            'articles.hiring.item_1': 'Antes de tocar em algo, é preciso perceber o fluxo atual e o impacto real da alteração.',
            'articles.hiring.item_2': 'Nomes, convenções e pequenos detalhes contam muito quando várias pessoas mantêm a mesma base.',
            'articles.hiring.item_3': 'Resolver uma incidência depressa é bom; deixar o sistema mais claro depois é melhor.',
            'articles.hiring.item_4': 'A comunicação com a equipa evita retrabalho e muitas vezes é tão importante quanto a solução técnica.',
            'articles.scaling.title': 'Menos picar código, mais soluções que escalam',
            'articles.scaling.intro': 'Quanto mais aprendo, mais claro fica que escalar não é produzir mais linhas de código, mas resolver melhor os problemas certos.',
            'articles.scaling.item_1': 'Começa pelo problema: antes de programar, clarifica objetivo, restrições e critério de sucesso.',
            'articles.scaling.item_2': 'Desenha arquitetura simples: uma solução clara costuma render melhor do que uma brilhante mas difícil de manter.',
            'articles.scaling.item_3': 'Automatiza o repetível: testes, validações e processos previsíveis reduzem erros evitáveis.',
            'articles.scaling.item_4': 'Mede antes de otimizar: desempenho útil melhora-se com dados, não com intuição.',
            'articles.scaling.item_5': 'Pensa em equipa: documentação, legibilidade e convenções poupam tempo a todos.',
            'articles.scaling.note': 'É neste tipo de desenvolvimento que quero continuar a crescer: menos ruído e mais impacto real.',
            'privacy.title': 'Política de Privacidade',
            'privacy.intro': 'Esta política de privacidade explica que informação pode ser recolhida quando utilizas este portfólio, como é usada e como é protegida.',
            'privacy.section_1.title': '1. Informação que recolhemos',
            'privacy.section_1.body': 'Dependendo de como interages com o site, podemos recolher dados pessoais limitados que são fornecidos voluntariamente através de formulários ou comunicações.',
            'privacy.section_1.item_1': 'Nome ou identificador profissional.',
            'privacy.section_1.item_2': 'Dados de contacto, como um endereço de email.',
            'privacy.section_1.item_3': 'Informação de utilização relacionada com preferências do site ou análise.',
            'privacy.section_1.item_4': 'Qualquer mensagem enviada através do formulário de contacto.',
            'privacy.section_2.title': '2. Como a informação é usada',
            'privacy.section_2.body': 'A informação é usada apenas para fins diretamente relacionados com o funcionamento e melhoria da experiência do portfólio.',
            'privacy.section_2.item_1': 'Responder a mensagens ou pedidos profissionais.',
            'privacy.section_2.item_2': 'Melhorar o conteúdo, a usabilidade e o desempenho do site.',
            'privacy.section_2.item_3': 'Rever análises anonimizadas ou dados de preferências.',
            'privacy.section_2.item_4': 'Manter registos internos quando necessário.',
            'privacy.section_3.title': '3. Proteção de dados',
            'privacy.section_3.body': 'São aplicadas medidas técnicas e organizativas razoáveis para reduzir o risco de acesso não autorizado, uso indevido ou divulgação de quaisquer dados partilhados através deste site.',
            'privacy.section_4.title': '4. Serviços e ligações externas',
            'privacy.section_4.body': 'Este site pode ligar a serviços externos como GitHub, LinkedIn ou demos em direto. Esses websites têm as suas próprias práticas de privacidade e este portfólio não é responsável por como terceiros tratam a tua informação.',
            'privacy.section_5.title': '5. Os teus direitos',
            'privacy.section_5.body': 'Se partilhaste informação pessoal e queres pedir esclarecimento, correção ou eliminação, podes fazê-lo através dos canais de contacto publicados no site.',
            'privacy.meta': 'Última atualização: abril de 2026',
            'terms.title': 'Termos do Serviço',
            'terms.intro': 'Ao aceder a este portfólio, concordas em usar o seu conteúdo de forma responsável e de acordo com as condições descritas abaixo.',
            'terms.section_1.title': '1. Utilização do conteúdo',
            'terms.section_1.body': 'Os projetos, excertos de código e designs apresentados neste portfólio são apenas para fins demonstrativos. Salvo indicação explícita através de uma licença open-source ou aviso escrito, a propriedade intelectual pertence ao titular do site.',
            'terms.section_1.item_1': 'Podes rever o trabalho publicado para referência pessoal.',
            'terms.section_1.item_2': 'Não podes extrair, copiar, redistribuir ou comercializar o conteúdo sem permissão prévia por escrito.',
            'terms.section_2.title': '2. Isenção de garantias',
            'terms.section_2.body': 'A informação neste site é fornecida "tal como está". Embora o portfólio seja mantido com cuidado, não é garantido que os materiais estejam sempre completos, atualizados, sem erros ou adequados para uso em produção.',
            'terms.section_3.title': '3. Limitação de responsabilidade',
            'terms.section_3.body': 'Em nenhuma circunstância o titular do site será responsável por quaisquer danos diretos, indiretos, incidentais ou consequenciais resultantes da utilização, ou incapacidade de utilização, da informação, exemplos de código ou projetos mostrados neste site.',
            'terms.section_4.title': '4. Cookies e rastreio',
            'terms.section_4.body': 'Este site pode usar cookies para melhorar a experiência do utilizador, lembrar preferências ou recolher dados anónimos de tráfego. Ao continuares a navegar, reconheces este uso de acordo com a Política de Privacidade e a Política de Cookies.',
            'terms.section_5.title': '5. Ligações externas',
            'terms.section_5.body': 'Este site pode incluir ligações para websites de terceiros como repositórios, perfis profissionais ou demos. Essas ligações são fornecidas apenas por conveniência e o titular não se responsabiliza pelo seu conteúdo ou disponibilidade.',
            'terms.meta': 'Última atualização: abril de 2026',
            'cookies.title': 'Política de Cookies',
            'cookies.meta': 'Última atualização: 17 de abril de 2026',
            'cookies.intro': 'Esta política de cookies explica como este portfólio usa cookies e tecnologias semelhantes, porque são usados e que opções tens para os controlar.',
            'cookies.section_1.title': '1. O que são cookies?',
            'cookies.section_1.body': 'Os cookies são pequenos ficheiros de texto armazenados no teu dispositivo quando visitas um site. Ajudam os sites a funcionar corretamente, a lembrar preferências e a perceber como os visitantes interagem com o conteúdo.',
            'cookies.section_2.title': '2. Como os cookies são usados',
            'cookies.section_2.body': 'Este site pode usar cookies próprios ou de terceiros para funcionamento técnico, medição de desempenho e armazenamento de preferências.',
            'cookies.table.head_1': 'Tipo de cookie',
            'cookies.table.head_2': 'Descrição',
            'cookies.table.row_1_col_1': 'Essenciais',
            'cookies.table.row_1_col_2': 'Necessários para o funcionamento básico do site, como segurança ou entrega estável das páginas.',
            'cookies.table.row_2_col_1': 'Analíticos',
            'cookies.table.row_2_col_2': 'Usados para perceber como os visitantes interagem com o site e melhorar a qualidade do conteúdo.',
            'cookies.table.row_3_col_1': 'Preferências',
            'cookies.table.row_3_col_2': 'Lembram definições como tema, idioma ou outras preferências de experiência do utilizador.',
            'cookies.section_3.title': '3. Controlo de cookies',
            'cookies.section_3.body': 'Podes decidir se aceitas ou recusas cookies através das definições do teu navegador. Desativar alguns cookies pode afetar o funcionamento correto de certas áreas do site.',
            'cookies.section_4.title': '4. Cookies de terceiros',
            'cookies.section_4.body': 'Em alguns casos, serviços externos de confiança como plataformas de análise podem colocar cookies para ajudar a medir o tráfego e melhorar a experiência geral.',
            'cookies.section_5.title': '5. Mais informação',
            'cookies.section_5.body': 'Se precisares de mais informação sobre a utilização de cookies neste site, podes entrar em contacto através dos canais principais disponíveis no portfólio.',
            'projects.library.alt': 'Logo do projeto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Design e desenvolvimento',
            'projects.library.body_1': 'Projeto final de DAW no qual desenhei e implementei uma aplicação de gestão bibliotecária com Laravel, PHP, Eloquent ORM e MySQL para suportar catálogo, empréstimos e devoluções de ponta a ponta.',
            'projects.library.body_2': 'Defini o modelo relacional, organizei a arquitetura MVC e apliquei validações de negócio para garantir integridade de dados e facilitar evolução da aplicação.',
            'projects.content.alt': 'Logo do projeto Gestor de Conteudo',
            'projects.content.title': 'Gestor de Conteudo',
            'projects.content.meta': 'Fev. 2026 | Desenvolvimento',
            'projects.content.body_1': 'Projeto interno em ambiente empresarial focado em operações de conteúdo: trabalhei sobre uma base Laravel/PHP com MySQL para estabilizar fluxos de edição e publicação.',
            'projects.content.body_2': 'Analisei lógica legada, refinei regras de negócio e melhorei componentes de interface em Blade + JavaScript para reduzir fricção operacional nas próximas entregas da equipa.',
            'projects.juegoRol.alt': 'Logo do projeto Jogo de RPG',
            'projects.juegoRol.title': 'Jogo de RPG',
            'projects.juegoRol.meta': 'Mai. 2026 | Desenvolvimento e design',
            'projects.juegoRol.body_1': 'Jogo modular em Vanilla JavaScript com separação explícita de domínio (mapa, combate, personagens e estado), desenhado para escalar funcionalidades.',
            'projects.juegoRol.body_2': 'Implementei uma camada de apresentação desacoplada com templates HTML e fluxos orientados a eventos para adicionar mecânicas sem degradar legibilidade nem manutenção.',
            'projects.time.alt': 'Logo do projeto Gestor de Fichagem',
            'projects.time.title': 'Gestor de Fichagem',
            'projects.time.meta': 'Jan. 2026 | Desenvolvimento',
            'projects.time.body_1': 'Aplicação de controlo horário focada em rastreabilidade de assiduidade e incidências; contribuí em fluxos backend PHP/Laravel e persistência MySQL para garantir registos fiáveis.',
            'projects.time.body_2': 'Revisei processos críticos de negócio, depurei regras de fichagem e melhorei a camada de interface com Blade + JavaScript para acelerar a operação diária do utilizador final.',
            'projects.portfolio.alt': 'Logo do portfolio Roger Lab',
            'projects.portfolio.title': 'Portfolio Web',
            'projects.portfolio.meta': 'Abr. 2026 | Design e desenvolvimento',
            'projects.portfolio.body_1': 'Desenvolvi este portfólio como produto full-stack com Laravel, Blade, Vanilla JavaScript e arquitetura por componentes para apresentar projetos com contexto técnico e de negócio.',
            'projects.portfolio.body_2': 'Implementei navegação parcial, i18n ES/EN/PT e fluxos de contacto com validação para demonstrar decisões de arquitetura orientadas a performance, manutenção e clareza de UX.',
            'projects.apipokemon.alt': 'Logo do projeto API Pokemon',
            'projects.apipokemon.title': 'API Pokemon Pokedex Shiny',
            'projects.apipokemon.meta': 'Jun. 2026 | Desenvolvimento full stack',
            'projects.apipokemon.body_1': 'Projeto full-stack de integração REST com Laravel: desenhei endpoints internos, validação de input e um serviço de consumo da PokeAPI para gerar fichas completas por nome ou ID.',
            'projects.apipokemon.body_2': 'Estruturei transformação de dados aninhados, renderização por componentes Blade e filtros de galeria em JavaScript para entregar uma Pokedex rápida, legível e preparada para expansão funcional.',
            'projects.n8n-linkedin.alt': 'Logo do projeto n8n LinkedIn',
            'projects.n8n-linkedin.title': 'N8n LinkedIn Workflow Busca Emprego',
            'projects.n8n-linkedin.meta': 'Agosto 2026 | Automação de Busca Emprego (HTTP)',
            'projects.n8n-linkedin.body_1': 'Projeto de automação de procura de emprego em n8n, com um workflow que pesquisa vagas no LinkedIn via Browserless e extrai por código os dados essenciais para facilitar cada candidatura.',
            'projects.n8n-linkedin.body_2': 'Também implementei um filtro de match score para priorizar as ofertas mais alinhadas com os dados do CV.',
            'projects.n8n-linkedin.body_3': 'O fluxo integra ainda as APIs do Google Drive, Google Sheets e Google Docs para guardar dados e gerar cartas de apresentação personalizadas para cada vaga, acelerando o processo sem perder profissionalismo.',
            'projects.n8n-linkedin.preview_alt': 'Captura do projeto N8n LinkedIn Workflow Busca Emprego',
            'projects.n8n-linkedin.download': 'Descarregar fluxo de trabalho',

            'about.methodology.title': 'Qual e a minha metodologia de trabalho?',
            'about.methodology.body_1': `Não me limito a escrever código. Primeiro tento perceber o problema, depois proponho uma solução simples e por fim verifico se essa solução vai ser sustentável para outras pessoas além de mim.`,
            'about.methodology.body_2': 'Trabalho com controlo de versões, procuro documentar decisões importantes e valorizo código que possa ser lido, revisto e evoluído sem fricção desnecessária.',
            'about.specialization.title': 'Em que me estou a especializar agora?',
            'about.specialization.body_1': `Neste momento estou a aprofundar Laravel, a qualidade do backend em PHP e a parte operacional que rodeia uma aplicação web: deploy, estrutura do projeto, rastreabilidade de erros e manutenção.`,
            'about.specialization.body_2': 'A curto prazo quero continuar a ganhar experiência em empresa, reforçar bases de arquitetura e testing e trabalhar em equipas onde possa aprender com developers mais experientes.',
            'about.repository.title': 'O meu código do repositório pode ser revisto?',
            'about.repository.body_1': 'Sim. Os repositórios estão publicados para mostrar como estruturo soluções, qual é o meu nível atual e como abordo projetos académicos, pessoais e de estágio.',
            'about.repository.button': 'Repositorio',
            'about.website.button': 'Web',
            'contact.title': 'Contacto profissional',
            'contact.form.company': 'Empresa',
            'contact.form.name': 'Nome',
            'contact.form.subject': 'Assunto',
            'contact.form.email': 'Email',
            'contact.form.message': 'Mensagem',
            'contact.form.subject_placeholder': 'Gostaria de falar contigo sobre uma vaga',
            'contact.form.email_placeholder': 'exemplo@email.com',
            'contact.form.message_placeholder': 'Conta-me sobre a vaga, a equipa, a stack ou o motivo do contacto e responderei assim que possível.',
            'contact.form.notice': 'Antes de a mensagem chegar ao administrador, tens de confirmar o teu email atraves de uma ligacao de verificacao.',
            'contact.form.submit': 'Enviar mensagem',
            'footer.rights': '© {year} Roger Lab. Todos os direitos reservados.',
            'footer.privacy': 'Politica de privacidade',
            'footer.terms': 'Termos do servico',
            'footer.cookies': 'Politica de cookies'
        }
    };

    var pageMetadata = {
        es: {
            home: {
                title: 'RogerLab | Desarrollador Full Stack titulado en DAW',
                description: 'Portfolio de Rogério Lucas, desarrollador Full Stack titulado en DAW. Proyectos con Laravel, PHP, JavaScript, bases de datos, Docker y AWS orientados a código mantenible y trabajo en equipo.'
            },
            about: {
                title: 'Sobre mí | Rogério Lucas, desarrollador Full Stack',
                description: 'Experiencia, metodología de trabajo y objetivos profesionales de Rogério Lucas tras finalizar DAW y realizar prácticas en entorno real.'
            },
            miPeriodoPracticas: {
                title: 'Prácticas FCT | RogerLab',
                description: 'Resumen de mi periodo de prácticas FCT: mantenimiento, despliegues, aprendizaje sobre código existente y trabajo en entorno empresarial.'
            },
            articles: {
                title: 'Artículos y reflexiones técnicas | RogerLab',
                description: 'Notas sobre aprendizaje técnico, mantenimiento, código heredado y desarrollo web desde una perspectiva profesional y honesta.'
            },
            projects: {
                title: 'Proyectos | Rogério Lucas',
                description: 'Selección de proyectos full-stack con Laravel, PHP, MySQL, JavaScript, Docker y AWS, centrados en arquitectura mantenible, integración API y resolución de problemas reales.'
            },
            juegos: {
                title: 'Juegos JavaScript | RogerLab',
                description: 'Pequeños proyectos interactivos en JavaScript incluidos dentro del portfolio para mostrar lógica, estructura y organización del código.'
            },
            ahorcado: {
                title: 'Juego del Ahorcado | RogerLab',
                description: 'Juego del ahorcado desarrollado en JavaScript como parte del portfolio técnico de Rogério Lucas.'
            },
            contact: {
                title: 'Contacto profesional | RogerLab',
                description: 'Escríbeme para hablar sobre vacantes, procesos de selección o colaboración técnica dentro de un equipo de desarrollo.'
            },
            privacyPolicy: {
                title: 'Política de Privacidad | RogerLab',
                description: 'Información sobre el tratamiento de datos personales enviados a través del portfolio de RogerLab.'
            },
            termsOfService: {
                title: 'Términos del Servicio | RogerLab',
                description: 'Condiciones de uso y alcance del contenido publicado en el portfolio profesional de RogerLab.'
            },
            cookiesPrivacy: {
                title: 'Política de Cookies | RogerLab',
                description: 'Información sobre cookies, almacenamiento local y tecnologías similares utilizadas en la web de RogerLab.'
            },
            notFound: {
                title: 'Página no encontrada | RogerLab',
                description: 'La página que buscas no está disponible. Puedes volver al inicio para revisar mi perfil, proyectos y formas de contacto.'
            }
        },
        en: {
            home: {
                title: 'RogerLab | Full Stack Developer, DAW graduate',
                description: 'Portfolio of Rogério Lucas, a Full Stack developer and DAW graduate. Projects with Laravel, PHP, JavaScript, databases, Docker, and AWS focused on maintainable code and teamwork.'
            },
            about: {
                title: 'About me | Rogério Lucas, Full Stack Developer',
                description: 'Experience, working methodology, and professional goals of Rogério Lucas after completing DAW and working in a real internship environment.'
            },
            miPeriodoPracticas: {
                title: 'FCT Internship | RogerLab',
                description: 'Summary of my FCT internship: maintenance work, deployments, learning from existing code, and day-to-day work in a business environment.'
            },
            articles: {
                title: 'Articles and technical reflections | RogerLab',
                description: 'Notes on technical learning, maintenance, legacy code, and web development from a professional and honest perspective.'
            },
            projects: {
                title: 'Projects | Rogério Lucas',
                description: 'Selection of full-stack projects using Laravel, PHP, MySQL, JavaScript, Docker, and AWS, focused on maintainable architecture, API integration, and real problem-solving.'
            },
            juegos: {
                title: 'JavaScript Games | RogerLab',
                description: 'Small interactive JavaScript projects included in the portfolio to show logic, structure, and code organization.'
            },
            ahorcado: {
                title: 'Hangman Game | RogerLab',
                description: 'Hangman game built in JavaScript as part of Rogério Lucas technical portfolio.'
            },
            contact: {
                title: 'Professional contact | RogerLab',
                description: 'Get in touch to discuss roles, hiring processes, or technical collaboration within a development team.'
            },
            privacyPolicy: {
                title: 'Privacy Policy | RogerLab',
                description: 'Information about how personal data submitted through the RogerLab portfolio is processed.'
            },
            termsOfService: {
                title: 'Terms of Service | RogerLab',
                description: 'Terms of use and scope of the content published in the RogerLab professional portfolio.'
            },
            cookiesPrivacy: {
                title: 'Cookie Policy | RogerLab',
                description: 'Information about cookies, local storage, and similar technologies used on the RogerLab website.'
            },
            notFound: {
                title: 'Page not found | RogerLab',
                description: 'The page you are looking for is not available. You can return to the homepage to review my profile, projects, and contact details.'
            }
        },
        pt: {
            home: {
                title: 'RogerLab | Desenvolvedor Full Stack, formado em DAW',
                description: 'Portfólio de Rogério Lucas, desenvolvedor Full Stack formado em DAW. Projetos com Laravel, PHP, JavaScript, bases de dados, Docker e AWS focados em código sustentável e trabalho em equipa.'
            },
            about: {
                title: 'Sobre mim | Rogério Lucas, Desenvolvedor Full Stack',
                description: 'Experiência, metodologia de trabalho e objetivos profissionais de Rogério Lucas depois de concluir DAW e realizar estágio em ambiente real.'
            },
            miPeriodoPracticas: {
                title: 'Estágio FCT | RogerLab',
                description: 'Resumo do meu período de estágio FCT: manutenção, deploys, aprendizagem sobre código existente e trabalho em ambiente empresarial.'
            },
            articles: {
                title: 'Artigos e reflexões técnicas | RogerLab',
                description: 'Notas sobre aprendizagem técnica, manutenção, código legado e desenvolvimento web numa perspetiva profissional e honesta.'
            },
            projects: {
                title: 'Projetos | Rogério Lucas',
                description: 'Seleção de projetos full-stack com Laravel, PHP, MySQL, JavaScript, Docker e AWS, focados em arquitetura sustentável, integração API e resolução de problemas reais.'
            },
            juegos: {
                title: 'Jogos JavaScript | RogerLab',
                description: 'Pequenos projetos interativos em JavaScript incluídos no portfólio para mostrar lógica, estrutura e organização de código.'
            },
            ahorcado: {
                title: 'Jogo da Forca | RogerLab',
                description: 'Jogo da forca desenvolvido em JavaScript como parte do portfólio técnico de Rogério Lucas.'
            },
            contact: {
                title: 'Contacto profissional | RogerLab',
                description: 'Escreve-me para falar sobre vagas, processos de recrutamento ou colaboração técnica dentro de uma equipa de desenvolvimento.'
            },
            privacyPolicy: {
                title: 'Política de Privacidade | RogerLab',
                description: 'Informação sobre o tratamento de dados pessoais enviados através do portfólio RogerLab.'
            },
            termsOfService: {
                title: 'Termos do Serviço | RogerLab',
                description: 'Condições de utilização e alcance do conteúdo publicado no portfólio profissional RogerLab.'
            },
            cookiesPrivacy: {
                title: 'Política de Cookies | RogerLab',
                description: 'Informação sobre cookies, armazenamento local e tecnologias semelhantes utilizadas no site RogerLab.'
            },
            notFound: {
                title: 'Página não encontrada | RogerLab',
                description: 'A página que procuras não está disponível. Podes voltar ao início para rever o meu perfil, projetos e formas de contacto.'
            }
        }
    };

    function normalizeLanguage(language) {
        return SUPPORTED_LANGUAGES.indexOf(language) >= 0 ? language : DEFAULT_LANGUAGE;
    }

    function getStoredLanguage() {
        return normalizeLanguage(window.localStorage.getItem(STORAGE_KEY) || DEFAULT_LANGUAGE);
    }

    function setStoredLanguage(language) {
        window.localStorage.setItem(STORAGE_KEY, normalizeLanguage(language));
    }

    function interpolate(template, element) {
        return template.replace('{year}', element.dataset.i18nYear || '');
    }

    function translateElement(element, language) {
        var key = element.dataset.i18n;
        var dictionary = translations[language] || translations[DEFAULT_LANGUAGE];
        var translation = dictionary[key];

        if (!translation) {
            return;
        }

        element.textContent = interpolate(translation, element);
    }

    function translatePlaceholder(element, language) {
        var key = element.dataset.i18nPlaceholder;
        var dictionary = translations[language] || translations[DEFAULT_LANGUAGE];
        var translation = dictionary[key];

        if (!translation) {
            return;
        }

        element.setAttribute('placeholder', translation);
    }

    function translateAlt(element, language) {
        var key = element.dataset.i18nAlt;
        var dictionary = translations[language] || translations[DEFAULT_LANGUAGE];
        var translation = dictionary[key];

        if (!translation) {
            return;
        }

        element.setAttribute('alt', translation);
    }

    function syncLanguageButtons(language) {
        document.querySelectorAll('[data-language-option]').forEach(function (button) {
            var isActive = button.dataset.languageOption === language;

            button.classList.toggle('is-active', isActive);
            button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
    }

    function applyPageMetadata(language) {
        var container = document.querySelector(SECTION_SELECTOR);
        var section = container ? container.dataset.section : null;
        var localizedMetadata = section && pageMetadata[language] ? pageMetadata[language][section] : null;
        var fallbackMetadata = section && pageMetadata[DEFAULT_LANGUAGE] ? pageMetadata[DEFAULT_LANGUAGE][section] : null;
        var metadata = localizedMetadata || fallbackMetadata;

        if (!metadata) {
            return;
        }

        if (metadata.title) {
            document.title = metadata.title;

            [
                'meta[property="og:title"]',
                'meta[name="twitter:title"]'
            ].forEach(function (selector) {
                var metaTag = document.querySelector(selector);

                if (metaTag) {
                    metaTag.setAttribute('content', metadata.title);
                }
            });
        }

        if (metadata.description) {
            [
                'meta[name="description"]',
                'meta[property="og:description"]',
                'meta[name="twitter:description"]'
            ].forEach(function (selector) {
                var metaTag = document.querySelector(selector);

                if (metaTag) {
                    metaTag.setAttribute('content', metadata.description);
                }
            });
        }
    }

    function applyLanguage(language) {
        var activeLanguage = normalizeLanguage(language);

        document.documentElement.lang = activeLanguage;

        document.querySelectorAll('[data-i18n]').forEach(function (element) {
            translateElement(element, activeLanguage);
        });

        document.querySelectorAll('[data-i18n-placeholder]').forEach(function (element) {
            translatePlaceholder(element, activeLanguage);
        });

        document.querySelectorAll('[data-i18n-alt]').forEach(function (element) {
            translateAlt(element, activeLanguage);
        });

        applyPageMetadata(activeLanguage);

        syncLanguageButtons(activeLanguage);

        document.dispatchEvent(new CustomEvent('rogerlab:language-changed', {
            detail: { language: activeLanguage }
        }));
    }

    function handleLanguageSelection(event) {
        var button = event.target.closest('[data-language-option]');

        if (!button) {
            return;
        }

        event.preventDefault();

        var language = normalizeLanguage(button.dataset.languageOption);

        setStoredLanguage(language);
        applyLanguage(language);
    }

    function initLanguageSwitcher() {
        applyLanguage(getStoredLanguage());
    }

    document.addEventListener('click', handleLanguageSelection);
    document.addEventListener('DOMContentLoaded', initLanguageSwitcher);
    document.addEventListener('partial:navigation:loaded', initLanguageSwitcher);
}());