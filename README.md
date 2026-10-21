<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Blog privado de RogerLab

El blog es público en `/blog`. Solo el propietario puede acceder a `/login`
y gestionar publicaciones en `/admin/blog`. No existe registro público ni recuperación
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
- Se guardan los archivos originales: elimina metadatos personales/EXIF antes de
  subir fotos. Incluye `storage/app/blog` y la base de datos en tus copias de seguridad.
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

## Habilidades, proyectos y carrusel de inicio

El mismo acceso de propietario permite gestionar `/admin/skills` y
`/admin/projects`, con enlaces desde la barra del panel del blog. No se necesita
otra cuenta. Ejecuta `php artisan migrate` antes de servir esta versión:
la migración añade las tablas y conserva las nueve habilidades y los siete
proyectos actuales, sus traducciones, enlaces, descarga del flujo y capturas.
La instantánea inicial está en [portfolio.json](./database/data/portfolio.json);
después de migrar, los cambios se hacen en el panel, no en esa instantánea.

- **Habilidades:** nombre ES/EN/PT, orden y borrador/publicación. Solo las publicadas
  aparecen en `heroStack` y en `Person.knowsAbout` de la home.
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
- En inicio, identidad, foto y CV permanecen fijos. Debajo se alternan hasta cuatro
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
php vendor/bin/phpunit tests/Feature/PortfolioContentTest.php tests/Feature/PortfolioPresentationTest.php tests/Feature/BlogPublishingTest.php
npm run build
node --test tests/Frontend/portfolio.test.mjs
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
