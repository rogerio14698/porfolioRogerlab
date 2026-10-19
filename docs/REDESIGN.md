# Rediseño visual del portfolio

## Rama, base y alcance

- Rama de trabajo: `nuevoDiseño-ui-ux`.
- Commit base: `b56e8decb315dbd9f0b59cbea721f9e3592fc82e`.
- Rama de retorno: `blogDinamico`, que apunta al mismo commit base. Se ha
  inferido de las referencias existentes, no del nombre de una rama nueva.
- No se han cambiado, fusionado ni publicado otras ramas. Nunca se ha hecho
  push a `master`.
- Se conservan los textos y traducciones ES/EN/PT, proyectos, enlaces,
  descargas, rutas y contratos del formulario y la navegación parcial.
- No se han añadido dependencias ni modificado la configuración de la base
  de datos, credenciales o servicios de producción.

Se ejecutó `git status` antes de comenzar. Los cambios que ya existían en
[composer.json](../composer.json) y [composer.lock](../composer.lock) quedan
fuera de los commits. El Repomix inicial estaba desactualizado: se contrastó
con los archivos reales y se regeneró con `npx repomix`, sin versionarlo.
También se ha dejado fuera la imagen no rastreada `22.jpe`, aparecida durante
el trabajo en el directorio del sistema de diseño.

## Contexto y auditoría inicial

Stack conservado: Laravel 12, Blade, TypeScript/Vite 7 y Sass/Gulp. Aunque
hay paquetes de Tailwind en el proyecto, los estilos reales son Sass y se
ha mantenido esa arquitectura.

| Prioridad | Problema inicial | Solución |
| --- | --- | --- |
| Alta | Encabezados competidores y dos h1 por página | Un h1 principal por ruta y nombre del header como párrafo |
| Alta | Animación por letras que alteraba el texto; sin movimiento reducido | Entradas progresivas sin reescribir contenido y estado estático con reduced motion |
| Alta | Navegación móvil y controles con foco/tamaño inconsistentes | Menú compacto, Escape, foco visible y objetivos de 44–48px |
| Media | Monoespaciada para todo y cuerpo pequeño | Familias diferenciadas, cuerpo de 16px e interlineado 1.65 |
| Media | Retrato diminuto y proyectos sin jerarquía | Retrato protagonista y siete casos de estudio con acciones claras |
| Media | Bordes, partículas y ritmos de separación incoherentes | Superficies tonales, espaciado compartido y retirada del canvas decorativo |
| Baja | Hover, radios, metadatos y footer dispares | Tokens y estados comunes en todas las secciones |

La medición inicial de inicio produjo 6 FAIL y 7 WARN en el inspector de
diseño. Sus reglas estéticas no equivalen a una auditoría WCAG.

## Dirección de arte

Un dossier profesional: el retrato real presenta a la persona y los casos
de estudio muestran su trabajo, sin inventar fotografías, cifras ni claims.
Los títulos condensados dan carácter; el cuerpo sans facilita la lectura.
Se mantiene el contraste carbón/marfil y se usa espacio y superficie en vez
de efectos, bordes decorativos o tarjetas pequeñas repetidas.

Se ejecutó el motor local de UI UX Pro Max para
`professional personal developer portfolio editorial monochrome accessible`,
con `--design-system --persist -p RogerLab --page portfolio`.
Su propuesta se adaptó a esta identidad: no se adoptaron el azul, el
brutalismo, la mezcla serif/mono ni el parallax sugeridos.
La referencia compositiva de Taste fue `page-is-the-object`, semilla
`1081985591`.

Persistencia solicitada:

- [Master](../design-system/rogerlab/MASTER.md).
- [Overrides del portfolio](../design-system/rogerlab/pages/portfolio.md).
- [Tokens implementados](../resources/sass/global/_tokens.scss).

## Paleta y tokens

Los ocho colores de partida se conservan: `#222222`, `#ECE8DF`, `#DDDDDD`,
`#1F1F1F`, `#333333`, `#444444`, `#999999` y `#FFFFFF`.
No hay un nuevo tono de acento; las imágenes mantienen sus colores originales.

