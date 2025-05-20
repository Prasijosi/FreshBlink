<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AuthenticateTrader;


// Home route
Route::get('/', function () {
    return view('userblade.login');
})->name('home');


// Trader Registration Routes
Route::get('trader/register', [TraderController::class, 'showRegister'])->name('trader.register.form');
Route::post('trader/register', [TraderController::class, 'register'])->name('trader.register.submit');

// Trader Login Routes
Route::get('/trader/login', [TraderController::class, 'showLoginForm'])->name('login');
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


//Trader Shop


// Route::middleware(['auth'])->group(function () {
//     Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
//     Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');
//     Route::get('/trader/home', function () {
//         return view('traderblade.traderhome');
//     })->name('traderhome');
// });




// Route::middleware([AuthenticateTrader::class])->group(function () {
//     Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
//     Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

//     Route::get('/trader/home', function () {
//         return view('traderblade.traderhome');
//     })->name('traderhome');
// });


Route::middleware([AuthenticateTrader::class])->group(function () {
    Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
    Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');
    Route::get('/trader/home', [ShopController::class, 'home'])->name('traderhome');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});

Route::middleware(['auth:trader'])->group(function () {
    Route::resource('products', ProductController::class);
});
