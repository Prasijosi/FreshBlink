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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign In</title>
    <!-- Bootstrap 4.0 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .signin-container {
            max-width: 400px;
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
        .btn-signin {
            background: #28a745;
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-signin:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        .custom-control-label {
            color: #6c757d;
        }
        .signup-link {
            color: #28a745;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .signup-link:hover {
            color: #218838;
            text-decoration: none;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="signin-container">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-user-circle text-success mr-2"></i>
                        Customer Sign In
                    </h3>
                    
                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_GET['msg']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="customer_sign_in.php">
                        <div class="form-group">
                            <label for="email" class="font-weight-medium">Email Address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-success"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Enter your email" required 
                                       value="<?php echo isset($_COOKIE["email"]) ? $_COOKIE["email"] : ''; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="font-weight-medium">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-lock text-success"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Enter your password" required
                                       value="<?php echo isset($_COOKIE["password"]) ? $_COOKIE["password"] : ''; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember" name="remember"
                                       <?php echo isset($_COOKIE["email"]) ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="remember">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-signin btn-block">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </button>

                        <div class="text-center mt-3">
                            <p class="mb-0">Don't have an account? 
                                <a href="../sign_up_customer.php" class="signup-link">Sign Up</a>
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
