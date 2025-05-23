<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}

include 'connection.php';

if (isset($_POST['submit'])) {
    $shop_name =  $_POST['shop_name'];
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_details = $_POST['product_details'];
    $product_price = $_POST['product_price'];
    $stock = $_POST['stock'];

    $Product_Image = $_FILES['product_image'];
    $filename = $Product_Image['name'];
    $fileerror = $Product_Image['error'];
    $filetmp = $Product_Image['tmp_name'];

    $imgext = explode('.', $filename);
    $filecheck = strtolower(end($imgext));

    $fileextstored = array('png', 'jpg', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {
        $destinationfile = 'images/' . $filename;
        $destinationfile1 = '../images/' . $filename;
        move_uploaded_file($filetmp, $destinationfile1);

        $sql = "INSERT INTO product(Shop_Id, Product_Name, Product_Type, Product_Details, Product_Price, Stock, Product_Image,Product_Verification) values('$shop_name', '$product_name', '$product_category', '$product_details', '$product_price', '$stock', '$destinationfile',0)";

        $result = oci_parse($connection, $sql);
        oci_execute($result);

        if ($result) {
            header('Location:trader_crud.php?msg=Product Added Successfully');
            exit();
        } else {
            header('Location:trader_crud.php?msg=Unable to Insert Product');
            exit();
        }
    } else {
        echo "Location:trader_crud.php?msg=Error while Uploading!";
    }
}
?>
<div>
    <?php include 'theader.php'; ?>
    <div class="container w-100 d-flex align-items-center justify-content-center">
        <div class="row mt-4 w-100">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <form class="p-4" method="POST" action="addproduct.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-4">Add Product</h4>
                                    <h6 class="text-muted mb-4">Basic Information</h6>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="shop_name" class="form-label">Shop Name</label>
                                <select name="shop_name" class="form-control">
                                    <?php
                                    include 'connection.php';

                                    $trader_id = $_SESSION['trader_id'];

                                    $sql = "SELECT * from trader,shop where '$trader_id'= trader.Trader_Id and trader.Trader_id = shop.Trader_id and SHOP_VERIFICATION=1";

                                    $result = oci_parse($connection, $sql);
                                    oci_execute($result);

                                    while ($row = oci_fetch_assoc($result)) {
                                        $shop_name = $row['SHOP_NAME'];
                                        $shop_id = $row['SHOP_ID'];
                                        echo "<option value='" . $shop_id . "'>" . $shop_name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="product_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="product_name" placeholder="Product Name" name="product_name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="product_category" class="form-label">Product Category</label>
                                <input type="text" class="form-control" id="product_category" placeholder="Product Category" name="product_category" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="product_details" class="form-label">Product Details</label>
                                <textarea class="form-control" id="product_details" rows="3" name="product_details" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="product_price" class="form-label">Product Price</label>
                                <input type="number" class="form-control" id="product_price" placeholder="Product Price" name="product_price" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" placeholder="Stock" name="stock" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="product_image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="file" name="product_image" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success px-5" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../end.php'; ?>
<?php include '../footer.php'; ?>