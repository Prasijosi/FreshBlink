<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    // Display the user's wishlists
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view wishlists');
        }
        
        $wishlists = Wishlist::with('wishlistProducts.product')
                              ->where('user_id', Auth::id())
                              ->get();
        
        return view('wishlists.index', compact('wishlists'));
    }

    // Show a specific wishlist
    public function show($id)
    {
        $wishlist = Wishlist::with('wishlistProducts.product')
                            ->where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        return view('wishlists.show', compact('wishlist'));
    }

    // Show create wishlist form
    public function create()
    {
        return view('wishlists.create');
    }

    // Store a new wishlist
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'wishlist_name' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $wishlist = Wishlist::create([
            'user_id' => Auth::id(),
            'wishlist_name' => $request->wishlist_name,
            'created_on' => now(),
            'updated_on' => now(),
        ]);
        
        return redirect()->route('wishlists.show', $wishlist->id)
                         ->with('success', 'Wishlist created successfully');
    }

    // Show edit wishlist form
    public function edit($id)
    {
        $wishlist = Wishlist::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        return view('wishlists.edit', compact('wishlist'));
    }

    // Update wishlist
    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'wishlist_name' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $wishlist->update([
            'wishlist_name' => $request->wishlist_name,
            'updated_on' => now(),
        ]);
        
        return redirect()->route('wishlists.show', $wishlist->id)
                         ->with('success', 'Wishlist updated successfully');
    }

    // Delete wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        // Delete associated wishlist products
        $wishlist->wishlistProducts()->delete();
        $wishlist->delete();
        
        return redirect()->route('wishlists.index')
                         ->with('success', 'Wishlist deleted successfully');
    }

    // Add product to wishlist
    public function addProduct(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'wishlist_id' => 'required|integer|exists:wishlists,id',
            'product_id' => 'required|integer|exists:products,id',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $wishlist = Wishlist::where('id', $request->wishlist_id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        // Check if product already exists in the wishlist
        $exists = $wishlist->wishlistProducts()
                           ->where('product_id', $request->product_id)
                           ->exists();
        
        if (!$exists) {
            $wishlist->wishlistProducts()->create([
                'product_id' => $request->product_id,
            ]);
            
            $wishlist->update(['updated_on' => now()]);
            
            return back()->with('success', 'Product added to wishlist successfully');
        }
        
        return back()->with('info', 'Product already exists in wishlist');
    }

    // Remove product from wishlist
    public function removeProduct($wishlistId, $productId)
    {
        $wishlist = Wishlist::where('id', $wishlistId)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        $wishlist->wishlistProducts()
                 ->where('product_id', $productId)
                 ->delete();
        
        $wishlist->update(['updated_on' => now()]);
        
        return back()->with('success', 'Product removed from wishlist');
    }

    // Move product to another wishlist
    public function moveProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_wishlist_id' => 'required|integer|exists:wishlists,id',
            'target_wishlist_id' => 'required|integer|exists:wishlists,id|different:source_wishlist_id',
            'product_id' => 'required|integer|exists:products,id',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $sourceWishlist = Wishlist::where('id', $request->source_wishlist_id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();
        
        $targetWishlist = Wishlist::where('id', $request->target_wishlist_id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();
        
        // Check if product exists in source wishlist
        $sourceProduct = $sourceWishlist->wishlistProducts()
                                        ->where('product_id', $request->product_id)
                                        ->first();
        
        if (!$sourceProduct) {
            return back()->with('error', 'Product not found in source wishlist');
        }
        
        // Check if product already exists in target wishlist
        $exists = $targetWishlist->wishlistProducts()
                                 ->where('product_id', $request->product_id)
                                 ->exists();
        
        if (!$exists) {
            // Add to target wishlist
            $targetWishlist->wishlistProducts()->create([
                'product_id' => $request->product_id,
            ]);
            
            // Remove from source wishlist
            $sourceProduct->delete();
            
            // Update timestamps
            $sourceWishlist->update(['updated_on' => now()]);
            $targetWishlist->update(['updated_on' => now()]);
            
            return back()->with('success', 'Product moved to another wishlist');
        }
        
        // If product already exists in target, just remove from source
        $sourceProduct->delete();
        $sourceWishlist->update(['updated_on' => now()]);
        
        return back()->with('info', 'Product already exists in target wishlist. Removed from source wishlist.');
    }
} 