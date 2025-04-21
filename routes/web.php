<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

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

    // Note routes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // Page routes
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}', [PageController::class, 'show'])->name('pages.show');
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
    
    // Additional page actions
    Route::post('/pages/{page}/archive', [PageController::class, 'archive'])->name('pages.archive');
    Route::post('/pages/{page}/restore', [PageController::class, 'restore'])->name('pages.restore');
    Route::post('/pages/{page}/duplicate', [PageController::class, 'duplicate'])->name('pages.duplicate');
    Route::post('/pages/positions', [PageController::class, 'updatePositions'])->name('pages.positions');

    // Document routes
    Route::post('/documents/import', [DocumentController::class, 'import'])->name('documents.import');

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});