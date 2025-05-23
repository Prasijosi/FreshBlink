<?php
session_start();
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $pincode = trim($_POST['pincode']);
    
    if (empty($email) || empty($pincode)) {
        header('Location:../customer_email_verify.php?msg=Please fill in all fields');
        exit();
    }

    include('../connection.php');

    // First check if the email exists
    $check_sql = "SELECT * FROM customer WHERE Email = :email";
    $check_stmt = oci_parse($connection, $check_sql);
    oci_bind_by_name($check_stmt, ':email', $email);
    oci_execute($check_stmt);
    
    if (oci_fetch($check_stmt)) {
        // Email exists, now verify the pin
        $verify_sql = "SELECT * FROM customer WHERE Email = :email AND Email_Verify = :pincode";
        $verify_stmt = oci_parse($connection, $verify_sql);
        oci_bind_by_name($verify_stmt, ':email', $email);
        oci_bind_by_name($verify_stmt, ':pincode', $pincode);
        oci_execute($verify_stmt);

        if (oci_fetch($verify_stmt)) {
            // Update verification status
            $update_sql = "UPDATE CUSTOMER SET EMAIL_VERIFY = '0' WHERE EMAIL = :email AND EMAIL_VERIFY = :pincode";
            $update_stmt = oci_parse($connection, $update_sql);
            oci_bind_by_name($update_stmt, ':email', $email);
            oci_bind_by_name($update_stmt, ':pincode', $pincode);
            
            if (oci_execute($update_stmt)) {
                header('Location:../sign_in_customer.php?message=Email Successfully Verified');
                exit();
            } else {
                header('Location:../customer_email_verify.php?msg=Verification failed. Please try again.');
                exit();
            }
        } else {
            header('Location:../customer_email_verify.php?msg=Invalid verification code');
            exit();
        }
    } else {
        header('Location:../customer_email_verify.php?msg=Email not found. Please check your email address.');
        exit();
    }
} else {
    header('Location:../customer_email_verify.php?msg=Invalid request');
    exit();
}
?>