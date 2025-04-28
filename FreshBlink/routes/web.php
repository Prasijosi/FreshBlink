<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('userblade.login');
});



Route::get('trader/register', [TraderController::class, 'showRegister']);
Route::post('trader/register', [TraderController::class, 'register']);


//Login get
Route::get('/trader/login',[TraderController::class,'showLoginForm']);

// Login POST
Route::post('/trader/login', [TraderController::class, 'login']);

// Logout
Route::post('/trader/logout', [TraderController::class, 'logout']);

// Trader Dashboard after login (Temporary placeholder)
Route::get('/trader/dashboard', function () {
    return 'Welcome to Trader Dashboard!';
})->middleware('auth:trader');


//Admin Traders relationships
Route::get('/admin/traders', [AdminController::class, 'index']);

// Approve trader
Route::post('/admin/traders/{id}/approve', [AdminController::class, 'approve']);

// Reject trader
Route::post('/admin/traders/{id}/reject', [AdminController::class, 'reject']);

