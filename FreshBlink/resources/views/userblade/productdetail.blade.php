<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Detail</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/css/productdetail.css">
</head>

<body>

  @guest
  {{-- Show this if the user is NOT logged in --}}
  @include('components.navbar')
  @endguest

  @auth
  {{-- Show this if the user IS logged in --}}
  @include('userblade.loggedin')
  @endauth

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h3>Product Category</h3>
      <ul>
        <li><input type="checkbox"> Bakery</li>
        <li><input type="checkbox"> Butchery</li>
        <li><input type="checkbox"> Greengrocers</li>
        <li><input type="checkbox"> Delicatessen</li>
        <li><input type="checkbox"> Fishmonger</li>
      </ul>

      <hr>
      <label>Filter by price</label>
      <input type="range" min="20" max="250">
      <button class="filter-btn">Filter</button>

      <hr>
      <label>Weight</label>
      <ul>
        <li><input type="checkbox"> 1kg</li>
        <li><input type="checkbox"> 2kg</li>
        <li><input type="checkbox"> 5kg</li>
        <li><input type="checkbox"> 10kg</li>
        <li><input type="checkbox"> 15kg</li>
      </ul>

      <hr>
    </aside>

    <!-- Product Content -->
    <main class="product-detail">
      <div class="product-main">
        <div class="product-left">
          <div class="product-image"></div>
          <div class="thumbnails">
            <div class="thumb"></div>
            <div class="thumb"></div>
            <div class="thumb"></div>
          </div>
        </div>

        <div class="product-info">
          <h2>Product Name</h2>
          <p><strong>Sold By:</strong> {Freshblink}</p>

          <label>Description:</label>
          <p class="product-description">
            This is a high-quality product sourced fresh from our local vendors. Perfect for your daily needs!
          </p>


          <p class="price">
            $12.69 <span class="old-price">$15.88</span>
          </p>

          <label>Size / Weight:</label>
          <div class="size-buttons">
            <button>1</button>
            <button>2</button>
            <button>4</button>
            <button>8</button>
            <button>12</button>
          </div>

          <div class="cart-controls">
            <button id="decrease">-</button>
            <input type="text" id="quantity" value="1" readonly>
            <button id="increase">+</button>
            <button class="add-to-cart">Add to cart</button>
          </div>


          <p class="availability">Availability: <strong>In stock</strong></p>
        </div>
      </div>


      <!-- Reviews -->
      <div class="review-card">
        <div class="review">
          <div class="review-header">
            <img src="user.png" alt="Profile" class="profile-icon">
            <p><strong>Customer name</strong></p>
          </div>
          <div class="stars">☆☆☆☆☆</div>
          <input type="text" placeholder="Review">
        </div>
      </div>


      <div class="review-card">
        <div class="review">
          <div class="review-header">
            <img src="user.png" alt="Profile" class="profile-icon">
            <p><strong>Customer name</strong></p>
          </div>
          <div class="stars">☆☆☆☆☆</div>
          <input type="text" placeholder="Review">
        </div>
      </div>


      <div class="review-card">
        <div class="review">
          <div class="review-header">
            <img src="user.png" alt="Profile" class="profile-icon">
            <p><strong>Customer name</strong></p>
          </div>
          <div class="stars">☆☆☆☆☆</div>
          <input type="text" placeholder="Review">
        </div>
      </div>


      <script src="/js/pd.js"></script>
</body>

</html>