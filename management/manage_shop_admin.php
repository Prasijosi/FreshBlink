<?php

if (isset($_POST['submit']) && isset($_POST['sid'])) {

    $sid = $_POST['sid'];

    include 'connection.php';

    $sql = "UPDATE shop SET Shop_Verification='1' where Shop_Id='$sid'";  //first set shop verification to 1 since approve button has been pressed
    $qry = oci_parse($connection, $sql);
    oci_execute($qry);

    if ($qry) {

        include 'connection.php';

        $sql4 = "SELECT * from shop inner join trader ON shop.trader_Id=trader.trader_Id where Shop_Id=$sid";  //after setting verification to 1  then taking trader id to run another sql
        $qry4 = oci_parse($connection, $sql4);
        oci_execute($qry4);
        while ($row = oci_fetch_assoc($qry4)) {
            $tid = $row['TRADER_ID'];
            $temail = $row['EMAIL'];
            $tname = $row['NAME'];
        }

        include 'connection.php';
        $sql6 = "SELECT * from  trader where Trader_Id=$tid and TRADER_VERIFICATION=0";  //now checking if that trader is new or old
        $qry6 = oci_parse($connection, $sql6);
        oci_execute($qry6);

        $count = oci_fetch_all($qry6, $connection);
        oci_execute($qry6);

        if ($count == 1) {  //if trader is new then sending email function of new account approval

            include 'connection.php';


            $sql5 = "UPDATE trader SET TRADER_VERIFICATION='1', Status='approved' where TRADER_ID=$tid";
            $qry5 = oci_parse($connection, $sql5);
            oci_execute($qry5);

            if ($qry5) {

                include 'connection.php';
                $to_email = "echo $temail";
                $subject = "Welcome to FreshBlink!";
                $headers = "From: FreshBlink  <josiprasi@gmail.com>";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $message = '
            
            
                <html> <!-- #A3D0F8 -->
        <body style="color: #000; font-size: 16px; text-decoration: none; font-family:  Helvetica, Arial, sans-serif; background-color: #efefef;">
            
            <div id="wrapper" style="max-width: 600px; margin: auto auto; padding: 20px;">
                
                <div id="logo" style="">
                    <center><h1 style="margin: 0px;"><a href="{SITE_ADDR}" target="_blank">FreshBlink</a></h1></center>
                </div>
                    
                <div id="content" style="font-size: 16px; padding: 25px; background-color: #fff;
                    moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; -khtml-border-radius: 10px;
                    border-color: #A3D0F8; border-width: 4px 1px; border-style: solid;">
    
                    <h1 style="font-size: 22px;"><center>Dear ' . $tname . ' , Your Account has been Approved !</center></h1>
                    
                    <p>Hi,</p>
    
                    <p>Thank you for contacting us to request approval of seller account</p>
    
                    <p>We reviewed your account and the information you provided, and We have decided that you can now sell on FreshBlink</p>
    
                    <p>To get started with your new account, please visit here! (http://localhost:8000/index.php) </p>
    
                    <p>Enjoy selling products on FreshBlink</p>

                    <p style="display: flex; justify-content: center; margin-top: 10px;"><center>
					<a href="http://localhost:8000/trader/sign_in_trader.php" target="_blank" style="border: 1px solid #0561B3; background-color: #238CEA; 
					color: #fff; text-decoration: none; font-size: 18px; padding: 10px 20px;">Go To Your Account</a></div>
				</center></p>
    
                
                    
                </div>
    
                <div id="footer" style="margin-bottom: 20px; padding: 0px 8px; text-align: center;">
                    <a href="http://localhost:8000/index.php" target="_blank" style="text-decoration: none; color: #238CEA;">@FreshBlink</a> 
                </div>
            </div>
        </body>
    </html>';


                include '../sendmail.php';
                $result = sendEmail(
                    $temail,
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
            }
        }


        header('Location:managementseler.php?msg=Shop Approved');
    } else {


        header('Location:managementseler.php?msg=Query Not Running');
    }
} elseif (isset($_POST['submit2']) && isset($_POST['sid'])) {

    $sid = $_POST['sid'];
    $tid = $_POST['tid'];

    include 'connection.php';

    $sql8 = "SELECT * from shop inner join trader ON shop.trader_Id=trader.trader_Id where Shop_Id=$sid";
    $qry8 = oci_parse($connection, $sql8);
    oci_execute($qry8);

    $count8 = oci_fetch_all($qry8, $connection);
    oci_execute($qry8);

    if ($count8 == 1) {
        include 'connection.php';
        $tid1 = $_POST['tid'];
        $sql40 = "SELECT * from trader where trader_Id=$tid1";
        $qry40 = oci_parse($connection, $sql40);
        oci_execute($qry40);
        while ($row = oci_fetch_assoc($qry40)) {
            $temail = $row['EMAIL'];
            $tname = $row['NAME'];
        }

        $sql41 = "UPDATE trader SET Status='rejected' where trader_Id=$tid1";
        $qry41 = oci_parse($connection, $sql41);
        oci_execute($qry41);

        if ($qry41) {   //sending email saying account has been deleted or disapproved

            include 'connection.php';
            $to_email = "echo $temail";
            $subject = "Account Scheduled for Deletion!";
            $headers = "From: FreshBlink  <josiprasi@gmail.com>";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


            $message = '
            
            
            <html> <!-- #A3D0F8 -->
	<body style="color: #000; font-size: 16px; text-decoration: none; font-family:  Helvetica, Arial, sans-serif; background-color: #efefef;">
		
		<div id="wrapper" style="max-width: 600px; margin: auto auto; padding: 20px;">
			
			<div id="logo" style="">
				<center><h1 style="margin: 0px;"><a href="{SITE_ADDR}" target="_blank">FreshBlink</a></h1></center>
			</div>
				
			<div id="content" style="font-size: 16px; padding: 25px; background-color: #fff;
				moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; -khtml-border-radius: 10px;
				border-color: #A3D0F8; border-width: 4px 1px; border-style: solid;">

				<h1 style="font-size: 22px;"><center>Dear :' . $tname . ' , Your Account has been Disapproved !</center></h1>
				
				<p>Hi,</p>

				<p>We understand that you would like to join our FreshBlink Seller Community</p>

				<p>But! We reviewed your account and the information you provided, and we decided that you may no longer sell on FreshBlink</p>

				<p>You can learn more about our terms and condition for Seller account here (https://FreshBlink.com/terms-and-condition-seller) </p>

				<p>We may not reply to futher emails about this issue.</p>

			
				
			</div>

			<div id="footer" style="margin-bottom: 20px; padding: 0px 8px; text-align: center;">
				<a href="http://localhost:8000/index.php" target="_blank" style="text-decoration: none; color: #238CEA;">@FreshBlink</a> 
			</div>
		</div>
	</body>
</html>';

            include '../sendmail.php';
            $result = sendEmail(
                $temail,
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
        }
    }


    if ($qry8) {
        header('Location:managementseler.php?msg=Shop Deleted');
    } else {
        header('Location:managementseler.php?msg=Query Not Running');
    }
}
