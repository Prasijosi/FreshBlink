<?php
session_start();
include 'connection.php';

if (isset($_POST['submit'])) {
    $tun = $_SESSION['trader_username'];
    $sname = $_POST['sname'];
    $saddress = $_POST['saddress'];
    $what = $_POST['what'];

    $sql1 = "SELECT * FROM trader WHERE Username='$tun'";
    $qry1 = oci_parse($connection, $sql1);
    oci_execute($qry1);

    while ($row = oci_fetch_assoc($qry1)) {
        $tid = $row['TRADER_ID'];
    }

    if (!empty($sname) && !empty($saddress) && !empty($what)) {

        include 'connection.php';

        $sql = "INSERT INTO shop (Shop_Name, Shop_description, Shop_location,Trader_Id,Shop_Verification) VALUES ('$sname','$what','$saddress','$tid',0)";

        $qry = oci_parse($connection, $sql);
        oci_execute($qry);

        //echo $qry;
        //die();
        if ($qry) {
            $_SESSION['right'] = "Successfully Shop Inserted";
            header('Location:addshop.php');
            exit();
            //echo "shop added";
        } else {
            echo "Query error";
        }
    } else {
        $_SESSION['error'] = "Fill Up The All Forms";
        header("Location:addshop.php?sname=$sname & saddress=$saddress & what=$what");
        //echo "Please full all the forms";
    }
}
