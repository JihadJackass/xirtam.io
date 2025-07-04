<?php
$db_server = '10.24.91.136';
$db_database = 'admin_vortex';
$db_username = 'root';
$db_password = 'voodoo';
$mysql_connection = mysql_connect($db_server, $db_username, $db_password)or die(mysql_error());
mysql_select_db($db_database)or die(mysql_error());
session_start();
if(isset($_SESSION['myid'])){
$time = time();
$timeyyy = $time - 400;
if(!isset($_SESSION['updatetime']) || $_SESSION['updatetime'] < $timeyyy){
$_SESSION['updatetime'] = $time;
mysql_query("UPDATE online SET time = '$time' WHERE id = '{$_SESSION['myid']}'");
}
}
?>
