<<<<<<< HEAD
  <!-- Navbar -->
  <header class="bg-white shadow">
    <div class="flex flex-wrap items-center justify-between px-4 py-3 border-b border-gray-300">
      <a href="#"><img src="images/logo.png" alt="FreshBlink Logo" class="w-28 sm:w-40"></a>
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
=======
<!-- Top Navbar -->
<div class="flex flex-col md:flex-row justify-between items-center px-5 py-3 border-b border-gray-300 bg-white gap-3 md:gap-0">
    <!-- Logo -->
    <div class="w-40">
        <a href="/"><img src="/images/logo2.png" alt="Logo"></a>
>>>>>>> 8dc90d6028104f76fa1bc9b03791bd0513833879
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
        <a href="/login" class="text-black text-sm">Login</a>
        <a href="/register"><button class="bg-green-600 text-white px-4 py-2 rounded">Register</button></a> 
    </div>
</div> 