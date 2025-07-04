<?php
include('kick.php');

if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	header("location:login.php?goawaxP=1");
}
include('pv_connect_to_db.php');

if($_REQUEST['battle']){
	unset($_SESSION['opponent_profile'],$_SESSION['s1'],$_SESSION['s2'],$_SESSION['s3'],$_SESSION['s4'],$_SESSION['s5'],$_SESSION['s6'],$_SESSION['ops1'],$_SESSION['ops2'],$_SESSION['ops3'],$_SESSION['ops4'],$_SESSION['ops5'],$_SESSION['ops6'],$_SESSION['position'],$_SESSION['your_profile'],$_SESSION['y_p']); 
}
if(!$_REQUEST['ajax']){
	$time = time(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="js/ie6-.js"></script>
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Shqipe v3 - Live Battle</title>
</head>

<body>
<?php include_once("analytics.php"); ?>
<div id="alert"></div><div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">

<?php
include('/var/www/ads/headerad.php');
?>
</div>
<div id="title">
<h1><a href="index.php"><em>pokemon-shqipe.co.uk</em></a></h1>
</div>
<ul id="nav">
<li><a href="map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li>
<li><a href="battle_select.php" id="battleTab" class="deselected"><em>Battle</em></a></li>
<li><a href="your_account.php" id="yourAccountTab" class="deselected"><em>Your Account</em></a></li>
<li><a href="community.php" id="communityTab" class="deselected"><em>Communtiy</em></a></li>
</ul>
<ul id="logout">
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
<?php include('includes/usernav.php'); ?>
<div id="contentContainer">
<div id="sidebar">
<div id="sidebarContainer">
<div id="sidebarLoading"></div>
<div id="sidebarContent"></div>
</div>
<ul id="sidebarTabs">
<li><a href="/pokedex.php" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
<li><a href="/members.php" id="membersTab" class="deselected"><em>Members</em></a></li>
<li><a href="/options.php" id="optionsTab" class="deselected"><em>Options</em></a></li>
</ul>
</div> 
<div id="content">
<div id="notification" style="visibility: hidden;"></div>
<div id="loading"></div>
<div id="scroll">
<div id="suggestResults"></div>
<div id="showDetails"></div>
<div id="errorBox"></div>
<div style="float: right;">
</p>
<?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<div id="ajax">
<?php
}
if(isset($_POST['item']) || isset($_POST['attack']) || isset($_POST['active_pokemon']) || $_SESSION['pos'] == '123' || isset($_POST['choose'])){
	function checkNum($number){
		return ($number%2) ? TRUE : FALSE;
	}

	if($_POST['choose']){
		mysql_query("UPDATE live_battle SET pokemon_attack_{$_SESSION['live'][0]} = 0, pokemon_attack_{$_SESSION['live'][0]}_2 = 0, choose_{$_SESSION['live'][0]} = '1' WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'");
		$_SESSION['position'] = 1;
		$_SESSION['pos'] = 1; 
	}
	else{
		$_SESSION['pos'] = '123';
		$_SESSION['position'] = 78;
	}
	if($_SESSION['position'] != 1){

		if($_POST['active_pokemon']){
			$_SESSION['numero'] = 1;
			mysql_query("UPDATE live_battle SET choose_{$_SESSION['live'][0]} = '0', user_time_1 = 0, user_time_1_2 = 0, user_time_2_2 = 0, user_time_2 = 0, pokemon_choice_{$_SESSION['live'][0]} = '{$_POST['active_pokemon']}', user_position_{$_SESSION['live'][0]} = '4', user_position_{$_SESSION['live'][0]}_2 = '0' WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'");
		}
		$_SESSION['numero1'] = $_SESSION['numero'];
		if($_POST['attack']){
			$_SESSION['your_attack'] = $_POST['attack'];

			if(checkNum($_SESSION['numero']) === TRUE){
				mysql_query("UPDATE live_battle SET user_time_{$_SESSION['live'][0]} = user_time_{$_SESSION['live'][0]} + 1, pokemon_attack_{$_SESSION['live'][0]} = '{$_POST['attack']}', user_position_{$_SESSION['live'][0]}_2 = '5' WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'");
			}
			else{
				mysql_query("UPDATE live_battle SET user_time_{$_SESSION['live'][0]}_2 = user_time_{$_SESSION['live'][0]}_2 + 1, pokemon_attack_{$_SESSION['live'][0]}_2 = '{$_POST['attack']}', user_position_{$_SESSION['live'][0]}_2 = '5' WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'");
			}
			$_SESSION['numero'] += 1;
		}

		$li_ve = mysql_query("SELECT * FROM live_battle WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'");

		$liveu = $_SESSION['live'][0];
		$liveo = $_SESSION['live'][1];
		$yt = mysql_fetch_array($li_ve);
		if($yt['user_position_'.$_SESSION['live'][1]] == '0' && $yt['user_position_'.$_SESSION['live'][0]] != '4' && $yt['user_position_'.$_SESSION['live'][1].'_2'] == '0'&& $yt['choose_'.$_SESSION['live'][1]] == '0' && $yt['choose_'.$_SESSION['live'][0]] == '0'){
			$_SESSION['position'] = 2;
			$_SESSION['pos'] = 1;
		}
		if($yt['user_position_1'] == '4' && $yt['user_position_2'] == '4' && $yt['user_position_'.$liveu.'_2'] != '5' && $yt['choose_'.$_SESSION['live'][1]] == '0' && $yt['choose_'.$_SESSION['live'][0]] == '0'){

			$user_pokemon_choice = $yt['pokemon_choice_'.$liveo];
			$u_pokemon_choice = $yt['pokemon_choice_'.$liveu];
			if($user_pokemon_choice != 0 && $u_pokemon_choice != 0){
				$atp = $u_pokemon_choice;
				if($atp == $_SESSION['s1'][1]){
					$_SESSION['y_p'][0] = 1;
				}
				if($atp == $_SESSION['s2'][1]){
					$_SESSION['y_p'][0] = 2;
				}
				if($atp == $_SESSION['s3'][1]){
					$_SESSION['y_p'][0] = 3;
				}
				if($atp == $_SESSION['s4'][1]){
					$_SESSION['y_p'][0] = 4;
				}
				if($atp == $_SESSION['s5'][1]){
					$_SESSION['y_p'][0] = 5;
				}
				if($atp == $_SESSION['s6'][1]){
					$_SESSION['y_p'][0] = 6;
				}
				$spot = $user_pokemon_choice;
				if($spot == $_SESSION['ops1'][1]){
					$_SESSION['y_p'][1] = 1;
				}
				if($spot == $_SESSION['ops2'][1]){
					$_SESSION['y_p'][1] = 2;
				}
				if($spot == $_SESSION['ops3'][1]){
					$_SESSION['y_p'][1] = 3;
				}
				if($spot == $_SESSION['ops4'][1]){
					$_SESSION['y_p'][1] = 4;
				}
				if($spot == $_SESSION['ops5'][1]){
					$_SESSION['y_p'][1] = 5;
				}
				if($spot == $_SESSION['ops6'][1]){
					$_SESSION['y_p'][1] = 6;
				}
			}
			$_SESSION['position'] = 2;
			$_SESSION['pos'] = 1;
		}
		elseif($yt['user_position_1_2'] == '5' && $yt['user_position_2_2'] == '5' && $yt['user_time_1'] == $yt['user_time_2'] && $yt['user_time_1'] != 0 || $yt['user_position_1_2'] == '5' && $yt['user_position_2_2'] == '5' && $yt['user_time_1_2'] == $yt['user_time_2_2'] && $yt['user_time_1'] != 0 && $yt['choose_'.$_SESSION['live'][1]] == '0' && $yt['choose_'.$_SESSION['live'][0]] == '0'){
		if(checkNum($_SESSION['numero1']) === TRUE){
			$attack_live1 = $_SESSION['your_attack'];
			$attack_live2 = $yt['pokemon_attack_'.$liveo];
			$_SESSION['position'] = 2;
			$_SESSION['pos'] = 1;
		}
		else{
			$attack_live1 = $_SESSION['your_attack'];
			$attack_live2 = $yt['pokemon_attack_'.$liveo.'_2'];
			$_SESSION['position'] = 2;
			$_SESSION['pos'] = 1;
		}
	}
	else{
		$rw = $yt['user_time_'.$liveu] + 1;
		$wr = $yt['user_time_'.$liveu.'_2'] + 1;
		if($rw == $yt['user_time_'.$liveo] && $yt['user_time_1'] != 0 && $yt['choose_'.$_SESSION['live'][1]] == '0' && $yt['choose_'.$_SESSION['live'][0]] == '0' || $wr == $yt['user_time_'.$liveo.'_2'] && $yt['choose_'.$_SESSION['live'][1]] == '0' && $yt['choose_'.$_SESSION['live'][0]] == '0'){
			if(checkNum($_SESSION['numero1']) === TRUE){
				$attack_live1 = $_SESSION['your_attack'];
				$attack_live2 = $yt['pokemon_attack_'.$liveo];
				$_SESSION['position'] = 2;
				$_SESSION['pos'] = 1;
			}
			else{
				$attack_live1 = $_SESSION['your_attack'];
				$attack_live2 = $yt['pokemon_attack_'.$liveo.'_2'];
				$_SESSION['position'] = 2;
				$_SESSION['pos'] = 1;
			}
		}
		elseif($yt['user_position_'.$liveo] == 0 && $yt['user_position_'.$liveo.'_2'] == 0 && $_SESSION['numero'] > 1 && $yt['choose_'.$_SESSION['live'][1]] == '0' && $yt['choose_'.$_SESSION['live'][0]] == '0'){
			if(checkNum($_SESSION['numero1']) === TRUE){
				$attack_live1 = $_SESSION['your_attack'];
				$attack_live2 = $yt['pokemon_attack_'.$liveo];
				$_SESSION['position'] = 2;
				$_SESSION['pos'] = 1;
			}
			else{
				$attack_live1 = $_SESSION['your_attack'];
				$attack_live2 = $yt['pokemon_attack_'.$liveo.'_2'];
				$_SESSION['position'] = 2;
				$_SESSION['pos'] = 1;
			}
		}
		else{
			if($yt['choose_'.$_SESSION['live'][1]] == '1' && $yt['choose_'.$_SESSION['live'][0]] == '1'){
				$_SESSION['position'] = 1;
				$_SESSION['pos'] = 1;
			}
			else{
				?>
				<p class="large" style="margin-top: 75px; text-align: center;"><strong>Waiting for the other user to respond...<a href="/live_battle.php">Refresh</a></strong></p><p style="text-align: center;">You have been waiting <span id="waitTime">0 seconds</span>.</p>
				<?php
			}
		}
	}
}
}

if($_SESSION['position'] == 2 && !isset($_POST['choose']) && $_SESSION['pos'] != 123){
	mysql_query("UPDATE live_battle SET choose_{$_SESSION['live'][0]} = '0' WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'"); 
	function convert($atype, $ty, $ty2){
		$damage = 1;
		switch($atype){
		case Flying:
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage * 2;
		}
		if($ty == "Fighting" || $ty2 == "Fighting"){
			$damage = $damage * 2;
		}
		if($ty == "Bug" || $ty2 == "Bug"){
			$damage = $damage * 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		if($ty == "Electric" || $ty2 == "Electric"){
			$damage = $damage / 2;
		}
		break;
		case Electric:
		if($ty == "Electric" || $ty2 == "Electric"){
			$damage = $damage / 2;
		}
		if($ty == "Water" || $ty2 == "Water"){
		$damage = $damage * 2;
		}
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage / 2;
		}
		if($ty == "Ground" || $ty2 == "Ground"){
			$damage = $damage * 0;
		}
		if($ty == "Flying" || $ty2 == "Flying"){
			$damage = $damage * 2;
		}
		if($ty == "Dragon" || $ty2 == "Dragon"){
			$damage = $damage / 2;
		}
		break;
		case Fighting:
		if($ty == "Normal" || $ty2 == "Normal"){
			$damage = $damage * 2;
		}
		if($ty == "Ice" || $ty2 == "Ice"){
			$damage = $damage * 2;
		}
		if($ty == "Poison" || $ty2 == "Poison"){
			$damage = $damage / 2;
		}
		if($ty == "Flying" || $ty2 == "Flying"){
			$damage = $damage / 2;
		}
		if($ty == "Psychic" || $ty2 == "Psychic"){
			$damage = $damage / 2;
		}
		if($ty == "Bug" || $ty2 == "Bug"){
			$damage = $damage / 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage * 2;
		}
		if($ty == "Ghost" || $ty2 == "Ghost"){
			$damage = $damage * 0;
		}
		if($ty == "Dark" || $ty2 == "Dark"){
			$damage = $damage * 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage * 2;
		}
		break;
		case Fire:
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage / 2;
		}
		if($ty == "Water" || $ty2 == "Water"){
			$damage = $damage / 2;
		}
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage * 2;
		}
		if($ty == "Ice" || $ty2 == "Ice"){
			$damage = $damage * 2;
		}
		if($ty == "Bug" || $ty2 == "Bug"){
			$damage = $damage * 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage * 2;
		}
		if($ty == "Dragon" || $ty2 == "Dragon"){
			$damage = $damage / 2;
		}
		break;
		case Grass:
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage / 2;
		}
		if($ty == "Water" || $ty2 == "Water"){
			$damage = $damage * 2;
		}
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage / 2;
		}
		if($ty == "Poison" || $ty2 == "Poison"){
			$damage = $damage / 2;
		}
		if($ty == "Ground" || $ty2 == "Ground"){
			$damage = $damage * 2;
		}
		if($ty == "Bug" || $ty2 == "Bug"){
			$damage = $damage / 2;
		}
		if($ty == "Flying" || $ty2 == "Flying"){
			$damage = $damage / 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage * 2;
		}
		if($ty == "Dragon" || $ty2 == "Dragon"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		break;
		case Steel:
		if($ty == "Electric" || $ty2 == "Electric"){
			$damage = $damage / 2;
		}
		if($ty == "Water" || $ty2 == "Water"){
			$damage = $damage / 2;
		}
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage / 2;
		}
		if($ty == "Ice" || $ty2 == "Ice"){
			$damage = $damage * 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage * 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		break;
		case Psychic:
		if($ty == "Fighting" || $ty2 == "Fighting"){
			$damage = $damage * 2;
		}
		if($ty == "Poison" || $ty2 == "Poison"){
			$damage = $damage * 2;
		}
		if($ty == "Psychic" || $ty2 == "Psychic"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		if($ty == "Dark" || $ty2 == "Dark"){
			$damage = $damage * 0;
		}
		break;
		case Ghost:
		if($ty == "Normal" || $ty2 == "Normal"){
			$damage = $damage * 0;
		}
		if($ty == "Psychic" || $ty2 == "Psychic"){
			$damage = $damage * 2;
		}
		if($ty == "Ghost" || $ty2 == "Ghost"){
			$damage = $damage * 2;
		}
		if($ty == "Dark" || $ty2 == "Dark"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		break;
		case Rock:
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage * 2;
		}
		if($ty == "Ice" || $ty2 == "Ice"){
			$damage = $damage * 2;
		}
		if($ty == "Fighting" || $ty2 == "Fighting"){
			$damage = $damage / 2;
		}
		if($ty == "Ground" || $ty2 == "Ground"){
		$damage = $damage / 2;
		}
		if($ty == "Flying" || $ty2 == "Flying"){
			$damage = $damage * 2;
		}
		if($ty == "Bug" || $ty2 == "Bug"){
			$damage = $damage * 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		break;
		case Ground:
		if($ty == "Electric" || $ty2 == "Electric"){
			$damage = $damage * 2;
		}
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage * 2;
		}
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage / 2;
		}
		if($ty == "Poison" || $ty2 == "Poison"){
			$damage = $damage * 2;
		}
		if($ty == "Flying" || $ty2 == "Flying"){
			$damage = $damage * 0;
		}
		if($ty == "Bug" || $ty2 == "Bug"){
			$damage = $damage / 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage * 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage * 2;
		}
		break;
		case Poison:
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage * 2;
		}
		if($ty == "Poison" || $ty2 == "Poison"){
			$damage = $damage / 2;
		}
		if($ty == "Ground" || $ty2 == "Ground"){
			$damage = $damage / 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage / 2;
		}
		if($ty == "Ghost" || $ty2 == "Ghost"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage * 0;
		}
		break;
		case Dark:
		if($ty == "Fighting" || $ty2 == "Fighting"){
			$damage = $damage / 2;
		}
		if($ty == "Psychic" || $ty2 == "Psychic"){
			$damage = $damage * 2;
		}
		if($ty == "Ghost" || $ty2 == "Ghost"){
			$damage = $damage * 2;
		}
		if($ty == "Dark" || $ty2 == "Dark"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		break;
		case Normal:
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage / 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		if($ty == "Ghost" || $ty2 == "Ghost"){
			$damage = $damage * 0;
		}
		break;
		case Water:
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage * 2;
		}
		if($ty == "Water" || $ty2 == "Water"){
			$damage = $damage / 2;
		}
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage / 2;
		}
		if($ty == "Ground" || $ty2 == "Ground"){
			$damage = $damage * 2;
		}
		if($ty == "Rock" || $ty2 == "Rock"){
			$damage = $damage * 2;
		}
		if($ty == "Dragon" || $ty2 == "Dragon"){
			$damage = $damage / 2;
		}
		break;
		case Ice:
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage / 2;
		}
		if($ty == "Water" || $ty2 == "Water"){
			$damage = $damage / 2;
		}
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage * 2;
		}
		if($ty == "Ice" || $ty2 == "Ice"){
			$damage = $damage / 2;
		}
		if($ty == "Ground" || $ty2 == "Ground"){
			$damage = $damage * 2;
		}
		if($ty == "Flying" || $ty2 == "Flying"){
			$damage = $damage * 2;
		}
		if($ty == "Dragon" || $ty2 == "Dragon"){
			$damage = $damage * 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		break;
		case Bug:
		if($ty == "Fire" || $ty2 == "Fire"){
			$damage = $damage / 2;
		}
		if($ty == "Grass" || $ty2 == "Grass"){
			$damage = $damage * 2;
		}
		if($ty == "Fighting" || $ty2 == "Fighting"){
			$damage = $damage / 2;
		}
		if($ty == "Poison" || $ty2 == "Poison"){
			$damage = $damage / 2;
		}
		if($ty == "Flying" || $ty2 == "Flying"){
			$damage = $damage / 2;
		}
		if($ty == "Psychic" || $ty2 == "Psychic"){
			$damage = $damage * 2;
		}
		if($ty == "Ghost" || $ty2 == "Ghost"){
			$damage = $damage / 2;
		}
		if($ty == "Dark" || $ty2 == "Dark"){
			$damage = $damage * 2;
		}
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		break;
		case Dragon:
		if($ty == "Steel" || $ty2 == "Steel"){
			$damage = $damage / 2;
		}
		if($ty == "Dragon" || $ty2 == "Dragon"){
			$damage = $damage * 2;
		}
		break;
	}
	return $damage;
}

