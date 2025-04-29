<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//temp

Route::view('/customer/cart','userblade.cart');