<?php include 'start.php';

$pid = '';

if (!isset($_SESSION['username'])) {
  header('Location:sign_in_customer.php');
}

if (isset($_GET['msg'])) {
  $msg = $_GET['msg'];
  echo "<script>alert('" . $msg . "')</script>";
}
?>
<style>
  :root {
    --primary-color: #2e7d32;
    /* Dark green */
    --secondary-color: #43a047;
    /* Medium green */
    --accent-color: #81c784;
    /* Light green */
    --text-color: #1b5e20;
    /* Forest green */
    --light-bg: #e8f5e9;
    /* Very light green */
  }

  body {
    background-color: var(--light-bg);
    color: var(--text-color);
  }

  .fa-star {
    color: var(--accent-color);
    font-size: 1.2rem;
  }

  .review-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 0.5rem;
  }

  .review-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(46, 125, 50, 0.15);
  }

  .product-image {
    max-height: 150px;
    object-fit: contain;
    border-radius: 0.5rem;
    transition: transform 0.3s ease;
  }

  .product-image:hover {
    transform: scale(1.05);
  }

  .sidebar-card {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.15rem 1.75rem rgba(46, 125, 50, 0.15);
  }

  .list-group-item {
    border: none;
    padding: 1rem 1.25rem;
    transition: all 0.2s ease;
  }

  .list-group-item:hover {
    background-color: var(--light-bg);
    color: var(--primary-color);
  }

  .list-group-item.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
  }

  .btn-review {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
    transition: all 0.2s ease;
  }

  .btn-review:hover {
    background-color: #2e7d32;
    border-color: #2e7d32;
    transform: translateY(-1px);
  }

  .review-date {
    color: #558b2f;
    font-size: 0.875rem;
  }

  .shop-name {
    color: var(--primary-color);
    font-weight: 500;
  }
</style>

<?php include 'header.php' ?>

