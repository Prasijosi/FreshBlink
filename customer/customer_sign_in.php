<?php
session_start();
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {

        $sql = "SELECT * FROM CUSTOMER WHERE EMAIL='$email' and PASSWORD='$password' and Email_Verify='0'";

        include('../connection.php');

        $qry = oci_parse($connection, $sql);
        oci_execute($qry);

        $count = oci_fetch_all($qry, $connection);
        oci_execute($qry);

        if ($count == 1) {

            while ($row = oci_fetch_array($qry)) {
                $_SESSION['username'] = $row['USERNAME'];
                $_SESSION['email'] = $row['EMAIL'];
                $_SESSION['customer_id'] = $row['CUSTOMER_ID'];
                $_SESSION['profile_picture'] = $row['PROFILE_IMAGE'];
                header('Location:../index.php');
            }

            if (!empty($_POST["remember"])) {
                setcookie("email", $email, time() + (1 * 60 * 60), "/");
                setcookie("password", $password, time() + (1 * 60 * 60), "/");
            } else {

                if (isset($_COOKIE["email"])) {

                    setcookie("email", "");
                }
                if (isset($_COOKIE["password"])) {
                    setcookie("password", "");
                }
            }
        } else {
            header('Location:../sign_in_customer.php?msg=Invalid Email/Password');
            exit();
        }
    }
}
