<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FreshBlink - Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/css/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <div class="flex flex-col md:flex-row justify-between items-center px-5 py-3 border-b border-gray-300 bg-white gap-3 md:gap-0">
    <!-- Logo -->
    <div class="w-40">
      <a href="home.html"><img src="/images/logo2.png" alt="Logo"></a>
    </div>

    <!-- Search Box -->
    <div class="flex w-full md:flex-1 max-w-2xl mx-0 md:mx-5">
      <input type="text" placeholder="Search Products......." class="w-full px-3 py-2 border border-gray-300 border-r-0 bg-green-50 rounded-l">
      <button class="bg-green-600 text-white px-3 py-2 rounded-r"><span class="material-icons">search</span></button>
    </div>

    <!-- Nav Actions -->
    <div class="flex flex-wrap justify-center md:justify-end items-center gap-6 md:gap-12 w-full md:w-auto">
      <a href="Wishlist.html" class="text-black text-sm flex items-center gap-1"><span class="material-icons">favorite_border</span> Saved</a>
      <a href="cartprd.html" class="text-black text-sm flex items-center gap-1"><span class="material-icons">shopping_cart</span> Cart</a>
      <a href="login.html" class="text-black text-sm">Login</a>
      <button class="bg-green-600 text-white px-4 py-2 rounded">Register</button>
    </div>
  </div>
  <!-- Secondary Navbar -->
  <header class="navbar">
    <button class="categories-btn">
      <img src="/images/Grid.png" alt=""> Browse All Categories
    </button>
    <nav class="nav-links">
      <a href="home.html" class="active">Home</a>
      <a href="#">Shop</a>
      <a href="ContactUs.html">Contact</a>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
  <div class="hero-text">
    <p class="tagline"><span class="highlight">100%</span> Organic</p>
    <h1>Start Shopping At<br>Our Store</h1>
    <p class="subtext">Save up to 50% off on your first order</p>
  </div>
  <div class="hero-images">
    <img src="/images/1.png" alt="Meat" class="meat-image" />
    <img src="/images/2.png" alt="Vegetables" class="vegetables" />
  </div>
</section>


  <!-- Product Promo Cards Section -->
  <section class="promo-section">
    <div class="promo-card card-blue">
      <div class="promo-content">
        <h3>The best Organic<br />Product Online</h3>
        <a href="#" class="shop-now">Shop Now</a>
      </div>
      <img src="/images/greenvegie.png" alt="Vegetables" class="promo-image">
    </div>

    <div class="promo-card card-beige">
      <div class="promo-content">
        <h3>Everyday Fresh &<br />Clean Product</h3>
        <a href="#" class="shop-now">Shop Now</a>
      </div>
      <img src="/images/ginger.png" alt="Ginger" class="promo-image">
    </div>

    <div class="promo-card card-pink">
      <div class="promo-content">
        <h3>Make your Breakfast<br />Healthy and Easy</h3>
        <a href="#" class="shop-now">Shop Now</a>
      </div>
      <img src="/images/cake.png" alt="Cake" class="promo-image">
    </div>
  </section>

  <!-- Featured Categories -->
  <section class="featured-section">
    <h2 class="featured-heading">Featured Categories</h2>
    <div class="categories">
      <div class="category-box category-bakery">
        <img src="/images/bakery_vector.png" alt="Bakery">
        <p>Bakery</p>
      </div>
      <div class="category-box category-butchery">
        <img src="/images/meat_steak.webp" alt="Butchery">
        <p>Butchery</p>
      </div>
      <div class="category-box category-greengrocer">
        <img src="/images/vegetable_vector.png" alt="Greengrocer">
        <p>Greengrocer</p>
      </div>
      <div class="category-box category-delicatessen">
        <img src="/images/vector.png" alt="Delicatessen">
        <p>Delicatessen</p>
      </div>
      <div class="category-box category-fishmonger">
        <img src="/images/seer_fish.png" alt="Fishmonger">
        <p>Fishmonger</p>
      </div>
    </div>
  </section>

  <!-- Popular Products -->
  <section class="popular-products">
    <h2 class="featured-heading">Popular Products</h2>
    <div class="product-grid">
      <div class="product-card">
        <img src="/images/watermelom.png" alt="Watermelon">
        <p>Watermelon 500gm</p>
        <p class="price">$4 <span class="old-price">$5.99</span></p>
        <button class="add-btn">Add</button>
      </div>
      <div class="product-card">
        <img src="/images/grainbread.png" alt="Brown Bread">
        <p>Brown Bread</p>
        <p class="price">$2.99 <span class="old-price">$3.99</span></p>
        <button class="add-btn">Add</button>
      </div>
      <div class="product-card">
        <img src="/images/apple.png" alt="Apple">
        <p>Apple 1000gm</p>
        <p class="price">$2.99 <span class="old-price">$3.99</span></p>
        <button class="add-btn">Add</button>
      </div>
      <div class="product-card">
        <img src="/images/buff2.png" alt="Buff Meat">
        <p>Buff Meat 200gm</p>
        <p class="price">$4.99 <span class="old-price">$6.99</span></p>
        <button class="add-btn">Add</button>
      </div>
      <div class="product-card">
        <img src="/images/snacks-PL_mob.png" alt="Nut Bar">
        <p>Nut Bar</p>
        <p class="price">$0.99 <span class="old-price">$1.99</span></p>
        <button class="add-btn">Add</button>
      </div>
    </div>
  </section>
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
