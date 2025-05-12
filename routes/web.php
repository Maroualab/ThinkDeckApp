<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\WorkspaceMiddleware;
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

// Admin routes
// These routes require both authentication and admin privileges
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [UserController::class,'index'])->name('dashboard');
    Route::patch('/dashboard/{user}', [UserController::class,'updateStatusUser'])->name('updateRole'); // Consider renaming to users.updateStatus
    Route::get('/users', [UserController::class, 'userDisplay'])->name('users.index');
});


// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    // Registration routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Login routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Password reset routes (Ensure these controllers and views exist if you plan to use them)
    // Route::get('/forgot-password', [AuthController::class, 'showPasswordRequestForm'])->name('password.request');
    // Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');
    // Route::get('/reset-password/{token}', [AuthController::class, 'showPasswordResetForm'])->name('password.reset');
    // Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated routes (only accessible when logged in)
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard',[PageController::class,'dashboard'])->name('dashboard');
    
    // Task routes
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Note routes
    Route::resource('notes', NoteController::class); // Uses resource controller for standard CRUD

    // Page routes
    Route::resource('pages', PageController::class); // Uses resource controller for standard CRUD
    
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
    Route::get('/workspaces/{workspace}/edit', [WorkspaceController::class, 'edit'])->name('workspaces.edit');
    Route::put('/workspaces/{workspace}', [WorkspaceController::class, 'update'])->name('workspaces.update');
    Route::patch('/workspaces/{workspace}', [WorkspaceController::class, 'update']); // Alias for update
    Route::delete('/workspaces/{workspace}', [WorkspaceController::class, 'destroy'])->name('workspaces.destroy');
    Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show'])->middleware(WorkspaceMiddleware::class)->name('workspaces.show'); // Custom show route
    Route::post('/workspaces/join',[WorkspaceController::class,'join'])->name('workspaces.join');
    Route::get('/workspaces/join/invite',[WorkspaceController::class,'join'])->name('workspaces.join.invite'); // This seems redundant with the POST join
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
});