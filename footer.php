<style>
    .footer {
        background-color: white;
        padding: 2rem 1rem;
    }

    .footer-logo {
        height: 50px;
    }

    .footer-text {
        color: #4BB543;
        font-size: 1.3rem;
        font-weight: bold;
    }

    .footer-links a {
        text-decoration: none;
        color: #343a40;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }

    .footer-heading {
        font-weight: bold;
        margin-bottom: 1rem;
    }

    @media (max-width: 576px) {
        .footer-logo {
            height: 40px;
        }

        .footer-text {
            font-size: 1.1rem;
        }
    }
</style>

<footer class="footer">
  <div class="container-fluid">
    <div class="row text-center text-md-left">
      <!-- Logo -->
      <div class="col-12 col-md-3 mb-4 d-flex flex-column align-items-center align-items-md-start">
        <img src="images/logo.png" alt="FreshBlink" class="footer-logo mb-2">
      </div>

      <!-- Account -->
      <div class="col-12 col-md-3 mb-4 footer-links">
        <h5 class="footer-heading">Account</h5>
        <ul class="list-unstyled">
          <li><a href="#">Wishlist</a></li>
          <li><a href="cart.php">Cart</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">Shipping Details</a></li>
        </ul>
      </div>

      <!-- Useful Links -->
      <div class="col-12 col-md-3 mb-4 footer-links">
        <h5 class="footer-heading">Useful Links</h5>
        <ul class="list-unstyled">
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Hot Deals</a></li>
          <li><a href="#">Promotions</a></li>
          <li><a href="#">New Product</a></li>
        </ul>
      </div>

      <!-- Help Center -->
      <div class="col-12 col-md-3 mb-4 footer-links">
        <h5 class="footer-heading">Help Center</h5>
        <ul class="list-unstyled">
          <li><a href="#">Payment</a></li>
          <li><a href="#">Refund</a></li>
          <li><a href="#">Checkout</a></li>
          <li><a href="#">Q&A</a></li>
          <li><a href="#">Shipping</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
    </div>

    <hr>

    <div class="row text-center text-md-left align-items-center">
      <div class="col-12 col-md-4 mb-2 mb-md-0">
        <span class="text-dark">&copy; 2025, All rights reserved</span>
      </div>
      <div class="col-12 col-md-4 mb-2 mb-md-0 text-center">
        <img src="images/paypal.webp" alt="PayPal" style="height:38px;">
      </div>
    </div>
  </div>
</footer>