<div class="container-fluid py-4">
  <div class="row">
    <!-- Sidebar -->
    <aside class="col-lg-3 col-md-4 mb-4">
      <div class="card sidebar-card">
        <div class="card-header bg-white py-3">
          <h4 class="mb-0" style="color: var(--primary-color);">
            <i class="fas fa-user-circle mr-2" style="color: var(--primary-color); font-size: 1.5rem;"></i>My Account
          </h4>
        </div>
        <div class="list-group list-group-flush">
          <a href="customer_profile.php" class="list-group-item list-group-item-action">
            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
          </a>
          <a href="orders.php" class="list-group-item list-group-item-action">
            <i class="fas fa-shopping-bag mr-2"></i>Orders
          </a>
          <a href="reviews.php" class="list-group-item list-group-item-action" style="background-color: var(--primary-color); color: white;">
            <i class="fas fa-star mr-2" style="background: transparent;"></i>Product Reviews
          </a>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <section class="col-lg-9 col-md-8">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
          <h4 class="mb-0" style="color: var(--primary-color);">
            <i class="fas fa-star mr-2"></i>My Reviews
          </h4>
        </div>
        <div class="card-body">
          <?php
          include 'connection.php';
          $username = $_SESSION['username'];

          $sql1 = "SELECT * from customer where username= '$username'";
          $result1 = oci_parse($connection, $sql1);
          oci_execute($result1);

          while ($row = oci_fetch_assoc($result1)) {
            $cid = $row['CUSTOMER_ID'];
            $sql2 = " SELECT * FROM orders WHERE Customer_Id='$cid'";
            $result2 = oci_parse($connection, $sql2);
            oci_execute($result2);

            while ($row = oci_fetch_assoc($result2)) {
              include 'connection.php';
              $pid = $row['PRODUCT_ID'];
            }

            $sql3 = " SELECT * FROM review WHERE Customer_Id='$cid' and Product_Id='$pid'";
            $result3 = oci_parse($connection, $sql3);
            oci_execute($result3);

            $count2 = oci_fetch_all($result3, $connection);
            oci_execute($result3);

            if ($count2 == 0) {
              include 'connection.php';
              $sql4 = "SELECT * FROM orders INNER JOIN product ON orders.PRODUCT_ID=product.PRODUCT_ID inner join shop on shop.shop_id=product.shop_id WHERE Customer_Id='$cid'";
              $result4 = oci_parse($connection, $sql4);
              oci_execute($result4);

              while ($row = oci_fetch_assoc($result4)) {
                $productid = $row['PRODUCT_ID'];
                $odate = $row['ORDER_DATE'];
                $pname = $row['PRODUCT_NAME'];
                $pimage = $row['PRODUCT_IMAGE'];
                $sid = $row['SHOP_ID'];
                $sname = $row['SHOP_NAME'];
          ?>
                <div class="card mb-4 review-card">
                  <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                      <div class="col">
                        <strong class="review-date">
                          <i class="far fa-calendar-alt mr-2"></i>Purchased on: <?php echo htmlspecialchars($odate); ?>
                        </strong>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-md-3 text-center">
                        <img src="<?php echo htmlspecialchars($pimage); ?>"
                          alt="<?php echo htmlspecialchars($pname); ?>"
                          class="img-fluid product-image">
                      </div>
                      <div class="col-md-4">
                        <h6 class="mb-2 font-weight-bold"><?php echo htmlspecialchars($pname); ?></h6>
                        <p class="mb-0 text-muted">
                          <i class="fas fa-store mr-2"></i>
                          <span class="shop-name"><?php echo htmlspecialchars($sname); ?></span>
                        </p>
                      </div>
                      <div class="col-md-5 text-md-right mt-3 mt-md-0">
                        <a href="review_product.php?product_id=<?php echo htmlspecialchars($pid); ?>"
                          class="btn btn-review">
                          <i class="fas fa-pencil-alt mr-2"></i>Write Review
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
          <?php
              }
            }
          }
          ?>
          <div class="review-list" style="max-height: 600px; overflow-y: auto;">
            <?php
            include 'connection.php';
            $username = $_SESSION['username'];

            $sql1 = "SELECT * from customer where username= '$username'";
            $result1 = oci_parse($connection, $sql1);
            oci_execute($result1);

            while ($row = oci_fetch_assoc($result1)) {
              $cid = $row['CUSTOMER_ID'];
              $sql2 = " SELECT * FROM review WHERE Customer_Id='$cid'";
              $result2 = oci_parse($connection, $sql2);
              oci_execute($result2);

              while ($row = oci_fetch_assoc($result2)) {
                $rdate = $row['DATES'];
                $desc = $row['DESCRIPTION'];
                $rating2 = $row['RATING'];
                $rid = $row['REVIEW_ID'];
                $pid = $row['PRODUCT_ID'];

                $sql3 = " SELECT * FROM product WHERE Product_Id='$pid'";
                $result3 = oci_parse($connection, $sql3);
                oci_execute($result3);

                while ($row = oci_fetch_assoc($result3)) {
                  $pname = $row['PRODUCT_NAME'];
                  $sid = $row['SHOP_ID'];
                  $pimage = $row['PRODUCT_IMAGE'];

                  $sql4 = " SELECT * FROM shop WHERE Shop_Id='$sid'";
                  $result4 = oci_parse($connection, $sql4);
                  oci_execute($result4);

                  while ($row = oci_fetch_assoc($result4)) {
                    $sname = $row['SHOP_NAME'];
            ?>
                    <div class="card mb-4 review-card">
                      <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                          <div class="col">
                            <strong class="review-date">
                              <i class="far fa-calendar-alt mr-2"></i>Reviewed on: <?php echo htmlspecialchars($rdate); ?>
                            </strong>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="mb-3">
                              <img src="<?php echo htmlspecialchars($pimage); ?>"
                                alt="<?php echo htmlspecialchars($pname); ?>"
                                class="img-fluid product-image">
                            </div>
                            <h6 class="font-weight-bold"><?php echo htmlspecialchars($pname); ?></h6>
                          </div>
                          <div class="col-md-6">
                            <p class="mb-2">
                              <strong><i class="fas fa-store mr-2"></i>Sold by:</strong>
                              <span class="shop-name"><?php echo htmlspecialchars($sname); ?></span>
                            </p>
                            <div class="mb-3">
                              <?php include 'condition_checker/rating_conditional_2.php'; ?>
                            </div>
                            <div class="mb-3">
                              <strong><i class="fas fa-comment mr-2"></i>Your Review:</strong>
                              <p class="mb-0 mt-2"><?php echo htmlspecialchars($desc); ?></p>
                            </div>
                            <div class="text-success">
                              <small><i class="fas fa-check-circle mr-2"></i>Status: Approved</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            <?php
                  }
                }
              }
            }
            ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php include 'footer.php';
include 'end.php' ?>