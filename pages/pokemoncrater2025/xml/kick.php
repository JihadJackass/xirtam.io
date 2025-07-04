<?php
$_validservers = array('v3.pokemon-vortex.com');
if (!isset($_SERVER['HTTP_USER_AGENT']) || (isset($_SERVER['HTTP_HOST']) && !in_array($_SERVER['HTTP_HOST'], $_validservers))) {
	exit;
header('location:http://v3.pokemon-vortex.com/login.php');
}
session_start();
?>