| Token semántico | Oscuro | Claro |
| --- | --- | --- |
| Fondo | #222222 | #ECE8DF |
| Superficie elevada | #333333 | #FFFFFF |
| Texto principal | #DDDDDD | #1F1F1F |
| Texto secundario | #DDDDDD | #444444 |
| Acción | #ECE8DF | #222222 |
| Texto de acción | #1F1F1F | #ECE8DF |
| Foco | #ECE8DF | #222222 |
| Borde de campo | #999999 | #444444 |

Arquitectura: primitivos → semánticos → componentes. Los alias CSS
anteriores, como `--_fondo` y `--_texto`, siguen disponibles.

| Categoría | Valores |
| --- | --- |
| Títulos | Big Shoulders 600 |
| Cuerpo y controles | Public Sans 400/600 |
| Tipografía | 14px pequeña; 16px cuerpo; 18–22px lead; 28–48px sección; 36–76px display |
| Lectura | Interlineado 1.65; medida aproximada 65ch |
| Espaciado | 4, 8, 12, 16, 24, 32, 48, 64 y 96px |
| Márgenes | Gutter fluido 20–64px; ritmo de sección 48–96px |
| Radios | 0; controles y medios cuadrados |
| Sombras | Solo diálogos: `0 24px 80px rgb(0 0 0 / 28%)` |
| Foco | Contorno 2px con offset de 4px |
| Movimiento | Feedback 160ms; entrada 600ms, `cubic-bezier(.16,1,.3,1)`, desplazamiento máximo 16px |

Contrastes calculados con luminancia relativa sRGB:

| Texto / fondo | Ratio |
| --- | --- |
| #DDDDDD / #222222 | 11.71:1 |
| #DDDDDD / #333333 | 9.30:1 |
| #1F1F1F / #ECE8DF | 13.48:1 |
| #444444 / #FFFFFF | 9.74:1 |
| #444444 / #ECE8DF | 7.97:1 |

Estas parejas superan AA para texto normal; no constituyen por sí solas
una certificación de accesibilidad de todo el sitio.

## Cambios por sección

- **Header y navegación:** identidad compacta, idioma y tema visibles,
  `aria-pressed`, enlace actual y menú móvil con retorno de foco mediante
  Escape. La navegación sigue disponible si no se ejecuta JavaScript.
- **Inicio:** retrato existente en gran formato, prioridad de carga y
  dimensiones reales 1170×2080; título, presentación, CTA y CV con jerarquía
  clara. La introducción completa se mantiene debajo.
- **Sobre mí / skills:** directorio de conocimientos y dos columnas de
  metodología/especialización; se apila en móvil.
- **Proyectos:** siete filas de caso de estudio, medios y cuerpo agrupados,
  metadatos y acciones legibles. Se conservan carruseles y galerías.
  El CSS respeta explícitamente `[hidden]` para no mostrar todas las
  miniaturas. Lightbox con Tab/Shift+Tab, flechas, Escape, bloqueo/restauración
  del scroll y retorno del foco al disparador.
- **Contacto:** rejilla responsive, campos amplios, labels y avisos de 16px,
  sin alterar endpoint, CSRF, validación ni integración Turnstile.
- **FCT:** mejor lectura del documento y diálogo de seguimiento.
- **Blog/login:** presentación coherente, nombres accesibles y autocomplete.
  En la primera entrega el login permaneció deshabilitado; el panel funcional
  de la actualización de blog descrita más abajo sustituye ese estado.
- **Legales y footer:** medida de lectura, ritmo vertical, enlaces visibles
  y una única superficie de desplazamiento del documento.
- **Comportamiento compartido:** entradas con IntersectionObserver que no
  modifican los textos; contenido visible sin animación ni JavaScript.
  `prefers-reduced-motion` elimina las entradas. Los textos largos pueden
  partirse cuando no caben, incluido al ampliar la tipografía al 200 %.

