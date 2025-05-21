<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cart - FreshBlink</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 text-sm sm:text-base">

  @include('components.navbar')

  <!-- Cart Section -->
  <main class="px-4 sm:px-8 mt-6 space-y-6">
    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
      </div>
    @endif

    @if(count($cartItems) > 0)
      <!-- Desktop View -->
      <div class="hidden sm:flex gap-4">
        <!-- Cart Items -->
        <div class="w-2/3 bg-white p-4 rounded-lg shadow overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="p-2">Product</th>
                <th class="p-2 text-center">Price</th>
                <th class="p-2 text-center">Quantity</th>
                <th class="p-2 text-center">Total</th>
                <th class="p-2 text-center">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @foreach($cartItems as $item)
              <tr>
                <td class="p-2 flex items-center gap-3">
                  <img src="{{ asset($item->product->product_image) }}" class="w-12 h-12 border rounded object-cover" />
                  <span>{{ $item->product->product_name }}</span>
                </td>
                <td class="p-2 text-center">${{ number_format($item->product->price, 2) }}</td>
                <td class="p-2 text-center">
                  <form action="{{ route('cart.update') }}" method="POST" class="flex justify-center items-center gap-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="bg-gray-300 px-2 py-1 rounded" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                    <span>{{ $item->quantity }}</span>
                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="bg-gray-300 px-2 py-1 rounded">+</button>
                  </form>
                </td>
                <td class="p-2 text-center">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                <td class="p-2 text-center">
                  <form action="{{ route('cart.remove', $item->product->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Summary -->
        <div class="w-1/3 bg-white p-6 rounded-lg shadow h-fit">
          <h2 class="text-xl font-semibold mb-4">Summary</h2>
          <div class="flex justify-between mb-2">
            <span>Subtotal</span>
            <span>${{ number_format($total, 2) }}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Shipping</span>
            <span>Free</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Discount</span>
            <span>$0</span>
          </div>
          <hr class="my-2" />
          <div class="flex justify-between font-bold text-lg">
            <span>Total</span>
            <span>${{ number_format($total, 2) }}</span>
          </div>
          <a href="{{ route('paypal.payment') }}" class="block w-full mt-4 bg-green-600 text-white py-2 rounded hover:bg-green-700 text-center">Proceed to Checkout with PayPal</a>
        </div>
      </div>

      <!-- Mobile View -->
      <div class="sm:hidden space-y-4">
        <h2 class="text-lg font-semibold">Your Cart</h2>

        <div class="grid grid-cols-5 bg-gray-200 text-center py-2 font-semibold text-xs rounded">
          <span class="col-span-2">Product</span>
          <span>Qty</span>
          <span>Total</span>
          <span>Act</span>
        </div>

        @foreach($cartItems as $item)
        <div class="bg-white p-3 rounded-lg shadow grid grid-cols-5 items-center text-center text-xs">
          <div class="col-span-2 flex items-center gap-2">
            <img src="{{ asset($item->product->product_image) }}" class="w-10 h-10 border rounded object-cover" />
            <span class="text-left">{{ $item->product->product_name }}</span>
          </div>
          <div>
            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center justify-center gap-1">
              @csrf
              <input type="hidden" name="product_id" value="{{ $item->product->id }}">
              <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="bg-gray-300 px-2 py-1 rounded" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
              <span>{{ $item->quantity }}</span>
              <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="bg-gray-300 px-2 py-1 rounded">+</button>
            </form>
          </div>
          <div>${{ number_format($item->product->price * $item->quantity, 2) }}</div>
          <div>
            <form action="{{ route('cart.remove', $item->product->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
            </form>
          </div>
        </div>
        @endforeach

        <!-- Summary -->
        <div class="bg-white p-4 rounded-lg shadow space-y-2 mt-4">
          <h3 class="text-base font-semibold">Summary</h3>
          <div class="flex justify-between"></div>
            <span>Subtotal</span>
            <span>${{ number_format($total, 2) }}</span>
          </div>
          <div class="flex justify-between">
            <span>Shipping</span>
            <span>Free</span>
          </div>
          <div class="flex justify-between">
            <span>Discount</span>
            <span>$0</span>
          </div>
          <hr />
          <div class="flex justify-between font-bold text-base">
            <span>Total</span>
            <span>${{ number_format($total, 2) }}</span>
          </div>
          <a href="{{ route('paypal.payment') }}" class="block w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 mt-2 text-center">Checkout with PayPal</a>
        </div>
      </div>
    @else
      <div class="bg-white p-8 rounded-lg shadow text-center">
        <h2 class="text-2xl font-semibold mb-4">Your cart is empty</h2>
        <p class="text-gray-600 mb-6">Add some products to your cart to continue shopping.</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
          Continue Shopping
        </a>
      </div>
    @endif
  </main>

  @include('components.footer')

</body>
</html>
