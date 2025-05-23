<?php
ob_start();
@include 'start.php';
include 'connection.php';
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = "select * from product,shop where product_id = '$product_id' and product.shop_id = shop.shop_id";

    $result = oci_parse($connection, $query);
    oci_execute($result);

    while ($row = oci_fetch_assoc($result)) {
        $product_type = $row['PRODUCT_TYPE'];
        $product_name = $row['PRODUCT_NAME'];
        $product_price = $row['PRODUCT_PRICE'];
        $product_details = $row['PRODUCT_DETAILS'];
        $stock = $row['STOCK'];
        $product_image = $row['PRODUCT_IMAGE'];
        $shop_id = $row['SHOP_ID'];
        $shop_name = $row['SHOP_NAME'];
    }
} else {
    header('Location:index.php');
    exit();
}
?>

<?php
include 'connection.php';
$product_id = $_GET['product_id'];
$query = "SELECT *
FROM (
    SELECT r.*, c.Full_Name as Customer_Name
    FROM review r, customer c
    WHERE r.Customer_Id = c.Customer_Id
      AND Product_Id = :pid
)
WHERE ROWNUM <= 3
";
$statement = oci_parse($connection, $query);
oci_bind_by_name($statement, ':pid', $product_id);
oci_execute($statement);
?>

<?php include 'header.php'; ?>

<div class="container py-5">
    <?php if (isset($_POST['addtoCart'])) {
        $qty = $_POST['quantity'];
        if (!isset($_SESSION['username'])) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Please <a href="sign_in_customer.php" class="alert-link">Sign-In</a> to place an Order!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
        }
    } ?>

    <form action="manage_cart.php" method="POST">
        <div class="row">
            <!-- Product Image -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <img src="<?php echo $product_image; ?>" class="card-img-top p-4" 
                         alt="<?php echo $product_name; ?>" style="object-fit: contain; height: 400px;">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h1 class="h2 mb-3"><?php echo $product_name; ?></h1>
                        
                        <!-- Rating -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-2">Customer Rating</h5>
                            <div class="d-flex align-items-center">
                                <?php include 'condition_checker/rating_conditional.php'; ?>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-2">Price</h5>
                            <h3 class="text-success mb-0"><?php echo $product_price; ?></h3>
                        </div>

                        <!-- Seller Info -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-2">Seller Information</h5>
                            <p class="mb-2">
                                <strong>Sold by:</strong>
                                <a href="search_product.php?search_Cat=<?php echo $shop_name; ?>" 
                                   class="text-success ml-2">
                                    <?php echo $shop_name; ?>
                                </a>
                            </p>
                            <a href="search_product.php?search_Cat=<?php echo $shop_name; ?>" 
                               class="btn btn-outline-success btn-sm">
                                View more from this seller
                            </a>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-2">Availability</h5>
                            <?php if ($stock > 0): ?>
                                <span class="badge badge-success p-2">In Stock (<?php echo $stock; ?> available)</span>
                            <?php else: ?>
                                <span class="badge badge-danger p-2">Out of Stock</span>
                            <?php endif; ?>
                        </div>

                        <!-- Add to Cart -->
                        <?php if ($stock > 0): ?>
                            <div class="mb-4">
                                <h5 class="text-muted mb-2">Quantity</h5>
                                <div class="input-group" style="width: 150px;">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="decrementQuantity()">-</button>
                                    </div>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                           max="<?php echo $stock; ?>" class="form-control text-center">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="incrementQuantity()">+</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" name="addtoCart" class="btn btn-success btn-lg btn-block">
                                <i class="fas fa-shopping-cart mr-2" style="background-color: #28a745; color: white;"></i>Add to Cart
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="text-muted mb-3">Product Description</h5>
                        <p class="mb-0"><?php echo $product_details; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Customer Reviews -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h3 class="h4 mb-4">Customer Reviews</h3>
            <?php while ($review = oci_fetch_assoc($statement)): ?>
                <div class="review-item mb-4 pb-4 border-bottom">
                    <div class="d-flex align-items-center mb-2">
                        <div class="user-avatar mr-3">
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-0"><?php echo $review['CUSTOMER_NAME']; ?></h6>
                            <small class="text-muted">
                                <?php echo date('F j, Y', strtotime($review['REVIEW_DATE'])); ?>
                            </small>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $review['RATING'] ? 'text-warning' : 'text-muted'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mb-0"><?php echo $review['REVIEW_TEXT']; ?></p>
                </div>
            <?php endwhile; ?>
            
            <?php if (oci_num_rows($statement) == 0): ?>
                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['username'])): ?>
                <a href="review_product.php?product_id=<?php echo $product_id; ?>" 
                   class="btn btn-outline-success">
                    Write a Review
                </a>
            <?php else: ?>
                <a href="sign_in_customer.php" class="btn btn-outline-success">
                    Sign in to Write a Review
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .rating .fa-star {
        font-size: 1rem;
    }
    .review-item:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    .input-group .btn {
        padding: 0.375rem 1rem;
    }
    .input-group input[type="number"] {
        -moz-appearance: textfield;
    }
    .input-group input[type="number"]::-webkit-outer-spin-button,
    .input-group input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<script>
function incrementQuantity() {
    var input = document.getElementById('quantity');
    var max = parseInt(input.getAttribute('max'));
    var value = parseInt(input.value);
    if (value < max) {
        input.value = value + 1;
    }
}

function decrementQuantity() {
    var input = document.getElementById('quantity');
    var value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
    }
}
</script>

<?php include 'footer.php'; ?>

<?php
include 'end.php';
ob_end_flush();
?>