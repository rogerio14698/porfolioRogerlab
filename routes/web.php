<?php

use Illuminate\Support\Facades\Route;

//Vista por defecto, redirecciona a la landing page
Route::get('/', function () {return view('index');});

//Ruta de incio, landing page
Route::get('/home', function () {return view('index');})->name('home');

//Ruta de contacto
Route::get('/contact', function () {return view('rogerlab-Paginas.contacto');})->name('contact');

//Routa projects
Route::get('/projects', function () {return view('rogerlab-Paginas.projects');})->name('projects');

//Ruta de servicios
Route::get('/about', function () {return view('rogerlab-Paginas.about');})->name('about');