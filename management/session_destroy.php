<?php
session_start();
session_destroy();
header('Location:../trader/sign_in_trader.php');
exit();