Las fuentes se sirven por Google Fonts como antes, sustituyendo las
familias anteriores, sin añadir paquetes. El fondo de partículas original se recuperó después por petición expresa,
con los límites y controles descritos en la actualización siguiente.

## Verificación realizada

- `npm run build`: Vite y Sass/Gulp correctos; CSS compilado y sourcemap
  versionados según el patrón existente.
- Compilación de vistas con `php artisan view:cache` correcta; se limpió
  después la caché temporal con `view:clear`.
- Seis pruebas focalizadas aprobadas: cuatro de presentación y las dos de
  contacto existentes. No se presenta este resultado como suite completa.
- 54 combinaciones renderizadas: nueve rutas × 1440/768/390px × dos temas,
  con HTTP 200, un h1, sin overflow horizontal ni imágenes cargadas rotas,
  y sin animaciones bajo reduced motion.
- 27 comprobaciones de interacción en Chrome mediante eventos reales de
  toque/teclado: menú, navegación parcial, galerías, FCT, idiomas, temas,
  reflow a 320px y texto al 200 % en inicio/proyectos/contacto/sobre mí.
  Sin excepciones JavaScript durante ese recorrido.
- Revisión visual de capturas de inicio, proyectos y contacto en escritorio,
  tablet y móvil; tema claro; y páginas de sobre mí, FCT, blog y privacidad.
- `code-review` sobre el diff del rediseño: sin hallazgos significativos.
  Las comprobaciones visuales posteriores detectaron y corrigieron el
  override de `[hidden]` y la alineación de controles de las galerías.
- `git diff --check` correcto.

Se utilizó una base SQLite temporal aislada, sin cambiar `.env` ni datos
reales. El blog se revisó vacío. No se probaron correo/Turnstile reales,
contenido de producción, lectores de pantalla ni dispositivos móviles
físicos. No se ejecutó axe ni se declara conformidad WCAG completa.
Vite transpila TypeScript; no existe un type-check independiente configurado.

### Medición de diseño y excepciones

El inspector final informa 0 FAIL con excepciones explícitas: inicio
3 WARN, proyectos 2 WARN y contacto 3 WARN. No se presenta como aprobado
sin condiciones:

- `headline-lines`: se preservan los títulos largos originales, sin
  reescribirlos para satisfacer un número arbitrario de líneas.
- `few-pictures`: inicio tiene el retrato real y contacto no requiere fotos;
  no se añade material ajeno para llegar a una cuota.
- `off-centre` en proyectos: compara el borde del título con el contenido
  interior de las tarjetas; los gutters exteriores siguen siendo simétricos.
- `still-page` y `focal-point` en contacto: el foco es el formulario, no una
  imagen o animación decorativa.
- Aviso marfil/crema: forma parte de la paleta exigida.
- Aviso sin vídeo: no existe un clip propio relevante y no se añade stock.
- Aviso poco movimiento: se priorizan las microinteracciones ligeras.
- `name-only-title` en contacto es una clasificación errónea del título
  descriptivo existente «Contacto profesional».

El detector Impeccable no encontró patrones en las superficies rediseñadas.
El lint bruto de estilos sí señala sombras: las de diálogos son
intencionadas y los estilos del juego heredado quedan fuera del alcance.

### Crítica visual final

ROUND 3

Seen in one second: desarrollador identificable, retrato real y acceso al trabajo.

Idea (one sentence): un dossier profesional monocromático basado en trabajo real.

Live thing: entradas discretas, controles de tema y galerías interactivas.

Layout words by section: hero=presentación/retrato / about=directorio/narrativa /
projects=casos de estudio / contact=formulario / footer=contacto/legal.

Scores: design 6.5 · usability 8.5 · creativity 6 · content 8 → overall 7.4

Caps applied: diseño limitado por los titulares originales largos; identidad
deliberadamente conservadora, no una propuesta experimental de galería.

Top three problems (most visible first), each with the screenshot it shows in and the fix:

1. Título de inicio de tres líneas (`final-home/desktop-fold.jpg`):
   conservarlo por la restricción de contenido; no cortar ni abreviar.
