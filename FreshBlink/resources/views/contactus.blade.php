<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <header class="flex flex-wrap items-center justify-between gap-6 px-6 py-4 border-b bg-white">
    <div class="logo">
      <img src="/images/logo.png" alt="Logo" class="w-40">
    </div>

    <div class="flex flex-1 max-w-md mx-auto items-center">
      <input type="text" placeholder="Search Products...." class="w-full px-4 py-2 border border-gray-300 rounded-l bg-green-50">
      <button class="bg-lime-600 px-3 py-2 rounded-r text-white">
        <img src="/images/icons/search.png" alt="Search" class="w-4 h-4">
      </button>
    </div>

    <div class="flex items-center gap-4 flex-wrap">
      <a href="#" class="flex items-center text-sm text-black gap-1">
        <img src="/images/icons/saved.png" alt="Saved Icon" class="w-4 h-4"> Saved
      </a>
      <a href="#" class="flex items-center text-sm text-black gap-1">
        <img src="/images/icons/cart.png" alt="Cart Icon" class="w-4 h-4"> Cart
      </a>
      <a href="#" class="text-sm">Register</a>
      <button class="bg-lime-600 text-white px-4 py-2 rounded text-sm">Login</button>
    </div>
  </header>

  <!-- Contact Section -->
  <div class="bg-white max-w-5xl mx-auto mt-10 p-8 rounded-lg shadow flex flex-col md:flex-row gap-8">
    <!-- Info -->
    <div class="flex-1 min-w-[250px]">
      <h2 class="text-3xl font-semibold mb-6">Contact Us</h2>
      <p class="flex items-center text-lg mb-4">
        <img src="/images/icons/location.png" alt="Location Icon" class="w-5 mr-3"> Location
      </p>
      <p class="flex items-center text-lg mb-4">
        <img src="/images/icons/emaiil.png" alt="Email Icon" class="w-5 mr-3"> www.freshblink.com
      </p>
      <p class="flex items-center text-lg">
        <img src="/images/icons/phone.png" alt="Phone Icon" class="w-5 mr-3"> Contact
      </p>
    </div>

    <!-- Divider -->
    <div class="hidden md:block w-px bg-gray-300"></div>

    <!-- Form -->
    <form class="flex-1 flex flex-col gap-4">
      <input type="text" placeholder="Your name" required class="px-4 py-3 border border-gray-300 rounded" />
      <input type="email" placeholder="Your Email" required class="px-4 py-3 border border-gray-300 rounded" />
      <input type="text" placeholder="Your Phone Number" class="px-4 py-3 border border-gray-300 rounded" />
      <textarea placeholder="Your message" required class="px-4 py-3 border border-gray-300 rounded min-h-[90px]"></textarea>
      <button type="submit" class="bg-lime-600 text-white py-3 rounded font-semibold hover:bg-lime-700 transition">
        Send Message
      </button>
    </form>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-200 mt-16 px-6 pt-10 pb-4 text-sm text-gray-700">
    <div class="flex flex-col md:flex-row justify-center gap-10 mb-6">
      <div class="footer-logo text-center md:text-left">
        <img src="/images/logo.png" alt="Logo" class="w-28 mb-4 mx-auto md:mx-0">
      </div>

      <div>
        <h3 class="font-semibold mb-3 text-gray-800">Account</h3>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-black">Wishlist</a></li>
          <li><a href="#" class="hover:text-black">Cart</a></li>
          <li><a href="#" class="hover:text-black">Track Order</a></li>
          <li><a href="#" class="hover:text-black">Shipping Details</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold mb-3 text-gray-800">Useful Links</h3>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-black">About Us</a></li>
          <li><a href="#" class="hover:text-black">Contact Us</a></li>
          <li><a href="#" class="hover:text-black">Hot Deals</a></li>
          <li><a href="#" class="hover:text-black">Promotions</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold mb-3 text-gray-800">Help Center</h3>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-black">Payment</a></li>
          <li><a href="#" class="hover:text-black">Refund</a></li>
          <li><a href="#" class="hover:text-black">Checkout</a></li>
          <li><a href="#" class="hover:text-black">Shipping</a></li>
        </ul>
      </div>
    </div>

    <hr class="border-gray-300" />

    <div class="text-center py-4 text-gray-600">
      © 2025 Freshblink
    </div>
  </footer>

</body>
</html>