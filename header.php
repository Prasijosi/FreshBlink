<?php
$c = 0;
if (isset($_SESSION['cart'])) {
    $c = count($_SESSION['cart']);
}
?>

<header class="py-2 bg-white border-bottom shadow-sm">
    <div class="container-fluid">
        <div class="row align-items-center">
            <!-- Logo -->
           <!-- Logo -->
<div class="col-12 col-md-2 d-flex justify-content-center justify-content-md-start align-items-center mb-2 mb-md-0">
    <a href="index.php" class="d-flex align-items-center text-decoration-none">
        <img src="images/logo.png" alt="FreshBlink" style="height:40px;">
    </a>
</div>


            <!-- Search Bar -->
            <div class="col-12 col-md-6 my-2 my-md-0">
                <form action="search_product.php" method="POST">
                    <div class="input-group">
                        <input type="text" name="search_Txt" class="form-control border" placeholder="Search products">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" name="submit_search">
                                <i class="fas fa-search text-white"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Icons and Auth -->
            <div class="col-6 col-md-4 d-flex justify-content-end align-items-center">
                <a href="cart.php" class="d-flex align-items-center text-dark mx-2 text-decoration-none">
                    <i class="fas fa-shopping-cart" style="font-size:1.3rem;"></i>
                    <span class="ml-1 d-none d-md-inline">Cart<?php if ($c > 0) echo " ($c)"; ?></span>
                </a>

                <?php if (!isset($_SESSION['username'])): ?>
                    <a href="sign_up_customer.php" class="text-dark mx-2 d-none d-md-inline text-decoration-none">Register</a>
                    <a href="sign_in_customer.php" class="btn btn-success ml-2 px-3 py-1">Login</a>
                <?php else: ?>
                    <div class="dropdown mx-2">
                        <button class="btn btn-link dropdown-toggle text-dark p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>Welcome, <?php echo ucfirst($_SESSION['username']); ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="customer_profile.php">My Profile</a>
                            <a class="dropdown-item" href="orders.php">My Orders</a>
                            <a class="dropdown-item" href="reviews.php">My Reviews</a>
                            <a class="dropdown-item" href="session_destroy.php">Log Out</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
