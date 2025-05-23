<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    echo "<script>alert('" . $msg . "');</script>";
} else {
    echo "";
}
?>

<style>
    .product-table {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    .product-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
        padding: 1rem;
        font-size: 0.95rem;
    }

    .product-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .product-table tbody tr {
        transition: all 0.2s ease;
    }

    .product-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.85rem;
    display: inline-block;
    min-width: 90px;
    text-align: center;
    margin-right: 1.5rem; /* Increased from 0.25rem */
    height: 32px;
    line-height: 1.2;
}

    .status-approved {
        background-color: #d4edda;
        color: #155724;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .action-buttons {
    display: flex;
    gap: 1 rem; /* Maintain a tight gap between buttons */
    flex-wrap: wrap;
    align-items: center;
}

    .action-buttons .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        line-height: 1.2;
        min-width: 90px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        margin: 0.25rem 0;
        border-radius: 4px;
    }

    .filter-select {
        min-width: 120px;
        height: 32px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 0.3rem 0.5rem;
        font-size: 0.85rem;
        background-color: #fff;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .filter-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.1rem rgba(0,123,255,.25);
    }

    form .btn.btn-dark {
        padding: 0.3rem 0.8rem;
        font-size: 0.85rem;
        height: 32px;
        line-height: 1.2;
    }

    .table-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 1rem;
    }

    .product-name {
        font-weight: 500;
        color: #212529;
    }

    .product-category {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .product-price {
        font-weight: 600;
        color: #28a745;
    }

    .product-stock {
        font-weight: 500;
        color: #495057;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .action-buttons .btn {
            width: 100%;
        }

        .status-badge {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .filter-select, form .btn {
            width: 100%;
        }
        form.d-flex {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>


<?php include 'theader.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Product Overview</h3>
                <a href="addproduct.php" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Add Products
                </a>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="row mb-3">
            <div class="col-md-6 d-flex align-items-center">
                <h5 class="mb-0">All Products</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end align-items-center">
                    <span class="me-2">Filter by: </span>
                    <form method="POST" action="#" class="d-flex align-items-center">
                        <select id="sort" class="filter-select ms-1" name="status">
                            <option value="all" <?php echo (!isset($_POST['status']) || $_POST['status'] == 'all') ? 'selected' : ''; ?>>All Products</option>
                            <option value="approved" <?php echo (isset($_POST['status']) && $_POST['status'] == 'approved') ? 'selected' : ''; ?>>Approved Only</option>
                            <option value="pending" <?php echo (isset($_POST['status']) && $_POST['status'] == 'pending') ? 'selected' : ''; ?>>Pending Only</option>
                        </select>
                        <button type="submit" class="btn btn-dark btn-sm ms-2">Go</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover product-table">
                <thead>
                    <tr>
                        <th scope="col">SN</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1;
                    $i = 0;

                    include 'connection.php';

                    $tn = $_SESSION['trader_username'];

                    $sql = "SELECT * FROM trader where Username='$tn'";
                    $qry = oci_parse($connection, $sql);
                    oci_execute($qry);

                    while ($row = oci_fetch_assoc($qry)) {
                        $tid = $row['TRADER_ID'];
                        
                        // Base query
                        $sql1 = "SELECT * FROM product, shop WHERE shop.Shop_Id=product.Shop_Id AND shop.Trader_id='$tid'";
                        
                        // Add status filter if selected
                        if (isset($_POST['status']) && $_POST['status'] != 'all') {
                            $status = $_POST['status'] == 'approved' ? 1 : 0;
                            $sql1 .= " AND product.Product_Verification='$status'";
                        }
                        
                        $qry1 = oci_parse($connection, $sql1);
                        oci_execute($qry1);

                        $count = oci_fetch_all($qry1, $connection);
                        oci_execute($qry1);

                        if ($count >= 1) {
                            while ($row1 = oci_fetch_assoc($qry1)) {
                                $product_id[$i] = $row1['PRODUCT_ID'];
                                $product_image[$i] = $row1['PRODUCT_IMAGE'];
                                $product_name[$i] = $row1['PRODUCT_NAME'];
                                $product_category[$i] = $row1['PRODUCT_TYPE'];
                                $price[$i] = $row1['PRODUCT_PRICE'];
                                $stock[$i] = $row1['STOCK'];
                                $verify[$i] = $row1['PRODUCT_VERIFICATION'];
                    ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td>
                                        <img src="../<?php echo $product_image[$i]; ?>" class="product-image" alt="Product Image">
                                    </td>
                                    <td>
                                        <div class="product-name"><?php echo $product_name[$i]; ?></div>
                                    </td>
                                    <td>
                                        <div class="product-category"><?php echo $product_category[$i]; ?></div>
                                    </td>
                                    <td>
                                        <div class="product-price">$<?php echo number_format($price[$i], 2); ?></div>
                                    </td>
                                    <td>
                                        <div class="product-stock"><?php echo $stock[$i]; ?></div>
                                    </td>
                                    <td colspan="2">
                                        <div class="d-flex align-items-center gap-4 flex-wrap">
                                            <span class="status-badge <?php echo $verify[$i] == 1 ? 'status-approved' : 'status-pending'; ?> me-2 mb-2 mb-md-0">
                                                <?php echo $verify[$i] == 1 ? 'Approved' : 'Pending'; ?>
                                            </span>
                                            <div class="action-buttons ms-2">
                                                <a href="editproducts.php?productID=<?php echo $product_id[$i]; ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>Edit
                                                </a>
                                                <a href="deleteproducts.php?productID=<?php echo $product_id[$i]; ?>" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                    <?php
                                $sn++;
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No Products Found</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
unset($_SESSION['msg']);
include '../end.php'; ?>