<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminDocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard overview
    Route::get('/', AdminDashboardController::class)->name('dashboard');

    // Events CRUD
    Route::post('/eventos', [AdminEventController::class, 'store'])->name('eventos.store');
    Route::put('/eventos/{event}', [AdminEventController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/{event}', [AdminEventController::class, 'destroy'])->name('eventos.destroy');

    // Documents CRUD
    Route::post('/documentos', [AdminDocumentController::class, 'store'])->name('documentos.store');
    Route::put('/documentos/{document}', [AdminDocumentController::class, 'update'])->name('documentos.update');
    Route::delete('/documentos/{document}', [AdminDocumentController::class, 'destroy'])->name('documentos.destroy');
});
