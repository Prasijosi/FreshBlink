<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta tags for character set and responsive design -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <!-- Page title shown on browser tab -->
  <title>Add Product - FreshBlink</title>

  <!-- Link to external CSS for styling -->
  <link rel="stylesheet" href="/css/addProductTrader.css" />
  
  <!-- Google Material Icons (used for icons in navbar) -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

  <!-- ========== NAVIGATION BAR ========== -->
    @include('traderblade.tradernav')
  <!-- ========== PAGE BREADCRUMB & TITLE ========== -->
  <div class="bottom-bar">
    <span>Add Product</span> <!-- Page Title -->
    <span class="breadcrumb">Trader &gt; Add Product</span> <!-- Navigation trail -->
  </div>

  <!-- ========== ADD PRODUCT FORM ========== -->
  <div class="add-product-container">
    <form class="add-product-form">
      <h2>Add New Product</h2> <!-- Form Header -->

      <!-- Product Info Section Header -->
      <h3>Product Info</h3>

      <!-- Input field for product name -->
      <label for="productName">Product Name</label>
      <input type="text" id="productName" placeholder="Enter product name" required>

      <!-- Textarea for product description -->
      <label for="productDesc">Detailed Description</label>
      <textarea id="productDesc" placeholder="Enter product description" required></textarea>

      <!-- Input for available quantity -->
      <label for="quantity">Quantity</label>
      <input type="number" id="quantity" placeholder="Available stock" required>

      <!-- Input for minimum order limit -->
      <label for="minOrder">Minimum Order</label>
      <input type="number" id="minOrder" placeholder="Minimum quantity per order" required>

      <!-- Input for maximum order limit -->
      <label for="maxOrder">Maximum Order</label>
      <input type="number" id="maxOrder" placeholder="Maximum quantity per order" required>

      <!-- Input for product price -->
      <label for="price">Price</label>
      <input type="number" id="price" placeholder="Enter price" required>

      <!-- Dropdown to select the shop category -->
      <label for="shop">Shop</label>
      <select id="shop" required>
        <option value="" disabled selected>Select shop</option>
        <option value="shop1">Butchers</option>
        <option value="shop2">Greengrocer</option>
        <option value="shop3">Fishmonger</option>
        <option value="shop4">Bakery</option>
        <option value="shop5"></option>
      </select>

      <!-- File input for uploading product image -->
      <label for="image">Upload Product Image</label>
      <input type="file" id="image" required>

      <!-- Form submission button -->
      <button type="submit">Submit</button>
    </form>
  </div>

  <!-- ========== FOOTER ========== -->
  <footer class="footer">
    <div class="footer-top">
      <!-- Footer logo -->
      <div class="footer-logo">
        <img src="/images/logo2.png" alt="FreshBlink Logo" />
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
        <img src="/images/paypal.webp" alt="PayPal" />
    </div>
  </footer>

  <!-- Link to external JavaScript functionality -->
  <script src="/js/addProductTrader.js"></script>
</body>
</html>