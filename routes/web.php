<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/home', function () {
    $section = 'home';
    return view('index', compact('section'));
})->name('home');

Route::get('/about', function () {
    $section = 'about';
    return view('index', compact('section'));
})->name('about');

Route::get('/projects', function () {
    $section = 'projects';
    return view('index', compact('section'));
})->name('projects');

Route::get('/contact', function () {
    $section = 'contact';
    return view('index', compact('section'));
})->name('contact');


Route::get('/privacy-policy', function () {
    $section = 'privacyPolicy';
    return view('index', compact('section'));
})->name('privacy-policy');


Route::get('/terms-of-service', function () {
    $section = 'termsOfService';
    return view('index', compact('section'));
})->name('terms-of-service');

Route::get('/cookies-privacy', function () {
    $section = 'cookiesPrivacy';
    return view('index', compact('section'));
})->name('cookies-privacy');

Route::get('/{any}', function () {
    $section = 'notFound';
    return view('index', compact('section'));
})->where('any', '.*')->name('not-found');