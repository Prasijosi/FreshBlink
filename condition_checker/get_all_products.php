<?php
include 'connection.php';
$popular_products = [];

$query = "SELECT * FROM (
    SELECT * FROM product 
    WHERE product_verification = '1' 
    ORDER BY PRODUCT_ID DESC
)";

$result = oci_parse($connection, $query);
oci_execute($result);

while ($row = oci_fetch_assoc($result)) {
    $popular_products[] = [
        'img' => $row['PRODUCT_IMAGE'],
        'name' => $row['PRODUCT_NAME'],
        'category' => $row['PRODUCT_TYPE'],
        'link' => 'product_details.php?product_id=' . $row['PRODUCT_ID'],
    ];
}
