<?php include 'start.php';
if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}
@$profile_picture = $_SESSION['profile_picture'];
?>
	<?php include 'header.php'; ?>

<div class="mt-5">
	<div class="row">
		<!-- Sidebar -->
		<aside class="col-md-4 mb-4">
			<div class="card shadow-sm">
				<div class="card-header bg-light text-dark">
					<h4 class="mb-0 bg-light">My Account</h4>
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
					<h4 class="mb-0 bg-light">My Orders</h4>
				</div>
				<div class="card-body" style="max-height: 400px; overflow-y: auto;">
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
						<div class="card mb-3">
							<div class="card-header bg-light">
								<div class="row align-items-center">
									<div class="col bg-light">
										<strong class="bg-light">Order #<?php echo htmlspecialchars($order_no); ?></strong>
									</div>
									<div class="col text-end bg-light">
										<small class="text-muted bg-light"><?php echo htmlspecialchars($order_date); ?></small>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row align-items-center" 
					>
									<div class="col-md-3 text-center">
										<img src="<?php echo htmlspecialchars($Product_Image); ?>" 
											 alt="<?php echo htmlspecialchars($product_name); ?>" 
											 class="img-fluid rounded"
											 style="max-height: 100px; object-fit: contain;">
									</div>
									<div class="col-md-4">
										<h6 class="mb-1"><?php echo htmlspecialchars($product_name); ?></h6>
										<p class="mb-0 text-muted">Quantity: <?php echo htmlspecialchars($qty); ?></p>
									</div>
									<div class="col-md-5 text-end">
										<span class="badge <?php echo $order_status == 0 ? 'bg-warning' : 'bg-success'; ?>">
											<?php echo $order_status == 0 ? 'Order Pending' : 'Order Delivered'; ?>
										</span>
									</div>
								</style=>
							</div>
						</div>
						<?php
					}

					if (!$hasOrders) {
						echo '<div class="alert alert-info">No orders found.</div>';
					}
					?>
				</div>
			</div>
		</section>
	</div>
</div>
<?php include 'footer.php';
include 'end.php'; ?>
include 'end.php'; ?>