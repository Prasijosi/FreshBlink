<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ratings & Reviews - FreshBlink</title>
  <link rel="stylesheet" href="rating.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

  <!-- NAVBAR -->
  @guest
  {{-- Show this if the user is NOT logged in --}}
  @include('components.navbar')
  @endguest

  @auth
  {{-- Show this if the user IS logged in --}}
  @include('userblade.loggedin')
  @endauth


  <!-- BREADCRUMB -->
  <section class="bottom-bar">
    <span>Ratings & Reviews</span>
    <span class="breadcrumb">Home &gt; Ratings & Reviews</span>
  </section>

  <!-- MAIN CONTENT -->
  <main class="review-container">
    <h2>Leave a Review</h2>
    <form id="review-form">
      <label for="username">Your Name:</label>
      <input type="text" id="username" placeholder="John Doe" required>

      <label for="rating">Rating:</label>
      <div class="star-rating" id="star-rating">
        <span class="material-icons star" data-value="1">star_border</span>
        <span class="material-icons star" data-value="2">star_border</span>
        <span class="material-icons star" data-value="3">star_border</span>
        <span class="material-icons star" data-value="4">star_border</span>
        <span class="material-icons star" data-value="5">star_border</span>
      </div>
      <input type="hidden" id="rating" value="0">

      <label for="comment">Your Comment:</label>
      <textarea id="comment" rows="4" placeholder="Share your experience..." required></textarea>

      <div class="validation">
        <p id="name-error" class="error-msg"></p>
        <p id="rating-error" class="error-msg"></p>
        <p id="comment-error" class="error-msg"></p>
      </div>

      <button type="submit" class="submit-btn">Submit Review</button>
    </form>

    <!-- Controls -->
    <div class="sort-controls">
      <div class="sort-group">
        <label for="sort">Sort by:</label>
        <select id="sort">
          <option value="latest">Latest</option>
          <option value="rating">Rating (High → Low)</option>
        </select>
      </div>
    </div>

    <h3>Recent Reviews</h3>
    <div id="review-list" class="review-list"></div>
    <button id="load-more" class="submit-btn" style="margin-top: 1rem; display: none;">Load More Reviews</button>

  </main>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-logo">
        <img src="/images/logo2.png" alt="FreshBlink Logo" />
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
      <p>&copy; 2025 FreshBlink. All rights reserved.</p>
    </div>
    <div class="footer-bottom">
      <img src="/images/paypal.webp" alt="PayPal" />
    </div>
  </footer>

  <script src="/js/rating.js"></script>
</body>

</html>