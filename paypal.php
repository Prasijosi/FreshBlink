<?php
session_start();
$t = 0;
foreach ($_SESSION['cart'] as $key => $value) {
    //from here we get index value of array  , only key then whole data aaray shows if value added then index
    //print_r($key) ;

    $q = $value['quantity'];
    $p = $value['price'];

    $q1 = $q * $p; //quantuty * price

    //echo " Sub Total".$q1." ";  //subtotal price of one product

    $t = $q1 + $t; //grand total
}


//include_once("db_connect.php");
//Set variables for paypal form
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //always the same
//Test PayPal API URL
$paypal_email = 'sb-2fcha6626063@business.example.com'; //merchant account -> gets the money in this account
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
      integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/mystyle.css">
<title> Paypal Integration in PHP</title>


<div class="container">
  <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 p-5">
    <div class="row">
      <form action="<?php echo $paypal_url; ?>" method="post">
        <!-- Paypal business test account email id so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
        <!-- Buy Now button. -->
        <input type="hidden" name="cmd" value="_cart">
        <!--default/don't change-->

        <input type="hidden" name="upload" value="1">

        <!-- Details about the item that buyers will purchase. -->

          <?php

          $q2 = 0;
          $p2 = 0;
          $t2 = 0;

          $i = 0;
          foreach ($_SESSION['cart'] as $key => $values) {
              $item_name = $values['item_name'];
              $quantity = $values['quantity'];
              $price = $values['price'];


              $q2 = $values['quantity'];
              $p2 = $values['price'];

              $t2 = $q2 * $p2;

              $i = $i + 1;
              echo " 

					<input type='hidden' name='item_name_$i' value='$q2 X $values[item_name]'>
			<input type='hidden' name='item_number_$i' value='$i'>
			
			<input type='hidden' name='amount_$i' value='$p2'>
			<input type='hidden' name='quantity_$i' value='$q2'>


			

			<input type='hidden' name='currency_code' value='GBP'>	
		 ";
          }


          ?>


        <!-- URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost:8000/cancel.php'>
        <!--Change according to requirement-->

        <input type='hidden' name='return' value='http://localhost:8000/successful_checkout.php'>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h4 mt-5">
          Order Summary
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 border-bottom">
        </div>

        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end h6 mt-5">
          <a href="cart.php">
            Edit
          </a>
        </div>
        <div
          class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start mt-3">
          <table class="table mt-2">
            <thead class="thead-dark">
            <tr>
              <th class="text-center h6" style="width: 33.33333333333333%;">
                Image
              </th>
              <th class="text-center h6" style="width: 33.33333333333333%;">
                Product Description
              </th>
              <th class="text-center h6" style="width: 33.33333333333333%;">
                SubTotal
              </th>
            </tr>
            </thead>
            <tbody class="border">
            <?php
            $q2 = 0;
            $p2 = 0;
            $t2 = 0;
            foreach ($_SESSION['cart'] as $key => $values) {
                $item_name = $values['item_name'];
                $price = $values['price'];
                $quantity = $values['quantity'];
                $pimage = $values['image'];
                $q2 = $values['quantity'];
                $p2 = $values['price'];

                $t2 = $q2 * $p2;

                echo "<tr>
										<td class='col d-flex align-items-center justify-content-center'>
												<a href='#'>
													<img src='$pimage' class='img-fluid'>
												</a>
											</td>
											<td class='col-12 col-sm-12 border text-center' style='width: 33.33333333333333%;'>
											$item_name
											<input type='hidden' class='iprice' name='pprice' value='$values[price]'>
											</td>
											<td class='col border text-center' style='width: 33.33333333333333%;'>
											$t2
											<input type='hidden' class='form-control text-center iquantity' onchange='subTotal()' id='inputQtry' min='1' max='20' name='quan' value='$values[quantity]'>
											</td>

											
										</tr>";
            }
            ?>
            </tbody>
          </table>
        </div>
        <!-- <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start h6 my-3'>
                        Cart Subtotal
                        </div>
                        <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end h6 my-3'>
                            Rs ***
                        </div> -->
        <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 border mt-5'></div>
        <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start h5 my-4'>
          Cart Subtotal
        </div>
        <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end h5 my-4'
             id="gtotal">
            <?php echo $t; ?>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">


          <!-- payment button. -->
          <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
                 alt="PayPal - The safer, easier way to pay online">
          <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
        </div>
    </div>
    </form>
  </div>
</div>