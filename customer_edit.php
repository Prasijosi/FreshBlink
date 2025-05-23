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
    
    .btn-edit {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transition: all 0.2s ease;
    }
    
    .btn-edit:hover {
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
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i><?= htmlspecialchars($_GET['msg']) ?>
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
                        <i class="fas fa-edit mr-2"></i>Edit Account Information
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($customer_data)): ?>
                        <form method="POST" action="edituserprocess.php">
                            <input type="hidden" name="cid" value="<?php echo htmlspecialchars($customer_data['CUSTOMER_ID']); ?>">

                            <div class="form-group mb-3">
                                <label class="form-label"><i class="fas fa-user mr-2"></i>Username</label>
                                <input type="text" name="uname" class="form-control"
                                       value="<?php echo htmlspecialchars($customer_data['USERNAME']); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"><i class="fas fa-id-card mr-2"></i>Full Name</label>
                                <input type="text" name="fname" class="form-control"
                                       value="<?php echo htmlspecialchars($customer_data['FULL_NAME']); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"><i class="fas fa-envelope mr-2"></i>Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?php echo htmlspecialchars($customer_data['EMAIL']); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"><i class="fas fa-map-marker-alt mr-2"></i>Address</label>
                                <input type="text" name="address" class="form-control"
                                       value="<?php echo htmlspecialchars($customer_data['ADDRESS']); ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"><i class="fas fa-phone mr-2"></i>Phone Number</label>
                                <input type="text" name="phone" class="form-control"
                                       value="<?php echo htmlspecialchars($customer_data['CONTACT_NUMBER']); ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"><i class="fas fa-venus-mars mr-2"></i>Gender</label><br>
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

                            <div class="form-group mb-4">
                                <label class="form-label"><i class="fas fa-calendar mr-2"></i>Date of Birth</label>
                                <input type="date" name="dob" class="form-control"
                                       value="<?php echo htmlspecialchars($customer_data['DATE_OF_BIRTH']); ?>">
                            </div>

                            <div class="text-center">
                                <button type="submit" name="update" class="btn btn-edit" style="background-color: var(--primary-color); color: white;">
                                    <i class="fas fa-save mr-2" style="background: transparent; color:white;"></i>Update Profile
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Customer data not found.
                        </div>
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