if($_POST['item']){
	$u = $_SESSION['y_p'][0];
	$n = $_SESSION['y_p'][1];
	$quick = array("Potion", "Super Potion", "Hyper Potion", "Full Heal", "Awakening", "Paralyz Heal", "Antidote", "Burn Heal", "Ice Heal");
	$quicky = array("Potion", "Super_Potion", "Hyper_Potion", "Full_Heal", "Awakening", "Paralyz_Heal", "Antidote", "Burn_Heal", "Ice_Heal");
	for($ra=0;$ra<=8;$ra++){
		if($quick[$ra] == $_POST['item']){
			if($_SESSION['items'][$ra] > 0){
				$_SESSION['items'][$ra] -= 1;
				$rq = $quicky[$ra];
				mysql_query("UDPATE items SET $rq = $rq - 1 WHERE uid = '{$_SESSION['myid']}' AND $d > 0");
			}
		}
	}
	$tu = rand(1,4);
	$tu = $tu + 5;
	$oattack = $_SESSION['ops'.$n][$tu];
	if($oattack == $_SESSION['attack_short'][3]){
		$hittingd = $_SESSION['attack_short'][3];
		$hittinge = $_SESSION['attack_short'][4];
		$hittingf = $_SESSION['attack_short'][5];
	}
	if($oattack != $_SESSION['attack_short'][3] || !$_SESSION['attack_short'][3]){
		$r_a = mysql_fetch_array(mysql_query("SELECT * FROM attacks WHERE attack = '$oattack'"));
		$hittingd = $r_a['attack'];
		$hittinge = $r_a['type'];
		$hittingf = $r_a['power'];
		$_SESSION['attack_short'][3] = $hittingd;
		$_SESSION['attack_short'][4] = $hittinge;
		$_SESSION['attack_short'][5] = $hittingf;
	}
	if($hittinge == $_SESSION['ops'.$n][2] || $hittinge == $_SESSION['ops'.$n][3] ){
		$opmultn = 1.5;
	}
	else {
		$opmultn = 1;
	}
	$h = $_SESSION['ops'.$n][4] / 30;
	$hh = $_SESSION['attack_short'][5] / 2;
	$y = $hittinge;
	$g = $_SESSION['s'.$u][2];
	$f = $_SESSION['s'.$u][3];
	$damages2 = convert("$y", "$g", "$f");
	if(strstr($_SESSION['ops'.$n][0],'Dark ') || strstr($_SESSION['s'.$u][0],'Metallic ')){
		$d_a = 1;
		if(strstr($_SESSION['s'.$u][0],'Metallic ')){
			$d_a = $d_a - 0.25;
		}
		if(strstr($_SESSION['ops'.$n][0],'Dark ')){
			$d_a = $d_a + 0.25;
		}
		$h2 = $h * $hh;
		$h3 = $h2 * $d_a;
		$h4 = $h3 * $damages2;
		$hhh = round($h4 * $opmultn);
	}
	else {
		$h2 = $h * $hh;
		$h3 = $h2 * $damages2;
		$hhh = round($h3 * $opmultn);
	}
	if(strstr($_SESSION['ops'.$n][0],'Mystic')){
		$ran = rand(1,4);
		if($ran == 2){
			$you_scared = 2;
			$www = 0;
		}
	}
	if(strstr($_SESSION['s'.$u][0],'Mystic')){
		$rand = rand(1,4);
		if($rand == 2){
			$op_scared = 2;
			$hhh = 0;
		}
	}
	$_SESSION['s'.$u][10] = $_SESSION['s'.$u][10] - $hhh;
	$i_u = $_POST['item'];
	switch($i_u){
		case "Potion":
		$item_statement = "regained 20 HP."; 
		$_SESSION['s'.$u][10] += 20;
		break;
		case "Super Potion":
		$item_statement = "regained 100 HP."; 
		$_SESSION['s'.$u][10] += 100;
		break;
		case "Hyper Potion":
		$item_statement = "regained 250 HP."; 
		$_SESSION['s'.$u][10] += 250;
		break;
		case "Full Heal":
		$item_statement = "been healed of it's status affliction.";
		break;
		case "Awakening":
		$item_statement = "woke up."; 
		break;
		case "Paralyze Heal":
		$item_statement = "been healed of it's paralysis."; 
		break;
		case "Antidote":
		$item_statement = "been healed of it's poison.";
		break;
		case "Burn Heal":
		$item_statement = "been healed of it's burn."; 
		break;
		case "Ice Heal":
		$item_statement = "been defrosted."; 
		break;
	}
	if($_SESSION['s'.$u][10] > $_SESSION['s'.$u][11]){
		$_SESSION['s'.$u][10] = $_SESSION['s'.$u][11];
	}
}
if(is_numeric($attack_live1) && is_numeric($attack_live2)){
	$rat = $attack_live1;
	$u = $_SESSION['y_p'][0];
	$n = $_SESSION['y_p'][1];
	$rat = $rat + 5;
	$attack = $_SESSION['s'.$u][$rat];
	$_SESSION['s'.$u][13] = 1;
	if($attack == $_SESSION['attack_short'][0]){
		$hittinga = $_SESSION['attack_short'][0];
		$hittingb = $_SESSION['attack_short'][1];
		$hittingc = $_SESSION['attack_short'][2];
	}
	$rat = $attack_live2;
	$rat = $rat + 5;
	$oattack = $_SESSION['ops'.$n][$rat];
	if($oattack == $_SESSION['attack_short'][3]){
		$hittingd = $_SESSION['attack_short'][3];
		$hittinge = $_SESSION['attack_short'][4];
		$hittingf = $_SESSION['attack_short'][5];
	}
	
	if($attack != $_SESSION['attack_short'][0] || !$_SESSION['attack_short'][0]){
		$r_u = mysql_fetch_array(mysql_query("SELECT * FROM attacks WHERE attack = '$attack'"));
		$hittinga = $r_u['attack'];
		$hittingb = $r_u['type'];
		$hittingc = $r_u['power'];
		$_SESSION['attack_short'][0] = $hittinga;
		$_SESSION['attack_short'][1] = $hittingb;
		$_SESSION['attack_short'][2] = $hittingc;
	}
	if($oattack != $_SESSION['attack_short'][3] || !$_SESSION['attack_short'][3]){
		$r_a = mysql_fetch_array(mysql_query("SELECT * FROM attacks WHERE attack = '$oattack'"));
		$hittingd = $r_a['attack'];
		$hittinge = $r_a['type'];
		$hittingf = $r_a['power'];
		$_SESSION['attack_short'][3] = $hittingd;
		$_SESSION['attack_short'][4] = $hittinge;
		$_SESSION['attack_short'][5] = $hittingf;
	}
	if($hittingb == $_SESSION['s'.$u][2] || $hittingb == $_SESSION['s'.$u][3] ){
		$multn = 1.5;
	}
	else {
		$multn = 1;
	}
	if($hittinge == $_SESSION['ops'.$n][2] || $hittinge == $_SESSION['ops'.$n][3] ){
		$opmultn = 1.5;
	}
	else {
		$opmultn = 1;
	}

	$w = $_SESSION['s'.$u][4] / 30;
	$ww = $_SESSION['attack_short'][2] / 2;
	$y = $_SESSION['attack_short'][1];
	$g = $_SESSION['ops'.$n][2];
	$f = $_SESSION['ops'.$n][3];
	$damages = convert("$y", "$g", "$f");
	if(strstr($_SESSION['s'.$u][0],'Dark ') || strstr($_SESSION['ops'.$n][0],'Metallic ')){
		$d_a = 1;
		if(strstr($_SESSION['ops'.$n][0],'Metallic ')){
			$d_a = $d_a - 0.25;
		}
		if(strstr($_SESSION['s'.$u][0],'Dark ')){
			$d_a = $d_a + 0.25;
		}
		$w2 = $w * $ww;
		$w3 = $w2 * $d_a;
		$w4 = $w3 * $damages;
		$www = round($w4 * $multn);
	}
	else {
		$w2 = $w * $ww;
		$w3 = $w2 * $damages;
		$www = round($w3 * $multn);
	}
	$h = $_SESSION['ops'.$n][4] / 30;
	$hh = $_SESSION['attack_short'][5] / 2;
	$qw = $_SESSION['attack_short'][4];
	$wew = $_SESSION['s'.$u][2];
	$efe = $_SESSION['s'.$u][3];
	$damages2 = convert("$qw", "$wew", "$efe");
	if(strstr($_SESSION['ops'.$n][0],'Dark ') || strstr($_SESSION['s'.$u][0],'Metallic ')){
		$d_a = 1;
		if(strstr($_SESSION['s'.$u][0],'Metallic ')){
			$d_a = $d_a - 0.25;
		}
		if(strstr($_SESSION['ops'.$n][0],'Dark ')){
			$d_a = $d_a + 0.25;
		}
		$h2 = $h * $hh;
		$h3 = $h2 * $d_a;
		$h4 = $h3 * $damages2;
		$hhh = round($h4 * $opmultn);
	}
	else {
		$h2 = $h * $hh;
		$h3 = $h2 * $damages2;
		$hhh = round($h3 * $opmultn);
	}

	if(strstr($_SESSION['ops'.$n][0],'Mystic')){
		$ran = rand(1,4);
		if($ran == 2){
			$you_scared = 2;
			$www = 0;
		}
	}
	if(strstr($_SESSION['s'.$u][0],'Mystic')){
		$rand = rand(1,4);
		if($rand == 2){
			$op_scared = 2;
			$hhh = 0;
		}
	}

	$_SESSION['s'.$u][10] = $_SESSION['s'.$u][10] - $hhh;

	$_SESSION['ops'.$n][10] = $_SESSION['ops'.$n][10] - $www;


	if($_SESSION['s'.$u][10] < 0){
		$_SESSION['s'.$u][10] = 0;
	}
	if($_SESSION['ops'.$n][10] < 0){
		$_SESSION['ops'.$n][10] = 0;
	}
	$div = $_SESSION['s'.$u][10] / $_SESSION['s'.$u][11];
	$_SESSION['s'.$u][12] = $div * 100;
	$div = $_SESSION['ops'.$n][10] / $_SESSION['ops'.$n][11];
	$_SESSION['ops'.$n][12] = $div * 100; 
}

