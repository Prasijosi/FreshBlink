<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FreshBlink - Login</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
   <!-- Top Navbar -->
   <div class="flex flex-col md:flex-row justify-between items-center px-5 py-3 border-b border-gray-300 bg-white gap-3 md:gap-0">
    <!-- Logo -->
    <div class="w-40">
      <a href=""><img src="/images/logo2.png" alt="Logo"></a>
    </div>

    <!-- Search Box -->
    <div class="flex w-full md:flex-1 max-w-2xl mx-0 md:mx-5">
      <input type="text" placeholder="Search Products......." class="w-full px-3 py-2 border border-gray-300 border-r-0 bg-green-50 rounded-l">
      <button class="bg-green-600 text-white px-3 py-2 rounded-r"><span class="material-icons">search</span></button>
    </div>

    <!-- Nav Actions -->
    <div class="flex flex-wrap justify-center md:justify-end items-center gap-6 md:gap-12 w-full md:w-auto">
      <a href="#" class="text-black text-sm flex items-center gap-1"><span class="material-icons">favorite_border</span> Saved</a>
      <a href="#" class="text-black text-sm flex items-center gap-1"><span class="material-icons">shopping_cart</span> Cart</a>
      <a href="#" class="text-black text-sm">Login</a>
      <button class="bg-green-600 text-white px-4 py-2 rounded">Register</button>
    </div>
  </div>

  <!-- Bottom Green Bar -->
  <div class="bg-green-600 text-white flex flex-col sm:flex-row justify-between px-5 py-4 text-base">
    <span>Login</span>
    <span>Login &gt; Home</span>
  </div>
  <!-- Login Form -->
  <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md w-[90%] sm:w-[500px] mx-auto mt-10">
    <form method="POST" action="{{ route('login.submit') }}" class="flex flex-col">
      @csrf
      <div class="text-center mb-5">
        <img src="/images/logo2.png" alt="FreshBlink Logo" class="w-36 mx-auto">
        <h2 class="text-lg font-semibold mt-2">Welcome Back!</h2>
      </div>

      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <label for="email" class="text-sm mb-1">Email Address*</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required class="p-2 mb-4 border border-gray-300 rounded text-sm">

      <label for="password" class="text-sm mb-1">Password*</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required class="p-2 mb-4 border border-gray-300 rounded text-sm">

      <div class="flex justify-between items-center mb-4 text-sm">
        <div class="flex items-center gap-2">
          <input type="checkbox" id="remember" name="remember" class="accent-green-600">
          <label for="remember">Remember me</label>
        </div>
        <a href="{{ route('password.request') }}" class="text-green-600 hover:underline">Forgot password?</a>
      </div>

      <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded">Login</button>

      <p class="text-sm text-center mt-4 text-gray-600">Don't have an account? 
        <a href="{{ route('register') }}" class="text-green-600 font-medium hover:underline">Register</a>
      </p>
    </form>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-300 pt-10 px-5 mt-16">
    <div class="flex flex-wrap justify-center lg:justify-around gap-6 mb-5">
      <div class="text-center lg:text-left">
        <img src="/images/logo2.png" alt="FreshBlink Logo" class="w-36 mx-auto lg:mx-0">
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
      <img src="/images/paypal.webp" alt="PayPal" class="w-28 mx-auto">
    </div>
  </footer>

</body>
</html>
