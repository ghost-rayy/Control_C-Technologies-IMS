<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesRecordingController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Products
    Route::resource('products', ProductController::class);
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

    // Sales Recording
    Route::get('/sales/create', [SalesRecordingController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SalesRecordingController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}/receipt', [SalesRecordingController::class, 'receipt'])->name('sales.receipt');
    Route::get('/sales/{sale}/print', [SalesRecordingController::class, 'print'])->name('sales.print');
    Route::get('/sales/history', [SalesRecordingController::class, 'history'])->name('sales.history');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
