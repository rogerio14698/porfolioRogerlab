<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\AdminSkillController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogLoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\BlogLocale;
use App\Http\Middleware\BlogOwner;
use App\Http\Middleware\PrivateBlogResponse;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/home', [PortfolioController::class, 'home'])->middleware(BlogLocale::class)->name('home');

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

Route::middleware(BlogLocale::class)->group(function () {
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/media/{image}', [BlogController::class, 'image'])->name('blog.image');
    Route::get('/blog/porfolio', [BlogController::class, 'redirectLegacy'])->name('blog.legacy');
    Route::get('/blog/{blog:link}', [BlogController::class, 'show'])->name('blog.show');

    Route::middleware(PrivateBlogResponse::class)->group(function () {
        Route::get('/login', [BlogLoginController::class, 'create'])->name('login');
        Route::post('/login', [BlogLoginController::class, 'store'])->middleware('throttle:blog-login')->name('login.store');
        Route::middleware([BlogOwner::class, 'auth.session'])->group(function () {
            Route::post('/logout', [BlogLoginController::class, 'destroy'])->name('logout');
            Route::get('/admin/blog/{blog}/preview', [BlogController::class, 'preview'])->name('admin.blog.preview');
            Route::resource('/admin/blog', AdminBlogController::class)->except('show')->names('admin.blog');
            Route::get('/admin/projects/{project}/preview', [PortfolioController::class, 'preview'])->name('admin.projects.preview');
            Route::resource('/admin/projects', AdminProjectController::class)->except('show')->names('admin.projects');
            Route::resource('/admin/skills', AdminSkillController::class)->except('show')->names('admin.skills');
        });
    });
});

Route::middleware(BlogLocale::class)->group(function () {
    Route::get('/projects', [PortfolioController::class, 'index'])->name('projects');
    Route::get('/projects/media/{project}/{index}', [PortfolioController::class, 'image'])->whereNumber('index')->name('projects.image');
    Route::get('/projects/{project:slug}', [PortfolioController::class, 'show'])->name('projects.show');
});

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
        'Política de Privacidad | RogerLab',
        'Consulta cómo se recopilan, utilizan y protegen los datos personales enviados a través del portfolio y del formulario de contacto de RogerLab.'
    );
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return renderSection(
        'termsOfService',
        'Términos del Servicio | RogerLab',
        'Revisa las condiciones de uso del contenido, limitaciones y alcance del portfolio profesional de RogerLab.'
    );
})->name('terms-of-service');

Route::get('/cookies-privacy', function () {
    return renderSection(
        'cookiesPrivacy',
        'Política de Cookies | RogerLab',
        'Información sobre el uso de cookies, tecnologías de seguimiento y opciones de control disponibles en la web de RogerLab.'
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
