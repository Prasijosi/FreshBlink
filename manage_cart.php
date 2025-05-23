<?php
session_start();



if (isset($_GET['d'])) {
    unset($_SESSION['cart']);
   
    $cid= $_SESSION['customer_id'];
    include('connection.php');
   $sql = "DELETE FROM CART WHERE customer_id=$cid";

  

   $qry = oci_parse($connection, $sql);
   oci_execute($qry);

   if($qry){
    echo " <script>
    alert('Cart Cleared');
    window.location.href='index.php';
    </script>";
   }
   else{
    echo " <script>
    alert('Error in qry while clearing all cart');
    window.location.href='index.php';
    </script>";
   }


}



if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    echo " <script>
    alert('Cart Cleared');
    window.location.href='index.php';
    </script>";
}






if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['addtoCart'])) {
        if (isset($_SESSION['cart'])) {

            $myitems = array_column($_SESSION['cart'], 'item_name'); //storing session cart product name in $myitems
            if (in_array($_POST['itemname'], $myitems)) {  //checking if that item name from session cart matched with passed item name from post method
                echo " <script>
                alert('Items Already Added');
                window.location.href='product_details.php?product_id=1001';
                </script>";
            } else {




                $count = count($_SESSION['cart']); //if there is already a cart then count it
                $_SESSION['cart'][$count] = array('item_name' => $_POST['itemname'], 'price' => $_POST['itemprice'], 'quantity' => $_POST['quantity'], 'image' => $_POST['itemimage'], 'stock' => $_POST['stock']); //in 1 index again it stores all items details
                print_r($_SESSION['cart']);

                echo " <script>
            alert('Item Added');
            window.location.href='cart.php';

          
            </script>";
            }
        } else {
            $_SESSION['cart'][0] = array('item_name' => $_POST['itemname'], 'price' => $_POST['itemprice'], 'quantity' => $_POST['quantity'], 'image' => $_POST['itemimage'], 'stock' => $_POST['stock']); // if no session of cart then set item deatils in 0 index, using aasociative aaray 

            echo " <script>
            alert('Item Added');
            window.location.href='cart.php';
            </script>";

            //print_r($_SESSION['cart']);
        }
    }


    if (isset($_POST['Mod_Quantity'])) {  //while refreshing page , quantity value was reseting so to fix

        foreach ($_SESSION['cart'] as $key => $value) {  //from here we get index value of array  , only key then whole data aaray shows if value added then index
            //print_r($key) ;
            if ($value['item_name'] == $_GET['value']) {

                $_SESSION['cart'][$key]['quantity'] = $_POST['Mod_Quantity']; //cart ko key index ko quantity laii post bata send gareko value ma chnage garne


                //print_r($_SESSION['cart']);
                // echo "
                // <script>
                // alert('Item Removed');
                // window.location.href='cart.php';
                // </script>
                // ";
            }
        }
    }
} else {
    echo "";
}

if (isset($_GET['value'])) {  //for removing item

    foreach ($_SESSION['cart'] as $key => $value) {  //from here we get index value of array  , only key then whole data aaray shows if value added then index
        //print_r($key) ;
        if ($value['item_name'] == $_GET['value']) {
              $productname=$value['item_name'];
              
            unset($_SESSION['cart'][$key]); //for removing that index cart item

            $_SESSION['cart'] = array_values($_SESSION['cart']); //for reaaranging araay index , if 0 index item is delete then remaining other index values are arraged like  1 to 0 , 2 to 1 since 0 index is deleted


                            $cid= $_SESSION['customer_id'];
                    include('connection.php');

                    $sql2 = "select * from product where PRODUCT_NAME='$productname'";
                    $qry2 = oci_parse($connection, $sql2);
                    oci_execute($qry2);


                    while ($row = oci_fetch_array($qry2)) {
                        $pid=$row['PRODUCT_ID'];
                        include('connection.php');
                        $sql3 = "select * from cart where product_id=$pid and customer_id=$cid";
                        $qry3 = oci_parse($connection, $sql3);
                        oci_execute($qry3);

                        while ($row = oci_fetch_array($qry3)) {

                           $cartid=$row['CART_ID'];
                            include('connection.php');
                            
                        $sql4 = "DELETE FROM CART WHERE CART_ID=$cartid";
                        $qry4 = oci_parse($connection, $sql4);
                        oci_execute($qry4);
        
                        if($qry4){
                            echo "
                            <script>
                            alert('Item Removed');
                            window.location.href='cart.php';
                            </script>
                            ";
                        }
                        else{
                            echo "
                            <script>
                            alert('Query error');
                            window.location.href='cart.php';
                            </script>
                            ";
                        }




                        }



                       

           

                    }

                


        }
    }
}
