<?php include 'start.php';
if (!isset($_SESSION['username'])) {
    header('Location:sign_in_customer.php');
}
@$profile_picture = $_SESSION['profile_picture'];
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

    .order-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 0.5rem;
    }

    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(46, 125, 50, 0.15);
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

    .order-date {
        color: #558b2f;
        font-size: 0.875rem;
    }

    .order-number {
        color: var(--primary-color);
        font-weight: 500;
    }

    .badge-pending {
        background-color: var(--accent-color);
        color: #fff;
    }

    .badge-delivered {
        background-color: var(--secondary-color);
        color: #fff;
    }
</style>

<?php include 'header.php'; ?>

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
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="<?php echo $profile_picture ?>"
                            alt="Profile Picture"
                            class="img-thumbnail rounded-circle"
                            style="width: 180px; height: 180px; object-fit: cover;">
                    </div>
                    <a href="customer_profile_picture.php" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-camera mr-2"></i>Change Profile Picture
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    <a href="customer_profile.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action" style="background-color: var(--primary-color); color: white;">
                        <i class="fas fa-shopping-bag mr-2" style="background: transparent;"></i>Orders
                    </a>
                    <a href="reviews.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-star mr-2"></i>Product Reviews
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <section class="col-lg-9 col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-shopping-bag mr-2"></i>My Orders
                    </h4>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <?php
                    include 'connection.php';

                    $customer_id = $_SESSION['customer_id'];

                    $sql = "SELECT * FROM orders o, product p, customer c where '$customer_id' = c.Customer_Id and c.Customer_Id = o.Customer_Id and o.Product_Id = p.Product_ID";

                    $result = oci_parse($connection, $sql);
                    oci_execute($result);

                    $hasOrders = false;
                    while ($row = oci_fetch_assoc($result)) {
                        $hasOrders = true;
                        $order_no = $row['ORDER_ID'];
                        $order_date = $row['ORDER_DATE'];
                        $qty = $row['QUANTITY'];
                        $order_status = $row['DELIVERY_STATUS'];
                        $Product_Image = $row['PRODUCT_IMAGE'];
                        $product_name = $row['PRODUCT_NAME'];
                    ?>
                        <div class="card mb-4 order-card">
                            <div class="card-header bg-white py-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <strong class="order-number">
                                            <i class="fas fa-hashtag mr-2"></i>Order #<?php echo htmlspecialchars($order_no); ?>
                                        </strong>
                                    </div>
                                    <div class="col text-end">
                                        <small class="order-date">
                                            <i class="far fa-calendar-alt mr-2"></i><?php echo htmlspecialchars($order_date); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        <img src="<?php echo htmlspecialchars($Product_Image); ?>"
                                            alt="<?php echo htmlspecialchars($product_name); ?>"
                                            class="img-fluid product-image">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-2 font-weight-bold"><?php echo htmlspecialchars($product_name); ?></h6>
                                        <p class="mb-0 text-muted">
                                            <i class="fas fa-shopping-cart mr-2"></i>Quantity: <?php echo htmlspecialchars($qty); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-5 text-md-right mt-3 mt-md-0">
                                        <span class="badge <?php echo $order_status == 0 ? 'badge-pending' : 'badge-delivered'; ?> p-2">
                                            <i class="fas <?php echo $order_status == 0 ? 'fa-clock' : 'fa-check-circle'; ?> mr-2"></i>
                                            <?php echo $order_status == 0 ? 'Order Pending' : 'Order Delivered'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    if (!$hasOrders) {
                        echo '<div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>No orders found.
                            </div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include 'footer.php';
include 'end.php'; ?>