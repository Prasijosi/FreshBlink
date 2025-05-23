<?php
session_start();
if (isset($_POST['submit'])) {

    if (!empty($_POST['uname']) && !empty($_POST['fname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['shopname']) && !empty($_POST['what'])) {


        if (empty($_POST['cb'])) {
            $_SESSION['error'] = "Please Agree our Privacy Notice and Terms of Use.</br>";
            header('Location:sign_up_trader.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & shopname=' . $_POST['shopname'] . ' & what=' . $_POST['what'] . '');
        } else {

            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email Should be in Correct Format <br/>";
                header('Location:sign_up_trader.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & shopname=' . $_POST['shopname'] . ' & what=' . $_POST['what'] . '');
            } else {



                $password = $_POST['password'];
                $repassword = $_POST['repassword'];

                if ($password == $repassword) {

                    $pattern = "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/";
                    $password = $_POST['password'];

                    if (preg_match($pattern, $password)) {
                        $tpassword = $password;
                        $uname = $_POST['uname'];
                        $fname = $_POST['fname'];
                        $shopname = $_POST['shopname'];
                        $what = $_POST['what'];


                        $sql = "INSERT INTO trader( Name, Username, Password, Email,Trader_Verification) VALUES ('$fname','$uname','$tpassword','$email',0)";

                        include('../connection.php');

                        $qry = oci_parse($connection, $sql);
                        oci_execute($qry);

                        if ($qry) {
                            //echo "User Inserted";

                            $sql1 = "SELECT * FROM trader WHERE Username='$uname'";
                            $qry1 = oci_parse($connection, $sql1);
                            oci_execute($qry1);

                            if ($qry1) {

                                while ($r = oci_fetch_array($qry1)) {
                                    $tid = $r['TRADER_ID'];
                                    $_SESSION['trader_id']=$tid;
                                    $_SESSION['trader_email'] = $r['EMAIL'];
                                }


                                $sql2 = "INSERT INTO shop(Shop_Name, Shop_description, Shop_location, Trader_id,Shop_Verification) VALUES ('$shopname','$what','Cleckhuddersfax','$tid',0)";
                                $qry2 = oci_parse($connection, $sql2);
                                oci_execute($qry2);

                                $_SESSION['trader_username'] = $uname;
                                header('Location:new_trader_request.php');
                            }
                        } else {
                            echo "ERROR";
                        }
                    } else {  //else for password req check
                        $_SESSION['error'] = "Password includes at least one capital letter, a number , a symbol and 8 digit <br/>";
                        header('Location:sign_up_trader.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & shopname=' . $_POST['shopname'] . ' & what=' . $_POST['what'] . '');
                    }
                } else {  //else for password and re password check
                    $_SESSION['error'] = "Password do not MATCH <br/>";
                    header('Location:sign_up_trader.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & shopname=' . $_POST['shopname'] . ' & what=' . $_POST['what'] . '');
                }
            }  //else for email check

        }  //else for checkbox

    } else {  //else for check empty
        $_SESSION['error'] = "Please Fill up the all forms<br/>";
        header('Location:sign_up_trader.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & shopname=' . $_POST['shopname'] . ' & what=' . $_POST['what'] . ' ');
    }
}
