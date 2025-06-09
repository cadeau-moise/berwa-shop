<?php

use App\Http\Controllers\Auth\ShopkeeperAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest:shopkeeper')->group(function () {
    Route::get('login', [ShopkeeperAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [ShopkeeperAuthController::class, 'login']);
    Route::get('register', [ShopkeeperAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [ShopkeeperAuthController::class, 'register']);
});

Route::middleware('auth:shopkeeper')->group(function () {
    Route::post('logout', [ShopkeeperAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products Management
    Route::resource('products', ProductController::class);

    // Stock Management
    Route::post('products/{product}/stock-in', [ProductController::class, 'stockIn'])->name('products.stock-in');
    Route::post('products/{product}/stock-out', [ProductController::class, 'stockOut'])->name('products.stock-out');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('reports/stock-status', [ReportController::class, 'stockStatus'])->name('reports.stock-status');
    Route::get('reports/stock-in', [ReportController::class, 'stockIn'])->name('reports.stock-in');
    Route::get('reports/stock-out', [ReportController::class, 'stockOut'])->name('reports.stock-out');
});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});
