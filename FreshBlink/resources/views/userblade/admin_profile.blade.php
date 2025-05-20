<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Information</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <div class="flex flex-wrap items-center justify-between px-4 py-3 border-b border-gray-300 bg-white">
    <a href="#" class="flex-shrink-0">
      <img src="/Users/manjusha/Desktop/practice/images/ logo.png" alt="FreshBlink Logo" class="w-28 sm:w-40" />
    </a>

    <!-- Centered Navigation -->
    <nav class="flex flex-wrap justify-center gap-2 sm:gap-4 mt-2 sm:mt-0">
  <button class="px-3 py-1 sm:px-4 sm:py-2 bg-gray-200 rounded text-sm sm:text-base whitespace-nowrap">Dashboard</button>
  <button class="px-3 py-1 sm:px-4 sm:py-2 bg-gray-200 rounded text-sm sm:text-base whitespace-nowrap">Add Trader</button>
  <button class="px-3 py-1 sm:px-4 sm:py-2 bg-gray-200 rounded text-sm sm:text-base whitespace-nowrap">Customer Page</button>
    </nav>
 

    <div class="relative mt-3 sm:mt-0 flex-shrink-0">
      <img id="navProfilePic" src="images/Customer.jpg" alt="Customer" class="w-10 h-10 rounded-full object-cover border border-gray-300 hover:opacity-80 transition" />
    </div>
  </div>

  <!-- Main Content -->
  <main class="p-4 sm:p-6 max-w-screen-xl mx-auto relative">
    <h2 class="text-2xl font-semibold mb-4">Customer Information</h2>

    <!-- Slide Buttons (Mobile only) -->
    <button
      id="slideBtnLeft"
      class="fixed left-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-3 py-2 rounded-full shadow-lg sm:hidden z-10"
    >
      &#8592;
    </button>

    <button
      id="slideBtn"
      class="fixed right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-3 py-2 rounded-full shadow-lg sm:hidden z-10"
    >
      ➤
    </button>

    <div id="tableWrapper" class="overflow-x-auto">
      <table class="min-w-full bg-white shadow rounded-lg">
        <thead>
          <tr class="bg-gray-200 text-left text-xs sm:text-sm font-semibold">
            <th class="p-2 sm:p-3 whitespace-nowrap">Profile</th>
            <th class="p-2 sm:p-3 whitespace-nowrap">Name</th>
            <th class="p-2 sm:p-3 whitespace-nowrap">Contact</th>
            <th class="p-2 sm:p-3 whitespace-nowrap">Address</th>
            <th class="p-2 sm:p-3 whitespace-nowrap">Email</th>
            <th class="p-2 sm:p-3 whitespace-nowrap">Total Order</th>
            <th class="p-2 sm:p-3 whitespace-nowrap">Points</th>
          </tr>
        </thead>
        <tbody id="customerTableBody">
          <!-- JS will insert rows here -->
        </tbody>
      </table>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white mt-8 p-4 sm:p-6 shadow">
    <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 text-sm text-gray-700">
      <div class="col-span-1 flex justify-center">
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
      <span>© 2025 FreshBlink</span>
      <div class="space-x-4 text-lg text-gray-600">
        <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f hover:text-blue-600"></i></a>
        <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in hover:text-blue-500"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram hover:text-pink-500"></i></a>
        <a href="https://x.com/i/flow/login" target="_blank"><i class="fab fa-twitter hover:text-blue-400"></i></a>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/admin_profile.js') }}"></script>
</body>
</html>
