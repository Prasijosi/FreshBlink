<div class="container">
  <style type="text/css">
      a {
          color: black;
      }
  </style>
  <nav class="navbar navbar-expand-md navbar-light bg-light">
    <a href="index.php" class="navbar-brand">
      <img src="../images/logo.png" height="58" alt="companylogo">
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav">
        <a href="http://localhost:8080/apex/f?p=103:LOGIN_DESKTOP:15070506401462:::::" class="nav-item nav-link ">Dashboard</a>
        <a href="trader_crud.php" class="nav-item nav-link">Products</a>
        <a href="trader_shop.php" class="nav-item nav-link">Shop</a>
        <a href="trader_order.php" class="nav-item nav-link">Orders</a>
        <a href="trader_review.php" class="nav-item nav-link">Reviews</a>
      </div>
      <div class="navbar-nav ml-auto">
          <?php
          if (!isset($_SESSION['trader_username'])) {
              echo "<a href='sign_in_trader.php'><span class='ml-2'>Sign In</span></a>";
          } else {
              @$username = ucfirst($_SESSION['trader_username']);
              echo "<div class='dropdown'>
							<button class='btn btn-seondary dropdown-toggle' type='button' style='border:none;' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							  <a href='index.php'><span class='ml-2'> Welcome, " . $username . "</span></a>
							</button>
							<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
							  <a class='dropdown-item' href='index.php'>My Profile</a>
							  <a class='dropdown-item' href='trader_order.php'>Orders</a>
							  <a class='dropdown-item' href='trader_review.php'>Reviews</a>
							  <a class='dropdown-item' href='session_destroy.php'>Log Out</a>
							</div>
					  </div>";
          }
          ?>

      </div>
    </div>
  </nav>

  </body>

  </html>