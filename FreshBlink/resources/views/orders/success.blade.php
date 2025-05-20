<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - FreshBlink</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <div class="text-center">
                <div class="text-green-500 text-6xl mb-4">
                    <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Order Placed Successfully!</h2>
                <p class="text-gray-600 mb-6">Your order #{{ $order->id }} has been placed successfully.</p>
                
                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold mb-2">Order Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span>${{ number_format($order->total_order + $order->points_discount, 2) }}</span>
                        </div>
                        @if($order->points_discount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Loyalty Points Discount:</span>
                            <span>-${{ number_format($order->points_discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between font-semibold">
                            <span>Total:</span>
                            <span>${{ number_format($order->total_order, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Collection Details -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold mb-2">Collection Details</h3>
                    <p class="text-gray-600">Date: {{ $order->collectionSlot->slot_date->format('Y-m-d') }}</p>
                    <p class="text-gray-600">Time: {{ $order->collectionSlot->time_details->format('H:i') }}</p>
                </div>
                
                <!-- Loyalty Points -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Loyalty Points Update</h3>
                    @if($order->points_discount > 0)
                    <p class="text-blue-600">You used {{ ceil($order->points_discount * 100) }} points for a discount of ${{ number_format($order->points_discount, 2) }}</p>
                    @endif
                    <p class="text-blue-600">You earned {{ floor($order->total_order) }} new points from this purchase!</p>
                    <p class="text-blue-600">Current Balance: {{ Auth::user()->customer->loyalty_points }} points</p>
                </div>
                
                <div class="space-y-4">
                    <a href="{{ route('orders.show', $order->id) }}" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                        View Order Details
                    </a>
                    <a href="{{ route('products.index') }}" class="block w-full bg-gray-200 text-gray-800 text-center py-2 px-4 rounded-md hover:bg-gray-300 transition duration-200">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 