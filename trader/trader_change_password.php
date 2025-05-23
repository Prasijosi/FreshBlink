<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}

include('connection.php');
$trader_id = $_SESSION['trader_id'];
$sql = "SELECT * FROM trader WHERE Trader_Id=$trader_id";

$qry = oci_parse($connection, $sql);
oci_execute($qry);

while ($r = oci_fetch_array($qry)) {
    $tname = $r['USERNAME'];
    $tuname = $r['NAME'];
    $email = $r['EMAIL'];
    $timage = $r['PROFILE_IMAGE'];
    $phone = $r['CONTACT'];
}
?>

<?php include 'theader.php'; ?>

<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light text-dark">
                    <h4 class="mb-0">My Account</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="../<?php echo $timage; ?>" 
                             alt="Profile Picture" 
                             class="img-thumbnail rounded-circle"
                             style="width: 180px; height: 180px; object-fit: cover;">
                    </div>
                    <a href="trader_profile_picture.php" class="btn btn-outline-secondary btn-sm">
                        Change Profile Picture
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    <a href="index.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="trader_crud.php" class="list-group-item list-group-item-action">Products</a>
                    <a href="trader_review.php" class="list-group-item list-group-item-action">Reviews</a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <section class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light text-dark">
                    <h4 class="mb-0">Change Password</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['msg'] . '</div>';
                    }
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    }
                    ?>
                    <form method="POST" action="trader_change_password_process.php">
                        <div class="form-group mb-3">
                            <label for="inputPassword" class="form-label">New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="inputPassword" 
                                   placeholder="Enter your new password" 
                                   name="password"
                                   required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="inputPassword1" class="form-label">Confirm New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="inputPassword1" 
                                   placeholder="Re-enter your new password" 
                                   name="repassword"
                                   required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="submit">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
unset($_SESSION['msg']);
unset($_SESSION['error']);
include '../end.php';
?>