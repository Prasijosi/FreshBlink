<?php include 'start.php';
if (!isset($_SESSION['username'])) {
    header('Location:sign_in_customer.php');
}
$profile_picture = $_SESSION['profile_picture'];
?>
  <div class="container mt-5">
      <?php include 'header.php';
      if (isset($_GET['msg'])) {
          $msg = $_GET['msg'];
          echo "<script type='text/javascript'>alert('" . $msg . "')</script>";
      }
      ?>
    <div class="row">
      <!-- Sidebar -->
      <aside class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-light text-dark">
            <h4 class="mb-0">My Account</h4>
          </div>
          <div class="card-body text-center">
            <div class="mb-3">
              <img src="<?php echo $profile_picture ?>"
                   alt="Profile Picture"
                   class="img-thumbnail rounded-circle"
                   style="width: 180px; height: 180px; object-fit: cover;">
            </div>
            <a href="customer_profile_picture.php" class="btn btn-outline-secondary btn-sm">
              Change Profile Picture
            </a>
          </div>
          <div class="list-group list-group-flush">
            <a href="customer_profile.php" class="list-group-item list-group-item-action">Dashboard</a>
            <a href="orders.php" class="list-group-item list-group-item-action">Orders</a>
            <a href="reviews.php" class="list-group-item list-group-item-action">Product Reviews</a>
          </div>
        </div>
      </aside>

      <!-- Main Content -->
      <section class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header bg-light text-dark">
            <h4 class="mb-0">Change Password</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="change_password_process.php">
              <div class="form-group mb-3">
                <label for="inputPassword" class="form-label">New Password</label>
                <input type="password"
                       class="form-control"
                       id="inputPassword"
                       placeholder="Enter your new password"
                       name="password"
                       required>
              </div>
              <div class="form-group mb-4">
                <label for="inputPassword1" class="form-label">Confirm New Password</label>
                <input type="password"
                       class="form-control"
                       id="inputPassword1"
                       placeholder="Re-enter your new password"
                       name="repassword"
                       required>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-success" name="submit">
                  Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
<?php include 'footer.php';
include 'end.php';
?>