<?php
include('pv_connect_to_db.php');

$rand = rand(34,999999999999999);
$encrypt = md5($rand);
echo $encrypt;
?>
