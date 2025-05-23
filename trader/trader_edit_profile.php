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


    $tuname = $r['USERNAME'];
    $tname = $r['NAME'];
    $email = $r['EMAIL'];
    $timage = $r['PROFILE_IMAGE'];

    $phone = $r['CONTACT'];
}


if (isset($_POST['submit'])) {

    $tuname1 = $_POST['tuname'];
    $tname1 = $_POST['tname'];
    $tphone = $_POST['tphone'];
    $temail = $_POST['temail'];

    $sql = "UPDATE trader SET Username='$tuname1' , Name='$tname1', Contact='$tphone', Email='$temail' WHERE Trader_Id=$trader_id";
    $qry = oci_parse($connection, $sql);
    oci_execute($qry);

    if ($qry) {

        unset($_SESSION['trader_email']);
        unset($_SESSION['trader_username']);

        include('connection.php');

        $sql = "SELECT * FROM trader WHERE Trader_Id=$trader_id";
        $qry = oci_parse($connection, $sql);
        oci_execute($qry);

        while ($r = oci_fetch_array($qry)) {
            $_SESSION['trader_username'] = $r['USERNAME'];

            $_SESSION['trader_email'] = $r['EMAIL'];

        }


        $_SESSION['msg'] = "Account Details Updated Successfully";

        header('Location:index.php');
        exit();
    } else {

        header('Location:index.php');
        exit();
    }
}


?>


<?php include 'theader.php'; ?>

  <div class="container mt-3">
    <div class="row">
      <div class="col-4 border">
          <?php echo " 
<img src='../$timage' class='img-fluid mx-auto d-block mt-3' alt='No Trader Image' style='height: 200px; width: 200px;  '   >";
          ?>
        <div style="text-align: center; margin-top: 10px;">


          <a href="trader_profile_picture.php">Change Profile Picture</a>
        </div>
        <p class="h3 mt-3">My Account</p>
        <p>Edit Account Information</p>


      </div>
      <div class="col border ml-4 float-right">
        <h3>Edit Account Information</h3>

        <div>Account Information</div>
        <form method="POST" action="trader_edit_profile.php">


          <div class="form-group mt-3">
            <label for="inputUsername">Username</label>
            <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="tuname"
                   value="<?php echo $tuname; ?>">
          </div>

          <div class="form-group">
            <label for="inputFullname">Full Name</label>
            <input type="text" class="form-control" id="inputFullname" placeholder="Full Name" name="tname"
                   value="<?php echo $tname; ?>">

          </div>

          <div class="form-group">
            <label for="inputPhonenumber">Phone Number</label>
            <input type="number" class="form-control" id="inputPhonenumber" placeholder="Phone Number" name="tphone"
                   value="<?php echo $phone; ?>">

          </div>

          <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="temail"
                   value="<?php echo $email; ?>">

          </div>

          <div class="form-group">

            <button type="submit" class="btn btn-success" name="submit">Save Changes</button>
          </div>


        </form>


      </div>


    </div>
  </div>


<?php

include '../end.php' ?>