<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
	header('Location:../trader/sign_in_trader.php');
	exit();
}

include 'theader.php';

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "<script>alert('" . $msg . "');</script>";
} else {
	echo "";
}

?>
<div class="container-fluid main-content">

	<div class="card shadow-sm">
		<div class="card-body">
			<div class="row mb-3">
				<div class="col-md-6 d-flex align-items-center">
					<?php
					include 'connection.php';

					$sql = " SELECT * FROM  product, shop, trader where trader.Trader_Id=shop.Trader_id  and shop.Shop_Id=product.Shop_Id  and product.Product_Verification='0'";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);

					$count3 = oci_fetch_all($qry, $connection);
					oci_execute($qry);

					echo "<h5 class='mb-0'>New Product Request : $count3</h5>";
					?>
				</div>

				<div class="col-md-6">
					<form action="#" method="GET" class="d-flex justify-content-end align-items-center">
						<span class="me-2">Sort By:</span>
						<select name="category" class="form-select sort-select me-2" style="width: auto;">
							<option value="recent">Recent</option>
							<option value="name_asc">Product Name (A-Z)</option>
							<option value="name_desc">Product Name (Z-A)</option>
							<option value="type_asc">Product Type (A-Z)</option>
							<option value="type_desc">Product Type (Z-A)</option>
							<option value="price_asc">Price (Low to High)</option>
							<option value="price_desc">Price (High to Low)</option>
						</select>
						<button type="submit" class="btn btn-dark btn-sm">Go</button>
					</form>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr class="bg-light">
							<th>SN</th>
							<th>Product Name</th>
							<th>Product Type</th>
							<th>Product Image</th>
							<th>Price</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include 'connection.php';
						$sql = "SELECT * FROM product, shop, trader WHERE trader.Trader_Id=shop.Trader_id AND shop.Shop_Id=product.Shop_Id AND Product_Verification='0'";
						
						// Add sorting logic
						if (isset($_GET['category'])) {
							$sort = $_GET['category'];
							switch($sort) {
								case 'name_asc':
									$sql .= " ORDER BY product.PRODUCT_NAME ASC";
									break;
								case 'name_desc':
									$sql .= " ORDER BY product.PRODUCT_NAME DESC";
									break;
								case 'type_asc':
									$sql .= " ORDER BY product.PRODUCT_TYPE ASC";
									break;
								case 'type_desc':
									$sql .= " ORDER BY product.PRODUCT_TYPE DESC";
									break;
								case 'price_asc':
									$sql .= " ORDER BY product.PRODUCT_PRICE ASC";
									break;
								case 'price_desc':
									$sql .= " ORDER BY product.PRODUCT_PRICE DESC";
									break;
								default:
									$sql .= " ORDER BY product.PRODUCT_ID DESC"; // Recent by default
							}
						} else {
							$sql .= " ORDER BY product.PRODUCT_ID DESC"; // Recent by default
						}
						
						$qry = oci_parse($connection, $sql);
						oci_execute($qry);
						$s = 0;
						while ($row = oci_fetch_assoc($qry)) {
							$pid = $row['PRODUCT_ID'];
							$tname = $row['NAME'];
							$sname = $row['SHOP_NAME'];
							$pimage = $row['PRODUCT_IMAGE'];
							$pname = $row['PRODUCT_NAME'];
							$ptype = $row['PRODUCT_TYPE'];
							$check = $row['PRODUCT_VERIFICATION'];
							$pprice = $row['PRODUCT_PRICE'];
							$s = $s + 1;
							?>
							<tr>
								<td class="text-center"><?php echo $s; ?></td>
								<td class="text-center"><?php echo $pname; ?></td>
								<td class="text-center"><?php echo $ptype; ?></td>
								<td class="text-center">
									<img src="../<?php echo $pimage; ?>" class="product-image" alt="Product Image">
								</td>
								<td class="text-center">$<?php echo number_format($pprice, 2); ?></td>
								<td class="text-center">
									<form method="POST" action="product_request_process.php" class="d-inline">
										<input type="hidden" name="pid" value="<?php echo $pid; ?>">
										<?php if ($check == 1): ?>
											<button type="submit" class="btn btn-success btn-sm me-2" name="submit" disabled>Approve</button>
											<button type="submit" class="btn btn-danger btn-sm" name="submit2">Decline</button>
										<?php else: ?>
											<button type="submit" class="btn btn-success btn-sm me-2" name="submit">Approve</button>
											<button type="submit" class="btn btn-danger btn-sm" name="submit2" disabled>Decline</button>
										<?php endif; ?>
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<style>
	.sort-select {
		min-width: 150px;
		height: 32px;
		border: 1px solid #dee2e6;
		border-radius: 4px;
		padding: 0.3rem 0.5rem;
		font-size: 0.85rem;
		background-color: #fff;
		box-shadow: 0 1px 2px rgba(0,0,0,0.05);
	}

	.sort-select:focus {
		border-color: #80bdff;
		box-shadow: 0 0 0 0.1rem rgba(0,123,255,.25);
	}

	.table {
		margin-bottom: 0;
	}

	.table thead th {
		border-bottom: 2px solid #dee2e6;
		color: #495057;
		font-weight: 600;
		font-size: 0.95rem;
		padding: 1rem;
	}

	.table tbody td {
		vertical-align: middle;
		padding: 1rem;
		font-size: 0.95rem;
	}

	.table tbody tr {
		transition: all 0.2s ease;
	}

	.table tbody tr:hover {
		background-color: #f8f9fa;
	}

	.product-image {
		width: 80px;
		height: 80px;
		object-fit: cover;
		border-radius: 4px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}

	.btn-sm {
		padding: 0.4rem 0.8rem;
		font-size: 0.85rem;
	}

	@media (max-width: 576px) {
		.sort-select, .btn {
			width: 100%;
			margin-bottom: 0.5rem;
		}
		form.d-flex {
			flex-direction: column;
			gap: 0.5rem;
		}
		.product-image {
			width: 60px;
			height: 60px;
		}
	}
</style>
<?php include 'tfooter.php'; ?>