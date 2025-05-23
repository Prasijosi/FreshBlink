<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Management</title>

  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <!-- External CSS and JS -->

  <!-- CSS for navbar -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

<div class="container">

  <nav class="navbar navbar-expand-md navbar-light bg-light">
    <a href="#" class="navbar-brand">
      <img src="../images/logo.png" height="58" alt="companylogo">
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav">
        <a href="http://localhost:8080/apex/" class="nav-item nav-link">Dashboard</a>
        <a href="managementseler.php" class="nav-item nav-link">New Shop/Trader Request</a>
        <a href="management.php" class="nav-item nav-link">New Products Request</a>
        <a href="managementpwr.php" class="nav-item nav-link">Products Enable/Disable</a>

        <a href="managementreview.php" class="nav-item nav-link">Reviews</a>
      </div>
      <div class="navbar-nav ml-auto">
          <?php
          if (!isset($_SESSION['admin_username'])) {
              echo "<a href='../trader/sign_in_trader.php'><span class='ml-2'>Sign In</span></a>";
          } else {
              @$username = ucfirst($_SESSION['admin_username']);
              echo "<div class='dropdown'>
							<button class='btn btn-seondary dropdown-toggle' type='button' style='border:none;' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							  <a href='customer_profile.php'><span class='ml-2'> Welcome, " . $username . "</span></a>
							</button>
							<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
							  <a class='dropdown-item' href='managementseler.php'>New Shop Request</a>
							  <a class='dropdown-item' href='management.php'>New Products Request</a>
							  <a class='dropdown-item' href='managementpwr.php'>Products Enable/Disable</a>
							  <a class='dropdown-item' href='managementreview.php'>Reviews</a>
							  <a class='dropdown-item' href='session_destroy.php'>Log Out</a>
							</div>
					  </div>";
          }
          ?>
      </div>
    </div>
  </nav>