<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function create()
    {
        $traderId = Auth::guard('trader')->user()->id;
        $shops = Shop::where('trader_id', $traderId)->get();
        $categories = Category::all();
    
        return view('traderblade.addproduct', compact('shops', 'categories'));
    }
}
