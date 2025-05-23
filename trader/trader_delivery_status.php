<?php
if (isset($_GET['orderID'])) {

    $oid = $_GET['orderID'];

    include 'connection.php';

    if ($_GET['d'] == 1) {
        $sql = "UPDATE orders SET Delivery_Status=0 WHERE Order_Id=$oid";
        $result = oci_parse($connection, $sql);
        oci_execute($result);

        if ($result) {
            $_SESSION['ds'] = 0;
            header('Location:trader_order.php');
        } else {
            echo "qry error";
        }
    } else {
        $sql = "UPDATE orders SET Delivery_Status=1 WHERE Order_Id=$oid";
        $result = oci_parse($connection, $sql);
        oci_execute($result);

        if ($result) {
            $_SESSION['ds'] = 1;
            header('Location:trader_order.php');
        } else {
            echo "qry error";
        }
    }
}
