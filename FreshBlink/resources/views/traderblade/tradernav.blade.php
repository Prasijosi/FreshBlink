<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Navigation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#28a745",
          },
        },
      },
    };
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
  <!-- Navbar -->
  <div class="bg-primary text-white px-4 py-3 shadow-md flex items-center justify-between">
    <!-- Logo -->
    <a href="#" class="flex-shrink-0">
      <img src="/images/logo.png" alt="Logo" class="w-28 sm:w-40" />
    </a>

    <!-- Desktop Nav -->
    <nav class="hidden md:flex items-center gap-10 ml-10">
      <a href="#" class="hover:underline font-medium">Dashboard</a>
      <a href="#" class="hover:underline font-medium">Shop</a>

      <!-- Product with Dropdown -->
      <div class="relative group">
        <button class="font-medium hover:underline">Product</button>
        <div class="absolute hidden group-hover:flex flex-col mt-2 bg-white text-primary rounded shadow-lg min-w-[150px] z-50">
          <a href="#" class="px-4 py-2 hover:bg-gray-100 border-b">Add Product</a>
          <a href="#" class="px-4 py-2 hover:bg-gray-100">Product Details</a>
        </div>
      </div>

      <a href="#" class="hover:underline font-medium">Profile</a>
    </nav>

    <!-- Profile Picture -->
    <div class="relative hidden md:block">
      <img src="/images/Customer.jpg" alt="Customer" class="w-10 h-10 rounded-full object-cover border border-white hover:opacity-80 transition" />
    </div>

    <!-- Hamburger for Mobile -->
    <button id="menuBtn" class="md:hidden text-white text-2xl focus:outline-none">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="md:hidden hidden bg-white shadow border-t border-gray-200">
    <div class="flex flex-col px-4 py-2 gap-2 text-primary font-medium">
      <a href="#" class="hover:bg-gray-100 px-2 py-2 rounded">Dashboard</a>
      <a href="#" class="hover:bg-gray-100 px-2 py-2 rounded">Shop</a>

      <!-- Mobile Product Dropdown -->
      <div>
        <button onclick="toggleDropdown()" class="w-full text-left hover:bg-gray-100 px-2 py-2 rounded flex items-center justify-between">
          Product
          <i class="fas fa-chevron-down ml-2 text-sm"></i>
        </button>
        <div id="dropdownMenu" class="hidden pl-4">
          <a href="#" class="block py-1 hover:text-primary">Add Product</a>
          <a href="#" class="block py-1 hover:text-primary">Product Details</a>
        </div>
      </div>

      <a href="#" class="hover:bg-gray-100 px-2 py-2 rounded">Profile</a>
      <div class="pt-2 border-t border-gray-200">
        <img src="/images/Customer.jpg" alt="Customer" class="w-10 h-10 rounded-full object-cover border border-gray-300 hover:opacity-80 transition" />
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // Hamburger Menu Toggle
    document.getElementById('menuBtn').addEventListener('click', function () {
      document.getElementById('mobileMenu').classList.toggle('hidden');
    });

    // Mobile Dropdown Toggle
    function toggleDropdown() {
      document.getElementById('dropdownMenu').classList.toggle('hidden');
    }
  </script>
</body>

</html>
