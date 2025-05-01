<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;
use App\Http\Controllers\AdminController;

// Home route
Route::get('/', function () {
    return view('userblade.login');
})->name('home');


// Trader Registration Routes
Route::get('trader/register', [TraderController::class, 'showRegister'])->name('trader.register.form');
Route::post('trader/register', [TraderController::class, 'register'])->name('trader.register.submit');

// Trader Login Routes
Route::get('/trader/login', [TraderController::class, 'showLoginForm'])->name('trader.login.form');
Route::post('/trader/login', [TraderController::class, 'login'])->name('trader.login.submit');

// Trader Logout
Route::post('/trader/logout', [TraderController::class, 'logout'])->name('trader.logout');

// Trader Dashboard
Route::get('/trader/dashboard', function () {
    return 'Welcome to Trader Dashboard!';
})->middleware('auth:trader')->name('trader.dashboard');


// Admin: Trader Management Routes
Route::get('/admin/traders', [AdminController::class, 'index'])->name('admin.traders.index');
Route::post('/admin/traders/{id}/approve', [AdminController::class, 'approve'])->name('admin.traders.approve');
Route::post('/admin/traders/{id}/reject', [AdminController::class, 'reject'])->name('admin.traders.reject');
