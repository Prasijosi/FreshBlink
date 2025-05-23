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

    .verify-container {
        max-width: 500px;
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

    .btn-verify {
        height: 50px;
        background: #28a745;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        min-width: 200px;
    }

    .btn-verify:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    .back-link {
        color: #28a745;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .back-link:hover {
        color: #218838;
        text-decoration: none;
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

    .logo-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo-container img {
        width: 80px;
        height: auto;
        transition: transform 0.3s ease;
    }

    .logo-container img:hover {
        transform: scale(1.05);
    }

    .alert {
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border: none;
        padding: 1rem 1.25rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    @media (max-width: 576px) {
        .verify-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .logo-container img {
            width: 70px;
        }
    }
</style>

<div class="container-fluid px-3">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="verify-container">
                <?php
                if (isset($_GET['msg'])) {
                    $user_created_msg = $_GET['msg'];
                    echo "<div class='alert alert-danger text-center'>" . htmlspecialchars($user_created_msg) . "</div>";
                }
                ?>

                <div class="logo-container">
                    <a href="index.php">
                        <img src="images/logo.png" alt="FreshBlink Logo">
                    </a>
                </div>

                <form method="POST" action="customer/customer_email_verify_process.php">
                    <h4 class="section-title">Verify Your Email</h4>

                    <div class="form-group">
                        <label for="inputEmail" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="inputEmail" 
                               placeholder="Enter your email address" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="pincode" class="form-label">Verification Code</label>
                        <input type="number" class="form-control" id="pincode" 
                               placeholder="Enter 6-digit verification code" name="pincode" required>
                        <small class="form-text text-muted">
                            Please enter the 6-digit code sent to your email
                        </small>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-verify" name="submit">Verify Email</button>
                    </div>

                    <div class="text-center mt-4">
                        <a href="sign_in_customer.php" class="back-link">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Sign In
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'end.php'; ?>