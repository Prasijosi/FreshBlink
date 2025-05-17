<?php

namespace App\Http\Controllers;

use App\Services\PayPalService;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function showPaymentForm(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::findOrFail($orderId);
        
        // Verify that the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')->with('error', 'Unauthorized access');
        }
        
        return view('payment.form', compact('order'));
    }

    public function createPayment(Request $request)
    {
        try {
            // Get the order from the session or request
            $orderId = $request->input('order_id');
            $order = Order::findOrFail($orderId);
            
            // Verify that the order belongs to the authenticated user
            if ($order->user_id !== Auth::id()) {
                return redirect()->route('orders.index')->with('error', 'Unauthorized access');
            }

            // Create PayPal order
            $response = $this->paypalService->createOrder($order->total_order);
            
            if ($response->statusCode == 201) {
                // Store PayPal order ID in the order
                $order->update([
                    'payment_id' => $response->result->id,
                    'payment_method' => 'paypal'
                ]);

                // Find the approval URL
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect($link->href);
                    }
                }
            }
            
            return redirect()->route('paypal.cancel')->with('error', 'Something went wrong with PayPal');
        } catch (\Exception $e) {
            return redirect()->route('paypal.cancel')->with('error', $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        try {
            $orderId = $request->input('token');
            $order = Order::where('payment_id', $orderId)->firstOrFail();
            
            // Verify that the order belongs to the authenticated user
            if ($order->user_id !== Auth::id()) {
                return redirect()->route('orders.index')->with('error', 'Unauthorized access');
            }
            
            // Capture the payment
            $response = $this->paypalService->captureOrder($orderId);
            
            if ($response->statusCode == 201) {
                // Update order status
                $order->update([
                    'status' => 'paid',
                    'is_placed' => true
                ]);

                // Create payment record
                Payment::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'payment_id' => $response->result->id,
                    'payment_method' => 'paypal',
                    'total_amount' => $order->total_order,
                    'transaction_pin' => $response->result->id,
                    'is_made_by' => true
                ]);

                return view('payment.success');
            }
            
            return redirect()->route('paypal.cancel')->with('error', 'Payment failed');
        } catch (\Exception $e) {
            return redirect()->route('paypal.cancel')->with('error', $e->getMessage());
        }
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
} 