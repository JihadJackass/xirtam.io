<?php
if(!$_SESSION['myid']){ // Check the user is logged in
	include('/var/www/html/pv_disconnect_from_db.php');
	header("location:http:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
if($_SESSION['access'] == 9){
	include('/var/www/html/kick.php');
	include('/var/www/html/pv_connect_to_db.php');
	
	$time = time();
	$move = $_REQUEST['move'];
	if($move == 'up'){
		$statment = 'y = y - 1';
	}
	if($move == 'down'){
		$statment = 'y = y + 1';
	}
	if($move == 'left'){
		$statment = 'x = x - 1';
	}
	if($move == 'right'){
		$statment = 'x = x + 1';
	}
	if($move == 'leftup'){
		$statment = 'x = x - 1, y = y - 1';
	}
	if($move == 'leftdown'){
		$statment = 'x = x - 1, y = y + 1';
	}
	if($move == 'rightup'){
		$statment = 'x = x + 1, y = y - 1';
	}
	if($move == 'rightdown'){
		$statment = 'x = x + 1, y = y + 1';
	}
	
	unset($_SESSION['mapx']);
	unset($_SESSION['mapy']);
	mysql_query("UPDATE mapusers SET $statment WHERE id = '{$_SESSION['myid']}'");
}
else {
	include('/var/www/html/pv_disconnect_from_db.php');
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
?>
