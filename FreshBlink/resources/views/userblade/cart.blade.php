<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cart Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 text-sm sm:text-base">

  <!-- Navbar -->
  @guest
  {{-- Show this if the user is NOT logged in --}}
  @include('components.navbar')
  @endguest

  @auth
  {{-- Show this if the user IS logged in --}}
  @include('userblade.loggedin')
  @endauth

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
                <tr class="cart-item desktop-item" data-product-id="{{ $item->id }}" data-price="{{ $item->product->price }}">
              <td class="p-2 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 border rounded" />
                    <span>{{ $item->product->name }}</span>
              </td>
                  <td class="p-2 text-center">${{ number_format($item->product->price, 2) }}</td>
              <td class="p-2 text-center">
                <div class="flex justify-center items-center gap-2">
                      <button class="bg-gray-300 px-2 py-1 rounded qty-btn" data-action="decrease">−</button>
                      <span class="item-qty">{{ $item->quantity }}</span>
                      <button class="bg-gray-300 px-2 py-1 rounded qty-btn" data-action="increase">+</button>
                </div>
              </td>
                  <td class="p-2 text-center item-total">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
              <td class="p-2 text-center">
                    <button class="text-red-600 remove-item" data-product-id="{{ $item->id }}">🗑️</button>
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
            <span>Subtotal</span><span class="summary-subtotal">${{ number_format($total, 2) }}</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Shipping</span><span>Free</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Discount</span><span>$0</span>
        </div>
        <hr class="my-2" />
        <div class="flex justify-between font-bold text-lg">
            <span>Total</span><span class="summary-total">${{ number_format($total, 2) }}</span>
        </div>
        <button class="w-full mt-4 bg-green-600 text-white py-2 rounded hover:bg-green-700">Proceed to Checkout</button>
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
          <div class="cart-item mobile-item bg-white p-3 rounded-lg shadow grid grid-cols-5 items-center text-center text-xs" data-product-id="{{ $item->id }}" data-price="{{ $item->product->price }}">
        <div class="col-span-2 flex items-center gap-2">
              <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 border rounded" />
              <span class="text-left">{{ $item->product->name }}</span>
        </div>
        <div>
          <div class="flex items-center justify-center gap-1">
                <button class="bg-gray-300 px-2 py-1 rounded qty-btn" data-action="decrease">−</button>
                <span class="item-qty">{{ $item->quantity }}</span>
                <button class="bg-gray-300 px-2 py-1 rounded qty-btn" data-action="increase">+</button>
          </div>
        </div>
            <div class="item-total">${{ number_format($item->product->price * $item->quantity, 2) }}</div>
            <div>
              <button class="text-red-600 remove-item" data-product-id="{{ $item->id }}">🗑️</button>
        </div>
          </div>
        @endforeach

      <!-- Summary -->
      <div class="bg-white p-4 rounded-lg shadow space-y-2 mt-4">
        <h3 class="text-base font-semibold">Summary</h3>
        <div class="flex justify-between">
            <span>Subtotal</span><span class="summary-subtotal">${{ number_format($total, 2) }}</span>
        </div>
        <div class="flex justify-between">
          <span>Shipping</span><span>Free</span>
        </div>
        <div class="flex justify-between">
          <span>Discount</span><span>$0</span>
        </div>
        <hr />
        <div class="flex justify-between font-bold text-base">
            <span>Total</span><span class="summary-total">${{ number_format($total, 2) }}</span>
          </div>
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

  <!-- Footer -->
  <footer class="bg-white mt-10 p-4 sm:p-6 shadow">
    <div class="max-w-screen-xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-sm text-gray-700">
      <div class="flex justify-center sm:justify-start">
        <div class="w-28 h-16 sm:w-32 sm:h-20 bg-gray-200 flex items-center justify-center">Image</div>
      </div>
      <div>
        <h4 class="font-semibold mb-2">Account</h4>
        <ul class="space-y-1 text-blue-500">
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-2">Useful Links</h4>
        <ul class="space-y-1 text-blue-500">
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-2">Help Center</h4>
        <ul class="space-y-1 text-blue-500">
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
        </ul>
      </div>
    </div>
    <div class="flex flex-wrap justify-between items-center text-xs text-gray-500 mt-6 border-t pt-4">
      <span>©️ 2025 Company Name</span>
      <div class="space-x-4 text-lg text-gray-600">
        <a href="#"><i class="fab fa-facebook-f hover:text-blue-600"></i></a>
        <a href="#"><i class="fab fa-linkedin-in hover:text-blue-500"></i></a>
        <a href="#"><i class="fab fa-instagram hover:text-pink-500"></i></a>
        <a href="#"><i class="fab fa-twitter hover:text-blue-400"></i></a>
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      
      // Function to update cart item quantity
      async function updateQuantity(productId, quantity) {
        try {
          const response = await fetch(`/cart/update`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
              product_id: productId,
              quantity: quantity
            })
          });

          const data = await response.json();
          
          if (response.ok) {
            // Update the UI
            const item = document.querySelector(`[data-product-id="${productId}"]`);
            const price = parseFloat(item.dataset.price);
            const qtyElement = item.querySelector('.item-qty');
            const totalElement = item.querySelector('.item-total');
            
            qtyElement.textContent = quantity;
            totalElement.textContent = `$${(price * quantity).toFixed(2)}`;
            
            // Update summary
            updateSummary();
          } else {
            alert(data.message || 'Error updating cart');
          }
        } catch (error) {
          console.error('Error:', error);
          alert('Error updating cart');
        }
      }

      // Function to remove cart item
      async function removeItem(productId) {
        if (!confirm('Are you sure you want to remove this item?')) return;

        try {
          const response = await fetch(`/cart/remove/${productId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken
            }
          });

          if (response.ok) {
            const item = document.querySelector(`[data-product-id="${productId}"]`);
            item.remove();
            updateSummary();
            
            // If no items left, show empty cart message
            if (document.querySelectorAll('.cart-item').length === 0) {
              location.reload();
            }
          } else {
            alert('Error removing item');
          }
        } catch (error) {
          console.error('Error:', error);
          alert('Error removing item');
        }
      }

      // Function to update summary totals
      function updateSummary() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
          const price = parseFloat(item.dataset.price);
          const quantity = parseInt(item.querySelector('.item-qty').textContent);
          subtotal += price * quantity;
        });

        document.querySelectorAll('.summary-subtotal').forEach(el => {
          el.textContent = `$${subtotal.toFixed(2)}`;
        });
        document.querySelectorAll('.summary-total').forEach(el => {
          el.textContent = `$${subtotal.toFixed(2)}`;
        });
      }

      // Event listeners for quantity buttons
      document.querySelectorAll('.qty-btn').forEach(button => {
        button.addEventListener('click', function() {
          const item = this.closest('.cart-item');
          const productId = item.dataset.productId;
          const qtyElement = item.querySelector('.item-qty');
          let quantity = parseInt(qtyElement.textContent);

          if (this.dataset.action === 'increase') {
            quantity++;
          } else if (this.dataset.action === 'decrease' && quantity > 1) {
            quantity--;
          }

          updateQuantity(productId, quantity);
        });
      });

      // Event listeners for remove buttons
      document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
          const productId = this.dataset.productId;
          removeItem(productId);
        });
      });
    });
  </script>
</body>

</html>