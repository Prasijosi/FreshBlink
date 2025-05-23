<?php include 'start.php';
include 'condition_checker/get_all_products.php';
?>

<?php include 'header.php';
if (isset($_GET['msg'])) {
  $user_created_msg = $_GET['msg'];
  echo "
                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 d-flex align-items-center justify-content-center' style='text-align: center; color:green;'>" . $user_created_msg . "
                        </div>
                    </div>";
}
?>

<div class="container-fluid">
  <section class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100 img-fluid" src="images/image_slider_01.png" alt="First Slide">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container my-4">
      <div class="row">
        <a href="search_product.php?search_Txt=&search_Cat=" class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100 img-fluid" src="images/shop_now_1.jpg" alt="First Slide">
              </div>
            </div>
          </div>
        </a>
        <a href="search_product.php?search_Txt=&search_Cat=" class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100 img-fluid" src="images/shop_now_2.jpg" alt="First Slide">
              </div>
            </div>
          </div>
        </a>
        <a href="search_product.php?search_Txt=&search_Cat=" class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100 img-fluid" src="images/shop_now_3.jpg" alt="First Slide">
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- Featured Categories -->
    <section class="container mb-5">
      <h2 class="section-title mb-4">Featured Categories</h2>
      <div class="row">
        <div class="col-6 col-md-4 col-lg-2-4 mb-4">
          <a href="search_product.php?search_Txt=&search_Cat=Bakery" class="text-decoration-none">
            <div class="category-card text-center p-3">
              <div class="category-icon mb-3">
                <img src="images/bakery.png" alt="Bakery" class="img-fluid">
              </div>
              <h5 class="category-title mb-0">Bakery</h5>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4 mb-4">
          <a href="search_product.php?search_Txt=&search_Cat=Butcher" class="text-decoration-none">
            <div class="category-card text-center p-3">
              <div class="category-icon mb-3">
                <img src="images/butcher.png" alt="Butchery" class="img-fluid">
              </div>
              <h5 class="category-title mb-0">Butcher</h5>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4 mb-4">
          <a href="search_product.php?search_Txt=&search_Cat=Greengrocery" class="text-decoration-none">
            <div class="category-card text-center p-3">
              <div class="category-icon mb-3">
                <img src="images/greengrocery.png" alt="Greengrocer" class="img-fluid">
              </div>
              <h5 class="category-title mb-0">Green Grocery</h5>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4 mb-4">
          <a href="search_product.php?search_Txt=&search_Cat=Delicatesssen" class="text-decoration-none">
            <div class="category-card text-center p-3">
              <div class="category-icon mb-3">
                <img src="images/delicatessen.png" alt="Delicatessen" class="img-fluid">
              </div>
              <h5 class="category-title mb-0">Delicatessen</h5>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4 mb-4">
          <a href="search_product.php?search_Txt=&search_Cat=Fishmonger" class="text-decoration-none">
            <div class="category-card text-center p-3">
              <div class="category-icon mb-3">
                <img src="images/fishmonger.png" alt="Fishmonger" class="img-fluid">
              </div>
              <h5 class="category-title mb-0">Fish Monger</h5>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- Popular Products -->
    <section class="container mb-5">
      <h2 class="section-title mb-4">Popular Products</h2>
      <div class="row">
        <?php foreach (array_slice($popular_products, 5, length: 6) as $product): ?>
          <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
            <div class="card product-card h-100 border-0 shadow-sm">
              <div class="product-image-container">
                <img src="<?= $product['img'] ?>" class="card-img-top p-3"
                  alt="<?= htmlspecialchars($product['name']) ?>">
              </div>
              <div class="card-body text-center">
                <div class="product-category small text-muted mb-1">
                  <?= htmlspecialchars($product['category']) ?>
                </div>
                <h5 class="product-title mb-2">
                  <?= htmlspecialchars($product['name']) ?>
                </h5>
                <a href="<?= $product['link'] ?>" class="btn btn-outline-success btn-sm">View Details</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Deals of the Day -->
    <section class="container mb-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">Deals of the Day</h2>
        <a href="search_product.php" class="btn btn-link text-success">View All</a>
      </div>
      <div class="row">
        <?php foreach (array_slice($popular_products, 0, 4) as $product): ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card deal-card h-100 border-0 shadow-sm">
              <div class="deal-badge">Special Offer</div>
              <img src="<?= $product['img'] ?>" class="card-img-top"
                alt="<?= htmlspecialchars($product['name']) ?>">
              <div class="card-body">
                <h5 class="card-title mb-1">
                  <?= htmlspecialchars($product['name']) ?>
                </h5>
                <p class="card-text text-muted small mb-3">
                  <?= htmlspecialchars($product['category']) ?>
                </p>
                <a href="<?= $product['link'] ?>" class="btn btn-danger btn-block">
                  View Deal
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <style>
      .section-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #333;
        position: relative;
        padding-bottom: 0.5rem;
      }

      .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background-color: #28a745;
      }

      .category-card {
        background: #fff;
        border-radius: 10px;
        transition: transform 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      }

      .category-card:hover {
        transform: translateY(-5px);
      }

      .category-icon img {
        max-height: 60px;
        object-fit: contain;
      }

      .category-title {
        color: #333;
        font-size: 0.9rem;
        font-weight: 500;
      }

      .product-card {
        border-radius: 10px;
        transition: transform 0.3s ease;
      }

      .product-card:hover {
        transform: translateY(-5px);
      }

      .product-image-container {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .product-image-container img {
        max-height: 100%;
        object-fit: contain;
      }

      .product-title {
        font-size: 0.9rem;
        font-weight: 500;
        color: #333;
      }

      .deal-card {
        border-radius: 15px;
        overflow: hidden;
      }

      .deal-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #dc3545;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
      }

      .deal-card img {
        height: 200px;
        object-fit: cover;
      }

      .hero-section .carousel-item {
        height: 400px;
      }

      .hero-section .carousel-item img {
        object-fit: cover;
        height: 100%;
      }

      .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        padding: 2rem;
        border-radius: 10px;
      }
    </style>

    <?php include 'footer.php';
    include 'end.php'; ?>