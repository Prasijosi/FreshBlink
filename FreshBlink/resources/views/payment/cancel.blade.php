<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled - FreshBlink</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <div class="text-center">
                <div class="text-red-500 text-6xl mb-4">
                    <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Payment Cancelled</h2>
                <p class="text-gray-600 mb-6">Your payment was cancelled. No charges were made.</p>
                <div class="space-y-4">
                    <a href="{{ route('cart.index') }}" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                        Return to Cart
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