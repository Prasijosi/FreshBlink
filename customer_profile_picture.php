<?php
include 'start.php';

if (!isset($_SESSION['username'])) {
    header('Location: sign_in_customer.php');
    exit();
}

$username = $_SESSION['username'];
$customer_id = $_SESSION['customer_id'] ?? null;
$profile_picture = $_SESSION['profile_picture'] ?? 'images/customer/default-profile.png';

if (isset($_POST['submit'])) {
    $Profile_Image = $_FILES['Profile_Image'];
    $filename = $Profile_Image['name'];
    $fileerror = $Profile_Image['error'];
    $filetmp = $Profile_Image['tmp_name'];

    $imgext = explode('.', $filename);
    $filecheck = strtolower(end($imgext));

    $fileextstored = array('png', 'jpg', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {
        // Create directory if it doesn't exist
        $upload_dir = 'images/customer/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique filename
        $new_filename = uniqid() . '.' . $filecheck;
        $destinationfile = $upload_dir . $new_filename;

        if (move_uploaded_file($filetmp, $destinationfile)) {
            include 'connection.php';

            $sql = "UPDATE customer SET Profile_Image = :profile_image WHERE Customer_ID = :customer_id";
            $query = oci_parse($connection, $sql);
            oci_bind_by_name($query, ':profile_image', $destinationfile);
            oci_bind_by_name($query, ':customer_id', $customer_id);

            if (oci_execute($query)) {
                // Update session
                $_SESSION['profile_picture'] = $destinationfile;

                // Redirect with success message
                header('Location: customer_profile.php?msg=Profile picture updated successfully');
                exit();
            }
        }
    }

    // If we get here, there was an error
    $error_message = "Error while uploading! Please try again.";
}
?>

<?php include 'header.php'; ?>

  <div class="mt-5">
    <div class="row">
      <!-- Sidebar -->
      <aside class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-light text-dark">
            <h4 class="mb-0">My Account</h4>
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
          <div class="card-body">
            <h4 class="card-title text-center mb-4">Update Profile Picture</h4>

              <?php if (isset($error_message)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= htmlspecialchars($error_message) ?>
                </div>
              <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
              <div class="text-center mb-4">
                <img src="<?= htmlspecialchars($profile_picture) ?>"
                     alt="Profile Picture"
                     class="img-thumbnail rounded-circle"
                     style="width: 200px; height: 200px; object-fit: cover;">
              </div>

              <div class="mb-4">
                <label for="Profile_Image" class="form-label">Choose new profile picture</label>
                <input type="file"
                       class="form-control"
                       id="Profile_Image"
                       name="Profile_Image"
                       accept=".jpg,.jpeg,.png"
                       required>
                <div class="form-text">Allowed formats: JPG, JPEG, PNG</div>
              </div>

              <div class="text-center">
                <button type="submit" name="submit" class="btn btn-primary">
                  Update Profile Picture
                </button>
                <a href="customer_profile.php" class="btn btn-outline-secondary ms-2">
                  Cancel
                </a>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>

<?php
include 'footer.php';
include 'end.php';
?>