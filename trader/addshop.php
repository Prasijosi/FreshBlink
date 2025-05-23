<?php
include '../start.php';


if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}
?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trader Add Shop</title>


  </head>

  <body>
  <?php include 'theader.php'; ?>
  <div class="container">

    <form method="POST" action="traderaddshop.php">
      <br>
      <h6>Add Shop</h6></br>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<h4 style='text-align: center; color:red;'>" . $_SESSION['error'] . "</h4>";
        }

        if (isset($_SESSION['right'])) {
            echo "<h4 style='text-align: center; color:green;'>" . $_SESSION['right'] . "</h4>";
        }

        ?>

      <div class="mb-3">
        <label for="story">Shop Name</label>
        <input type="text" class="form-control" name="sname" placeholder="" value="<?php if (isset($_GET['sname'])) {
            echo $_GET['sname'];
        } ?>">


        <div class="mb-3">
          <label for="display-name">Shop Address</label>
          <input type="text" class="form-control" name="saddress" placeholder=""
                 value="<?php if (isset($_GET['saddress'])) {
                     echo $_GET['saddress'];
                 } ?>">


          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">What types of items are you going to
              list?</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="what"
                      value="<?php if (isset($_GET['what'])) {
                          echo $_GET['what'];
                      } ?>"></textarea>
          </div>

          <br>
          <div class="form-group row"></br>
            <div
              class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
              <button type="submit" class="btn btn-success" name="submit">Submit</button>
            </div>

    </form>

  </body>

  </html>

<?php
unset($_SESSION["error"]);
unset($_SESSION["right"]);
?>