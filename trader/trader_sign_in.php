<?php
session_start();
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password) && $_POST['c'] == 't') {

        $sql = "SELECT * FROM trader WHERE Email='$email' and Password='$password' and Trader_Verification='1'";

        include 'connection.php';

        $qry = oci_parse($connection, $sql);
        oci_execute($qry);

        $count = oci_fetch_all($qry, $connection);
        oci_execute($qry);
        if ($count == 1) {
            while ($row = oci_fetch_assoc($qry)) {
                $_SESSION['trader_username'] = $row['USERNAME'];
                $_SESSION['trader_id'] = $row['TRADER_ID'];
                $_SESSION['trader_profile_picture'] = $row['PROFILE_IMAGE'];
                header('Location:index.php');
                exit();
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
            // Check if trader exists but is not approved
            $sql = "SELECT * FROM trader WHERE Email='$email' and Password='$password'";
            $qry = oci_parse($connection, $sql);
            oci_execute($qry);
            $count = oci_fetch_all($qry, $connection);

            if ($count == 1) {
                header('Location:sign_in_trader.php?msg=Your account is pending approval. Please wait for admin verification.');
            } else {
                header('Location:sign_in_trader.php?msg=Email / Password Error!');
            }
            exit();
        }
    } elseif (!empty($email) && !empty($password) && $_POST['c'] == 'a') {

        $sql = "SELECT * FROM admin WHERE Email='$email' and Password='$password'";

        include 'connection.php';

        $qry = oci_parse($connection, $sql);
        oci_execute($qry);

        $count = oci_fetch_all($qry, $connection);
        oci_execute($qry);

        if ($count == 1) {
            while ($row = oci_fetch_assoc($qry)) {

                $_SESSION['admin_username'] = $row['USERNAME'];
                $_SESSION['admin_id'] = $row['ADMIN_ID'];
                $_SESSION['admin_profile_picture'] = $row['PROFILE_IMAGE'];
                header('Location: ../management/management.php');
                exit();
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
            header('Location:sign_in_trader.php?msg=Admin not Registered!');
            exit();
        }
    }
}
