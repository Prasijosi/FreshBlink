<?php include '../start.php'; ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 500px;">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-danger text-center mt-2">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="../index.php">
                <img src="../images/logo.png" class="img-fluid" style="width: 20rem" alt="FreshBlink Logo">
            </a>
        </div>

        <form class="border p-4 mt-4 rounded shadow-sm bg-light" method="POST" action="trader_sign_in.php">
            <h4 class="text-center mb-3">Trader/Admin Sign-In</h4>

            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email"
                       class="form-control"
                       id="inputEmail"
                       name="email"
                       placeholder="Email"
                       required
                       value="<?= isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password"
                       class="form-control"
                       id="inputPassword"
                       name="password"
                       placeholder="Password"
                       required
                       value="<?= isset($_COOKIE['password']) ? htmlspecialchars($_COOKIE['password']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="userType">User Type</label>
                <select id="userType" name="c" class="form-control">
                    <option value="t" <?= (isset($_POST['c']) && $_POST['c'] == "t") ? 'selected' : '' ?>>Trader</option>
                    <option value="a" <?= (isset($_POST['c']) && $_POST['c'] == "a") ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input"
                       type="checkbox"
                       id="rememberMe"
                       name="remember"
                       <?= isset($_COOKIE["email"]) ? 'checked' : '' ?>>
                <label class="form-check-label" for="rememberMe">
                    Remember Me
                </label>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success" name="submit">Sign In</button>
            </div>

            <div class="text-center mt-3">
                <a href="sign_up_trader.php" style="font-size: 16px;">Wanna be one of us? Sign Up Here</a>
            </div>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>
<?php include '../end.php'; ?>
