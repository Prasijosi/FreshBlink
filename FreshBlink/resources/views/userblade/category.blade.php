<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>{{ isset($category) ? $category->name : 'Categories' }} - FreshBlink</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="font-sans bg-gray-100">

  <!-- Navbar -->
  @guest
  {{-- Show this if the user is NOT logged in --}}
  @include('components.navbar')
  @endguest

  @auth
  {{-- Show this if the user IS logged in --}}
  @include('userblade.loggedin')
  @endauth


  <!-- Category Menu -->
  <div class="bg-white py-3 flex justify-center gap-4 sm:gap-8 border-b border-gray-300 flex-wrap text-sm sm:text-base font-semibold">
    @foreach($categories as $cat)
      <a href="{{ route('categories.show', $cat->id) }}" 
         class="{{ isset($category) && $category->id === $cat->id ? 'text-green-600' : 'hover:text-green-600' }}">
        {{ $cat->name }}
        <span class="text-xs text-gray-500">({{ $cat->products_count }})</span>
      </a>
    @endforeach
  </div>

  @if(isset($category))
    <div class="bg-white py-4 px-6 border-b">
      <h1 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h1>
      <p class="text-gray-600 mt-1">{{ $category->description }}</p>
    </div>
  @endif

  <!-- PRODUCT GRID (shown on md+) -->
  <div id="grid" class="hidden md:grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 px-6 sm:px-12 pb-8 max-w-6xl mx-auto">
    @forelse($products ?? [] as $product)
      <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
        <a href="{{ route('products.show', $product->id) }}" class="block">
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
            <p class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($product->description, 60) }}</p>
          </div>
        </a>
        <div class="p-4 pt-0">
          <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex gap-2">
            @csrf
            <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" 
                   class="w-16 px-2 py-1 border rounded text-center" />
            <button type="submit" class="flex-1 bg-green-600 text-white py-1 rounded hover:bg-green-700">
              Add to Cart
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-span-full text-center py-12">
        <p class="text-gray-600">No products found in this category.</p>
      </div>
    @endforelse
  </div>

  <!-- PRODUCT SLIDER (shown below md) -->
  <div class="relative block md:hidden px-4 pb-8">
    <div id="slider" class="overflow-hidden">
      <div id="slides" class="flex transition-transform duration-300">
        @forelse($products ?? [] as $product)
          <div class="w-full flex-shrink-0 px-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
              <a href="{{ route('products.show', $product->id) }}" class="block">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover" />
                <div class="p-4">
                  <h3 class="font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                  <p class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</p>
                  <p class="text-sm text-gray-600 mt-1">{{ Str::limit($product->description, 60) }}</p>
                </div>
              </a>
              <div class="p-4 pt-0">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex gap-2">
                  @csrf
                  <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" 
                         class="w-16 px-2 py-1 border rounded text-center" />
                  <button type="submit" class="flex-1 bg-green-600 text-white py-1 rounded hover:bg-green-700">
                    Add to Cart
                  </button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="w-full text-center py-12">
            <p class="text-gray-600">No products found in this category.</p>
          </div>
        @endforelse
      </div>
    </div>
    @if(isset($products) && count($products) > 0)
      <button id="prevBtn" class="absolute top-1/2 left-3 -translate-y-1/2 bg-green-600 p-2 rounded-full shadow text-white">&#8592;</button>
      <button id="nextBtn" class="absolute top-1/2 right-3 -translate-y-1/2 bg-green-600 p-2 rounded-full shadow text-white">&#8594;</button>
    @endif
  </div>

  <!-- Pagination -->
  @if(isset($products) && $products->hasPages())
    <div class="px-6 sm:px-12 pb-8 max-w-6xl mx-auto">
      {{ $products->links() }}
    </div>
  @endif

  @include('components.footer')

    <hr class="my-6" />

    <div class="flex flex-col sm:flex-row justify-between items-center max-w-screen-xl mx-auto">
      <p class="text-xs text-gray-500 mb-2 sm:mb-0">&copy; {{ date('Y') }} FreshBlink, All rights reserved</p>
      <img src="{{ asset('images/paypal.webp') }}" alt="PayPal" class="w-24" />
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Mobile slider functionality
      const slider = document.getElementById('slider');
      const slides = document.getElementById('slides');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      
      if (slider && slides && prevBtn && nextBtn) {
        let currentSlide = 0;
        const slideCount = slides.children.length;
        const slideWidth = slider.clientWidth;
        
        function updateSlider() {
          slides.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
        }
        
        prevBtn.addEventListener('click', () => {
          if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
          }
        });
        
        nextBtn.addEventListener('click', () => {
          if (currentSlide < slideCount - 1) {
            currentSlide++;
            updateSlider();
          }
        });
        
        // Update slider on window resize
        window.addEventListener('resize', () => {
          updateSlider();
        });
      }
    });
  </script>
</body>

</html>