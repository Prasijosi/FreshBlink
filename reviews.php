<?php include 'start.php';
	
	$pid = '';

if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "<script>alert('" . $msg . "')</script>";
}
?>
<style type="text/css">
	.fa-star {
		color: orange;
		font-size: 1.5vw;
	}
</style>
<?php include 'header.php' ?>

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
				<div class="card-header bg-light text-dark">
					<h4 class="mb-0 bg-light">My Reviews</h4>
				</div>
				<div class="card-body">
					<?php
					include 'connection.php';
					$username = $_SESSION['username'];

					$sql1 = "SELECT * from customer where username= '$username'";
					$result1 = oci_parse($connection, $sql1);
					oci_execute($result1);

					while ($row = oci_fetch_assoc($result1)) {
						$cid = $row['CUSTOMER_ID'];
						$sql2 = " SELECT * FROM orders WHERE Customer_Id='$cid'";
						$result2 = oci_parse($connection, $sql2);
						oci_execute($result2);

						while ($row = oci_fetch_assoc($result2)) {
							include 'connection.php';
							$pid = $row['PRODUCT_ID'];
						}

						$sql3 = " SELECT * FROM review WHERE Customer_Id='$cid' and Product_Id='$pid'";
						$result3 = oci_parse($connection, $sql3);
						oci_execute($result3);

						$count2 = oci_fetch_all($result3, $connection);
						oci_execute($result3);

						if ($count2 == 0) {
							include 'connection.php';
							$sql4 = "SELECT * FROM orders INNER JOIN product ON orders.PRODUCT_ID=product.PRODUCT_ID inner join shop on shop.shop_id=product.shop_id WHERE Customer_Id='$cid'";
							$result4 = oci_parse($connection, $sql4);
							oci_execute($result4);

							while ($row = oci_fetch_assoc($result4)) {
								$productid = $row['PRODUCT_ID'];
								$odate = $row['ORDER_DATE'];
								$pname = $row['PRODUCT_NAME'];
								$pimage = $row['PRODUCT_IMAGE'];
								$sid = $row['SHOP_ID'];
								$sname = $row['SHOP_NAME'];
								?>
								<div class="card mb-3">
									<div class="card-header bg-light">
										<div class="row align-items-center">
											<div class="col">
												<strong>Purchased on: <?php echo htmlspecialchars($odate); ?></strong>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-md-3 text-center">
												<img src="<?php echo htmlspecialchars($pimage); ?>" 
													 alt="<?php echo htmlspecialchars($pname); ?>" 
													 class="img-fluid rounded"
													 style="max-height: 100px; object-fit: contain;">
											</div>
											<div class="col-md-4">
												<h6 class="mb-1"><?php echo htmlspecialchars($pname); ?></h6>
												<p class="mb-0 text-muted">Sold by: <?php echo htmlspecialchars($sname); ?></p>
											</div>
											<div class="col-md-5 text-end">
												<a href="review_product.php?product_id=<?php echo htmlspecialchars($pid); ?>" 
												   class="btn btn-success">Write Review</a>
											</div>
										</div>
									</div>
								</div>
								<?php
							}
						}
					}
					?>
					<div style="max-height: 400px; overflow-y: auto;">
						<?php
						include 'connection.php';
						$username = $_SESSION['username'];

						$sql1 = "SELECT * from customer where username= '$username'";
						$result1 = oci_parse($connection, $sql1);
						oci_execute($result1);

						while ($row = oci_fetch_assoc($result1)) {
							$cid = $row['CUSTOMER_ID'];
							$sql2 = " SELECT * FROM review WHERE Customer_Id='$cid'";
							$result2 = oci_parse($connection, $sql2);
							oci_execute($result2);

							while ($row = oci_fetch_assoc($result2)) {
								$rdate = $row['DATES'];
								$desc = $row['DESCRIPTION'];
								$rating2 = $row['RATING'];
								$rid = $row['REVIEW_ID'];
								$pid = $row['PRODUCT_ID'];

								$sql3 = " SELECT * FROM product WHERE Product_Id='$pid'";
								$result3 = oci_parse($connection, $sql3);
								oci_execute($result3);

								while ($row = oci_fetch_assoc($result3)) {
									$pname = $row['PRODUCT_NAME'];
									$sid = $row['SHOP_ID'];
									$pimage = $row['PRODUCT_IMAGE'];

									$sql4 = " SELECT * FROM shop WHERE Shop_Id='$sid'";
									$result4 = oci_parse($connection, $sql4);
									oci_execute($result4);

									while ($row = oci_fetch_assoc($result4)) {
										$sname = $row['SHOP_NAME'];
										?>
										<div class="card mb-3">
											<div class="card-header bg-light">
												<div class="row align-items-center">
													<div class="col bg-light">
														<strong class="bg-light">Reviewed on: <?php echo htmlspecialchars($rdate); ?></strong>
													</div>
												</div>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-md-6">
														<div class="mb-3">
															<img src="<?php echo htmlspecialchars($pimage); ?>" 
																 alt="<?php echo htmlspecialchars($pname); ?>" 
																 class="img-fluid rounded"
																 style="max-height: 150px; object-fit: contain;">
														</div>
														<h6><?php echo htmlspecialchars($pname); ?></h6>
													</div>
													<div class="col-md-6">
														<p class="mb-2"><strong>Sold by:</strong> <?php echo htmlspecialchars($sname); ?></p>
														<div class="mb-2">
															<?php include 'condition_checker/rating_conditional_2.php'; ?>
														</div>
														<div class="mb-2">
															<strong>Your Review:</strong>
															<p class="mb-0"><?php echo htmlspecialchars($desc); ?></p>
														</div>
														<div class="text-muted">
															<small>Status: Approved</small>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
									}
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
<?php include 'footer.php';
include 'end.php' ?>