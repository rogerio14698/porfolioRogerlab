<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Rendimiento y despliegue

- Todas las vistas comparten las fuentes JetBrains Mono y Public Sans alojadas
  localmente (WOFF2, con sus licencias en `public/fonts`); no dependen de Google
  Fonts ni de la hoja completa de Font Awesome. Los dos iconos sociales son SVG
  locales con la atribución de Font Awesome incluida.
- La identidad visual usa grafito y verde mineral, con alternativa clara.
  La portada prioriza proyectos y conserva los dos CV. Stripe/Strapi se presentan
  como investigación en curso, no como experiencia comercial consolidada.
  Los accesos de contacto para empleo y proyectos solo completan un asunto vacío;
  no cambian el envío ni la verificación del correo.
- El fondo conserva su efecto y sus controles, pero se inicializa después de
  cargar la página, en un turno libre del navegador. Aprovecha compilación paralela
  de shaders cuando WebGL la admite, sin bloquear esperando su estado.
  Conserva la densidad original de partículas, resolución y límite de 30 fps.
  Respeta pausa guardada, movimiento reducido, pestañas ocultas y pérdida de WebGL.
- El retrato usa variantes WebP de 480 y 960 px sin eliminar el JPEG original.
  Desde el panel se puede reemplazar por una subida optimizada; las variantes
  anteriores solo se usan mientras siga seleccionada la foto inicial.
- Los CV siguen siendo PDF vectoriales, con el mismo texto y enlaces. Se han
  recomprimido sin pérdida: inglés **1863338 → 1481053 bytes** y español
  **2166322 → 1743594 bytes**. No se regeneran en cada visita. Sus URL y nombres
  de ruta no cambian; admiten `HEAD`, rangos `206` y validación `304` mediante
  `ETag`/`Last-Modified`, sin iniciar sesión ni emitir cookies.
  Son documentos públicos con caché de una hora: al sustituirlos, una copia
  ya almacenada puede seguir disponible hasta que venza ese plazo.
- `public/.htaccess` activa gzip para HTML/CSS/JS/JSON/SVG **si Apache dispone
  de `mod_deflate`** y caché solo para archivos estáticos **si dispone de
  `mod_expires`**. Las fuentes versionadas se conservan un año; CSS/JS/imágenes,
  una semana. El CSS usa versión en la URL y Vite genera nombres con hash.
  Para sustituir una imagen o fuente con caché, usa otro nombre de archivo.
  Las imágenes privadas del blog/proyectos siguen con `no-store, private`;
  no se activa caché pública para HTML, formularios ni el panel.

Despliega únicamente después de un `git pull --ff-only` correcto. Si Git detecta
cambios locales, revísalos y resuélvelos o respáldalos antes; no continúes con una
compilación de la revisión antigua:

```sh
git status --short
git pull --ff-only
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Mantén `APP_ENV=production`, `APP_DEBUG=false` y OPcache habilitado en el PHP
que sirve la web. No instales ni actives módulos reiniciando un servidor compartido
sin revisar antes su configuración. Si usas Nginx, `.htaccess` no se aplica:
configura allí gzip y la caché **solo de archivos estáticos**, sin incluir las
rutas Laravel de medios privados. Comprueba en producción `Content-Encoding: gzip`
para una petición GET de CSS/JS con `Accept-Encoding: gzip`, y `Cache-Control`
para fuentes e imágenes. La configuración local de XAMPP puede no tener esos
módulos activos aunque los cambios de la aplicación ya estén funcionando.

Vuelve a ejecutar Lighthouse en móvil y escritorio después del despliegue,
con la misma configuración y sin extensiones. El informe inicial registró
FCP 0,7 s, LCP 0,8 s y TBT 16890 ms; una medición local no garantiza la misma
puntuación ni reproduce por sí sola el coste de GPU del dispositivo original.

Pruebas de entrega y controles:

```sh
php vendor/bin/phpunit tests/Feature/PdfPerformanceTest.php tests/Feature/PortfolioPresentationTest.php
node --test tests/Frontend/background.test.mjs tests/Frontend/portfolio.test.mjs tests/Frontend/contact-paths.test.mjs tests/Frontend/admin-editor.test.mjs
```

## Blog privado de RogerLab

El blog es público en `/blog`. Solo el propietario puede acceder a `/login`
y acceder al panel central en `/admin`, con publicaciones en `/admin/blog`. No existe registro público ni recuperación
de contraseña por correo.

### Preparación y primer acceso

1. Guarda una copia de seguridad de la base de datos y del archivo `.env`.
2. Ejecuta `php artisan migrate` y `npm run build`. Para una instalación SQLite nueva,
   crea primero el archivo `database/database.sqlite`. No uses `migrate:fresh` en una
   instalación con datos.
3. En `.env`, mantén `BLOG_OWNER_EMAIL=rogeriolucas14698@gmail.com` y escribe una
   contraseña única en `BLOG_INITIAL_PASSWORD=`. Debe tener entre **12 y 72 bytes**,
   en una sola línea (ASCII evita diferencias entre bytes y caracteres). Respeta
   la sintaxis de dotenv: entrecomilla valores con espacios o `#`; no uses
   interpolación `${...}`. No envíes ni confirmes este archivo en Git.
