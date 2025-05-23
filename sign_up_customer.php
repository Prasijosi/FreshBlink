<?php
include 'start.php';
?>
<?php include 'header.php'; ?>

  <div class="container w-100 d-flex align-items-center justify-content-center">
      <?php
      if (isset($_GET['message'])) {
          $user_created_msg = $_GET['message'];
          echo "<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 d-flex align-items-center justify-content-center' style='color:green;'>" . $user_created_msg . "
                </div>";
      }
      ?>
    <div class="row mt-3">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-5">
        <a href="index.php">
          <img src="images/logo.png" class="img-fluid" style="width: 10rem; ">
        </a>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-3">
        <form class="border p-5 mt-2" method="POST" action="customer/customer_sign_up.php">
          <div class="row">
            <div
              class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
              <div class="h4 mt-1">Customer : Create Account</div>
            </div>
          </div>
          <div class="row">
            <div
              class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
              <div class="h6 mt-3">Want to be a Trader?
                <a href="trader/sign_up_trader.php">
                  <u>
                    Create a Trader account here
                  </u>
                </a>
              </div>
            </div>
          </div>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color:red; text-align:center'>" . $_SESSION['error'] . "</p> ";
            }
            ?>
          <div class="form-group mt-3">
            <label for="inputUsername">Username</label>
            <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="uname"
                   value="<?php if (isset($_GET['uname'])) {
                       echo $_GET['uname'];
                   } ?>">
          </div>
          <div class="form-group">
            <label for="inputfullName">Full Name</label>
            <input type="text" class="form-control" id="inputfullName" placeholder="Full Name" name="fname"
                   value="<?php if (isset($_GET['fname'])) {
                       echo $_GET['fname'];
                   } ?>">
          </div>
          <div class="form-group row">
            <label for="inputEmail" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Email</label>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <input type="email" class="form-control" id="inputEmail" placeholder="Email Address" name="email"
                     value="<?php if (isset($_GET['email'])) {
                         echo $_GET['email'];
                     } ?>">
            </div>
          </div>

          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-0">Gender</legend>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="genderRadio"
                         value="Male" <?php if (isset($_GET['gender']) && $_GET['gender'] == "Male") echo "checked"; ?>
                         checked style="width: 1vw; height: 1vw;">
                  <label class="form-check-label" for="genderRadio">
                    Male
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="genderRadio1"
                         style="width: 1vw; height: 1vw;"
                         value="Female" <?php if (isset($_GET['gender']) && $_GET['gender'] == "Female") {
                      echo "checked";
                  } ?> />
                  <label class="form-check-label" for="genderRadio1">
                    Female
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="genderRadio2"
                         value="Other" <?php if (isset($_GET['gender']) && $_GET['gender'] == "Other") echo "checked"; ?>
                         style="width: 1vw; height: 1vw;">
                  <label class="form-check-label" for="genderRadio2">
                    Other
                  </label>
                </div>
              </div>
            </div>
          </fieldset>

          <div class="form-group row">
            <label for="inputDOB" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Date of
              Birth</label>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <input type="date" class="form-control" id="inputDOB" name="dob" value="<?php if (isset($_GET['dob'])) {
                  echo $_GET['dob'];
              } ?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword"
                   class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Password</label>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <input type="password" class="form-control" id="inputPassword" placeholder="Enter your Password"
                     name="password">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword1" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Confirm
              your password</label>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <input type="password" class="form-control" id="inputPassword1" placeholder="Re-enter your Password"
                     name="repassword">
            </div>
          </div>
          <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="Address" name="address"
                   value="<?php if (isset($_GET['address'])) {
                       echo $_GET['address'];
                   } ?>">
          </div>
          <div class="form-group">
            <label for="inputphoneNumber">Phone Number</label>
            <input type="text" class="form-control" id="inputphoneNumber" placeholder="Phone Number" name="phone"
                   value="<?php if (isset($_GET['phone'])) {
                       echo $_GET['phone'];
                   } ?>">
          </div>


          <div class="form-group row">
            <div
              class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkBox" style="width:1.2vw; height: 1.2vw;"
                       name="cb">
                <label class="form-check-label" for="checkBox">
                  <span>By creating an account, you agree to FreshBlink Privacy <br>Notice and Terms of Use.</span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div
              class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
              <button type="submit" class="btn btn-success" name="submit">Sign Up</button>
            </div>
          </div>
          <div class="row">
            <div
              class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
              <a href="sign_in_customer.php" style="font-size: 1vw">Have an account? Sign In</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php include 'footer.php'; ?>
<?php include 'end.php' ?>