2. Capturas de proyecto demasiado pequeñas para leer dentro de miniaturas
   (`final-projects/mobile-page-01.jpg`): mantenerlas como acceso a ampliación
   y ofrecer lightbox operable por teclado y toque.
3. Contacto visualmente más estático (`final-contact/desktop-page-01.jpg`):
   mantener el formulario como foco y no añadir vídeo/ornamentos que
   distraigan de completarlo.

Las capturas y resultados detallados son evidencia local de la sesión,
no archivos añadidos al repositorio.

## Actualización solicitada: traducciones, navegación y fondo

Tras la primera entrega se solicitaron estos ajustes, manteniendo la misma rama:

- **FCT ES/EN/PT:** la narración principal carecía de claves de traducción.
  Se conectaron introducción, competencias, aportación y evaluación al
  selector existente, conservando el texto español. El modal ya disponía de
  sus tres conjuntos de datos; se localizó también el nombre accesible de
  su botón de cierre.
- **Navegación sticky:** permanece en la parte superior al recorrer proyectos
  largos y el resto de rutas. Fondo opaco del tema, sin blur, con menú móvil
  limitado a la altura disponible y desplazamiento propio solo si lo necesita.
  El documento reserva margen de scroll para el foco.
- **Fondo recuperado:** se vuelve a montar el canvas del shader original,
  sin sustituir las partículas por un efecto nuevo. Opacidad 0.18 en oscuro
  y 0.12 en claro, con composición screen/multiply respectivamente; los
  paneles y la navegación conservan superficies opacas para leer con claridad.
- **Control y coste:** máximo 30fps y DPR 1. Botón «Animación de fondo»
  traducido, con `aria-pressed` y preferencia guardada. En movimiento reducido
  se conserva una imagen estática y no se permite activar el bucle.
  No hay frames continuos en pestañas ocultas. La pérdida de WebGL se
  registra en consola y deja el fondo de color como alternativa.

Verificación de esta actualización:

- Build correcto y **7 pruebas PHP** aprobadas.
- **23 comprobaciones Chrome** aprobadas para traducción principal/modal,
  navegación parcial, sticky a 1440/768/390/320px, apertura móvil, dibujo
  WebGL, pausa persistente, cambio dinámico de reduced motion, suspensión
  por visibilidad y ausencia de excepciones JavaScript.
- Repetidas las **54 combinaciones de ruta, tema y tamaño** con el fondo
  restaurado y reduced motion activo: sin overflow, imágenes cargadas rotas
  ni animaciones DOM, con el control de reproducción deshabilitado.
- Verificadas las 18 claves de traducción de la superficie y su control
  de fondo en cada diccionario ES/EN/PT.
- Inspector de proyectos: 0 FAIL / 2 WARN con las excepciones de contenido
  anteriores. FCT: 0 FAIL / 3 WARN; se conserva su título largo original y
  su naturaleza documental sin fotos/vídeo ajenos.

La eliminación inicial del canvas y la prueba original que exigía su
ausencia quedan sustituidas por este comportamiento, aprobado expresamente
por el usuario. No se ha importado contenido de MySQL ni modificado `.env`.

Crítica visual de la actualización:

ROUND 1

Seen in one second: el fondo original vuelve a identificar el portfolio sin
restar jerarquía a títulos, retrato y casos de estudio.

Idea (one sentence): el mismo dossier profesional con la textura de
partículas propia del portfolio, no una dirección de arte nueva.

Live thing: partículas originales pausables y galerías existentes.

Layout words by section: navegación=barra sticky / proyectos=casos de estudio /
FCT=documento traducido / fondo=textura ambiental.

Scores: design 6.5 · usability 8.5 · creativity 6.5 · content 8 → overall 7.4

Caps applied: títulos originales largos conservados.

Top three problems (most visible first), each with the screenshot it shows in and the fix:

1. FCT sigue teniendo cuatro líneas de título en móvil
   (`followup-inspect-fct/mobile-fold.jpg`): no truncar ni reescribir el contenido.
