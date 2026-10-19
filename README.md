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
El panel y las vistas previas llevan `noindex` y caché privada desactivada.
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
