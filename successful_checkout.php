<?php
include 'start.php';
include "connection.php";

if (!isset($_SESSION['username'])) {
    header('Location:sign_in_customer.php');
    exit;
}

$un = $_SESSION['username'];
$cemail = '';

// Get customer email
$sql100 = "SELECT Email FROM customer WHERE Username = :username";
$result100 = oci_parse($connection, $sql100);
oci_bind_by_name($result100, ":username", $un);
oci_execute($result100);

if ($row = oci_fetch_assoc($result100)) {
    $cemail = $row['EMAIL'];
}

if (empty($cemail)) {
    die("Customer email not found.");
}

$to_email = $cemail;
$subject = "Your FreshBlink order has been received!";
$headers = "From: FreshBlink <josiprasi@gmail.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

if (isset($_GET['PayerID'])) {
    $payerid = $_GET['PayerID'];
}

if (!isset($_SESSION['username'])) {
    header('Location:sign_in_customer.php');
}
/*
if(isset($_POST['radio1'])  ){   //this is for while inserting in payment table just testing
	$v=$_POST['radio1'];
	include "connection.php";
	echo"collection  select";
	$sql0 = " INSERT INTO `c`(`iname`, `oid`, `v`) VALUES ('1','2','$v') ";
	$result0 = mysqli_query($connection, $sql0);
	}
	else{
		echo "collection not selected";
	}

	*/

foreach ($_SESSION['collectionslot'] as $key => $value) {


    $taskoption = $value['task_option'];
    $timeoption = $value['time_option'];
}


include "connection.php";


$un = $_SESSION['username'];

$sql1 = " SELECT Customer_ID FROM customer WHERE Username = '$un'";


$result1 = oci_parse($connection, $sql1);
oci_execute($result1);

while ($row = oci_fetch_array($result1)) {

    $cid = $row['CUSTOMER_ID'];
    //echo $cid . " ";

    $sql8 = " SELECT MAX(Order_Id) as Order_Id FROM orders";
    $result8 = oci_parse($connection, $sql8);
    oci_execute($result8);

    while ($row = oci_fetch_array($result8)) {
        $maxid = $row['ORDER_ID'];
    }

    $sql = " SELECT * FROM cart WHERE Customer_Id = '$cid'";
    $result = oci_parse($connection, $sql);
    oci_execute($result);


    while ($row = oci_fetch_array($result)) {

        $ctid = $row['CART_ID'];
        $pid = $row['PRODUCT_ID'];
        $quantity = $row['TOTAL_PRICE'];
        //echo "Cart ID " . $ctid . " ";
        //echo "Payer ID " .$payerid."";


        $sql2 = " SELECT Product_Price, Stock FROM product WHERE Product_Id = '$pid'";
        $result2 = oci_parse($connection, $sql2);
        oci_execute($result2);

        while ($row = oci_fetch_array($result2)) {
            $productprice = $row['PRODUCT_PRICE'];
            $stock = $row['STOCK'];
            //echo "Product Price " . $productprice . " ";

            $gt = $quantity * $productprice;

            $sql3 = "INSERT INTO orders(Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES (SYSDATE,'$quantity','$gt','$cid','$pid','0')";

            $result3 = oci_parse($connection, $sql3);
            oci_execute($result3);

            if ($result3) {
                unset($_SESSION['cart']);

                $remquantity = $stock - $quantity;
                $sql6 = "UPDATE product SET Stock='$remquantity' WHERE Product_Id='$pid'";
                $result6 = oci_parse($connection, $sql6);
                oci_execute($result6);
                if ($result6) {

                    $sql4 = "SELECT Cart_Id FROM cart WHERE Customer_Id='$cid'";
                    $result4 = oci_parse($connection, $sql4);
                    oci_execute($result4);

                    while ($row = oci_fetch_array($result4)) {

                        $cartid = $row['CART_ID'];

                        $sql5 = " delete from cart where Cart_Id='$cartid' ";
                        $result5 = oci_parse($connection, $sql5);
                        oci_execute($result5);
                    }
                }


            } else {
                echo " <script>
								alert('Order Not Placed');
								//window.location.href='checkout.php';
								</script>";
            }
        } //


    }

    $sql7 = "SELECT * FROM orders WHERE Delivery_Status=0 AND Customer_Id='$cid' AND Order_Date=SYSDATE AND Order_Id>'$maxid'";
    $result7 = oci_parse($connection, $sql7);
    oci_execute($result7);

    while ($row = oci_fetch_assoc($result7)) {
        $oid = $row['ORDER_ID'];
        $oprice = $row['ORDER_PRICE'];

        $sql10 = "INSERT INTO time_slot(Time_Slot_Date, Time_Slot_Time, Order_Id, Customer_Id) VALUES ('$taskoption','$timeoption','$oid','$cid')";
        $result10 = oci_parse($connection, $sql10);
        oci_execute($result10);

        $sql11 = "INSERT INTO payment(Payment_Id, Payment_type, Total_Payment, Customer_Id, Order_Id) VALUES ('$payerid','Paypal','$oprice','$cid','$oid')";
        $result11 = oci_parse($connection, $sql11);
        oci_execute($result11);
    }
}

