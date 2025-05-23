<?php
if (@$rating2 >= 1 && @$rating2 < 2) {
    echo "<i class='fa fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>";
} elseif (@$rating2 >= 2 && @$rating2 < 3) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>";
} elseif (@$rating2 >= 3 && @$rating2 < 4) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='far fa-star'></i>
			<i class='far fa-star'></i>";
} elseif (@$rating2 >= 4 && @$rating2 < 5) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='far fa-star'></i>";
} elseif (@$rating2 == 5) {
    echo "<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>
			<i class='fa fa-star'></i>";
} else {
    $rating2 = "No Rating Available";
    echo $rating2;
}
