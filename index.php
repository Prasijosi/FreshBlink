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

      <h3 class="font-weight-bold my-4">Featured Categories</h3>
      <div class="featured-categories-row">
        <a href="search_product.php?search_Txt=&search_Cat=Bakery" class="featured-category-card bakery">
          <img src="images/bakery.png" alt="Bakery">
          <div class="cat-title">
            Bakery
          </div>
        </a>
        <a href="search_product.php?search_Txt=&search_Cat=Butcher" class="featured-category-card greengrocer">
          <img src="images/butcher.png" alt="Butchery">
          <div class="cat-title">
            Butcher
          </div>
        </a>

        <a href="search_product.php?search_Txt=&search_Cat=Greengrocery" class="featured-category-card greengrocer">
          <img src="images/greengrocery.png" alt="Greengrocer">
          <div class="cat-title">Green grocery</div>
        </a>
        <a href="search_product.php?search_Txt=&search_Cat=Delicatesssen" class="featured-category-card delicatessen">
          <img src="images/delicatessen.png" alt="Delicatessen">
          <div class="cat-title">
            Delicatessen
          </div>
        </a>
        <a href="search_product.php?search_Txt=&search_Cat=Fishmonger" class="featured-category-card fishmonger">
          <img src="images/fishmonger.png" alt="Fishmonger">
          <div class="cat-title">
            Fish Monger
          </div>
        </a>
      </div>

      <div class="container my-5">
        <h3 class="font-weight-bold mb-4">Popular Products</h3>
        <div class="row">
            <?php foreach (array_slice($popular_products, 5, length: 6) as $product): ?>
              <a href="<?= $product['link'] ?>" class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px;">
                  <img src="<?= $product['img'] ?>" class="card-img-top p-3"
                       alt="<?= htmlspecialchars($product['name']) ?>" style="height:120px;object-fit:contain;">
                  <div class="card-body text-center p-2">
                    <div class="small text-muted"><?= htmlspecialchars($product['category']) ?></div>
                    <div class="font-weight-bold mb-1"><?= htmlspecialchars($product['name']) ?></div>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
        </div>
      </div>

      <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="font-weight-bold">Deals Of The Day</h3>
        </div>
        <div class="row">
            <?php foreach (array_slice($popular_products, 0, 4) as $product): ?>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 18px;">
                  <img src="<?= $product['img'] ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>"
                       style="height:180px;object-fit:cover;border-top-left-radius:18px;border-top-right-radius:18px;">
                  <div class="card-body" style="border-radius:0 0 18px 18px;">
                    <div class="font-weight-bold mb-1"
                         style="font-size:1.1rem;"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="small text-muted mb-2"><?= htmlspecialchars($product['category']) ?></div>
                    <a href="<?= $product['link'] ?>" class="btn btn-danger btn-block font-weight-bold"
                       style="border-radius:8px;">View Deal</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
        </div>
      </div>
    </section>
  </div>
<?php include 'footer.php';
include 'end.php'; ?>