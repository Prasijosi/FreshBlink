<?php
session_start();

// Clear entire cart
if (isset($_GET['d'])) {
    unset($_SESSION['cart']);
    $_SESSION['cart'] = array();

    if (isset($_SESSION['customer_id'])) {
        $cid = $_SESSION['customer_id'];
        include('connection.php');
        $sql = "DELETE FROM CART WHERE customer_id=$cid";
        $qry = oci_parse($connection, $sql);
        oci_execute($qry);
    }

    echo "<script>
        alert('Cart Cleared');
        window.location.href='cart.php';
    </script>";
    exit();
}

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add to cart
    if (isset($_POST['addtoCart'])) {
        // Validate required fields
        if (!isset($_POST['itemname']) || !isset($_POST['itemprice']) || !isset($_POST['quantity']) || !isset($_POST['itemimage']) || !isset($_POST['stock'])) {
            echo "<script>
                alert('Missing required product information');
                window.location.href='index.php';
            </script>";
            exit();
        }

        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if item already exists in cart
        $myitems = array_column($_SESSION['cart'], 'item_name');
        if (in_array($_POST['itemname'], $myitems)) {
            echo "<script>
                alert('Item is already in your cart');
                window.location.href='cart.php';
            </script>";
            exit();
        }

        // Add item to cart
        $count = count($_SESSION['cart']);
        $_SESSION['cart'][$count] = array(
            'item_name' => $_POST['itemname'],
            'price' => $_POST['itemprice'],
            'quantity' => $_POST['quantity'],
            'image' => $_POST['itemimage'],
            'stock' => $_POST['stock']
        );

        echo "<script>
            alert('Item Added to Cart');
            window.location.href='cart.php';
        </script>";
        exit();
    }

    // Modify quantity
    if (isset($_POST['Mod_Quantity']) && isset($_POST['item_name'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['item_name'] == $_POST['item_name']) {
                $_SESSION['cart'][$key]['quantity'] = $_POST['Mod_Quantity'];
                echo "<script>
                    alert('Quantity Updated');
                    window.location.href='cart.php';
                </script>";
                exit();
            }
        }
    }
}

// Remove item from cart
if (isset($_GET['value'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['item_name'] == $_GET['value']) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array

            if (isset($_SESSION['customer_id'])) {
                $cid = $_SESSION['customer_id'];
                include('connection.php');
                
                $sql2 = "SELECT * FROM product WHERE PRODUCT_NAME='" . $value['item_name'] . "'";
                $qry2 = oci_parse($connection, $sql2);
                oci_execute($qry2);

                while ($row = oci_fetch_array($qry2)) {
                    $pid = $row['PRODUCT_ID'];
                    $sql3 = "DELETE FROM cart WHERE product_id=$pid AND customer_id=$cid";
                    $qry3 = oci_parse($connection, $sql3);
                    oci_execute($qry3);
                }
            }

            echo "<script>
                alert('Item Removed from Cart');
                window.location.href='cart.php';
            </script>";
            exit();
        }
    }
}
