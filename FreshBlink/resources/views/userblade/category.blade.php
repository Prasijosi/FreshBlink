<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Traders Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body class="font-sans bg-gray-100">

  @include('components.navbar')

  <!-- Category Menu -->
  <div class="bg-white py-3 flex justify-center gap-4 sm:gap-8 border-b border-gray-300 flex-wrap text-sm sm:text-base font-semibold">
    <a href="#">Bakery</a>
    <a href="#">Butchery</a>
    <a href="#">Greengrocer</a>
    <a href="#">Delicatessen</a>
    <a href="#">Fishmonger</a>
  </div>

  <!-- Page Title -->
  <h1 class="text-center my-8 text-3xl font-semibold underline">Traders</h1>

  <!-- PRODUCT GRID (shown on md+) -->
  <div id="grid" class="hidden md:grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 px-[5%] pb-8 max-w-[70rem] mx-auto"></div>

  <!-- PRODUCT SLIDER (shown below md) -->
  <div class="relative block md:hidden px-4 pb-8">
    <div id="slider" class="overflow-hidden">
      <div id="slides" class="flex transition-transform duration-300"></div>
    </div>
    <button id="prevBtn" class="absolute top-1/2 left-2 -translate-y-1/2 bg-white p-2 rounded-full shadow">‹</button>
    <button id="nextBtn" class="absolute top-1/2 right-2 -translate-y-1/2 bg-white p-2 rounded-full shadow">›</button>
  </div>

  @include('components.footer')

  <script src="{{ asset('js/category.js') }}"></script>
</body>
</html>
