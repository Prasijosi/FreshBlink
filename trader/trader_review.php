<?php include '../start.php' ?>
<?php
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}
?>

  <style>
      .review-card {
          border: 1px solid #dee2e6;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
          transition: all 0.3s ease;
          margin-bottom: 1.5rem;
      }

      .review-card:hover {
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .fa-star {
          color: #ffc107;
          font-size: 1.2rem;
      }

      .review-header {
          background-color: #f8f9fa;
          border-bottom: 1px solid #dee2e6;
          padding: 1.25rem;
          border-radius: 8px 8px 0 0;
      }

      .review-content {
          padding: 1.5rem;
      }

      .product-image {
          width: 130px;
          height: 130px;
          object-fit: cover;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .reply-input {
          resize: none;
          border: 1px solid #dee2e6;
          border-radius: 4px;
          padding: 0.75rem;
          font-size: 0.95rem;
          transition: all 0.2s ease;
      }

      .reply-input:focus {
          border-color: #80bdff;
          box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
      }

      .sort-select {
          min-width: 120px;
          height: 32px;
          border: 1px solid #dee2e6;
          border-radius: 4px;
          padding: 0.3rem 0.5rem;
          font-size: 0.85rem;
          background-color: #fff;
          box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
      }

      .sort-select:focus {
          border-color: #80bdff;
          box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, .25);
      }

      form .btn.btn-dark {
          padding: 0.3rem 0.8rem;
          font-size: 0.85rem;
          height: 32px;
          line-height: 1.2;
      }

      @media (max-width: 576px) {
          .sort-select, form .btn {
              width: 100%;
          }

          form.d-flex {
              flex-direction: column;
              gap: 0.5rem;
          }
      }

      .review-date {
          font-size: 0.9rem;
          color: #6c757d;
      }

      .review-text {
          font-size: 1rem;
          line-height: 1.5;
          color: #212529;
      }

      .product-name {
          font-weight: 500;
          color: #495057;
          margin-bottom: 0.5rem;
      }

      .reply-btn {
          padding: 0.5rem 1rem;
          font-size: 0.95rem;
          transition: all 0.2s ease;
      }

      .reply-btn:hover {
          transform: translateY(-1px);
      }

      .rating-container {
          display: flex;
          align-items: center;
          gap: 0.5rem;
      }

      .table-container {
          background: #fff;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
          padding: 1.5rem;
      }
  </style>

<?php include 'theader.php'; ?>

  <div class="container mt-4">
    <div class="row mb-4">
      <div class="col-12">
        <h3 class="mb-4">Customer Reviews</h3>

        <div class="table-container">
          <form method="POST" action="#" class="d-flex align-items-center">
            <span class="me-2">Sort By: </span>
            <select id="sort" class="sort-select me-2" name="cat">
              <option
                value="DESC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "DESC") ? 'selected="selected"' : ''; ?>>
                Recent reviews
              </option>
              <option
                value="ASC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "ASC") ? 'selected="selected"' : ''; ?>>
                Old reviews
              </option>
            </select>
            <button class="btn btn-dark btn-sm">Go</button>
          </form>
        </div>
      </div>
    </div>

      <?php
      include('connection.php');

      $tn = $_SESSION['trader_username'];

      $sql = "SELECT * FROM trader where Username='$tn'";
      $qry = oci_parse($connection, $sql);
      oci_execute($qry);

      while ($row = oci_fetch_assoc($qry)) {
          $tid = $row['TRADER_ID'];

          if (isset($_POST['cat'])) {
              $c = $_POST['cat'];
              $s = ($c == "DESC") ? "DESC" : (($c == "ASC") ? "ASC" : "");

              $sql1 = "SELECT * FROM review, product, shop WHERE shop.Shop_Id=product.Shop_Id AND review.Product_Id=product.Product_Id AND shop.Trader_id='$tid' ORDER BY Dates $s";
          } else {
              $sql1 = "SELECT * FROM review, product, shop WHERE shop.Shop_Id=product.Shop_Id AND review.Product_Id=product.Product_Id AND shop.Trader_id='$tid'";
          }

          $qry1 = oci_parse($connection, $sql1);
          oci_execute($qry1);

          while ($row = oci_fetch_assoc($qry1)) {
              $pname = $row['PRODUCT_NAME'];
              $rating2 = $row['RATING'];
              $review = $row['DESCRIPTION'];
              $rdate = $row['DATES'];
              $pimage = $row['PRODUCT_IMAGE'];
              ?>
            <div class="review-card">
              <div class="review-header">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="rating-container">
                      <?php include '../condition_checker/rating_conditional_2.php'; ?>
                  </div>
                  <span class="review-date"><?php echo $rdate; ?></span>
                </div>
              </div>

              <div class="review-content">
                <div class="row">
                  <div class="col-md-8">
                    <p class="review-text mb-4"><?php echo $review; ?></p>
                  </div>
                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-body">
                        <img src="../<?php echo $pimage; ?>" class="product-image mb-3" alt="Product Image">
                        <h5 class="product-name"><?php echo $pname; ?></h5>
                        <div class="form-group">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <?php
          }
      }
      ?>
  </div>

<?php include '../end.php'; ?>