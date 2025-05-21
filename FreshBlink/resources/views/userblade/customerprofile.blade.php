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
  @guest
  {{-- Show this if the user is NOT logged in --}}
  @include('components.navbar')
  @endguest

  @auth
  {{-- Show this if the user IS logged in --}}
  @include('userblade.loggedin')
  @endauth


  <!-- Slide Buttons (Mobile Only for Recent Orders) -->
  <button
    id="slideBtnLeft"
    class="fixed left-2 top-1/2 transform -translate-y-1/2 bg-green-600 text-white px-3 py-2 rounded-full shadow-lg sm:hidden z-10">
    &#8592;
  </button>

  <button
    id="slideBtnRight"
    class="fixed right-2 top-1/2 transform -translate-y-1/2 bg-green-600 text-white px-3 py-2 rounded-full shadow-lg sm:hidden z-10">
    &#8594;
  </button>

  <!-- Main Content -->
  <main class="max-w-screen-xl mx-auto p-4 grid grid-cols-1 lg:grid-cols-4 gap-4">

    <!-- Profile Sidebar -->
    <aside class="bg-white p-4 rounded shadow col-span-1 flex flex-col items-center text-center">
      <label for="profilePicInput" class="cursor-pointer">
        <img id="profilePic" src="{{ Auth::user()->getProfileImageUrl() }}"
          alt="Profile Picture"
          class="w-24 h-24 rounded-full mb-2 object-cover border border-gray-300 hover:opacity-80 transition" />
        <input type="file" id="profilePicInput" accept="image/*" class="hidden" />
      </label>
      <p class="font-semibold">Profile Picture</p>
      <p class="text-sm text-gray-600 mt-1">My Account</p>
    </aside>

    <!-- Account Info and Orders -->
    <section class="col-span-1 lg:col-span-3 space-y-4">
      
      @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Account Info -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-4">Account Information</h2>
        <form action="{{ route('user.profile.update') }}" method="POST" id="profileForm" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="space-y-4">

            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" name="name" id="name" value="{{ $user->name }}" required
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" id="email" value="{{ $user->email }}" required
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>

            <div>
              <label for="contact_details" class="block text-sm font-medium text-gray-700">Contact Details</label>
              <input type="text" name="contact_details" id="contact_details" value="{{ $user->contact_details }}" required
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>

            <div>
              <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
              <textarea name="address" id="address" required rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ $user->address }}</textarea>
            </div>

            <div>
              <label for="notification_preference" class="block text-sm font-medium text-gray-700">Notification Preference</label>
              <select name="notification_preference" id="notification_preference"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="email" {{ $customer->notification_preference === 'email' ? 'selected' : '' }}>Email</option>
                <option value="sms" {{ $customer->notification_preference === 'sms' ? 'selected' : '' }}>SMS</option>
                <option value="both" {{ $customer->notification_preference === 'both' ? 'selected' : '' }}>Both</option>
              </select>
            </div>
            
            <div>
              <label for="loyalty_points" class="block text-sm font-medium text-gray-700">Loyalty Points</label>
              <input type="text" name="loyalty_points" id="loyalty_points" value="{{ $customer->loyalty_points }}" required
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>

            <div class="flex justify-between items-center pt-4">
              <a href="{{ route('user.password.change') }}" class="text-green-600 hover:text-green-800">Change Password</a>
              <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Save Changes
              </button>
            </div>
          </div>
        </form>
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

  <script>
    function previewImage(input) {
      const preview = document.getElementById('imagePreview');
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Initialize preview with current image
    document.addEventListener('DOMContentLoaded', function() {
      const preview = document.getElementById('imagePreview');
      if (preview.src) {
        preview.classList.remove('hidden');
      }
    });
  </script>

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