<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta tags for character set and responsive design -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Page title shown on browser tab -->
  <title>Add Product - FreshBlink</title>

  <!-- Link to external CSS for styling -->
  <link rel="stylesheet" href="/css/addProductTrader.css" />

  <!-- Google Material Icons (used for icons in navbar) -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

  <!-- ========== NAVIGATION BAR ========== -->
  <div class="navbar">
    <!-- Website Logo -->
    <div class="logo">
      <a href="#"><img src="images/logo2.png" alt="FreshBlink Logo"></a>
    </div>

    <!-- Search bar in the middle of navbar -->
    <div class="search-box">
      <input type="text" placeholder="Search Products......." />
      <button><span class="material-icons">search</span></button>
    </div>

    <!-- Navigation actions like wishlist, cart, register and login -->
    <div class="nav-actions">
      <a href="#"><span class="material-icons">favorite_border</span> Saved</a>
      <a href="#"><span class="material-icons">shopping_cart</span> Cart</a>
      <a href="#">Register</a>
      <button class="login-btn">Login</button>
    </div>
  </div>

  <!-- ========== PAGE BREADCRUMB & TITLE ========== -->
  <div class="bottom-bar">
    <span>Add Product</span> <!-- Page Title -->
    <span class="breadcrumb">Trader &gt; Add Product</span> <!-- Navigation trail -->
  </div>

  <!-- ========== ADD PRODUCT FORM ========== -->
  <div class="add-product-container">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="add-product-form">
      @csrf
      <h2>Add New Product</h2>

      <h3>Product Info</h3>

      <label for="productName">Product Name</label>
      <input type="text" id="productName" name="name" placeholder="Enter product name" required>

      <label for="productDesc">Detailed Description</label>
      <textarea id="productDesc" name="description" placeholder="Enter product description" required></textarea>

      <label for="quantity">Quantity</label>
      <input type="number" id="quantity" name="quantity" placeholder="Available stock" required>

      <label for="minOrder">Minimum Order</label>
      <input type="number" id="minOrder" name="min_order" placeholder="Minimum quantity per order" required>

      <label for="maxOrder">Maximum Order</label>
      <input type="number" id="maxOrder" name="max_order" placeholder="Maximum quantity per order" required>

      <label for="price">Price</label>
      <input type="number" id="price" name="price" placeholder="Enter price" required>

      <!-- Shop Dropdown (Trader's Shops) -->
      <label for="shop">Shop</label>
      <select id="shop" name="shop_id" required>
        <option value="" disabled selected>Select shop</option>
        @foreach($shops as $shop)
        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
        @endforeach
      </select>

      <!-- Category Dropdown -->
      <label for="category_id">Category</label>
      <select name="product_category_id" id="product_category_id" required>
        <option value="" disabled selected>Select category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>

      <label for="image">Upload Product Image</label>
      <input type="file" id="image" name="image" required>

      <button type="submit">Submit</button>
    </form>

  </div>

  <!-- ========== FOOTER ========== -->
  <footer class="footer">
    <div class="footer-top">
      <!-- Footer logo -->
      <div class="footer-logo">
        <img src="images/logo2.png" alt="FreshBlink Logo" />
      </div>

      <!-- Footer links: Account -->
      <div class="footer-column">
        <h3>Account</h3>
        <ul>
          <li><a href="#">Wishlist</a></li>
          <li><a href="#">Cart</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">Shipping Details</a></li>
        </ul>
      </div>

      <!-- Footer links: Useful links -->
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

      <!-- Footer links: Help Center -->
      <div class="footer-column">
        <h3>Help Center</h3>
        <ul>
          <li><a href="#">Payment</a></li>
          <li><a href="#">Refund</a></li>
          <li><a href="#">Checkout</a></li>
          <li><a href="#">Q&amp;A</a></li>
          <li><a href="#">Shipping</a></li>
          <li><a href="#">Shipping</a></li>
        </ul>
      </div>
    </div>

    <!-- Divider line -->
    <hr />

    <!-- Copyright -->
    <div class="copyright">
      <p>&copy; 2022, All rights reserved</p>
    </div>

    <!-- Payment options (e.g., PayPal logo) -->
    <div class="footer-bottom">
      <img src="images/paypal.webp" alt="PayPal" />
    </div>
  </footer>

  <!-- Link to external JavaScript functionality -->
  <script src="script.js"></script>
</body>

</html>