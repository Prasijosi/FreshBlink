<?php
$c = 0;
if (isset($_SESSION['cart'])) {
  $c = count($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 4.0 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .navbar {
      padding: 1rem 0;
      background: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .navbar-brand img {
      height: 40px;
    }

    .search-form {
      position: relative;
      max-width: 600px;
      margin: 0 auto;
      width: 100%;
    }

    .search-form .form-control {
      border-radius: 25px;
      padding: 0.75rem 1.5rem;
      padding-right: 3.5rem;
      border: 1px solid #e0e0e0;
      font-size: 1.1rem;
      height: auto;
    }

    .search-form .btn {
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      border-radius: 20px;
      padding: 0.5rem 1.5rem;
      font-size: 1.1rem;
    }

    .nav-link {
      color: #333;
      font-weight: 500;
      padding: 0.5rem 1rem;
      transition: color 0.3s ease;
    }

    .nav-link:hover {
      color: #28a745;
    }

    .cart-icon {
      position: relative;
      font-size: 1.3rem;
    }

    .cart-badge {
      position: absolute;
      top: -8px;
      right: -8px;
      background: #28a745;
      color: white;
      border-radius: 50%;
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    .dropdown-item {
      padding: 0.5rem 1.5rem;
      color: #333;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
      color: #28a745;
    }

    .btn-login {
      background: #28a745;
      color: white;
      border-radius: 20px;
      padding: 0.5rem 1.5rem;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background: #218838;
      color: white;
      transform: translateY(-1px);
    }

    @media (max-width: 768px) {
      .search-form {
        margin: 1rem 0;
      }

      .navbar-nav {
        margin-top: 1rem;
      }
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="FreshBlink" class="img-fluid">
      </a>

      <!-- Mobile Toggle Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Content -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <!-- Search Form -->
        <form action="search_product.php" method="POST" class="search-form mx-auto">
          <input type="text" name="search_Txt" class="form-control" placeholder="Search products...">
          <button class="btn btn-success" type="submit" name="submit_search">
            <i class="fas fa-search" style="background-color: #28a745; color: white;"></i>
          </button>
        </form>

        <!-- Right Side Navigation -->
        <ul class="navbar-nav ml-auto align-items-center">
          <!-- Cart -->
          <li class="nav-item">
            <a href="cart.php" class="nav-link">
              <i class="fas fa-shopping-cart cart-icon"></i>
              <?php if ($c > 0): ?>
                <span class="cart-badge"><?php echo $c; ?></span>
              <?php endif; ?>
              <span class="d-none d-md-inline ml-1">Cart</span>
            </a>
          </li>

          <?php if (!isset($_SESSION['username'])): ?>
            <!-- Register/Login -->
            <li class="nav-item">
              <a href="sign_up_customer.php" class="nav-link d-none d-md-inline">Register</a>
            </li>
            <li class="nav-item">
              <a href="sign_in_customer.php" class="btn btn-login">Login</a>
            </li>
          <?php else: ?>
            <!-- User Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle mr-1"></i>
                <?php echo ucfirst($_SESSION['username']); ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="customer_profile.php">
                  <i class="fas fa-user mr-2"></i>My Profile
                </a>
                <a class="dropdown-item" href="orders.php">
                  <i class="fas fa-shopping-bag mr-2"></i>My Orders
                </a>
                <a class="dropdown-item" href="reviews.php">
                  <i class="fas fa-star mr-2"></i>My Reviews
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="session_destroy.php">
                  <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                </a>
              </div>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>