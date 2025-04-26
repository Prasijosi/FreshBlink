<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    // Display a listing of product categories
    public function index()
    {
        $categories = ProductCategory::withCount('products')->paginate(15);
        return view('userblade.category', compact('categories'));
    }

    // Display the specified category and its products
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        $products = Product::where('product_category_id', $id)->paginate(12);
        
        return view('userblade.category', compact('category', 'products'));
    }

    // Filter products by multiple categories
    public function filter(Request $request)
    {
        $categoryIds = $request->get('categories', []);
        $query = Product::query();
        
        if (!empty($categoryIds)) {
            $query->whereIn('product_category_id', $categoryIds);
        }
        
        $products = $query->paginate(12);
        $categories = ProductCategory::all();
        
        return view('userblade.category', compact('products', 'categories', 'categoryIds'));
    }

    // Browse products by category (for navigation)
    public function browse()
    {
        $categories = ProductCategory::withCount('products')->get();
        return view('userblade.category', compact('categories'));
    }
} 