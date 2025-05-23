<?php
// Initialize variables and include connection
include 'connection.php';
$products = [];
$params = [];

// Get all input parameters safely
$search_Cat = $_POST['search_Cat'] ?? '';
$search_Txt = $_POST['search_Txt'] ?? '';
$product_Category = $_POST['product_Category'] ?? '';
$traders = $_POST['traders'] ?? '';

// Main search logic
if (isset($_POST['submit_search'])) {
    // Use the raw input safely
    $search_Txt = isset($_POST['search_Txt']) ? trim($_POST['search_Txt']) : '';

    $query = "SELECT * FROM product WHERE product_verification = '1'";
    $params = [];

    // If search text is empty, null, or 'all', get all verified products without filtering
    if ($search_Txt !== '' && strtolower($search_Txt) !== 'all') {
        $query .= " AND UPPER(Product_Name) LIKE UPPER(:search_text)";
        $params[':search_text'] = '%' . $search_Txt . '%';
    }

    $stmt = oci_parse($connection, $query);

    // Bind parameters only if exist
    foreach ($params as $key => &$value) {
        oci_bind_by_name($stmt, $key, $value);
    }

    oci_execute($stmt);

    while ($row = oci_fetch_assoc($stmt)) {
        $products[] = [
            'id' => $row['PRODUCT_ID'],
            'type' => $row['PRODUCT_TYPE'],
            'name' => $row['PRODUCT_NAME'],
            'price' => $row['PRODUCT_PRICE'],
            'details' => $row['PRODUCT_DETAILS'],
            'stock' => $row['STOCK'],
            'image' => $row['PRODUCT_IMAGE'],
            'shop_id' => $row['SHOP_ID']
        ];
    }
    oci_free_statement($stmt);

} elseif (isset($_POST['submit1']) && !empty($product_Category)) {
    $query = "SELECT * FROM product WHERE Product_Type LIKE :category AND product_verification = '1'";
    $stmt = oci_parse($connection, $query);
    $category_param = '%' . $product_Category . '%';
    oci_bind_by_name($stmt, ':category', $category_param);
    oci_execute($stmt);

    while ($row = oci_fetch_assoc($stmt)) {
        $products[] = [
            'id' => $row['PRODUCT_ID'],
            'type' => $row['PRODUCT_TYPE'],
            'name' => $row['PRODUCT_NAME'],
            'price' => $row['PRODUCT_PRICE'],
            'details' => $row['PRODUCT_DETAILS'],
            'stock' => $row['STOCK'],
            'image' => $row['PRODUCT_IMAGE'],
            'shop_id' => $row['SHOP_ID']
        ];
    }
    oci_free_statement($stmt);

}
// Category filter
elseif (isset($_POST['submit1']) && !empty($product_Category)) {
    $query = "SELECT * FROM product WHERE Product_Type LIKE :category AND product_verification = '1'";
    $stmt = oci_parse($connection, $query);
    $category_param = '%' . $product_Category . '%';
    oci_bind_by_name($stmt, ':category', $category_param);
    oci_execute($stmt);
    
    while ($row = oci_fetch_assoc($stmt)) {
        $products[] = [
            'id' => $row['PRODUCT_ID'],
            'type' => $row['PRODUCT_TYPE'],
            'name' => $row['PRODUCT_NAME'],
            'price' => $row['PRODUCT_PRICE'],
            'details' => $row['PRODUCT_DETAILS'],
            'stock' => $row['STOCK'],
            'image' => $row['PRODUCT_IMAGE'],
            'shop_id' => $row['SHOP_ID']
        ];
    }
    oci_free_statement($stmt);
}
// Traders filter
elseif (isset($_POST['submit2']) && !empty($traders)) {
    $query = "SELECT p.* 
              FROM trader t
              JOIN shop s ON t.Trader_Id = s.Trader_id
              JOIN product p ON s.Shop_Id = p.Shop_Id
              WHERE t.Name LIKE :trader_name 
              AND t.trader_verification = '1' 
              AND p.product_verification = '1'";
    
    $stmt = oci_parse($connection, $query);
    $trader_param = '%' . $traders . '%';
    oci_bind_by_name($stmt, ':trader_name', $trader_param);
    oci_execute($stmt);
    
    while ($row = oci_fetch_assoc($stmt)) {
        $products[] = [
            'id' => $row['PRODUCT_ID'],
            'type' => $row['PRODUCT_TYPE'],
            'name' => $row['PRODUCT_NAME'],
            'price' => $row['PRODUCT_PRICE'],
            'details' => $row['PRODUCT_DETAILS'],
            'stock' => $row['STOCK'],
            'image' => $row['PRODUCT_IMAGE'],
            'shop_id' => $row['SHOP_ID']
        ];
    }
    oci_free_statement($stmt);
}
// Default case
else {
    $products = [];
}

$count = count($products);