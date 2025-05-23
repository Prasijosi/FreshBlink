<?php

if (isset($_POST['submit']) && isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    include('connection.php');
    $sql = " UPDATE product SET Product_Verification= '1' where Product_Id='$pid' ";
    $qry = oci_parse($connection, $sql);
    oci_execute($qry);

    if ($qry) {
        header('Location:managementpwr.php?msg=Product Approved');
    } else {
        header('Location:managementpwr.php?msg=Product Disapproved');
    }
} elseif (isset($_POST['submit2']) && isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    include('connection.php');
    $sql = " UPDATE product SET Product_Verification= '0' where Product_Id='$pid' ";
    $qry = oci_parse($connection, $sql);
    oci_execute($qry);

    if ($qry) {
        header('Location:managementpwr.php?msg=Product Disapproved');
    } else {
        header('Location:managementpwr.php?msg=Product Approved');
    }
}
