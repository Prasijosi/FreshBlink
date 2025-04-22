<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Traders Page</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="logo">LOGO</div>
    <div class="search-box">
      <input type="text" placeholder="Search">
      <button><span class="material-icons">search</span></button>
    </div>
    <div class="nav-actions">
      <a href="#"><span class="material-icons">favorite_border</span> Saved</a>
      <a href="#"><span class="material-icons">shopping_cart</span> Cart</a>
      <a href="#">Register</a>
      <button class="login-btn">Login</button>
    </div>
  </div>

  <!-- Category Menu -->
  <div class="category-menu">
    <a href="#">Bakery</a>
    <a href="#">Butchery</a>
    <a href="#">Greengrocer</a>
    <a href="#">Delicatessen</a>
    <a href="#">Fishmonger</a>
  </div>

  <!-- Title -->
  <h1 class="page-title">Traders</h1>

  <!-- Product Grid -->
  <div class="product-grid" id="grid"></div>

  <script src="script.js"></script>
</body>
</html>