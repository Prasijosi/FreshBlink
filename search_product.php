<?php include 'start.php';
include 'condition_checker/get_all_products.php';
include 'condition_checker/search_conditonal.php';

// Get unique categories from the database
$category_query = "SELECT DISTINCT PRODUCT_TYPE FROM product WHERE product_verification = '1' ORDER BY PRODUCT_TYPE";
$category_result = oci_parse($connection, $category_query);
oci_execute($category_result);

$categories = [];
while ($row = oci_fetch_assoc($category_result)) {
  $categories[] = $row['PRODUCT_TYPE'];
}

// Get unique traders from the database
$trader_query = "SELECT DISTINCT t.NAME 
                 FROM trader t 
                 INNER JOIN shop s ON t.TRADER_ID = s.TRADER_ID 
                 INNER JOIN product p ON s.SHOP_ID = p.SHOP_ID 
                 WHERE p.PRODUCT_VERIFICATION = '1' 
                 ORDER BY t.NAME";
$trader_result = oci_parse($connection, $trader_query);
oci_execute($trader_result);

$traders = [];
while ($row = oci_fetch_assoc($trader_result)) {
  $traders[] = $row['NAME'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Search</title>
  <!-- Bootstrap 4.0 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    :root {
      --brand-green: #28a745;
      --brand-green-light: #e6f4ea;
      --brand-green-hover: #218838;
    }

    body {
      background: #f8f9fa;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .sidebar {
      position: sticky;
      top: 1rem;
    }

    .filter-box {
      background: #fff;
      border: 1px solid var(--brand-green-light);
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .filter-box:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-color: var(--brand-green);
    }

    .filter-box label {
      font-weight: 600;
      margin-bottom: 0.75rem;
      display: block;
      color: #495057;
    }

    .form-control {
      border-radius: 8px;
      border: 1px solid #dee2e6;
      padding: 0.75rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--brand-green);
      box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .btn-success {
      background-color: var(--brand-green);
      border-color: var(--brand-green);
      border-radius: 8px;
      padding: 0.75rem 1.5rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-success:hover {
      background-color: var(--brand-green-hover);
      border-color: var(--brand-green-hover);
      transform: translateY(-1px);
    }

    .results-header {
      font-weight: 600;
      color: #2c3e50;
      margin: 1.5rem 0 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid var(--brand-green);
    }

    .card-products {
      border: none;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .card-products:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background: var(--brand-green);
      color: white;
      font-weight: 600;
      border-radius: 10px 10px 0 0 !important;
      padding: 1rem 1.5rem;
    }

    .table {
      margin-bottom: 0;
    }

    .table thead th {
      background: var(--brand-green-light);
      border-bottom: none;
      color: #495057;
      font-weight: 600;
      padding: 1rem;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background: #f8f9fa;
    }

    .product-thumb {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .product-thumb:hover {
      transform: scale(1.05);
    }

    .no-results {
      text-align: center;
      padding: 3rem;
      color: #6c757d;
      font-style: italic;
    }

    .search-form {
      background: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      margin-bottom: 1.5rem;
    }

    .search-form .form-control {
      border-radius: 8px 0 0 8px;
    }

    .search-form .btn {
      border-radius: 0 8px 8px 0;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>

  <div class="container-fluid py-5">
    <div class="row">
      <!-- Sidebar Filters -->
      <div class="col-lg-3">
        <div class="sidebar">
          <!-- Category Filter -->
          <div class="filter-box">
            <form method="POST" action="search_product.php">
              <label for="product_Category">
                <i class="fas fa-tags mr-2"></i>Product Category
              </label>
              <select id="product_Category" name="product_Category" class="form-control mb-3">
                <option value="">— All Categories —</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= htmlspecialchars($cat) ?>" <?= ($product_Category === $cat) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <button type="submit" name="submit1" class="btn btn-success btn-block">
                <i class="fas fa-filter mr-2" style="background-color: #28a745; color: white;"></i>Filter Category
              </button>
            </form>
          </div>

          <!-- Traders Filter -->
          <div class="filter-box">
            <form method="POST" action="search_product.php">
              <label for="traders">
                <i class="fas fa-store mr-2"></i>Traders
              </label>
              <select id="traders" name="traders" class="form-control mb-3">
                <option value="">— All Traders —</option>
                <?php foreach ($traders as $tr): ?>
                  <option value="<?= htmlspecialchars($tr) ?>" <?= (isset($_POST['traders']) && $_POST['traders'] === $tr) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tr) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <button type="submit" name="submit2" class="btn btn-success btn-block">
                <i class="fas fa-filter mr-2" style="background-color: #28a745; color: white;"></i>Filter Trader
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Products & Search -->
      <div class="col-lg-9">
        <!-- Search Form -->
        <form method="POST" action="search_product.php" class="search-form">
          <div class="input-group">
            <input type="text" name="search_Txt" class="form-control"
              placeholder="Search products..." value="<?= htmlspecialchars($search_Txt) ?>">
            <div class="input-group-append">
              <button class="btn btn-success" type="submit" name="submit_search">
                <i class="fas fa-search mr-2" style="background-color: #28a745; color: white;"></i>Search
              </button>
            </div>
          </div>
        </form>

        <h4 class="results-header">
          <i class="fas fa-list mr-2"></i>
          <?= $count ?> items found for
          <?php if ($search_Txt): ?>
            "<?= ucfirst(htmlspecialchars($search_Txt)) ?>"
          <?php elseif ($search_Cat): ?>
            "<?= ucfirst(htmlspecialchars($search_Cat)) ?>"
          <?php elseif ($product_Category): ?>
            "<?= ucfirst(htmlspecialchars($product_Category)) ?>"
          <?php elseif (isset($_POST['traders']) && $_POST['traders']): ?>
            "<?= ucfirst(htmlspecialchars($_POST['traders'])) ?>"
          <?php else: ?>
            "<?= $search_Txt || $search_Cat || $product_Category || (isset($_POST['traders']) ? $_POST['traders'] : '') ?>"
          <?php endif; ?>
        </h4>

        <?php if ($count > 0): ?>
          <div class="card card-products">
            <div class="card-header" style="background-color: #28a745; color: white;">
              <i class="fas fa-box mr-2" style="background-color: #28a745; color: white;"></i>Product Results
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">S.No</th>
                      <th class="text-center">Image</th>
                      <th>Name</th>
                      <th class="text-center">Price</th>
                      <th class="text-center">Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($products as $index => $product): ?>
                      <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td class="text-center">
                          <a href="product_details.php?product_id=<?= $product['id'] ?>">
                            <img src="<?= htmlspecialchars($product['image']) ?>"
                              alt="<?= htmlspecialchars($product['name']) ?>"
                              class="product-thumb">
                          </a>
                        </td>
                        <td>
                          <a href="product_details.php?product_id=<?= $product['id'] ?>"
                            class="text-dark">
                            <?= htmlspecialchars($product['name']) ?>
                          </a>
                        </td>
                        <td class="text-center text-success font-weight-bold">
                          £<?= htmlspecialchars($product['price']) ?>
                        </td>
                        <td class="text-center">
                          <a href="product_details.php?product_id=<?= $product['id'] ?>"
                            class="btn btn-sm btn-success">
                            <i class="fas fa-eye mr-1"
                              style="background-color: #28a745; color: white;"></i>View
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="no-results">
            <i class="fas fa-search fa-3x mb-3 text-muted"></i>
            <h5>No products match your filters.</h5>
            <p class="text-muted">Try adjusting your search criteria</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>