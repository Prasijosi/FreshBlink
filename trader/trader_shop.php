<?php include '../start.php' ?>

<?php
include 'theader.php';

if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}
?>

<style>
    .shop-table {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    .shop-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
    }

    .shop-table tbody tr {
        transition: all 0.2s ease;
    }

    .shop-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .add-shop-btn {
        transition: all 0.2s ease;
    }

    .add-shop-btn:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Shop Overview</h3>
                <a href="addshop.php" class="btn btn-primary add-shop-btn">
                    <i class="fas fa-plus me-2"></i>Add Shop
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="mb-0">All Shops</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover shop-table">
                    <thead>
                        <tr>
                            <th scope="col">S ID</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Shop Description</th>
                            <th scope="col">Location</th>
                            <th scope="col">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'connection.php';

                        $tn = $_SESSION['trader_username'];

                        $sql = "SELECT * FROM trader where Username='$tn' ";
                        $qry = oci_parse($connection, $sql);
                        oci_execute($qry);
                        
                        $hasShops = false;
                        while ($row = oci_fetch_assoc($qry)) {
                            $tid = $row['TRADER_ID'];
                            $tcontact = $row['CONTACT'];
                            
                            $sql1 = "SELECT * FROM shop where Trader_id='$tid' and Shop_Verification='1' ";
                            $qry1 = oci_parse($connection, $sql1);
                            oci_execute($qry1);
                            
                            $sid = 0;
                            while ($row = oci_fetch_assoc($qry1)) {
                                $hasShops = true;
                                $sid = $sid + 1;
                                $sname = $row['SHOP_NAME'];
                                $sdesc = $row['SHOP_DESCRIPTION'];
                                $sloc = $row['SHOP_LOCATION'];
                        ?>
                                <tr>
                                    <td><?php echo $sid; ?></td>
                                    <td><?php echo $sname; ?></td>
                                    <td><?php echo $sdesc; ?></td>
                                    <td><?php echo $sloc; ?></td>
                                    <td><?php echo $tcontact; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        
                        if (!$hasShops) {
                            echo "<tr><td colspan='5' class='text-center'>No shops found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../end.php'; ?>