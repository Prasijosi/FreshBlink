<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;


Route::get('/', function () {
    return view('userblade.login');
});



Route::get('trader/register', [TraderController::class, 'showRegister']);
Route::post('trader/register', [TraderController::class, 'register']);
//add Product trader routing
Route::view('trader/addproduct/',"traderblade.addproduct");