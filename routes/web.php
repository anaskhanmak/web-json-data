<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;

// JSON-driven homepage (content from storage/app/content.json)
Route::get('/', [PageController::class, 'home'])->name('home');

// Legacy frontend home (existing site)
Route::get('/home', [FrontendController::class, 'home'])->name('frontend.home');

// Admin dashboard: view and update content JSON
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'update'])->name('dashboard.update');
});
