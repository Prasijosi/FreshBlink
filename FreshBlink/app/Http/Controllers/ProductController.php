<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
{
    $trader = Auth::guard('trader')->user();

    $products = Product::with(['shop', 'category'])
        ->where('user_id', $trader->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $shops = Shop::where('trader_id', $trader->id)->get();
    $categories = Category::all();

    return view('traderblade.index', compact('products', 'shops', 'categories'));
}

    public function create()
    {
        $traderId = Auth::guard('trader')->user()->id;
        $shops = Shop::where('trader_id', $traderId)->get();
        $categories = Category::all();
    
        return view('traderblade.addproduct', compact('shops', 'categories'));
    }


public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'description' => 'nullable|string',
        'min_order' => 'required|integer',
        'max_order' => 'nullable|integer',
        'stock_no' => 'nullable|string',
        'shop_id' => 'required|exists:shops,id',
        'product_category_id' => 'required|exists:categories,id',
    ]);

    $traderId = Auth::guard('trader')->id();

    $validated['user_id'] = Auth::guard('trader')->id();
    Product::create($validated);

    return redirect()->route('products.index')->with('success', 'Product saved successfully!');
}
}
