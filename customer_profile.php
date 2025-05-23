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

<?php include 'header.php'; ?>

<?php if (isset($_GET['msg'])): ?>
    <h4 class="text-center text-success"><?= htmlspecialchars($_GET['msg']) ?></h4>
<?php endif; ?>

<div class="mt-5">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light text-dark">
                    <h4 class="mb-0 bg-light">My Account</h4>
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
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img
                            src="<?= htmlspecialchars($profile_picture ?: 'default-profile.png') ?>"
                            alt="Profile Picture"
                            class="img-thumbnail rounded-circle"
                            style="width: 180px; height: 180px; object-fit: cover;">
                    </div>
                    <a href="customer_profile_picture.php" class="btn btn-outline-secondary btn-sm">
                        Change Profile Picture
                    </a>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="mb-4 text-center">Account Information</h5>
                    <p class="mb-1"><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                    <div class="row g-3 justify-content-center mt-4">
                        <div class="col-auto">
                            <a href="customer_edit.php?id=<?= $customer_id ?>" class="btn btn-dark btn-sm text-white w-100">
                                Edit Profile
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="change_password.php" class="btn btn-success btn-sm text-white w-100">
                                Change Password
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <!-- Recent Orders Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-4 text-center">Recent Orders</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead style="background-color: #f8f9fa; color: #212529;">
                        <tr>
                            <th style="width: 25%;">Product Image</th>
                            <th style="width: 25%;">Order Date</th>
                            <th style="width: 25%;">Order Number</th>
                            <th style="width: 25%;">Product Price</th>
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
                                    <td>
                                        <a href="#">
                                            <img src="<?= htmlspecialchars($product_image) ?>" alt="Product Image" class="img-fluid" style="max-height: 100px;">
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($odate) ?></td>
                                    <td><?= htmlspecialchars($onumber) ?></td>
                                    <td>$<?= number_format($oprice, 2) ?></td>
                                </tr>
                        <?php
                            }

                            if (!$hasOrder) {
                                echo "<tr><td colspan='4'>No recent orders found.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php
include 'footer.php';
include 'end.php';
?>