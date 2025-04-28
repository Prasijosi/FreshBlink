<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FreshBlink - Home</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Top Navbar -->
  <div class="flex flex-col md:flex-row justify-between items-center px-5 py-3 border-b border-gray-300 bg-white gap-3 md:gap-0">
    <!-- Logo -->
    <div class="w-40">
      <a href="#"><img src="Image/logo2.png" alt="Logo"></a>
    </div>

    <!-- Search Box -->
    <div class="flex w-full md:flex-1 max-w-2xl mx-0 md:mx-5">
      <input type="text" placeholder="Search Products......." class="w-full px-3 py-2 border border-gray-300 border-r-0 bg-green-50 rounded-l">
      <button class="bg-green-600 text-white px-3 py-2 rounded-r">
        <span class="material-icons">search</span>
      </button>
    </div>

    <!-- Nav Actions -->
    <div class="flex flex-wrap justify-center md:justify-end items-center gap-6 md:gap-12 w-full md:w-auto">
      <a href="#" class="text-black text-sm flex items-center gap-1">
        <span class="material-icons">favorite_border</span> Saved
      </a>
      <a href="#" class="text-black text-sm flex items-center gap-1">
        <span class="material-icons">shopping_cart</span> Cart
      </a>
      <a href="#" class="text-black text-sm">Login</a>
      <button class="bg-green-600 text-white px-4 py-2 rounded">Register</button>
    </div>
  </div>

  <!-- Navbar 2 -->
  <nav class=" mb-6 flex items-center justify-between px-8 py-4 bg-white shadow">
    <div class="flex items-center space-x-4">
      <button class="flex items-center bg-green-600 text-white px-4 py-2 rounded">
        <img src="Image/Grid.png" class="h-5 w-5 mr-2" alt="Grid Icon" />
        Browse All Categories
      </button>
      <a href="#" class="flex items-center text-gray-700 hover:text-green-600">
        <img src="Image/icon 1.png" class="h-5 w-5 mr-1" alt="Hot Deals Icon" />
        Hot Deals
      </a>
    </div>
    <div class="flex space-x-6">
      <a href="#" class="text-green-600 font-semibold">Home</a>
      <a href="#" class="text-gray-700 hover:text-green-600">Shop</a>
      <a href="#" class="text-gray-700 hover:text-green-600">About</a>
      <a href="#" class="text-gray-700 hover:text-green-600">Blog</a>
      <a href="#" class="text-gray-700 hover:text-green-600">Contact</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-green-100 py-10 px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 items-center gap-6">
      <div>
        <p class="text-sm text-red-600 font-bold">100% Organic</p>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
          Start Shopping At<br />Our Store
        </h1>
        <p class="text-gray-600 mt-2">Save up to 50% off on your first order</p>
      </div>
      <div class="flex items-center justify-center">
        <img src="Image/2.png" alt="Organic Foods" class="w-full max-w-xl rounded" />
      </div>
    </div>
  </section>
<br>
  <!-- Promo Banners -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto mb-12">
    <div class="bg-blue-100 p-6 rounded-xl flex flex-col justify-between h-full">
      <h2 class="text-xl font-semibold mb-4">The best Organic <br />Product Online</h2>
      <button class="bg-orange-500 text-white px-4 py-2 rounded-full w-max">Shop Now</button>
      <img src="Image/greenvegie.png" alt="Organic Veggies" class="mt-4">
    </div>
    <div class="bg-yellow-100 p-6 rounded-xl flex flex-col justify-between h-full">
      <h2 class="text-xl font-semibold mb-4">Everyday Fresh & <br />Clean Product</h2>
      <button class="bg-orange-500 text-white px-4 py-2 rounded-full w-max">Shop Now</button>
      <img src="Image/ginger.png" alt="Ginger" class="mt-4">
    </div>
    <div class="bg-pink-100 p-6 rounded-xl flex flex-col justify-between h-full">
      <h2 class="text-xl font-semibold mb-4">Make your Breakfast <br />Healthy and Easy</h2>
      <button class="bg-orange-500 text-white px-4 py-2 rounded-full w-max">Shop Now</button>
      <img src="Image/cake.png" alt="Cake Slice" class="mt-4">
    </div>
  </div>

  <!-- Featured Categories -->
  <div class="max-w-7xl mx-auto">
    <h3 class="text-2xl font-bold mb-6">Featured Categories</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
      <div class="bg-yellow-100 p-4 rounded-xl text-center">
        <img src="Image/bakery.png" class="mx-auto h-16 mb-2" alt="Bakery">
        <div class="text-lg font-bold">Bakery</div>
      </div>
      <div class="bg-rose-200 p-4 rounded-xl text-center">
        <img src="Image/butchery.png" class="mx-auto h-16 mb-2" alt="Butchery">
        <div class="text-lg font-bold">Butchery</div>
      </div>
      <div class="bg-lime-100 p-4 rounded-xl text-center">
        <img src="Image/greengrocer.png" class="mx-auto h-16 mb-2" alt="Greengrocer">
        <div class="text-lg font-bold">Greengrocer</div>
      </div>
      <div class="bg-amber-100 p-4 rounded-xl text-center">
        <img src="Image/delicatessen.png" class="mx-auto h-16 mb-2" alt="Delicatessen">
        <div class="text-lg font-bold">Delicatessen</div>
      </div>
      <div class="bg-blue-100 p-4 rounded-xl text-center">
        <img src="Image/fishmonger.png" class="mx-auto h-16 mb-2" alt="Fishmonger">
        <div class="text-lg font-bold">Fishmonger</div>
      </div>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer class="bg-gray-300 pt-10 px-5 mt-16">
    <div class="flex flex-wrap justify-center lg:justify-around gap-6 mb-5">
      <div class="text-center lg:text-left">
        <img src="Image/logo2.png" alt="FreshBlink Logo" class="w-36 mx-auto lg:mx-0">
      </div>

      <div class="min-w-[150px]">
        <h3 class="text-lg mb-2">Account</h3>
        <ul class="text-sm text-gray-800 space-y-2">
          <li><a href="#">Wishlist</a></li>
          <li><a href="#">Cart</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">Shipping Details</a></li>
        </ul>
      </div>

      <div class="min-w-[150px]">
        <h3 class="text-lg mb-2">Useful Links</h3>
        <ul class="text-sm text-gray-800 space-y-2">
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Hot Deals</a></li>
          <li><a href="#">Promotions</a></li>
          <li><a href="#">New Product</a></li>
        </ul>
      </div>

      <div class="min-w-[150px]">
        <h3 class="text-lg mb-2">Help Center</h3>
        <ul class="text-sm text-gray-800 space-y-2">
          <li><a href="#">Payment</a></li>
          <li><a href="#">Refund</a></li>
          <li><a href="#">Checkout</a></li>
          <li><a href="#">Q&amp;A</a></li>
          <li><a href="#">Shipping</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
    </div>

    <hr class="border-t border-gray-600 my-5">
    <div class="text-center text-sm text-gray-800 mb-3">
      <p>&copy; 2022, All rights reserved</p>
    </div>
    <div class="text-center">
      <img src="Image/paypal.webp" alt="PayPal" class="w-28 mx-auto">
    </div>
  </footer>

</body>
</html>