4. Si cambias configuración, ejecuta `php artisan config:clear`. El secreto inicial
   se lee directamente del archivo, no se incorpora a `config:cache`.
5. Abre `/login` e inicia sesión con ese correo y contraseña. Solo tras comprobarlos
   se crea el usuario con un hash de Laravel y se elimina **toda la asignación
   `BLOG_INITIAL_PASSWORD`** de `.env`. El directorio del archivo debe permitir su
   sustitución segura por el proceso PHP. Si la escritura falla, el acceso falla
   y la creación del usuario se revierte; revisa permisos y el registro.

Una vez creada la cuenta, volver a escribir una contraseña en `.env` **no cambia
la de la cuenta**. Para restablecerla desde una terminal de confianza:

```sh
php artisan blog:reset-password
```

El comando solicita y confirma la nueva contraseña sin mostrarla ni recibirla como
argumento, guarda el hash, retira el secreto inicial si queda y revoca las sesiones
del panel al volver a acceder. También permite preparar la cuenta sin escribir una
contraseña temporal en `.env`. Si excepcionalmente falla el commit de base de datos
tras limpiar el archivo, este comando permite recuperar el acceso.

### Publicaciones e imágenes

- Crea, edita, previsualiza, publica, retira a borrador y elimina desde el panel.
  La eliminación requiere confirmación y no se puede deshacer.
- Cada publicación tiene título, texto y SEO independientes en español, inglés
  y portugués. Se exige título y texto en los tres idiomas para publicar; los
  borradores solo necesitan el título en español. No se traducen textos automáticamente.
- El editor usa texto simple escapado, con saltos de línea; no admite HTML.
- La dirección usa letras minúsculas, números y guiones. No la cambies después de
  publicar salvo que aceptes perder las URL anteriores; no se crean redirecciones.
  La excepción es la corrección histórica de `porfolio` a `portfolio`: la migración
  conserva el contenido y `/blog/porfolio` devuelve un 301 a `/blog/portfolio`,
  manteniendo los parámetros (incluido `lang`). El slug antiguo queda reservado.
  Si ya existen ambos slugs, la migración se detiene para resolver el conflicto
  sin sobrescribir publicaciones. La corrección de datos no se revierte con un rollback.
- Puedes adjuntar hasta 10 imágenes JPEG/PNG/WebP de 5 MB y 6000 × 6000 px cada una.
  Cada foto necesita texto alternativo en los tres idiomas. Se conservan en orden
  de subida, sin recorte destructivo. Se muestra un carrusel manual accesible para
  varias imágenes y el logo de la web si no hay fotos. No se genera contenido ficticio.
- Los archivos se guardan en `storage/app/blog`, fuera del directorio público;
  **no hace falta `storage:link`**. Las imágenes de borradores solo las puede leer
  el propietario. Las respuestas no se almacenan en caché para respetar su retirada.
  No es posible revocar copias que alguien haya descargado cuando eran públicas.
