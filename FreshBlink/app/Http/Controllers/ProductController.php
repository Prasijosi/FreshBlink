<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'min_order' => 'required|integer|min:1',
            'max_order' => 'required|integer|min:1|gte:min_order',
            'price' => 'required|numeric|min:0',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->quantity = $validated['quantity'];
        $product->min_order = $validated['min_order'];
        $product->max_order = $validated['max_order'];
        $product->price = $validated['price'];
        $product->shop_id = $validated['shop_id'];
        $product->image = $imagePath;

        $product->save();

        return redirect()->back()->with('success', 'Product added successfully!');
    }
 

}
