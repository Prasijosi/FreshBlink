<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Display a listing of products
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Filter by category if provided
        if ($request->has('category')) {
            $query->where('product_category_id', $request->category);
        }
        
        // Filter by shop if provided
        if ($request->has('shop')) {
            $query->where('shop_id', $request->shop);
        }
        
        // Filter by price range if provided
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Search by name if provided
        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->paginate(12);
        $categories = ProductCategory::all();
        
        return view('userblade.category', compact('products', 'categories'));
    }

    // Display product details
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                                    ->where('id', '!=', $id)
                                    ->limit(4)
                                    ->get();
        $reviews = Review::where('product_id', $id)->latest()->get();
        
        // Check if product is in user's wishlist
        $inWishlist = false;
        if (Auth::check()) {
            $inWishlist = Wishlist::where('user_id', Auth::id())
                                    ->whereHas('wishlistProducts', function($query) use ($id) {
                                        $query->where('product_id', $id);
                                    })
                                    ->exists();
        }
        
        return view('userblade.product_detail', compact('product', 'relatedProducts', 'reviews', 'inWishlist'));
    }

    // Search products
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $products = Product::where('product_name', 'like', '%' . $keyword . '%')
                           ->orWhere('description', 'like', '%' . $keyword . '%')
                           ->paginate(12);
                           
        return view('products.search', compact('products', 'keyword'));
    }

    // Add product to wishlist
    public function addToWishlist($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add products to wishlist');
        }
        
        $user = Auth::user();
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'wishlist_name' => 'My Wishlist'
        ]);
        
        // Check if product already exists in the wishlist
        $exists = $wishlist->wishlistProducts()->where('product_id', $id)->exists();
        
        if (!$exists) {
            $wishlist->wishlistProducts()->create([
                'product_id' => $id
            ]);
            
            return back()->with('success', 'Product added to wishlist');
        }
        
        return back()->with('info', 'Product already in wishlist');
    }

    // Remove product from wishlist
    public function removeFromWishlist($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $wishlist = Wishlist::where('user_id', Auth::id())->first();
        
        if ($wishlist) {
            $wishlist->wishlistProducts()->where('product_id', $id)->delete();
            return back()->with('success', 'Product removed from wishlist');
        }
        
        return back()->with('error', 'Product not found in wishlist');
    }

    // Add product to cart
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->quantity ?? 1;
        
        if ($product->quantity < $quantity) {
            return back()->with('error', 'Not enough stock available');
        }
        
        if (!Auth::check()) {
            // Handle guest cart in session
            $cart = session()->get('cart', []);
            
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    'product_id' => $id,
                    'product_name' => $product->product_name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'image' => $product->product_image,
                ];
            }
            
            session()->put('cart', $cart);
            return back()->with('success', 'Product added to cart');
        }
        
        // Handle logged in user cart
        $userId = Auth::id();
        $cart = Cart::firstOrCreate([
            'user_id' => $userId,
        ]);
        
        $cartProduct = $cart->cartProducts()->where('product_id', $id)->first();
        
        if ($cartProduct) {
            $cartProduct->update([
                'quantity' => $cartProduct->quantity + $quantity,
            ]);
        } else {
            $cart->cartProducts()->create([
                'product_id' => $id,
                'quantity' => $quantity,
            ]);
        }
        
        return back()->with('success', 'Product added to cart');
    }

    // Submit product review
    public function submitReview(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to submit a review');
        }
        
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'review_date' => now(),
        ]);
        
        return back()->with('success', 'Review submitted successfully');
    }
} 