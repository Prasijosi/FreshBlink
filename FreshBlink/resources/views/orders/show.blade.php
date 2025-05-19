<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - FreshBlink</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Order Header -->
                <div class="bg-blue-600 text-white px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-semibold">Order #{{ $order->id }}</h1>
                        <span class="px-3 py-1 rounded-full {{ $order->status === 'pending' ? 'bg-yellow-500' : ($order->status === 'completed' ? 'bg-green-500' : 'bg-red-500') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <p class="text-sm mt-1">Placed on {{ $order->created_at->format('F j, Y g:i A') }}</p>
                </div>

                <!-- Order Details -->
                <div class="p-6">
                    <!-- Products -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                        <div class="space-y-4">
                            @foreach($order->orderProducts as $item)
                            <div class="flex items-center border-b border-gray-200 pb-4">
                                <img src="{{ asset($item->product->product_image) }}" alt="{{ $item->product->product_name }}" class="w-20 h-20 object-cover rounded">
                                <div class="flex-1 ml-4">
                                    <h3 class="text-lg font-medium">{{ $item->product->product_name }}</h3>
                                    <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-gray-600">Price: ${{ number_format($item->price, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-medium">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Collection Details -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-4">Collection Details</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-600">Date: {{ $order->collectionSlot->slot_date->format('F j, Y') }}</p>
                            <p class="text-gray-600">Time: {{ $order->collectionSlot->time_details->format('g:i A') }}</p>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-600">Payment Method: {{ ucfirst($order->payment->payment_method) }}</p>
                            <p class="text-gray-600">Transaction ID: {{ $order->payment->transaction_pin }}</p>
                        </div>
                    </div>

                    <!-- Loyalty Points -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-4">Loyalty Points</h2>
                        <div class="bg-blue-50 rounded-lg p-4">
                            @if($order->points_discount > 0)
                            <p class="text-blue-600">Points Used: {{ ceil($order->points_discount * 100) }} points</p>
                            <p class="text-blue-600">Points Discount: ${{ number_format($order->points_discount, 2) }}</p>
                            @endif
                            <p class="text-blue-600">Points Earned: {{ floor($order->total_order) }} points</p>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
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
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800">
                            ← Back to Orders
                        </a>
                        @if($order->status === 'pending')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Cancel Order
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 