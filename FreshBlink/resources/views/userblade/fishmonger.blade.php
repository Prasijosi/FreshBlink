<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Traders Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>

<body class="font-sans bg-gray-100">

  <!-- Navbar -->
  @guest
  {{-- Show this if the user is NOT logged in --}}
  @include('components.navbar')
  @endguest

  @auth
  {{-- Show this if the user IS logged in --}}
  @include('userblade.loggedin')
  @endauth


  <!-- Category Menu -->
  <div class="bg-white py-3 flex justify-center gap-4 sm:gap-8 border-b border-gray-300 flex-wrap text-sm sm:text-base font-semibold">
    <a href="#">Bakery</a>
    <a href="#">Butchery</a>
    <a href="#">Greengrocer</a>
    <a href="#">Delicatessen</a>
    <a href="#">Fishmonger</a>
  </div>

  <!-- Page Title -->
  <h1 class="text-center my-8 text-3xl font-semibold underline">Fishmonger</h1>

  <!-- PRODUCT GRID (shown on md+) -->
  <div id="grid" class="hidden md:grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 px-6 sm:px-12 pb-8 max-w-6xl mx-auto"></div>

  <!-- PRODUCT SLIDER (shown below md) -->
  <div class="relative block md:hidden px-4 pb-8">
    <div id="slider" class="overflow-hidden">
      <div id="slides" class="flex transition-transform duration-300"></div>
    </div>
    <button id="prevBtn" class="absolute top-1/2 left-3 -translate-y-1/2 bg-green-600 p-2 rounded-full shadow">&#8592;</button>
    <button id="nextBtn" class="absolute top-1/2 right-3 -translate-y-1/2 bg-green-600 p-2 rounded-full shadow"> &#8594;</button>
  </div>

  <!-- ========== FOOTER ========== -->
  <footer class="bg-white mt-12 px-6 pt-10 pb-6 text-sm text-gray-700 border-t">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-y-8 gap-x-4 max-w-screen-xl mx-auto">
      <div>
        <img src="/images/logo.png" alt="FreshBlink Logo" class="w-32 mb-4" />
      </div>

      <div>
        <h3 class="font-bold mb-2">Account</h3>
        <ul class="space-y-1">
          <li><a href="#" class="hover:text-green-600">Wishlist</a></li>
          <li><a href="#" class="hover:text-green-600">Cart</a></li>
          <li><a href="#" class="hover:text-green-600">Track Order</a></li>
          <li><a href="#" class="hover:text-green-600">Shipping Details</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-bold mb-2">Useful links</h3>
        <ul class="space-y-1">
          <li><a href="#" class="hover:text-green-600">About Us</a></li>
          <li><a href="#" class="hover:text-green-600">Contact us</a></li>
          <li><a href="#" class="hover:text-green-600">Hot Deals</a></li>
          <li><a href="#" class="hover:text-green-600">Promotions</a></li>
          <li><a href="#" class="hover:text-green-600">New product</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-bold mb-2">Help Center</h3>
        <ul class="space-y-1">
          <li><a href="#" class="hover:text-green-600">Payment</a></li>
          <li><a href="#" class="hover:text-green-600">Refund</a></li>
          <li><a href="#" class="hover:text-green-600">Checkout</a></li>
          <li><a href="#" class="hover:text-green-600">Q&amp;A</a></li>
          <li><a href="#" class="hover:text-green-600">Shipping</a></li>
        </ul>
      </div>
    </div>

    <hr class="my-6" />

    <div class="flex flex-col sm:flex-row justify-between items-center max-w-screen-xl mx-auto">
      <p class="text-xs text-gray-500 mb-2 sm:mb-0">&copy; 2022, All rights reserved</p>
      <img src="/images/paypal.webp" alt="PayPal" class="w-24" />
    </div>
  </footer>

  <script src="traders.js"></script>
</body>

</html>