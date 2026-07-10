<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'public/Home')->name('home');
Route::inertia('/nosotros', 'public/AboutUs')->name('about-us');
Route::inertia('/proyeccion-social', 'public/ProyeccionSocial')->name('proyeccion-social');
Route::inertia('/seguimiento-graduado', 'public/SeguimientoGraduado')->name('seguimiento-graduado');
Route::inertia('/documentos', 'public/Documentos')->name('documentos');
Route::inertia('/eventos', 'public/Eventos')->name('eventos');
Route::inertia('/sandbox', 'public/Sandbox')->name('sandbox');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
