<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Points</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-[#4DAF22] px-6 py-5">
            <h2 class="text-3xl font-semibold text-white">Your Loyalty Points</h2>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-8">
            <!-- Session Alerts -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Points Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg shadow-sm p-6 text-center">
                    <h3 class="text-xl font-medium mb-2">Current Points Balance</h3>
                    <p class="text-4xl font-bold text-[#4DAF22]">{{ number_format($customer->loyalty_points) }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg shadow-sm p-6 text-center">
                    <h3 class="text-xl font-medium mb-2">Available Discount</h3>
                    <p class="text-4xl font-bold text-[#4DAF22]">Rs. {{ number_format($availableDiscount, 2) }}</p>
                </div>
            </div>

            <!-- Redeem Section -->
            @if($customer->loyalty_points >= 500)
                <div class="bg-gray-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-medium mb-4">Redeem Points</h3>
                    <form method="POST" action="{{ route('customer.redeem-points') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="points_to_redeem" class="block text-sm font-medium mb-2">Points to Redeem</label>
                            <input type="number"
                                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4DAF22]"
                                   id="points_to_redeem"
                                   name="points_to_redeem"
                                   min="500"
                                   max="{{ $customer->loyalty_points }}"
                                   step="100"
                                   required>
                            <p class="mt-2 text-sm text-gray-500">Minimum redemption: 500 points — 100 points = Rs. 1 discount</p>
                        </div>
                        <button type="submit"
                                class="w-full bg-[#4DAF22] text-white py-3 rounded-lg font-medium hover:bg-green-600 transition">
                            Apply Points to Next Order
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-gray-50 rounded-lg shadow-sm p-6 text-center">
                    <p>You need at least <strong>500 points</strong> to redeem for a discount.</p>
                    <p class="mt-2">Keep shopping to earn more points!</p>
                </div>
            @endif

            <!-- Points History Table -->
            <div>
                <h3 class="text-xl font-medium mb-4">Points History</h3>
                <div class="rounded-lg shadow-sm">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-[#4DAF22] text-white">
                                <th class="px-4 py-3 text-left text-sm">Order ID</th>
                                <th class="px-4 py-3 text-left text-sm">Date</th>
                                <th class="px-4 py-3 text-left text-sm">Points Earned</th>
                                <th class="px-4 py-3 text-left text-sm">Points Redeemed</th>
                                <th class="px-4 py-3 text-left text-sm">Order Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($customer->user->orders()->latest()->take(5)->get() as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 border-t">{{ $order->order_id }}</td>
                                    <td class="px-4 py-3 border-t">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 border-t text-[#4DAF22] font-medium">+{{ $order->points_earned }}</td>
                                    <td class="px-4 py-3 border-t text-red-600">{{ $order->points_redeemed > 0 ? "-{$order->points_redeemed}" : '-' }}</td>
                                    <td class="px-4 py-3 border-t">Rs. {{ number_format($order->total_order, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- How to Earn Points -->
            <div class="bg-gray-50 rounded-lg shadow-sm p-6">
                <h3 class="text-xl font-medium mb-4">How to Earn Points</h3>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <span class="text-[#4DAF22] mr-3">✔</span>
                        Earn 1 point for every Rs. 10 spent
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#4DAF22] mr-3">✔</span>
                        Points are awarded after order completion
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#4DAF22] mr-3">✔</span>
                        Points expire after 12 months
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#4DAF22] mr-3">✔</span>
                        Minimum redemption: 500 points
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#4DAF22] mr-3">✔</span>
                        100 points = Rs. 1 discount
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>
