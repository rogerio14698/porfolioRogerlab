(function () {
    'use strict';

    var STORAGE_KEY = 'rogerlab.language';
    var DEFAULT_LANGUAGE = 'es';
    var SUPPORTED_LANGUAGES = ['es', 'en', 'pt'];

    var translations = {
        es: {
            'nav.home': 'Inicio',
            'nav.about': 'Sobre mi',
            'nav.articles': 'Articulos',
            'nav.projects': 'Proyectos',
            'nav.juegos': 'Juegos JavaScript',
            'nav.contact': 'Contacto',
            'games.back': 'Volver a juegos',
            'games.hangman.card.alt': 'Juego del ahorcado',
            'games.hangman.card.title': 'Juego del ahorcado',
            'games.hangman.card.body_1': 'Este juego del ahorcado pone a prueba tu vocabulario y rapidez mental: debes adivinar la palabra oculta letra por letra antes de completar el dibujo. Incluye una interfaz clara, feedback inmediato en cada intento y una experiencia pensada para jugar de forma fluida desde cualquier dispositivo.',
            'games.hangman.card.body_2': 'Lo desarrolle como parte de mi portafolio para demostrar logica de programacion, manejo del estado del juego y organizacion del codigo en componentes reutilizables. El objetivo fue combinar funcionalidad, rendimiento y una presentacion visual consistente con el resto del sitio.',
            'games.hangman.card.cta': 'Jugar al ahorcado',
            'games.hangman.input_placeholder': 'Escribe una letra',
            'games.hangman.try': 'Intentar',
            'games.hangman.restart': 'Reiniciar juego',
            'games.dungeon.card.alt': 'Mazmorra impia',
            'games.dungeon.card.title': 'Mazmorra impia',
            'games.dungeon.card.cta': 'Jugar a Mazmorra impia',
            'home.intro.body': 'Disfruto el desarrollo web porque me permite transformar ideas en soluciones practicas, y mi objetivo es entregar un trabajo agil, eficaz y de alta calidad en cada reto que aparece. Me gusta analizar proyectos, detectar lo que no esta funcionando, mejorar sistemas existentes y conseguir que todo sea mas claro, mas estable y mas facil de mantener desde el primer dia.',
            'articles.visits.title': '¿Que necesita una web para convertir visitas en clientes?',
            'articles.visits.intro': 'Tener una web bonita ya no es suficiente. Para generar resultados reales en 2026, tu sitio debe cumplir con estos pilares:',
            'articles.visits.item_1': 'Velocidad extrema: si tarda mas de 2 segundos en cargar, el 50% de los usuarios se ira.',
            'articles.visits.item_2': 'Propuesta de valor clara: el usuario debe entender que haces y por que elegirte en los primeros 5 segundos.',
            'articles.visits.item_3': 'Prueba social: testimonios reales, logos de clientes y casos de exito que generen confianza inmediata.',
            'articles.visits.item_4': 'Llamada a la accion (CTA): botones visibles y directos como Empieza hoy o Reserva tu cita.',
            'articles.pricing.title': '¿Cuanto cuesta una pagina web en Espana en 2026?',
            'articles.pricing.intro': 'El precio de una web profesional en 2026 varia segun su complejidad y objetivos. Actualmente, el mercado se mueve en estos rangos medios:',
            'articles.pricing.item_1': 'Landing Page: desde 800€ hasta 2.000€. Ideal para campanas especificas.',
            'articles.pricing.item_2': 'Web corporativa (Pyme): entre 1.500€ y 4.500€. Incluye servicios, contacto y blog.',
            'articles.pricing.item_3': 'E-commerce (Tienda online): desde 3.000€ hasta mas de 10.000€ segun el catalogo y las pasarelas de pago.',
            'articles.pricing.note': 'Nota: en 2026, factores como la optimizacion para buscadores de IA (GEO) y la seguridad avanzada con firewalls activos son esenciales en cualquier presupuesto profesional.',
            'articles.landing.title': 'Landing Page vs Web Completa: ¿Que elegir?',
            'articles.landing.head_1': 'Opcion',
            'articles.landing.head_2': 'Cuando elegirla',
            'articles.landing.head_3': 'Objetivo principal',
            'articles.landing.row_1_col_1': 'Landing Page',
            'articles.landing.row_1_col_2': 'Lanzamiento de un producto o campana de anuncios.',
            'articles.landing.row_1_col_3': 'Conversion rapida (venta o lead).',
            'articles.landing.row_2_col_1': 'Web Completa',
            'articles.landing.row_2_col_2': 'Negocios que buscan autoridad y presencia a largo plazo.',
            'articles.landing.row_2_col_3': 'Informar, educar y posicionar en Google (SEO).',
            'articles.hiring.title': 'Errores comunes al contratar un desarrollador web',
            'articles.hiring.intro': 'Evita estos fallos para que tu inversion no se convierta en un gasto:',
            'articles.hiring.item_1': 'Elegir solo por precio: una web de 300€ suele carecer de seguridad y soporte, y puede quedar expuesta a hackeos en pocas semanas.',
            'articles.hiring.item_2': 'No ser dueno de tu hosting o dominio: asegurate siempre de que las cuentas esten a tu nombre, no al del desarrollador.',
            'articles.hiring.item_3': 'Olvidar el mantenimiento: el software caduca. Una web sin actualizaciones de seguridad es un riesgo para tu negocio.',
            'articles.hiring.item_4': 'No definir objetivos: si no sabes que quieres que haga el usuario en tu web, el desarrollador tampoco podra guiarlo bien.',
            'projects.library.alt': 'Logo del proyecto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Diseno y desarrollo',
            'projects.library.body_1': 'Fue mi proyecto final del modulo de Desarrollo de Aplicaciones Web. Se trata de un sistema de gestion bibliotecaria que permite administrar colecciones, prestamos, devoluciones y consultas de catalogo. El proyecto se desarrollo con Laravel y MySQL.',
            'projects.library.body_2': 'En este proyecto me centre en construir una interfaz clara para el usuario y en asegurar que la funcionalidad respondiera a los requisitos planteados en el modulo DAW.',
            'projects.content.alt': 'Logo del proyecto Gestor de Contenido',
            'projects.content.title': 'Gestor de Contenido',
            'projects.content.meta': 'Feb. 2026 | Desarrollo',
            'projects.content.body_1': 'Proyecto interno en el que participe durante mis practicas, centrado en la gestion y actualizacion de contenido dentro de una aplicacion real en entorno empresarial.',
            'projects.content.body_2': 'Mi trabajo estuvo orientado a revisar flujos existentes, mejorar la estructura del sistema y facilitar futuras actualizaciones del contenido por parte del equipo.',
            'projects.time.alt': 'Logo del proyecto Gestor de Fichaje',
            'projects.time.title': 'Gestor de Fichaje',
            'projects.time.meta': 'Ene. 2026 | Desarrollo',
            'projects.time.body_1': 'Aplicacion enfocada en el control horario y la gestion de fichajes, pensada para registrar entradas, salidas e incidencias dentro del flujo laboral diario.',
            'projects.time.body_2': 'En este proyecto trabaje en la mejora de procesos internos, revision de logica de negocio y adaptacion de la interfaz para hacer el sistema mas claro y util para el usuario final.',
            'projects.portfolio.alt': 'Logo del portfolio Roger Lab',
            'projects.portfolio.title': 'Portfolio Web',
            'projects.portfolio.meta': 'Abr. 2026 | Diseno y desarrollo',
            'projects.portfolio.body_1': 'Disene y desarrolle este portfolio personal con Laravel, HTML, CSS y JavaScript para mostrar mis proyectos, habilidades tecnicas y experiencia de forma profesional y clara.',
            'projects.portfolio.body_2': 'Me inspire en diferentes portfolios y webs de referencia para crear una identidad visual propia que reflejara mejor mi estilo de trabajo y mi forma de presentar soluciones digitales.',
            'about.learning.title': '¿Como aprendi a desarrollar?',
            'about.learning.body_1': 'Desde siempre me ha llamado la atencion este mundo, y siempre he trasteado en foros y videos por internet, creando pequenos proyectos personales que eran, sobre todo, pruebas para aprender y mejorar.',
            'about.learning.body_2': 'Durante mis practicas participe en proyectos reales dentro de empresa, colaborando en tareas de desarrollo, revision de flujos y mejora de estructuras internas. Esa etapa me ayudo a trabajar con mas criterio tecnico, organizacion y enfoque profesional.',
            'about.learning.body_3': 'Despues quise profundizar y empece a formarme de manera mas seria con cursos en Udemy y, posteriormente, con el grado en Desarrollo de Aplicaciones Web.',
            'about.learning.button': 'Ver informe de practicas',
            'about.methodology.title': '¿Cual es mi metodologia de trabajo?',
            'about.methodology.body_1': 'No me limito a escribir codigo; me gusta entender el porque de cada solucion. Intento seguir buenas practicas, como el codigo limpio, y me enfoco en crear soluciones que sean escalables, mantenibles y utiles para el negocio.',
            'about.methodology.body_2': 'Creo firmemente en la documentacion y en el control de versiones, por lo que mis repositorios mantienen una estructura clara y organizada para facilitar futuras mejoras.',
            'about.specialization.title': '¿En que me estoy especializando ahora?',
            'about.specialization.body_1': 'El aprendizaje en este sector nunca termina. Actualmente, estoy profundizando en tecnologias como React y Node.js para reforzar mi perfil como desarrollador full stack.',
            'about.specialization.body_2': 'Mi objetivo a corto plazo es dominar mejor el despliegue de aplicaciones en la nube y seguir colaborando en proyectos que aporten valor real y experiencia tecnica solida.',
            'about.repository.title': '¿Puedo usar mis codigos del repositorio?',
            'about.repository.body_1': 'Claro. Son proyectos funcionales pensados para mostrar como trabajo y como estructuro el codigo. Una vez entiendes el contexto, puedes revisarlos y utilizarlos como referencia sin problema.',
            'about.repository.button': 'Repositorio',
            'contact.title': 'Contacto',
            'contact.form.company': 'Empresa',
            'contact.form.name': 'Nombre',
            'contact.form.subject': 'Asunto',
            'contact.form.email': 'Correo electronico',
            'contact.form.message': 'Mensaje',
            'contact.form.subject_placeholder': 'Necesito una web para mi negocio',
            'contact.form.email_placeholder': 'ejemplo@email.com',
            'contact.form.message_placeholder': 'Cuentame tu proyecto, el contexto y el plazo que tienes en mente.',
            'contact.form.notice': 'Antes de que el mensaje llegue al administrador, debes confirmar tu direccion de correo mediante un enlace de verificacion.',
            'contact.form.submit': 'Enviar mensaje',
            'footer.rights': '© {year} Roger Lab. Todos los derechos reservados.',
            'footer.privacy': 'Politica de privacidad',
            'footer.terms': 'Terminos del servicio',
            'footer.cookies': 'Politica de cookies'
        },
        en: {
            'nav.home': 'Home',
            'nav.about': 'About',
            'nav.articles': 'Articles',
            'nav.projects': 'Projects',
            'nav.juegos': 'JavaScript Games',
            'nav.contact': 'Contact',
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
            'home.intro.body': 'I enjoy web development because it allows me to transform ideas into practical solutions, and my goal is to deliver agile, effective, and high quality work in every challenge that appears. I like analyzing projects, identifying what is not working, improving existing systems, and making everything clearer, more stable, and easier to maintain from day one.',
            'articles.visits.title': 'What does a website need to turn visits into clients?',
            'articles.visits.intro': 'A nice looking website is no longer enough. To generate real results in 2026, your site must meet these core pillars:',
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
            'articles.landing.title': 'Landing Page vs Full Website: which one should you choose?',
            'articles.landing.head_1': 'Option',
            'articles.landing.head_2': 'When to choose it',
            'articles.landing.head_3': 'Main goal',
            'articles.landing.row_1_col_1': 'Landing Page',
            'articles.landing.row_1_col_2': 'Launching a product or an ad campaign.',
            'articles.landing.row_1_col_3': 'Fast conversion (sale or lead).',
            'articles.landing.row_2_col_1': 'Full Website',
            'articles.landing.row_2_col_2': 'Businesses seeking authority and long term presence.',
            'articles.landing.row_2_col_3': 'Inform, educate, and rank on Google (SEO).',
            'articles.hiring.title': 'Common mistakes when hiring a web developer',
            'articles.hiring.intro': 'Avoid these mistakes so your investment does not turn into wasted money:',
            'articles.hiring.item_1': 'Choosing only by price: a €300 website usually lacks security and support, and can become vulnerable to hacks within weeks.',
            'articles.hiring.item_2': 'Not owning your hosting or domain: make sure those accounts are always under your name, not the developer’s.',
            'articles.hiring.item_3': 'Ignoring maintenance: software becomes outdated. A website without security updates is a risk for your business.',
            'articles.hiring.item_4': 'Not defining goals: if you do not know what you want users to do on your site, the developer will not be able to guide the project properly.',
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
            'about.learning.title': 'How did I learn to develop?',
            'about.learning.body_1': 'I have always been drawn to this field, and I have spent years exploring forums, tutorials, and small personal projects that helped me learn by building.',
            'about.learning.body_2': 'During my internship I took part in real company projects, contributing to development tasks, reviewing workflows, and improving internal structures. That stage helped me work with stronger technical judgment, better organization, and a more professional mindset.',
            'about.learning.body_3': 'Later, I decided to go deeper and study more seriously through Udemy courses and, after that, the Web Application Development degree.',
            'about.learning.button': 'Open internship report',
            'about.methodology.title': 'What is my working methodology?',
            'about.methodology.body_1': 'I do not just write code; I like to understand the reason behind each solution. I follow solid practices such as clean code and focus on building solutions that are scalable, maintainable, and useful for the business.',
            'about.methodology.body_2': 'I strongly believe in documentation and version control, so my repositories keep a clear and organized structure that makes future improvements easier.',
            'about.specialization.title': 'What am I specializing in right now?',
            'about.specialization.body_1': 'Learning never really ends in this field. Right now, I am going deeper into technologies such as React and Node.js to strengthen my full stack profile.',
            'about.specialization.body_2': 'My short term goal is to improve further in cloud deployment and keep contributing to projects that provide real value and solid technical experience.',
            'about.repository.title': 'Can you use my repository code?',
            'about.repository.body_1': 'Yes. These are functional projects designed to show how I work and how I structure code. Once you understand the context, you can review them and use them as a reference without any issue.',
            'about.repository.button': 'Repository',
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
            'nav.home': 'Inicio',
            'nav.about': 'Sobre mim',
            'nav.articles': 'Artigos',
            'nav.projects': 'Projetos',
            'nav.juegos': 'Jogos JavaScript',
            'nav.contact': 'Contacto',
            'games.back': 'Voltar aos jogos',
            'games.hangman.card.alt': 'Jogo da forca',
            'games.hangman.card.title': 'Jogo da forca',
            'games.hangman.card.body_1': 'Este jogo da forca poe a prova o teu vocabulario e rapidez mental: tens de adivinhar a palavra escondida letra a letra antes de completar o desenho. Inclui uma interface clara, feedback imediato em cada tentativa e uma experiencia pensada para jogar de forma fluida em qualquer dispositivo.',
            'games.hangman.card.body_2': 'Desenvolvi-o como parte do meu portfolio para demonstrar logica de programacao, gestao do estado do jogo e organizacao do codigo em componentes reutilizaveis. O objetivo foi combinar funcionalidade, desempenho e uma apresentacao visual consistente com o resto do site.',
            'games.hangman.card.cta': 'Jogar forca',
            'games.hangman.input_placeholder': 'Escreve uma letra',
            'games.hangman.try': 'Tentar',
            'games.hangman.restart': 'Reiniciar jogo',
            'games.dungeon.card.alt': 'Masmorra impia',
            'games.dungeon.card.title': 'Masmorra impia',
            'games.dungeon.card.cta': 'Jogar Masmorra impia',
            'home.intro.body': 'Gosto de desenvolvimento web porque me permite transformar ideias em solucoes praticas, e o meu objetivo e entregar um trabalho agil, eficaz e de alta qualidade em cada desafio. Gosto de analisar projetos, detetar o que nao esta a funcionar, melhorar sistemas existentes e fazer com que tudo fique mais claro, mais estavel e mais facil de manter desde o primeiro dia.',
            'articles.visits.title': 'O que precisa um site para transformar visitas em clientes?',
            'articles.visits.intro': 'Ter um site bonito ja nao e suficiente. Para gerar resultados reais em 2026, o teu site precisa destes pilares:',
            'articles.visits.item_1': 'Velocidade extrema: se demorar mais de 2 segundos a carregar, 50% dos utilizadores vao sair.',
            'articles.visits.item_2': 'Proposta de valor clara: o utilizador tem de perceber o que fazes e porque te deve escolher nos primeiros 5 segundos.',
            'articles.visits.item_3': 'Prova social: testemunhos reais, logos de clientes e casos de sucesso que gerem confianca imediata.',
            'articles.visits.item_4': 'Chamada para a acao (CTA): botoes visiveis e diretos, como Comeca hoje ou Marca a tua reuniao.',
            'articles.pricing.title': 'Quanto custa um site em Espanha em 2026?',
            'articles.pricing.intro': 'O preco de um site profissional em 2026 varia conforme a sua complexidade e objetivos. Atualmente, o mercado move-se nestas faixas medias:',
            'articles.pricing.item_1': 'Landing Page: de 800€ a 2.000€. Ideal para campanhas especificas.',
            'articles.pricing.item_2': 'Site corporativo (PME): entre 1.500€ e 4.500€. Inclui servicos, contacto e blog.',
            'articles.pricing.item_3': 'Loja online: de 3.000€ a mais de 10.000€, dependendo do catalogo e das integracoes de pagamento.',
            'articles.pricing.note': 'Nota: em 2026, fatores como a otimizacao para motores de busca com IA (GEO) e a seguranca avancada com firewalls ativos sao essenciais em qualquer orcamento profissional.',
            'articles.landing.title': 'Landing Page vs Site Completo: o que escolher?',
            'articles.landing.head_1': 'Opcao',
            'articles.landing.head_2': 'Quando escolher',
            'articles.landing.head_3': 'Objetivo principal',
            'articles.landing.row_1_col_1': 'Landing Page',
            'articles.landing.row_1_col_2': 'Lancamento de um produto ou campanha de anuncios.',
            'articles.landing.row_1_col_3': 'Conversao rapida (venda ou lead).',
            'articles.landing.row_2_col_1': 'Site Completo',
            'articles.landing.row_2_col_2': 'Negocios que procuram autoridade e presenca a longo prazo.',
            'articles.landing.row_2_col_3': 'Informar, educar e posicionar no Google (SEO).',
            'articles.hiring.title': 'Erros comuns ao contratar um programador web',
            'articles.hiring.intro': 'Evita estes erros para que o teu investimento nao se transforme num gasto inutil:',
            'articles.hiring.item_1': 'Escolher apenas pelo preco: um site de 300€ costuma nao ter seguranca nem suporte e pode ficar vulneravel em poucas semanas.',
            'articles.hiring.item_2': 'Nao seres dono do teu hosting ou dominio: garante sempre que essas contas ficam em teu nome, e nao no nome do programador.',
            'articles.hiring.item_3': 'Esquecer a manutencao: o software envelhece. Um site sem atualizacoes de seguranca e um risco para o teu negocio.',
            'articles.hiring.item_4': 'Nao definir objetivos: se nao souberes o que queres que o utilizador faca no site, o programador tambem nao conseguira orientar bem o projeto.',
            'projects.library.alt': 'Logo do projeto Biblioteca DAW',
            'projects.library.title': 'Biblioteca DAW',
            'projects.library.meta': 'Abr. 2023 | Design e desenvolvimento',
            'projects.library.body_1': 'Foi o meu projeto final do modulo de Desenvolvimento de Aplicacoes Web. Trata-se de um sistema de gestao bibliotecaria que permite gerir colecoes, emprestimos, devolucoes e pesquisas no catalogo. O projeto foi desenvolvido com Laravel e MySQL.',
            'projects.library.body_2': 'Neste projeto foquei-me em construir uma interface clara para o utilizador e em garantir que a funcionalidade respondia aos requisitos definidos no modulo DAW.',
            'projects.content.alt': 'Logo do projeto Gestor de Conteudo',
            'projects.content.title': 'Gestor de Conteudo',
            'projects.content.meta': 'Fev. 2026 | Desenvolvimento',
            'projects.content.body_1': 'Projeto interno em que participei durante o meu estagio, focado na gestao e atualizacao de conteudo dentro de uma aplicacao empresarial real.',
            'projects.content.body_2': 'O meu trabalho esteve orientado para rever fluxos existentes, melhorar a estrutura do sistema e facilitar futuras atualizacoes de conteudo por parte da equipa.',
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
            'about.learning.title': 'Como aprendi a desenvolver?',
            'about.learning.body_1': 'Desde sempre me chamou a atencao este mundo, e fui aprendendo em foruns, videos e pequenos projetos pessoais que me ajudaram a ganhar pratica e criterio tecnico.',
            'about.learning.body_2': 'Durante o meu estagio participei em projetos reais dentro de empresa, colaborando em tarefas de desenvolvimento, revisao de fluxos e melhoria de estruturas internas. Essa fase ajudou-me a trabalhar com mais criterio tecnico, organizacao e uma abordagem mais profissional.',
            'about.learning.body_3': 'Mais tarde quis aprofundar mais a minha formacao e comecei com cursos na Udemy e, depois disso, com o curso de Desenvolvimento de Aplicacoes Web.',
            'about.learning.button': 'Ver relatorio de estagio',
            'about.methodology.title': 'Qual e a minha metodologia de trabalho?',
            'about.methodology.body_1': 'Nao me limito a escrever codigo; gosto de perceber o motivo por tras de cada solucao. Tento seguir boas praticas, como codigo limpo, e foco-me em criar solucoes escalaveis, manuteniveis e uteis para o negocio.',
            'about.methodology.body_2': 'Acredito muito na documentacao e no controlo de versoes, por isso os meus repositorios mantem uma estrutura clara e organizada para facilitar melhorias futuras.',
            'about.specialization.title': 'Em que me estou a especializar agora?',
            'about.specialization.body_1': 'A aprendizagem neste setor nunca termina. Neste momento, estou a aprofundar tecnologias como React e Node.js para reforcar o meu perfil full stack.',
            'about.specialization.body_2': 'O meu objetivo a curto prazo e melhorar ainda mais a parte de deploy na cloud e continuar a colaborar em projetos que tragam valor real e experiencia tecnica solida.',
            'about.repository.title': 'Podes usar o meu codigo do repositorio?',
            'about.repository.body_1': 'Claro. Sao projetos funcionais pensados para mostrar como trabalho e como estruturo o codigo. Depois de entenderes o contexto, podes revistos e usa-los como referencia sem problema.',
            'about.repository.button': 'Repositorio',
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