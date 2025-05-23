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
        <div class="row mb-3">
          <div class="col-md-6 d-flex align-items-center">
              <?php
              include('connection.php');
              $sql = " SELECT * FROM  review, product,customer where review.Product_Id=product.Product_Id and review.Customer_Id=customer.Customer_ID and Review_Status='0' ";
              $qry = oci_parse($connection, $sql);
              oci_execute($qry);
              $count3 = oci_fetch_all($qry, $connection);
              oci_execute($qry);
              echo "<h5 class='mb-0'>New Review Request : [ $count3 ]</h5>";
              ?>
          </div>

          <div class="col-md-6">
            <form action="#" method="GET" class="d-flex justify-content-end align-items-center">
              <span class="me-2">Sort By:</span>
              <select name="category" class="form-select sort-select me-2" style="width: auto;">
                <option value="recent">Recent</option>
              </select>
              <button type="submit" class="btn btn-dark btn-sm">Go</button>
            </form>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="bg-light">
              <th>SN</th>
              <th>Product Name</th>
              <th>Product Image</th>
              <th>Rating</th>
              <th>Review</th>
              <th>Reviewer</th>
              <th>Actions</th>
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
                <td class="text-center"><?php echo $pname; ?></td>
                <td class="text-center"><img src="../<?php echo $pimage; ?>" class="img-fluid" style="width: 10vw;">
                </td>
                <td class="text-center"><?php echo $rating; ?></td>
                <td class="text-center"><?php echo $review; ?></td>
                <td class="text-center"><?php echo $customer; ?></td>
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
      .sort-select {
          min-width: 150px;
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

      .table {
          margin-bottom: 0;
      }

      .table thead th {
          border-bottom: 2px solid #dee2e6;
          color: #495057;
          font-weight: 600;
          font-size: 0.95rem;
          padding: 1rem;
      }

      .table tbody td {
          vertical-align: middle;
          padding: 1rem;
          font-size: 0.95rem;
      }

      .table tbody tr {
          transition: all 0.2s ease;
      }

      .table tbody tr:hover {
          background-color: #f8f9fa;
      }

      .btn-sm {
          padding: 0.4rem 0.8rem;
          font-size: 0.85rem;
      }

      @media (max-width: 576px) {
          .sort-select, .btn {
              width: 100%;
              margin-bottom: 0.5rem;
          }

          form.d-flex {
              flex-direction: column;
              gap: 0.5rem;
          }
      }
  </style>

<?php include 'tfooter.php'; ?>