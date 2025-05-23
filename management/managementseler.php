<?php
session_start();
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
        <div class="row mb-3">
          <div class="col-md-6 d-flex align-items-center">
              <?php
              include 'connection.php';

              $sql = " SELECT * FROM   shop, trader where trader.Trader_Id=shop.Trader_id   and shop.Shop_Verification='0'";
              $qry = oci_parse($connection, $sql);
              oci_execute($qry);

              $count3 = oci_fetch_all($qry, $connection);
              oci_execute($qry);

              echo "<h5 class='mb-0'>New Trader or Shop Request : $count3</h5>";
              ?>
          </div>

          <div class="col-md-6">
            <form action="#" method="GET" class="d-flex justify-content-end align-items-center">
              <span class="me-2">Sort By:</span>
              <select name="category" class="form-select sort-select me-2" style="width: auto;">
                <option value="recent">Recent</option>
                <option value="name_asc">Name (A-Z)</option>
                <option value="name_desc">Name (Z-A)</option>
                <option value="shop_asc">Shop Name (A-Z)</option>
                <option value="shop_desc">Shop Name (Z-A)</option>
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
              <th>Trader Name</th>
              <th>Shop Name</th>
              <th>Shop Details</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include('connection.php');
            $sql = "SELECT * FROM shop, trader WHERE shop.Trader_id=trader.Trader_Id AND Shop_Verification='0'";

            // Add sorting logic
            if (isset($_GET['category'])) {
                $sort = $_GET['category'];
                switch ($sort) {
                    case 'name_asc':
                        $sql .= " ORDER BY trader.NAME ASC";
                        break;
                    case 'name_desc':
                        $sql .= " ORDER BY trader.NAME DESC";
                        break;
                    case 'shop_asc':
                        $sql .= " ORDER BY shop.SHOP_NAME ASC";
                        break;
                    case 'shop_desc':
                        $sql .= " ORDER BY shop.SHOP_NAME DESC";
                        break;
                    default:
                        $sql .= " ORDER BY shop.SHOP_ID DESC"; // Recent by default
                }
            } else {
                $sql .= " ORDER BY shop.SHOP_ID DESC"; // Recent by default
            }

            $qry = oci_parse($connection, $sql);
            oci_execute($qry);
            $s = 0;
            while ($row = oci_fetch_assoc($qry)) {
                $tid = $row['TRADER_ID'];
                $sid = $row['SHOP_ID'];
                $tname = $row['NAME'];
                $sname = $row['SHOP_NAME'];
                $sdetails = $row['SHOP_DESCRIPTION'];

                $s = $s + 1;
                ?>
              <tr>
                <td class="text-center"><?php echo $s; ?></td>
                <td class="text-center"><?php echo $tname; ?></td>
                <td class="text-center"><?php echo $sname; ?></td>
                <td class="text-center"><?php echo $sdetails; ?></td>
                <td class="text-center">
                  <form method="POST" action="manage_shop_admin.php" class="d-inline">
                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                    <input type="hidden" name="tid" value="<?php echo $tid; ?>">
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