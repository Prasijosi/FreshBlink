<?php include 'start.php';

if (!isset($_SESSION['username'])) {
	header('Location: sign_in_customer.php');
	exit();
}

$count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<?php include 'header.php'; ?>

<div>
<div class="row mt-5">
  <!-- Cart Items Column -->
  <div class="col-lg-8">
    <form method="POST" action="checkout.php">
      <div class="card shadow mb-4">
        <div class="card-header bg-light text-dark">
          <h4 class="mb-0 bg-light">Shopping Cart (<?php echo $count; ?> items)</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead class="thead-dark">
                <tr>
                  <th>Image</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Subtotal</th>
                  <th>Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total = 0;
                if (isset($_SESSION['cart'])) {
                  foreach ($_SESSION['cart'] as $key => $value) {
                    $pimage = $value['image'];
                    $stock = $value['stock'];
                    echo "<tr>
                      <td><img src='$pimage' class='img-fluid' style='height: 60px;'></td>
                      <td>$value[item_name]<input type='hidden' class='pname' name='pname' value='$value[item_name]'></td>
                      <td>Rs. $value[price]<input type='hidden' class='iprice' name='pprice' value='$value[price]'></td>
                      <td><input type='number' class='form-control iquantity text-center' name='Mod_Quantity' onchange='this.form.submit()' min='1' max='$stock' value='$value[quantity]'><input type='hidden' name='item_name' value='$value[item_name]'></td>
                      <td class='itotal'></td>
                      <td><a href='manage_cart.php?value=$value[item_name]'><i class='fas fa-times text-danger'></i></a></td>
                    </tr>";
                  }
                }
                ?>
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center my-3">
            <a href="index.php" class="btn btn-info">Continue Shopping</a>
            <?php if ($count > 0): ?>
              <a href="manage_cart.php?d" class="btn btn-secondary">Clear Cart</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
  </div>

  <!-- Order Summary Column -->
  <div class="col-lg-4">
    <?php if ($count > 0): ?>
      <div class="card shadow">
        <div class="card-body">
          <h5 class="mb-4">Order Summary</h5>
          <div class="row">
            <div class="col-6">Discount</div>
            <div class="col-6 text-end">Rs. 0</div>
          </div>
          <div class="row mt-2">
            <div class="col-6">Sub-Total</div>
            <div class="col-6 text-end">Rs. <span id="subtotalText">0</span></div>
          </div>
          <hr>
          <div class="row mt-2 fw-bold">
            <div class="col-6">Order Total</div>
            <div class="col-6 text-end" id="gtotal">Rs. 0</div>
          </div>
          <button type="submit" class="btn btn-success w-100 mt-4" name="checkout">Proceed to Checkout</button>
        </div>
      </div>
    <?php endif; ?>
    </form>
  </div>
</div>


<script>
	document.addEventListener('DOMContentLoaded', function () {
		let gt = 0;
		let iprice = document.getElementsByClassName('iprice');
		let iquantity = document.getElementsByClassName('iquantity');
		let itotal = document.getElementsByClassName('itotal');
		let gtotal = document.getElementById('gtotal');

		function subTotal() {
			gt = 0;
			for (let i = 0; i < iprice.length; i++) {
				let subtotal = iprice[i].value * iquantity[i].value;
				itotal[i].innerText = 'Rs. ' + subtotal;
				gt += subtotal;
			}
			gtotal.innerText = 'Rs. ' + gt;
		}

		subTotal();
	});
</script>

<?php
include 'footer.php';
include 'end.php';
?>
