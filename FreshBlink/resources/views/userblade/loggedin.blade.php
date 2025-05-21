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
  <div class="flex flex-col md:flex-row justify-between items-center px-5 py-3 border-b border-gray-300 bg-white gap-3 md:gap-0">
    <!-- Logo -->
    <div class="w-40">
      <a href="/"><img src="Image/logo2.png" alt="Logo"></a>
    </div>
    <!-- Search Box -->
    <div class="flex w-full md:flex-1 max-w-2xl mx-0 md:mx-5">
      <input type="text" placeholder="Search Products......." class="w-full px-3 py-2 border border-gray-300 border-r-0 bg-green-50 rounded-l">
      <button class="bg-green-600 text-white px-3 py-2 rounded-r"><span class="material-icons">search</span></button>
    </div>
    <!-- Nav Actions -->
    <!-- LOGGED IN -->
    <div class="flex flex-wrap justify-center md:justify-end items-center gap-6 md:gap-12 w-full md:w-auto">
        <a href="/wishlist" class="text-black text-sm flex items-center gap-1">
          <span class="material-icons">favorite_border</span> Saved
        </a>
        <a href="/cart" class="text-black text-sm flex items-center gap-1">
          <span class="material-icons">shopping_cart</span> Cart
        </a>
        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Logout</button>
        <!-- USER ICON (Material Icon in a circle) -->
        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200">
          <img src ="/images/icons/user.png" alt="User" class ="w-6 h-6" />
        </span>
        <!-- END USER ICON -->
      </div>
  </div>
  <!-- Bottom Green Bar -->
  <div class="bg-green-600 text-white flex flex-col sm:flex-row justify-between px-5 py-4 text-base">
    <span>Login</span>
    <span>Login &gt; Home</span>
  </div>
</body>
</html>