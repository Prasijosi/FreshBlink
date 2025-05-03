<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\CollectionSlot;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\InvoiceEmail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // Display checkout page
    public function checkout()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout');
        }
        
        // Get cart items
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->cartProducts()->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        $cartItems = $cart->cartProducts()->with('product')->get();
        $total = 0;
        
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }
        
        // Get available collection slots
        $collectionSlots = CollectionSlot::where('slot_date', '>=', now()->format('Y-m-d'))
                                         ->orderBy('slot_date')
                                         ->orderBy('time_details')
                                         ->get();
        
        return view('orders.checkout', compact('cartItems', 'total', 'collectionSlots'));
    }

    // Process order
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'collection_slot_id' => 'required|exists:collection_slots,id',
            'payment_method' => 'required|in:credit_card,paypal,cash',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        
        if (!$cart || $cart->cartProducts()->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        $cartItems = $cart->cartProducts()->with('product')->get();
        $total = 0;
        $productCount = 0;
        
        foreach ($cartItems as $item) {
            // Check if enough stock is available
            if ($item->product->quantity < $item->quantity) {
                return back()->with('error', "Not enough stock available for {$item->product->product_name}");
            }
            
            $total += $item->product->price * $item->quantity;
            $productCount += $item->quantity;
        }
        
        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'cart_id' => $cart->id,
            'collection_slot_id' => $request->collection_slot_id,
            'no_of_product' => $productCount,
            'total_order' => $total,
            'status' => 'pending'
        ]);
        
        // Create order products
        foreach ($cartItems as $item) {
            $order->orderProducts()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
            
            // Reduce product quantity
            $product = $item->product;
            $product->quantity -= $item->quantity;
            $product->save();
        }
        
        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $userId,
            'payment_method' => $request->payment_method,
            'transaction_pin' => Str::random(8),
            'total_amount' => $total,
        ]);
        
        // Create invoice
        $invoice = Invoice::create([
            'payment_id' => $payment->id,
            'status' => 'paid',
            'issue_date' => now(),
            'due_date' => now()->addDays(7)
        ]);
        
        // Clear the cart
        $cart->cartProducts()->delete();
        
        // Send invoice email
        Mail::to($order->user->email)->send(new InvoiceEmail($order));
        
        return redirect()->route('orders.success', $order->id)
                         ->with('success', 'Order placed successfully');
    }

    // Order success page
    public function success($id)
    {
        $order = Order::with(['orderProducts.product', 'collectionSlot', 'payment', 'payment.invoice'])
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        
        return view('orders.success', compact('order'));
    }

    // List user orders
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $orders = Order::with(['orderProducts.product', 'collectionSlot'])
                       ->where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    // Show order details
    public function show($id)
    {
        $order = Order::with(['orderProducts.product', 'collectionSlot', 'payment', 'payment.invoice'])
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        
        return view('orders.show', compact('order'));
    }

    // Cancel order
    public function cancel($id)
    {
        $order = Order::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->firstOrFail();
        
        $order->update(['status' => 'cancelled']);
        
        // Return products to inventory
        foreach ($order->orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            if ($product) {
                $product->quantity += $orderProduct->quantity;
                $product->save();
            }
        }
        
        return back()->with('success', 'Order cancelled successfully');
    }
} 