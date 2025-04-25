<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('userblade.login');
});


//View traders
Route::get('admin/trader/all', [AdminController::class, 'index']);
//Approve Traders
Route::post('admin/traders/{traderId}/approve',[AdminController::class,'approve']);
//Reject Traders
Route::post('admin/traders/{traderId}/reject',[AdminController::class,'reject']);

