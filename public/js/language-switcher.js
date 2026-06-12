(function () {
    'use strict';

    var STORAGE_KEY = 'rogerlab.language';
    var DEFAULT_LANGUAGE = 'es';
    var SUPPORTED_LANGUAGES = ['es', 'en', 'pt'];

    var translations = {
        es: {
            'nav.home': 'Inicio',
            'nav.about': 'Skills',
            'nav.fct': 'Prácticas FCT',
            'nav.articles': 'Blog',
            'nav.projects': 'Proyectos',
            'nav.juegos': 'Juegos JavaScript',
            'nav.contact': 'Contacto',
            'conocimientos.title.desarrollo': 'Desarrollo Backend y Frontend',
            'conocimientos.title.frameworks': 'Frameworks y Librerías',
            'conocimientos.title.datos': 'Bases de Datos y Servidores',
            'conocimientos.title.herramientas': 'Herramientas y DevOps',
            'conocimientos.title.cloud': 'Cloud Computing',
            'conocimientos.title.entornos': 'Entornos de Desarrollo y OS',
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
            'home.intro.body.part1': 'Hola, soy Rogério Lucas. Me dedico al desarrollo Full Stack con un enfoque muy claro: picar código limpio,estructurado y que resuelva problemas reales sin complicar las cosas. Me muevo cómodamente en todo el ciclo deuna aplicación, desde diseñar bases de datos y refactorizar lógica en el backend con Laravel, hasta optimizar elrendimiento en el frontend o pelearme con la configuración de contenedores en Docker. No busco simplemente quelas cosas funcionen; me importa que sean estables, escalables y fáciles de mantener en producción.',
            'home.intro.body.part2': 'Acabo de terminar mi formación superior en DAW y de foguearme en entornos reales gestionando desde despliegues en AWS hasta interacciones complejas con bases de datos. Si buscas a alguien que sepa analizar código heredado, solucionar bugs sin romper nada por el camino y aportar valor al equipo desde el primer día, echa un vistazo a mis proyectos o hablemos.',

            'articles.visits.title': '¿Qué necesita una web para convertir visitas en clientes?',
            'articles.visits.intro': 'Tener una web bonita ya no es suficiente. Para generar resultados reales en 2026, tu sitio debe cumplir con estos pilares:',
            'articles.visits.item_1': 'Velocidad extrema: si tarda más de 2 segundos en cargar, el 50 % de los usuarios se irá.',
            'articles.visits.item_2': 'Propuesta de valor clara: el usuario debe entender qué haces y por qué elegirte en los primeros 5 segundos.',
            'articles.visits.item_3': 'Prueba social: testimonios reales, logos de clientes y casos de éxito que generen confianza inmediata.',
            'articles.visits.item_4': 'Llamada a la acción (CTA): botones visibles y directos como Empieza hoy o Reserva tu cita.',
            'articles.pricing.title': '¿Cuánto cuesta una página web en España en 2026?',
            'articles.pricing.intro': 'El precio de una web profesional en 2026 varía según su complejidad y objetivos. Actualmente, el mercado se mueve en estos rangos medios:',
            'articles.pricing.item_1': 'Landing Page: desde 800€ hasta 2.000€. Ideal para campañas específicas.',
            'articles.pricing.item_2': 'Web corporativa (Pyme): entre 1.500€ y 4.500€. Incluye servicios, contacto y blog.',
            'articles.pricing.item_3': 'E-commerce (Tienda online): desde 3.000€ hasta más de 10.000€ según el catálogo y las pasarelas de pago.',
            'articles.pricing.note': 'Nota: en 2026, factores como la optimización para buscadores de IA (GEO) y la seguridad avanzada con firewalls activos son esenciales en cualquier presupuesto profesional.',
            'articles.landing.title': 'Landing Page vs Web completa: ¿Qué elegir?',
            'articles.landing.head_1': 'Opción',
            'articles.landing.head_2': 'Cuándo elegirla',
            'articles.landing.head_3': 'Objetivo principal',
            'articles.landing.row_1_col_1': 'Landing Page',
            'articles.landing.row_1_col_2': 'Lanzamiento de un producto o campaña de anuncios.',
            'articles.landing.row_1_col_3': 'Conversión rápida (venta o lead).',
            'articles.landing.row_2_col_1': 'Web completa',
            'articles.landing.row_2_col_2': 'Negocios que buscan autoridad y presencia a largo plazo.',
            'articles.landing.row_2_col_3': 'Informar, educar y posicionar en Google (SEO).',
            'articles.hiring.title': 'Errores comunes al contratar un desarrollador web',
            'articles.hiring.intro': 'Evita estos fallos para que tu inversión no se convierta en un gasto:',
            'articles.hiring.item_1': 'Elegir solo por precio: una web de 300€ suele carecer de seguridad y soporte, y puede quedar expuesta a hackeos en pocas semanas.',
            'articles.hiring.item_2': 'No ser dueño de tu hosting o dominio: asegúrate siempre de que las cuentas estén a tu nombre, no al del desarrollador.',
            'articles.hiring.item_3': 'Olvidar el mantenimiento: el software caduca. Una web sin actualizaciones de seguridad es un riesgo para tu negocio.',
            'articles.hiring.item_4': 'No definir objetivos: si no sabes qué quieres que haga el usuario en tu web, el desarrollador tampoco podrá guiarlo bien.',
            'articles.scaling.title': 'Menos picar código, más soluciones que escalan',
            'articles.scaling.intro': 'Escalar no consiste en producir más líneas de código, sino en resolver mejor los problemas que importan al negocio y al usuario.',
            'articles.scaling.item_1': 'Empieza por el problema: antes de programar, define con precisión el objetivo, la restricción y la métrica de éxito.',
            'articles.scaling.item_2': 'Diseña arquitectura simple: prefiere soluciones claras, modulares y fáciles de mantener frente a complejidad innecesaria.',
            'articles.scaling.item_3': 'Automatiza lo repetible: CI/CD, tests y validaciones reducen errores y permiten iterar con confianza.',
            'articles.scaling.item_4': 'Mide antes de optimizar: usa datos reales de rendimiento y uso para decidir qué mejorar primero.',
            'articles.scaling.item_5': 'Piensa en equipo: documentación, convenciones y código legible aceleran la colaboración y evitan deuda técnica.',
            'articles.scaling.note': 'Cuando el foco pasa de picar código a entregar valor, el software escala mejor en calidad, velocidad de entrega y experiencia de usuario.',
            'projects.library.alt': 'Logo del proyecto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Diseño y desarrollo',
            'projects.library.body_1': 'Fue mi proyecto final del módulo de Desarrollo de Aplicaciones Web. Se trata de un sistema de gestión bibliotecaria que permite administrar colecciones, préstamos, devoluciones y consultas de catálogo. El proyecto se desarrolló con Laravel y MySQL.',
            'projects.library.body_2': 'En este proyecto me centré en construir una interfaz clara para el usuario y en asegurar que la funcionalidad respondiera a los requisitos planteados en el módulo DAW.',
            'projects.content.alt': 'Logo del proyecto Gestor de Contenido',
            'projects.content.title': 'Gestor de Contenido',
            'projects.content.meta': 'Feb. 2026 | Desarrollo',
            'projects.content.body_1': 'Proyecto interno en el que participé durante mis prácticas, centrado en la gestión y actualización de contenido dentro de una aplicación real en entorno empresarial.',
            'projects.content.body_2': 'Mi trabajo estuvo orientado a revisar flujos existentes, mejorar la estructura del sistema y facilitar futuras actualizaciones del contenido por parte del equipo.',
            'projects.juegoRol.alt': 'Logo del proyecto Juego de Rol',
            'projects.juegoRol.title': 'Juego de Rol',
            'projects.juegoRol.meta': 'May. 2026 | Desarrollo y diseño',
            'projects.juegoRol.body_1': 'Juego modular en JavaScript con lógica separada de mapa, personajes, combate y estado. Usa plantillas claras y eventos para mantener el código ordenado.',
            'projects.juegoRol.body_2': 'Interfaz construida con HTML externo y scripts especializados; presenta la UI separada de la lógica para facilitar cambios y mantenimiento.',
            'projects.time.alt': 'Logo del proyecto Gestor de Fichaje',
            'projects.time.title': 'Gestor de Fichaje',
            'projects.time.meta': 'Ene. 2026 | Desarrollo',
            'projects.time.body_1': 'Aplicación enfocada en el control horario y la gestión de fichajes, pensada para registrar entradas, salidas e incidencias dentro del flujo laboral diario.',
            'projects.time.body_2': 'En este proyecto trabajé en la mejora de procesos internos, revisión de lógica de negocio y adaptación de la interfaz para hacer el sistema más claro y útil para el usuario final.',
            'projects.portfolio.alt': 'Logo del portfolio Roger Lab',
            'projects.portfolio.title': 'Portfolio Web',
            'projects.portfolio.meta': 'Abr. 2026 | Diseño y desarrollo',
            'projects.portfolio.body_1': 'Diseñé y desarrollé este portafolio personal con Laravel, HTML, CSS y JavaScript para mostrar mis proyectos, habilidades técnicas y experiencia de forma profesional y clara.',
            'projects.portfolio.body_2': 'Me inspiré en diferentes portfolios y webs de referencia para crear una identidad visual propia que reflejara mejor mi estilo de trabajo y mi forma de presentar soluciones digitales.',

            'about.methodology.title': '¿Cuál es mi metodología de trabajo?',
            'about.methodology.body_1': 'No me limito a escribir código; me gusta entender el porqué de cada solución. Intento seguir buenas prácticas, como el código limpio, y me enfoco en crear soluciones que sean escalables, mantenibles y útiles para el negocio.',
            'about.methodology.body_2': 'Creo firmemente en la documentación y en el control de versiones, por lo que mis repositorios mantienen una estructura clara y organizada para facilitar futuras mejoras.',
            'about.specialization.title': '¿En qué me estoy especializando ahora?',
            'about.specialization.body_1': 'El aprendizaje en este sector nunca termina. Actualmente, estoy profundizando en tecnologías como React y Node.js para reforzar mi perfil como desarrollador full stack.',
            'about.specialization.body_2': 'Mi objetivo a corto plazo es dominar mejor el despliegue de aplicaciones en la nube y seguir colaborando en proyectos que aporten valor real y experiencia técnica sólida.',
            'about.repository.title': '¿Puedo usar mis códigos del repositorio?',
            'about.repository.body_1': 'Claro. Son proyectos funcionales pensados para mostrar cómo trabajo y cómo estructuro el código. Una vez entiendes el contexto, puedes revisarlos y utilizarlos como referencia sin problema.',
            'about.repository.button': 'Repositorio',
            'about.website.button': 'Web',
            'contact.title': 'Contacto',
            'contact.form.company': 'Empresa',
            'contact.form.name': 'Nombre',
            'contact.form.subject': 'Asunto',
            'contact.form.email': 'Correo electrónico',
            'contact.form.message': 'Mensaje',
            'contact.form.subject_placeholder': 'Necesito una web para mi negocio',
            'contact.form.email_placeholder': 'ejemplo@email.com',
            'contact.form.message_placeholder': 'Cuéntame tu proyecto, el contexto y el plazo que tienes en mente.',
            'contact.form.notice': 'Antes de que el mensaje llegue al administrador, debes confirmar tu dirección de correo mediante un enlace de verificación.',
            'contact.form.submit': 'Enviar mensaje',
            'footer.rights': '© {year} Roger Lab. Todos los derechos reservados.',
            'footer.privacy': 'Política de privacidad',
            'footer.terms': 'Términos del servicio',
            'footer.cookies': 'Política de cookies'
        },
        en: {
            'nav.home': 'Home',
            'nav.about': 'Skills',
            'nav.fct': 'FCT Internship',
            'nav.articles': 'Blog',
            'nav.projects': 'Projects',
            'nav.juegos': 'JavaScript Games',
            'nav.contact': 'Contact',
            'conocimientos.title.desarrollo': 'Backend and Frontend Development',
            'conocimientos.title.frameworks': 'Frameworks and Libraries',
            'conocimientos.title.datos': 'Databases and Servers',
            'conocimientos.title.herramientas': 'Tools and DevOps',
            'conocimientos.title.cloud': 'Cloud Computing',
            'conocimientos.title.entornos': 'Development Environments and OS',
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
            'home.intro.body.part1': `Hi, I'm Rogério Lucas. I'm a full-stack developer with a very clear focus: writing clean, structured code that solves real-world problems without overcomplicating things. I'm comfortable working across the entire application lifecycle, from designing databases and refactoring backend logic with Laravel, to optimizing frontend performance or tackling container configuration in Docker. I don't just want things to work; I care about them being stable, scalable, and easy to maintain in production.` ,
            'home.intro.body.part2' : `I just finished my higher education in Web Application Development (DAW) and gained experience in real-world environments managing everything from AWS deployments to complex database interactions. If you're looking for someone who can analyze legacy code, fix bugs without breaking anything, and add value to the team from day one, check out my projects or let's talk.`,

            'articles.visits.title': 'What does a website need to turn visits into clients?',
            'articles.visits.intro': 'A nice-looking website is no longer enough. To generate real results in 2026, your site must meet these core pillars:',
            'articles.visits.item_1': 'Extreme speed: if it takes more than 2 seconds to load, 50% of users will leave.',
            'articles.visits.item_2': 'Clear value proposition: users must understand what you do and why they should choose you within the first 5 seconds.',
            'articles.visits.item_3': 'Social proof: real testimonials, client logos, and case studies that build immediate trust.',
            'articles.visits.item_4': 'Call to action (CTA): visible and direct buttons such as Start today or Book your call.',
            'articles.pricing.title': 'How much does a website cost in Spain in 2026?',
            'articles.pricing.intro': 'The price of a professional website in 2026 varies depending on its complexity and goals. At the moment, the market usually moves within these average ranges:',
            'articles.pricing.item_1': 'Landing Page: from €800 to €2,000. Ideal for specific campaigns.',
            'articles.pricing.item_2': 'Corporate Website (SME): between €1,500 and €4,500. Includes services, contact, and blog.',
            'articles.pricing.item_3': 'E-commerce Store: from €3,000 to more than €10,000 depending on the catalog and payment gateways.',
            'articles.pricing.note': 'Note: in 2026, factors such as optimization for AI search engines (GEO) and advanced security with active firewalls are essential in any professional budget.',
            'articles.landing.title': 'Landing Page vs Full Website: Which one should you choose?',
            'articles.landing.head_1': 'Option',
            'articles.landing.head_2': 'When to choose it',
            'articles.landing.head_3': 'Main goal',
            'articles.landing.row_1_col_1': 'Landing Page',
            'articles.landing.row_1_col_2': 'Launching a product or an ad campaign.',
            'articles.landing.row_1_col_3': 'Fast conversion (sale or lead).',
            'articles.landing.row_2_col_1': 'Full Website',
            'articles.landing.row_2_col_2': 'Businesses seeking authority and long-term presence.',
            'articles.landing.row_2_col_3': 'Inform, educate, and rank on Google (SEO).',
            'articles.hiring.title': 'Common mistakes when hiring a web developer',
            'articles.hiring.intro': 'Avoid these mistakes so your investment does not turn into wasted money:',
            'articles.hiring.item_1': 'Choosing only by price: a €300 website usually lacks security and support, and can become vulnerable to hacks within weeks.',
            'articles.hiring.item_2': 'Not owning your hosting or domain: make sure those accounts are always under your name, not the developer\'s.',
            'articles.hiring.item_3': 'Ignoring maintenance: software becomes outdated. A website without security updates is a risk for your business.',
            'articles.hiring.item_4': 'Not defining goals: if you do not know what you want users to do on your site, the developer will not be able to guide the project properly.',
            'articles.scaling.title': 'Less coding, more solutions that scale',
            'articles.scaling.intro': 'Scaling is not about producing more lines of code, but about solving the problems that matter most to business and users.',
            'articles.scaling.item_1': 'Start with the problem: before coding, clearly define the goal, constraints, and success metric.',
            'articles.scaling.item_2': 'Design simple architecture: prefer clear, modular, and maintainable solutions over unnecessary complexity.',
            'articles.scaling.item_3': 'Automate repeatable work: CI/CD, tests, and validations reduce errors and let teams iterate with confidence.',
            'articles.scaling.item_4': 'Measure before optimizing: use real performance and usage data to decide what to improve first.',
            'articles.scaling.item_5': 'Think as a team: documentation, conventions, and readable code speed up collaboration and reduce technical debt.',
            'articles.scaling.note': 'When the focus shifts from coding for its own sake to delivering value, software scales better in quality, delivery speed, and user experience.',
            'projects.library.alt': 'DAW Library project logo',
            'projects.library.title': 'DAW Library',
            'projects.library.meta': 'Apr. 2023 | Design and development',
            'projects.library.body_1': 'This was my final project for the Web Application Development module. It is a library management system that allows users to manage collections, loans, returns, and catalog searches. The project was built with Laravel and MySQL.',
            'projects.library.body_2': 'In this project I focused on building a clear user interface and ensuring the functionality matched the requirements defined in the DAW module.',
            'projects.content.alt': 'Content Manager project logo',
            'projects.content.title': 'Content Manager',
            'projects.content.meta': 'Feb. 2026 | Development',
            'projects.content.body_1': 'An internal project I worked on during my internship, focused on managing and updating content inside a real business application.',
            'projects.content.body_2': 'My work was focused on reviewing existing flows, improving system structure, and making future content updates easier for the team.',
            'projects.juegoRol.alt': 'Role-playing game project logo',
            'projects.juegoRol.title': 'Role-playing Game',
            'projects.juegoRol.meta': 'May 2026 | Development & Design',
            'projects.juegoRol.body_1': 'Modular JS game with separate map, character, combat, and state logic. Uses clear templates and events to keep the code organized.',
            'projects.juegoRol.body_2': 'UI built with external HTML templates and specialized scripts; presentation is kept separate from logic for easier maintenance.',
            'projects.time.alt': 'Time Tracking project logo',
            'projects.time.title': 'Time Tracking Manager',
            'projects.time.meta': 'Jan. 2026 | Development',
            'projects.time.body_1': 'An application focused on time tracking and attendance management, designed to record check-ins, check-outs, and incidents in daily workflows.',
            'projects.time.body_2': 'In this project I worked on improving internal processes, reviewing business logic, and adapting the interface to make the system clearer and more useful for end users.',
            'projects.portfolio.alt': 'Roger Lab portfolio logo',
            'projects.portfolio.title': 'Web Portfolio',
            'projects.portfolio.meta': 'Apr. 2026 | Design and development',
            'projects.portfolio.body_1': 'I designed and developed this personal portfolio with Laravel, HTML, CSS, and JavaScript to present my projects, technical skills, and experience in a professional and clear way.',
            'projects.portfolio.body_2': 'I used different portfolio references and design websites as inspiration to create a visual identity that better reflects my way of working and presenting digital solutions.',

            'about.methodology.title': 'What is my working methodology?',
            'about.methodology.body_1': 'I do not just write code; I like to understand the reason behind each solution. I follow solid practices such as clean code and focus on building solutions that are scalable, maintainable, and useful for the business.',
            'about.methodology.body_2': 'I strongly believe in documentation and version control, so my repositories keep a clear and organized structure that makes future improvements easier.',
            'about.specialization.title': 'What am I specializing in right now?',
            'about.specialization.body_1': 'Learning never really ends in this field. Right now, I am going deeper into technologies such as React and Node.js to strengthen my full-stack profile.',
            'about.specialization.body_2': 'My short-term goal is to improve further in cloud deployment and keep contributing to projects that provide real value and solid technical experience.',
            'about.repository.title': 'Can I use the code from the repository?',
            'about.repository.body_1': 'Yes. These are functional projects designed to show how I work and how I structure code. Once you understand the context, you can review them and use them as a reference without any issue.',
            'about.repository.button': 'Repository',
            'about.website.button': 'Web',
            'contact.title': 'Contact',
            'contact.form.company': 'Company',
            'contact.form.name': 'Name',
            'contact.form.subject': 'Subject',
            'contact.form.email': 'Email',
            'contact.form.message': 'Message',
            'contact.form.subject_placeholder': 'I need a website for my business',
            'contact.form.email_placeholder': 'example@email.com',
            'contact.form.message_placeholder': 'Tell me about your project, the context, and the timeline you have in mind.',
            'contact.form.notice': 'Before the message reaches the administrator, you must confirm your email address through a verification link.',
            'contact.form.submit': 'Send message',
            'footer.rights': '© {year} Roger Lab. All rights reserved.',
            'footer.privacy': 'Privacy Policy',
            'footer.terms': 'Terms of Service',
            'footer.cookies': 'Cookie Policy'
        },
        pt: {
            'nav.home': 'Início',
            'nav.about': 'Skills',
            'nav.fct': 'Estágio FCT',
            'nav.articles': 'Blog',
            'nav.projects': 'Projetos',
            'nav.juegos': 'Jogos JavaScript',
            'nav.contact': 'Contacto',
            'conocimientos.title.desarrollo': 'Desenvolvimento Backend e Frontend',
            'conocimientos.title.frameworks': 'Frameworks e Bibliotecas',
            'conocimientos.title.datos': 'Bases de Dados e Servidores',
            'conocimientos.title.herramientas': 'Ferramentas e DevOps',
            'conocimientos.title.cloud': 'Cloud Computing',
            'conocimientos.title.entornos': 'Ambientes de Desenvolvimento e SO',
            'practicas.modal.title': 'Acompanhamento detalhado do estágio:',
            'practicas.modal.open': 'Ver acompanhamento',
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
            'home.intro.body.part1': 'Olá, meu nome é Rogério Lucas. Sou um desenvolvedor Full Stack com um foco bem definido: escrever código limpo e estruturado que resolva problemas reais sem complicações desnecessárias. Tenho experiência em todas as etapas do ciclo de vida de uma aplicação, desde o design de bancos de dados e a refatoração da lógica de backend com Laravel, até a otimização do desempenho do frontend e a configuração de containers em Docker. Não me preocupo apenas com o funcionamento; quero que as coisas sejam estáveis, escaláveis ​​e fáceis de manter em produção.',
            'home.intro.body.part2': 'Acabei de concluir minha formação superior em Desenvolvimento de Aplicações Web (DAW) e adquiri experiência em ambientes reais, gerenciando desde implantações na AWS até interações complexas com bancos de dados. Se você procura alguém capaz de analisar código legado, corrigir bugs sem causar problemas e agregar valor à equipe desde o primeiro dia, confira meus projetos ou entre em contato.',

            'articles.visits.title': 'O que precisa um site para transformar visitas em clientes?',
            'articles.visits.intro': 'Ter um site bonito já não é suficiente. Para gerar resultados reais em 2026, o teu site precisa destes pilares:',
            'articles.visits.item_1': 'Velocidade extrema: se demorar mais de 2 segundos a carregar, 50% dos utilizadores vão sair.',
            'articles.visits.item_2': 'Proposta de valor clara: o utilizador tem de perceber o que fazes e por que te deve escolher nos primeiros 5 segundos.',
            'articles.visits.item_3': 'Prova social: testemunhos reais, logos de clientes e casos de sucesso que gerem confiança imediata.',
            'articles.visits.item_4': 'Chamada para a ação (CTA): botões visíveis e diretos, como Começa hoje ou Marca a tua reunião.',
            'articles.pricing.title': 'Quanto custa um site em Espanha em 2026?',
            'articles.pricing.intro': 'O preço de um site profissional em 2026 varia conforme a sua complexidade e objetivos. Atualmente, o mercado move-se nestas faixas médias:',
            'articles.pricing.item_1': 'Landing Page: de 800€ a 2.000€. Ideal para campanhas específicas.',
            'articles.pricing.item_2': 'Site corporativo (PME): entre 1.500€ e 4.500€. Inclui serviços, contacto e blog.',
            'articles.pricing.item_3': 'Loja online: de 3.000€ a mais de 10.000€, dependendo do catálogo e das integrações de pagamento.',
            'articles.pricing.note': 'Nota: em 2026, fatores como a otimização para motores de busca com IA (GEO) e a segurança avançada com firewalls ativos são essenciais em qualquer orçamento profissional.',
            'articles.landing.title': 'Landing Page vs Site completo: o que escolher?',
            'articles.landing.head_1': 'Opção',
            'articles.landing.head_2': 'Quando escolher',
            'articles.landing.head_3': 'Objetivo principal',
            'articles.landing.row_1_col_1': 'Landing Page',
            'articles.landing.row_1_col_2': 'Lançamento de um produto ou campanha de anúncios.',
            'articles.landing.row_1_col_3': 'Conversão rápida (venda ou lead).',
            'articles.landing.row_2_col_1': 'Site completo',
            'articles.landing.row_2_col_2': 'Negócios que procuram autoridade e presença a longo prazo.',
            'articles.landing.row_2_col_3': 'Informar, educar e posicionar no Google (SEO).',
            'articles.hiring.title': 'Erros comuns ao contratar um programador web',
            'articles.hiring.intro': 'Evita estes erros para que o teu investimento não se transforme num gasto inútil:',
            'articles.hiring.item_1': 'Escolher apenas pelo preço: um site de 300€ costuma não ter segurança nem suporte e pode ficar vulnerável em poucas semanas.',
            'articles.hiring.item_2': 'Não seres dono do teu hosting ou domínio: garante sempre que essas contas ficam em teu nome, e não no nome do programador.',
            'articles.hiring.item_3': 'Esquecer a manutenção: o software envelhece. Um site sem atualizações de segurança é um risco para o teu negócio.',
            'articles.hiring.item_4': 'Não definir objetivos: se não souberes o que queres que o utilizador faça no site, o programador também não conseguirá orientar bem o projeto.',
            'articles.scaling.title': 'Menos picar código, mais soluções que escalam',
            'articles.scaling.intro': 'Escalar não é produzir mais linhas de código, mas sim resolver melhor os problemas que realmente importam para o negócio e para o utilizador.',
            'articles.scaling.item_1': 'Começa pelo problema: antes de programar, define com clareza o objetivo, as restrições e a métrica de sucesso.',
            'articles.scaling.item_2': 'Desenha arquitetura simples: prefere soluções claras, modulares e fáceis de manter em vez de complexidade desnecessária.',
            'articles.scaling.item_3': 'Automatiza o repetível: CI/CD, testes e validações reduzem erros e permitem iterar com confiança.',
            'articles.scaling.item_4': 'Mede antes de otimizar: usa dados reais de desempenho e uso para decidir o que melhorar primeiro.',
            'articles.scaling.item_5': 'Pensa em equipa: documentação, convenções e código legível aceleram a colaboração e evitam dívida técnica.',
            'articles.scaling.note': 'Quando o foco muda de picar código para entregar valor, o software escala melhor em qualidade, velocidade de entrega e experiência do utilizador.',
            'projects.library.alt': 'Logo do projeto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Design e desenvolvimento',
            'projects.library.body_1': 'Foi o meu projeto final do modulo de Desenvolvimento de Aplicacoes Web. Trata-se de um sistema de gestao bibliotecaria que permite gerir colecoes, emprestimos, devolucoes e pesquisas no catalogo. O projeto foi desenvolvido com Laravel e MySQL.',
            'projects.library.body_2': 'Neste projeto foquei-me em construir uma interface clara para o utilizador e em garantir que a funcionalidade respondia aos requisitos definidos no modulo DAW.',
            'projects.content.alt': 'Logo do projeto Gestor de Conteudo',
            'projects.content.title': 'Gestor de Conteudo',
            'projects.content.meta': 'Fev. 2026 | Desenvolvimento',
            'projects.content.body_1': 'Projeto interno em que participei durante o meu estagio, focado na gestao e atualizacao de conteudo dentro de uma aplicacao empresarial real.',
            'projects.content.body_2': 'O meu trabalho esteve orientado para rever fluxos existentes, melhorar a estrutura do sistema e facilitar futuras actualizacoes de conteudo por parte da equipa.',
            'projects.juegoRol.alt': 'Logo do projeto Jogo de RPG',
            'projects.juegoRol.title': 'Jogo de RPG',
            'projects.juegoRol.meta': 'Mai. 2026 | Desenvolvimento e design',
            'projects.juegoRol.body_1': 'Jogo modular em JS com lógica separada de mapa, personagens, combate e estado. Usa templates claros e eventos para manter o código organizado.',
            'projects.juegoRol.body_2': 'Interface com HTML externo e scripts especializados; apresentação e lógica ficam separadas para facilitar a manutenção.',
            'projects.time.alt': 'Logo do projeto Gestor de Fichagem',
            'projects.time.title': 'Gestor de Fichagem',
            'projects.time.meta': 'Jan. 2026 | Desenvolvimento',
            'projects.time.body_1': 'Aplicacao orientada ao controlo horario e gestao de fichagens, pensada para registar entradas, saidas e incidencias dentro do fluxo laboral diario.',
            'projects.time.body_2': 'Neste projeto trabalhei na melhoria de processos internos, revisao da logica de negocio e adaptacao da interface para tornar o sistema mais claro e util para o utilizador final.',
            'projects.portfolio.alt': 'Logo do portfolio Roger Lab',
            'projects.portfolio.title': 'Portfolio Web',
            'projects.portfolio.meta': 'Abr. 2026 | Design e desenvolvimento',
            'projects.portfolio.body_1': 'Desenhei e desenvolvi este portfolio pessoal com Laravel, HTML, CSS e JavaScript para apresentar os meus projetos, competencias tecnicas e experiencia de forma profissional e clara.',
            'projects.portfolio.body_2': 'Inspirei-me em diferentes portfolios e websites de referencia para criar uma identidade visual propria que refletisse melhor a minha forma de trabalhar e apresentar solucoes digitais.',

            'about.methodology.title': 'Qual e a minha metodologia de trabalho?',
            'about.methodology.body_1': 'Nao me limito a escrever codigo; gosto de perceber o motivo por tras de cada solucao. Tento seguir boas praticas, como codigo limpo, e foco-me em criar solucoes escalaveis, manuteniveis e uteis para o negocio.',
            'about.methodology.body_2': 'Acredito muito na documentacao e no controlo de versoes, por isso os meus repositorios mantem uma estrutura clara e organizada para facilitar melhorias futuras.',
            'about.specialization.title': 'Em que me estou a especializar agora?',
            'about.specialization.body_1': 'A aprendizagem neste setor nunca termina. Neste momento, estou a aprofundar tecnologias como React e Node.js para reforcar o meu perfil full stack.',
            'about.specialization.body_2': 'O meu objetivo a curto prazo e melhorar ainda mais a parte de deploy na cloud e continuar a colaborar em projetos que tragam valor real e experiencia tecnica solida.',
            'about.repository.title': 'Podes usar o meu codigo do repositorio?',
            'about.repository.body_1': 'Claro. Sao projetos funcionais pensados para mostrar como trabalho e como estruturo o codigo. Depois de entenderes o contexto, podes revistos e usa-los como referencia sem problema.',
            'about.repository.button': 'Repositorio',
            'about.website.button': 'Web',
            'contact.title': 'Contacto',
            'contact.form.company': 'Empresa',
            'contact.form.name': 'Nome',
            'contact.form.subject': 'Assunto',
            'contact.form.email': 'Email',
            'contact.form.message': 'Mensagem',
            'contact.form.subject_placeholder': 'Preciso de um site para o meu negocio',
            'contact.form.email_placeholder': 'exemplo@email.com',
            'contact.form.message_placeholder': 'Conta-me sobre o teu projeto, o contexto e o prazo que tens em mente.',
            'contact.form.notice': 'Antes de a mensagem chegar ao administrador, tens de confirmar o teu email atraves de uma ligacao de verificacao.',
            'contact.form.submit': 'Enviar mensagem',
            'footer.rights': '© {year} Roger Lab. Todos os direitos reservados.',
            'footer.privacy': 'Politica de privacidade',
            'footer.terms': 'Termos do servico',
            'footer.cookies': 'Politica de cookies'
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