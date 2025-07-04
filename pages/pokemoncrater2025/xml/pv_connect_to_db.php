<?php
$db_server = 'localhost';
$db_database = 'Pokemon-Shqipe';
$db_username = 'arben';
$db_password = 'cenalia122';
$mysql_connection = mysql_connect($db_server, $db_username, $db_password)or die('Can\'t Connect');
mysql_select_db($db_database)or die('Can\'t Connect');
session_start();
if(isset($_SESSION['myid'])){
	$time_update = $_SERVER['REQUEST_TIME'] - 400;
	if(!isset($_SESSION['updatetime']) || $_SESSION['updatetime'] < $time_update){
		$_SESSION['updatetime'] = $_SERVER['REQUEST_TIME'];
		mysql_query("UPDATE online SET time = '{$_SERVER['REQUEST_TIME']}' WHERE id = '{$_SESSION['myid']}'");
	}
}
?>