<?php
ob_start();
@include 'start.php';
include 'connection.php';
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = "select * from product,shop where product_id = '$product_id' and product.shop_id = shop.shop_id";

    $result = oci_parse($connection, $query);
    oci_execute($result);

    while ($row = oci_fetch_assoc($result)) {
        $product_type = $row['PRODUCT_TYPE'];
        $product_name = $row['PRODUCT_NAME'];
        $product_price = $row['PRODUCT_PRICE'];
        $product_details = $row['PRODUCT_DETAILS'];
        $stock = $row['STOCK'];
        $product_image = $row['PRODUCT_IMAGE'];
        $shop_id = $row['SHOP_ID'];
        $shop_name = $row['SHOP_NAME'];
    }
} else {
    header('Location:index.php');
    exit();
}
?>

<?php
include 'connection.php';
$product_id = $_GET['product_id'];
$query = "SELECT *
FROM (
    SELECT r.*, c.Full_Name as Customer_Name
    FROM review r, customer c
    WHERE r.Customer_Id = c.Customer_Id
      AND Product_Id = :pid
)
WHERE ROWNUM <= 3
";
$statement = oci_parse($connection, $query);
oci_bind_by_name($statement, ':pid', $product_id);
oci_execute($statement);
?>

  <style>
      .product-container {
          background: #ffffff;
          border-radius: 15px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
          padding: 2rem;
          margin: 2rem 0;
      }

      .product-image {
          width: 100%;
          max-width: 500px;
          border-radius: 12px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
      }

      .product-image:hover {
          transform: scale(1.02);
      }

      .product-details {
          height: auto !important;
          min-height: 150px;
          resize: none;
          border: 1px solid #e0e0e0;
          background-color: #f8f9fa;
          padding: 15px;
          border-radius: 10px;
          font-size: 0.95rem;
          line-height: 1.6;
      }

      .fa-star {
          color: #ffc107;
          font-size: 1.2rem;
          margin-right: 2px;
      }

      .section-title {
          font-weight: 600;
          color: #2c3e50;
          margin-bottom: 1.2rem;
          padding-bottom: 0.5rem;
          border-bottom: 2px solid #e9ecef;
      }

      .info-box {
          background: #f8f9fa;
          border-radius: 10px;
          padding: 1rem;
          margin-bottom: 1rem;
          border: 1px solid #e9ecef;
      }

      .info-label {
          font-weight: 600;
          color: #495057;
          margin-bottom: 0.3rem;
      }

      .info-value {
          color: #212529;
      }

      .review-section {
          background: #ffffff;
          border-radius: 15px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
          padding: 2rem;
          margin-top: 2rem;
      }

      .review-card {
          background: #f8f9fa;
          border: 1px solid #e9ecef;
          border-radius: 8px;
          padding: 1.2rem;
          margin-bottom: 1rem;
      }

      .review-card:last-child {
          margin-bottom: 0;
      }

      .review-header {
          background: #f8f9fa;
          color: #2c3e50;
          font-weight: 600;
          padding: 1rem;
          border-radius: 8px;
          margin-bottom: 1.5rem;
          border-bottom: 2px solid #e9ecef;
      }

      .user-icon {
          width: 35px;
          height: 35px;
          background: #e9ecef;
          border-radius: 50%;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          margin-right: 10px;
          color: #6c757d;
      }

      .review-text {
          margin-top: 0.8rem;
          padding: 0.8rem;
          background: #ffffff;
          border-radius: 6px;
          margin-top: 1rem;
          padding: 1rem;
          background: #f8f9fa;
          border-radius: 8px;
          font-size: 0.95rem;
          line-height: 1.6;
      }

      .quantity-input {
          width: 100px !important;
          text-align: center;
      }

      .btn-add-cart {
          padding: 0.8rem 2rem;
          font-weight: 600;
          border-radius: 8px;
          transition: all 0.3s ease;
      }

      .btn-add-cart:hover {
          transform: translateY(-2px);
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .seller-link {
          color: #28a745;
          text-decoration: none;
          transition: color 0.3s ease;
      }

      .seller-link:hover {
          color: #218838;
          text-decoration: underline;
      }
  </style>

<?php include 'header.php'; ?>

  <div class="">

      <?php if (isset($_POST['addtoCart'])) {
          $qty = $_POST['quantity'];
          if (!isset($_SESSION['username'])) {
              echo "
			<div class='alert alert-warning alert-dismissible fade show' role='alert'>
				Please <a href='sign_in_customer.php' class='alert-link'>Sign-In</a> to place an Order!
				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
			</div>";
          }
      } ?>

    <form action="manage_cart.php" method="POST" class="product-container">
      <div class="row g-4">
        <div class="col-md-6 text-center">
          <img src="<?php echo $product_image; ?>" class="product-image img-fluid" alt="<?php echo $product_name; ?>">
        </div>
        <div class="col-md-6">
          <h2 class="mb-4"><?php echo $product_name; ?></h2>

          <div class="info-box">
            <h5 class="section-title">Rating</h5>
            <div class="mb-3"><?php include 'condition_checker/rating_conditional.php'; ?></div>
          </div>

          <div class="info-box">
            <h5 class="section-title">Seller Information</h5>
            <p class="mb-2">
              <strong>Sold by:</strong>
              <a href="search_product.php?search_Cat=<?php echo $shop_name; ?>" class="seller-link">
                  <?php echo $shop_name; ?>
              </a>
            </p>
            <p>
              <a href="search_product.php?search_Cat=<?php echo $shop_name; ?>" class="seller-link">
                View more from this seller
              </a>
            </p>
          </div>

          <div class="info-box">
            <h5 class="section-title">Product Details</h5>
            <textarea class="form-control product-details" disabled><?php echo $product_details; ?></textarea>
          </div>

          <div class="info-box">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="info-label">Price</div>
                <div class="info-value h4 text-success"><?php echo $product_price; ?></div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Availability</div>
                <div
                  class="info-value h5 <?php echo ($stock == 0 || $stock == "Out of Stock") ? 'text-danger' : 'text-success'; ?>">
                    <?php echo ($stock == 0 || $stock == "Out of Stock") ? "Out of Stock" : $stock; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="info-box">
            <label class="info-label">Quantity</label>
            <input type="number" name="quantity" class="form-control quantity-input" value="1" min="1"
                   max="<?php echo $stock; ?>" required>
          </div>

            <?php if ($stock > 0) { ?>
              <button type="submit" name="addtoCart" class="btn btn-success btn-add-cart">
                <i></i>Add to Cart
              </button>
            <?php } ?>

          <!-- Hidden Fields -->
            <?php foreach (['itemname' => $product_name, 'itemprice' => $product_price, 'itemimage' => $product_image, 'pid' => $product_id, 'stock' => $stock] as $name => $value): ?>
              <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
            <?php endforeach; ?>
        </div>
      </div>
    </form>

    <div class="row">
      <div class="col-12 col-md-8">
        <div class="review-section">
          <h3 class="section-title">Customer Reviews</h3>
            <?php
            $hasReviews = false;
            while ($row = oci_fetch_assoc($statement)) {
                $hasReviews = true;
                $name = htmlspecialchars($row['CUSTOMER_NAME']);
                $rating = (int)$row['RATING'];
                $review = htmlspecialchars($row['DESCRIPTION']);

                echo '<div class="review-card">';
                echo '  <div class="d-flex align-items-center mb-3">';
                echo '    <div class="user-icon"><i class="fas fa-user"></i></div>';
                echo '    <div><strong>' . $name . '</strong></div>';
                echo '  </div>';
                echo '  <div class="mb-3">';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        echo '<i class="fas fa-star"></i>';
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                }
                echo '  </div>';
                echo '  <div class="review-text">' . $review . '</div>';
                echo '</div>';
            }

            if (!$hasReviews) {
                echo '<div class="text-center p-4 bg-light rounded">';
                echo '  <i class="far fa-comment-dots fa-3x mb-3 text-muted"></i>';
                echo '  <p class="text-muted">No reviews available for this product.</p>';
                echo '</div>';
            }
            ?>
        </div>
      </div>

      <div class="col-12 col-md-4">
          <?php include 'review_product.php'; ?>
      </div>
    </div>
  </div>

<?php
include 'footer.php';
include 'end.php';
ob_end_flush();
?>