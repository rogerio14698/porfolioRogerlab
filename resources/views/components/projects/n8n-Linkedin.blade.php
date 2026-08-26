<div class="cardProject">
    <div class="logo">
        <img src="{{ asset('img/n8n-logo.png') }}" alt="Logo del proyecto n8n LinkedIn"
            data-i18n-alt="projects.n8n-linkedin.alt">
    </div>

    <div class="titleProject">
        <h2 data-i18n="projects.n8n-linkedin.title">N8n LinkedIn Workflow Búsqueda Empleo</h2>
        <p data-i18n="projects.n8n-linkedin.meta">Agosto 2026 | Automatización de Busqueda Empleo (HTTP)</p>
    </div>

    <div class="description">
        <p data-i18n="projects.n8n-linkedin.body_1">
            Proyecto de automatización de búsqueda de empleos en n8n, en el cual hice un flujo de trabajo
            en el cual se realiza búsquedas de empleos en Linkedin via browsless, y mediante código extrae lo necesario
            para
            que luego puedas aplicar a esa oferta.
            <br> <br>
            También implementé un filtro match score en el flujo para priorizar las ofertas que mejor se ajusten a los
            datos
            del CV.
            <br> <br>
            El proyecto también incluye la integración de APIs de Google Drive, Google Sheets y Google Docs, para
            almacenar, organizar datos
            y generar cartas de presentación personalizadas para cada oferta de empleo. Permitiendo un aplicar a ofertas
            de manera más eficiente y rápida. Sin perder la profesionalidad y personalización en el proceso de
            aplicación.

        </p>
        <br>
    </div>
    <div class="galeria galeria--n8n">
        <button type="button" class="galeria__item galeria__item--n8n" aria-label="Ampliar captura del proyecto n8n LinkedIn">
            <img src="{{ asset('img/workflow-linkedin.png') }}"
                alt="Captura del proyecto N8n LinkedIn Workflow Búsqueda Empleo"
                data-i18n-alt="projects.n8n-linkedin.body_2">
        </button>
    </div>
    <div class="alinearButton">
        <button class="btnRepo"
            onclick="window.open('https://github.com/rogerio14698/n8n-LinkedingJob', '_blank', 'noopener,noreferrer')">
            <span data-i18n="about.repository.button">Repositorio</span> <span>&rarr;</span>
        </button >
        {{-- Boton de descarga del JSON del flujo de trabajo --}}
       <button class="btnRepo">
         <a  href="{{ asset('n8n-JSON/workFlow-BusquedaEmpleo.json') }}" download="workFlow-BusquedaEmpleo.json" target="_blank" rel="noopener noreferrer">
            <span data-i18n="projects.n8n-linkedin.download">Descargar flujo de trabajo</span> <span>&rarr;</span>
        </a>
         </button>
    </div>
</div>
