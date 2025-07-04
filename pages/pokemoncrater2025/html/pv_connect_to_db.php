<?php
$db_server = 'localhost';
$db_database = 'Pokemon-Shqipe';
$db_username = 'arben';
$db_password = 'cenalia122';
$mysql_connection = mysql_connect($db_server, $db_username, $db_password)or die('Can\'t Connect');
mysql_select_db($db_database)or die('Can\'t Connect');
session_start();

if(isset($_SESSION['myid'])){
	//----------------- Check if a user is banned and kick them from the game -----------------------//
	$ban = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$banned = mysql_fetch_array($ban);
	if($banned['banned'] == '1'){
		$_SESSION['banned'] = 1;
		mysql_query("DELETE FROM online WHERE id = '{$_SESSION['myid']}'");
		mysql_query("DELETE FROM mapusers WHERE id = '{$_SESSION['myid']}'");
		header('location:/login.php?action=Banned');
		exit();
	}
	//----------------- Update the users online time ------------------------//
	$time_update = $_SERVER['REQUEST_TIME'] - 400;
	if(!isset($_SESSION['updatetime']) || $_SESSION['updatetime'] < $time_update){
		$_SESSION['updatetime'] = $_SERVER['REQUEST_TIME'];
		$time = time();
		$update_time = mysql_query("UPDATE online SET time = '$time' WHERE id = '{$_SESSION['myid']}'");
		if(!$update_time){
			header('location:/login.php');
			exit();
		}
	}
}
?>