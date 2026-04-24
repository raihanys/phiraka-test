<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FibonacciController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/fibonacci');
});

Route::any('/fibonacci', [FibonacciController::class, 'index'])->name('fibonacci');

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/captcha-image', [UserController::class, 'generateCaptcha'])->name('captcha');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
