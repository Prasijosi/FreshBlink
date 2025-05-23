<?php

include('connection.php');
session_start();
if (isset($_POST['update'])) {
    $cid = $_POST['cid'];
    $uname = $_POST['uname'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];

    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    if (!empty($uname) && !empty($fname) && !empty($email) && !empty($address)  && !empty($gender) && !empty($dob)) {

        $sql = "UPDATE customer SET Username = '$uname', Full_Name='$fname', Email = '$email', Address='$address', 
        Contact_number='$phone', Sex = '$gender', Date_Of_Birth = '$dob' where Customer_ID = $cid";

        $qry = oci_parse($connection, $sql);
        oci_execute($qry);

        if ($qry) {

            
            unset($_SESSION['username']);
            unset($_SESSION['email']);


            include('connection.php');
     
			$sql = "SELECT * FROM customer where  Customer_ID=$cid";
			$qry84 = oci_parse($connection, $sql);
			oci_execute($qry84);
	
			while ($r = oci_fetch_array($qry84)) {
                $_SESSION['username'] = $r['USERNAME'];
                $_SESSION['email']=$r['EMAIL'];
	
			}
           

            header("Location:customer_profile.php?msg=$uname Account Details Updated Successfully");
            //echo "updated";
        } else {
            echo "Error Running the Query";
        }
    } else {
        header("Location:customer_edit.php?msg=Fill Up The All Forms&id=$cid");
        //echo "Please full all the forms";
    }
} else {
    echo "Error while Updating"; //error in 
}
