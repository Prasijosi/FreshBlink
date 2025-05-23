<?php
session_start();
include 'connection.php';
if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    $sql = "delete from product where Product_Id='$productID'";

    $result = oci_parse($connection, $sql);
    oci_execute($result);

    if ($result) {
        header('Location:trader_crud.php?msg=Product Number Successfully Deleted');
        exit();
    }
} else {
    header('Location:trader_crud.php?msg=Unable to Delete Product Number');
    exit();
}
