<?php include 'start.php';
if (!isset($_SESSION['username'])) {
    header('Location:sign_in_customer.php');
}
$profile_picture = $_SESSION['profile_picture'];
?>
<style>
    :root {
        --primary-color: #2e7d32;  /* Dark green */
        --secondary-color: #43a047; /* Medium green */
        --accent-color: #81c784;   /* Light green */
        --text-color: #1b5e20;     /* Forest green */
        --light-bg: #e8f5e9;       /* Very light green */
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
    
    .btn-password {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transition: all 0.2s ease;
    }
    
    .btn-password:hover {
        background-color: #1b5e20;
        border-color: #1b5e20;
        transform: translateY(-1px);
    }
    
    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(129, 199, 132, 0.25);
    }
</style>

<div class="container-fluid py-4">
    <?php include 'header.php';
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='fas fa-exclamation-circle mr-2'></i>" . htmlspecialchars($msg) . "
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
    }
    ?>
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
                        <img src="<?php echo htmlspecialchars($profile_picture); ?>"
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
                        <i class="fas fa-key mr-2"></i>Change Password
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="change_password_process.php">
                        <div class="form-group mb-4">
                            <label for="inputPassword" class="form-label">
                                <i class="fas fa-lock mr-2"></i>New Password
                            </label>
                            <input type="password"
                                   class="form-control"
                                   id="inputPassword"
                                   placeholder="Enter your new password"
                                   name="password"
                                   required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="inputPassword1" class="form-label">
                                <i class="fas fa-lock mr-2"></i>Confirm New Password
                            </label>
                            <input type="password"
                                   class="form-control"
                                   id="inputPassword1"
                                   placeholder="Re-enter your new password"
                                   name="repassword"
                                   required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-password" name="submit" style="background-color: var(--primary-color); color: white;">
                                <i class="fas fa-save mr-2" style="background: transparent; color:white;"></i>Save Changes
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