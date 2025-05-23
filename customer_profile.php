<?php
include 'start.php';
if (!isset($_SESSION['username'])) {
    header('Location:sign_in_customer.php');
    exit();
}

$username_1 = $_SESSION['username'];
@$profile_picture = $_SESSION['profile_picture'];

include 'connection.php';

$query = "select * from customer where username='$username_1'";
$result = oci_parse($connection, $query);
oci_execute($result);

$customer_id = null;
while ($row = oci_fetch_assoc($result)) {
    $full_name = ucwords($row['FULL_NAME']);
    $email = strtolower($row['EMAIL']);
    $customer_id = $row['CUSTOMER_ID'];
}
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
    
    .btn-password {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        transition: all 0.2s ease;
    }
    
    .btn-password:hover {
        background-color: #2e7d32;
        border-color: #2e7d32;
        transform: translateY(-1px);
    }
    
    .table-custom th {
        background-color: var(--light-bg);
        color: var(--text-color);
        font-weight: 600;
    }
    
    .table-custom td {
        vertical-align: middle;
    }
    
    .product-image {
        max-height: 100px;
        object-fit: contain;
        border-radius: 0.5rem;
        transition: transform 0.3s ease;
    }
    
    .product-image:hover {
        transform: scale(1.05);
    }
</style>

<?php include 'header.php'; ?>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i><?= htmlspecialchars($_GET['msg']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-lg-3 col-md-4 mb-4">
            <div class="card sidebar-card">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-user-circle mr-2" style="color: var(--primary-color); font-size: 1.5rem;"></i>My Account
                    </h4>
                </div>
                <div class="list-group list-group-flush">
                    <a href="customer_profile.php" class="list-group-item list-group-item-action" style="background-color: var(--primary-color); color: white;">
                        <i class="fas fa-tachometer-alt mr-2" style="background: transparent;"></i>Dashboard
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
            <div class="card profile-card mb-4">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img src="<?= htmlspecialchars($profile_picture ?: 'default-profile.png') ?>"
                             alt="Profile Picture"
                             class="rounded-circle profile-image">
                    </div>
                    <a href="customer_profile_picture.php" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-camera mr-2"></i>Change Profile Picture
                    </a>
                </div>
            </div>

            <div class="card profile-card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-user mr-2"></i>Account Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="fas fa-user mr-2"></i>Username:</strong>
                                <span class="text-muted"><?= htmlspecialchars($_SESSION['username']) ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="fas fa-envelope mr-2"></i>Email:</strong>
                                <span class="text-muted"><?= htmlspecialchars($_SESSION['email']) ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="customer_edit.php?id=<?= $customer_id ?>" class="btn btn-edit btn-block" style="background-color: var(--primary-color); color: white;">
                                <i class="fas fa-edit mr-2" style="background: transparent; color:white;"></i>Edit Profile
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="change_password.php" class="btn btn-password btn-block" style="background-color: var(--primary-color); color: white;">
                                <i class="fas fa-key mr-2" style="background: transparent; color:white;"></i>Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="card profile-card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-shopping-bag mr-2"></i>Recent Orders
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Product Image</th>
                                    <th>Order Date</th>
                                    <th>Order Number</th>
                                    <th class="text-right">Product Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "connection.php";
                                $un = $_SESSION['username'];
                                $sql1 = "SELECT Customer_ID FROM customer WHERE Username = :un";

                                $result1 = oci_parse($connection, $sql1);
                                oci_bind_by_name($result1, ':un', $un);
                                oci_execute($result1);

                                while ($row = oci_fetch_assoc($result1)) {
                                    $cid = $row['CUSTOMER_ID'];

                                    $sql2 = "SELECT Order_Id, Order_Date, Order_price, Product_Id FROM orders WHERE Customer_Id = :cid ORDER BY Order_Date DESC";
                                    $result2 = oci_parse($connection, $sql2);
                                    oci_bind_by_name($result2, ':cid', $cid);
                                    oci_execute($result2);

                                    $hasOrder = false;
                                    while ($order = oci_fetch_assoc($result2)) {
                                        $hasOrder = true;
                                        $oid = $order['ORDER_ID'];
                                        $odate = $order['ORDER_DATE'];
                                        $onumber = $order['ORDER_ID'];
                                        $oprice = $order['ORDER_PRICE'];
                                        $pid = $order['PRODUCT_ID'];

                                        $sql3 = "SELECT Product_Image FROM product WHERE Product_Id = :pid";
                                        $result3 = oci_parse($connection, $sql3);
                                        oci_bind_by_name($result3, ':pid', $pid);
                                        oci_execute($result3);

                                        $product_image = 'default-product.png';
                                        if ($prod_row = oci_fetch_assoc($result3)) {
                                            $product_image = $prod_row['PRODUCT_IMAGE'];
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <img src="<?= htmlspecialchars($product_image) ?>" 
                                                     alt="Product Image" 
                                                     class="product-image">
                                            </td>
                                            <td>
                                                <i class="far fa-calendar-alt mr-2"></i>
                                                <?= htmlspecialchars($odate) ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-hashtag mr-2"></i>
                                                <?= htmlspecialchars($onumber) ?>
                                            </td>
                                            <td class="text-right">
                                                <i class="fas fa-dollar-sign mr-1"></i>
                                                <?= number_format($oprice, 2) ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }

                                    if (!$hasOrder) {
                                        echo "<tr><td colspan='4' class='text-center'>No recent orders found.</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
include 'footer.php';
include 'end.php';
?>