include "connection.php";
$sql15 = "SELECT * FROM orders INNER JOIN customer on 
orders.Customer_Id=customer.Customer_ID INNER join product on orders.Product_Id=product.Product_Id INNER JOIN shop on product.Shop_Id=shop.Shop_Id INNER JOIN trader on trader.Trader_Id=shop.Trader_id  AND orders.Customer_Id='$cid' AND orders.Delivery_Status=0  AND Order_Id>$maxid";
$qry15 = oci_parse($connection, $sql15);
oci_execute($qry15);
$s = 0;
$gt1 = 0;

$count = oci_fetch_all($qry15, $connection);
oci_execute($qry15);

if ($count > 0) {


    while ($row = oci_fetch_assoc($qry15)) {
        include "connection.php";
        $oid = $row['ORDER_ID'];
        $cname1 = $row['FULL_NAME'];
        $address1 = $row['ADDRESS'];
        $email1 = $row['EMAIL'];
        $odate1 = $row['ORDER_DATE'];

        $oprice1 = $row['ORDER_PRICE'];
        $gt1 = $oprice1 + $gt1;

        $tname = $row['NAME'];
        $sname = $row['SHOP_NAME'];
        $taddress = $row['SHOP_LOCATION'];


    }

    include "connection.php";
    $sql20 = "SELECT * FROM orders INNER JOIN customer on 
			orders.Customer_Id=customer.Customer_ID INNER join product on orders.Product_Id=product.Product_Id  AND orders.Customer_Id='$cid' AND orders.Delivery_Status=0  AND Order_Id>$maxid";
    $qry20 = oci_parse($connection, $sql20);
    oci_execute($qry20);


    $message = '

<html>




<body style="color: #000; font-size: 16px; text-decoration: none; font-family: , Helvetica, Arial, sans-serif; background-color: #efefef;">

<div id="wrapper" style="max-width: 1000px; margin: auto auto; padding: 20px;">
<div id="logo" style="">
				<center><h1 style="margin: 0px;"><a href="http://localhost:8000/index.php" target="_blank">FreshBlink</a></h1></center>
			</div>

            <div id="content" style="font-size: 16px; padding: 25px; background-color: #fff;
				moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; -khtml-border-radius: 10px;
				border-color: #A3D0F8; border-width: 4px 1px; border-style: solid;">

                <div>
                    
                Bill From: <br>
                FreshBlink <br>
                Clechshudderfax <br>
                josiprasi@gmail.com <br>
                <br>
                
                
                </div>

                <div style=" color:white; display:flex;
                justify-content:center;background-color:#898989;">Sales Invoice</div>


                <div style="float: right; ">   
                
                <P>Invoice NO: ' . $payerid . '</P>
                <P>Invoice Date: ' . $odate1 . '</P>
              
                <P>Order Date: ' . $odate1 . '</P>
              
                </div>
                
                <div style="display: block; ">                
                <P>Bill To: </P>
                <P>Customer Name: ' . $cname1 . '</P>
                <P>Customer Address: ' . $address1 . '</P>
                
               
                </div>



							<br>
			<div style="display: block; ">                
			<P>Sold By: </P>
			<P>Trader Name: ' . $tname . '</P>
			<P>Shop Name: ' . $sname . '</P>
			<P>Address: ' . $taddress . '</P>
			<P>Seller Email: ' . $email1 . '</P>
			</div>

						<br>
			<div style="display: block; ">                
			<P>Payment Method: Paypal</P>

			</div>

	

			

	

		<table style=" width:100%; border-style:solid; border-width:1px; border-color:#000000; border-collapse: collapse;">
		<tr>
		<th>SN</th>
		  <th>Product ID</th>
		  <th>Product Name</th>
		  <th>Product Description</th>
		  <th>Qty</th>
		  <th>Unit Cost</th>
		  <th>Discount</th>
		  <th>Total Price</th>
		</tr>';


    include 'connection.php';


    while ($row = oci_fetch_assoc($qry20)) {
        include 'connection.php';
        $s = $s + 1;
        $cname2 = $row['FULL_NAME'];


        $message .= '
		  <tr>
		  <td>' . $s . '</td>
		  <td>' . $row['PRODUCT_ID'] . '</td>
		  <td>' . $row['PRODUCT_NAME'] . '</td>
		  <td>' . $row['PRODUCT_DETAILS'] . '</td>
		  <td>' . $row['QUANTITY'] . '</td>
		  <td>' . $row['PRODUCT_PRICE'] . '</td>
		  <td>0</td>
		  <td>' . $row['ORDER_PRICE'] . '</td>
		  
		  
		  </tr>';
    }


    $message .= ' 

<tr>
<td  colspan="6" ></td>
<td   >Total: </td>
<td   >' . $gt1 . '</td>
  </tr>
</table>
</div>
</div>

</body>

</html>
';

} else {
    echo "order number must be greater than 0";


}

