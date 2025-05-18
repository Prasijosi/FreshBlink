<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FreshBlink</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap -mx-4">
            <!-- Order Summary -->
            <div class="w-full lg:w-8/12 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-semibold mb-4">Order Summary</h2>
                    
                    @foreach($cartItems as $item)
                    <div class="flex items-center border-b border-gray-200 py-4">
                        <img src="{{ asset($item->product->product_image) }}" alt="{{ $item->product->product_name }}" class="w-20 h-20 object-cover rounded">
                        <div class="flex-1 ml-4">
                            <h3 class="text-lg font-medium">{{ $item->product->product_name }}</h3>
                            <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                            <p class="text-gray-600">Price: ${{ number_format($item->product->price, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-medium">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="mt-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ number_format($total, 2) }}</span>
                        </div>
                        
                        @if(Auth::user()->customer->loyalty_points > 0)
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Available Loyalty Points</span>
                            <span class="font-medium">{{ Auth::user()->customer->loyalty_points }} points</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Maximum Discount (30%)</span>
                            <span class="font-medium">${{ number_format($total * 0.3, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Checkout Form -->
            <div class="w-full lg:w-4/12 px-4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-semibold mb-4">Payment Details</h2>
                    
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        
                        <!-- Collection Slot -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="collection_slot_id">
                                Collection Slot
                            </label>
                            <select name="collection_slot_id" id="collection_slot_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Select a collection slot</option>
                                @foreach($collectionSlots as $slot)
                                <option value="{{ $slot->id }}">
                                    {{ $slot->slot_date->format('Y-m-d') }} at {{ $slot->time_details->format('H:i') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Payment Method
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="credit_card" class="mr-2" required>
                                    <span>Credit Card</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="paypal" class="mr-2">
                                    <span>PayPal</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="cash" class="mr-2">
                                    <span>Cash</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Loyalty Points -->
                        @if(Auth::user()->customer->loyalty_points > 0)
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="use_loyalty_points" value="1" class="mr-2">
                                <span>Use Loyalty Points for Discount</span>
                            </label>
                            <p class="text-sm text-gray-600 mt-1">
                                You have {{ Auth::user()->customer->loyalty_points }} points available.
                                Each point is worth $0.01 in discount (max 30% of order total).
                            </p>
                        </div>
                        @endif
                        
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 