<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}
?>

  <style>
      .order-table {
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
          border-radius: 8px;
          overflow: hidden;
      }

      .order-table thead th {
          background-color: #f8f9fa;
          border-bottom: 2px solid #dee2e6;
          color: #495057;
          font-weight: 600;
          font-size: 0.95rem;
          padding: 1rem;
          white-space: nowrap;
      }

      .order-table tbody td {
          font-size: 0.95rem;
          vertical-align: middle;
          padding: 1rem;
      }

      .order-table tbody tr {
          transition: all 0.2s ease;
      }

      .order-table tbody tr:hover {
          background-color: #f8f9fa;
      }

      .status-btn {
          min-width: 120px;
          font-size: 0.85rem;
          padding: 0.4rem 0.8rem;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 0.5rem;
      }

      .sort-select {
          min-width: 120px;
          border: 1px solid #dee2e6;
          border-radius: 4px;
          padding: 0.3rem 0.6rem;
          font-size: 0.95rem;
          background-color: #fff;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      }

      .sort-select:focus {
          border-color: #80bdff;
          box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
      }

      .order-count {
          font-size: 1.1rem;
          color: #495057;
          font-weight: 500;
      }

      .table-container {
          background: #fff;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
          padding: 1rem;
      }

      .order-id {
          font-weight: 600;
          color: #495057;
      }

      .order-date {
          color: #6c757d;
      }

      .order-total {
          font-weight: 600;
          color: #28a745;
      }

      .order-quantity {
          font-weight: 500;
          color: #495057;
      }
  </style>

<?php include 'theader.php'; ?>

  <div class="container mt-4">
    <div class="row mb-4">
      <div class="col-12">
        <h3 class="mb-4">Order Overview</h3>
      </div>
    </div>

      <?php
      include('connection.php');

      $tn = $_SESSION['trader_username'];

      $sql2 = "SELECT * FROM trader where Username='$tn' ";
      $qry2 = oci_parse($connection, $sql2);
      oci_execute($qry2);

      while ($row = oci_fetch_assoc($qry2)) {
          $tid = $row['TRADER_ID'];
      }

      $sql = "SELECT * FROM orders, product, shop,TIME_SLOT where shop.Shop_Id=product.Shop_Id AND orders.Product_Id=product.Product_Id and orders.order_id=time_slot.order_id and shop.Trader_id='$tid'";
      $qry = oci_parse($connection, $sql);
      oci_execute($qry);

      // Get count of orders
      $count2 = 0;
      while (oci_fetch_assoc($qry)) {
          $count2++;
      }
      oci_execute($qry); // Reset the cursor
      ?>

    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-md-6">
            <span class="order-count"><?php echo $count2; ?> Orders</span>
          </div>
          <div class="col-md-6">
            <form method="POST" action="#" class="d-flex justify-content-end align-items-center">
              <span class="me-2">Sort By:</span>
              <select id="sort" class="sort-select me-2" name="cat">
                <option
                  value="DESC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "DESC") ? 'selected="selected"' : ''; ?>>
                  Recent Orders
                </option>
                <option
                  value="ASC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "ASC") ? 'selected="selected"' : ''; ?>>
                  Old Orders
                </option>
              </select>
              <button class="btn btn-dark">Go</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-hover order-table">
          <thead>
          <tr>
            <th>SN</th>
            <th>Order Date</th>
            <th>Order ID</th>
            <th>Product Information</th>
            <th>Collection Slot</th>
            <th>Buyer Details</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if (isset($_POST['cat'])) {
              $c = $_POST['cat'];
              $s = ($c == "DESC") ? "DESC" : (($c == "ASC") ? "ASC" : "");
              $sql = "SELECT * FROM orders, product, shop,TIME_SLOT where shop.Shop_Id=product.Shop_Id AND orders.Product_Id=product.Product_Id and orders.order_id=time_slot.order_id and shop.Trader_id='$tid' ORDER BY Order_Date $s";
          } else {
              $sql = "SELECT * FROM orders, product, shop,TIME_SLOT where shop.Shop_Id=product.Shop_Id AND orders.Product_Id=product.Product_Id and orders.order_id=time_slot.order_id and shop.Trader_id='$tid'";
          }

          $qry = oci_parse($connection, $sql);
          oci_execute($qry);
          $sn = 0;

          while ($row = oci_fetch_assoc($qry)) {
              $oid = $row['ORDER_ID'];
              $odate = $row['ORDER_DATE'];
              $quantity = $row['QUANTITY'];
              $total = $row['ORDER_PRICE'];
              $cid = $row['CUSTOMER_ID'];
              $pid = $row['PRODUCT_ID'];
              $pname = $row['PRODUCT_NAME'];
              $ds = $row['DELIVERY_STATUS'];
              $time = $row['TIME_SLOT_DATE'];

              $sql1 = "SELECT * FROM customer where Customer_ID ='$cid'";
              $qry1 = oci_parse($connection, $sql1);
              oci_execute($qry1);

              while ($row = oci_fetch_assoc($qry1)) {
                  $cname = $row['USERNAME'];
                  $sn++;
                  ?>
                <tr>
                  <td><?php echo $sn; ?></td>
                  <td>
                    <div class="order-date"><?php echo $odate; ?></div>
                  </td>
                  <td>
                    <div class="order-id"><?php echo $oid; ?></div>
                  </td>
                  <td><?php echo $pname; ?></td>
                  <td><?php echo $time; ?></td>
                  <td><?php echo $cname; ?></td>
                  <td>
                    <div class="order-quantity"><?php echo $quantity; ?></div>
                  </td>
                  <td>
                    <div class="order-total">$<?php echo number_format($total, 2); ?></div>
                  </td>
                  <td>
                      <?php if ($ds == 1): ?>
                        <a href="trader_delivery_status.php?orderID=<?php echo $oid; ?>&d=1"
                           class="btn btn-success status-btn">
                          <i class="fas fa-check"></i>Delivered
                        </a>
                      <?php else: ?>
                        <a href="trader_delivery_status.php?orderID=<?php echo $oid; ?>&d=0"
                           class="btn btn-danger status-btn">
                          <i class="fas fa-times"></i>Not Delivered
                        </a>
                      <?php endif; ?>
                  </td>
                </tr>
                  <?php
              }
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php
unset($_SESSION['ds']);
include '../end.php'; ?>