<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Product - FreshBlink</title>

  <!-- Link to external CSS -->
  <link rel="stylesheet" href="{{ asset('css/addProductTrader.css') }}" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

  <!-- ========== NAVIGATION BAR ========== -->
  <div class="navbar">
    <div class="logo">
      <a href="#"><img src="{{ asset('images/logo2.png') }}" alt="FreshBlink Logo"></a>
    </div>
    <div class="search-box">
      <input type="text" placeholder="Search Products......." />
      <button><span class="material-icons">search</span></button>
    </div>
    <div class="nav-actions">
      <a href="#"><span class="material-icons">favorite_border</span> Saved</a>
      <a href="#"><span class="material-icons">shopping_cart</span> Cart</a>
      <a href="#">Register</a>
      <button class="login-btn">Login</button>
    </div>
  </div>

  <!-- ========== PAGE BREADCRUMB & TITLE ========== -->
  <div class="bottom-bar">
    <span>Add Product</span>
    <span class="breadcrumb">Trader &gt; Add Product</span>
  </div>

  <!-- ========== ADD PRODUCT FORM ========== -->
  <div class="add-product-container">
    <!-- Laravel Form: Pratik added CSRF, method, action, enctype -->
    <form class="add-product-form" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
      @csrf <!-- CSRF protection (required by Laravel) -->

      <h2>Add New Product</h2>
      <h3>Product Info</h3>

      <!-- Product Name -->
      <label for="productName">Product Name</label>
      <input type="text" name="name" id="productName" placeholder="Enter product name" required>

      <!-- Description -->
      <label for="productDesc">Detailed Description</label>
      <textarea name="description" id="productDesc" placeholder="Enter product description" required></textarea>

      <!-- Quantity -->
      <label for="quantity">Quantity</label>
      <input type="number" name="quantity" id="quantity" placeholder="Available stock" required>

      <!-- Minimum Order -->
      <label for="minOrder">Minimum Order</label>
      <input type="number" name="min_order" id="minOrder" placeholder="Minimum quantity per order" required>

      <!-- Maximum Order -->
      <label for="maxOrder">Maximum Order</label>
      <input type="number" name="max_order" id="maxOrder" placeholder="Maximum quantity per order" required>

      <!-- Price -->
      <label for="price">Price</label>
      <input type="number" name="price" id="price" placeholder="Enter price" required>

      <!-- Shop Dropdown (dynamic) -->
      <label for="shop">Shop</label>
      <select name="shop_id" id="shop" required>
        <option value="" disabled selected>Select shop</option>
        @foreach($shops as $shop)
          <option value="{{ $shop->id }}">{{ $shop->shop_name }}</option>
        @endforeach
      </select>

      <!-- Image Upload -->
      <label for="image">Upload Product Image</label>
      <input type="file" name="image" id="image" required>

      <!-- Submit Button -->
      <button type="submit">Submit</button>
    </form>
  </div>

  <!-- ========== FOOTER ========== -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-logo">
        <img src="{{ asset('images/logo2.png') }}" alt="FreshBlink Logo" />
      </div>
      <div class="footer-column">
        <h3>Account</h3>
        <ul>
          <li><a href="#">Wishlist</a></li>
          <li><a href="#">Cart</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">Shipping Details</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Useful links</h3>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact us</a></li>
          <li><a href="#">Hot Deals</a></li>
          <li><a href="#">Promotions</a></li>
          <li><a href="#">New product</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Help Center</h3>
        <ul>
          <li><a href="#">Payment</a></li>
          <li><a href="#">Refund</a></li>
          <li><a href="#">Checkout</a></li>
          <li><a href="#">Q&amp;A</a></li>
          <li><a href="#">Shipping</a></li>
        </ul>
      </div>
    </div>
    <hr />
    <div class="copyright">
      <p>&copy; 2022, All rights reserved</p>
    </div>
    <div class="footer-bottom">
      <img src="{{ asset('images/paypal.webp') }}" alt="PayPal" />
    </div>
  </footer>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
