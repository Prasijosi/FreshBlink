<?php
include 'start.php';
?>
<?php include 'header.php'; ?>

<style>
    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .signup-container {
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
        padding: 2.5rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        height: 50px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
    }

    textarea.form-control {
        height: auto;
        min-height: 100px;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .btn-signup {
        height: 50px;
        background: #28a745;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
    }

    .btn-signup:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    .signin-link {
        color: #28a745;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .signin-link:hover {
        color: #218838;
        text-decoration: none;
    }

    .alert {
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border: none;
        padding: 1rem 1.25rem;
    }

    .section-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        padding-bottom: 1rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: #28a745;
        border-radius: 3px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-check {
        padding-left: 1.75rem;
    }

    .form-check-input {
        margin-left: -1.75rem;
    }

    .form-check-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .logo-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo-container img {
        width: 120px;
        height: auto;
        transition: transform 0.3s ease;
    }

    .logo-container img:hover {
        transform: scale(1.05);
    }

    @media (max-width: 576px) {
        .signup-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .logo-container img {
            width: 100px;
        }
    }
</style>

<div class="container-fluid px-3">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="signup-container">
                <?php
                if (isset($_GET['message'])) {
                    $user_created_msg = $_GET['message'];
                    echo "<div class='alert alert-success text-center'>" . htmlspecialchars($user_created_msg) . "</div>";
                }
                ?>

                <div class="logo-container">
                    <a href="index.php">
                        <img src="images/logo.png" alt="FreshBlink Logo">
                    </a>
                </div>

                <form method="POST" action="customer/customer_sign_up.php">
                    <h4 class="section-title">Create Your Account</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputUsername">Username</label>
                                <input type="text" class="form-control" id="inputUsername"
                                    placeholder="Choose a username" name="uname"
                                    value="<?php if (isset($_GET['uname'])) echo htmlspecialchars($_GET['uname']); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputfullName">Full Name</label>
                                <input type="text" class="form-control" id="inputfullName"
                                    placeholder="Enter your full name" name="fname"
                                    value="<?php if (isset($_GET['fname'])) echo htmlspecialchars($_GET['fname']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmail">Email Address</label>
                                <input type="email" class="form-control" id="inputEmail"
                                    placeholder="Enter your email" name="email"
                                    value="<?php if (isset($_GET['email'])) echo htmlspecialchars($_GET['email']); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputphoneNumber">Phone Number</label>
                                <input type="tel" class="form-control" id="inputphoneNumber"
                                    placeholder="Enter your phone number" name="phone"
                                    value="<?php if (isset($_GET['phone'])) echo htmlspecialchars($_GET['phone']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputDOB">Date of Birth</label>
                                <input type="date" class="form-control" id="inputDOB" name="dob"
                                    value="<?php if (isset($_GET['dob'])) echo htmlspecialchars($_GET['dob']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" class="form-control" id="inputPassword"
                                    placeholder="Create a password" name="password">
                                <small class="form-text text-muted">
                                    Must include uppercase, number, and special character
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword1">Confirm Password</label>
                                <input type="password" class="form-control" id="inputPassword1"
                                    placeholder="Confirm your password" name="repassword">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <textarea class="form-control" id="inputAddress"
                            placeholder="Enter your address" name="address" rows="2"><?php if (isset($_GET['address'])) echo htmlspecialchars($_GET['address']); ?></textarea>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderRadio"
                                        value="Male" <?php if (isset($_GET['gender']) && $_GET['gender'] == "Male") echo "checked"; ?> checked>
                                    <label class="form-check-label" for="genderRadio">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderRadio1"
                                        value="Female" <?php if (isset($_GET['gender']) && $_GET['gender'] == "Female") echo "checked"; ?>>
                                    <label class="form-check-label" for="genderRadio1">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderRadio2"
                                        value="Other" <?php if (isset($_GET['gender']) && $_GET['gender'] == "Other") echo "checked"; ?>>
                                    <label class="form-check-label" for="genderRadio2">Other</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkBox" name="cb">
                            <label class="form-check-label" for="checkBox">
                                I agree to the <a href="#" class="text-success">Privacy Notice</a> and <a href="#" class="text-success">Terms of Use</a>
                            </label>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-signup btn-block" name="submit">Create Account</button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0">Already have an account?
                            <a href="sign_in_customer.php" class="signin-link">Sign In</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'end.php'; ?>