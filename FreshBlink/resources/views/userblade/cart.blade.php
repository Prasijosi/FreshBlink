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

  @include('components.navbar')

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
            <tr>
              <td class="p-2 flex items-center gap-3">
                <img src="images/tomato.jpeg" class="w-12 h-12 border rounded" />
                <span>Tomato 1 kg</span>
              </td>
              <td class="p-2 text-center">$15</td>
              <td class="p-2 text-center">
                <div class="flex justify-center items-center gap-2">
                  <button class="bg-gray-300 px-2 py-1 rounded">-</button>
                  <span>1</span>
                  <button class="bg-gray-300 px-2 py-1 rounded">+</button>
                </div>
              </td>
              <td class="p-2 text-center">$15</td>
              <td class="p-2 text-center text-red-600">🗑️</td>
            </tr>
            <tr>
              <td class="p-2 flex items-center gap-3">
                <img src="images/apple.jpg" class="w-12 h-12 border rounded" />
                <span>Apple 2 kg</span>
              </td>
              <td class="p-2 text-center">$20</td>
              <td class="p-2 text-center">
                <div class="flex justify-center items-center gap-2">
                  <button class="bg-gray-300 px-2 py-1 rounded">-</button>
                  <span>1</span>
                  <button class="bg-gray-300 px-2 py-1 rounded">+</button>
                </div>
              </td>
              <td class="p-2 text-center">$20</td>
              <td class="p-2 text-center text-red-600">🗑️</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Summary -->
      <div class="w-1/3 bg-white p-6 rounded-lg shadow h-fit">
        <h2 class="text-xl font-semibold mb-4">Summary</h2>
        <div class="flex justify-between mb-2">
          <span>Subtotal</span><span>$35</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Shipping</span><span>Free</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Discount</span><span>$0</span>
        </div>
        <hr class="my-2" />
        <div class="flex justify-between font-bold text-lg">
          <span>Total</span><span>$35</span>
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
      <div class="bg-white p-3 rounded-lg shadow grid grid-cols-5 items-center text-center text-xs">
        <div class="col-span-2 flex items-center gap-2">
          <img src="images/tomato.jpeg" class="w-10 h-10 border rounded" />
          <span class="text-left">Tomato</span>
        </div>
        <div>
          <div class="flex items-center justify-center gap-1">
            <button class="bg-gray-300 px-2 py-1 rounded">-</button>
            <span>1</span>
            <button class="bg-gray-300 px-2 py-1 rounded">+</button>
          </div>
        </div>
        <div>$15</div>
        <div class="text-red-600">🗑️</div>
      </div>

      <!-- Item 2 -->
      <div class="bg-white p-3 rounded-lg shadow grid grid-cols-5 items-center text-center text-xs">
        <div class="col-span-2 flex items-center gap-2">
          <img src="images/apple.jpg" class="w-10 h-10 border rounded" />
          <span class="text-left">Apple</span>
        </div>
        <div>
          <div class="flex items-center justify-center gap-1">
            <button class="bg-gray-300 px-2 py-1 rounded">-</button>
            <span>1</span>
            <button class="bg-gray-300 px-2 py-1 rounded">+</button>
          </div>
        </div>
        <div>$20</div>
        <div class="text-red-600">🗑️</div>
      </div>

      <!-- Summary -->
      <div class="bg-white p-4 rounded-lg shadow space-y-2 mt-4">
        <h3 class="text-base font-semibold">Summary</h3>
        <div class="flex justify-between">
          <span>Subtotal</span><span>$35</span>
        </div>
        <div class="flex justify-between">
          <span>Shipping</span><span>Free</span>
        </div>
        <div class="flex justify-between">
          <span>Discount</span><span>$0</span>
        </div>
        <hr />
        <div class="flex justify-between font-bold text-base">
          <span>Total</span><span>$35</span>
        </div>
        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 mt-2">Checkout</button>
      </div>
    </div>
  </main>

  @include('components.footer')

</body>
</html>
