<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Orders - accessible by both admin and staff
    Route::resource('orders', OrderController::class)->except(['edit', 'update']);
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('ingredients', IngredientController::class)->except(['show']);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});