2. El fondo pasa detrás de texto documental
   (`followup-inspect-fct/desktop-fold.jpg`): intensidad limitada, controles de
   pausa y movimiento reducido; no aumentar el brillo del shader.
3. La barra ocupa altura mientras se lee en móvil
   (`followup-projects-390.jpg`): solo se fija la navegación compacta, no
   todo el header; menú plegado por defecto.

## Actualización: blog público y panel exclusivo del autor

Se conserva la dirección monocromática, las fuentes y la animación original.
El listado usa filas con imágenes sin recorte destructivo y el editor emplea
campos amplios, grupos por idioma y títulos compactos propios de una herramienta
de trabajo. No se incorporan dependencias, fuentes ni imágenes externas nuevas.

- `/login`: solo el correo configurado en `BLOG_OWNER_EMAIL`, sin registro.
  Primer acceso con contraseña temporal local; se guarda el hash y se elimina
  su asignación de `.env`. Recuperación local con `blog:reset-password`.
- `/admin/blog`: borradores, altas, edición, previsualización, publicación,
  retirada y eliminación confirmada. Texto simple en ES/EN/PT; SEO por idioma.
- `/blog`: únicamente publicaciones visibles, paginación, detalle y SEO
  generado en servidor. El idioma usa `?lang=`; entrar y salir del blog carga
  la página completa para no conservar metadatos de otra sección.
- Imágenes privadas fuera de `public`, con autorización también en la ruta
  de medios. Sin fotos se usa el logo existente. Carrusel manual, flechas
  de teclado, contador anunciado y todas las imágenes visibles sin JavaScript.
- Protección CSRF, límite de acceso, validación de archivos, hash de contraseña,
  noindex/no-store en panel y previsualizaciones. Revisión transaccional del
  máximo de imágenes para evitar superar el límite con guardados simultáneos.
- `.env.example` documenta claves del blog, SEO, SQLite y cookies. `.env` local
  tiene el correo y el campo inicial vacío; no se ha elegido una contraseña ni
  creado una cuenta real. Las instrucciones operativas están en el [README](../README.md).

### Verificación del blog

- Build Vite/Sass, formato PHP y compilación de todas las vistas correctos.
- 26 pruebas focalizadas de autenticación, publicación, traducciones, SEO seguro,
  privacidad, imágenes, borrado y regresión del portfolio/contacto. No se declara que
  haya pasado una suite completa.
- 32 comprobaciones Chrome del flujo real de login, borrador, publicación con
  dos archivos, carrusel con ratón/teclado, traducciones, SEO tras ejecutar JS,
  eliminación y logout; anchos 1440/768/390/320 y ambos temas, sin excepciones.
- Se repitieron las 23 comprobaciones anteriores de navegación/FCT/partículas
  y las 54 combinaciones de rutas, tamaños y temas: correctas.
- Fixtures, credenciales de prueba y archivos de navegador en una base SQLite
  y un almacenamiento temporales aislados; no se publicaron datos de ejemplo
  en la base local del usuario. Migración local aplicada de forma aditiva.
- `code-review` detectó la carrera del límite de imágenes; se corrigió con
  bloqueo del registro y comprobación dentro de la transacción, cubierta por test.

El inspector a 1440/768/390 informa 0 FAIL / 1 WARN tanto en acceso como en blog.
En el blog hay excepciones explícitas: `few-pictures` y `no-footage`, porque las
fotos son opcionales y no se inventa contenido; `eyebrow`, porque clasifica el
contador funcional «Imagen 1 de 3» como adorno sobre el siguiente título.
Las fechas se colocaron debajo del título para reforzar la jerarquía.
El único aviso restante es el marfil de la paleta que se debe conservar.
Se revisaron las capturas completas de los tres tamaños. No se ha realizado
una auditoría formal WCAG ni pruebas con lector de pantalla o móvil físico.

ROUND 2

Seen in one second: notas de desarrollo con la identidad de RogerLab y un
acceso diferenciado para su autor.

Idea (one sentence): el dossier de proyectos se amplía con un cuaderno de
publicaciones del propio desarrollador, con sus imágenes y tres idiomas.

