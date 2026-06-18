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
            'projects.library.alt': 'Logo del proyecto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Diseño y desarrollo',
            'projects.library.body_1': 'Fue mi proyecto final de Desarrollo de Aplicaciones Web. Construí un sistema de gestión bibliotecaria con Laravel y MySQL para administrar colecciones, préstamos, devoluciones y consultas de catálogo.',
            'projects.library.body_2': 'Me sirvió para consolidar estructura MVC, modelado de datos y una forma de trabajar ordenada de principio a fin sobre un proyecto completo.',
            'projects.content.alt': 'Logo del proyecto Gestor de Contenido',
            'projects.content.title': 'Gestor de Contenido',
            'projects.content.meta': 'Feb. 2026 | Desarrollo',
            'projects.content.body_1': 'Proyecto interno en el que participé durante las prácticas, centrado en la gestión y actualización de contenido dentro de una aplicación usada en entorno empresarial.',
            'projects.content.body_2': 'Mi aportación estuvo en revisar flujos existentes, entender restricciones de una base real y dejar el sistema más claro para futuras actualizaciones del equipo.',
            'projects.juegoRol.alt': 'Logo del proyecto Juego de Rol',
            'projects.juegoRol.title': 'Juego de Rol',
            'projects.juegoRol.meta': 'May. 2026 | Desarrollo y diseño',
            'projects.juegoRol.body_1': 'Juego modular en JavaScript con lógica separada de mapa, personajes, combate y estado. Usa plantillas claras y eventos para mantener el código ordenado.',
            'projects.juegoRol.body_2': 'Interfaz construida con HTML externo y scripts especializados; presenta la UI separada de la lógica para facilitar cambios y mantenimiento.',
            'projects.time.alt': 'Logo del proyecto Gestor de Fichaje',
            'projects.time.title': 'Gestor de Fichaje',
            'projects.time.meta': 'Ene. 2026 | Desarrollo',
            'projects.time.body_1': 'Aplicación centrada en control horario y gestión de fichajes, diseñada para registrar entradas, salidas e incidencias dentro del flujo laboral diario.',
            'projects.time.body_2': 'Aquí trabajé sobre procesos internos, revisión de lógica de negocio y pequeños ajustes de interfaz para hacer el sistema más comprensible para el usuario final.',
            'projects.portfolio.alt': 'Logo del portfolio Roger Lab',
            'projects.portfolio.title': 'Portfolio Web',
            'projects.portfolio.meta': 'Abr. 2026 | Diseño y desarrollo',
            'projects.portfolio.body_1': 'Diseñé y desarrollé este portfolio con Laravel, HTML, CSS y JavaScript para presentar mis proyectos, mi forma de trabajar y el tipo de perfil que quiero aportar a una empresa.',
            'projects.portfolio.body_2': 'Más que vender servicios, la intención es enseñar con claridad cómo estructuro una aplicación, cómo escribo el código y qué decisiones tomo al construir una interfaz.',

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
            'projects.library.alt': 'DAW Library project logo',
            'projects.library.title': 'DAW Library',
            'projects.library.meta': 'Apr. 2023 | Design and development',
            'projects.library.body_1': 'This was my final project in Web Application Development. I built a library management system with Laravel and MySQL to handle collections, loans, returns, and catalog searches.',
            'projects.library.body_2': 'It helped me consolidate MVC structure, data modeling, and an orderly way of working from start to finish on a complete project.',
            'projects.content.alt': 'Content Manager project logo',
            'projects.content.title': 'Content Manager',
            'projects.content.meta': 'Feb. 2026 | Development',
            'projects.content.body_1': 'An internal project I contributed to during my internship, focused on managing and updating content inside a real business application.',
            'projects.content.body_2': 'My contribution was to review existing flows, understand real constraints, and leave the system clearer for future updates by the team.',
            'projects.juegoRol.alt': 'Role-playing game project logo',
            'projects.juegoRol.title': 'Role-playing Game',
            'projects.juegoRol.meta': 'May 2026 | Development & Design',
            'projects.juegoRol.body_1': 'Modular JS game with separate map, character, combat, and state logic. Uses clear templates and events to keep the code organized.',
            'projects.juegoRol.body_2': 'UI built with external HTML templates and specialized scripts; presentation is kept separate from logic for easier maintenance.',
            'projects.time.alt': 'Time Tracking project logo',
            'projects.time.title': 'Time Tracking Manager',
            'projects.time.meta': 'Jan. 2026 | Development',
            'projects.time.body_1': 'An application focused on time tracking and attendance management, designed to record check-ins, check-outs, and incidents in daily workflows.',
            'projects.time.body_2': 'Here I worked on internal processes, business-logic review, and small interface adjustments to make the system easier for end users to understand.',
            'projects.portfolio.alt': 'Roger Lab portfolio logo',
            'projects.portfolio.title': 'Web Portfolio',
            'projects.portfolio.meta': 'Apr. 2026 | Design and development',
            'projects.portfolio.body_1': 'I designed and developed this portfolio with Laravel, HTML, CSS, and JavaScript to present my projects, my way of working, and the type of profile I want to bring to a company.',
            'projects.portfolio.body_2': 'More than selling services, the goal is to clearly show how I structure an application, how I write code, and what decisions I make when building an interface.',

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
            'projects.library.alt': 'Logo do projeto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Design e desenvolvimento',
            'projects.library.body_1': 'Foi o meu projeto final de Desenvolvimento de Aplicações Web. Construí um sistema de gestão bibliotecária com Laravel e MySQL para gerir coleções, empréstimos, devoluções e pesquisa em catálogo.',
            'projects.library.body_2': 'Serviu para consolidar estrutura MVC, modelação de dados e uma forma organizada de trabalhar do início ao fim num projeto completo.',
            'projects.content.alt': 'Logo do projeto Gestor de Conteudo',
            'projects.content.title': 'Gestor de Conteudo',
            'projects.content.meta': 'Fev. 2026 | Desenvolvimento',
            'projects.content.body_1': 'Projeto interno em que participei durante o estágio, focado na gestão e atualização de conteúdo dentro de uma aplicação empresarial real.',
            'projects.content.body_2': 'A minha contribuição esteve em rever fluxos existentes, entender restrições reais e deixar o sistema mais claro para futuras atualizações da equipa.',
            'projects.juegoRol.alt': 'Logo do projeto Jogo de RPG',
            'projects.juegoRol.title': 'Jogo de RPG',
            'projects.juegoRol.meta': 'Mai. 2026 | Desenvolvimento e design',
            'projects.juegoRol.body_1': 'Jogo modular em JS com lógica separada de mapa, personagens, combate e estado. Usa templates claros e eventos para manter o código organizado.',
            'projects.juegoRol.body_2': 'Interface com HTML externo e scripts especializados; apresentação e lógica ficam separadas para facilitar a manutenção.',
            'projects.time.alt': 'Logo do projeto Gestor de Fichagem',
            'projects.time.title': 'Gestor de Fichagem',
            'projects.time.meta': 'Jan. 2026 | Desenvolvimento',
            'projects.time.body_1': 'Aplicação orientada ao controlo horário e gestão de fichagens, pensada para registar entradas, saídas e incidências no fluxo laboral diário.',
            'projects.time.body_2': 'Neste projeto trabalhei sobre processos internos, revisão de lógica de negócio e pequenos ajustes de interface para tornar o sistema mais claro para o utilizador final.',
            'projects.portfolio.alt': 'Logo do portfolio Roger Lab',
            'projects.portfolio.title': 'Portfolio Web',
            'projects.portfolio.meta': 'Abr. 2026 | Design e desenvolvimento',
            'projects.portfolio.body_1': 'Desenhei e desenvolvi este portfólio com Laravel, HTML, CSS e JavaScript para apresentar os meus projetos, a minha forma de trabalhar e o tipo de perfil que quero levar para uma empresa.',
            'projects.portfolio.body_2': 'Mais do que vender serviços, a intenção é mostrar com clareza como estruturo uma aplicação, como escrevo código e que decisões tomo ao construir uma interface.',

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
                description: 'Selección de proyectos académicos, personales y de prácticas con Laravel, JavaScript, bases de datos y despliegue.'
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
                description: 'Selection of academic, personal, and internship projects built with Laravel, JavaScript, databases, and deployment tooling.'
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
                description: 'Seleção de projetos académicos, pessoais e de estágio com Laravel, JavaScript, bases de dados e deploy.'
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