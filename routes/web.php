<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

$seoCity = config('seo.city');
$seoRegion = config('seo.region');
$seoCountry = config('seo.country');

// 1. Definimos la función anónima en una variable global del archivo
$renderSection = function (string $section, string $pageTitle, string $pageMetaDescription, int $status = 200, string $robotsMeta = 'index,follow') {
    $data = compact('section', 'pageTitle', 'pageMetaDescription', 'robotsMeta');

    if (request()->ajax()) {
        return response()->view('components.sectionContent', $data, $status);
    }

    return response()->view('index', $data, $status);
};

Route::redirect('/', '/home');

// 2. Pasamos la variable a cada ruta usando 'use ($renderSection)'
Route::get('/home', function () use ($renderSection) {
    return $renderSection(
        'home',
        'Desarrollador Web Freelance en ' . config('seo.city') . ' | Aplicaciones Web para Negocios',
        'Desarrollo paginas web, landings y aplicaciones web a medida en ' . config('seo.city') . ' y ' . config('seo.region') . '. Soluciones rapidas, claras y enfocadas en conversion para negocios locales.'
    );
})->name('home');

Route::get('/about', function () use ($renderSection) {
    return $renderSection(
        'about',
        'Sobre Mi | Desarrollador Web Freelance en ' . config('seo.city'),
        'Conoce mi experiencia en desarrollo web, metodologias de trabajo y enfoque tecnico para crear webs y aplicaciones web mantenibles para negocios en ' . config('seo.city') . ' y ' . config('seo.region') . '.'
    );
})->name('about');

Route::get('/mi-periodo-practicas', function () use ($renderSection) {
    return $renderSection(
        'miPeriodoPracticas',
        'Mi Periodo de Practicas (FCT) | RogerLab',
        'Conoce mi experiencia profesional durante las practicas FCT en Mon Event SL: despliegues, mantenimiento de aplicaciones web y gestion de codigo legacy.'
    );
})->name('mi-periodo-practicas');

Route::get('/articles', function () use ($renderSection) {
    return $renderSection(
        'articles',
        'Articulos sobre Desarrollo Web, SEO y Conversion | RogerLab',
        'Lee articulos sobre precios web en ' . config('seo.country') . ', landing pages, conversion, SEO y criterios para contratar un desarrollador web orientado a negocio.'
    );
})->name('articles');

Route::get('/projects', function () use ($renderSection) {
    return $renderSection(
        'projects',
        'Proyectos Web y Aplicaciones Desarrolladas | RogerLab',
        'Explora proyectos de desarrollo web y aplicaciones a medida creados con Laravel, JavaScript y tecnologias modernas, orientados a rendimiento, usabilidad y negocio.'
    );
})->name('projects');

Route::get('/juegos', function () use ($renderSection) {
    return $renderSection(
        'juegos',
        'Juegos JavaScript | RogerLab',
        'Diviértete con juegos interactivos desarrollados en JavaScript, juegos como el ahorcado, y juegos de rol desarollado en el grado de Desarrollo de Aplicaciones Web'
    );
})->name('juegos');

Route::get('/juegos/ahorcado', function () use ($renderSection) {
    return $renderSection(
        'ahorcado',
        'Juego del Ahorcado | RogerLab',
        'Juega al ahorcado en una experiencia interactiva desarrollada con JavaScript dentro de RogerLab.'
    );
})->name('juegos.ahorcado');

Route::get('/contact', function () use ($renderSection) {
    return $renderSection(
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

Route::get('/privacy-policy', function () use ($renderSection) {
    return $renderSection(
        'privacyPolicy',
        'Politica de Privacidad | RogerLab',
        'Consulta como se recopilan, utilizan y protegen los datos personales enviados a traves del portfolio y del formulario de contacto de RogerLab.'
    );
})->name('privacy-policy');

Route::get('/terms-of-service', function () use ($renderSection) {
    return $renderSection(
        'termsOfService',
        'Terminos del Servicio | RogerLab',
        'Revisa las condiciones de uso del contenido, limitations y alcance del portfolio profesional de RogerLab.'
    );
})->name('terms-of-service');

Route::get('/cookies-privacy', function () use ($renderSection) {
    return $renderSection(
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

Route::get('/robots.txt', function () {
    return response()->view('robots')->header('Content-Type', 'text/plain');
})->name('robots.txt');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');

Route::get('/{any}', function () use ($renderSection) {
    return $renderSection(
        'notFound',
        'Pagina no encontrada | RogerLab',
        'La pagina que buscas no esta disponible. Puedes volver al inicio para explorar servicios, proyectos y formas de contacto.',
        404,
        'noindex,nofollow'
    );
})->where('any', '.*')->name('not-found');