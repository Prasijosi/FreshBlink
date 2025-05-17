<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Illuminate\Support\Facades\Config;

class PayPalService
{
    protected $client;

    public function __construct()
    {
        $mode = Config::get('paypal.mode');
        
        if ($mode === 'sandbox') {
            $environment = new SandboxEnvironment(
                Config::get('paypal.sandbox.client_id'),
                Config::get('paypal.sandbox.client_secret')
            );
        } else {
            $environment = new ProductionEnvironment(
                Config::get('paypal.live.client_id'),
                Config::get('paypal.live.client_secret')
            );
        }

        $this->client = new PayPalHttpClient($environment);
    }

    public function createOrder($amount, $currency = 'USD')
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currency,
                    'value' => number_format($amount, 2, '.', '')
                ],
                'description' => 'FreshBlink Order Payment'
            ]],
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
                'brand_name' => 'FreshBlink',
                'landing_page' => 'NO_PREFERENCE',
                'user_action' => 'PAY_NOW',
                'shipping_preference' => 'NO_SHIPPING'
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
} 