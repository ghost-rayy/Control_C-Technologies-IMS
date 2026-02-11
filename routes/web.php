<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesRecordingController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::match(['get', 'post'], '/logout', function () {
    return redirect()->route('admin.dashboard');
})->name('logout');

// Admin routes
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/chart-data', [AdminDashboardController::class, 'getChartData'])->name('api.chart-data');
    
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
    Route::get('/sales/history/export', [SalesRecordingController::class, 'export'])->name('sales.history.export');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/database/clear', [ProfileController::class, 'clearDatabase'])->name('database.clear');
});
