<?php include 'start.php';
include 'condition_checker/search_conditonal.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Search</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --brand-green: #4BB543;
      --brand-green-light: #e6f4ea;
      --brand-green-hover: #3da336;
    }

    body {
      font-family: 'Lato', sans-serif;
      background: #f8f9fa;
    }

    .sidebar {
      position: sticky;
      top: 1rem;
    }

    .filter-box {
      background: #fff;
      border: 1px solid var(--brand-green-light);
      border-radius: .5rem;
      padding: 1.25rem;
      margin-bottom: 1.5rem;
      transition: box-shadow .2s, border-color .2s;
    }

    .filter-box:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
      border-color: var(--brand-green);
    }

    .filter-box label {
      font-weight: 600;
      margin-bottom: .5rem;
      display: block;
      color: #495057;
    }

    .results-header {
      font-weight: 500;
      color: #343a40;
      margin: 1.5rem 0 .75rem;
      border-bottom: 2px solid var(--brand-green);
      padding-bottom: .5rem;
    }

    .card-products {
      border: 1px solid var(--brand-green-light);
      border-radius: .5rem;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, .03);
    }

    .card-products .card-header {
      background: var(--brand-green);
      color: #fff;
      font-weight: 600;
    }

    .table thead {
      background: var(--brand-green-light);
    }

    .table tbody tr:hover {
      background: #f1f3f5;
    }

    .product-thumb {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: .25rem;
    }

    .no-results {
      color: #6c757d;
      font-style: italic;
      text-align: center;
      margin-top: 2rem;
    }

    /* Custom button styles */
    .btn-success {
      background-color: var(--brand-green);
      border-color: var(--brand-green);
    }

    .btn-success:hover {
      background-color: var(--brand-green-hover);
      border-color: var(--brand-green-hover);
    }

    .btn-success:focus {
      background-color: var(--brand-green);
      border-color: var(--brand-green);
      box-shadow: 0 0 0 0.25rem rgba(75, 181, 67, 0.25);
    }

    .btn-success:active {
      background-color: var(--brand-green-hover) !important;
      border-color: var(--brand-green-hover) !important;
    }

    /* Form control focus styles */
    .form-control:focus {
      border-color: var(--brand-green);
      box-shadow: 0 0 0 0.25rem rgba(75, 181, 67, 0.25);
    }

    /* Select focus styles */
    .form-select:focus {
      border-color: var(--brand-green);
      box-shadow: 0 0 0 0.25rem rgba(75, 181, 67, 0.25);
    }

    /* Link styles */
    a {
      color: var(--brand-green);
    }

    a:hover {
      color: var(--brand-green-hover);
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>

  <div class="container-fluid py-5">
    <div class="row gx-4">
      <!-- Sidebar Filters -->
      <aside class="col-lg-3 sidebar">
        <!-- Category Filter -->
        <div class="filter-box">
          <form method="POST" action="search_product.php">
            <label for="product_Category">Product Category</label>
            <select id="product_Category" name="product_Category" class="form-select mb-3">
              <option value="">— All Categories —</option>
              <?php foreach (['Bakery', 'Butcher', 'Greengrocery', 'Fishmonger', 'Delicatesssen'] as $cat): ?>
                <option value="<?= $cat ?>" <?= ($product_Category === $cat) ? 'selected' : '' ?>>
                  <?= $cat ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="submit" name="submit1" class="btn btn-success w-100">
              Filter Category
            </button>
          </form>
        </div>

        <!-- Traders Filter -->
        <div class="filter-box">
          <form method="POST" action="search_product.php">
            <label for="traders">Traders</label>
            <select id="traders" name="traders" class="form-select mb-3">
              <option value="">— All Traders —</option>
              <?php foreach (['Jack Morris', 'Tim Hilton', 'Jimmy Chu', 'Kamala Harris', 'Tom Hardy'] as $tr): ?>
                <option value="<?= $tr ?>" <?= ($traders === $tr) ? 'selected' : '' ?>>
                  <?= $tr ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="submit" name="submit2" class="btn btn-success w-100">
              Filter Trader
            </button>
          </form>
        </div>
      </aside>

      <!-- Products & Search -->
      <section class="col-lg-9">
        <!-- Inline Search -->
        <form method="POST" action="search_product.php" class="d-flex mb-3">
          <input
            type="text"
            name="search_Txt"
            class="form-control me-2"
            placeholder="Search products..."
            value="<?= htmlspecialchars($search_Txt) ?>">
          <button class="btn btn-success" type="submit" name="submit_search">
            Search
          </button>
        </form>

        <div class="results-header">
          <?= $count ?> items found for
          <?php if ($search_Txt): ?>
            "<?= ucfirst(htmlspecialchars($search_Txt)) ?>"
          <?php elseif ($search_Cat): ?>
            "<?= ucfirst(htmlspecialchars($search_Cat)) ?>"
          <?php elseif ($product_Category): ?>
            "<?= ucfirst(htmlspecialchars($product_Category)) ?>"
          <?php elseif ($traders): ?>
            "<?= ucfirst(htmlspecialchars($traders)) ?>"
          <?php else: ?>
            "
            <?= $search_Txt || $search_Cat || $product_Category || $traders ?>
            "
          <?php endif; ?>
        </div>

        <?php if ($count > 0): ?>
          <div class="card card-products">
            <div class="card-header">Product Results</div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Details</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($products as $index => $product): ?>
  <tr>
    <td><?= $index + 1 ?></td>
    <td>
      <a href="product_details.php?product_id=<?= $product['id'] ?>">
        <img
          src="<?= htmlspecialchars($product['image']) ?>"
          alt="<?= htmlspecialchars($product['name']) ?>"
          class="product-thumb">
      </a>
    </td>
    <td><?= htmlspecialchars($product['name']) ?></td>
    <td><?= htmlspecialchars($product['price']) ?></td>
    <td>
      <a
        href="product_details.php?product_id=<?= $product['id'] ?>"
        class="btn btn-sm btn-success">
        View
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
          <div class="no-results">No products match your filters.</div>
        <?php endif; ?>
      </section>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>