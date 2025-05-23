<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    // Validate required fields
    $required_fields = ['uname', 'fname', 'email', 'password', 'repassword', 'shopname', 'what'];
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $_SESSION['error'] = "Please fill up all required fields: " . implode(', ', $missing_fields);
        header('Location: sign_up_trader.php?' . http_build_query($_POST));
        exit;
    }

    // Validate checkbox
    if (empty($_POST['cb'])) {
        $_SESSION['error'] = "Please agree to our Privacy Notice and Terms of Use.";
        header('Location: sign_up_trader.php?' . http_build_query($_POST));
        exit;
    }

    // Validate email format
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header('Location: sign_up_trader.php?' . http_build_query($_POST));
        exit;
    }

    // Validate password match
    if ($_POST['password'] !== $_POST['repassword']) {
        $_SESSION['error'] = "Passwords do not match.";
        header('Location: sign_up_trader.php?' . http_build_query($_POST));
        exit;
    }

    // Validate password strength
    $password = $_POST['password'];
    $pattern = "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/";
    if (!preg_match($pattern, $password)) {
        $_SESSION['error'] = "Password must include at least one capital letter, one number, one symbol, and be 8-20 characters long.";
        header('Location: sign_up_trader.php?' . http_build_query($_POST));
        exit;
    }

    // Include database connection
    include('../connection.php');
    if (!$connection) {
        $e = oci_error();
        $_SESSION['error'] = "Database connection failed: " . $e['message'];
        header('Location: sign_up_trader.php');
        exit;
    }

    // Check if username or email already exists
    $check_sql = "SELECT COUNT(*) FROM trader WHERE Username = :uname OR Email = :email";
    $check_stmt = oci_parse($connection, $check_sql);
    oci_bind_by_name($check_stmt, ':uname', $_POST['uname']);
    oci_bind_by_name($check_stmt, ':email', $email);

    if (!oci_execute($check_stmt)) {
        $e = oci_error($check_stmt);
        $_SESSION['error'] = "Database error: " . $e['message'];
        header('Location: sign_up_trader.php');
        exit;
    }

    $row = oci_fetch_array($check_stmt, OCI_NUM);

    if ($row[0] > 0) {
        $_SESSION['error'] = "Username or email already exists.";
        header('Location: sign_up_trader.php?' . http_build_query($_POST));
        exit;
    }

    // Start transaction
    $commit = false;
    $trader_id = null;
    oci_execute(oci_parse($connection, "BEGIN"));

    try {
        // Insert trader and get the auto-generated ID
        $trader_sql = "INSERT INTO trader (Name, Username, Password, Email, Trader_Verification) 
                      VALUES (:fname, :uname, :password, :email, 0)
                      RETURNING Trader_ID INTO :trader_id";

        $trader_stmt = oci_parse($connection, $trader_sql);
        oci_bind_by_name($trader_stmt, ':fname', $_POST['fname']);
        oci_bind_by_name($trader_stmt, ':uname', $_POST['uname']);
        oci_bind_by_name($trader_stmt, ':password', $password);
        oci_bind_by_name($trader_stmt, ':email', $email);
        oci_bind_by_name($trader_stmt, ':trader_id', $trader_id, 32);
        if (!oci_execute($trader_stmt)) {
            $e = oci_error($trader_stmt); // Get detailed Oracle error
            throw new Exception("Failed to register trader: " . $e['message']);
        }
        // Insert shop
        $shop_sql = "INSERT INTO shop (Shop_Name, Shop_description, Shop_location, Trader_id, Shop_Verification) 
                    VALUES (:shopname, :what, 'Cleckhuddersfax', :trader_id, 0)";

        $shop_stmt = oci_parse($connection, $shop_sql);
        oci_bind_by_name($shop_stmt, ':shopname', $_POST['shopname']);
        oci_bind_by_name($shop_stmt, ':what', $_POST['what']);
        oci_bind_by_name($shop_stmt, ':trader_id', $trader_id);

        if (!oci_execute($shop_stmt)) {
            throw new Exception("Failed to register shop.");
        }

        $commit = true;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    } finally {
        // Commit or rollback transaction
        if ($commit) {
            oci_execute(oci_parse($connection, "COMMIT"));
            $_SESSION['trader_id'] = $trader_id;
            $_SESSION['trader_email'] = $email;
            $_SESSION['trader_username'] = $_POST['uname'];
            header('Location: new_trader_request.php');
        } else {
            oci_execute(oci_parse($connection, "ROLLBACK"));
            header('Location: sign_up_trader.php?' . http_build_query($_POST));
        }
        exit;
    }
} else {
    header('Location: sign_up_trader.php');
    exit;
}