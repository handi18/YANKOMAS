<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsirasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile.edit');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Aspirasi routes
    Route::resource('aspirasi', AsirasiController::class);
    Route::post('aspirasi/{aspirasi}/update-status', [AsirasiController::class, 'updateStatus'])->name('aspirasi.update-status');

    // Report routes
    Route::get('aspirasi/export/excel', [ReportController::class, 'exportExcel'])->name('aspirasi.export-excel');
    Route::get('aspirasi/export/pdf', [ReportController::class, 'exportPdf'])->name('aspirasi.export-pdf');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        // User management
        Route::prefix('admin')->group(function () {
            Route::get('users', [AdminController::class, 'users'])->name('admin.users');
            Route::get('users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
            Route::post('users', [AdminController::class, 'storeUser'])->name('admin.users.store');
            Route::get('users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
            Route::put('users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
            Route::delete('users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
            Route::post('users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');

            // Activity logs
            Route::get('activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');
        });
    });
});
