<?php include '../start.php';
if(isset($_POST['submit'])){
    unset($_SESSION['trader_id']);
    unset($_SESSION['trader_email']);
    unset($_SESSION['trader_username']);
    header('Location:../index.php');
}
?>

<style>
    .request-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }

    .request-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2.5rem;
        margin-top: 2rem;
    }

    .logo-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo-container img {
        width: 80px;
        height: 80px;
        transition: transform 0.3s ease;
    }

    .logo-container img:hover {
        transform: scale(1.05);
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        background: #fff3cd;
        color: #856404;
        border-radius: 50px;
        font-weight: 500;
        margin: 1rem 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .email-display {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
        font-size: 1.1rem;
        color: #495057;
        border: 1px solid #e9ecef;
    }

    .info-text {
        color: #6c757d;
        line-height: 1.6;
        margin: 1.5rem 0;
    }

    .action-button {
        padding: 0.8rem 2.5rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .signup-link {
        color: #28a745;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .signup-link:hover {
        color: #218838;
        text-decoration: underline;
    }

    .alert-message {
        background: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="container request-container">
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert-message">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <div class="request-card">
        <div class="logo-container">
            <a href="../index.php">
                <img src="../images/logo.png" alt="FreshBlink Logo" class="img-fluid">
            </a>
        </div>

        <div class="text-center">
            <div class="status-badge">
                <i class="fas fa-clock me-2"></i>Request Pending
            </div>
        </div>

        <div class="email-display text-center">
            <i class="fas fa-envelope me-2"></i>
            <?php echo htmlspecialchars($_SESSION['trader_email']); ?>
        </div>

        <div class="text-center">
            <h4 class="mb-3">Request Sent Successfully!</h4>
            <p class="info-text">
                We've received your trader account request and notified our admin team. 
                Please check your email for updates or return here to check your approval status.
            </p>
        </div>

        <div class="text-center mt-4">
            <form method="POST" action="new_trader_request.php" class="d-inline">
                <button type="submit" class="btn btn-success action-button" name="submit">
                    <i class="fas fa-check me-2"></i>OK
                </button>
            </form>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">
                <a href="sign_up_trader.php" class="signup-link">
                    <i class="fas fa-user-plus me-2"></i>Want to be a trader? Sign Up Here
                </a>
            </p>
        </div>
    </div>
</div>

<?php include '../end.php' ?>