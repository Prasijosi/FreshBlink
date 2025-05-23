<?php
include 'start.php';
?>
<?php include 'header.php'; ?>

<div class="container w-100 d-flex align-items-center justify-content-center">
	<div class="row mt-3">
		<?php
		if (isset($_GET['msg'])) {
			$user_created_msg = $_GET['msg'];
			echo "<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 d-flex align-items-center justify-content-center' style='color:red;'>" . $user_created_msg . "
 			</div>";
		}
		?>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-5">
			<a href="index.php">
				<img src="images/logo.png" class="img-fluid" style="width: 70px; height: 70px;">
			</a>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-3">
			<form class="border p-5 mt-2" method="POST" action="customer/customer_email_verify_process.php">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
						<div class="h4 mt-1">Verify Your Email</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Email</label>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">6-Digit Code</label>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<input type="number" class="form-control" id="pincode" placeholder="6-Digit Code" name="pincode" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
						<button type="submit" class="btn btn-success" name="submit">Verify Email</button>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
						<a href="sign_in_customer.php" style="font-size: 1vw">Back to Sign In</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
<?php include 'end.php' ?>