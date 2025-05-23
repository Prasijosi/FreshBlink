<?php include '../start.php'; ?>
<?php include '../header.php'; ?>

<div class="container w-100 d-flex align-items-center justify-content-center">
    <div class="row mt-3 w-100">
        <div class="col-12 d-flex align-items-center justify-content-center mt-5">
            <a href="index.php">
                <img src="../images/logo.png" class="img-fluid" style="width: 10rem;">
            </a>
        </div>

        <div class="col-12 d-flex align-items-center justify-content-center mt-3">
            <form class="border p-5 mt-2 w-100" method="POST" action="trader_sign_up.php" style="max-width: 600px;">
                <div class="text-center">
                    <div class="h4">Trader Registration</div>
                    <div class="h6 mt-3">Welcome! You are one step away to sell on FreshBlink</div>
                </div>

                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p style='color:red; text-align:center'>" . $_SESSION['error'] . "</p>";
                }
                ?>

                <div class="form-group mt-3">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="uname" value="<?php echo $_GET['uname'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="inputfullName">Full Name</label>
                    <input type="text" class="form-control" id="inputfullName" placeholder="Full Name" name="fname" value="<?php echo $_GET['fname'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" placeholder="Email Address" name="email" value="<?php echo $_GET['email'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter your Password" name="password">
                </div>

                <div class="form-group">
                    <label for="inputPassword1">Confirm your Password</label>
                    <input type="password" class="form-control" id="inputPassword1" placeholder="Re-enter your Password" name="repassword">
                </div>

                <div class="form-group">
                    <label for="inputAddress">Shop Name</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Shop Name" name="shopname" value="<?php echo $_GET['shopname'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Shop Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="what"><?php echo $_GET['what'] ?? ''; ?></textarea>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="checkbox" name="cb">
                    <label class="form-check-label" for="checkbox">
                        By creating an account, you agree to FreshBlink Privacy Notice and Terms of Use.
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success" name="submit">Sign Up</button>
                </div>

                <div class="text-center mt-3">
                    <a href="sign_in_trader.php" style="font-size: 16px;">Have an account? Sign In</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
<?php include '../end.php'; ?>
