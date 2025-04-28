<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;


Route::get('/', function () {
    return view('userblade.home');
});



Route::get('trader/register', [TraderController::class, 'showRegister']);
Route::post('trader/register', [TraderController::class, 'register']);