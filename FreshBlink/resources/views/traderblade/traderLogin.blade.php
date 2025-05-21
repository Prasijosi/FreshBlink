<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register Trader - FreshBlink</title>

  <link rel="stylesheet" href="css/traderregister.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

  <!-- ========== NAVBAR ========== -->
  <div class="navbar">
    <div class="logo">
      <a href="#"><img src="images/logo2.png" alt="FreshBlink Logo"></a>
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

  <!-- ========== BREADCRUMB ========== -->
  <div class="bottom-bar">
    <span>Register Trader</span>
    <span class="breadcrumb">Register Trader &gt; Home</span>
  </div>

  <!-- ========== MAIN CONTENT ========== -->
  <div class="form-container">
    <h2>Trader Registration Form</h2>
    <form id="trader-form">
      <label for="fullname">Full Name:</label>
      <input type="text" id="fullname" name="fullname" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>

      <label for="trader-type">Select your trader type:</label>
      <select id="trader-type" name="trader-type" required>
        <!--Js will populate this-->
      </select>

      <label for="phone">Phone Number (optional):</label>
      <input type="tel" id="phone" name="phone">

      <button type="submit" class="submit-btn">Register</button>
    </form>
  </div>

  <!-- ========== FOOTER ========== -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-logo">
        <img src="images/logo2.png" alt="FreshBlink Logo" />
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
      <img src="images/paypal.webp" alt="PayPal" />
    </div>
  </footer>

  <script src="js/traderregister.js"></script>
</body>
</html>
