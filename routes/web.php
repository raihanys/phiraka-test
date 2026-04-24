<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FibonacciController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/login');
});

// Soal 1: Fibonacci
Route::any('/fibonacci', [FibonacciController::class, 'index'])->name('fibonacci');

// Soal 2: Auth
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// ROUTE CAPTCHA
Route::get('/captcha-image', [UserController::class, 'generateCaptcha'])->name('captcha');

// Soal 2: CRUD User (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
