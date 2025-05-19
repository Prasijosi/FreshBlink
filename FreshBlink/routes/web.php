<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\TraderController;
use App\Http\Controllers\PayPalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Home route
Route::get('/', function () {
    return view('userblade.home');
});

// Authentication routes
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// User profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'showEditProfile'])->name('user.profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('user.password.change');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.password.update');
})->name('home');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/products/{id}/review', [ProductController::class, 'submitReview'])->name('products.review');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Wishlist routes
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::get('/wishlists/{id}', [WishlistController::class, 'show'])->name('wishlists.show');
    Route::get('/wishlists/create', [WishlistController::class, 'create'])->name('wishlists.create');
    Route::post('/wishlists', [WishlistController::class, 'store'])->name('wishlists.store');
    Route::get('/wishlists/{id}/edit', [WishlistController::class, 'edit'])->name('wishlists.edit');
    Route::put('/wishlists/{id}', [WishlistController::class, 'update'])->name('wishlists.update');
    Route::delete('/wishlists/{id}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');
    Route::post('/wishlists/add', [WishlistController::class, 'addProduct'])->name('wishlists.add.product');
    Route::delete('/wishlists/{wishlistId}/product/{productId}', [WishlistController::class, 'removeProduct'])->name('wishlists.remove.product');
    Route::post('/wishlists/move', [WishlistController::class, 'moveProduct'])->name('wishlists.move.product');
});

// Add to wishlist from product page
Route::post('/products/{id}/wishlist', [ProductController::class, 'addToWishlist'])->name('products.wishlist.add');
Route::delete('/products/{id}/wishlist', [ProductController::class, 'removeFromWishlist'])->name('products.wishlist.remove');

// Order routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Shop routes
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{id}', [ShopController::class, 'show'])->name('shops.show');
Route::get('/shops/{shopId}/category/{categoryId}', [ShopController::class, 'filterByCategory'])->name('shops.category');
Route::get('/shops/{id}/search', [ShopController::class, 'search'])->name('shops.search');

// Shop management (trader) routes
Route::middleware(['auth'])->group(function () {
    Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
    Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');
    Route::get('/shops/{id}/edit', [ShopController::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{id}', [ShopController::class, 'update'])->name('shops.update');
    Route::delete('/shops/{id}', [ShopController::class, 'destroy'])->name('shops.destroy');
    Route::get('/shops/{id}/dashboard', [ShopController::class, 'dashboard'])->name('shops.dashboard');
});

// Trader routes
Route::prefix('trader')->name('trader.')->group(function () {
    // Registration routes
    Route::get('/register', [TraderController::class, 'showRegister'])->name('register');
    Route::post('/register', [TraderController::class, 'register'])->name('register.submit');
    
    // Login routes
    Route::get('/login', [TraderController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [TraderController::class, 'login'])->name('login.submit');
    Route::post('/logout', [TraderController::class, 'logout'])->name('logout');
    
    // Protected trader routes
    Route::middleware(['auth:trader'])->group(function () {
        Route::get('/dashboard', [TraderController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [TraderController::class, 'profile'])->name('profile');
        Route::put('/profile', [TraderController::class, 'updateProfile'])->name('profile.update');
    });
});

// Category routes
Route::get('/categories', [ProductCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [ProductCategoryController::class, 'show'])->name('categories.show');
Route::post('/categories/filter', [ProductCategoryController::class, 'filter'])->name('categories.filter');
Route::get('/browse', [ProductCategoryController::class, 'browse'])->name('categories.browse');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // Admin protected routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Users management
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
        Route::put('/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
        
        // Shops management
        Route::get('/shops', [AdminController::class, 'manageShops'])->name('shops');
        Route::get('/shops/{id}', [AdminController::class, 'showShop'])->name('shops.show');
        
        // Categories management
        Route::get('/categories', [AdminController::class, 'manageCategories'])->name('categories');
        Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
        Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
        
        // Reports management
        Route::get('/reports', [AdminController::class, 'manageReports'])->name('reports');
        Route::get('/reports/{id}', [AdminController::class, 'showReport'])->name('reports.show');
        Route::put('/reports/{id}', [AdminController::class, 'updateReportStatus'])->name('reports.update');
        
        // Discounts management
        Route::get('/discounts', [AdminController::class, 'manageDiscounts'])->name('discounts');
        Route::get('/discounts/create', [AdminController::class, 'createDiscount'])->name('discounts.create');
        Route::post('/discounts', [AdminController::class, 'storeDiscount'])->name('discounts.store');

        // Trader management
        Route::get('/traders', [AdminController::class, 'index'])->name('traders');
        Route::post('/traders/{id}/approve', [AdminController::class, 'approve'])->name('traders.approve');
        Route::post('/traders/{id}/reject', [AdminController::class, 'reject'])->name('traders.reject');
    });
});

// PayPal Routes
Route::prefix('paypal')->group(function () {
    Route::get('payment', [PayPalController::class, 'showPaymentForm'])->name('paypal.payment');
    Route::post('create-payment', [PayPalController::class, 'createPayment'])->name('paypal.create');
    Route::get('success', [PayPalController::class, 'success'])->name('paypal.success');
    Route::get('cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');
});

// Password Reset Routes
Route::get('forgot-password', [UserController::class, 'showForgotPassword'])->name('password.request');
Route::post('forgot-password', [UserController::class, 'forgotPassword'])->name('password.email');
Route::get('reset-password/{token}', [UserController::class, 'showResetPassword'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'resetPassword'])->name('password.update');
