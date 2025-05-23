<?php
session_start();
if (isset($_SESSION['trader_id'])) {

    $trader_id = $_SESSION['trader_id'];
    if (isset($_POST['submit'])) {

        $password = $_POST['password'];
        $repassword = $_POST['repassword'];

        if ($password == $repassword) {

            $pattern = "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/";
            $password1 = $password;

            if (preg_match($pattern, $password)) {
                include 'connection.php';
                $sql = "UPDATE trader SET Password ='$password1' where Trader_Id ='$trader_id'";
                $result = oci_parse($connection, $sql);
                oci_execute($result);
                $_SESSION['msg'] = "Password Changed Succesfully!";
                header('Location:index.php');
            } else {
                $_SESSION['error'] = "Password includes at least one capital letter, a number , a symbol and 8 digit";
                header('Location:trader_change_password.php');
            }
        } else {
            $_SESSION['error'] = "Passwords do not MATCH!";
            header('Location:trader_change_password.php');
        }
    } else {
        header('Location:trader_change_password.php');
    }
} else {
    header('Location:sign_in_trader.php');
}
