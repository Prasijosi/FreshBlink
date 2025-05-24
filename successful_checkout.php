<?php
include 'start.php';
include "connection.php";
include 'sendmail.php';

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
        $quantity = (int)$row['TOTAL_PRICE'];
        //echo "Cart ID " . $ctid . " ";
        //echo "Payer ID " .$payerid."";


        $sql2 = " SELECT Product_Price, Stock FROM product WHERE Product_Id = :pid";
        $result2 = oci_parse($connection, $sql2);
        oci_bind_by_name($result2, ":pid", $pid);
        oci_execute($result2);

        while ($row = oci_fetch_array($result2)) {
            $productprice = floatval($row['PRODUCT_PRICE']);
            $stock = intval($row['STOCK']);
            //echo "Product Price " . $productprice . " ";

            $gt = $quantity * $productprice;

            $sql3 = "INSERT INTO orders(Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) 
                    VALUES (SYSDATE, :quantity, :gt, :cid, :pid, '0')";
            $result3 = oci_parse($connection, $sql3);
            oci_bind_by_name($result3, ":quantity", $quantity);
            oci_bind_by_name($result3, ":gt", $gt);
            oci_bind_by_name($result3, ":cid", $cid);
            oci_bind_by_name($result3, ":pid", $pid);
            oci_execute($result3);

            if ($result3) {
                unset($_SESSION['cart']);

                $remquantity = $stock - $quantity;
                $sql6 = "UPDATE product SET Stock = :remquantity WHERE Product_Id = :pid";
                $result6 = oci_parse($connection, $sql6);
                oci_bind_by_name($result6, ":remquantity", $remquantity);
                oci_bind_by_name($result6, ":pid", $pid);
                oci_execute($result6);
                if ($result6) {

                    $sql4 = "SELECT Cart_Id FROM cart WHERE Customer_Id = :cid";
                    $result4 = oci_parse($connection, $sql4);
                    oci_bind_by_name($result4, ":cid", $cid);
                    oci_execute($result4);

                    while ($row = oci_fetch_array($result4)) {

                        $cartid = $row['CART_ID'];

                        $sql5 = "DELETE FROM cart WHERE Cart_Id = :cartid";
                        $result5 = oci_parse($connection, $sql5);
                        oci_bind_by_name($result5, ":cartid", $cartid);
                        oci_execute($result5);
                    }
                }
            } else {
                echo "<script>alert('Order Not Placed');</script>";
            }
        } //


    }

    $sql7 = "SELECT * FROM orders WHERE Delivery_Status = 0 AND Customer_Id = :cid AND Order_Date = SYSDATE AND Order_Id > :maxid";
    $result7 = oci_parse($connection, $sql7);
    oci_bind_by_name($result7, ":cid", $cid);
    oci_bind_by_name($result7, ":maxid", $maxid);
    oci_execute($result7);

    while ($row = oci_fetch_assoc($result7)) {
        $oid = $row['ORDER_ID'];
        $oprice = $row['ORDER_PRICE'];

        $sql10 = "INSERT INTO time_slot(Time_Slot_Date, Time_Slot_Time, Order_Id, Customer_Id) 
                 VALUES (:taskoption, :timeoption, :oid, :cid)";
        $result10 = oci_parse($connection, $sql10);
        oci_bind_by_name($result10, ":taskoption", $taskoption);
        oci_bind_by_name($result10, ":timeoption", $timeoption);
        oci_bind_by_name($result10, ":oid", $oid);
        oci_bind_by_name($result10, ":cid", $cid);
        oci_execute($result10);

        $sql11 = "INSERT INTO payment(Payment_Id, Payment_type, Total_Payment, Customer_Id, Order_Id) 
                 VALUES (:payerid, 'Paypal', :oprice, :cid, :oid)";
        $result11 = oci_parse($connection, $sql11);
        oci_bind_by_name($result11, ":payerid", $payerid);
        oci_bind_by_name($result11, ":oprice", $oprice);
        oci_bind_by_name($result11, ":cid", $cid);
        oci_bind_by_name($result11, ":oid", $oid);
        oci_execute($result11);
    }
}

include "connection.php";
$sql15 = "SELECT * FROM orders INNER JOIN customer on 
orders.Customer_Id=customer.Customer_ID INNER join product on orders.Product_Id=product.Product_Id INNER JOIN shop on product.Shop_Id=shop.Shop_Id INNER JOIN trader on trader.Trader_Id=shop.Trader_id  AND orders.Customer_Id='$cid' AND orders.Delivery_Status=0  AND Order_Id>$maxid";
$qry15 = oci_parse($connection, $sql15);
oci_execute($qry15);
$s = 0;
@$gt1 = 0;

$count = oci_fetch_all($qry15, $connection);
oci_execute($qry15);

