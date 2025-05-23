<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$count = 111111;
$count1 = 999999;
$random_number = rand($count, $count1);

if (isset($_POST['submit'])) {
    // Validate required fields
    $required_fields = ['uname', 'fname', 'email', 'password', 'repassword', 'address', 'gender', 'dob'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        $_SESSION['error'] = "Please fill up all required fields: " . implode(', ', $missing_fields);
        header('Location: ../sign_up_customer.php?' . http_build_query($_POST));
        exit;
    }

    // Validate checkbox
    if (empty($_POST['cb'])) {
        $_SESSION['error'] = "Please agree to our Privacy Notice and Terms of Use.";
        header('Location: ../sign_up_customer.php?' . http_build_query($_POST));
        exit;
    }

    // Validate email format
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header('Location: ../sign_up_customer.php?' . http_build_query($_POST));
        exit;
    }

    // Validate password match
    if ($_POST['password'] !== $_POST['repassword']) {
        $_SESSION['error'] = "Passwords do not match.";
        header('Location: ../sign_up_customer.php?' . http_build_query($_POST));
        exit;
    }

    // Validate password strength
    $password = $_POST['password'];
    $pattern = "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/";
    if (!preg_match($pattern, $password)) {
        $_SESSION['error'] = "Password must include at least one capital letter, one number, one symbol, and be 8-20 characters long.";
        header('Location: ../sign_up_customer.php?' . http_build_query($_POST));
        exit;
    }

    // Include database connection
    include('../connection.php');
    if (!$connection) {
        $_SESSION['error'] = "Database connection failed.";
        header('Location: ../sign_up_customer.php');
        exit;
    }

    // Check if username or email already exists
    $check_sql = "SELECT COUNT(*) FROM customer WHERE Username = :uname OR Email = :email";
    $check_stmt = oci_parse($connection, $check_sql);
    oci_bind_by_name($check_stmt, ':uname', $_POST['uname']);
    oci_bind_by_name($check_stmt, ':email', $email);
    
    if (!oci_execute($check_stmt)) {
        $_SESSION['error'] = "Database error occurred.";
        header('Location: ../sign_up_customer.php');
        exit;
    }
    
    $row = oci_fetch_array($check_stmt, OCI_NUM);
    if ($row[0] > 0) {
        $_SESSION['error'] = "Username or email already exists.";
        header('Location: ../sign_up_customer.php?' . http_build_query($_POST));
        exit;
    }

    // Prepare SQL with parameter binding
    $sql = "INSERT INTO customer (Username, Full_Name, Email, Password, Address, Contact_number, Sex, Date_Of_Birth, Email_Verify) 
            VALUES (:uname, :fname, :email, :password, :address, :phone, :gender, :dob, :verify_code)";
    
    $stmt = oci_parse($connection, $sql);
    oci_bind_by_name($stmt, ':uname', $_POST['uname']);
    oci_bind_by_name($stmt, ':fname', $_POST['fname']);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':password', $password);
    oci_bind_by_name($stmt, ':address', $_POST['address']);
    oci_bind_by_name($stmt, ':phone', $_POST['phone']);
    oci_bind_by_name($stmt, ':gender', $_POST['gender']);
    oci_bind_by_name($stmt, ':dob', $_POST['dob']);
    oci_bind_by_name($stmt, ':verify_code', $random_number);

    if (oci_execute($stmt)) {
        $_SESSION['username'] = $_POST['uname'];
        $_SESSION['verify_code'] = $random_number;
        
        // Send verification email
        $to = $email;
        $subject = 'Verification Code';
        $message = 'Your 6-Digit OTP Verification Code is: ' . $random_number;
        $headers = "From: josiprasi@gmail.com\r\nReply-To: josiprasi@gmail.com";
        
        include '../sendmail.php';
        $result = sendEmail(
            $to,
            '',
            $subject,
            $message,
            ""
        );
        
        if ($result === true) {
            unset($_SESSION['username']);
            echo "<script>alert('Check your Email for 6-Digit OTP Code');</script>";
            header('Location: ../customer_email_verify.php');
        } else {
            unset($_SESSION['username']);
            echo "<script>alert('Mail Failed');</script>";
            $_SESSION['error'] = "Failed to send verification email.";
            header('Location: ../sign_up_customer.php');
            exit;
        }
        unset($_SESSION['username']);
    } else {
        $e = oci_error($stmt);
        $_SESSION['error'] = "Registration failed: " . $e['message'];
        header('Location: ../sign_up_customer.php');
        exit;
    }
} else {
    header('Location: ../sign_up_customer.php');
    exit;
}