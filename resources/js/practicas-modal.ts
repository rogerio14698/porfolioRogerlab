(function () {
    'use strict';

    var SUPPORTED_LANGUAGES = ['es', 'en', 'pt'];

    var PRACTICAS_DATA = {
        es: {
            info_general: {
                alumno: 'Viana Teixeira, Rogerio Lucas',
                centro_docente: 'CFPE TUNIVERS FORMACION',
                ciclo_formativo: 'Desarrollo de Aplicaciones Web (LFP)',
                clave_ciclo: 'IFC-303',
                empresa: 'MON EVENT SL',
                tutor_empresa: 'Paz Rellan Lopez',
                tutor_docente: 'Mario Alvarez Fernandez'
            },
            seguimiento_detallado: [
            {
                periodo: '02/02/2026 al 06/02/2026',
                dias: [
                    { jornada: 1, actividad: 'Realizacion Media Query', orientaciones: 'Proyecto Completo web (Photo) test.mglab.s', tiempo: '8h', dificultad: 'Encontrar los archivos - Proyecto grande (Sin README)', valoracion: 'Factible' },
                    { jornada: 2, actividad: 'Configurar la web Laravel para local', orientaciones: 'Base de datos, proyecto prueba, herramientas', tiempo: '8h', dificultad: 'Lanzar en local, leer archivos', valoracion: 'Factible' },
                    { jornada: 3, actividad: 'Verificar CSS web', orientaciones: 'Carpeta de CSS del proyecto + Bootstrap', tiempo: '8h', dificultad: 'Encontrar las diferentes rutas para los archivos', valoracion: 'Factible' },
                    { jornada: 4, actividad: 'Actualizar web a Server y Local', orientaciones: 'Lanzar en local para actualizar diseno', tiempo: '8h', dificultad: 'Volver a cargar la BD en local', valoracion: 'Factible' }
                ]
            },
            {
                periodo: '09/02/2026 al 12/02/2026',
                dias: [
                    { jornada: 1, actividad: 'Resolver problemas rutas CSS en servidor', orientaciones: 'Buscar si el servidor es Case Sensitive', tiempo: '8h', dificultad: 'Actualizar rutas', valoracion: 'Factible' },
                    { jornada: 2, actividad: 'Resolver problemas finales de la web para puesta en marcha', orientaciones: 'Hacer BD para produccion', tiempo: '8h', dificultad: 'Encontrar fallo en diferentes archivos y leer documentacion', valoracion: 'Factible' },
                    { jornada: 3, actividad: 'Nueva web: hacer que funcione en local', orientaciones: 'Buscar versiones y documentacion para rodar en local', tiempo: '8h', dificultad: 'Descargar distintas versiones de terceros', valoracion: 'Factible' },
                    { jornada: 4, actividad: 'Crear contenedor Docker para multiples proyectos', orientaciones: 'Actualizar documentacion', tiempo: '8h', dificultad: 'Fallo de Docker al correr phpMyAdmin', valoracion: 'Factible' }
                ]
            },
            {
                periodo: '16/02/2026 al 20/02/2026',
                dias: [
                    { jornada: 1, actividad: 'Festivo', orientaciones: 'Festivo', tiempo: '0h', dificultad: 'N/A', valoracion: 'Festivo' },
                    { jornada: 2, actividad: 'Festivo', orientaciones: 'Festivo', tiempo: '0h', dificultad: 'N/A', valoracion: 'Festivo' },
                    { jornada: 3, actividad: 'Hacer modal de modificar hora fichaje / Optimizar Docker-Linux', orientaciones: 'Buscar documentacion', tiempo: '8h', dificultad: 'Encontrar documentacion Linux', valoracion: 'Factible' },
                    { jornada: 4, actividad: 'Optimizar fichaje / Permitir fichar de una vez', orientaciones: 'Buscar documentacion y leer codigo antiguo', tiempo: '8h', dificultad: 'Muchas lineas de codigo de otro programador sin comentarios', valoracion: 'Factible' }
                ]
            },
            {
                periodo: '02/03/2026 al 06/03/2026',
                dias: [
                    { jornada: 1, actividad: 'Corregir paginas el CSS', orientaciones: 'Basado en el estilo propuesto', tiempo: '8h', dificultad: 'Quitar estilos antiguos conflictivos', valoracion: 'Facil' },
                    { jornada: 2, actividad: 'Seccion Comentarios-Tareas', orientaciones: 'Revisar codigo y plantear nuevo diseno', tiempo: '8h', dificultad: 'Quitar clases de Bootstrap y poner nuevas', valoracion: 'Moderado' },
                    { jornada: 3, actividad: 'Estructurar email HTML para noticias', orientaciones: 'Enviar email al comentar una tarea', tiempo: '8h', dificultad: 'Revisar codigo no comentado', valoracion: 'Moderado' },
                    { jornada: 4, actividad: 'Corregir AJAX de comentarios y fichaje', orientaciones: 'Revisar codigo antiguo y actualizarlo', tiempo: '8h', dificultad: 'Buscar codigo en la web', valoracion: 'Moderado' }
                ]
            },
            {
                periodo: '09/03/2026 al 13/03/2026',
                dias: [
                    { jornada: 1, actividad: 'Corregir errores proyecto y produccion', orientaciones: 'Revisar codigo que da error', tiempo: '8h', dificultad: 'N/A', valoracion: 'Facil' },
                    { jornada: 2, actividad: 'Corregir logica de permisos y hacer dinamico el controller', orientaciones: 'Plantear nueva logica', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderado' },
                    { jornada: 3, actividad: 'Ajustar comentarios / Ver errores de consola', orientaciones: 'Ver codigo antiguo', tiempo: '8h', dificultad: 'Ver codigo antiguo', valoracion: 'Moderado' },
                    { jornada: 4, actividad: 'Botones comentarios (Editar/Eliminar) fallan', orientaciones: 'Corregir acciones de los botones', tiempo: '8h', dificultad: 'N/A', valoracion: 'Facil' },
                    { jornada: 5, actividad: 'Festivo', orientaciones: 'Festivo', tiempo: '0h', dificultad: 'N/A', valoracion: 'Festivo' }
                ]
            },
            {
                periodo: '16/03/2026 al 20/03/2026',
                dias: [
                    { jornada: 1, actividad: 'Subir archivos al servidor para produccion', orientaciones: 'Usar FileZilla', tiempo: '8h', dificultad: 'Configurar BD para nueva web', valoracion: 'Facil' },
                    { jornada: 2, actividad: 'Aplicar estilos finos al CSS', orientaciones: 'Buscar codigo y aplicar', tiempo: '8h', dificultad: 'Hacer estilo con mas detalles', valoracion: 'Facil' },
                    { jornada: 3, actividad: 'Corregir filtro de vacaciones', orientaciones: 'Filtro deja de funcionar', tiempo: '8h', dificultad: 'Ver codigo AJAX', valoracion: 'Moderado' },
                    { jornada: 4, actividad: 'Aplicar estilo a la Tabla de fichaje', orientaciones: 'Redisennar tabla', tiempo: '8h', dificultad: 'Ajustar responsividad', valoracion: 'Moderado' }
                ]
            },
            {
                periodo: '23/03/2026 al 27/03/2026',
                dias: [
                    { jornada: 1, actividad: 'Corregir fallos seccion comentarios', orientaciones: 'Identificar el archivo que falla', tiempo: '8h', dificultad: 'Plugin que apunta a una ruta/array', valoracion: 'Moderado' },
                    { jornada: 2, actividad: 'Fallo en rutas de Linux', orientaciones: 'Identificar y buscar fallos de rutas', tiempo: '8h', dificultad: 'Multiples rutas en terminal con nombres similares', valoracion: 'Dificil' },
                    { jornada: 3, actividad: 'Reconstruccion del contenedor Docker', orientaciones: 'Actualizar contenedor para nueva web (Nuntii)', tiempo: '8h', dificultad: 'Fallo de Docker', valoracion: 'Moderado' },
                    { jornada: 4, actividad: 'Arreglar terminal PuTTy para despliegue', orientaciones: 'Ayuda de documentacion', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderado' },
                    { jornada: 5, actividad: 'Corregir error del gestor de contenido', orientaciones: 'Fallo en la tabla Idioms', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderado' }
                ]
            },
            {
                periodo: '06/04/2026 al 10/04/2026',
                dias: [
                    { jornada: 1, actividad: 'Actualizar gestor contenido', orientaciones: 'Anadir funcionalidades de forma dinamica', tiempo: '8h', dificultad: 'Codigo desactualizado', valoracion: 'Moderado' },
                    { jornada: 2, actividad: 'Corregir conflicto Github', orientaciones: 'Editar lineas y verificar merge', tiempo: '8h', dificultad: 'Conflicto en los merges', valoracion: 'Moderado' },
                    { jornada: 3, actividad: 'Editar fallos con imagenes', orientaciones: 'Ver controlador y corregir bug', tiempo: '8h', dificultad: 'Conflicto logica del controlador', valoracion: 'Moderado' },
                    { jornada: 4, actividad: 'Corregir detalles tecnicos', orientaciones: 'Ver el codigo', tiempo: '8h', dificultad: 'Detalles tecnicos', valoracion: 'Facil' }
                ]
            },
            {
                periodo: '13/04/2026 al 17/04/2026',
                dias: [
                    { jornada: 1, actividad: 'Corregir bugs en el gestor contenido', orientaciones: 'Ver las migraciones', tiempo: '8h', dificultad: 'Codigo que colisiona con otros', valoracion: 'Moderado' },
                    { jornada: 2, actividad: 'Actualizar terminal de proyectos', orientaciones: 'Subir con FileZilla / Git pull', tiempo: '8h', dificultad: 'Gestionar varios repositorios', valoracion: 'Moderado' },
                    { jornada: 3, actividad: 'Permisos colaboradores Git', orientaciones: 'Buscar como dar permisos a usuarios', tiempo: '8h', dificultad: 'Conflictos de permisos', valoracion: 'Moderado' },
                    { jornada: 4, actividad: 'Ramas GitHub', orientaciones: 'Resolver Merges y Pull Requests', tiempo: '8h', dificultad: 'Conflictos de push', valoracion: 'Moderado' },
                    { jornada: 5, actividad: 'Documentacion final', orientaciones: 'Redactar manual', tiempo: '8h', dificultad: 'N/A', valoracion: 'Finalizado' }
                ]
            }
            ]
        },
        en: {
            info_general: {
                alumno: 'Viana Teixeira, Rogerio Lucas',
                centro_docente: 'CFPE TUNIVERS FORMACION',
                ciclo_formativo: 'Web Application Development (LFP)',
                clave_ciclo: 'IFC-303',
                empresa: 'MON EVENT SL',
                tutor_empresa: 'Paz Rellan Lopez',
                tutor_docente: 'Mario Alvarez Fernandez'
            },
            seguimiento_detallado: [
                {
                    periodo: '02/02/2026 to 06/02/2026',
                    dias: [
                        { jornada: 1, actividad: 'Create media queries', orientaciones: 'Complete website project (Photo) test.mglab.s', tiempo: '8h', dificultad: 'Finding files in a large project (without README)', valoracion: 'Feasible' },
                        { jornada: 2, actividad: 'Configure Laravel website for local environment', orientaciones: 'Database, test project, tools', tiempo: '8h', dificultad: 'Launching locally and reading files', valoracion: 'Feasible' },
                        { jornada: 3, actividad: 'Verify website CSS', orientaciones: 'Project CSS folder + Bootstrap', tiempo: '8h', dificultad: 'Finding the different file paths', valoracion: 'Feasible' },
                        { jornada: 4, actividad: 'Update website on server and local', orientaciones: 'Run locally to update design', tiempo: '8h', dificultad: 'Reloading the database locally', valoracion: 'Feasible' }
                    ]
                },
                {
                    periodo: '09/02/2026 to 12/02/2026',
                    dias: [
                        { jornada: 1, actividad: 'Fix CSS path issues on server', orientaciones: 'Check if server is case-sensitive', tiempo: '8h', dificultad: 'Updating routes', valoracion: 'Feasible' },
                        { jornada: 2, actividad: 'Solve final website issues before go-live', orientaciones: 'Prepare database for production', tiempo: '8h', dificultad: 'Finding failures in different files and reading documentation', valoracion: 'Feasible' },
                        { jornada: 3, actividad: 'New website: make it run locally', orientaciones: 'Check versions and documentation to run locally', tiempo: '8h', dificultad: 'Downloading different third-party versions', valoracion: 'Feasible' },
                        { jornada: 4, actividad: 'Create Docker container for multiple projects', orientaciones: 'Update documentation', tiempo: '8h', dificultad: 'Docker failure when running phpMyAdmin', valoracion: 'Feasible' }
                    ]
                },
                {
                    periodo: '16/02/2026 to 20/02/2026',
                    dias: [
                        { jornada: 1, actividad: 'Holiday', orientaciones: 'Holiday', tiempo: '0h', dificultad: 'N/A', valoracion: 'Holiday' },
                        { jornada: 2, actividad: 'Holiday', orientaciones: 'Holiday', tiempo: '0h', dificultad: 'N/A', valoracion: 'Holiday' },
                        { jornada: 3, actividad: 'Create modal to edit time entry / optimize Docker-Linux', orientaciones: 'Search documentation', tiempo: '8h', dificultad: 'Finding Linux documentation', valoracion: 'Feasible' },
                        { jornada: 4, actividad: 'Optimize time entry / allow single-step clock-in', orientaciones: 'Search documentation and read legacy code', tiempo: '8h', dificultad: 'Many lines of uncommented code from another developer', valoracion: 'Feasible' }
                    ]
                },
                {
                    periodo: '02/03/2026 to 06/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Fix CSS on pages', orientaciones: 'Based on proposed style', tiempo: '8h', dificultad: 'Removing conflicting old styles', valoracion: 'Easy' },
                        { jornada: 2, actividad: 'Comments-Tasks section', orientaciones: 'Review code and propose new design', tiempo: '8h', dificultad: 'Removing Bootstrap classes and replacing them', valoracion: 'Moderate' },
                        { jornada: 3, actividad: 'Build HTML email for updates', orientaciones: 'Send email when commenting on a task', tiempo: '8h', dificultad: 'Reviewing uncommented code', valoracion: 'Moderate' },
                        { jornada: 4, actividad: 'Fix comments and time-entry AJAX', orientaciones: 'Review and update legacy code', tiempo: '8h', dificultad: 'Searching code in the website', valoracion: 'Moderate' }
                    ]
                },
                {
                    periodo: '09/03/2026 to 13/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Fix project and production errors', orientaciones: 'Review failing code', tiempo: '8h', dificultad: 'N/A', valoracion: 'Easy' },
                        { jornada: 2, actividad: 'Fix permissions logic and make controller dynamic', orientaciones: 'Define new logic', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderate' },
                        { jornada: 3, actividad: 'Adjust comments / check console errors', orientaciones: 'Review legacy code', tiempo: '8h', dificultad: 'Reviewing legacy code', valoracion: 'Moderate' },
                        { jornada: 4, actividad: 'Comment buttons (Edit/Delete) failing', orientaciones: 'Fix button actions', tiempo: '8h', dificultad: 'N/A', valoracion: 'Easy' },
                        { jornada: 5, actividad: 'Holiday', orientaciones: 'Holiday', tiempo: '0h', dificultad: 'N/A', valoracion: 'Holiday' }
                    ]
                },
                {
                    periodo: '16/03/2026 to 20/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Upload files to production server', orientaciones: 'Use FileZilla', tiempo: '8h', dificultad: 'Configure database for new website', valoracion: 'Easy' },
                        { jornada: 2, actividad: 'Apply refined CSS styles', orientaciones: 'Search and apply code', tiempo: '8h', dificultad: 'Adding more detailed styling', valoracion: 'Easy' },
                        { jornada: 3, actividad: 'Fix vacation filter', orientaciones: 'Filter stops working', tiempo: '8h', dificultad: 'Review AJAX code', valoracion: 'Moderate' },
                        { jornada: 4, actividad: 'Apply styling to time-entry table', orientaciones: 'Redesign table', tiempo: '8h', dificultad: 'Adjust responsive behavior', valoracion: 'Moderate' }
                    ]
                },
                {
                    periodo: '23/03/2026 to 27/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Fix issues in comments section', orientaciones: 'Identify failing file', tiempo: '8h', dificultad: 'Plugin pointing to route/array', valoracion: 'Moderate' },
                        { jornada: 2, actividad: 'Linux route failures', orientaciones: 'Identify and locate route issues', tiempo: '8h', dificultad: 'Multiple terminal paths with similar names', valoracion: 'Difficult' },
                        { jornada: 3, actividad: 'Rebuild Docker container', orientaciones: 'Update container for new website (Nuntii)', tiempo: '8h', dificultad: 'Docker failure', valoracion: 'Moderate' },
                        { jornada: 4, actividad: 'Fix PuTTy terminal for deployment', orientaciones: 'Use documentation support', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderate' },
                        { jornada: 5, actividad: 'Fix content manager error', orientaciones: 'Failure in Idioms table', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderate' }
                    ]
                },
                {
                    periodo: '06/04/2026 to 10/04/2026',
                    dias: [
                        { jornada: 1, actividad: 'Update content manager', orientaciones: 'Add dynamic features', tiempo: '8h', dificultad: 'Outdated code', valoracion: 'Moderate' },
                        { jornada: 2, actividad: 'Fix GitHub conflict', orientaciones: 'Edit lines and verify merge', tiempo: '8h', dificultad: 'Merge conflicts', valoracion: 'Moderate' },
                        { jornada: 3, actividad: 'Fix image-related issues', orientaciones: 'Check controller and fix bug', tiempo: '8h', dificultad: 'Controller logic conflict', valoracion: 'Moderate' },
                        { jornada: 4, actividad: 'Fix technical details', orientaciones: 'Review code', tiempo: '8h', dificultad: 'Technical details', valoracion: 'Easy' }
                    ]
                },
                {
                    periodo: '13/04/2026 to 17/04/2026',
                    dias: [
                        { jornada: 1, actividad: 'Fix bugs in content manager', orientaciones: 'Review migrations', tiempo: '8h', dificultad: 'Code collisions with other modules', valoracion: 'Moderate' },
                        { jornada: 2, actividad: 'Update project terminal workflows', orientaciones: 'Upload with FileZilla / Git pull', tiempo: '8h', dificultad: 'Managing multiple repositories', valoracion: 'Moderate' },
                        { jornada: 3, actividad: 'Git collaborator permissions', orientaciones: 'Research how to assign permissions', tiempo: '8h', dificultad: 'Permission conflicts', valoracion: 'Moderate' },
                        { jornada: 4, actividad: 'GitHub branches', orientaciones: 'Resolve merges and pull requests', tiempo: '8h', dificultad: 'Push conflicts', valoracion: 'Moderate' },
                        { jornada: 5, actividad: 'Final documentation', orientaciones: 'Write manual', tiempo: '8h', dificultad: 'N/A', valoracion: 'Completed' }
                    ]
                }
            ]
        },
        pt: {
            info_general: {
                alumno: 'Viana Teixeira, Rogerio Lucas',
                centro_docente: 'CFPE TUNIVERS FORMACAO',
                ciclo_formativo: 'Desenvolvimento de Aplicacoes Web (LFP)',
                clave_ciclo: 'IFC-303',
                empresa: 'MON EVENT SL',
                tutor_empresa: 'Paz Rellan Lopez',
                tutor_docente: 'Mario Alvarez Fernandez'
            },
            seguimiento_detallado: [
                {
                    periodo: '02/02/2026 a 06/02/2026',
                    dias: [
                        { jornada: 1, actividad: 'Realizar media query', orientaciones: 'Projeto web completo (Photo) test.mglab.s', tiempo: '8h', dificultad: 'Encontrar ficheiros - projeto grande (sem README)', valoracion: 'Viavel' },
                        { jornada: 2, actividad: 'Configurar o site Laravel em local', orientaciones: 'Base de dados, projeto de teste, ferramentas', tiempo: '8h', dificultad: 'Lancar em local e ler ficheiros', valoracion: 'Viavel' },
                        { jornada: 3, actividad: 'Verificar CSS do site', orientaciones: 'Pasta CSS do projeto + Bootstrap', tiempo: '8h', dificultad: 'Encontrar os diferentes caminhos dos ficheiros', valoracion: 'Viavel' },
                        { jornada: 4, actividad: 'Atualizar site no servidor e local', orientaciones: 'Lancar em local para atualizar design', tiempo: '8h', dificultad: 'Carregar novamente a BD em local', valoracion: 'Viavel' }
                    ]
                },
                {
                    periodo: '09/02/2026 a 12/02/2026',
                    dias: [
                        { jornada: 1, actividad: 'Resolver problemas de rotas CSS no servidor', orientaciones: 'Ver se o servidor e case-sensitive', tiempo: '8h', dificultad: 'Atualizar rotas', valoracion: 'Viavel' },
                        { jornada: 2, actividad: 'Resolver problemas finais do site para entrada em producao', orientaciones: 'Criar BD para producao', tiempo: '8h', dificultad: 'Encontrar erro em varios ficheiros e ler documentacao', valoracion: 'Viavel' },
                        { jornada: 3, actividad: 'Novo site: colocar a funcionar em local', orientaciones: 'Procurar versoes e documentacao para correr em local', tiempo: '8h', dificultad: 'Descarregar diferentes versoes de terceiros', valoracion: 'Viavel' },
                        { jornada: 4, actividad: 'Criar contentor Docker para multiplos projetos', orientaciones: 'Atualizar documentacao', tiempo: '8h', dificultad: 'Falha do Docker ao correr phpMyAdmin', valoracion: 'Viavel' }
                    ]
                },
                {
                    periodo: '16/02/2026 a 20/02/2026',
                    dias: [
                        { jornada: 1, actividad: 'Feriado', orientaciones: 'Feriado', tiempo: '0h', dificultad: 'N/A', valoracion: 'Feriado' },
                        { jornada: 2, actividad: 'Feriado', orientaciones: 'Feriado', tiempo: '0h', dificultad: 'N/A', valoracion: 'Feriado' },
                        { jornada: 3, actividad: 'Criar modal para alterar hora de registo / otimizar Docker-Linux', orientaciones: 'Procurar documentacao', tiempo: '8h', dificultad: 'Encontrar documentacao Linux', valoracion: 'Viavel' },
                        { jornada: 4, actividad: 'Otimizar registo de ponto / permitir registo de uma vez', orientaciones: 'Procurar documentacao e ler codigo antigo', tiempo: '8h', dificultad: 'Muitas linhas de codigo de outro programador sem comentarios', valoracion: 'Viavel' }
                    ]
                },
                {
                    periodo: '02/03/2026 a 06/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Corrigir CSS das paginas', orientaciones: 'Com base no estilo proposto', tiempo: '8h', dificultad: 'Remover estilos antigos em conflito', valoracion: 'Facil' },
                        { jornada: 2, actividad: 'Secao Comentarios-Tarefas', orientaciones: 'Rever codigo e propor novo design', tiempo: '8h', dificultad: 'Remover classes Bootstrap e aplicar novas', valoracion: 'Moderado' },
                        { jornada: 3, actividad: 'Estruturar email HTML para noticias', orientaciones: 'Enviar email ao comentar uma tarefa', tiempo: '8h', dificultad: 'Rever codigo sem comentarios', valoracion: 'Moderado' },
                        { jornada: 4, actividad: 'Corrigir AJAX de comentarios e registo', orientaciones: 'Rever codigo antigo e atualizar', tiempo: '8h', dificultad: 'Procurar codigo no site', valoracion: 'Moderado' }
                    ]
                },
                {
                    periodo: '09/03/2026 a 13/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Corrigir erros do projeto e producao', orientaciones: 'Rever codigo com erro', tiempo: '8h', dificultad: 'N/A', valoracion: 'Facil' },
                        { jornada: 2, actividad: 'Corrigir logica de permissoes e tornar o controller dinamico', orientaciones: 'Definir nova logica', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderado' },
                        { jornada: 3, actividad: 'Ajustar comentarios / ver erros de consola', orientaciones: 'Ver codigo antigo', tiempo: '8h', dificultad: 'Ver codigo antigo', valoracion: 'Moderado' },
                        { jornada: 4, actividad: 'Botoes de comentarios (Editar/Eliminar) falham', orientaciones: 'Corrigir acoes dos botoes', tiempo: '8h', dificultad: 'N/A', valoracion: 'Facil' },
                        { jornada: 5, actividad: 'Feriado', orientaciones: 'Feriado', tiempo: '0h', dificultad: 'N/A', valoracion: 'Feriado' }
                    ]
                },
                {
                    periodo: '16/03/2026 a 20/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Subir ficheiros para o servidor de producao', orientaciones: 'Usar FileZilla', tiempo: '8h', dificultad: 'Configurar BD para novo site', valoracion: 'Facil' },
                        { jornada: 2, actividad: 'Aplicar ajustes finos de CSS', orientaciones: 'Procurar codigo e aplicar', tiempo: '8h', dificultad: 'Fazer estilo com mais detalhe', valoracion: 'Facil' },
                        { jornada: 3, actividad: 'Corrigir filtro de ferias', orientaciones: 'Filtro deixa de funcionar', tiempo: '8h', dificultad: 'Ver codigo AJAX', valoracion: 'Moderado' },
                        { jornada: 4, actividad: 'Aplicar estilo a tabela de registos', orientaciones: 'Redesenhar tabela', tiempo: '8h', dificultad: 'Ajustar responsividade', valoracion: 'Moderado' }
                    ]
                },
                {
                    periodo: '23/03/2026 a 27/03/2026',
                    dias: [
                        { jornada: 1, actividad: 'Corrigir falhas na secao de comentarios', orientaciones: 'Identificar ficheiro com falha', tiempo: '8h', dificultad: 'Plugin aponta para rota/array', valoracion: 'Moderado' },
                        { jornada: 2, actividad: 'Falha em rotas Linux', orientaciones: 'Identificar e procurar falhas de rotas', tiempo: '8h', dificultad: 'Multiplas rotas no terminal com nomes semelhantes', valoracion: 'Dificil' },
                        { jornada: 3, actividad: 'Reconstrucao do contentor Docker', orientaciones: 'Atualizar contentor para novo site (Nuntii)', tiempo: '8h', dificultad: 'Falha de Docker', valoracion: 'Moderado' },
                        { jornada: 4, actividad: 'Arranjar terminal PuTTy para deploy', orientaciones: 'Ajuda da documentacao', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderado' },
                        { jornada: 5, actividad: 'Corrigir erro do gestor de conteudo', orientaciones: 'Falha na tabela Idioms', tiempo: '8h', dificultad: 'N/A', valoracion: 'Moderado' }
                    ]
                },
                {
                    periodo: '06/04/2026 a 10/04/2026',
                    dias: [
                        { jornada: 1, actividad: 'Atualizar gestor de conteudo', orientaciones: 'Adicionar funcionalidades de forma dinamica', tiempo: '8h', dificultad: 'Codigo desatualizado', valoracion: 'Moderado' },
                        { jornada: 2, actividad: 'Corrigir conflito GitHub', orientaciones: 'Editar linhas e verificar merge', tiempo: '8h', dificultad: 'Conflito nos merges', valoracion: 'Moderado' },
                        { jornada: 3, actividad: 'Editar falhas com imagens', orientaciones: 'Ver controlador e corrigir bug', tiempo: '8h', dificultad: 'Conflito na logica do controlador', valoracion: 'Moderado' },
                        { jornada: 4, actividad: 'Corrigir detalhes tecnicos', orientaciones: 'Ver o codigo', tiempo: '8h', dificultad: 'Detalhes tecnicos', valoracion: 'Facil' }
                    ]
                },
                {
                    periodo: '13/04/2026 a 17/04/2026',
                    dias: [
                        { jornada: 1, actividad: 'Corrigir bugs no gestor de conteudo', orientaciones: 'Ver migracoes', tiempo: '8h', dificultad: 'Codigo colide com outros modulos', valoracion: 'Moderado' },
                        { jornada: 2, actividad: 'Atualizar terminal de projetos', orientaciones: 'Subir com FileZilla / Git pull', tiempo: '8h', dificultad: 'Gerir varios repositorios', valoracion: 'Moderado' },
                        { jornada: 3, actividad: 'Permissoes de colaboradores Git', orientaciones: 'Procurar como dar permissoes aos utilizadores', tiempo: '8h', dificultad: 'Conflitos de permissoes', valoracion: 'Moderado' },
                        { jornada: 4, actividad: 'Ramos GitHub', orientaciones: 'Resolver merges e pull requests', tiempo: '8h', dificultad: 'Conflitos de push', valoracion: 'Moderado' },
                        { jornada: 5, actividad: 'Documentacao final', orientaciones: 'Redigir manual', tiempo: '8h', dificultad: 'N/A', valoracion: 'Finalizado' }
                    ]
                }
            ]
        }
    };

    var UI_TEXT = {
        es: {
            modalTitle: 'Seguimiento detallado de practicas',
            generalInfo: 'Informacion general',
            periodLabel: 'Periodo',
            headers: ['Jornada', 'Actividad', 'Orientaciones', 'Tiempo', 'Dificultad', 'Valoracion'],
            infoLabels: {
                alumno: 'Alumno',
                centro_docente: 'Centro docente',
                ciclo_formativo: 'Ciclo formativo',
                clave_ciclo: 'Clave ciclo',
                empresa: 'Empresa',
                tutor_empresa: 'Tutor empresa',
                tutor_docente: 'Tutor docente'
            }
        },
        en: {
            modalTitle: 'Detailed internship tracking',
            generalInfo: 'General information',
            periodLabel: 'Period',
            headers: ['Day', 'Task', 'Guidance', 'Time', 'Difficulty', 'Assessment'],
            infoLabels: {
                alumno: 'Student',
                centro_docente: 'Academic center',
                ciclo_formativo: 'Training program',
                clave_ciclo: 'Program code',
                empresa: 'Company',
                tutor_empresa: 'Company mentor',
                tutor_docente: 'Academic mentor'
            }
        },
        pt: {
            modalTitle: 'Acompanhamento detalhado do estagio',
            generalInfo: 'Informacao geral',
            periodLabel: 'Periodo',
            headers: ['Jornada', 'Atividade', 'Orientacoes', 'Tempo', 'Dificuldade', 'Avaliacao'],
            infoLabels: {
                alumno: 'Aluno',
                centro_docente: 'Centro docente',
                ciclo_formativo: 'Curso formativo',
                clave_ciclo: 'Codigo do curso',
                empresa: 'Empresa',
                tutor_empresa: 'Tutor da empresa',
                tutor_docente: 'Tutor docente'
            }
        }
    };

    function normalizeLanguage(language) {
        return SUPPORTED_LANGUAGES.indexOf(language) >= 0 ? language : 'es';
    }

    function getActiveLanguage() {
        var fromDoc = (document.documentElement.lang || '').slice(0, 2);
        return normalizeLanguage(fromDoc);
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function buildGeneralInfoTable(dataset, infoLabels) {
        var infoRows = Object.keys(dataset.info_general).map(function (key) {
            var label = infoLabels[key] || key;
            var value = dataset.info_general[key];

            return '<div class="practicasInfoRow">' +
                '<span class="practicasInfoRow__label">' + escapeHtml(label) + '</span>' +
                '<span class="practicasInfoRow__value">' + escapeHtml(value) + '</span>' +
            '</div>';
        }).join('');

        return '<div class="practicasInfoGrid">' + infoRows + '</div>';
    }

    function buildPeriods(dataset, texts) {
        return dataset.seguimiento_detallado.map(function (weekBlock) {
            var rows = weekBlock.dias.map(function (day) {
                return '<article class="practicasDayCard">' +
                    '<h5 class="practicasDayCard__title">' + escapeHtml(texts.headers[0]) + ' ' + escapeHtml(day.jornada) + '</h5>' +
                    '<div class="practicasDayCard__row"><span>' + escapeHtml(texts.headers[1]) + '</span><p>' + escapeHtml(day.actividad) + '</p></div>' +
                    '<div class="practicasDayCard__row"><span>' + escapeHtml(texts.headers[2]) + '</span><p>' + escapeHtml(day.orientaciones) + '</p></div>' +
                    '<div class="practicasDayCard__meta">' +
                        '<div><span>' + escapeHtml(texts.headers[3]) + '</span><p>' + escapeHtml(day.tiempo) + '</p></div>' +
                        '<div><span>' + escapeHtml(texts.headers[4]) + '</span><p>' + escapeHtml(day.dificultad) + '</p></div>' +
                        '<div><span>' + escapeHtml(texts.headers[5]) + '</span><p>' + escapeHtml(day.valoracion) + '</p></div>' +
                    '</div>' +
                '</article>';
            }).join('');

            return '<section class="practicasModalSection">' +
                '<h4 class="practicasPeriodHeading">' +
                    '<span class="practicasPeriodHeading__label">' + escapeHtml(texts.periodLabel) + '</span>' +
                    '<span class="practicasPeriodHeading__value">' + escapeHtml(weekBlock.periodo) + '</span>' +
                '</h4>' +
                '<div class="practicasDayList">' + rows + '</div>' +
            '</section>';
        }).join('');
    }

    function renderModal(language) {
        var currentLanguage = normalizeLanguage(language);
        var dataset = PRACTICAS_DATA[currentLanguage] || PRACTICAS_DATA.es;
        var texts = UI_TEXT[currentLanguage] || UI_TEXT.es;

        var title = document.getElementById('practicasModalTitle');
        var content = document.getElementById('practicasModalContent');

        if (!title || !content) {
            return;
        }

        title.textContent = texts.modalTitle;

        content.innerHTML =
            '<section class="practicasModalSection">' +
                '<h4>' + escapeHtml(texts.generalInfo) + '</h4>' +
                buildGeneralInfoTable(dataset, texts.infoLabels) +
            '</section>' +
            buildPeriods(dataset, texts);
    }

    function openModal() {
        var modal = document.getElementById('practicasModal');

        if (!modal) {
            return;
        }

        renderModal(getActiveLanguage());
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        var modal = document.getElementById('practicasModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.addEventListener('click', function (event) {
        if (event.target.closest('#openPracticasModal')) {
            openModal();
            return;
        }

        if (event.target.closest('[data-practicas-close]')) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    document.addEventListener('rogerlab:language-changed', function (event) {
        var modal = document.getElementById('practicasModal');

        if (!modal || !modal.classList.contains('is-open')) {
            return;
        }

        var language = event.detail && event.detail.language ? event.detail.language : getActiveLanguage();
        renderModal(language);
    });
}());
