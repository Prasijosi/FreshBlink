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

<style>
    :root {
        --primary-color: #2e7d32;
        /* Dark green */
        --secondary-color: #43a047;
        /* Medium green */
        --accent-color: #81c784;
        /* Light green */
        --text-color: #1b5e20;
        /* Forest green */
        --light-bg: #e8f5e9;
        /* Very light green */
    }

    body {
        background-color: var(--light-bg);
        color: var(--text-color);
    }

    .profile-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 0.5rem;
    }

    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(46, 125, 50, 0.15);
    }

    .sidebar-card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem rgba(46, 125, 50, 0.15);
    }

    .list-group-item {
        border: none;
        padding: 1rem 1.25rem;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: var(--light-bg);
        color: var(--primary-color);
    }

    .list-group-item.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .profile-image {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border: 3px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .profile-image:hover {
        transform: scale(1.05);
    }

    .btn-upload {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transition: all 0.2s ease;
    }

    .btn-upload:hover {
        background-color: #1b5e20;
        border-color: #1b5e20;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background-color: #558b2f;
        border-color: #558b2f;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background-color: #33691e;
        border-color: #33691e;
        transform: translateY(-1px);
    }

    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(129, 199, 132, 0.25);
    }
</style>

<div class="container-fluid py-4">
    <?php include 'header.php'; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i><?= htmlspecialchars($error_message) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Sidebar -->
        <aside class="col-lg-3 col-md-4 mb-4">
            <div class="card sidebar-card">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-user-circle mr-2" style="color: var(--primary-color); font-size: 1.5rem;"></i>My Account
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="<?= htmlspecialchars($profile_picture) ?>"
                            alt="Profile Picture"
                            class="rounded-circle profile-image">
                    </div>
                    <a href="customer_profile_picture.php" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-camera mr-2"></i>Change Profile Picture
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    <a href="customer_profile.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag mr-2"></i>Orders
                    </a>
                    <a href="reviews.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-star mr-2"></i>Product Reviews
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <section class="col-lg-9 col-md-8">
            <div class="card profile-card">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-camera mr-2"></i>Update Profile Picture
                    </h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-4">
                            <img src="<?= htmlspecialchars($profile_picture) ?>"
                                alt="Profile Picture"
                                class="rounded-circle profile-image mb-3">
                            <h5 class="text-muted">Current Profile Picture</h5>
                        </div>

                        <div class="form-group mb-4">
                            <label for="Profile_Image" class="form-label">
                                <i class="fas fa-upload mr-2"></i>Choose new profile picture
                            </label>
                            <div class="custom-file">
                                <input type="file"
                                    class="custom-file-input"
                                    id="Profile_Image"
                                    name="Profile_Image"
                                    accept=".jpg,.jpeg,.png"
                                    required>
                                <label class="custom-file-label" for="Profile_Image">Choose file...</label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Allowed formats: JPG, JPEG, PNG
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-upload mr-2" style="background-color: var(--primary-color); color: white;">
                                <i class="fas fa-upload mr-2" style="background: transparent; color:white;"></i>Update Profile Picture
                            </button>
                            <a href="customer_profile.php" class="btn btn-cancel" style="color: white;">
                                <i class="fas fa-times mr-2" style="background: transparent; color:white;"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    // Update custom file input label with selected filename
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

<?php
include 'footer.php';
include 'end.php';
?>