if ($count > 0) {
    $message = '';
    while ($row = oci_fetch_assoc($qry15)) {
        include "connection.php";
        $oid = $row['ORDER_ID'];
        $cname1 = $row['FULL_NAME'];
        $address1 = $row['ADDRESS'];
        $email1 = $row['EMAIL'];
        $to_email = $email1;
        $odate1 = $row['ORDER_DATE'];
        $oprice1 = $row['ORDER_PRICE'];
        @$gt1 = $oprice1 + @$gt1;
        $tname = $row['NAME'];
        $sname = $row['SHOP_NAME'];
        $taddress = $row['SHOP_LOCATION'];
        
        // Build email message
        $message = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshBlink Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #28a745; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f8f9fa; padding: 20px; }
        .order-details { margin: 20px 0; }
        .shop-details { margin: 20px 0; }
        .footer { text-align: center; margin-top: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        <div class="content">
            <h2>Thank you for your order!</h2>
            <p>Dear ' . htmlspecialchars($cname1) . ',</p>
            <p>Your order has been successfully placed.</p>
            
            <div class="order-details">
                <h3>Order Details:</h3>
                <ul>
                    <li><strong>Order ID:</strong> ' . htmlspecialchars($oid) . '</li>
                    <li><strong>Order Date:</strong> ' . htmlspecialchars($odate1) . '</li>
                    <li><strong>Total Amount:</strong> £' . htmlspecialchars($gt1) . '</li>
                    <li><strong>Delivery Address:</strong> ' . htmlspecialchars($address1) . '</li>
                    <li><strong>Collection Date:</strong> ' . htmlspecialchars($taskoption) . '</li>
                    <li><strong>Collection Time:</strong> ' . htmlspecialchars($timeoption) . '</li>
                </ul>
            </div>
            
            <div class="shop-details">
                <h3>Shop Details:</h3>
                <ul>
                    <li><strong>Shop Name:</strong> ' . htmlspecialchars($sname) . '</li>
                    <li><strong>Shop Location:</strong> ' . htmlspecialchars($taddress) . '</li>
                </ul>
            </div>
            
            <div class="footer">
                <p>Thank you for shopping with FreshBlink!</p>
                <p>If you have any questions, please contact our customer support.</p>
            </div>
        </div>
    </div>
</body>
</html>';
    }

    // Send email only if we have a message and email address
    if (!empty($message) && !empty($to_email)) {
        $result = sendEmail(
            $to_email,
            $cname1,
            $subject,
            $message,
            "Thank you for your order! Your order has been successfully placed."
        );

        if ($result === true) {
            echo "<script>alert('Order placed successfully! A confirmation email has been sent.');</script>";
        } else {
            echo "<script>alert('Order placed successfully! However, there was an error sending the confirmation email.');</script>";
        }
    } else {
        echo "<script>alert('Order placed successfully! However, there was an error preparing the confirmation email.');</script>";
    }
} else {
    // echo "order number must be greater than 0";
}

if (@$gt > 0) {
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

<style>
    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .success-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 3rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: white;
        font-size: 2.5rem;
    }

    .success-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .success-subtitle {
        color: #6c757d;
        font-size: 1.25rem;
        margin-bottom: 2rem;
    }

    .order-details {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin: 2rem 0;
    }

    .order-info {
        color: #495057;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .order-label {
        font-weight: 600;
        color: #2c3e50;
    }

    .email-receipt {
        background: #e9ecef;
        border-radius: 10px;
        padding: 2rem;
        margin-top: 2rem;
        text-align: center;
    }

    .email-icon {
        font-size: 3rem;
        color: #28a745;
        margin-bottom: 1rem;
    }

    .email-text {
        color: #6c757d;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    @media (max-width: 576px) {
        .success-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }
    }
</style>

<div class="container">
    <div class="success-container">
        <div class="text-center">
            <div class="success-icon">
                <i class="fas fa-check" style="color: white; background-color: #28a745; font-size: 3rem;"></i>
            </div>
            <h1 class="success-title">Thank You!</h1>
            <p class="success-subtitle">Your order was completed successfully.</p>
        </div>

        <?php if (isset($_GET['PayerID'])): ?>
            <div class="order-details">
                <div class="row" style="background-color: transparent;">
                    <div class="col-md-6" style="background-color: transparent;">
                        <p class="order-info" style="background-color: transparent;">
                            <span class="order-label" style="background-color: transparent;">Payment ID:</span><br>
                            <span style="background-color: transparent;">
                                <?php echo htmlspecialchars($payerid); ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6" style="background-color: transparent;">
                        <p class="order-info" style="background-color: transparent;">
                            <span class="order-label" style="background-color: transparent;">Collection Date:</span><br>
                            <span style="background-color: transparent;">
                                <?php echo htmlspecialchars($taskoption); ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="email-receipt">
                <i class="fas fa-envelope email-icon" style="background-color: #e9ecef;"></i>
                <p class="email-text" style="background-color: #e9ecef;">
                    An email receipt including the details about your order has been sent to the email address provided.
                </p>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-center">
                There was some issue while checking out. Please try again.
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-success btn-lg">
                <i class="fas fa-home mr-2" style="background-color: #28a745; color: white;"></i>Return to Home
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php';
include 'end.php'; ?>