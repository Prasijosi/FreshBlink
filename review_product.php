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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style>
  body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
  }

  .review-container {
    width: 500px !important;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .product-image {
    max-height: 200px;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }

  .product-image:hover {
    transform: scale(1.02);
  }

  .star-rating {
    margin: 2rem 0;
  }

  .star-rating .fa-star {
    font-size: 2rem;
    cursor: pointer;
    color: #ddd;
    transition: color 0.2s ease;
    margin: 0 0.2rem;
  }

  .star-rating .fa-star.checked {
    color: #ffc107;
  }

  .star-rating .fa-star:hover {
    transform: scale(1.1);
  }

  .review-textarea {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 1rem;
    transition: border-color 0.3s ease;
    resize: none;
  }

  .review-textarea:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
  }

  .btn-submit {
    padding: 0.8rem 2.5rem;
    font-size: 1.1rem;
    border-radius: 50px;
    transition: all 0.3s ease;
    background: #28a745;
    border: none;
    color: white;
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    background: #218838;
  }

  .alert {
    border-radius: 10px;
    padding: 1.5rem;
    margin: 2rem auto;
    max-width: 600px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .alert-link {
    font-weight: 600;
    text-decoration: none;
  }

  .alert-link:hover {
    text-decoration: underline;
  }

  .page-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.5rem;
  }

  .page-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: #28a745;
    border-radius: 3px;
  }
</style>

<?php include 'header.php'; ?>

<?php if (!$is_authenticated): ?>
  <div class="container review-container">
    <h3 class="text-center page-title">Review Product: <?php echo htmlspecialchars($product_name); ?></h3>

    <div class="text-center mb-4">
      <img src="<?php echo htmlspecialchars($product_image); ?>" class="product-image" alt="<?php echo htmlspecialchars($product_name); ?>">
    </div>

    <form method="POST">
      <div class="text-center star-rating">
        <input type="hidden" name="rating" id="rating-value" value="1">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <i class="fa fa-star" data-index="<?= $i ?>"></i>
        <?php endfor; ?>
      </div>

      <div class="form-group">
        <textarea name="description" class="form-control review-textarea"
          placeholder="Share your experience with this product..."
          rows="5" required></textarea>
      </div>

      <div class="text-center mt-4">
        <button type="submit" name="review" class="btn btn-submit">
          <i class="fa fa-paper-plane mr-2" style="background-color: #28a745; color: white;"></i>Submit Review
        </button>
      </div>
    </form>
  </div>
<?php else: ?>
  <div class="container">
    <div class="alert alert-info">
      <h4 class="alert-heading mb-3">
        <i class="fa fa-info-circle mr-2"></i>Sign In Required
      </h4>
      <p class="mb-0">Please <a href="sign_in_customer.php" class="alert-link">sign in</a> to leave a review.</p>
      <p class="mb-0 mt-2">You must be logged in to submit a product review.</p>
    </div>
  </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
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

    star.addEventListener("mouseover", () => {
      highlightStars(index + 1);
      star.style.transform = "scale(1.2)";
    });

    star.addEventListener("mouseout", () => {
      highlightStars(currentRating);
      star.style.transform = "scale(1)";
    });
  });

  function highlightStars(count) {
    stars.forEach((star, idx) => {
      star.classList.toggle("checked", idx < count);
    });
  }

  highlightStars(1);
</script>