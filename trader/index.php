<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}
?>
<?php include 'theader.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    echo "<script>alert('" . $msg . "');</script>";
}

if (isset($_SESSION['msg'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			' . $_SESSION['msg'] . '
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>';
}
?>

  <div class="container mt-4">
    <div class="row">
      <!-- Main Content -->
      <div class="col-md-8">
        <!-- Account Information Card -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-light">
            <h5 class="mb-0">Account Information</h5>
          </div>
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-md-3 text-center">
                  <?php
                  include 'connection.php';
                  $tn = $_SESSION['trader_username'];
                  $sql = "SELECT * FROM trader where Username='$tn'";
                  $qry = oci_parse($connection, $sql);
                  oci_execute($qry);

                  while ($row = oci_fetch_assoc($qry)) {
                      $tid = $row['TRADER_ID'];
                      $timage = $row['PROFILE_IMAGE'];
                      $tname = $row['NAME'];
                      $temail = $row['EMAIL'];
                  }
                  ?>
                <img src="../<?php echo $timage; ?>"
                     class="img-thumbnail rounded-circle mb-3"
                     style="width: 100px; height: 100px; object-fit: cover;"
                     alt="Profile Picture">
              </div>
              <div class="col-md-9">
                <h5 class="mb-3"><?php echo $tname; ?></h5>
                <p class="text-muted mb-2">
                  <i class="fas fa-envelope me-2"></i><?php echo $temail; ?>
                </p>
                <div class="mt-3">
                  <a href="trader_edit_profile.php" class="btn btn-outline-primary btn-sm me-2">
                    <i class="fas fa-edit me-1"></i>Edit Profile
                  </a>
                  <a href="trader_change_password.php" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-key me-1"></i>Change Password
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Stock Level Sidebar -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header bg-light">
            <h5 class="mb-0">Stock Level</h5>
          </div>
          <div class="card-body p-0">
              <?php
              $sql1 = "SELECT * FROM trader, product, shop WHERE shop.Shop_Id=product.Shop_Id AND trader.Trader_Id=shop.Trader_id AND shop.Trader_id='$tid' ORDER BY stock";
              $qry1 = oci_parse($connection, $sql1);
              oci_execute($qry1);

              while ($row = oci_fetch_assoc($qry1)) {
                  $pname = $row['PRODUCT_NAME'];
                  $stock = $row['STOCK'];
                  ?>
                <div class="p-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><?php echo $pname; ?></h6>
                    <span class="badge <?php echo $stock < 10 ? 'bg-danger' : 'bg-success'; ?>">
									<?php echo $stock; ?> in stock
								</span>
                  </div>
                </div>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
unset($_SESSION['msg']);
include '../end.php';
?>