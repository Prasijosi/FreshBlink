<?php
session_start();
$count = 111111;
$count1 = 999999;
$random_number =  rand($count, $count1);
if (isset($_POST['submit'])) {

    if (!empty($_POST['uname']) && !empty($_POST['fname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['address']) && !empty($_POST['gender']) && !empty($_POST['dob'])) {


        if (empty($_POST['cb'])) {
            $_SESSION['error'] = "Please Agree our Privacy Notice and Terms of Use.</br>";
            header('Location:../sign_up_customer.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & address=' . $_POST['address'] . ' & phone=' . $_POST['phone'] . ' & gender=' . $_POST['gender'] . ' & dob=' . $_POST['dob'] . '');
        } else {

            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email Should be in Correct Format <br/>";
                header('Location:../sign_up_customer.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & address=' . $_POST['address'] . ' & phone=' . $_POST['phone'] . ' & gender=' . $_POST['gender'] . ' & dob=' . $_POST['dob'] . '');
            } else {



                $password = $_POST['password'];
                $repassword = $_POST['repassword'];

                if ($password == $repassword) {

                    $pattern = "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/";
                    $password = $_POST['password'];

                    if (preg_match($pattern, $password)) {
                        $cpassword = $password;
                        $uname = $_POST['uname'];
                        $fname = $_POST['fname'];
                        $address = $_POST['address'];
                        $phone = $_POST['phone'];
                        $gender = $_POST['gender'];
                        $dob = $_POST['dob'];

                        include('../connection.php');

                        $sql = "INSERT INTO customer(Username,Full_Name,Email,Password,Address,Contact_number,Sex,Date_Of_Birth,Email_Verify) VALUES ('$uname','$fname','$email','$cpassword','$address','$phone','$gender','$dob','$random_number')";

                        $qry = oci_parse($connection, $sql);
                        oci_execute($qry);
                        
                        if ($qry) {

                            $_SESSION['username'] = $uname;
                            
                            $to = $email;
                            $subject = 'Verification Code';
                            $message = 'Your 6-Digit OTP Verification Code is : ' . $random_number . '';
                            $headers = "From: josiprasi@gmail.com\r\nReply-To: josiprasi@gmail.com";
                            include 'sendmail.php';
                            $result = sendEmail(
                                $to_email,
                                '',
                                $subject,
                                $message,
                                ""
                            );
                            
                            if ($result === true) {
                                unset($_SESSION['username']);
                                echo "<script>alert('Check your Email for 6-Digit OTP Code');</script>";
                            } else {
                                unset($_SESSION['username']);
                                echo "<script>alert('Mail Failed');</script>";
                            }
                            unset($_SESSION['username']);
                            header('Location:../customer_email_verify.php');
                        } else {
                            echo "ERROR";
                        }
                    } else {  //else for password req check
                        $_SESSION['error'] = "Password includes at least one capital letter, a number , a symbol and 8 digit <br/>";
                        header('Location:../sign_up_customer.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & address=' . $_POST['address'] . ' & phone=' . $_POST['phone'] . ' & gender=' . $_POST['gender'] . ' & dob=' . $_POST['dob'] . '');
                    }
                } else {  //else for password and re password check
                    $_SESSION['error'] = "Password do not MATCH <br/>";
                    header('Location:../sign_up_customer.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & address=' . $_POST['address'] . ' & phone=' . $_POST['phone'] . ' & gender=' . $_POST['gender'] . ' & dob=' . $_POST['dob'] . '');
                }
            }  //else for email check

        }  //else for checkbox

    } else {  //else for check empty
        $_SESSION['error'] = "Please Fill up the all forms<br/>";
        header('Location:../sign_up_customer.php?uname=' . $_POST['uname'] . ' & fname=' . $_POST['fname'] . ' & email=' . $_POST['email'] . ' & address=' . $_POST['address'] . ' & phone=' . $_POST['phone'] . ' & gender=' . $_POST['gender'] . ' & dob=' . $_POST['dob'] . ' ');
    }
}