- Las nuevas imágenes del blog y proyectos se convierten automáticamente a WebP,
  sin recorte, con el lado mayor limitado a 1600 px (sin ampliar imágenes pequeñas).
  Se aplica calidad 78, reduciéndola hasta 60 si supera 300 KB; ese peso es un
  objetivo, no un límite garantizado. Se conserva transparencia y se eliminan
  metadatos. Con PHP EXIF activo también se corrige la orientación JPEG.
  Los originales subidos no se conservan: guarda tu copia de alta calidad.
  Las imágenes ya existentes no cambian; vuelve a subirlas para optimizarlas.
  Requiere **PHP GD con soporte WebP** en el PHP que sirve la web; sin él se
  muestra un error y no se guarda la publicación. En Debian/Ubuntu normalmente
  se instala con `apt install php-gd` (o el paquete de tu versión PHP), activándolo
  después en Apache/PHP-FPM. En XAMPP activa `extension=gd` en su `php.ini`.
  Incluye `storage/app/blog` y la base de datos en tus copias de seguridad.
- Ajusta `upload_max_filesize` (al menos `5M`), `post_max_size` (recomendado `64M`)
  y `max_file_uploads` (al menos 10) en el PHP que sirve la web, y los límites del
  servidor/proxy. La configuración local detectada tiene `post_max_size=40M`:
  para subir diez fotos de 5 MB juntas debes elevarlo y reiniciar el servidor PHP,
  o subirlas en varias ediciones. Los archivos nuevos deben seleccionarse otra vez
  si hay errores de validación.
- Si aparece un aviso de limpieza, consulta el registro: la publicación ya se guardó,
  pero un archivo retirado no pudo eliminarse del disco. No se oculta ese fallo.

### SEO y despliegue

Los títulos SEO (70 caracteres), descripciones (160) y palabras clave (255) son
opcionales por idioma. Sin ellos se usa el título o un extracto del texto.
Las publicaciones generan canonical, hreflang, Open Graph, Twitter y JSON-LD
`BlogPosting`; solo las publicadas aparecen en `/sitemap.xml`.
El índice del blog y los posts usan canonical propio con `?lang=es`, `?lang=en`
o `?lang=pt`, y alternativos `hreflang` para las traducciones disponibles más
`x-default` apuntando al español. Sin `lang`, el blog público siempre se sirve
en español, independientemente de la sesión o del idioma guardado en el navegador.
Las páginas paginadas conservan `page` en canonical y alternativos, excepto `page=1`.
El sitemap incluye las tres versiones del índice. No se migran las URL a prefijos
por idioma. Inicio, proyectos y blog ya resuelven su contenido dinámico desde el
servidor; las demás secciones mantienen su sistema de traducción en el navegador.

