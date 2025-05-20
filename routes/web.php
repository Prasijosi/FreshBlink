// User profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'showEditProfile'])->name('user.profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('user.password.change');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.password.update');
    
    // Loyalty points routes
    Route::get('/loyalty-points', [CustomerController::class, 'showLoyaltyPoints'])->name('customer.loyalty-points');
    Route::post('/redeem-points', [CustomerController::class, 'applyPointsDiscount'])->name('customer.redeem-points');
}); 