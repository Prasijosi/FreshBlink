<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function showPaymentForm()
    {
        return view('payment.paypal');
    }

    public function createPayment(Request $request)
    {
        try {
            // Get cart items and calculate total
            $cartItems = Auth::user()->cart->cartProducts()->with('product')->get();
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Create PayPal order
            $response = $this->paypalService->createOrder($total);

            // Store order ID in session for later use
            session(['paypal_order_id' => $response->result->id]);

            // Find the approval URL from the response
            $approvalUrl = collect($response->result->links)
                ->firstWhere('rel', 'approve')
                ->href;

            return redirect($approvalUrl);
        } catch (\Exception $e) {
            Log::error('PayPal payment creation failed: ' . $e->getMessage());
            return redirect()->route('paypal.cancel')
                ->with('error', 'Failed to create PayPal payment. Please try again.');
        }
    }

    public function success(Request $request)
    {
        try {
            $orderId = session('paypal_order_id');
            if (!$orderId) {
                throw new \Exception('No PayPal order ID found in session');
            }

            // Capture the payment
            $response = $this->paypalService->captureOrder($orderId);

            if ($response->result->status === 'COMPLETED') {
                // Create order in database
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'payment_method' => 'paypal',
                    'total_amount' => $response->result->purchase_units[0]->payments->captures[0]->amount->value,
                    'transaction_pin' => $orderId,
                    'status' => 'paid'
                ]);

                // Clear the cart
                Auth::user()->cart->cartProducts()->delete();

                // Clear PayPal order ID from session
                session()->forget('paypal_order_id');

                return view('payment.success');
            }

            throw new \Exception('Payment not completed');
        } catch (\Exception $e) {
            Log::error('PayPal payment capture failed: ' . $e->getMessage());
            return redirect()->route('paypal.cancel')
                ->with('error', 'Failed to process payment. Please contact support.');
        }
    }

    public function cancel()
    {
        // Clear PayPal order ID from session
        session()->forget('paypal_order_id');
        return view('payment.cancel');
    }
} 