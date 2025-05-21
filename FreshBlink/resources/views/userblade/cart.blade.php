<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cart Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 text-sm sm:text-base">

  <!-- Navbar -->
  <header class="bg-white shadow">
    <div class="flex flex-wrap items-center justify-between px-4 py-3 border-b border-gray-300">
      <a href="#"><img src="/images/logo.png" alt="FreshBlink Logo" class="w-28 sm:w-40"></a>
      <div class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-2 mt-2 sm:mt-0">
        <div class="flex w-full sm:w-auto">
          <input type="text" placeholder="Search Products..." class="w-full sm:w-64 px-3 py-2 border rounded-l bg-green-50 focus:outline-none" />
          <button class="px-3 py-2 bg-green-600 text-white rounded-r">
            <span class="material-icons">search</span>
          </button>
        </div>
        <div class="flex items-center gap-4 text-sm mt-2 sm:mt-0">
          <a href="#" class="flex items-center hover:text-green-600">
            <span class="material-icons mr-1">favorite_border</span> Saved
          </a>
          <a href="#" class="flex items-center hover:text-green-600">
            <span class="material-icons mr-1">shopping_cart</span> Cart
          </a>
          <a href="#" class="hover:text-green-600">Register</a>
          <button class="bg-green-600 text-white px-4 py-2 rounded">Login</button>
        </div>
      </div>
    </div>
  </header>

  <!-- Cart Section -->
  <main class="px-4 sm:px-8 mt-6 space-y-6">

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
            <tr class="cart-item desktop-item" data-price="15">
              <td class="p-2 flex items-center gap-3">
                <img src="/images/tomato.jpeg" class="w-12 h-12 border rounded" />
                <span>Tomato 1 kg</span>
              </td>
              <td class="p-2 text-center">$15</td>
              <td class="p-2 text-center">
                <div class="flex justify-center items-center gap-2">
                  <button class="bg-gray-300 px-2 py-1 rounded qty-btn">−</button>
                  <span class="item-qty">1</span>
                  <button class="bg-gray-300 px-2 py-1 rounded qty-btn">+</button>
                </div>
              </td>
              <td class="p-2 text-center item-total">$15.00</td>
              <td class="p-2 text-center text-red-600">🗑️</td>
            </tr>
            <tr class="cart-item desktop-item" data-price="20">
              <td class="p-2 flex items-center gap-3">
                <img src="/images/apple.jpg" class="w-12 h-12 border rounded" />
                <span>Apple 2 kg</span>
              </td>
              <td class="p-2 text-center">$20</td>
              <td class="p-2 text-center">
                <div class="flex justify-center items-center gap-2">
                  <button class="bg-gray-300 px-2 py-1 rounded qty-btn">−</button>
                  <span class="item-qty">1</span>
                  <button class="bg-gray-300 px-2 py-1 rounded qty-btn">+</button>
                </div>
              </td>
              <td class="p-2 text-center item-total">$20.00</td>
              <td class="p-2 text-center text-red-600">🗑️</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Summary -->
      <div class="w-1/3 bg-white p-6 rounded-lg shadow h-fit">
        <h2 class="text-xl font-semibold mb-4">Summary</h2>
        <div class="flex justify-between mb-2">
          <span>Subtotal</span><span class="summary-subtotal">$35.00</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Shipping</span><span>Free</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Discount</span><span>$0</span>
        </div>
        <hr class="my-2" />
        <div class="flex justify-between font-bold text-lg">
          <span>Total</span><span class="summary-total">$35.00</span>
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

      <!-- Item 1 -->
      <div class="cart-item mobile-item bg-white p-3 rounded-lg shadow grid grid-cols-5 items-center text-center text-xs" data-price="15">
        <div class="col-span-2 flex items-center gap-2">
          <img src="/images/tomato.jpeg" class="w-10 h-10 border rounded" />
          <span class="text-left">Tomato</span>
        </div>
        <div>
          <div class="flex items-center justify-center gap-1">
            <button class="bg-gray-300 px-2 py-1 rounded qty-btn">−</button>
            <span class="item-qty">1</span>
            <button class="bg-gray-300 px-2 py-1 rounded qty-btn">+</button>
          </div>
        </div>
        <div class="item-total">$15.00</div>
        <div class="text-red-600">🗑️</div>
      </div>

      <!-- Item 2 -->
      <div class="cart-item mobile-item bg-white p-3 rounded-lg shadow grid grid-cols-5 items-center text-center text-xs" data-price="20">
        <div class="col-span-2 flex items-center gap-2">
          <img src="/images/apple.jpg" class="w-10 h-10 border rounded" />
          <span class="text-left">Apple</span>
        </div>
        <div>
          <div class="flex items-center justify-center gap-1">
            <button class="bg-gray-300 px-2 py-1 rounded qty-btn">−</button>
            <span class="item-qty">1</span>
            <button class="bg-gray-300 px-2 py-1 rounded qty-btn">+</button>
          </div>
        </div>
        <div class="item-total">$20.00</div>
        <div class="text-red-600">🗑️</div>
      </div>

      <!-- Summary -->
      <div class="bg-white p-4 rounded-lg shadow space-y-2 mt-4">
        <h3 class="text-base font-semibold">Summary</h3>
        <div class="flex justify-between">
          <span>Subtotal</span><span class="summary-subtotal">$35.00</span>
        </div>
        <div class="flex justify-between">
          <span>Shipping</span><span>Free</span>
        </div>
        <div class="flex justify-between">
          <span>Discount</span><span>$0</span>
        </div>
        <hr />
        <div class="flex justify-between font-bold text-base">
          <span>Total</span><span class="summary-total">$35.00</span>
        </div>
        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 mt-2">Checkout</button>
      </div>
    </div>
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

  <!-- Link to external JS -->
  <script src="/js/cart.js"></script>
</body>
</html>