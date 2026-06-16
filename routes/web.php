<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;


// PUBLIC ROUTES
Route::get('/', [LandingController::class, 'index']);
Route::get('/explore', [ExploreController::class, 'index']);
Route::get('/explore/{regency}', [ExploreController::class, 'show']);
Route::get('/explore/{regency}/{content}', [ContentController::class, 'show']);

// Auth — hanya untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// CONTRIBUTOR ROUTES
Route::middleware(['auth', 'contributor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/contents/create', [ContentController::class, 'create']);
    Route::post('/contents', [ContentController::class, 'store']);
    Route::get('/contents/{content}/edit', [ContentController::class, 'edit']);
    Route::put('/contents/{content}', [ContentController::class, 'update']);
    Route::delete('/contents/{content}', [ContentController::class, 'destroy']);
});

// ADMIN ROUTES
Route::prefix('admin')->group(function () {

    // Admin login — guest only
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Admin authenticated routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // Moderation
        Route::get('/moderation', [ModerationController::class, 'index']);
        Route::get('/moderation/{content}', [ModerationController::class, 'show']);
        Route::post('/moderation/{content}/approve', [ModerationController::class, 'approve']);
        Route::post('/moderation/{content}/reject', [ModerationController::class, 'reject']);

        // Content management
        Route::get('/contents', [AdminContentController::class, 'index']);
        Route::post('/contents/{content}/unpublish', [AdminContentController::class, 'unpublish']);
        Route::delete('/contents/{content}', [AdminContentController::class, 'destroy']);
    });
});
