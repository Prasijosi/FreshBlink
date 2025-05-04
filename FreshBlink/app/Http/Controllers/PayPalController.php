<?php

namespace App\Http\Controllers;

use App\Services\PayPalService;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function createPayment(Request $request)
    {
        try {
            $amount = $request->input('amount', 10.00); // Default amount for testing
            $response = $this->paypalService->createOrder($amount);
            
            if ($response->statusCode == 201) {
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect($link->href);
                    }
                }
            }
            
            return redirect()->back()->with('error', 'Something went wrong with PayPal');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        try {
            $orderId = $request->input('token');
            $response = $this->paypalService->captureOrder($orderId);
            
            if ($response->statusCode == 201) {
                // Payment successful, handle your business logic here
                return redirect()->route('payment.success')->with('success', 'Payment successful!');
            }
            
            return redirect()->route('payment.cancel')->with('error', 'Payment failed');
        } catch (\Exception $e) {
            return redirect()->route('payment.cancel')->with('error', $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('payment.cancel')->with('error', 'Payment cancelled');
    }
} 