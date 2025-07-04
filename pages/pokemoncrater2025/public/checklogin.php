<?php
include('/var/www/html/kick.php');
include('/var/www/html/pv_connect_to_db.php');
$ytime = time();
$time1 = '1800';
$timeout = $ytime - $time1;
$myusername = mysql_real_escape_string($_POST['myusername']);
$mypassword = mysql_real_escape_string($_POST['mypassword']);
$ips = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];
$myusername = addslashes($myusername);
$get_attempts = mysql_query("SELECT attempts, ip FROM login_trys WHERE username = '$myusername' AND ip = '$ips'");
mysql_query("DELETE FROM login_trys WHERE time < '$timeout'");
$get_att = mysql_fetch_array($get_attempts);
if($get_att['attempts'] < 6){
	$mypassword = stripslashes($mypassword);
	$nw = md5($mypassword);
	
	$result = mysql_query("SELECT * FROM members WHERE username = '$myusername' AND password = '$nw' LIMIT 1")or die(mysql_error());
	$count = mysql_num_rows($result);
	
	
	if($count == 1){
		$re = mysql_fetch_object($result);
		$get_settings = mysql_query("SELECT * FROM members_options WHERE id = '{$re->id}' LIMIT 1")or die(mysql_error());
		$settings = mysql_fetch_object($get_settings);
		mysql_query("DELETE FROM online WHERE time < '$timeout'");
		mysql_query("INSERT INTO online SET id = '{$re->id}', username = '{$re->username}', clan_tag = '{$re->clan_tag}', activity = 'Dashboard', time = '$ytime', useragent = '$useragent', server = 'zeta' ON DUPLICATE KEY UPDATE time = '$ytime', server = 'zeta'");
		$ips = $_SERVER['REMOTE_ADDR'];
		$t = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$re->id}' GROUP BY pid");
		
		while($h = mysql_fetch_array($t)){
			$_SESSION['your_pokemon'][] = $h['pid'];
		}
		$_SESSION['myuser'] = $re->username;
		$_SESSION['myid'] = $re->id;
		$_SESSION['myeb'] = $re->eb;
		$_SESSION['access'] = 9;
		$_SESSION['sidequest'] = $re->sidequest;
		$_SESSION['message_preferences'][0] = $settings->messnotifyonoff;
		$_SESSION['layout'] = $settings->layout;
		$_SESSION['map_preferences'][0] = $re->badges;
		$_SESSION['map_preferences'][1] = $settings->memonmap;
		$_SESSION['map_preferences'][2] = $settings->trainer;
		$_SESSION['my_team'][0] = $re->s1;
		$_SESSION['my_team'][1] = $re->s2;
		$_SESSION['my_team'][2] = $re->s3;
		$_SESSION['my_team'][3] = $re->s4;
		$_SESSION['my_team'][4] = $re->s5;
		$_SESSION['my_team'][5] = $re->s6;
		$_SESSION['clan'] = $re->clan_name;
		$_SESSION['night'] = 0;
		$_SESSION['banned'] = $re->banned;
		$cl = mysql_query("SELECT id FROM clans WHERE owner = '{$_SESSION['myuser']}'");
		$cla = mysql_num_rows($cl);
		if($cla >= 1){
			$_SESSION['clanowner'] = 1;
		}
		
		
		mysql_query("UPDATE members SET llogin = '$ytime', ip = '$ips' WHERE id = '{$re->id}'");
		header("location:dashboard.php");
		exit;
	}
	else {
		$retr = mysql_num_rows(mysql_query("SELECT username FROM login_trys WHERE username = '$myusername' AND ip = '$ips'"));
		if($retr == 0){
			mysql_query("INSERT INTO login_trys (username, ip, time) VALUES('$myusername', '$ips', '$ytime')");
			header("location:http://www.pokemon-shqipe.co.uk/login.php?action=Error&type=User_Pass");
			exit;
		}
		else {
			mysql_query("UPDATE login_trys SET attempts = attempts + 1, time = '$ytime' WHERE username = '$myusername' AND ip = '$ips'");
			header("location:http://www.pokemon-shqipe.co.uk/login.php?action=Error&type=User_Pass");
			exit;
		}
	}
}
else {
	header("location:http://www.pokemon-shqipe.co.uk/login.php?action=Attempts");
	exit;
}
?>