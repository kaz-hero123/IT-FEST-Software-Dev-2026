<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ChatApiController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;


// PUBLIC ROUTES
Route::get('/', [LandingController::class, 'index']);
Route::get('/about', [LandingController::class, 'about']);
Route::get('/question', [LandingController::class, 'question']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/explore', [ExploreController::class, 'index']);
Route::get('/explore/{regency}', [ExploreController::class, 'show']);
Route::get('/explore/{regency}/{content}', [ContentController::class, 'show']);

// Smart Predictor (Bagian A) - Dipindahkan ke Explore
Route::post('/predictor/predict', [App\Http\Controllers\PredictorController::class, 'predict']);

// Chat API (public - accessible without auth)
Route::middleware(['throttle:120,1', function ($request, $next) {
    if (!$request->ajax() && !app()->runningUnitTests()) {
        return response()->json(['error' => 'Forbidden: API access is restricted to the application frontend.'], 403);
    }
    return $next($request);
}])->group(function () {
    Route::get('/api/chat/messages', [ChatApiController::class, 'getMessages']);
    Route::post('/api/chat/send', [ChatApiController::class, 'sendMessage']);
    Route::post('/api/chat/clear', [ChatApiController::class, 'clearMessages']);
});

// Auth — hanya untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::get('/register', [AuthController::class, 'registerForm']);
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
    
    // Password Reset
    Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// CONTRIBUTOR ROUTES
Route::middleware(['auth', 'contributor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/contents/create', [ContentController::class, 'create']);
    Route::post('/contents', [ContentController::class, 'store'])->middleware('throttle:20,1');
    Route::get('/contents/{content}/edit', [ContentController::class, 'edit']);
    Route::put('/contents/{content}', [ContentController::class, 'update'])->middleware('throttle:20,1');
    Route::delete('/contents/{content}', [ContentController::class, 'destroy']);
});

// ADMIN API ROUTES (No prefix, but uses admin auth)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/api/chat/admin/conversations', [ChatApiController::class, 'getAdminConversations']);
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

        // Live Chat Support
        Route::get('/chat', [AdminChatController::class, 'index']);
    });
});
