<?php include 'start.php';

if (!isset($_SESSION['username'])) {
    header('Location: sign_in_customer.php');
    exit();
}

$count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Debug information
echo "<!-- Debug Info: -->";
echo "<!-- Cart Count: " . $count . " -->";
if (isset($_SESSION['cart'])) {
    echo "<!-- Cart Contents: " . print_r($_SESSION['cart'], true) . " -->";
}
?>
<?php include 'header.php'; ?>

<div class="container py-5">
    <div class="row">
        <!-- Cart Items Column -->
        <div class="col-lg-8">
            <form method="POST" action="checkout.php">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 text-dark">
                            <i class="fas fa-shopping-cart mr-2 text-success"></i>
                            Shopping Cart (<?php echo $count; ?> items)
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <?php if ($count > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0">Product</th>
                                            <th class="border-0 text-center">Price</th>
                                            <th class="border-0 text-center">Quantity</th>
                                            <th class="border-0 text-center">Subtotal</th>
                                            <th class="border-0 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        if (isset($_SESSION['cart'])) {
                                            foreach ($_SESSION['cart'] as $key => $value) {
                                                $pimage = $value['image'];
                                                $stock = $value['stock'];
                                                $subtotal = $value['price'] * $value['quantity'];
                                                $total += $subtotal;
                                                echo "<tr>
                                                    <td class='align-middle'>
                                                        <div class='d-flex align-items-center'>
                                                            <img src='$pimage' class='img-fluid rounded' style='width: 80px; height: 80px; object-fit: cover;'>
                                                            <div class='ml-3'>
                                                                <h6 class='mb-0'>$value[item_name]</h6>
                                                                <input type='hidden' name='pname' value='$value[item_name]'>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class='align-middle text-center'>
                                                        <span class='text-success font-weight-bold'>Rs. $value[price]</span>
                                                        <input type='hidden' name='pprice' value='$value[price]'>
                                                    </td>
                                                    <td class='align-middle text-center'>
                                                        <div class='input-group input-group-sm mx-auto' style='width: 120px;'>
                                                            <div class='input-group-prepend'>
                                                                <button type='button' class='btn btn-outline-secondary' onclick='decrementQuantity(this)'>-</button>
                                                            </div>
                                                            <input type='number' class='form-control text-center iquantity' name='Mod_Quantity' 
                                                                   onchange='updateQuantity(this)' min='1' max='$stock' value='$value[quantity]'>
                                                            <div class='input-group-append'>
                                                                <button type='button' class='btn btn-outline-secondary' onclick='incrementQuantity(this)'>+</button>
                                                            </div>
                                                        </div>
                                                        <input type='hidden' name='item_name' value='$value[item_name]'>
                                                    </td>
                                                    <td class='align-middle text-center'>
                                                        <span class='text-success font-weight-bold'>Rs. $subtotal</span>
                                                    </td>
                                                    <td class='align-middle text-center'>
                                                        <a href='manage_cart.php?value=$value[item_name]' class='btn btn-link text-danger p-0'>
                                                            <i class='fas fa-trash-alt'></i>
                                                        </a>
                                                    </td>
                                                </tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Your cart is empty</h5>
                                <a href="index.php" class="btn btn-success mt-3">Start Shopping</a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($count > 0): ?>
                        <div class="card-footer bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="index.php" class="btn btn-outline-success">
                                    <i class="fas fa-arrow-left mr-2"></i>Continue Shopping
                                </a>
                                <a href="manage_cart.php?d" class="btn btn-outline-danger">
                                    <i class="fas fa-trash-alt mr-2"></i>Clear Cart
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
        </div>

        <!-- Order Summary Column -->
        <div class="col-lg-4">
            <?php if ($count > 0): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-receipt mr-2 text-success"></i>
                            Order Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span class="text-success font-weight-bold">Rs. <?php echo $total; ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success font-weight-bold">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tax</span>
                            <span class="text-success font-weight-bold">Rs. 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="font-weight-bold">Total</span>
                            <span class="text-success font-weight-bold">Rs. <?php echo $total; ?></span>
                        </div>
                        <button type="submit" class="btn btn-success btn-block py-3" name="checkout" style="background-color: #28a745; ">
                            <i class="fas fa-lock mr-2" style="background-color: #28a745; color: white;"></i>Proceed to Checkout
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script>
    function incrementQuantity(button) {
        let input = button.parentElement.parentElement.querySelector('input');
        let max = parseInt(input.getAttribute('max'));
        let value = parseInt(input.value);
        if (value < max) {
            input.value = value + 1;
            updateQuantity(input);
        }
    }

    function decrementQuantity(button) {
        let input = button.parentElement.parentElement.querySelector('input');
        let value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
            updateQuantity(input);
        }
    }

    function updateQuantity(input) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = 'manage_cart.php';

        let quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'Mod_Quantity';
        quantityInput.value = input.value;

        let itemNameInput = document.createElement('input');
        itemNameInput.type = 'hidden';
        itemNameInput.name = 'item_name';
        itemNameInput.value = input.parentElement.parentElement.querySelector('input[name="item_name"]').value;

        form.appendChild(quantityInput);
        form.appendChild(itemNameInput);
        document.body.appendChild(form);
        form.submit();
    }
</script>

<?php
include 'footer.php';
include 'end.php';
?>