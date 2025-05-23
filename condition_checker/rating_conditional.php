<?php

$sql = "SELECT avg(Rating) from review where '$product_id' = Product_Id";

$result = oci_parse($connection, $sql);
oci_execute($result);

while ($row = oci_fetch_assoc($result)) {
    $rating = $row['AVG(RATING)'];
}

if ($rating >= 1 && $rating < 2) {
    echo "<i class='fa fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>";
} elseif ($rating >= 2 && $rating < 3) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>";
} elseif ($rating >= 3 && $rating < 4) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>";
} elseif ($rating >= 4 && $rating < 5) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='far fa-star'></i>";
} elseif ($rating == 5) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>";
} else {
    $rating = "No Rating Available";
    echo $rating;
}