$q = $_SESSION['y_p'][1];
$p = $_SESSION['y_p'][0];
echo "<form action=\"/live_battle.php\" method=\"post\" name=\"battleForm\" id=\"battleForm\" onsubmit=\"get('/live_battle.php', '', this); disableSubmitButton(this); return false;\">";
echo "<h2>";
if(is_numeric($attack_live2) && $_SESSION['s'.$p][11] != 0 || $_POST['item'] && $_SESSION['s'.$p][11] != 0){
	if($_POST['item'] && $_SESSION['s'.$p][11] != 0){
		echo "Item Results / Select an Attack";
	}
	else{
		echo "Attack Results / Select an Attack";
	}
}
else{
	echo "Select an Attack";
}

echo '</h2><table cellpadding="0" cellspacing="0" style="width: 80%; text-align: center; margin: 0 auto;"><tr style="vertical-align: bottom;"><td style="width: 50%;">';
echo '<h3>Your ' . $_SESSION['s'.$p][0] . '</h3><img src="/images/pokemon/' . $_SESSION['s'.$p][0] . '.gif" width="80" height="80" /><br /><em>Level:</em> ' . $_SESSION['s'.$p][4] . '</td><td style="width: 50%;"><h3>' . $_SESSION['opponent_profile'][1] . '\'s ' . $_SESSION['ops'.$q][0] . '</h3><img src="/images/pokemon/' . $_SESSION['ops'.$q][0] . '.gif" width="80" height="80" /><br /><em>Level:</em> ' . $_SESSION['ops'.$q][4] . '</span></td></tr>';
echo '<tr style="vertical-align: middle;"><td style="width: 50%; padding: 10px 0;">
<strong>HP: <img src="/images/misc/hpbar.gif" height="10" width="' . $_SESSION['s'.$p][12] . '" border="0" /> ' . $_SESSION['s'.$p][10] . '</strong></td>
<td style="width: 50%; padding: 10px 0;">
<strong>HP: <img src="/images/misc/hpbar.gif" height="10" width="' . $_SESSION['ops'.$q][12] . '" border="0" /> ' . $_SESSION['ops'.$q][10] . '</strong></td>
</tr>';
if(is_numeric($attack_live2)){
	echo '<tr><td style="width: 50%; padding: 0 15px;" valign="top"><strong>';

	if($op_scared != 2){
		echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . ' and ';
		if($hhh == 0){
			echo 'had no effect.';
		}
		else{
			echo 'did '. $hhh . ' HP damage.';
		}

		if($damages2 == 4){
			echo '<br/><br/>The attack was ultra effective!';
		}
		if($damages2 == 2){
			echo '<br/><br/>The attack was super effective!';
		}
		if($damages2 == 1){
			echo '<br/><br/>The attack was not very effective.';
		}
		if($damages2 == 0){
			echo '<br/><br/>The attack did no damage.';
		}
		if($_SESSION['s'.$p][10] == 0){
			echo '<br/><br/>' . $_SESSION['s'.$p][0] . ' has fainted.';
		}
	}
	if($op_scared == 2){
		echo $_SESSION['ops'.$q][0] . ' is scared an could not attack.';
	}
	echo '</strong></td><td style="width: 50%; padding: 0 15px;" valign="top"><strong>';
	if($you_scared != 2){
		echo 'Your ' . $_SESSION['s'.$p][0] . ' attacked ' . $_SESSION['ops'.$q][0] . ' with ' . $attack . ' and ';
		if($www == 0){
			echo 'had no effect.';
		}
		else{
			echo 'did '. $www . ' HP damage.';
		}
		if($damages == 4){
			echo '<br/><br/>The attack was ultra effective!';
		}
		if($damages == 2){
			echo '<br/><br/>The attack was super effective!';
		}
		if($damages == 1){
			echo '<br/><br/>The attack was not very effective.';
		}
		if($damages == 0){
			echo '<br/><br/>The attack did no damage.';
		}
		if($_SESSION['ops'.$q][10] == 0){
			echo '<br/><br/>' . $_SESSION['ops'.$q][0] . ' has fainted.';
		}
	}
	else{
		echo $_SESSION['s'.$p][0] . ' is scared an could not attack.';
	}
	echo '</strong></td></tr><tr><td style="width:50%;"><div class="hr"></div></td><td style="width:50%;"><div class="hr"></div></td></tr>';
}
if($_POST['item']){
	echo '<tr><td style="width: 50%; padding: 0 15px;" valign="top"><strong>';
	if($op_scared != 2){
		echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . ' and ';
		if($hhh == 0){
			echo 'had no effect.';
		}
		else{
			echo 'did '. $hhh . ' HP damage.';
		}
		if($damages2 == 4){
			echo '<br/><br/>The attack was ultra effective!';
		}
		if($damages2 == 2){
			echo '<br/><br/>The attack was super effective!';
		}
		if($damages2 == 1){
			echo '<br/><br/>The attack was not very effective.';
		}
		if($damages2 == 0){
			echo '<br/><br/>The attack did no damage.';
		}
		if($_SESSION['s'.$p][10] == 0){
			echo '<br/><br/>' . $_SESSION['s'.$p][0] . ' has fainted.';
		}
	}

	else{
		echo $_SESSION['ops'.$q][0] . ' is scared an could not attack.';
	}

	echo '<br/><br/>Your ' . $_SESSION['s'.$p][0] . ' has ' . $item_statement;

	echo '</strong></td><td style="width: 50%; padding: 0 15px;" valign="top"><strong>Your ' . $_SESSION['s'.$p][0] . ' could not attack.';

	echo '</strong></td></tr><tr><td style="width:50%;"><div class="hr"></div></td><td style="width:50%;"><div class="hr"></div></td></tr>';

}
if($_SESSION['ops'.$q][10] != 0 && $_SESSION['s'.$p][10] != 0){
	$one = 'checked="checked"';
if($_SESSION['attack_short'][0] == $_SESSION['s'.$p][7]){
	$two = 'checked="checked"';
}
if($_SESSION['attack_short'][0] == $_SESSION['s'.$p][8]){
	$three = 'checked="checked"';
}
if($_SESSION['attack_short'][0] == $_SESSION['s'.$p][9]){
	$four = 'checked="checked"';
}
echo '<td style="width: 50%; padding: 0 10px;"><table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 0 auto; text-align: left;"><tr><td><p><strong>Select an attack:</strong></p><p><input type="radio" name="attack" id="attack1" value="1" ' . $one . ' />1. ' . $_SESSION['s'.$p][6] . '<br /><input type="radio" name="attack" id="attack2" value="2" ' . $two . '/>2. ' . $_SESSION['s'.$p][7] . '<br /><input type="radio" name="attack" id="attack3" value="3" ' . $three . '/>3. ' . $_SESSION['s'.$p][8] . '<br /><input type="radio" name="attack" id="attack4" value="4" ' . $four . '/>4. ' . $_SESSION['s'.$p][9] . '</p></td></tr></table></td>';

echo '<td style="width: 50%; padding: 0 10px;">
<table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 0 auto; text-align: left;"><tr><td><p><strong>Attacks:</strong></p><p>1. ' . $_SESSION['ops'.$q][6] . '<br />2. ' . $_SESSION['ops'.$q][7] . '<br />3. ' . $_SESSION['ops'.$q][8] . '<br />4. ' . $_SESSION['ops'.$q][9] . '</p></td></tr></table></td>';

echo '</tr></table>';
echo '<input type="hidden" name="action" value="attack" /><br /><input type="submit" value="Attack!" /></form>
<div class="hr"></div><h2 style="margin-top: 30px;">Or Use an Item</h2>
<table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
<tr style="vertical-align: text-top;"><td>
<form action="live_battle.php" method="post" id="itemForm" name="itemForm" onsubmit="get(\'/live_battle.php\', \'\', this); disableSubmitButton(this); return false;">
<table cellpadding="0" cellspacing="0" style="width: 260px; margin: 0 20px;">
<tr style="text-align: center;"><td>
<strong>Item:</strong></td>
<td width="80"><strong>Quantity:</strong></td></tr>';


$quick = array("Potion", "Super Potion", "Hyper Potion", "Full Heal", "Awakening", "Parlyz Heal", "Antidote", "Burn Heal", "Ice Heal");
for($a=0;$a<9;$a++){
	echo '<tr><td style="text-align: left;"><input type="radio" name="item" id="item2" value="' . $quick[$a] . '" ';
	if($_SESSION['items'][$a] == 0){
		echo "disabled";
	}
	echo '/> <label for="item2"><img src="/images/items/' . $quick[$a] . '.png" height="24" width="24" align="absmiddle">';

	if($_SESSION['items'][$a] == 0){ echo '<s>';} 
		echo $quick[$a];
		if($_SESSION['items'][$a] == 0){ echo '</s>';} 
			echo '</label></td><td align="center">' . $_SESSION['items'][$a] . '</td></tr>';
		}
		echo '<tr><td colspan="2"><center><input name="items" type="submit" value="Use Item" /><br /></center></td></tr></td></tr></table></form></td></td></tr>';
	}
	if($_SESSION['ops'.$q][10] == 0 || $_SESSION['s'.$p][10] == 0){
		echo '<input name="choose" type="hidden" value="pokechu">';
		echo '<tr><td colspan="2"><center><input type="submit" value="Continue"></center></td></tr>';
	}
	echo "</table>";
}
if($_REQUEST['battle'] == 'Live'){
	$get_op = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['live'][3]}'");
	$count_op = mysql_num_rows($get_op);
	if($count_op == 0){
		echo "<div class='errorMsg'>The username you have submitted does not exist.</div>";
	}
	else{
		$get_op1 = mysql_fetch_array($get_op);
		$a = $get_op1['s1'];$b = $get_op1['s2'];$c = $get_op1['s3'];$d = $get_op1['s4'];$e = $get_op1['s5'];$f = $get_op1['s6'];
		if($a && !$b){
			$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a) ORDER BY FIELD(id,$a)");
			$o_num = 1;
		}
		if($b && !$c){
			$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b) ORDER BY FIELD(id,$a,$b)");
			$o_num = 2;
		}
		if($c && !$d){
			$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c) ORDER BY FIELD(id,$a,$b,$c)");
			$o_num = 3;
		}
		if($d && !$e){
			$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c,$d) ORDER BY FIELD(id,$a,$b,$c,$d)");
			$o_num = 4;
		}
		if($e && !$f){
			$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c,$d,$e) ORDER BY FIELD(id,$a,$b,$c,$d,$e)");
			$o_num = 5;
		}
		if($f){
			$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c,$d,$e,$f) ORDER BY FIELD(id,$a,$b,$c,$d,$e,$f)");
			$o_num = 6;
		}

		$_SESSION['opponent_profile'] = array("{$get_op1['id']}","{$get_op1['username']}","{$o_num}","{$type}");

		while($goo = mysql_fetch_assoc($t)){
			$pname[] = $goo['name'];$pid[] = $goo['id'];$ptype1[] = $goo['t1'];$ptype2[] = $goo['t2'];$plvl[] = $goo['lvl'];$pexp[] = $goo['exp'];$pattack1[] = $goo['a1'];$pattack2[] = $goo['a2'];$pattack3[] = $goo['a3'];$pattack4[] = $goo['a4'];
		}
		for($i=0;$i<$o_num;$i++){
			if(strstr($pname[$i],'Shiny')){
				$ohp = $plvl[$i] * 5;
			}
			else {
				$ohp = $plvl[$i] * 4;
			}
			$s = $i + 1;
			$_SESSION['ops'.$s] = array($pname[$i],$pid[$i],$ptype1[$i],$ptype2[$i],$plvl[$i],$pexp[$i],$pattack1[$i],$pattack2[$i],$pattack3[$i],$pattack4[$i],$ohp,$ohp,"100","0","0","0");
		}

		$r = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
		$re = mysql_fetch_array($r);
		if(!isset($_SESSION['items'])){
			$it = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}'");
			$itt = mysql_fetch_array($it);
			$_SESSION['items'] = array("{$itt['Potion']}","{$itt['Super_Potion']}","{$itt['Hyper_Potion']}","{$itt['Full_Heal']}","{$itt['Awakening']}","{$itt['Parlyz_Heal']}","{$itt['Antidote']}","{$itt['Burn_Heal']}","{$itt['Ice_Heal']}","{$itt['Poke_Ball']}","{$itt['Great_Ball']}","{$itt['Ultra_Ball']}","{$itt['Master_Ball']}");
			}
			$pname = '';$pid = '';$ptype1 = '';$ptype2 = '';$plvl = '';$pexp = '';$pattack1 = '';$pattack2 = '';$pattack3 = '';$pattack4 = '';
			
			
			$a = $re['s1'];$b = $re['s2'];$c = $re['s3'];$d = $re['s4'];$e = $re['s5'];$f = $re['s6'];
			if($a && !$b){
				$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id IN($a) ORDER BY FIELD(id,$a)");
				$u_num = 1;
			}
			if($b && !$c){
				$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id IN($a,$b) ORDER BY FIELD(id,$a,$b)");
				$u_num = 2;
			}
			if($c && !$d){
				$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id IN($a,$b,$c) ORDER BY FIELD(id,$a,$b,$c)");
				$u_num = 3;
			}
			if($d && !$e){
				$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id IN($a,$b,$c,$d) ORDER BY FIELD(id,$a,$b,$c,$d)");
				$u_num = 4;
			}
			if($e && !$f){
				$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id IN($a,$b,$c,$d,$e) ORDER BY FIELD(id,$a,$b,$c,$d,$e)");
				$u_num = 5;
			}
			if($f){
				$t = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id IN($a,$b,$c,$d,$e,$f) ORDER BY FIELD(id,$a,$b,$c,$d,$e,$f)");
				$u_num = 6;
			}
			$_SESSION['your_profile'] = array("{$re['id']}","{$re['username']}","{$u_num}","{$re['eb']}");
			while($goo = mysql_fetch_assoc($t)){
				$pname[] = $goo['name'];
				$pid[] = $goo['id'];
				$ptype1[] = $goo['t1'];
				$ptype2[] = $goo['t2'];
				$plvl[] = $goo['lvl'];
				$pexp[] = $goo['exp'];
				$pattack1[] = $goo['a1'];
				$pattack2[] = $goo['a2'];
				$pattack3[] = $goo['a3'];
				$pattack4[] = $goo['a4'];
			}
			for($i=0;$i<$u_num;$i++){
				if(strstr($pname[$i],'Shiny')){
					$hp = $plvl[$i] * 5;
				}
				else {
					$hp = $plvl[$i] * 4;
				}
				$s = $i + 1;
				$_SESSION['s'.$s] = array($pname[$i],$pid[$i],$ptype1[$i],$ptype2[$i],$plvl[$i],$pexp[$i],$pattack1[$i],$pattack2[$i],$pattack3[$i],$pattack4[$i],$hp,$hp,"100","0","0","0");
			}
			$_SESSION['position'] = 1;
		}
	}
	echo "<form action=\"/live_battle.php\" method=\"post\" name=\"battleForm\" id=\"battleForm\" onsubmit=\"get('/live_battle.php', '', this); disableSubmitButton(this); return false;\">";
	if($_SESSION['position'] == 1){
		$all_dead_op = 1;
		$all_dead_op = $_SESSION['ops1'][10] + $_SESSION['ops2'][10] + $_SESSION['ops3'][10] + $_SESSION['ops4'][10] + $_SESSION['ops5'][10] + $_SESSION['ops6'][10];
		$all_dead_u = $_SESSION['s1'][10] + $_SESSION['s2'][10] + $_SESSION['s3'][10] + $_SESSION['s4'][10] + $_SESSION['s5'][10] + $_SESSION['s6'][10];
		if($all_dead_op == 0 && isset($_SESSION['ops1'])){
			$timebefore = mysql_query("SELECT btime, uniques, battle, totalexp FROM members WHERE id = '{$_SESSION['myid']}'");
			$tb = mysql_fetch_array($timebefore);
			$tbb = $tb['btime'];
			$time = time();
			$secs = $time - $tbb;
			if($secs < 10){
				echo '<div class="errorMsg">You have already completed a battle within the last 10 seconds. This is in effect to prevent cheating of any kind.</div>
				<p class="optionsList autowidth"><strong>Options:</strong><br />
				<a href="/live_battle.php?';
				if($_SESSION['opponent_profile'][3] == 'gym'){
					echo 'gymleader=' . $_SESSION['opponent_profile'][1];
				}
				else{
					echo 'bid=' . $_SESSION['opponent_profile'][0];
				}
				echo '" onclick="get(\'/live_battle.php\', \'';
				if($_SESSION['opponent_profile'][3] == 'gym'){
					echo 'gymleader=' . $_SESSION['opponent_profile'][1];
				}
				else{
					echo 'bid=' . $_SESSION['opponent_profile'][0];
				}
				echo '\'); return false;" class="deselected">Rebattle Opponent</a><br />
				<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
				<a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>';
			}
			else{
				echo '<h2>Congratulations! You won the battle!</h2>
				<h3>Your team beat ' . $_SESSION['opponent_profile'][1] . '\'s team.</h3>';
				mysql_query("DELETE FROM live_battle WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'");
				
				for($sa=1;$sa<=6;$sa++){
					if($_SESSION['s'.$sa][13] == 1){

						echo '<p><img src="/images/pokemon/' . $_SESSION['s'.$sa][0] . '.gif" align="absmiddle"> <strong><a href="/pokedex.php?pid=' . $_SESSION['s'.$sa][1] . '" onclick="pokedexTab(\'pid=' . $_SESSION['s'.$sa][1] . '\', 1); return false;">' . $_SESSION['s'.$sa][0] . '</a></strong></p>';
						$ya += 1;
						$u_level += $_SESSION['s'.$sa][4];
					}
				}

				for($asw=1;$asw<=$_SESSION['opponent_profile'][2];$asw++){
					$amount_level += $_SESSION['ops'.$asw][4];
				}
				$exp2 = $amount_level / $u_level;
				$r_e_x = $exp2 * 500;
				$exp2 = round($r_e_x * $_SESSION['your_profile'][3]);
				$tottal = 0;
				for($sa=1;$sa<=6;$sa++){
					if($_SESSION['s'.$sa][13] == 1){
						$tottal += $exp2;
						$id = $_SESSION['s'.$sa][1];
						$levl = $_SESSION['s'.$sa][4];
						if($levl == '100'){
							mysql_query("UPDATE pokemon SET exp = exp + $exp2 WHERE id = '$id'");
						}
						else{
							$trial = mysql_query("SELECT exp FROM pokemon WHERE id = '$id'");
							$lala = mysql_fetch_array($trial);
							$final = $lala['exp'] + $exp2;
							$lala2 = floor($final / 500);
							if($lala2 > 100){
								$lala2 = 100;
							}
							mysql_query("UPDATE pokemon SET lvl = '$lala2', exp = '$final' WHERE id = '$id'");
						}
					}
				}
				function randmoney($ex){
					$rvar = rand(1,1000);
					switch($rvar){
						case ($rvar <= 500):
						$moni = round($ex * 0.5);
						break;
						case ($rvar >= 501 && $rvar <= 800):
						$moni = round($ex * 1.2);
						break;
						case ($rvar >= 801 && $rvar <= 950):
						$moni = round($ex * 1.5);
						break;
						case ($rvar >= 951 && $rvar <= 994):
						$moni = round($ex * 2);
						break;
						case ($rvar >= 995 && $rvar <= 999):
						$moni = round($ex * 4);
						break;
						case ($rvar == 1000):
						$moni = round($ex * 7.5);
						break;
					}
					return $moni;
				}
				if($exp2 > 0){
					echo '<p>Each Pokemon above gained ';
					echo number_format($exp2); 
					$money = randmoney($exp2);
					echo ' experience points.';

					echo '<br />You also won <img src="/images/misc/pmoney.gif">' . number_format($money) . ' to buy items with.</p>';
					echo '<p class="optionsList autowidth"><strong>Options:</strong><br />
					<a href="/live_battle.php?';
					
					echo 'bid=' . $_SESSION['opponent_profile'][0];
					echo '" onclick="get(\'/live_battle.php\', \'';
					echo 'bid=' . $_SESSION['opponent_profile'][0];
					
					echo '\'); return false;" class="deselected">Rebattle Opponent</a><br />
					<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
					<a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>';
					$aiir = mysql_query("SELECT owner, AVG(exp) FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY owner");
					$aiir2 = mysql_fetch_array($aiir);
					$unique = $tb['uniques'];
					$avgexp = $aiir2['AVG(exp)'];
					$totalexp = $tb['totalexp'] + $tottal;
					$battle = $tb['battle'] + 1;
					$p1 = sqrt($totalexp);
					$p2 = $p1 / 20;
					$p3 = sqrt($avgexp) / 5;
					$p4 = $p2 + $p3;
					$p5 = sqrt($battle) * sqrt($unique);
					$p6 = $p4 + $p5;
					$p7 = round($p6, 1);
					$time = time();
					mysql_query("UPDATE members SET btime = '$time', averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7', battle = '{$battle}', money = money + $money WHERE id = '{$_SESSION['myid']}'");
				}
			}

			unset($_SESSION['opponent_profile'],$_SESSION['s1'],$_SESSION['s2'],$_SESSION['s3'],$_SESSION['s4'],$_SESSION['s5'],$_SESSION['s6'],$_SESSION['ops1'],$_SESSION['ops2'],$_SESSION['ops3'],$_SESSION['ops4'],$_SESSION['ops5'],$_SESSION['ops6'],$_SESSION['position'],$_SESSION['your_profile'],$_SESSION['y_p']); 
		}
		elseif($all_dead_u == 0 && isset($_SESSION['ops1'])){
			$timebefore = mysql_query("SELECT btime FROM members WHERE id = '{$_SESSION['myid']}'");
			$tb = mysql_fetch_array($timebefore);
			$tbb = $tb['btime'];
			$time = time();
			$secs = $time - $tbb;
			if($secs < 9){
				echo '<div class="errorMsg">You have already completed a battle within the last 10 seconds. This is in effect to prevent cheating of any kind.</div>
				<p class="optionsList autowidth"><strong>Options:</strong><br />
				<a href="/live_battle.php?';
				if($_SESSION['opponent_profile'][3] == 'gym'){
					echo 'gymleader=' . $_SESSION['opponent_profile'][1];
				}
				else{
					echo 'bid=' . $_SESSION['opponent_profile'][0];
				}
				echo '" onclick="get(\'/live_battle.php\', \'';
				if($_SESSION['opponent_profile'][3] == 'gym'){
					echo 'gymleader=' . $_SESSION['opponent_profile'][1];
				}
				else{
					echo 'bid=' . $_SESSION['opponent_profile'][0];
				}
				echo '\'); return false;" class="deselected">Rebattle Opponent</a><br />
				<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
				<a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>';
			}
			else{
				mysql_query("UPDATE members SET btime = '$time', losses = losses + 1 WHERE id = '{$_SESSION['myid']}'");
				echo '<h2>Sorry, you lost the battle.</h2>
				<h3>Your team lost to ' . $_SESSION['opponent_profile'][1] . '\'s team.</h3>';
				echo '<p class="optionsList autowidth"><strong>Options:</strong><br />
				<a href="/live_battle.php?';
				if($_SESSION['opponent_profile'][3] == 'gym'){
					echo 'gymleader=' . $_SESSION['opponent_profile'][1];
				}
				else{
					echo 'bid=' . $_SESSION['opponent_profile'][0];
				}
				echo '" onclick="get(\'/live_battle.php\', \'';
				if($_SESSION['opponent_profile'][3] == 'gym'){
					echo 'gymleader=' . $_SESSION['opponent_profile'][1];
				}
				else{
					echo 'bid=' . $_SESSION['opponent_profile'][0];
				}
				echo '\'); return false;" class="deselected">Rebattle Opponent</a><br />
				<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
				<a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>';
			}
			unset($_SESSION['opponent_profile'],$_SESSION['s1'],$_SESSION['s2'],$_SESSION['s3'],$_SESSION['s4'],$_SESSION['s5'],$_SESSION['s6'],$_SESSION['ops1'],$_SESSION['ops2'],$_SESSION['ops3'],$_SESSION['ops4'],$_SESSION['ops5'],$_SESSION['ops6'],$_SESSION['position'],$_SESSION['your_profile'],$_SESSION['y_p']); 
		}
		elseif($all_dead_u == 0 && $all_dead_op == 0 && !isset($_SESSION['ops1'])){
			echo '<h2>Cheating is bad for your health. So don\'t do it.</h2>';
		}
		else{
			unset($_SESSION['y_p']);
			mysql_query("UPDATE live_battle SET user_time_1 = 0, user_time_2 = 0, pokemon_choice_{$_SESSION['live'][0]} = '', user_position_{$_SESSION['live'][0]} = '0', user_position_{$_SESSION['live'][0]}_2 = '0' WHERE uid_{$_SESSION['live'][0]} = '{$_SESSION['myid']}' AND uid_{$_SESSION['live'][1]} = '{$_SESSION['opponent_profile'][0]}'");

			echo '<h3>Select your next Pok&eacute;mon to battle:</h3><table cellspacing="0" cellpadding="0" class="pokemonList"><tr><td nowrap="nowrap" id="y_p">';
			for($i=1;$i<=$_SESSION['your_profile'][2];$i++){

				echo '<table cellpadding="3" cellspacing="0"><tr><td><input type="radio" name="active_pokemon" value="'. $_SESSION['s'.$i][1] . '"';
				if($_SESSION['s1'][10] != 0 && $i == 1){  
					echo ' checked="checked"';
				} 
				elseif($_SESSION['s1'][10] == 0 && $_SESSION['s2'][10] != 0 && $i == 2){
					echo ' checked="checked"';
				} 
				elseif($_SESSION['s2'][10] == 0 && $_SESSION['s1'][10] == 0 && $_SESSION['s3'][10] != 0 && $i == 3){
					echo ' checked="checked"';
				}
				elseif($_SESSION['s3'][10] == 0 && $_SESSION['s2'][10] == 0 && $_SESSION['s1'][10] == 0 && $_SESSION['s4'][10] != 0 && $i == 4){
					echo ' checked="checked"';
				} 
				elseif($_SESSION['s4'][10] == 0 && $_SESSION['s3'][10] == 0 && $_SESSION['s2'][10] == 0 && $_SESSION['s1'][10] == 0 && $_SESSION['s5'][10] != 0 && $i == 5){
					echo ' checked="checked"';
				}
				elseif($_SESSION['s5'][10] == 0 && $_SESSION['s4'][10] == 0 && $_SESSION['s3'][10] == 0 && $_SESSION['s2'][10] == 0 && $_SESSION['s1'][10] == 0 && $_SESSION['s6'][10] != 0 && $i == 6){
					echo ' checked="checked"';
				}
				if($_SESSION['s'.$i][10] == 0){ echo " disabled"; }  
					echo '/><img src="/images/pokemon/' . $_SESSION['s'.$i][0] . '.gif" width="80" height="80" /></td><td><p><strong><a href="/pokedex.php?pid=' . $_SESSION['s'.$i][1] . '" onclick="pokedexTab(\'pid=' . $_SESSION['s'.$i][1] . '\', 1); return false;">';
					if($_SESSION['s'.$i][10] == 0){
						echo "<s>";
					}
					echo $_SESSION['s'.$i][0] . '</a></strong><br /><em>Level:</em>' . $_SESSION['s'.$i][4] . '<br /><em>HP:</em>' . $_SESSION['s'.$i][10];
					if($_SESSION['s'.$i][10] == 0){
						echo "</s>";
					}
					echo '</p></td></tr></table>';
				}
				echo '</td></tr></table>';
				echo '<h2>' . $_SESSION['opponent_profile'][1] . '\'s Pok&eacute;mon Team:</h2>
				<h3>Order shown is the order you will battle them.</h3>
				<table cellspacing="0" cellpadding="0" class="pokemonList">
				<tr>
				<td nowrap="nowrap" id="opponent_pokemon">';

				for($i=1;$i<=$_SESSION['opponent_profile'][2];$i++){
					echo '<table cellpadding="3" cellspacing="0"><tr><td><img src="/images/pokemon/' . $_SESSION['ops'.$i][0] . '.gif" width="80" height="80" /></td><td><p><strong><a href="/pokedex.php?pid=' . $_SESSION['ops'.$i][1] . '" onclick="pokedexTab(\'pid=' . $_SESSION['ops'.$i][1] . '\', 1); return false;">';
					if($_SESSION['ops'.$i][10] == 0){
						echo "<s>";
					}
					echo $_SESSION['ops'.$i][0];
					echo '</a></strong><br /><em>Level:</em> ' . $_SESSION['ops'.$i][4] . '<br /><em>HP:</em> ' . $_SESSION['ops'.$i][10]; 

					if($_SESSION['ops'.$i][10] == 0){ echo "</s>"; } 
						echo "</p></td></tr></table>";
					}
					echo '</td></tr></table><input type="hidden" name="action" value="select_attack" /><p><input type="submit" value="Continue" /></p></form>';
					$_SESSION['position'] = 2;
				}
			}
			if(!$_REQUEST['bid'] && !isset($_SESSION['opponent_profile']) && !$_POST['choose']){
				echo '<div class="errorMsg">Don\'t be greedy now</div>';
			}
if(!$_REQUEST['ajax']){

echo '</div>
<div id="copy">&copy;2008-2014 <a href="/">The Pok&eacute;mon Shqipe</a> This site is not affiliated with Nintendo, The Pok&eacute;mon Company, Creatures, or GameFreak<br /><a href="contactus.php">Contact Us</a> | <a href="about.php">About Us / FAQ</a> | <a href="privacy.php">Privacy Policy &amp; Terms of Service</a> | <a href="legal.php">Legal Info</a></div>
</div></div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>';
}
?>