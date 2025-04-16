<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    // Registration routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Login routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Password reset routes
    Route::get('/forgot-password', [AuthController::class, 'showPasswordRequestForm'])->name('password.request');
});

// Authenticated routes (only accessible when logged in)
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('notes', NoteController::class);

    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});