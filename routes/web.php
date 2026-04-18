<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

if (! function_exists('renderSection')) {
    function renderSection(string $section, string $pageTitle, int $status = 200)
    {
        $data = compact('section', 'pageTitle');

        if (request()->ajax()) {
            return response()->view('components.sectionContent', $data, $status);
        }

        return response()->view('index', $data, $status);
    }
}

Route::redirect('/', '/home');

Route::get('/home', function () {
    return renderSection('home', 'Inicio');
})->name('home');

Route::get('/about', function () {
    return renderSection('about', 'About');
})->name('about');

Route::get('/projects', function () {
    return renderSection('projects', 'Projects');
})->name('projects');

Route::get('/contact', function () {
    return renderSection('contact', 'Contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.submit');

Route::get('/contact/verify/{contactMessage}/{token}', [ContactController::class, 'verify'])
    ->middleware('signed')
    ->name('contact.verify');


Route::get('/privacy-policy', function () {
    return renderSection('privacyPolicy', 'Privacy Policy');
})->name('privacy-policy');


Route::get('/terms-of-service', function () {
    return renderSection('termsOfService', 'Terms of Service');
})->name('terms-of-service');

Route::get('/cookies-privacy', function () {
    return renderSection('cookiesPrivacy', 'Cookies Policy');
})->name('cookies-privacy');

Route::get('/{any}', function () {
    return renderSection('notFound', '404', 404);
})->where('any', '.*')->name('not-found');
