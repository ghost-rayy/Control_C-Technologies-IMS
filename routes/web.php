<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\SalesRecordingController;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('staff.dashboard');
        }
    }
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
});

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

    // Staff Management
    Route::resource('staff', StaffController::class)->except('show');
    Route::patch('/staff/{staff}/toggle-active', [StaffController::class, 'toggleActive'])->name('staff.toggle-active');

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
});

// Staff routes
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    // Sales
    Route::get('/sales/create', [SalesRecordingController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SalesRecordingController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}/receipt', [SalesRecordingController::class, 'receipt'])->name('sales.receipt');
    Route::get('/sales/{sale}/print', [SalesRecordingController::class, 'print'])->name('sales.print');
    Route::get('/sales/history', [SalesRecordingController::class, 'history'])->name('sales.history');
});