Live thing: carrusel manual de imágenes reales y publicación privada de borradores.

Layout words by section: blog=listado editorial / detalle=lectura / acceso=formulario /
panel=listado de trabajo / editor=grupos por idioma.

Scores: design 7 · usability 8.5 · creativity 6 · content 7 → overall 7.3

Caps applied: fotos opcionales y contenido de prueba solo para validación;
se prima la herramienta funcional sobre una composición experimental.

Top three problems (most visible first), each with the screenshot it shows in and the fix:

1. El título del acceso parecía un hero de marketing (`blog-login-inspect/desktop-fold.jpg`):
   se redujo a 24–32px para una tarea de autenticación.
2. Las fechas competían con los títulos (`blog-public-inspect/tablet-page-01.jpg`):
   se trasladaron bajo el título; no se suprime información editorial.
3. El editor completo es largo en móvil (`blog-editor-390.jpg`): se agrupa por idioma,
   se pliega el SEO opcional y se avisa antes de abandonar cambios sin guardar.
   Se mantiene el recorrido explícito en vez de esconder campos requeridos en pestañas.

Para revertir esta ampliación, guardar primero una copia de la base y de
`storage/app/blog`, y revertir sus commits conjuntamente. Revertir Git no revierte
la base de datos. **No ejecutar un rollback de la nueva migración sobre publicaciones
que se quieran conservar**: eliminaría sus traducciones y las relaciones de imágenes.

## Commits y reversión

Refinamiento posterior del inicio: los dos enlaces al CV utilizan la misma
pareja de tokens `--action-bg` / `--action-text`, con fondo opaco individual
y separación entre controles. Esto evita que el estilo heredado de
`a:first-child` deje el primer PDF con texto invertido sobre un fondo
transparente al comentar los CTA anteriores. Se conservan destinos, textos,
foco visible y adaptación a ambos temas.

| Commit | Unidad |
| --- | --- |
| `8991474` | Tokens, navegación y marco compartido |
| `5cab618` | Hero y directorio de conocimientos |
| `0dd77c3` | Casos de estudio |
| `4964567` | Contacto, footer y páginas secundarias |
| `f51ffff` | Galerías, foco y accesibilidad responsive |
| `dce38b2` | Pruebas de los contratos de presentación |
| `db0dace` | Documentación de la primera entrega |
| `e47cf7a` | Narrativa de prácticas y cierre de modal traducidos |
| `5119404` | Fondo original, control de animación y navegación sticky |
| `15c9a2f` | Modelo de publicación, medios privados y credenciales del autor |
| `3e9579e` | Panel, blog público multilingüe, galerías y SEO |
| `37a6ada` | Pruebas de acceso, publicaciones, imágenes y SEO |

La documentación se mantiene en commits propios. Para localizar toda
la serie: `git log --oneline b56e8de..nuevoDiseño-ui-ux`.

Para deshacer una sección, usar `git revert <commit>` en una rama de trabajo
y resolver posibles dependencias posteriores. Por ejemplo, revertir la
estructura inicial de proyectos puede requerir revertir primero sus
refinamientos. Después ejecutar `npm run build`, comprobar el resultado y
versionar también el CSS regenerado. No usar `reset --hard`.

Antes de cambiar de rama, guardar de forma independiente los cambios
personales pendientes y los archivos no rastreados. No se han guardado
automáticamente en un stash ni en commits de este rediseño.

Comandos de retorno **no ejecutados** (Git Bash, cmd o PowerShell 7):

Descartar la rama local del rediseño:

```sh
git switch blogDinamico && git branch -D nuevoDiseño-ui-ux
```

Aceptar el rediseño:

```sh
git switch blogDinamico && git merge nuevoDiseño-ui-ux
```

En Windows PowerShell antiguo, ejecutar cada parte en una línea separada,
la segunda solo si la primera termina correctamente. Borrar la rama local
no elimina su copia remota ni revierte una integración ya realizada.
No se usa `redesign/portfolio-ui-2026-10`: era un nombre del ejemplo de la
petición, no la rama de trabajo real.
