<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    // Display a listing of shops
    public function index()
    {
        $shops = Shop::withCount('products')->paginate(12);
        return view('shops.index', compact('shops'));
    }

    // Display a specific shop and its products
    public function show($id)
    {
        $shop = Shop::findOrFail($id);
        $products = Product::where('shop_id', $id)
                           ->paginate(12);
        $categories = ProductCategory::all();
        
        return view('shops.show', compact('shop', 'products', 'categories'));
    }

    // Display shop creation form (for traders)
    public function create()
    {
        if (!Auth::check() || !Auth::user()->trader) {
            return redirect()->route('trader.register')
                             ->with('error', 'You need to be registered as a trader to create a shop');
        }
        
        return view('shops.create');
    }

    // Store a newly created shop
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->trader) {
            return redirect()->route('trader.register');
        }
        
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255|unique:shops',
            'description' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email|max:255',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $shop = Shop::create([
            'user_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'description' => $request->description,
            'address' => $request->address,
            'email' => $request->email,
            'created_on' => now(),
        ]);
        
        return redirect()->route('shops.show', $shop->id)
                         ->with('success', 'Shop created successfully');
    }

    // Display form to edit shop
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $shop = Shop::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
        
        return view('shops.edit', compact('shop'));
    }

    // Update shop
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $shop = Shop::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255|unique:shops,shop_name,' . $shop->id,
            'description' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email|max:255',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $shop->update([
            'shop_name' => $request->shop_name,
            'description' => $request->description,
            'address' => $request->address,
            'email' => $request->email,
        ]);
        
        return redirect()->route('shops.show', $shop->id)
                         ->with('success', 'Shop updated successfully');
    }

    // Delete shop
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $shop = Shop::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
        
        // Check if shop has products
        $productCount = Product::where('shop_id', $id)->count();
        
        if ($productCount > 0) {
            return back()->with('error', 'Cannot delete shop with existing products. Please remove all products first.');
        }
        
        $shop->delete();
        
        return redirect()->route('shops.index')
                         ->with('success', 'Shop deleted successfully');
    }

    // Show shop analytics/dashboard for owner
    public function dashboard($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $shop = Shop::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
        
        $products = Product::where('shop_id', $id)->get();
        $totalProducts = $products->count();
        $totalStock = $products->sum('quantity');
        $totalValue = $products->sum(function($product) {
            return $product->price * $product->quantity;
        });
        
        // Get order statistics (could be expanded further)
        $orderCount = $shop->orderCount();
        $totalSales = $shop->totalSales();
        
        return view('shops.dashboard', compact(
            'shop', 
            'totalProducts', 
            'totalStock', 
            'totalValue', 
            'orderCount', 
            'totalSales'
        ));
    }

    // Filter shop products by category
    public function filterByCategory($shopId, $categoryId)
    {
        $shop = Shop::findOrFail($shopId);
        $category = ProductCategory::findOrFail($categoryId);
        
        $products = Product::where('shop_id', $shopId)
                           ->where('product_category_id', $categoryId)
                           ->paginate(12);
        
        $categories = ProductCategory::all();
        
        return view('shops.category', compact('shop', 'category', 'products', 'categories'));
    }

    // Search within a shop
    public function search(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $keyword = $request->get('keyword');
        
        $products = Product::where('shop_id', $id)
                           ->where(function($query) use ($keyword) {
                               $query->where('product_name', 'like', '%' . $keyword . '%')
                                     ->orWhere('description', 'like', '%' . $keyword . '%');
                           })
                           ->paginate(12);
        
        $categories = ProductCategory::all();
        
        return view('shops.search', compact('shop', 'products', 'categories', 'keyword'));
    }
} 