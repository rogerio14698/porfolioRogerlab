<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

$seoCity = config('seo.city');
$seoRegion = config('seo.region');
$seoCountry = config('seo.country');

if (! function_exists('renderSection')) {
    function renderSection(string $section, string $pageTitle, string $pageMetaDescription, int $status = 200, string $robotsMeta = 'index,follow')
    {
        $data = compact('section', 'pageTitle', 'pageMetaDescription', 'robotsMeta');

        if (request()->ajax()) {
            return response()->view('components.sectionContent', $data, $status);
        }

        return response()->view('index', $data, $status);
    }
}

Route::redirect('/', '/home');

Route::get('/home', function () {
    return renderSection(
        'home',
        'Desarrollador Web Freelance en ' . config('seo.city') . ' | Aplicaciones Web para Negocios',
        'Desarrollo paginas web, landings y aplicaciones web a medida en ' . config('seo.city') . ' y ' . config('seo.region') . '. Soluciones rapidas, claras y enfocadas en conversion para negocios locales.'
    );
})->name('home');

Route::get('/about', function () {
    return renderSection(
        'about',
        'Sobre Mi | Desarrollador Web Freelance en ' . config('seo.city'),
        'Conoce mi experiencia en desarrollo web, metodologias de trabajo y enfoque tecnico para crear webs y aplicaciones web mantenibles para negocios en ' . config('seo.city') . ' y ' . config('seo.region') . '.'
    );
})->name('about');

Route::get('/articles', function () {
    return renderSection(
        'articles',
        'Articulos sobre Desarrollo Web, SEO y Conversion | RogerLab',
        'Lee articulos sobre precios web en ' . config('seo.country') . ', landing pages, conversion, SEO y criterios para contratar un desarrollador web orientado a negocio.'
    );
})->name('articles');

Route::get('/projects', function () {
    return renderSection(
        'projects',
        'Proyectos Web y Aplicaciones Desarrolladas | RogerLab',
        'Explora proyectos de desarrollo web y aplicaciones a medida creados con Laravel, JavaScript y tecnologias modernas, orientados a rendimiento, usabilidad y negocio.'
    );
})->name('projects');

Route::get('/juegos', function () {
    return renderSection(
        'juegos',
        'Juegos JavaScript | RogerLab',
        'Diviértete con juegos interactivos desarrollados en JavaScript, juegos como el ahorcado, y juegos de rol desarollado en el grado de Desarrollo de Aplicaciones Web'
    );
})->name('juegos');

Route::get('/juegos/ahorcado', function () {
    return renderSection(
        'ahorcado',
        'Juego del Ahorcado | RogerLab',
        'Juega al ahorcado en una experiencia interactiva desarrollada con JavaScript dentro de RogerLab.'
    );
})->name('juegos.ahorcado');



Route::get('/contact', function () {
    return renderSection(
        'contact',
        'Contacto | Solicita tu Presupuesto Web en ' . config('seo.city'),
        'Cuentame tu proyecto y recibe una propuesta para tu pagina web, landing page o aplicacion web a medida en ' . config('seo.city') . ', ' . config('seo.region') . ' o cualquier punto de ' . config('seo.country') . '.'
    );
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.submit');

Route::get('/contact/verify/{contactMessage}/{token}', [ContactController::class, 'verify'])
    ->middleware('signed')
    ->name('contact.verify');


Route::get('/privacy-policy', function () {
    return renderSection(
        'privacyPolicy',
        'Politica de Privacidad | RogerLab',
        'Consulta como se recopilan, utilizan y protegen los datos personales enviados a traves del portfolio y del formulario de contacto de RogerLab.'
    );
})->name('privacy-policy');


Route::get('/terms-of-service', function () {
    return renderSection(
        'termsOfService',
        'Terminos del Servicio | RogerLab',
        'Revisa las condiciones de uso del contenido, limitaciones y alcance del portfolio profesional de RogerLab.'
    );
})->name('terms-of-service');

Route::get('/cookies-privacy', function () {
    return renderSection(
        'cookiesPrivacy',
        'Politica de Cookies | RogerLab',
        'Informacion sobre el uso de cookies, tecnologias de seguimiento y opciones de control disponibles en la web de RogerLab.'
    );
})->name('cookies-privacy');

Route::get('/pdf-cv/english', function () {
    $path = resource_path('views/components/pdf-cv/RogerioLucas-cv-English.pdf');

    abort_unless(file_exists($path), 404);

    return response()->file($path, ['Content-Type' => 'application/pdf']);
})->name('pdf-cv.english');

Route::get('/pdf-cv/spanish', function () {
    $path = resource_path('views/components/pdf-cv/RogerioLucas-Spanish-cv.pdf');

    abort_unless(file_exists($path), 404);

    return response()->file($path, ['Content-Type' => 'application/pdf']);
})->name('pdf-cv.spanish');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');

Route::get('/{any}', function () {
    return renderSection(
        'notFound',
        'Pagina no encontrada | RogerLab',
        'La pagina que buscas no esta disponible. Puedes volver al inicio para explorar servicios, proyectos y formas de contacto.',
        404,
        'noindex,nofollow'
    );
})->where('any', '.*')->name('not-found');
