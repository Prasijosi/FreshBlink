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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign Up</title>
    <!-- Bootstrap 4.0 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 2rem 0;
        }
        .signup-container {
            max-width: 800px;
            width: 100%;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .btn-signup {
            background: #28a745;
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-signup:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        .custom-control-label {
            color: #6c757d;
        }
        .signin-link {
            color: #28a745;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .signin-link:hover {
            color: #218838;
            text-decoration: none;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        .form-group label {
            font-weight: 500;
            color: #495057;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="signup-container">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-user-plus text-success mr-2"></i>
                        Create Your Account
                    </h3>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="customer_sign_up.php">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="uname">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="uname" name="uname" 
                                               placeholder="Choose a username" required
                                               value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Full Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="fname" name="fname" 
                                               placeholder="Enter your full name" required
                                               value="<?php echo isset($_GET['fname']) ? htmlspecialchars($_GET['fname']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Enter your email" required
                                               value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                        </div>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               placeholder="Enter your phone number"
                                               value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Create a password" required>
                                    </div>
                                    <small class="form-text text-muted">
                                        Password must include at least one capital letter, one number, one symbol, and be 8-20 characters long.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="repassword">Confirm Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control" id="repassword" name="repassword" 
                                               placeholder="Confirm your password" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </span>
                                        </div>
                                        <textarea class="form-control" id="address" name="address" 
                                                  placeholder="Enter your address" required rows="2"><?php echo isset($_GET['address']) ? htmlspecialchars($_GET['address']) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-venus-mars"></i>
                                            </span>
                                        </div>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male" <?php echo (isset($_GET['gender']) && $_GET['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo (isset($_GET['gender']) && $_GET['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            <option value="Other" <?php echo (isset($_GET['gender']) && $_GET['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="date" class="form-control" id="dob" name="dob" required
                                               value="<?php echo isset($_GET['dob']) ? htmlspecialchars($_GET['dob']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="cb" name="cb" required>
                                <label class="custom-control-label" for="cb">
                                    I agree to the <a href="#" class="text-success">Privacy Notice</a> and <a href="#" class="text-success">Terms of Use</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-signup btn-block">
                            <i class="fas fa-user-plus mr-2"></i>Create Account
                        </button>

                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account? 
                                <a href="../sign_in_customer.php" class="signin-link">Sign In</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>