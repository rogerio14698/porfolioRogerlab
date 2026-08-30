<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/home', function () {
    return renderSection(
        'home',
        'Rogerio Lucas Viana | Desarrollador Web Full Stack Junior en Gijón',
        'Portfolio de Rogerio Lucas Viana, desarrollador web Full Stack Junior en Gijón, Asturias. Proyectos y experiencia con Laravel, PHP, JavaScript, Docker, SQL y AWS.'
    );
})->name('home');

Route::get('/about', function () {
    return renderSection(
        'about',
        'Sobre Rogerio Lucas Viana | Desarrollador Web Full Stack Junior',
        'Conoce la experiencia, competencias y metodología de Rogerio Lucas Viana, desarrollador web Full Stack Junior titulado en DAW y especializado en Laravel, PHP y JavaScript.'
    );
})->name('about');

Route::get('/mi-periodo-practicas', function () {
    return renderSection(
        'miPeriodoPracticas',
        'Prácticas FCT en MON EVENT SL | Rogerio Lucas Viana',
        'Experiencia de Rogerio Lucas Viana en prácticas FCT: Docker, mantenimiento de aplicaciones PHP, refactorización de código heredado, AJAX y despliegues.'
    );
})->name('mi-periodo-practicas');

Route::get('/articles', function () {
    return renderSection(
        'articles',
        'Artículos y reflexiones técnicas | RogerLab',
        'Notas sobre aprendizaje técnico, mantenimiento, código heredado y desarrollo web desde una perspectiva profesional y honesta.'
    );
})->name('articles');

Route::get('/projects', function () {
    return renderSection(
        'projects',
        'Proyectos Full Stack | Laravel, PHP y JavaScript | Rogerio Lucas Viana',
        'Proyectos Full Stack de Rogerio Lucas Viana con Laravel, PHP, JavaScript, MySQL, Docker, AWS y automatización con n8n.'
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
        'Contacto profesional | Rogerio Lucas Viana, desarrollador Full Stack Junior',
        'Contacta con Rogerio Lucas Viana para vacantes junior, procesos de selección o colaboración en equipos de desarrollo web con Laravel, PHP y JavaScript.'
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

Route::get('/robots.txt', function () {
    return response()->view('robots')->header('Content-Type', 'text/plain');
})->name('robots.txt');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');

Route::get('/{any}', function () {
    return renderSection(
        'notFound',
        'Página no encontrada | RogerLab',
        'La página que buscas no está disponible. Puedes volver al inicio para revisar mi perfil, proyectos y formas de contacto.',
        404,
        'noindex,nofollow'
    );
})->where('any', '.*')->name('not-found');