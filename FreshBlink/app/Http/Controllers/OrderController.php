<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;

class OrderController extends Controller
{
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

        // Apply loyalty points discount if available
        $pointsDiscount = 0;
        $pointsRedeemed = 0;
        if (session()->has('loyalty_discount')) {
            $loyaltyDiscount = session('loyalty_discount');
            $pointsDiscount = $loyaltyDiscount['discount_amount'];
            $pointsRedeemed = $loyaltyDiscount['points_redeemed'];
            $total = max(0, $total - $pointsDiscount);
        }
        
        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'cart_id' => $cart->id,
                'collection_slot_id' => $request->collection_slot_id,
                'no_of_product' => $productCount,
                'total_order' => $total,
                'points_discount' => $pointsDiscount,
                'points_redeemed' => $pointsRedeemed,
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

            // Process loyalty points
            if ($pointsRedeemed > 0) {
                app(CustomerController::class)->processPointsRedemption($order);
            }

            // Award new loyalty points
            $pointsEarned = app(CustomerController::class)->awardPoints($order);
            $order->update(['points_earned' => $pointsEarned]);
            
            // Clear the cart
            $cart->cartProducts()->delete();
            
            DB::commit();

            // Send invoice email
            Mail::to($order->user->email)->send(new InvoiceEmail($order));
            
            return redirect()->route('orders.success', $order->id)
                             ->with('success', 'Order placed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order processing failed. Please try again.');
        }
    }
} 