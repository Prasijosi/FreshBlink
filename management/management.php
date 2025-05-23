<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header('Location:../trader/sign_in_trader.php');
    exit();
}

include 'theader.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    echo "<script>alert('" . $msg . "');</script>";
} else {
    echo "";
}

?>
  <div class="container-fluid main-content">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-12 d-flex align-items-center">
              <?php
              include 'connection.php';

              $sql = " SELECT * FROM  product, shop, trader where trader.Trader_Id=shop.Trader_id  and shop.Shop_Id=product.Shop_Id  and product.Product_Verification='0'";
              $qry = oci_parse($connection, $sql);
              oci_execute($qry);

              $count3 = oci_fetch_all($qry, $connection);
              oci_execute($qry);

              echo "<h5 class='mb-0 text-primary'><i class='fas fa-box-open me-2'></i>New Product Requests: <span class='badge bg-primary ms-2'>$count3</span></h5>";
              ?>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
            <tr class="bg-light">
              <th class="text-center" style="width: 5%">SN</th>
              <th class="text-center" style="width: 20%">Product</th>
              <th class="text-center" style="width: 15%">Type</th>
              <th class="text-center" style="width: 15%">Image</th>
              <th class="text-center" style="width: 15%">Price</th>
              <th class="text-center" style="width: 10%">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include 'connection.php';
            $sql = "SELECT * FROM product, shop, trader WHERE trader.Trader_Id=shop.Trader_id AND shop.Shop_Id=product.Shop_Id AND Product_Verification='0' ORDER BY product.PRODUCT_ID DESC";
            $qry = oci_parse($connection, $sql);
            oci_execute($qry);
            $s = 0;
            while ($row = oci_fetch_assoc($qry)) {
                $pid = $row['PRODUCT_ID'];
                $tname = $row['NAME'];
                $sname = $row['SHOP_NAME'];
                $pimage = $row['PRODUCT_IMAGE'];
                $pname = $row['PRODUCT_NAME'];
                $ptype = $row['PRODUCT_TYPE'];
                $check = $row['PRODUCT_VERIFICATION'];
                $pprice = $row['PRODUCT_PRICE'];
                $s = $s + 1;
                ?>
              <tr>
                <td class="text-center"><?php echo $s; ?></td>
                <td class="text-center fw-medium"><?php echo $pname; ?></td>
                <td class="text-center">
                  <span class="badge bg-secondary"><?php echo $ptype; ?></span>
                </td>
                <td class="text-center">
                  <img src="../<?php echo $pimage; ?>" class="product-image" alt="<?php echo $pname; ?>">
                </td>
                <td class="text-center">
                  <span class="badge bg-success">$<?php echo number_format($pprice, 2); ?></span>
                </td>
                <td class="text-center">
                  <form method="POST" action="product_request_process.php" class="d-inline">
                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                      <?php if ($check == 1): ?>
                        <button type="submit" class="btn btn-success btn-sm me-2" name="submit" disabled>Approve</button>
                        <button type="submit" class="btn btn-danger btn-sm" name="submit2">Decline</button>
                      <?php else: ?>
                        <button type="submit" class="btn btn-success btn-sm me-2" name="submit">Approve</button>
                        <button type="submit" class="btn btn-danger btn-sm" name="submit2" disabled>Decline</button>
                      <?php endif; ?>
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
      }
  </style>
<?php include 'tfooter.php'; ?>