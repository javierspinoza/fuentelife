<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Rutas de gestión de usuarios
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
        ->name('users.toggle-active');

    // Rutas de gestión de productos
    Route::resource('products', ProductController::class)->except(['show']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
