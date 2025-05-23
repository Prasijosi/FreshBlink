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

if (isset($_POST['submit'])) {
    $tid = $_SESSION['trader_id'];
    $Profile_Image = $_FILES['Profile_Image'];
    $filename = $Profile_Image['name'];
    $fileerror = $Profile_Image['error'];
    $filetmp = $Profile_Image['tmp_name'];

    $imgext = explode('.', $filename);
    $filecheck = strtolower(end($imgext));

    $fileextstored = array('png', 'jpg', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {
        // Create directory if it doesn't exist
        $upload_dir = 'images/trader/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique filename
        $new_filename = uniqid() . '.' . $filecheck;
        $destinationfile = $upload_dir . $new_filename;
        $destinationfile1 = '../' . $upload_dir . $new_filename;

        if (move_uploaded_file($filetmp, $destinationfile1)) {
            $sql = "UPDATE trader SET Profile_Image = :profile_image WHERE Trader_Id = :trader_id";
            $query = oci_parse($connection, $sql);
            oci_bind_by_name($query, ':profile_image', $destinationfile);
            oci_bind_by_name($query, ':trader_id', $tid);
            
            if (oci_execute($query)) {
                header('Location:index.php?msg=Profile picture updated successfully');
                exit();
            }
        }
    }
    $error_message = "Error while uploading! Please try again.";
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
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Update Profile Picture</h4>
                    
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?= htmlspecialchars($error_message) ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-4">
                            <img src="../<?php echo $timage; ?>" 
                                 alt="Profile Picture" 
                                 class="img-thumbnail rounded-circle"
                                 style="width: 200px; height: 200px; object-fit: cover;">
                        </div>

                        <div class="mb-4">
                            <label for="Profile_Image" class="form-label">Choose new profile picture</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="Profile_Image" 
                                   name="Profile_Image" 
                                   accept=".jpg,.jpeg,.png"
                                   required>
                            <div class="form-text">Allowed formats: JPG, JPEG, PNG</div>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-primary">
                                Update Profile Picture
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary ms-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include '../end.php'; ?>