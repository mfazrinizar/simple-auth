<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('login.post');

    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('registration', [AuthController::class, 'postRegistration'])->name('register.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('welcome', [AuthController::class, 'welcome'])->name('welcome');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});