include 'sendmail.php';

if ($gt > 0) {
    $result = sendEmail(
        $to_email,
        '',
        $subject,
        $message,
        ""
    );

    if ($result === true) {
        echo "✅ Email sent successfully.";
    } else {
        echo $result; // Displays the error message
    }
} else {
    // header('Location:index.php');
    //echo "Plz order";
}


?>
<?php include 'header.php' ?>

  <div class="container mb-5">
    <div class="row text-center mt-5" style="border: 0.1vw solid black;">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="h1 mt-5">Thank You !</div>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="h3">Your order was completed successfully.</div>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
          <?php

          include('connection.php');
          $un = $_SESSION['username'];
          $sql1 = " SELECT Customer_ID FROM customer WHERE Username = '$un'";


          $result1 = oci_parse($connection, $sql1);
          oci_execute($result1);

          while ($row = oci_fetch_array($result1)) {

              $cid = $row['CUSTOMER_ID'];

              $sql7 = "SELECT Order_Id FROM orders WHERE Customer_Id= '$cid' and Delivery_Status!=1";
              $result7 = oci_parse($connection, $sql7);
              oci_execute($result7);

              while ($row = oci_fetch_array($result7)) {

                  $orderid = $row['ORDER_ID'];

                  //echo "<div class='h4'>Your order number is $orderid </div>";
              }
          }
          ?>


      </div>

        <?php
        if (isset($_GET['PayerID'])) {
            $payerid = $_GET['PayerID'];
            echo " 
				<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
				<div class='h4'>Your Payment ID is  $payerid   </div>
					<div class='h5'>You can pickup your order  $taskoption</div>
				</div>
				<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-5'>
					<div class='row'>
						<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center d-flex align-items-center justify-content-center'>
							<i class='fas fa-envelope d-flex align-items-center justify-content-end' style='font-size:4vw;'></i>
						</div>
						<div class='col-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 d-flex align-items-center justify-content-center mt-4'>
							<div class='h5 text-justify text-center'>An email receipt including the details about your order has been sent to the email address provided.</div>
						</div>
					</div>
				</div>
				";
        } else {
            echo "There was some issue while checking out";
        }

        ?>

    </div>
  </div>
<?php include 'footer.php';
include 'end.php'; ?>