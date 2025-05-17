<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>FreshBlink - Payment</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">{{ __('Payment') }}</h2>
            </div>

            <div class="p-6">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('paypal.create') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    
                    <div class="space-y-2">
                        <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Order Total:</span>
                                <span class="font-medium">${{ number_format($order->total_order, 2) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Items:</span>
                                <span class="font-medium">{{ $order->no_of_product }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <h3 class="text-lg font-medium text-gray-900">Payment Method</h3>
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('Image/paypal.webp') }}" alt="PayPal" class="h-8">
                            <span class="text-gray-600">PayPal</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Pay ${{ number_format($order->total_order, 2) }} with PayPal
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 