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
