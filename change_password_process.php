<?php
session_start();
if (isset($_SESSION['username'])) {

    $customer_id = $_SESSION['customer_id'];
    if (isset($_POST['submit'])) {

        $password = $_POST['password'];
        $repassword = $_POST['repassword'];

        if ($password == $repassword) {

            $pattern = "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/";
            $password1 = $password;

            if (preg_match($pattern, $password)) {
                include 'connection.php';
                $sql = "UPDATE CUSTOMER SET PASSWORD ='$password1' where CUSTOMER_ID ='$customer_id'";
                $result = oci_parse($connection, $sql);
                oci_execute($result);
                header('Location:change_password.php?msg= Password Changed Succesfully!');
            } else {
                header('Location:change_password.php?msg=Password includes at least one capital letter, a number , a symbol and 8 digit');
            }
        } else {
            header('Location:change_password.php?msg=Passwords do not MATCH!');
        }
    } else {
        header('Location:change_password.php');
    }
} else {
    header('Location:sign_in_customer.php');
}
