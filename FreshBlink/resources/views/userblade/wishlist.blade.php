<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Wishlist</title>
   
  <link rel="stylesheet" href="Wishlist.css" />

</head>
<body>

  <!-- Navbar -->
    <header class="navbar">
    <div class="logo">
      <img src="/images/logo.png" alt="Logo" />
    </div>
    <div class="search-box">
      <input type="text" placeholder="Search Products..." />
      <button><img src="/images/icons/search.png" alt="Search" class="icon"></button>
    </div>
    
    <div class="nav-actions">
       <a href="#"><img src="/images/icons/saved.png" alt="Saved Icon" class="icon"> Saved</a>
       <a href="#"><img src="/images/icons/cart.png" alt="Cart Icon" class="icon"> Cart</a>
       <a href="#">Register</a>
    <button class="login-btn">Login</button>
  </div>
  </header>

  <!-- Wishlist Section -->
  <section class="wishlist-container">
    <h2>My Wishlist</h2>
    <div class="wishlist-items">

      <!-- Item 1 -->
      <div class="wishlist-item">
        <div class="wishlist-item-img">
          <img src="images/product1.jpg" alt="Product 1">
        </div>
        <div class="wishlist-item-details">
          <div class="wishlist-item-name">Wireless Headphones</div>
          <div class="wishlist-item-price">$49.99</div>
        </div>
        <div class="wishlist-item-actions">
          <button class="btn-add-cart">Add to Cart</button>
          <button class="btn-remove">Remove</button>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="wishlist-item">
        <div class="wishlist-item-img">
          <img src="images/product2.jpg" alt="Product 2">
        </div>
        <div class="wishlist-item-details">
          <div class="wishlist-item-name">Smart Watch</div>
          <div class="wishlist-item-price">$89.99</div>
        </div>
        <div class="wishlist-item-actions">
          <button class="btn-add-cart">Add to Cart</button>
          <button class="btn-remove">Remove</button>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="wishlist-item">
        <div class="wishlist-item-img">
          <img src="images/product3.jpg" alt="Product 3">
        </div>
        <div class="wishlist-item-details">
          <div class="wishlist-item-name">Bluetooth Speaker</div>
          <div class="wishlist-item-price">$34.99</div>
        </div>
        <div class="wishlist-item-actions">
          <button class="btn-add-cart">Add to Cart</button>
          <button class="btn-remove">Remove</button>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-logo">
        <img src="/images/logo.png" alt="Logo" />
      </div>
      <div class="footer-column">
        <h3>Account</h3>
        <ul>
          <li><a href="#">My Account</a></li>
          <li><a href="#">Orders</a></li>
          <li><a href="#">Wishlist</a></li>
          <li><a href="#">Track Order</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Useful Links</h3>
        <ul>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Returns</a></li>
          <li><a href="#">Shipping Info</a></li>
          <li><a href="#">FAQs</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Help Center</h3>
        <ul>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Support</a></li>
          <li><a href="#">Terms & Conditions</a></li>
          <li><a href="#">Report Issue</a></li>
        </ul>
      </div>
    </div>
    <hr />
    <div class="footer-bottom">
      <p class="copyright">© 2025 Freshblink</p>
    </div>
  </footer>
<script src="/js/wishlist.js"></script>
</body>
</html>