<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show cart
    public function index()
    {
        $cartItems = [];
        $total = 0;
        
        if (Auth::check()) {
            // Get cart for logged in user
            $cart = Cart::where('user_id', Auth::id())->first();
            
            if ($cart) {
                $cartItems = $cart->cartProducts()->with('product')->get();
                foreach ($cartItems as $item) {
                    $total += $item->product->price * $item->quantity;
                }
            }
        } else {
            // Get cart from session for guest user
            $sessionCart = session()->get('cart', []);
            
            foreach ($sessionCart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    $cartItems[] = (object) [
                        'id' => $id,
                        'product' => $product,
                        'quantity' => $details['quantity']
                    ];
                    $total += $product->price * $details['quantity'];
                }
            }
        }
        
        return view('userblade.cart', compact('cartItems', 'total'));
    }

    // Update cart item quantity
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        // Check product availability
        $product = Product::findOrFail($productId);
        if ($product->quantity < $quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock');
        }
        
        if (Auth::check()) {
            // Update quantity for logged in user
            $cart = Cart::where('user_id', Auth::id())->first();
            
            if ($cart) {
                $cartProduct = $cart->cartProducts()->where('product_id', $productId)->first();
                
                if ($cartProduct) {
                    $cartProduct->update(['quantity' => $quantity]);
                }
            }
        } else {
            // Update quantity in session for guest user
            $cart = session()->get('cart', []);
            
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }
        
        return back()->with('success', 'Cart updated successfully');
    }

    // Remove item from cart
    public function remove($id)
    {
        if (Auth::check()) {
            // Remove item for logged in user
            $cart = Cart::where('user_id', Auth::id())->first();
            
            if ($cart) {
                $cart->cartProducts()->where('product_id', $id)->delete();
            }
        } else {
            // Remove item from session for guest user
            $cart = session()->get('cart', []);
            
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        
        return back()->with('success', 'Item removed from cart');
    }

    // Clear all items from cart
    public function clear()
    {
        if (Auth::check()) {
            // Clear cart for logged in user
            $cart = Cart::where('user_id', Auth::id())->first();
            
            if ($cart) {
                $cart->cartProducts()->delete();
            }
        } else {
            // Clear session cart for guest user
            session()->forget('cart');
        }
        
        return back()->with('success', 'Cart cleared successfully');
    }

    // Transfer session cart to user cart after login
    public function transferSessionCart()
    {
        if (!Auth::check() || !session()->has('cart')) {
            return;
        }
        
        $sessionCart = session()->get('cart', []);
        $userId = Auth::id();
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        
        foreach ($sessionCart as $id => $details) {
            $product = Product::find($id);
            
            if ($product) {
                $cartProduct = $cart->cartProducts()->where('product_id', $id)->first();
                
                if ($cartProduct) {
                    $cartProduct->update([
                        'quantity' => $cartProduct->quantity + $details['quantity']
                    ]);
                } else {
                    $cart->cartProducts()->create([
                        'product_id' => $id,
                        'quantity' => $details['quantity']
                    ]);
                }
            }
        }
        
        // Clear the session cart after transfer
        session()->forget('cart');
    }
} 