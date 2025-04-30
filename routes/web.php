<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ProfileController;
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

Route::get('/admin/dashboard', [UserController::class,'index'])->name('admin.dashboard');
Route::get('/admin/users', [UserController::class, 'userDisplay'])->name('admin.users.index');


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

    // Dashboard route
    Route::get('/dashboard',[PageController::class,'dashboard'])->name('dashboard');
    Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/{task}/toggle', [App\Http\Controllers\TaskController::class, 'toggleStatus'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
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

    // Workspace routes
    
    Route::get('/workspaces', [WorkspaceController::class, 'index'])->name('workspaces.index');
    Route::get('/workspaces/create', [WorkspaceController::class, 'create'])->name('workspaces.create');
    Route::post('/workspaces', [WorkspaceController::class, 'store'])->name('workspaces.store');
    Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
    Route::get('/workspaces/{workspace}/edit', [WorkspaceController::class, 'edit'])->name('workspaces.edit');
    Route::put('/workspaces/{workspace}', [WorkspaceController::class, 'update'])->name('workspaces.update');
    Route::delete('/workspaces/{workspace}', [WorkspaceController::class, 'destroy'])->name('workspaces.destroy');
    Route::get('/workspaces/switch/{workspace}', [WorkspaceController::class, 'switch'])->name('workspaces.switch');
    Route::post('/workspaces/join',[WorkspaceController::class,'join'])->name('workspaces.join');
    Route::get('/workspaces/join/invite',[WorkspaceController::class,'join'])->name('workspaces.join.invite');
    Route::get('/workspaces/Users/{workspace}',[WorkspaceController::class,'workspacesUsers'])->name('workspaces.users');
    Route::delete('/workspaces/Users/{workspace}/{user}',[WorkspaceController::class,'removeUser'])->name('workspaces.users.remove');
    Route::post('workspaces/invite/{workspace}',[WorkspaceController::class,'inviteUser'])->name('workspaces.users.invite');
    Route::post('workspaces/Users/accept/{workspace}/{user}',[WorkspaceController::class,'acceptUser'])->name('workspaces.users.accept');
    Route::post('workspaces/Users/reject/{workspace}/{user}',[WorkspaceController::class,'rejectUser'])->name('workspaces.users.reject');
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Admin routes (only accessible by admins)


