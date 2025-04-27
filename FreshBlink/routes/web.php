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


//Admin and trader relationship


//Admin panel to view traders
Route::get('/admin/traders',[AdminController::class,'index']);

//Admin panel to approve traders

Route::post('/admin/traders/{id}/approve',[AdminController::class,'approve']);

//Admin panel to reject traders
Route::post('/admin/traders/{id}/reject',[AdminController::class,'reject']);

