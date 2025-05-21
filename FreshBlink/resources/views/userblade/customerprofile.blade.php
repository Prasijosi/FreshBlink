<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <div class="flex flex-wrap items-center justify-between px-4 py-3 border-b border-gray-300 bg-white">
    <a href="#"><img src="/images/ logo.png" alt="FreshBlink Logo" class="w-36 sm:w-40"></a>
    <div class="flex items-center gap-2">
      <input type="text" placeholder="Search Products..." class="px-3 py-2 border rounded-l bg-green-50 w-40 sm:w-64" />
      <button class="px-3 py-2 bg-green-600 text-white rounded-r">
        <span class="material-icons">search</span>
      </button>
    </div>
    <div class="flex items-center gap-4">
      <a href="#" class="flex items-center text-sm text-black hover:text-green-600">
        <span class="material-icons mr-1">shopping_cart</span> Cart
      </a>
      <a href="#" class="flex items-center text-sm text-black hover:text-green-600">
        <span class="material-icons mr-1">favorite_border</span> Saved
      </a>
    </div>
  </div>

  <!-- Slide Buttons (Mobile Only for Recent Orders) -->
  <button
    id="slideBtnLeft"
    class="fixed left-2 top-1/2 transform -translate-y-1/2 bg-green-600 text-white px-3 py-2 rounded-full shadow-lg sm:hidden z-10"
  >
    &#8592;
  </button>

  <button
    id="slideBtnRight"
    class="fixed right-2 top-1/2 transform -translate-y-1/2 bg-green-600 text-white px-3 py-2 rounded-full shadow-lg sm:hidden z-10"
  >
    &#8594;
  </button>

  <!-- Main Content -->
  <main class="max-w-screen-xl mx-auto p-4 grid grid-cols-1 lg:grid-cols-4 gap-4">
    
    <!-- Profile Sidebar -->
    <aside class="bg-white p-4 rounded shadow col-span-1 flex flex-col items-center text-center">
      <label for="profilePicInput" class="cursor-pointer">
        <img id="profilePic" src="/images/Customer.jpg"
             alt="Profile Picture"
             class="w-24 h-24 rounded-full mb-2 object-cover border border-gray-300 hover:opacity-80 transition" />
        <input type="file" id="profilePicInput" accept="image/*" class="hidden" />
      </label>
      <p class="font-semibold">Profile Picture</p>
      <p class="text-sm text-gray-600 mt-1">My Account</p>
    </aside>

    <!-- Account Info and Orders -->
    <section class="col-span-1 lg:col-span-3 space-y-4">
      
      <!-- Account Info -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Account Information</h2>
        <p><strong>Name:</strong> abc</p>
        <p><strong>Email:</strong> abc@gmail.com</p>
        <div class="mt-2 space-x-4 text-blue-600 text-sm">
          <button id="editBtn">Edit</button>
          <button id="changePasswordBtn">Change Password</button>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="bg-white p-4 rounded shadow overflow-x-auto" id="ordersContainer">
        <h3 class="font-semibold mb-2">Recent Orders</h3>
        <table class="w-full min-w-[600px] text-left text-sm border">
          <thead>
            <tr class="bg-gray-100 border-b">
              <th class="p-2">Order No</th>
              <th class="p-2">Placed On</th>
              <th class="p-2">Items</th>
              <th class="p-2">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="p-2">#1234</td>
              <td class="p-2">2025-04-25</td>
              <td class="p-2">Fish, Lettuce, Tomato</td>
              <td class="p-2">Rs.2200</td>
            </tr>
            <tr class="border-b">
              <td class="p-2">#1235</td>
              <td class="p-2">2025-04-20</td>
              <td class="p-2">Milk, Avocado</td>
              <td class="p-2">Rs.1000</td>
            </tr>
            <tr>
              <td class="p-2">#1236</td>
              <td class="p-2">2025-04-10</td>
              <td class="p-2">Broccoli, Carrot, Cheese</td>
              <td class="p-2">Rs.1500</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-white mt-8 p-6 shadow">
    <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 text-sm text-gray-700">
      <div class="col-span-1 flex justify-center">
        <div class="w-32 h-20 bg-gray-200 flex items-center justify-center">Image</div>
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
      <span>© 2025 Company Name</span>
      <div class="space-x-4 text-lg text-gray-600">
        <a href="https://www.facebook.com" target="_blank" aria-label="Facebook">
          <i class="fab fa-facebook-f hover:text-blue-600"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank" aria-label="LinkedIn">
          <i class="fab fa-linkedin-in hover:text-blue-500"></i>
        </a>
        <a href="https://instagram.com" target="_blank" aria-label="Instagram">
          <i class="fab fa-instagram hover:text-pink-500"></i>
        </a>
        <a href="https://x.com/i/flow/login" target="_blank" aria-label="Twitter">
          <i class="fab fa-twitter hover:text-blue-400"></i>
        </a>
      </div>
    </div>
  </footer>

  <script src="/js/profile.js"></script>
</body>
</html>
