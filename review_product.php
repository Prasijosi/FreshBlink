<?php
@include 'start.php';

$is_authenticated = !isset($_SESSION['username']);

include 'connection.php';

// Handle review submission first — before any HTML output
if (isset($_POST['review'])) {
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    $product_id = $_GET['product_id'];
    @$customer_id = @$_SESSION['customer_id'];

    $sql1 = "INSERT INTO review (Rating, Description, Customer_Id, Product_Id, Dates, Review_Status)
             VALUES (:rating, :description, :customer_id, :product_id, SYSDATE, 0)";
    $stmt = oci_parse($connection, $sql1);
    oci_bind_by_name($stmt, ':rating', $rating);
    oci_bind_by_name($stmt, ':description', $description);
    oci_bind_by_name($stmt, ':customer_id', $customer_id);
    oci_bind_by_name($stmt, ':product_id', $product_id);

    if (oci_execute($stmt)) {
        header("Location: product_details.php?product_id=$product_id&msg=Product Successfully Reviewed");
        exit();
    } else {
        header("Location: product_details.php?product_id=$product_id&msg=Error Reviewing the Product");
        exit();
    }
}

$product_name = '';
$product_image = '';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    @$customer_id = @$_SESSION['customer_id'];

    $sql = "SELECT * FROM product WHERE Product_Id = :product_id";
    $result = oci_parse($connection, $sql);
    oci_bind_by_name($result, ':product_id', $product_id);
    oci_execute($result);

    if ($row = oci_fetch_assoc($result)) {
        $product_name = $row['PRODUCT_NAME'];
        $product_image = $row['PRODUCT_IMAGE'];
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<style>
    .star-rating .fa-star {
        font-size: 1.5rem;
        cursor: pointer;
        color: #ddd;
    }

    .star-rating .fa-star.checked {
        color: #f0ad4e;
    }
</style>

<?php if (!$is_authenticated): ?>
  <div class="container review-container py-5">
    <h3 class="text-center mb-4">Review Product: <?php echo htmlspecialchars($product_name); ?></h3>
    <div class="text-center mb-4">
      <img src="<?php echo htmlspecialchars($product_image); ?>" class="img-fluid" style="max-height: 200px;">
    </div>

    <form method="POST">
      <div class="mb-4 text-center star-rating">
        <input type="hidden" name="rating" id="rating-value" value="1">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <i class="fa fa-star" data-index="<?= $i ?>"></i>
          <?php endfor; ?>
      </div>

      <div class="mb-4 text-center">
        <textarea name="description" class="form-control w-75 mx-auto" placeholder="Write your review here..." rows="5"
                  required></textarea>
      </div>

      <div class="text-center">
        <button type="submit" name="review" class="btn btn-success px-4">Submit Review</button>
      </div>
    </form>
  </div>
<?php else: ?>
  <div class="container py-5 text-center">
    <div class="alert alert-info">
      <h4 style="background-color: transparent;">Please <a href="sign_in_customer.php" class="alert-link">sign in</a> to
        leave a review</h4>
      <p style="background-color: transparent;">You must be logged in to submit a product review.</p>
    </div>
  </div>
<?php endif; ?>

<?php include 'end.php'; ?>

<script>
  const stars = document.querySelectorAll(".fa-star");
  const ratingInput = document.getElementById("rating-value");
  let currentRating = 1;

  stars.forEach((star, index) => {
    star.addEventListener("click", () => {
      currentRating = index + 1;
      ratingInput.value = currentRating;
      highlightStars(currentRating);
    });
    star.addEventListener("mouseover", () => highlightStars(index + 1));
    star.addEventListener("mouseout", () => highlightStars(currentRating));
  });

  function highlightStars(count) {
    stars.forEach((star, idx) => {
      star.classList.toggle("checked", idx < count);
    });
  }

  highlightStars(1);
</script>
