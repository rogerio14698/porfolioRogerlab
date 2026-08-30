<article class="cardProject project-card">
    <div class="logo project-card__media">
        <img src="{{ asset('img/ContentManagement.png') }}" alt="Logo del proyecto Gestor de Contenido"
            data-i18n-alt="projects.content.alt">
    </div>

    <div class="titleProject">
        <h2 data-i18n="projects.content.title">Gestor de Contenido</h2>
        <div class="project-card__meta">
            <span class="project-card__badge">Feb. 2026</span>
            <span class="project-card__badge">Proyecto interno</span>
        </div>
    </div>

    <ul class="project-card__stack" aria-label="Tecnologías de Gestor de Contenido">
        <li>Laravel</li>
        <li>PHP</li>
        <li>MySQL</li>
    </ul>

    <div class="description">
        <p data-i18n="projects.content.body_1">
            Proyecto interno en entorno empresarial orientado a gestión de contenido: trabajé sobre una base Laravel/PHP
            con MySQL para estabilizar flujos de edición y publicación.
        </p>
        <p data-i18n="projects.content.body_2">Analicé lógica heredada, ajusté reglas de negocio y refiné componentes de
            interfaz en Blade + JavaScript para reducir fricción operativa en futuras iteraciones del equipo.
        </p>
    </div>
    <div class="galeria" data-gallery="gestor-contenido" data-base-src="{{ url('img/GestorContenido') }}"
        data-extension=".png" data-count="10" aria-label="Galeria de capturas del proyecto Gestor de Contenido">
    </div>
    <div class="project-card__actions">
        <span class="project-card__internal">Proyecto interno</span>
    </div>
</article>
