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
        <h1 class="text-2xl font-bold mb-6">Checkout</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                @foreach($cartItems as $item)
                <div class="flex items-center justify-between py-4 border-b">
                    <div class="flex items-center">
                        <img src="{{ asset($item->product->product_image) }}" alt="{{ $item->product->product_name }}" class="w-16 h-16 object-cover rounded">
                        <div class="ml-4">
                            <h3 class="font-medium">{{ $item->product->product_name }}</h3>
                            <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                    </div>
                </div>
                @endforeach

                <div class="mt-6">
                    <div class="flex justify-between py-2">
                        <span class="font-medium">Subtotal:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium">Total:</span>
                        <span class="text-xl font-bold">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                
                <form action="{{ route('orders.store') }}" method="POST" id="payment-form">
                    @csrf
                    
                    <!-- Collection Slot Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Select Collection Slot</label>
                        <select name="collection_slot_id" class="w-full border rounded-lg px-4 py-2" required>
                            <option value="">Select a time slot</option>
                            <!-- Add your collection slots here -->
                        </select>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Payment Method</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="paypal" id="paypal" class="mr-2" checked>
                                <label for="paypal" class="flex items-center">
                                    <img src="{{ asset('images/paypal-logo.png') }}" alt="PayPal" class="h-6 mr-2">
                                    PayPal
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="credit_card" id="credit_card" class="mr-2">
                                <label for="credit_card">Credit Card</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="cash" id="cash" class="mr-2">
                                <label for="cash">Cash on Collection</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            if (paymentMethod === 'paypal') {
                e.preventDefault();
                window.location.href = "{{ route('paypal.payment') }}";
            }
        });
    </script>
    @endpush
</body>
</html> 