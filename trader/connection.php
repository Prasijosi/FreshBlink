<?php
$connection = oci_connect('freshblink-db', 'Tester1!', '127.0.0.1/XE', 'AL32UTF8');

if (!$connection) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
} 
?>
