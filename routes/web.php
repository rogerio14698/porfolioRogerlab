<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/home', function () {
    return renderSection(
        'home',
        'RogerLab | Desarrollador Full Stack titulado en DAW',
        'Portfolio de Rogério Lucas, desarrollador Full Stack titulado en DAW. Proyectos con Laravel, PHP, JavaScript, bases de datos, Docker y AWS orientados a código mantenible y trabajo en equipo.'
    );
})->name('home');

Route::get('/about', function () {
    return renderSection(
        'about',
        'Sobre mí | Rogério Lucas, desarrollador Full Stack',
        'Experiencia, metodología de trabajo y objetivos profesionales de Rogério Lucas tras finalizar DAW y realizar prácticas en entorno real.'
    );
})->name('about');

Route::get('/mi-periodo-practicas', function () {
    return renderSection(
        'miPeriodoPracticas',
        'Mi Periodo de Practicas (FCT) | RogerLab',
        'Conoce mi experiencia profesional durante las practicas FCT en Mon Event SL: despliegues, mantenimiento de aplicaciones web y gestion de codigo legacy.'
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
        'Proyectos | Rogério Lucas',
        'Selección de proyectos académicos, personales y de prácticas con Laravel, JavaScript, bases de datos y despliegue.'
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
        'Contacto profesional | RogerLab',
        'Escríbeme para hablar sobre vacantes, procesos de selección o colaboración técnica dentro de un equipo de desarrollo.'
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