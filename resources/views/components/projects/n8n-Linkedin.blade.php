<article class="cardProject project-card">
    <div class="logo project-card__media">
        <img src="{{ asset('img/n8n-logo.png') }}" alt="Logo del proyecto n8n LinkedIn"
            data-i18n-alt="projects.n8n-linkedin.alt">
    </div>

    <div class="titleProject">
        <h2 data-i18n="projects.n8n-linkedin.title">N8n LinkedIn Workflow Búsqueda Empleo</h2>
        <div class="project-card__meta">
            <span class="project-card__badge">Agosto 2026</span>
            <span class="project-card__badge">Automatización</span>
        </div>
    </div>

    <ul class="project-card__stack" aria-label="Tecnologías de Automatización de Búsqueda de Empleo con n8n">
        <li>n8n</li>
        <li>JavaScript</li>
        <li>Google APIs</li>
        <li>OpenAI</li>
        <li>Docker/VPS</li>
    </ul>

    <div class="description">
        <p data-i18n="projects.n8n-linkedin.body_1">
            Proyecto de automatización de búsqueda de empleos en n8n, en el cual hice un flujo de trabajo
            en el cual se realiza búsquedas de empleos en Linkedin via browsless, y mediante código extrae lo necesario
            para que luego puedas aplicar a esa oferta.
        </p>
        <p data-i18n="projects.n8n-linkedin.body_2">
            También implementé un filtro match score en el flujo para priorizar las ofertas que mejor se ajusten a los
            datos del CV.
        </p>
        <p data-i18n="projects.n8n-linkedin.body_3">
            El proyecto también incluye la integración de APIs de Google Drive, Google Sheets y Google Docs, para
            almacenar, organizar datos y generar cartas de presentación personalizadas para cada oferta de empleo.
            Permitiendo un aplicar a ofertas de manera más eficiente y rápida sin perder la profesionalidad y
            personalización en el proceso de aplicación.
        </p>
    </div>
    <div class="galeria galeria--n8n">
        <button type="button" class="galeria__item" aria-label="Ampliar captura del proyecto n8n LinkedIn">
            <img src="{{ asset('img/workflow-linkedin.png') }}"
                alt="Captura del proyecto N8n LinkedIn Workflow Búsqueda Empleo"
                data-i18n-alt="projects.n8n-linkedin.preview_alt">
        </button>
    </div>
    <div class="alinearButton project-card__actions">
        <a class="btnRepo" href="https://github.com/rogerio14698/n8n-LinkedingJob" target="_blank"
            rel="noopener noreferrer" data-i18n="about.repository.button">Repositorio</a>
        <a class="btnWeb" href="{{ asset('n8n-JSON/workFlow-BusquedaEmpleo.json') }}"
            download="workFlow-BusquedaEmpleo.json" data-i18n="projects.n8n-linkedin.download">Descargar flujo</a>
    </div>
</article>