La portada social del índice es [blog-social.png](./public/img/blog-social.png)
(1200 × 630 px). Los posts usan su primera imagen, la imagen histórica si existe,
o el logo si no tienen imagen; el JSON-LD utiliza las imágenes del propio post.
La home ya incluye `Person` y `WebSite`. Tras desplegar, comprueba una URL pública
de post en el [Rich Results Test](https://search.google.com/test/rich-results)
y revisa el grafo de la home en el [Schema Markup Validator](https://validator.schema.org/).
La validación local comprueba el JSON emitido, pero no sustituye estas herramientas.

El panel y las vistas previas llevan `noindex` y caché privada desactivada.
Los enlaces públicos a login/panel llevan `nofollow`. Tanto el archivo estático
[robots.txt](./public/robots.txt) como la respuesta Laravel excluyen `/login`,
`/logout`, `/admin` y las verificaciones de contacto. `robots.txt` no sustituye
la autenticación ni elimina por sí mismo URL ya indexadas.
Los campos globales `SEO_*` están documentados con valores de ejemplo en
[.env.example](./.env.example); `APP_URL` debe apuntar a la URL real del despliegue.
Las páginas del portfolio conservan sus textos SEO específicos existentes.

En producción usa HTTPS, `APP_ENV=production`, `APP_DEBUG=false`,
`SESSION_SECURE_COOKIE=true`, un `APP_KEY` propio y permisos mínimos para `.env`,
SQLite y `storage`. No publiques `.env`, bases de datos, copias de seguridad ni
el directorio `storage`. El acceso tiene límite de cinco intentos por minuto/IP.

Pruebas enfocadas:

```sh
php artisan test tests/Feature/BlogPublishingTest.php tests/Feature/PortfolioPresentationTest.php
```

## Perfil, herramientas, proyectos y carrusel

`/admin` es la entrada del panel. Comparte navegación lateral en escritorio,
menú plegable en móvil, tipografía de lectura y controles consistentes entre
todos los editores. Los idiomas se agrupan en bloques desplegables; los errores
abren el bloque afectado. La web pública mantiene las partículas, pero el
panel no carga el lienzo decorativo.

### Perfil e inicio

Ejecuta la migración aditiva `2026_10_23_130000_create_site_profiles` antes de
servir esta versión. No modifica publicaciones, proyectos ni herramientas
existentes. Crea un único perfil con los textos ES/EN/PT iniciales de
[profile.php](./lang/es/profile.php). Tras migrar, edita el contenido en
`/admin/profile`, no en esos valores iniciales.
Ejecuta también `2026_10_23_150000_create_profile_project_evidence`: convierte
las selecciones individuales existentes en relaciones múltiples sin perderlas.

- Edita rol, presentación, disponibilidad, tres áreas de aportación y los
  dos párrafos de biografía, en español, inglés y portugués.
- Cada área admite varios proyectos como evidencia mediante casillas, sin
  seleccionar ninguno si no corresponde. Un proyecto puede aparecer en varias
  áreas. Se muestran en el orden global de proyectos, con su portada si tiene
  imagen y un enlace a su ficha; sin imagen se conserva el enlace de texto.
  Solo aparecen los publicados y no futuros; los borradores conservan su
  selección para cuando se publiquen. Eliminar un proyecto limpia sus relaciones.
- El bloque de exploración permite crear, leer, editar, ocultar y eliminar su
  título, texto y enlace. El destino se elige entre Sobre mí, Proyectos, Blog y
  Contacto para evitar enlaces inseguros. Se comparte con Sobre mí.
- La foto admite subida, visualización, sustitución, ocultación y eliminación,
  con texto alternativo por idioma. JPEG/PNG/WebP hasta 5 MB y 6000 × 6000 px,
  optimizados por el servicio existente a WebP con límite de 1600 px.
  Requiere GD con soporte WebP en el PHP del servidor. En XAMPP, habilita
  `extension=gd` en el archivo de configuración PHP y detén/inicia Apache
  para cargarla; cambiar el archivo sin reiniciar solo afecta a procesos nuevos.
  Si no está disponible, se muestra un error y no se cambia la foto ni el perfil.
  Los archivos están en `storage/app/blog/profile`, servidos por `/profile/photo`
  con `nosniff` y sin caché. Sustituir o eliminar retira la subida anterior.
  Eliminar la foto inicial deja de mostrarla, pero no borra los recursos
  históricos versionados. Para añadirla de nuevo, sube un archivo.
- Guardar publica los cambios inmediatamente; requiere las traducciones de
  todos los campos visibles. No hay traducción automática. Se conserva el
  texto escrito tras errores, salvo el archivo, que hay que volver a elegir.
  Las eliminaciones requieren confirmación y se separan del guardado.
- Inicio y Sobre mí tienen títulos y descripciones SEO editables. El HTML
  renderizado en servidor, Open Graph, Twitter, canonical, hreflang y sitemap
  son coherentes con cada idioma. JSON-LD describe `Person`, `WebSite`,
  `WebPage`/`AboutPage` y tres `Service` basados en las áreas visibles, sin
  reseñas, precios ni resultados inventados.
- El contenido presenta empleo junior y proyectos freelance en Gijón/Asturias,
  España y remoto internacional. No presenta WordPress como especialidad
  acreditada ni convierte la investigación de Stripe/Strapi en experiencia comercial.
  El SEO técnico no garantiza posiciones ni resultados enriquecidos.

El mismo acceso de propietario permite gestionar `/admin/skills` y
`/admin/projects`, con enlaces desde la navegación del panel. No se necesita
otra cuenta. Ejecuta `php artisan migrate` antes de servir esta versión:
la migración añade las tablas y conserva las nueve habilidades y los siete
proyectos actuales, sus traducciones, enlaces, descarga del flujo y capturas.
La instantánea inicial está en [portfolio.json](./database/data/portfolio.json);
después de migrar, los cambios se hacen en el panel, no en esa instantánea.

- **Habilidades:** nombre ES/EN/PT, orden y borrador/publicación. Solo las publicadas
  aparecen como herramientas en Sobre mí y en `Person.knowsAbout`.
  Ya no se acumulan en la portada: el inicio explica aportaciones y trabajo relacionado.
- **Proyectos:** título, resumen, descripción, tipo, periodo, SEO y descripción
  general de imágenes por idioma; tecnologías (una por línea), repositorio,
  web, orden, estado y selección para la portada. Para publicar se exigen título,
  resumen, descripción y texto alternativo en los tres idiomas.
- Se pueden subir hasta 20 JPEG/PNG/WebP de 5 MB y 6000 × 6000 px cada uno.
  Se guardan en `storage/app/blog/projects`, con protección de borradores.
  Elige cualquier imagen conservada o la primera nueva como portada; puedes
  añadir textos alternativos específicos por imagen e idioma. Si se dejan
  vacíos, se usa la descripción general del proyecto.
  Las imágenes históricas de `public/img` se conservan como recursos públicos;
  retirar un proyecto no revoca esos recursos previamente públicos.
  Eliminar un proyecto solo borra sus archivos subidos, no los recursos históricos.
- El PHP del servidor debe permitir la cantidad y tamaño de archivos deseados:
  para 20 imágenes de 5 MB juntas, configura `max_file_uploads >= 20`,
  `upload_max_filesize >= 5M` y `post_max_size > 100M`, o sube en varias ediciones.
- La dirección `/projects/{slug}` tiene canonical e hreflang, Open Graph, Twitter
  y JSON-LD `CreativeWork`. El índice usa `CollectionPage`/`ItemList`, con canonical
  paginado. Solo proyectos publicados y no futuros aparecen en el sitemap.
  No se prometen posiciones ni resultados enriquecidos. Evita cambiar un slug
  publicado: no se generan redirecciones automáticas.
- En inicio, el nombre y los enlaces a CV permanecen fijos; el resto de la
  presentación y la foto se editan en Perfil e inicio. En el carrusel se alternan
  proyectos publicados destacados (según orden) y cuatro artículos publicados
  recientes; si falta un tipo se muestra el otro, sin contenido inventado.
  El carrusel avanza cada ocho segundos, sin título adicional, barra de desplazamiento
  ni fila de enlaces, flechas o contador. Muestra puntos pulsables para elegir
  contenido y una cápsula para el activo, junto al icono de pausa/reproducción.
  Cada indicador tiene un nombre accesible traducido y un área táctil de 44px.
  La selección manual pausa el avance hasta reanudar con el icono. Se detiene al pasar el ratón, tocar, ocultar la
  pestaña o salir de pantalla; al volver ofrece ocho segundos completos de lectura.
  El foco de teclado pausa hasta reanudar explícitamente. Con movimiento reducido
  no hay reproducción automática. Conserva flechas de teclado sobre la pista y
  gestos nativos; sin JavaScript sigue siendo desplazable.
  Con cero contenidos no se dibuja; con uno no muestra controles.
- Los iconos de tema y fondo no muestran texto en ninguna resolución, pero
  conservan su nombre accesible traducido y sus estados.
- La navegación parcial actualiza también canonical, alternativos, robots, metadatos
  sociales y JSON-LD, evitando arrastrar el SEO de la página anterior.

Validación del contenido dinámico y regresiones relacionadas:

```sh
php vendor/bin/phpunit tests/Feature/ProfileManagementTest.php tests/Feature/PortfolioContentTest.php tests/Feature/PortfolioPresentationTest.php tests/Feature/BlogPublishingTest.php
npm run build
node --test tests/Frontend/portfolio.test.mjs tests/Frontend/admin-editor.test.mjs
```

Las pruebas del carrusel usan el ejecutor integrado de Node 24, sin dependencias adicionales.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
