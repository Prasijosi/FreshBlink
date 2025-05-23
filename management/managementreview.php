<?php
session_start();
include 'theader.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    echo "<script>alert('" . $msg . "');</script>";
} else {
    echo "";
}

if (isset($_POST['submit']) && isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    include('connection.php');
    $sql = " UPDATE review SET Review_Status= '1' where Product_Id='$pid' ";
    $qry = oci_parse($connection, $sql);
    oci_execute($qry);
    if ($qry) {
        header('Location:managementreview.php?msg=Review Approved');
        exit();
    } else {
        header('Location:managementreview.php?msg=Query Not Running');
        exit();
    }
} elseif (isset($_POST['submit2']) && isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    include('connection.php');
    $sql = " DELETE FROM review WHERE  Product_Id='$pid' ";
    $qry = oci_parse($connection, $sql);
    oci_execute($qry);
    if ($qry) {
        header('Location:managementreview.php?msg=Review Deleted');
        exit();
    } else {
        header('Location:managementreview.php?msg=Query Not Running');
        exit();
    }
}
?>
  <div class="container-fluid main-content">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-12 d-flex align-items-center">
              <?php
              include('connection.php');
              $sql = " SELECT * FROM  review, product,customer where review.Product_Id=product.Product_Id and review.Customer_Id=customer.Customer_ID and Review_Status='0' ";
              $qry = oci_parse($connection, $sql);
              oci_execute($qry);
              $count3 = oci_fetch_all($qry, $connection);
              oci_execute($qry);
              echo "<h5 class='mb-0'>New Review Requests: $count3</h5>";
              ?>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
            <tr class="bg-light">
              <th class="text-center" style="width: 5%">SN</th>
              <th class="text-center" style="width: 20%">Product</th>
              <th class="text-center" style="width: 15%">Image</th>
              <th class="text-center" style="width: 10%">Rating</th>
              <th class="text-center" style="width: 25%">Review</th>
              <th class="text-center" style="width: 15%">Reviewer</th>
              <th class="text-center" style="width: 10%">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include('connection.php');
            $sql = "SELECT * FROM  review, product, customer where review.Product_Id=product.Product_Id and review.Customer_Id=customer.Customer_ID and Review_Status='0'";
            $qry = oci_parse($connection, $sql);
            oci_execute($qry);
            $s = 0;
            while ($row = oci_fetch_assoc($qry)) {
                $pid = $row['PRODUCT_ID'];
                $pname = $row['PRODUCT_NAME'];
                $pimage = $row['PRODUCT_IMAGE'];
                $rating = $row['RATING'];
                $review = $row['DESCRIPTION'];
                $customer = $row['FULL_NAME'];
                $s = $s + 1;
                ?>
              <tr>
                <td class="text-center"><?php echo $s; ?></td>
                <td class="text-center fw-medium"><?php echo $pname; ?></td>
                <td class="text-center">
                  <img src="../<?php echo $pimage; ?>" class="product-image" alt="<?php echo $pname; ?>">
                </td>
                <td class="text-center">
                  <span class="badge bg-warning"><?php echo $rating; ?>/5</span>
                </td>
                <td class="text-center">
                  <div class="review-text"><?php echo $review; ?></div>
                </td>
                <td class="text-center">
                  <span class="badge bg-info"><?php echo $customer; ?></span>
                </td>
                <td class="text-center">
                  <form method="POST" action="managementreview.php" class="d-inline">
                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                    <button type="submit" class="btn btn-success btn-sm me-2" name="submit">Approve</button>
                    <button type="submit" class="btn btn-danger btn-sm" name="submit2">Decline</button>
                  </form>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <style>
      .main-content {
          padding: 2rem;
      }

      .card {
          border: none;
          border-radius: 10px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
      }

      .sort-select {
          min-width: 150px;
          height: 38px;
          border: 1px solid #e0e0e0;
          border-radius: 6px;
          padding: 0.4rem 0.8rem;
          font-size: 0.9rem;
          background-color: #fff;
          transition: all 0.2s ease;
      }

      .sort-select:focus {
          border-color: #4a90e2;
          box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.15);
      }

      .table {
          margin-bottom: 0;
      }

      .table thead th {
          border-bottom: 2px solid #e0e0e0;
          color: #333;
          font-weight: 600;
          font-size: 0.95rem;
          padding: 1rem;
          background-color: #f8f9fa;
      }

      .table tbody td {
          padding: 1rem;
          font-size: 0.95rem;
          border-bottom: 1px solid #e0e0e0;
      }

      .table tbody tr {
          transition: all 0.2s ease;
      }

      .table tbody tr:hover {
          background-color: #f8f9fa;
          transform: translateY(-1px);
      }

      .product-image {
          width: 80px;
          height: 80px;
          object-fit: cover;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .rating-stars {
          font-size: 1rem;
      }

      .review-text {
          max-width: 300px;
          margin: 0 auto;
          line-height: 1.4;
      }

      .btn-sm {
          padding: 0.5rem 1rem;
          font-size: 0.9rem;
          border-radius: 6px;
          transition: all 0.2s ease;
      }

      .btn-sm:hover {
          transform: translateY(-1px);
      }

      .badge {
          padding: 0.5rem 1rem;
          font-weight: 500;
          border-radius: 6px;
      }

      @media (max-width: 768px) {
          .main-content {
              padding: 1rem;
          }

          .sort-select, .btn {
              width: 100%;
              margin-bottom: 0.5rem;
          }

          form.d-flex {
              flex-direction: column;
              gap: 0.5rem;
          }

          .product-image {
              width: 60px;
              height: 60px;
          }

          .review-text {
              max-width: 200px;
          }
      }
  </style>

<?php include 'tfooter.php'; ?>