<?php
include 'start.php';
if (!isset($_SESSION['username'])) {
    header('Location:sign_in_customer.php');
    exit;
}
include 'connection.php';

$profile_picture = $_SESSION['profile_picture'];
$customer_data = [];

if (isset($_GET['id'])) {
    $editid = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE CUSTOMER_ID = :id";
    $qry = oci_parse($connection, $sql);
    oci_bind_by_name($qry, ":id", $editid);
    oci_execute($qry);

    if ($r = oci_fetch_assoc($qry)) {
        $customer_data = $r;
    }
}
?>
<?php include 'header.php'; ?>

<div class="container mt-5">

    <?php if (isset($_GET['msg'])): ?>
      <h4 class="text-center text-danger"><?php echo htmlspecialchars($_GET['msg']); ?></h4>
    <?php endif; ?>

  <div class="row">
    <!-- Sidebar -->
    <aside class="col-md-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-light text-dark">
          <h4 class="mb-0">My Account</h4>
        </div>
        <div class="card-body text-center">
          <div class="mb-3">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>"
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
          <h4 class="mb-0">Edit Account Information</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($customer_data)): ?>
              <form method="POST" action="edituserprocess.php">
                <input type="hidden" name="cid" value="<?php echo htmlspecialchars($customer_data['CUSTOMER_ID']); ?>">

                <div class="form-group mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" name="uname" class="form-control"
                         value="<?php echo htmlspecialchars($customer_data['USERNAME']); ?>" required>
                </div>

                <div class="form-group mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="fname" class="form-control"
                         value="<?php echo htmlspecialchars($customer_data['FULL_NAME']); ?>" required>
                </div>

                <div class="form-group mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control"
                         value="<?php echo htmlspecialchars($customer_data['EMAIL']); ?>" required>
                </div>

                <div class="form-group mb-3">
                  <label class="form-label">Address</label>
                  <input type="text" name="address" class="form-control"
                         value="<?php echo htmlspecialchars($customer_data['ADDRESS']); ?>">
                </div>

                <div class="form-group mb-3">
                  <label class="form-label">Phone Number</label>
                  <input type="text" name="phone" class="form-control"
                         value="<?php echo htmlspecialchars($customer_data['CONTACT_NUMBER']); ?>">
                </div>

                <div class="form-group mb-3">
                  <label class="form-label">Gender</label><br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender"
                           value="Male" <?php echo ($customer_data['SEX'] == 'Male') ? 'checked' : ''; ?>>
                    <label class="form-check-label">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender"
                           value="Female" <?php echo ($customer_data['SEX'] == 'Female') ? 'checked' : ''; ?>>
                    <label class="form-check-label">Female</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender"
                           value="Other" <?php echo ($customer_data['SEX'] == 'Other') ? 'checked' : ''; ?>>
                    <label class="form-check-label">Other</label>
                  </div>
                </div>

                <div class="form-group mb-3">
                  <label class="form-label">Date of Birth</label>
                  <input type="date" name="dob" class="form-control"
                         value="<?php echo htmlspecialchars($customer_data['DATE_OF_BIRTH']); ?>">
                </div>

                <div class="text-center">
                  <button type="submit" name="update" class="btn btn-success">Update Profile</button>
                </div>
              </form>
            <?php else: ?>
              <div class="alert alert-warning">Customer data not found.</div>
            <?php endif; ?>
        </div>
      </div>
    </section>
  </div>
</div>

<?php
include 'footer.php';
include 'end.php';
?>
