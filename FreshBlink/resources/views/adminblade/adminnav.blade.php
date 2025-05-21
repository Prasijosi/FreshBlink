<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FreshBlink Nav</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#4DAF22",
          },x
        },
      },
    };
  </script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50">
  <div class="flex flex-wrap items-center justify-between px-4 py-3 border-b border-gray-300 bg-white shadow-md">
    <!-- Logo -->
    <a href="#" class="flex-shrink-0">
      <img src="/images/logo.png" alt="FreshBlink Logo" class="w-28 sm:w-40" />
    </a>

    <!-- Desktop Nav -->
    <nav class="hidden md:flex flex-grow items-center justify-center gap-10 ml-10">
      <button class="px-4 py-2 bg-primary text-white rounded text-sm sm:text-base whitespace-nowrap font-semibold hover:bg-green-600 transition">
        Dashboard
      </button>
      <div class="flex gap-4 ml-20">
        <button class="px-4 py-2 bg-primary/10 text-primary border border-primary rounded text-sm sm:text-base whitespace-nowrap hover:bg-primary/20 transition">
          Trader
        </button>
        <button class="px-4 py-2 bg-primary/10 text-primary border border-primary rounded text-sm sm:text-base whitespace-nowrap hover:bg-primary/20 transition">
          Customer
        </button>
      </div>
    </nav>

    <!-- Profile Picture -->
    <div class="relative flex-shrink-0 hidden md:block">
      <img id="navProfilePic" src="/images/Customer.jpg" alt="Customer" class="w-10 h-10 rounded-full object-cover border border-gray-300 hover:opacity-80 transition" />
    </div>

    <!-- Hamburger -->
    <div class="md:hidden flex items-center">
      <button id="menuBtn" class="text-primary focus:outline-none text-2xl">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="md:hidden hidden flex flex-col gap-2 px-4 py-2 bg-white shadow border-t border-gray-200">
    <button class="px-4 py-2 bg-primary text-white rounded text-sm font-semibold hover:bg-green-600 transition">
      Dashboard
    </button>
    <button class="px-4 py-2 bg-primary/10 text-primary border border-primary rounded text-sm hover:bg-primary/20 transition">
      Trader
    </button>
    <button class="px-4 py-2 bg-primary/10 text-primary border border-primary rounded text-sm hover:bg-primary/20 transition">
      Customer
    </button>
    <div class="pt-2 border-t border-gray-200">
      <img src="/images/Customer.jpg" alt="Customer" class="w-10 h-10 rounded-full object-cover border border-gray-300 hover:opacity-80 transition" />
    </div>
  </div>

  <script>
    //  Mobile Menu
    document.getElementById('menuBtn').addEventListener('click', function () {
      const menu = document.getElementById('mobileMenu');
      menu.classList.toggle('hidden');
    });
  </script>
</body>

</html>
