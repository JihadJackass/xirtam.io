<?php

include('kick.php');
if(!isset($_SESSION['myid']) || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:http://pokemon-shqipe.co.uk/login.php?goawaxP=1");
	exit();
}

/*
 * ---------------- Javascript check. -------------------
 * $_SESSION['nojs-check'] is set to a random token when the Select your next Pokemon screen is displayed.
 * The check condition is passed if the puzzle is solved and the token matches the one expected.
 * If the session token is NULL, then we weren't expecting one anyway - so this is also considered a pass.
 * ------------------------------------------------------
 */
$noJSpass = (!isset($_SESSION['nojs-check']) || intval(@$_POST['nojs-check'])===$_SESSION['nojs-check']);
unset($_SESSION['nojs-check']);

function displayNOJSpuzzle(){
	if (isset($_SESSION['nojs-check'], $_SESSION['nojs-check-a'], $_SESSION['nojs-check-b'])) { ?>
  		<div id="nojs-solve" style="display:none;background:#fbb;width:300px;margin:auto;padding:10px;border:1px solid #888;">
		<?php
		if (isset($_SESSION['nojs-check-err'])) {
			unset($_SESSION['nojs-check-err']);
			?>
			<span style="color:red;display:block;">Incorrect answer. Please try again.</span>
			<?php
		} ?>
		<input type="hidden" id="nojs-solve-a" value="<?=$_SESSION['nojs-check-a']?>" /> 
		<input type="hidden" id="nojs-solve-b" value="<?=$_SESSION['nojs-check-b']?>" />
		<label style="font-size:13px;">Please solve the following <?=$_SESSION['nojs-check-a']?> + <?=$_SESSION['nojs-check-b']?> = <input id="nojs-solve-v" type="text" name="nojs-check" style="width:30px;padding:6px;font-size:13px;"></label>
		<noscript><span style="display:block;color:#666;padding-top:10px;font-size:9px;">Note If you enable Javascript in your browser, you will no longer have to solve these puzzles.</span></noscript>
		</div>
		<?php
	}
}
function generateBattleButtonText($base) {
	if (rand(0,1)) {
		$base = " ".$base;
	}
	if (rand(0,1)) {
		$base .= " ";
	}
	$endings = array("",".","!","?","..","...");
	$base .= $endings[rand(0,count($endings)-1)];
	if (rand(0,1)) {
		$base .= " ";
	}
	return $base;
}

$random = rand(1309,9206);
include('pv_connect_to_db.php');

// Make sure the battle is valid

if(is_numeric($_REQUEST['bid']) || $_REQUEST['gymleader'] || $_REQUEST['sidequest'] || $_REQUEST['eventtrainer'] || $_REQUEST['clanbattle']){
	
	// Unset previous battle sessions
	
	unset($_SESSION['opponent_profile'],$_SESSION['s1'],$_SESSION['s2'],$_SESSION['s3'],$_SESSION['s4'],$_SESSION['s5'],$_SESSION['s6'],$_SESSION['ops1'],$_SESSION['ops2'],$_SESSION['ops3'],$_SESSION['ops4'],$_SESSION['ops5'],$_SESSION['ops6'],$_SESSION['position'],$_SESSION['your_profile'],$_SESSION['y_p']); 
}
else {
	if (!$noJSpass) {
		unset($_SESSION['nojs-check']);
		
		// Opponent types
		
		switch ($_SESSION['opponent_profile'][3]) {
			default: $loc = 'battle.php?bid='.$_SESSION['opponent_profile'][0]; break;
			case 'event': $loc = 'battle.php?eventtrainer='.$_SESSION['opponent_profile'][1]; break;
			case 'gym': $loc = 'battle.php?gymleader='.$_SESSION['opponent_profile'][1]; break;
			case 'side': $loc = 'battle.php?sidequest='.$_SESSION['opponent_profile'][0]; break;
			case 'clan': $loc = 'battle.php?clanbattle='.$_SESSION['opponent_profile'][4]; break;
		}
		$_SESSION['nojs-check-err'] = true;
		header('Location: '.$loc);
		exit;
	}	
}
if(!$_REQUEST['ajax']){
	$time = time(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="/html/static/js/v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
<?php
if($_SESSION['layout'] == '1'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
if($_SESSION['layout'] == '2'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie6-.js"></script>
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<style>#hide {display:none;}</style>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<script type="text/javascript"><!--
	function solveJScap(){
		var a = document.getElementById('nojs-solve-a');
		var b = document.getElementById('nojs-solve-b');
		var v = document.getElementById('nojs-solve-v'); 
		if (!a || !b || !v) { return; }
		v.value = parseInt(a.value) + parseInt(b.value);
	}
//-->
</script>
<noscript><style type="text/css">#nojs-solve{display:block !important;}</style></noscript>
<title>Pok&eacute;mon Shqipe v3 - Battle</title>
<style>
.hidden
{
	position: absolute;
	left: -10000px;
	top: auto;
	width: 1px;
	height: 1px;
	overflow: hidden;
}
</style>

</head>
<body>
<?php
if($_SESSION['myuser'] == ' '){
?>
<script type="text/javascript">
   var _mfq = _mfq || [];
   (function() {
       var mf = document.createElement("script"); mf.type = "text/javascript"; mf.async = true;
       mf.src = "//cdn.mouseflow.com/projects/6f42b4a2-655b-49bf-88b6-a0a12c7dbb46.js";
       document.getElementsByTagName("head")[0].appendChild(mf);
   })();
</script>
<?php 
}
include_once("analytics.php"); ?>
<div id="alert"></div>
<div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<?php
include('/var/www/ads/headerad.php');
?>

<!-- <script>
$(function(){
   setTimeout(function(){
      if($("#headerAd").css('display')=="none")
      {
          $('body').html("<center><h2>Oh no, You have AdBlocker</h2><img src=\"html/static/images/pika_cry.gif\"><p />We noticed you have an active Ad Blocker.<br />Pok&eacute;mon Shqipe is 100% funded by advertisements, we promise our ads are of high quality and are unobtrusive.<br />Please whitelist this site from your ad blocker so we can continue to provide this website for as long as possible and for free.<br />Thank You.");
      }
  },1000);
});
</script> -->
</div>
<div id="title">
<h1><a href="index"><em>pokemon-shqipe.co.uk</em></a></h1>
</div>
<ul id="nav">
<li><a href="map_select" id="mapsTab" class="deselected"><em>Maps</em></a></li>
<li><a href="battle_select" id="battleTab" class="deselected"><em>Battle</em></a></li>
<li><a href="your_account" id="yourAccountTab" class="deselected"><em>Your Account</em></a></li>
<li><a href="community" id="communityTab" class="deselected"><em>Communtiy</em></a></li>
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
<li><a href="/pokedex" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
<li><a href="/members" id="membersTab" class="deselected"><em>Members</em></a></li>
<li><a href="/options" id="optionsTab" class="deselected"><em>Options</em></a></li>
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
<?php
include('/var/www/ads/sidead.php');
?>

</div>
<div id="scrollContent">
<div id="ajax">
<?php
}
// Pokemon type damage conversions in style of the attacker

if($_SESSION['position'] == 2 && !isset($_POST['choose'])){
	function convert($atype, $ty, $ty2){
		$damage = 1;
		switch($atype){
			case Fairy: // Fairy Type
			if($ty == "Fire" || $ty2 == "Fire"){
				$damage = $damage / 2;
			}
			if($ty == "Fighting" || $ty2 == "Fighting"){
				$damage = $damage * 2;
			}
			if($ty == "Poison" || $ty2 == "Poison"){
				$damage = $damage / 2;
			}
			if($ty == "Dragon" || $ty2 == "Dragon"){
				$damage = $damage * 2;
			}
			if($ty == "Dark" || $ty2 == "Dark"){
				$damage = $damage * 2;
			}
			if($ty == "Steel" || $ty2 == "Steel"){
				$damage = damage * 0;
			}
			break;
			case Flying: // Flying Type
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
			case Electric: // Electric Type
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
			case Fighting: // Fighting Type
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
			if($ty == "Fairy" || $ty2 == "Fairy"){
				$damage = $damage / 2;
			}
			break;
			case Fire: // Fire Type
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
			case Grass: // Grass Type
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
			case Steel: // Steel Type
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
			if($ty == "Fairy" || $ty2 == "Fairy"){
				$damage = $damage * 2;
			}
			break;
			case Psychic: // Psychic Type
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
			case Ghost: // Ghost Type
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
			break;
			case Rock: // Rock Type
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
			case Ground: // Ground Type
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
			case Poison: // Poison Type
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
			if($ty == "Fairy" || $ty2 == "Fairy"){
				$damage = $damage * 2;
			}
			break;
			case Dark: // Dark Type
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
			if($ty == "Fairy" || $ty2 == "Fairy"){
				$damage = $damage / 2;
			}
			break;
			case Normal: // Normal Type
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
			case Water: // Water Type
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
			case Ice: // Ice Type
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
			case Bug: // Bug Type
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
			if($ty == "Fairy" || $ty2 == "Fairy"){
				$damage = $damage / 2;
			}
			break;
			case Dragon: // Dragon Type
			if($ty == "Steel" || $ty2 == "Steel"){
				$damage = $damage / 2;
			}
			if($ty == "Dragon" || $ty2 == "Dragon"){
				$damage = $damage * 2;
			}
			if($ty == "Fairy" || $ty2 == "Fairy"){
				$damage = $damage * 0;
			}
			break;
		}
		return $damage; // Get damage after type check
	}
	
	//--------------------------------------------USE AN ITEM AND OPPONENT ATTACKS----------------------------------------------//
	
	if($_POST['item']){
		$u = $_SESSION['y_p'][0];
		$n = $_SESSION['y_p'][1];
		$quick = array("Potion", "Super Potion", "Hyper Potion", "Full Heal", "Awakening", "Paralyz Heal", "Antidote", "Burn Heal", "Ice Heal");
		$quicky = array("Potion", "Super_Potion", "Hyper_Potion", "Full_Heal", "Awakening", "Paralyz_Heal", "Antidote", "Burn_Heal", "Ice_Heal");
		for($ra=0;$ra<=8;$ra++){
			if($quick[$ra] == $_POST['item']){
				if($_SESSION['items'][$ra] > 0){ // If the user has enough of the used item
					$_SESSION['items'][$ra] -= 1; // update the item session
					$rq = $quicky[$ra];
					mysql_query("UDPATE items SET $rq = $rq - 1 WHERE uid = '{$_SESSION['myid']}'"); // Update used item
				}
			}
		}
		$tu = rand(1,4);
		$tu = $tu + 5;
		$oattack = $_SESSION['ops'.$n][$tu]; // Opponents attack session [6] to [9]
		if($oattack == $_SESSION['attack_short'][3]){ // If opponent attack session is set
			$hittingd = $_SESSION['attack_short'][3]; // Opponent attack name
			$hittinge = $_SESSION['attack_short'][4]; // opponent attack type
			$hittingf = $_SESSION['attack_short'][5]; // opponent attack power
			$hittingg = $_SESSION['attack_short'][6]; // opponent attack accuracy
			$category = $_SESSION['attack_short'][8]; // opponent attack category
		}
		if($oattack != $_SESSION['attack_short'][3] || !$_SESSION['attack_short'][3]){ // If opponent has no attack session set
			$r_a = mysql_fetch_array(mysql_query("SELECT * FROM attacks WHERE attack = '$oattack'")); // Get the attack
			$hittingd = $r_a['attack']; // return name
			$hittinge = $r_a['type']; // return type
			$hittingf = $r_a['power']; // return power
			$hittingg = $r_a['accuracy']; // return accuracy
			$category = $r_a['category']; // return category
			$_SESSION['attack_short'][3] = $hittingd; // Opponent attack name session
			$_SESSION['attack_short'][4] = $hittinge; // Opponent attack type session
			$_SESSION['attack_short'][5] = $hittingf; // Opponent attack power session
			$_SESSION['attack_short'][6] = $hittingg; // opponent attack accuracy session
			$_SESSION['attack_short'][8] = $category; // opponent attack category session
		}
		if($hittinge == $_SESSION['ops'.$n][2] || $hittinge == $_SESSION['ops'.$n][3]){ // If the opponent's attack is the same type as itself
			$opmultn = 1.5; // return STAB
		}
		else {
			$opmultn = 1; // return standard damage
		}
		$h = $_SESSION['ops'.$n][4] / 30; // Opponent's level divided by 30
		$hh = $_SESSION['attack_short'][5] / 2; // Attack power divided by 2
		$y = $hittinge; // Opponent attack type
		$g = $_SESSION['s'.$u][2]; // Your pokemon type 1
		$f = $_SESSION['s'.$u][3]; // Your Pokemon type 2
		$damages2 = convert("$y", "$g", "$f"); // use type chart to get weakness / resistances
		if(strstr($_SESSION['ops'.$n][0],'Dark ') || strstr($_SESSION['s'.$u][0],'Metallic ')){ // If your opponent is dar of you are metallic
			$d_a = 1; // standard damage set
			if(strstr($_SESSION['s'.$u][0],'Metallic ')){ // If your pokemon is Metallic
				$d_a = $d_a - 0.25; // 25% defence boost
			}
			if(strstr($_SESSION['ops'.$n][0],'Dark ')){ // if your opponent is Dark
				$d_a = $d_a + 0.25; // 25% attack boost
			}
			$h2 = $h * $hh; // lvl / 30 * atkpwr / 2
			$h3 = $h2 * $d_a; // lvl / 30 * atkpwr / 2 * dmg-multiplier
			$h4 = $h3 * $damages2; // lvl / 30 * atkpwr / 2 * dmg-multiplier * type-markup
			$hhh = round($h4 * $opmultn); // round to the nearest whole number(lvl/30*atkpwr/2*dmg-multipolier*type-markup*STAB)
		} // end dark and metallic damage
		
		
		else { // standard pokemon damage
			// Critical hit chance --- 6.25%
			$crit = rand(1,16);
			if($crit == '1'){
				$d_a = 1.5;
			}
			else{
				$d_a = 1;
			}
			$h2 = $h * $hh; // lvl / 30 * atkpwr / 2
			$h3 = $h2 * $d_a; // lvl / 30 * atkpwr / 2 * dmg-multiplier
			$h4 = $h3 * $damages2; // lvl / 30 * atkpwr / 2 * dmg-muliplier * type-markup
			$hhh = round($h4 * $opmultn); // rouns to the nearest whole number(lvl / 30 * atkpwr / 2 * dmg-multiplier * type-markup * STAB)
		}
		if(strstr($_SESSION['ops'.$n][0],'Mystic')){ // If your opponent is Mysitc
			$ran = rand(1,4);
			if($ran == 2){ // 1 in 4 chance of your Pokemon being scared
				$you_scared = 2;
				$www = 0; // damage to opponent cancelled
			}
		}
		if(strstr($_SESSION['s'.$u][0],'Mystic')){ // If your Pokemon is Mystic
			$rand = rand(1,4);
			if($rand == 2){ // 1 in 4 chance of opponent Pokemon being scared
				$op_scared = 2;
				$hhh = 0; // damage to you cancelled
			}
		}
		if($_SESSION['attack_short'][6] == '95'){ // If opponents attack accuracy is 95
			$acc = rand(1,100);
			if($acc > 95){ // 95 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '90'){ // If opponents attack accuracy is 90
			$acc = rand(1,100);
			if($acc > 90){ // 90 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '85'){ // If opponents attack accuracy is 85
			$acc = rand(1,100);
			if($acc > 85){ // 85 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '80'){ // If opponents attack accuracy is 80
			$acc = rand(1,100);
			if($acc > 80){ // 80 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '75'){ // If opponents attack accuracy is 75
			$acc = rand(1,100);
			if($acc > 75){ // 75 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '70'){ // If opponents attack accuracy is 70
			$acc = rand(1,100);
			if($acc > 70){ // 70 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '60'){ // If Opponents attack accuracy is 60
			$acc = rand(1,100);
			if($acc > 60){ // 60 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '55'){ // If opponents attack accuracy is 55
			$acc = rand(1,100);
			if($acc > 55){ // 55 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '50'){ // If opponents attack accuracy is 50
			$acc = rand(1,100);
			if($acc > 50){ // 50 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] == '30'){ // If opponents attack accuracy is 30
			$acc = rand(1,100);
			if($acc > 30){ // 30 in 100 chance of hitting
				$op_missed = 1;
				$you_scared = 0; // Accuracy overrides Mystic's scare
				$hhh = 0;
			}
		}
		//------------------Opponents Transform and Sketch attacks-------------------//
		if(!$op_missed){
			if($oattack == 'Transform'){
				$_SESSION['ops'.$n][0] = $_SESSION['s'.$u][0]; // Change your Pokemon name to the opponents
				$_SESSION['ops'.$n][2] = $_SESSION['s'.$u][2]; // Change your Pokemon type 1 to the opponents
				$_SESSION['ops'.$n][3] = $_SESSION['s'.$u][3]; // Change your Pokemon type 2 to the opponents
				$_SESSION['ops'.$n][6] = $_SESSION['s'.$u][6]; // Change your Pokemon attack 1 to the opponents
				$_SESSION['ops'.$n][7] = $_SESSION['s'.$u][7]; // Change your Pokemon attack 2 to the opponents
				$_SESSION['ops'.$n][8] = $_SESSION['s'.$u][8]; // Change your Pokemon attack 3 to the opponents
				$_SESSION['ops'.$n][9] = $_SESSION['s'.$u][9]; // Change your Pokemon attack 4 to the opponents
			}
			if($oattack == 'Sketch'){
				$_SESSION['ops'.$n][$tu] = $_SESSION['attack_short'][0];
			}
		}		
		//----------------Opponent inflicting a status effect on you--------------------//
		
		if(!$_SESSION['s'.$u][14] && !$op_missed && !$op_scared){ // Make sure there isn't already a status effect in play and the opponent didn't miss
		
		//--------------------------BURN------------------------//
		
			// Attacks with 10% chance to burn
			if($oattack == 'Blaze Kick' || $oattack == 'Blue Flare' || $oattack == 'Ember' || $oattack == 'Fire Blast' || $oattack == 'Fire Fang' || $oattack == 'Fire Punch' || $oattack == 'Flame Wheel' || $oattack == 'Flamethrower' || $oattack == 'Heat Wave' || $oattack == 'Ice Burn' || $oattack == 'Searing Shot'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Don't burn
				}
				else{
					$brn = rand(1,10);
					if($brn == '1'){
						$_SESSION['s'.$u][14] = Burn;
					}
				}
			}
			// Attacks with 30% chance to burn
			if($oattack == 'Lava Plume' || $oattack == 'Scald'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Insert Statement
				}
				else{
					$brn = rand(1,10);
					if($brn < 4){
						$_SESSION['s'.$u][14] = Burn;
					}
				}
			}
			// Attacks with 50% chance to burn
			if($oattack == 'Sacred Fire'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Insert statement
				}
				else{
					$brn = rand(1,2);
					if($brn == '1'){
						$_SESSION['s'.$u][14] = Burn;
					}
				}
			}
			// Attacks with 100% chance to burn
			if($oattack == 'Will-O-Wisp' || $oattack == 'Inferno'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Insert statement
				}
				else{
					$_SESSION['s'.$u][14] = Burn;
				}
			}
			
			//---------------------FREEZE------------------//
			
			// Attacks with 10% chance to freeze
			if($oattack == 'Blizzard' || $oattack == 'Freeze-Dry' || $oattack == 'Ice Beam' || $oattack == 'Ice Fang' || $oattack == 'Ice Punch' || $oattack == 'Powder Snow' ){
				if($_SESSION['s'.$u][2] == 'Ice' || $_SESSION['s'.$u][3] == 'Ice'){
					// Insert statement
				}
				else{
					$frz = rand(1,10);
					if($frz == '1'){
						$_SESSION['s'.$u][14] = Frozen;
					}
				}
			}
			
			//-----------------PARALYSIS-----------------//
			
			// Attacks with 10% chance to paralyze
			if($oattack == 'Bolt Strike' || $oattack == 'Freeze Shock' || $oattack == 'Thunder Fang' || $oattack == 'Thunderbolt' || $oattack == 'Thunderpunch' || $oattack == 'Thundershock'){
				if($_SESSION['s'.$u][2] == 'Electric' || $_SESSION['s'.$u][3] == 'Electric'){
					// Insert statement
				}
				else{
					$par = rand(1,10);
					if($par == '1'){
						$_SESSION['s'.$u][14] = Paralyzed;
					}
				}
			}
			// Attacks with 30% chance to paralyze
			if($oattack == 'Body Slam' || $oattack == 'Bounce' || $oattack == 'Discharge' || $oattack == 'Force Palm' || $oattack == 'Lick' || $oattack == 'Spark' || $oattack == 'Thunder'){
				if($_SESSION['s'.$u][2] == 'Electric' || $_SESSION['s'.$u][3] == 'Electric'){
					//Insert statement
				}
				else{
					$par = rand(1,10);
					if($par < 4){
						$_SESSION['s'.$u][14] = Paralyzed;
					}
				}
			}
			// Attacks wih 100% chance to paralyze
			if($oattack == 'Glare' || $oattack == 'Nuzzle' || $oattack == 'Stun Spore' || $oattack == 'Thunder Wave' || $oattack == 'Zap Cannon'){
				if($_SESSION['s'.$u][2] == 'Electric' || $_SESSION['s'.$u][3] == 'Electric'){
					// Insert Statement
				}
				else{
					$_SESSION['s'.$u][14] = Paralyzed;
				}
			}
			
			//----------------POISON----------------//
			
			// Attacks with 10% chance of poison
			if($oattack == 'Cross Poison' || $oattack == 'Poison Tail' || $oattack == 'Sludge Wave'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn == '1'){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 20% chance of poison
			if($oattack == 'Twineedle'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn < 3){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 30% chance of poison
			if($oattack == 'Gunk Shot' || $oattack == 'Poison Jab' || $oattack == 'Poison Sting' || $oattack == 'Sludge' || $oattack == 'Sludge Bomb'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
					$psn = rand(1,10);
					if($psn < 4){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 40% chance to poison
			if($oattack == 'Smog'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn < 5){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 100% chance to poison
			if($oattack == 'Toxic Spikes' || $oattack == 'Poison Powder' || $oattack == 'Poison Gas'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$_SESSION['s'.$u][14] = Poison;
				}
			}
			
			//--------------SLEEP----------------------//
			
			// Attacks with 30% chance to sleep
			if($oattack == 'Relic Song'){
				// Add a check here for sleep immunity
				$slp = rand(1,10);
				if($slp < 4){
					$_SESSION['s'.$u][14] = Sleep;
				}
			}
			// Attacks with 100% chance to sleep
			if($oattack == 'Dark Void' || $oattack == 'Grasswhistle' || $oattack == 'Hypnosis' || $oattack == 'Lovely Kiss' || $oattack == 'Sing' || $oattack == 'Sleep Powder' || $oattack == 'Spore' || $oattack == 'Yawn'){
				// Add a check here for sleep immunity
				$_SESSION['s'.$u][14] = Sleep;
			}
			
			//------------------CONFUSION------------------//
			
			// Attacks with 10% to confuse
			if($oattack == 'Confusion' || $oattack == 'Hurricane' || $oattack == 'Psybeam' || $oattack == 'Signal Beam'){
				// Add a check here for confusion immunity
				$conf = rand(1,10);
				if($conf == '1'){
					$_SESSION['s'.$u][14] = Confused;
				}
			}
			
			//---------------BADLY POISONED------------------//
			
			// Attacks with 30% chance to badly poison
			if($oattack == 'Poison Fang'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$bpsn = rand(1,10);
					if($bpsn < 4){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 100% chance to badly poison
			if($_SESSION['attack_short'][3] == 'Toxic' || $_SESSION['attack_short'][3] == 'Toxic Spikes'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$_SESSION['s'.$u][14] = Poison;
				}
			}
				
//---------------------------Status effect damages----------------------------------------------//
// Only Poison and Burn are needed when you use an item since they're the only ones that do damage unless you're attacking //

		}
		if($_SESSION['s'.$u][14] == 'Poison'){ // If your Pokemon is Poisoned
			$percentage = 12;
			$maxhp = $_SESSION['s'.$u][11];
			$damg_u = ($percent / 100) * $maxhp;
			$state = "was hurt by it's poisoning.";
		}
		if($_SESSION['s'.$u][14] == 'Burn'){ // If your Pokemon is Burned
			$percent = 12;
			$maxhp = $_SESSION['s'.$u][11];
			$damg_u = ($percent / 100) * $maxhp;
			$state = "was hurt by it's burn.";
		}
		if($_SESSION['s'.$u][14] == 'Sleep'){ // If your Pokemon is asleep
			$sl_wake = rand(1,4);
			if($sl_wake == 1){
				unset($_SESSION['s'.$u][14]);
			}
		}
		if($_SESSION['s'.$u][14] == 'Frozen'){ // If your Pokemon is frozen
			$thaw = rand(1,4);
			if($thaw == 1){
				unset($_SESSION['s'.$u][14]);
			}
		}
			
		$_SESSION['s'.$u][10] = $_SESSION['s'.$u][10] - $hhh - round($damg_u); // Your pokemon's HP minus final damage
		
		$i_u = $_POST['item']; // Item conditions
		switch($i_u){
			case "Potion":
			$item_statement = "Your Pok&eacute;mon regained 20 HP.";
			$_SESSION['s'.$u][10] += 20; // HP session + 20
			mysql_query("UPDATE items SET Potion = Potion - 1 WHERE uid = '{$_SESSION['myid']}'");
			break;
			case "Super Potion":
			$item_statement = "Your Pok&eacute;mon regained 100 HP.";
			$_SESSION['s'.$u][10] += 100; // HP SESSION + 100
			mysql_query("UPDATE items SET Super_Potion = Super_Potion - 1 WHERE uid = '{$_SESSION['myid']}'");
			break;
			case "Hyper Potion":
			$item_statement = "Your Pok&eacute;mon regained 250 HP.";
			$_SESSION['s'.$u][10] += 250; // HP SESSION + 250
			mysql_query("UPDATE items SET Hyper_Potion = Hyper_Potion - 1 WHERE uid = '{$_SESSION['myid']}'");
			break;
			case "Full Heal":
			if($_SESSION['s'.$u][14] == 'Sleep' || $_SESSION['s'.$u][14] == 'Poison' || $_SESSION['s'.$u][14] == 'Burn' || $_SESSION['s'.$u][14] == 'Frozen' || $_SESSION['s'.$u][14] == 'Paralyzed'){
				unset($_SESSION['s'.$u][14]);
				mysql_query("UPDATE items SET Full_Heal = Full_Heal - 1 WHERE uid = '{$_SESSION['myid']}'");
				$item_statement = "Your Pok&eacute;mon has been healed of it's status affliction.";
				// Remove the status effect in play
			}
			else{
				$item_statement = "The full heal had no effect.";
			}
			break;
			case "Awakening":
			if($_SESSION['s'.$u][14] == 'Sleep'){
				unset($_SESSION['s'.$u][14]);
				mysql_query("UPDATE items SET Awakening = Awakening - 1 WHERE uid = '{$_SESSION['myid']}'");
				$item_statement = "Your Pok&eacute;mon has woke up.";
			}
			else{
				$item_statement = "The awakening had no effect.";
			}
			break;
			case "Paralyze Heal":
			if($_SESSION['s'.$u][14] == 'Paralyzed'){
				unset($_SESSION['s'.$u][14]);
				mysql_query("UPDATE items SET Parlyz_Heal = Parlyz_Heal - 1 WHERE uid = '{$_SESSION['myid']}'");
				$item_statement = "Your Pok&eacute;mon has been healed of it's paralysis.";
			}
			else{
				$item_statement = "The paralyze heal had no effect.";
			}
			break;
			case "Antidote":
			if($_SESSION['s'.$u][14] == 'Poison'){
				unset($_SESSION['s'.$u][14]);
				mysql_query("UPDATE items SET Antidote = Antidote - 1 WHERE uid = '{$_SESSION['myid']}'");
				$item_statement = "Your Pok&eacute;mon has been healed of it's poison.";
			}
			else{
				$item_statement = "The antidote had no effect";
			}
			break;
			case "Burn Heal":
			if($_SESSION['s'.$u][14] == 'Burn'){
				unset($_SESSION['s'.$u][14]);
				mysql_query("UPDATE items SET Burn_Heal = Burn_Heal - 1 WHERE uid = '{$_SESSION['myid']}'");
				$item_statement = "Your Pok&eacute;mon has been healed of it's burn.";
			}
			else{
				$item_statement = "The burn heal had no effect";
			}
			break;
			case "Ice Heal":
			if($_SESSION['s'.$u][14] == 'Frozen'){
				unset($_SESSION['s'.$u][14]);
				mysql_query("UPDATE items SET Ice_Heal = Ice_Heal - 1 WHERE uid = '{$_SESSION['myid']}'");
				$item_statement = "Your Pok&eacute;mon has been defrosted.";
			}
			else{
				$item_statement = "The ice heal had no effect";
			}
			break;
		}
		if($_SESSION['s'.$u][10] > $_SESSION['s'.$u][11]){ // If your pokemon's HP is over it's max HP
			$_SESSION['s'.$u][10] = $_SESSION['s'.$u][11]; // Set the HP to it's max
		}
		if($_SESSION['s'.$u][10] < 0){ // If Pokemon's HP is 0 or lower
			$_SESSION['s'.$u][10] = 0; // Set the Pokemon's HP to 0
		}
	}
	
	//----------------------------------------------YOU AND AN OPPONENT ATTACKS---------------------------------------------//
	
	if($_POST['attack']){
		$rat = mysql_real_escape_string($_POST['attack']);

		$u = $_SESSION['y_p'][0];
		$n = $_SESSION['y_p'][1];
		$rat = $rat + 5;
		$attack = $_SESSION['s'.$u][$rat]; // Attack you used
		$_SESSION['s'.$u][13] = 1;
		if($attack == $_SESSION['attack_short'][0]){
			$hittinga = $_SESSION['attack_short'][0]; // Your Attack name
			$hittingb = $_SESSION['attack_short'][1]; // Your attack type
			$hittingc = $_SESSION['attack_short'][2]; // Your attack power
			$hittingh = $_SESSION['attack_short'][7]; // Your attack accuracy
			$categoryb = $_SESSION['attack_short'][9]; // Your attack category
		}

		$tu = rand(1,4);
		$tu = $tu + 5;
		$oattack = $_SESSION['ops'.$n][$tu]; // Opponents attack
		if($oattack == $_SESSION['attack_short'][3]){
			$hittingd = $_SESSION['attack_short'][3]; // Opponents attack name
			$hittinge = $_SESSION['attack_short'][4]; // Opponents attack type
			$hittingf = $_SESSION['attack_short'][5]; // Opponents attack power
			$hittingg = $_SESSION['attack_short'][6]; // Opponents attack accuracy
			$categorya = $_SESSION['attack_short'][8]; // Opponents attack category
		}

		if($attack != $_SESSION['attack_short'][0] || !$_SESSION['attack_short'][0]){ // Your attack session not set
			$r_u = mysql_fetch_array(mysql_query("SELECT * FROM attacks WHERE attack = '$attack'")); // Get attack
			$hittinga = $r_u['attack'];
			$hittingb = $r_u['type'];
			$hittingc = $r_u['power'];
			$hittingh = $r_u['accuracy'];
			$categoryb = $r_u['category'];
			$_SESSION['attack_short'][0] = $hittinga; // Your attack name session
			$_SESSION['attack_short'][1] = $hittingb; // Your attack type session
			$_SESSION['attack_short'][2] = $hittingc; // Your attack power session
			$_SESSION['attack_short'][7] = $hittingh; // Your attack accuracy session
			$_SESSION['attack_short'][9] = $categoryb; // Your attack category session
		}
		if($oattack != $_SESSION['attack_short'][3] || !$_SESSION['attack_short'][3]){ // Opponents attack session not set
			$r_a = mysql_fetch_array(mysql_query("SELECT * FROM attacks WHERE attack = '$oattack'")); // Get attack
			$hittingd = $r_a['attack'];
			$hittinge = $r_a['type'];
			$hittingf = $r_a['power'];
			$hittingg = $r_a['accuracy'];
			$categorya = $r_a['category'];
			$_SESSION['attack_short'][3] = $hittingd; // Opponents attack name session
			$_SESSION['attack_short'][4] = $hittinge; // Opponents attack type session
			$_SESSION['attack_short'][5] = $hittingf; // Opponents attack power session
			$_SESSION['attack_short'][6] = $hittingg; // Opponents attack accuracy session
			$_SESSION['attack_short'][8] = $categorya; // Opponents attack category session
		}
		if($hittingb == $_SESSION['s'.$u][2] || $hittingb == $_SESSION['s'.$u][3] ){ // If your Pokemon shares type with the attack
			$multn = 1.5; // STAB
		}
		else {
			$multn = 1; // Standard damage multiplier
		}
		if($hittinge == $_SESSION['ops'.$n][2] || $hittinge == $_SESSION['ops'.$n][3] ){ // If your opponent shares type with the attack
			$opmultn = 1.5; // Opponent STAB
		}
		else {
			$opmultn = 1; // Opponent Standard damage multiplier
		}

		$w = $_SESSION['s'.$u][4] / 30; // Your pokemon's level divided by 30
		$ww = $_SESSION['attack_short'][2] / 2; // Your attack power divided by 2
		$y = $_SESSION['attack_short'][1]; // Your attack type
		$g = $_SESSION['ops'.$n][2]; // Opponents Pokemon type 1
		$f = $_SESSION['ops'.$n][3]; // Opponents Pokemon type 2
		$damages = convert("$y", "$g", "$f"); // Get type markup
		if(strstr($_SESSION['s'.$u][0],'Dark ') || strstr($_SESSION['ops'.$n][0],'Metallic ')){ // If your Pokemon is Dark or opponent is Metallic
			$d_a = 1; // Standard damage multiplier
			if(strstr($_SESSION['ops'.$n][0],'Metallic ')){ // If opponent is Metallic
				$d_a = $d_a - 0.25; // 25% defence boost
			}
			if(strstr($_SESSION['s'.$u][0],'Dark ')){ // If your Pokemon is Dark
				$d_a = $d_a + 0.25; // 25% Attack boost
			} // work out final damage to opponent
			$w2 = $w * $ww; // lvl / 30 * atkpwr / 2
			$w3 = $w2 * $d_a; // lvl / 30 * atkpwr / 2 * dmg-multiplier
			$w4 = $w3 * $damages; // lvl / 30 * atkpwr / 2 * dmg-multiplier * type-markup
			$www = round($w4 * $multn); // round to nearest whole number(lvl / 30 * atkpwr / 2 * dmg-multiplier * type-markup * STAB)
		} // End if metallic or dark
		else { // non dark/metallic final damage
		
			// Critical hit chance --- 6.25%
			$crit = rand(1,16);
			if($crit == 1){
				$d_a = 1.5;
			}
			else{
				$d_a = 1;
			}
			$w2 = $w * $ww; // lvl / 30 * atkpwr / 2
			$w3 = $w2 * $d_a; // lvl / 30 * atkpwr / 2 * dmg-multiplier
			$w4 = $w3 * $damages; // lvl / 30 * atkpwr / 2 * dmg-multiplier * type-markup
			$www = round($w4 * $multn); // round to nearest whole number(lvl / 30 * atkpwr / 2 * type-markup * STAB)
		}

		$h = $_SESSION['ops'.$n][4] / 30; // Opponents level divided by 30
		$hh = $_SESSION['attack_short'][5] / 2; // Opponents attack power divided by 2
		$qw = $_SESSION['attack_short'][4]; // Opponents attack type
		$wew = $_SESSION['s'.$u][2]; // Your Pokemon type 1
		$efe = $_SESSION['s'.$u][3]; // Your Pokemon type 2
		$damages2 = convert("$qw", "$wew", "$efe"); // Get type-markup
		if(strstr($_SESSION['ops'.$n][0],'Dark ') || strstr($_SESSION['s'.$u][0],'Metallic ')){ // If your Pokemon is Metallic or opponent is Dark
			$d_a = 1; // Standard multiplier
			if(strstr($_SESSION['s'.$u][0],'Metallic ')){ // If your Pokemon is Metallic
				$d_a = $d_a - 0.25; // 25% defence boost
			}
			if(strstr($_SESSION['ops'.$n][0],'Dark ')){ // If opponent is Dark
				$d_a = $d_a + 0.25; // 25% Attack boost
			}
			// work out final damage to your Pokemon
			$h2 = $h * $hh; // lvl / 30 * atkpwr / 2
			$h3 = $h2 * $d_a; // lvl / 30 * atkpwr / 2 * dmg-multiplier
			$h4 = $h3 * $damages2; // lvl / 30 * atkpwr / 2 * dmg-muliplier * type-markup
			$hhh = round($h4 * $opmultn); // round to nearest whole number(lvl / 30 * atkpwr / 2 * dmg-multiplier * type-markup * STAB)
		} // End if metallic or dark
		else { // non dark/metallic final damage
		
			// Critical hit chance --- 6.25%
			$crit = rand(1,16);
			if($crit == 1){
				$d_a = 1.5;
			}
			else{
				$d_a = 1;
			}
			$h2 = $h * $hh; // lvl / 30 * atkpwr / 2
			$h3 = $h2 * $d_a; // lvl / 30 * atkpwr / 2 * dmg-multiplier
			$h4 = $h3 * $damages2; // lvl / 30 * atkpwr / 2 * dmg-multiplier * type-markup
			$hhh = round($h4 * $opmultn); // round to nearest whole number(lvl / 30 * atkpwr / 2 * type-markup * STAB)
		}

		if(strstr($_SESSION['ops'.$n][0],'Mystic')){ // If opponent is mystic
			$ran = rand(1,4);
			if($ran == 2){ // 1 in 4 chance of being scared
				$you_scared = 2;
				$www = 0;
			}
		}
		if(strstr($_SESSION['s'.$u][0],'Mystic')){ // If your Pokemon is mystic
			$rand = rand(1,4);
			if($rand == 2){ // 1 in 4 chance of scaring opponent
				$op_scared = 2;
				$hhh = 0;
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '95'){ // If attack accuracy is 95
			if($_SESSION['attack_short'][6] == '95'){ // If opponents attack accuracy is 95
				$acc = rand(1,100);
				if($acc > 95){ // 95 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '95'){ // If your attack accuracy is 95
				$acc = rand(1,100);
				if($acc > 95){ // 95 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '90'){ // If attack accuracy is 90
			if($_SESSION['attack_short'][6] == '90'){ // If opponents attack accuracy is 90
				$acc = rand(1,100);
				if($acc > 90){ // 90 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '90'){ // If your attack accuracy is 90
				$acc = rand(1,100);
				if($acc > 90){ // 90 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '85'){ // If attack accuracy is 85
			if($_SESSION['attack_short'][6] == '85'){ // if opponents attack accuracy is 85
				$acc = rand(1,100);
				if($acc > 85){ // 85 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '85'){ // If your attack accuracy is 85
				$acc = rand(1,100);
				if($acc > 85){ // 85 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '80'){ // If attack acuracy is 80
			if($_SESSION['attack_short'][6] == '80'){ // If opponents attack accuracy is 80
				$acc = rand(1,100);
				if($acc > 80){ // 80 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '80'){ // If your attack accuracy is 80
				$acc = rand(1,100);
				if($acc > 80){ // 80 in 10 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '75'){ // If attack accuracy is 75
			if($_SESSION['attack_short'][6] == '75'){ // If opponents attack accuracy is 75
				$acc = rand(1,100);
				if($acc > 75){ // 75 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '75'){ // If your attack accuracy is 75
				$acc = rand(1,100);
				if($acc > 75){ // 75 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '70'){ // If attack accuracy is 70
			if($_SESSION['attack_short'][6] == '70'){ // If opponents attack accuracy is 70
				$acc = rand(1,100);
				if($acc > 70){ // 70 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '70'){ // If your attack accuracy is 70
				$acc = rand(1,100);
				if($acc > 70){ // 70 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '60'){ // If attack accuracy is 60
			if($_SESSION['attack_short'][6] == '60'){ // If opponents attack accuracy is 60
				$acc = rand(1,100);
				if($acc > 60){ // 60 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '60'){ // If your attack accuracy is 60
				$acc = rand(1,100);
				if($acc > 60){ // 60 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '55'){ // If attack accuracy is 55
			if($_SESSION['attack_short'][6] == '55'){ // If opponents attack accuracy is 55
				$acc = rand(1,100);
				if($acc > 55){ // 55 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '55'){ // If your attack accuracy is 55
				$acc = rand(1,100);
				if($acc > 55){ // 55 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '50'){ // If attack accuracy is 50
			if($_SESSION['attack_short'][6] == '50'){ // If opponents attack accuracy is 50
				$acc = rand(1,100);
				if($acc > 50){ // 50 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '50'){ // If your attack accuracy is 50
				$acc = rand(1,100);
				if($acc > 50){ // 50 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		if($_SESSION['attack_short'][6] || $_SESSION['attack_short'][7] == '30'){ // If attack accuracy is 30
			if($_SESSION['attack_short'][6] == '30'){ // If opponents attack accuracy is 30
				$acc = rand(1,100);
				if($acc > 30){ // 30 in 100 chance of hitting
					$op_missed = 1;
					$hhh = 0;
				}
			}
			if($_SESSION['attack_short'][7] == '30'){ // If your attack accuracy is 30
				$acc = rand(1,100);
				if($acc > 30){ // 30 in 100 chance of hitting
					$u_missed = 1;
					$www = 0;
				}
			}
		}
		//-----------------Opponents Transform and Sketch attacks-------------------//
		if(!$op_missed){
			if($oattack == 'Transform'){
				$_SESSION['ops'.$n][0] = $_SESSION['s'.$u][0]; // Change your Pokemon name to the opponents
				$_SESSION['ops'.$n][2] = $_SESSION['s'.$u][2]; // Change your Pokemon type 1 to the opponents
				$_SESSION['ops'.$n][3] = $_SESSION['s'.$u][3]; // Change your Pokemon type 2 to the opponents
				$_SESSION['ops'.$n][6] = $_SESSION['s'.$u][6]; // Change your Pokemon attack 1 to the opponents
				$_SESSION['ops'.$n][7] = $_SESSION['s'.$u][7]; // Change your Pokemon attack 2 to the opponents
				$_SESSION['ops'.$n][8] = $_SESSION['s'.$u][8]; // Change your Pokemon attack 3 to the opponents
				$_SESSION['ops'.$n][9] = $_SESSION['s'.$u][9]; // Change your Pokemon attack 4 to the opponents
			}
			if($oattack == 'Sketch'){
				$_SESSION['ops'.$n][$tu] = $_SESSION['s'.$u][$rat];
			}
		}
		//----------------Opponent inflicting a status effect on you--------------------//
		
		if(!$_SESSION['s'.$u][14] && !$op_missed && !$op_scared){ // Make sure there isn't already a status effect in play and the opponent didn't miss
		
		//--------------------------BURN------------------------//
		
			// Attacks with 10% chance to burn
			if($oattack == 'Blaze Kick' || $oattack == 'Blue Flare' || $oattack == 'Ember' || $oattack == 'Fire Blast' || $oattack == 'Fire Fang' || $oattack == 'Fire Punch' || $oattack == 'Flame Wheel' || $oattack == 'Flamethrower' || $oattack == 'Heat Wave' || $oattack == 'Ice Burn' || $oattack == 'Searing Shot'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Insert statement
				}
				else{
					$brn = rand(1,10);
					if($brn == '1'){
						$_SESSION['s'.$u][14] = Burn;
					}
				}
			}
			// Attacks with 30% chance to burn
			if($oattack == 'Lava Plume' || $oattack == 'Scald'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Insert statement
				}
				else{
					$brn = rand(1,10);
					if($brn < 4){
						$_SESSION['s'.$u][14] = Burn;
					}
				}
			}
			// Attacks with 50% chance to burn
			if($oattack == 'Sacred Fire'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Insert statement
				}
				else{
					$brn = rand(1,2);
					if($brn == '1'){
						$_SESSION['s'.$u][14] = Burn;
					}
				}
			}
			// Attacks with 100% chance to burn
			if($oattack == 'Will-O-Wisp' || $oattack == 'Inferno'){
				if($_SESSION['s'.$u][2] == 'Fire' || $_SESSION['s'.$u][3] == 'Fire'){
					// Insert statement
				}
				else{
					$_SESSION['s'.$u][14] = Burn;
				}
			}
			
			//---------------------FREEZE------------------//
			
			// Attacks with 10% chance to freeze
			if($oattack == 'Blizzard' || $oattack == 'Freeze-Dry' || $oattack == 'Ice Beam' || $oattack == 'Ice Fang' || $oattack == 'Ice Punch' || $oattack == 'Powder Snow' ){
				if($_SESSION['s'.$u][2] == 'Ice' || $_SESSION['s'.$u][3] == 'Ice'){
					// Insert statement
				}
				else{
					$frz = rand(1,10);
					if($frz == '1'){
						$_SESSION['s'.$u][14] = Frozen;
					}
				}
			}
			
			//-----------------PARALYSIS-----------------//
			
			// Attacks with 10% chance to paralyze
			if($oattack == 'Bolt Strike' || $oattack == 'Freeze Shock' || $oattack == 'Thunder Fang' || $oattack == 'Thunderbolt' || $oattack == 'Thunderpunch' || $oattack == 'Thundershock'){
				if($_SESSION['s'.$u][2] == 'Electric' || $_SESSION['s'.$u][3] == 'Electric'){
					// Insert statement
				}
				else{
					$par = rand(1,10);
					if($par == '1'){
						$_SESSION['s'.$u][14] = Paralyzed;
					}
				}
			}
			// Attacks with 30% chance to paralyze
			if($oattack == 'Body Slam' || $oattack == 'Bounce' || $oattack == 'Discharge' || $oattack == 'Force Palm' || $oattack == 'Lick' || $oattack == 'Spark' || $oattack == 'Thunder'){
				if($_SESSION['s'.$u][2] == 'Electric' || $_SESSION['s'.$u][3] == 'Electric'){
					// Insert statement
				}
				else{
					$par = rand(1,10);
					if($par < 4){
						$_SESSION['s'.$u][14] = Paralyzed;
					}
				}
			}
			// Attacks wih 100% chance to paralyze
			if($oattack == 'Glare' || $oattack == 'Nuzzle' || $oattack == 'Stun Spore' || $oattack == 'Thunder Wave' || $oattack == 'Zap Cannon'){
				if($_SESSION['s'.$u][2] == 'Electric' || $_SESSION['s'.$u][3] == 'Electric'){
					// Insert statement
				}
				else{
					$_SESSION['s'.$u][14] = Paralyzed;
				}
			}
			
			//----------------POISON----------------//
			
			// Attacks with 10% chance of poison
			if($oattack == 'Cross Poison' || $oattack == 'Poison Tail' || $oattack == 'Sludge Wave'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn == '1'){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 20% chance of poison
			if($oattack == 'Twineedle'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert stetement
				}
				else{
					$psn = rand(1,10);
					if($psn < 3){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 30% chance of poison
			if($oattack == 'Gunk Shot' || $oattack == 'Poison Jab' || $oattack == 'Poison Sting' || $oattack == 'Sludge' || $oattack == 'Sludge Bomb'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn < 4){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 40% chance to poison
			if($oattack == 'Smog'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn < 5){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 100% chance to poison
			if($oattack == 'Toxic Spikes' || $oattack == 'Poison Powder' || $oattack == 'Poison Gas'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$_SESSION['s'.$u][14] = Poison;
				}
			}
			
			//--------------SLEEP----------------------//
			
			// Attacks with 30% chance to sleep
			if($oattack == 'Relic Song'){
				// Add a check here for sleep immunity
				$slp = rand(1,10);
				if($slp < 4){
					$_SESSION['s'.$u][14] = Sleep;
					$u_sleep = 1;
				}
			}
			// Attacks with 100% chance to sleep
			if($oattack == 'Dark Void' || $oattack == 'Grasswhistle' || $oattack == 'Hypnosis' || $oattack == 'Lovely Kiss' || $oattack == 'Sing' || $oattack == 'Sleep Powder' || $oattack == 'Spore' || $oattack == 'Yawn'){
				// Add a check here for sleep immunity
				$_SESSION['s'.$u][14] = Sleep;
				$u_sleep = 1;
			}
			
			//------------------CONFUSION------------------//
			
			// Attacks with 10% to confuse
			if($oattack == 'Confusion' || $oattack == 'Hurricane' || $oattack == 'Psybeam' || $oattack == 'Signal Beam'){
				// Add a check here for confusion immunity
				$conf = rand(1,10);
				if($conf == '1'){
					$_SESSION['s'.$u][14] = Confused;
				}
			}
			
			//---------------BADLY POISONED------------------//
			
			// Attacks with 30% chance to badly poison
			if($oattack == 'Poison Fang'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$bpsn = rand(1,10);
					if($bpsn < 4){
						$_SESSION['s'.$u][14] = Poison;
					}
				}
			}
			// Attacks with 100% chance to badly poison
			if($_SESSION['attack_short'][3] == 'Toxic' || $_SESSION['attack_short'][3] == 'Toxic Spikes'){
				if($_SESSION['s'.$u][2] == 'Poison' || $_SESSION['s'.$u][3] == 'Poison' || $_SESSION['s'.$u][2] == 'Steel' || $_SESSION['s'.$u][3] == 'Steel'){
					// Insert statement
				}
				else{
					$_SESSION['s'.$u][14] = Poison;
				}
			}
			
		} // End opponent inflicting status effect on you
		
		//------------------------------------------- Your transform and sketch attacks--------------------------------------//
		
		if(!$u_missed){
			if($attack == 'Transform'){
				$_SESSION['s'.$u][0] = $_SESSION['ops'.$n][0]; // Change your Pokemon name to the opponents
				$_SESSION['s'.$u][2] = $_SESSION['ops'.$n][2]; // Change your Pokemon type 1 to the opponents
				$_SESSION['s'.$u][3] = $_SESSION['ops'.$n][3]; // Change your Pokemon type 2 to the opponents
				$_SESSION['s'.$u][6] = $_SESSION['ops'.$n][6]; // Change your Pokemon attack 1 to the opponents
				$_SESSION['s'.$u][7] = $_SESSION['ops'.$n][7]; // Change your Pokemon attack 2 to the opponents
				$_SESSION['s'.$u][8] = $_SESSION['ops'.$n][8]; // Change your Pokemon attack 3 to the opponents
				$_SESSION['s'.$u][9] = $_SESSION['ops'.$n][9]; // Change your Pokemon attack 4 to the opponents
			}
			if($attack == 'Sketch'){
				$_SESSION['s'.$u][$rat] = $_SESSION['ops'.$n][$tu];
			}
		}
		
		//-------------------You inflicting a status effect on the opponent------------------------//
		
		if(!$_SESSION['ops'.$n][14] && !$u_missed && !$u_scared && !$u_sleep){ // Make sure there isn't a status effect in play and you didn't miss, not scares and not asleep
		
		//--------------------------BURN------------------------//
		
			// Attacks with 10% chance to burn
			if($attack == 'Blaze Kick' || $attack == 'Blue Flare' || $attack == 'Ember' || $attack == 'Fire Blast' || $attack == 'Fire Fang' || $attack == 'Fire Punch' || $attack == 'Flame Wheel' || $attack == 'Flamethrower' || $attack == 'Heat Wave' || $attack == 'Ice Burn' || $attack == 'Searing Shot'){
				if($_SESSION['ops'.$n][2] == 'Fire' || $_SESSION['ops'.$n][3] == 'Fire'){
					// Insert statement
				}
				else{
					$brn = rand(1,10);
					if($brn == '1'){
						$_SESSION['ops'.$n][14] = Burn;
					}
				}
			}
			// Attacks with 30% chance to burn
			if($attack == 'Lava Plume' || $attack == 'Scald'){
				if($_SESSION['ops'.$n][2] == 'Fire' || $_SESSION['ops'.$n][3] == 'Fire'){
					// Insert statement
				}
				else{
					$brn = rand(1,10);
					if($brn < 4){
						$_SESSION['ops'.$n][14] = Burn;
					}
				}
			}
			// Attacks with 50% chance to burn
			if($attack == 'Sacred Fire'){
				if($_SESSION['ops'.$n][2] == 'Fire' || $_SESSION['ops'.$n][3] == 'Fire'){
					// Insert statement
				}
				else{
					$brn = rand(1,2);
					if($brn == '1'){
						$_SESSION['ops'.$n][14] = Burn;
					}
				}
			}
			// Attacks with 100% chance to burn
			if($attack == 'Will-O-Wisp' || $attack == 'Inferno'){
				if($_SESSION['ops'.$n][2] == 'Fire' || $_SESSION['ops'.$n][3] == 'Fire'){
					// Insert statement
				}
				else{
					$_SESSION['ops'.$n][14] = Burn;
				}
			}
			
			//---------------------FREEZE------------------//
			
			// Attacks with 10% chance to freeze
			if($attack == 'Blizzard' || $attack == 'Freeze-Dry' || $attack == 'Ice Beam' || $attack == 'Ice Fang' || $attack == 'Ice Punch' || $attack == 'Powder Snow' ){
				if($_SESSION['ops'.$n][2] == 'Ice' || $_SESSION['ops'.$n][3] == 'Ice'){
					// Insert statement
				}
				else{
					$frz = rand(1,10);
					if($frz == '1'){
						$_SESSION['ops'.$n][14] = Frozen;
					}
				}
			}
			
			//-----------------PARALYSIS-----------------//
			
			// Attacks with 10% chance to paralyze
			if($attack == 'Bolt Strike' || $attack == 'Freeze Shock' || $attack == 'Thunder Fang' || $attack == 'Thunderbolt' || $attack == 'Thunderpunch' || $attack == 'Thundershock'){
				if($_SESSION['ops'.$n][2] == 'Electric' || $_SESSION['ops'.$n][3] == 'Electric'){
					// Insert statement
				}
				else{
					$par = rand(1,10);
					if($par == '1'){
						$_SESSION['ops'.$n][14] = Paralyzed;
					}
				}
			}
			// Attacks with 30% chance to paralyze
			if($attack == 'Body Slam' || $attack == 'Bounce' || $attack == 'Discharge' || $attack == 'Force Palm' || $attack == 'Lick' || $attack == 'Spark' || $attack == 'Thunder'){
				if($_SESSION['ops'.$n][2] == 'Electric' || $_SESSION['ops'.$n][3] == 'Electric'){
					// Insert statement
				}
				else{
					$par = rand(1,10);
					if($par < 4){
						$_SESSION['ops'.$n][14] = Paralyzed;
					}
				}
			}
			// Attacks wih 100% chance to paralyze
			if($attack == 'Glare' || $attack == 'Nuzzle' || $attack == 'Stun Spore' || $attack == 'Thunder Wave' || $attack == 'Zap Cannon'){
				if($_SESSION['ops'.$n][2] == 'Electric' || $_SESSION['ops'.$n][3] == 'Electric'){
					// Insert statement
				}
				else{
					$_SESSION['ops'.$n][14] = Paralyzed;
				}
			}
			
			//----------------POISON----------------//
			
			// Attacks with 10% chance of poison
			if($attack == 'Cross Poison' || $attack == 'Poison Tail' || $attack == 'Sludge Wave'){
				if($_SESSION['ops'.$n][2] == 'Poison' || $_SESSION['ops'.$n][3] == 'Poison' || $_SESSION['ops'.$n][2] == 'Steel' || $_SESSION['ops'.$n][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn == '1'){
						$_SESSION['ops'.$n][14] = Poison;
					}
				}
			}
			// Attacks with 20% chance of poison
			if($attack == 'Twineedle'){
				if($_SESSION['ops'.$n][2] == 'Poison' || $_SESSION['ops'.$n][3] == 'Poison' || $_SESSION['ops'.$n][2] == 'Steel' || $_SESSION['ops'.$n][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn < 3){
						$_SESSION['ops'.$n][14] = Poison;
					}
				}
			}
			// Attacks with 30% chance of poison
			if($attack == 'Gunk Shot' || $attack == 'Poison Jab' || $attack == 'Poison Sting' || $attack == 'Sludge' || $attack == 'Sludge Bomb'){
				if($_SESSION['ops'.$n][2] == 'Poison' || $_SESSION['ops'.$n][3] == 'Poison' || $_SESSION['ops'.$n][2] == 'Steel' || $_SESSION['ops'.$n][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn < 4){
						$_SESSION['ops'.$n][14] = Poison;
					}
				}
			}
			// Attacks with 40% chance to poison
			if($attack == 'Smog'){
				if($_SESSION['ops'.$n][2] == 'Poison' || $_SESSION['ops'.$n][3] == 'Poison' || $_SESSION['ops'.$n][2] == 'Steel' || $_SESSION['ops'.$n][3] == 'Steel'){
					// Insert statement
				}
				else{
					$psn = rand(1,10);
					if($psn < 5){
						$_SESSION['ops'.$n][14] = Poison;
					}
				}
			}
			// Attacks with 100% chance to poison
			if($attack == 'Toxic Spikes' || $attack == 'Poison Powder' || $attack == 'Poison Gas'){
				if($_SESSION['ops'.$n][2] == 'Poison' || $_SESSION['ops'.$n][3] == 'Poison' || $_SESSION['ops'.$n][2] == 'Steel' || $_SESSION['ops'.$n][3] == 'Steel'){
					// Insert statement
				}
				else{
					$_SESSION['ops'.$n][14] = Poison;
				}
			}
			
			//--------------SLEEP----------------------//
			
			// Attacks with 30% chance to sleep
			if($attack == 'Relic Song'){
				// Add a check here for sleep immunity
				$slp = rand(1,10);
				if($slp < 4){
					$_SESSION['ops'.$n][14] = Sleep;
				}
			}
			// Attacks with 100% chance to sleep
			if($attack == 'Dark Void' || $attack == 'Grasswhistle' || $attack == 'Hypnosis' || $attack == 'Lovely Kiss' || $attack == 'Sing' || $attack == 'Sleep Powder' || $attack == 'Spore' || $attack == 'Yawn'){
				// Add a check here for sleep immunity
				$_SESSION['ops'.$n][14] = Sleep;
			}
			
			//------------------CONFUSION------------------//
			
			// Attacks with 10% to confuse
			if($attack == 'Confusion' || $attack == 'Hurricane' || $attack == 'Psybeam' || $attack == 'Signal Beam'){
				// Add a check here for confusion immunity
				$conf = rand(1,10);
				if($conf == '1'){
					$_SESSION['ops'.$n][14] = Confused;
				}
			}
			
			//---------------BADLY POISONED------------------//
			
			// Attacks with 30% chance to badly poison
			if($attack == 'Poison Fang'){
				if($_SESSION['ops'.$n][2] == 'Poison' || $_SESSION['ops'.$n][3] == 'Poison' || $_SESSION['ops'.$n][2] == 'Steel' || $_SESSION['ops'.$n][3] == 'Steel'){
					// Insert statement
				}
				else{
					$bpsn = rand(1,10);
					if($bpsn < 4){
						$_SESSION['ops'.$n][14] = Poison;
					}
				}
			}
			// Attacks with 100% chance to badly poison
			if($_SESSION['attack_short'][3] == 'Toxic' || $_SESSION['attack_short'][3] == 'Toxic Spikes'){
				if($_SESSION['ops'.$n][2] == 'Poison' || $_SESSION['ops'.$n][3] == 'Poison' || $_SESSION['ops'.$n][2] == 'Steel' || $_SESSION['ops'.$n][3] == 'Steel'){
					// Insert statement
				}
				else{
					$_SESSION['ops'.$n][14] = Poison;
				}
			}

		} // End inflicting status effect on opponent
		
		//------------------------------------Status effect damages and effects to you and opponent-----------------------------------//
		
		//-------------------------Your status effect damages--------------------------//
		
		if($_SESSION['s'.$u][14] == 'Poison'){ // If your Pokemon is Poisoned
			$percent_u = 12;
			$maxhp_u = $_SESSION['s'.$u][11];
			$damg_u = ($percent_u / 100) * $maxhp_u;
			$state_u = "was hurt by it's poisoning.";
		}
		if($_SESSION['s'.$u][14] == 'Burn'){ // If your Pokemon is Burned
			$percent_u = 12;
			$maxhp_u = $_SESSION['s'.$u][11];
			$damg_u = ($percent_u / 100) * $maxhp_u;
			$state_u = "was hurt by it's burn.";
		}
		if($_SESSION['s'.$u][14] == 'Sleep'){ // If your pokemon is asleep
			$wake_u = rand(1,4);
			if($wake_u == 1){
				unset($_SESSION['s'.$u][14]);
			}
			else{
				$www = 0;
			}
		}
		if($_SESSION['s'.$u][14] == 'Paralyzed'){ // If your pokemon is paralyzed
			$para_u = rand(1,4);
			if($para_u == 1){
				$www = 0;
			}
		}
		if($_SESSION['s'.$u][14] == 'Frozen'){ // If your pokemon is frozen
			$frz_u = rand(1,5);
			if($frz_u > 1){
				$www = 0;
			}
			if($frz_u == 1){ // Thaw out of frozen state
				unset($_SESSION['s'.$u][14]);
			}
		}
		if($_SESSION['s'.$u][14] == 'Confused'){ // If your Pokemon is confused
			$conf_u = rand(1,2);
			if($conf_u == 1){
				$percent_u = 10;
				$maxhp_u = $_SESSION['s'.$u][11];
				$damg_u = ($percent_u / 100) * $maxhp_u;
				$www = 0;
			}
		}
		
		//--------------------------Opponent status effect damages------------------------------//
		
		if($_SESSION['ops'.$n][14] == 'Poison'){ // If opponent is Poisoned
			$percent = 12;
			$maxhp_op = $_SESSION['ops'.$n][11];
			$damg_op = ($percent / 100) * $maxhp_op;
			$state_op = "was hurt by it's poisoning.";
		}
		if($_SESSION['ops'.$n][14] == 'Burn'){ // If opponent is Burned
			$percent = 12;
			$maxhp_op = $_SESSION['ops'.$n][11];
			$damg_op = ($percent / 100) * $maxhp_op;
			$state_op = "was hurt by it's burn.";
		}
		if($_SESSION['ops'.$n][14] == 'Sleep'){ // If opponent is asleep
			$wake_op = rand(1,4);
			if($wake_op == 1){
				unset($_SESSION['ops'.$n][14]);
			}
			else{
				$hhh = 0;
			}
		}
		if($_SESSION['ops'.$n][14] == 'Paralyzed'){ // If opponent is paralyzed
			$para_op = rand(1,4);
			if($para_op == 1){
				$hhh = 0;
			}
		}
		if($_SESSION['ops'.$n][14] == 'Frozen'){ // If opponent is frozen
			$frz_op = rand(1,5);
			if($frz_op > 1){
				$hhh = 0;
			}
			if($frz_op == 1){
				unset($_SESSION['ops'.$n][14]);
			}
		}
		if($_SESSION['ops'.$n][14] == 'Confused'){ // If opponent is confused
			$conf_op = rand(1,2);
			if($conf_op == 1){
				$percent_op = 10;
				$maxhp_op = $_SESSION['s'.$u][11];
				$damg_op = ($percent_op / 100) * $maxhp_op;
				$hhh = 0;
			}
		}

		$_SESSION['s'.$u][10] = $_SESSION['s'.$u][10] - $hhh - round($damg_u); // Your pokemon HP session minus final damage
		$_SESSION['ops'.$n][10] = $_SESSION['ops'.$n][10] - $www - round($damg_op);// Opponents HP session minus final damage

		if($_SESSION['s'.$u][10] < 0){ // if your HP below 0
			$_SESSION['s'.$u][10] = 0; // set HP to 0
		}
		if($_SESSION['ops'.$n][10] < 0){ // if opponents HP below 0
			$_SESSION['ops'.$n][10] = 0; // set to 0
		}
		$div = $_SESSION['s'.$u][10] / $_SESSION['s'.$u][11];
		$_SESSION['s'.$u][12] = $div * 100;
		$div = $_SESSION['ops'.$n][10] / $_SESSION['ops'.$n][11];
		$_SESSION['ops'.$n][12] = $div * 100;
	}
	if($_POST['active_pokemon']){ // Get the Pokemon you're using
		$atp = $_POST['active_pokemon'];
		if($atp == $_SESSION['s1'][1]){ // slot 1
			$_SESSION['y_p'][0] = 1;
		}
		if($atp == $_SESSION['s2'][1]){ // slot 2
			$_SESSION['y_p'][0] = 2;
		}
		if($atp == $_SESSION['s3'][1]){ // slot 3
			$_SESSION['y_p'][0] = 3;
		}
		if($atp == $_SESSION['s4'][1]){ // slot 4
			$_SESSION['y_p'][0] = 4;
		}
		if($atp == $_SESSION['s5'][1]){ // slot 5
			$_SESSION['y_p'][0] = 5;
		}
		if($atp == $_SESSION['s6'][1]){ // slot 6
			$_SESSION['y_p'][0] = 6;
		}
		$spot = 1;
		if(isset($_SESSION['ops2']) && $_SESSION['ops1'][10] == 0){ // If your opponent slot 1 is dead
			$spot = 2;
		}
		if(isset($_SESSION['ops3']) && $_SESSION['ops2'][10] == 0){ // If your opponent slot 2 is dead
			$spot = 3;
		}
		if(isset($_SESSION['ops4']) && $_SESSION['ops3'][10] == 0){ // If your opponent slot 3 is dead
			$spot = 4;
		}
		if(isset($_SESSION['ops5']) && $_SESSION['ops4'][10] == 0){ // If your opponent slot 4 is dead
			$spot = 5;
		}
		if(isset($_SESSION['ops6']) && $_SESSION['ops5'][10] == 0){ // If your opponent slot 5 is dead
			$spot = 6;
		}

		$_SESSION['y_p'][1] = $spot;
	}
	$q = $_SESSION['y_p'][1];
	$p = $_SESSION['y_p'][0];
	echo "<form action=\"/battle.php\" method=\"post\" name=\"1{$random}\" id=\"1{$random}\" style='display:none;' >
	<input type='submit' value='Continue' />
	</form>";
	echo "<form action=\"/battle.php\" method=\"post\" name=\"{$random}\" id=\"{$random}\" onsubmit=\"get('/battle.php', '', this); disableSubmitButton(this); return false;\">";
	echo "<h2>";
	if($_POST['attack'] && $_SESSION['s'.$p][11] != 0 || $_POST['item'] && $_SESSION['s'.$p][11] != 0){
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
	echo '<h3>Your ' . $_SESSION['s'.$p][0] . '</h3><img src="html/static/images/pokemon/' . $_SESSION['s'.$p][0] . '.gif" width="96" height="96" /><br /><em>Level:</em> ' . $_SESSION['s'.$p][4] . '</td><td style="width: 50%;"><h3>' . htmlentities($_SESSION['opponent_profile'][1]) . '\'s ' . $_SESSION['ops'.$q][0] . '</h3><img src="html/static/images/pokemon/' . $_SESSION['ops'.$q][0] . '.gif" width="96" height="96" /><br /><em>Level:</em> ' . $_SESSION['ops'.$q][4] . '</span></td></tr>';
	echo '<tr style="vertical-align: middle;"><td style="width: 50%; padding: 10px 0;">
	<strong>HP: <img src="html/static/images/misc/hpbar.gif" height="10" width="' . $_SESSION['s'.$p][12] . '" style="border:1px solid black" /> ' . $_SESSION['s'.$p][10] . ' </strong>'; // display your status effect
	if($_SESSION['s'.$u][14] == 'Poison'){
		echo '<img src="html/static/images/misc/poison.png" />';
	}
	if($_SESSION['s'.$u][14] == 'Sleep'){
		echo '<img src="html/static/images/misc/sleep.png" />';
	}
	if($_SESSION['s'.$u][14] == 'Burn'){
		echo '<img src="html/static/images/misc/burn.png" />';
	}
	if($_SESSION['s'.$u][14] == 'Paralyzed'){
		echo '<img src="html/static/images/misc/paralyze.png" />';
	}
	if($_SESSION['s'.$u][14] == 'Frozen'){
		echo '<img src="html/static/images/misc/freeze.png" />';
	}
	echo '</td>
	<td style="width: 50%; padding: 10px 0;">
	<strong>HP: <img src="html/static/images/misc/hpbar.gif" height="10" width="' . $_SESSION['ops'.$q][12] . '" style="border:1px solid black" /> ' . $_SESSION['ops'.$q][10] . ' </strong>'; // display opponents status effect
	if($_SESSION['ops'.$n][14] == 'Poison'){
		echo '<img src="html/static/images/misc/poison.png" />';
	}
	if($_SESSION['ops'.$n][14] == 'Sleep'){
		echo '<img src="html/static/images/misc/sleep.png" />';
	}
	if($_SESSION['ops'.$n][14] == 'Burn'){
		echo '<img src="html/static/images/misc/burn.png" />';
	}
	if($_SESSION['ops'.$n][14] == 'Paralyzed'){
		echo '<img src="html/static/images/misc/paralyze.png" />';
	}
	if($_SESSION['ops'.$n][14] == 'Frozen'){
		echo '<img src="html/static/images/misc/freeze.png" />';
	}
	echo '</td></tr>';
	
	//---------------------------------------------------Damage if both Pokemon attack-------------------------------------------//
	
	if($_POST['attack']){
		
		//---------------opponent attacking you-----------------//
		
		echo '<tr><td style="width: 50%; padding: 0 15px;" valign="top"><strong>';
					// If the opponent attack hits, isn't scared, asleep, confused, frozen or paralyzed
		if($op_scared != 2 && !$op_missed && $_SESSION['ops'.$n][14] != 'Sleep' && $conf_op != 1 && $frz_op != 1 && $para_op != 1){
			if($oattack == 'Will-O-Wisp' || $oattack == 'Glare' || $oattack == 'Stun Spore' || $oattack == 'Thunder Wave' || $oattack == 'Poison Gas' || $oattack == 'Poison Powder' || $oattack == 'Toxic Spikes' || $oattack == 'Toxic' || $oattack == 'Dark Void' || $oattack == 'Grasswhistle' || $oattack == 'Hypnosis' || $oattack == 'Lovely Kiss' || $oattack == 'Rest' || $oattack == 'Sing' || $oattack == 'Sleep Powder' || $oattack == 'Spore' || $oattack == 'Yawn' || $oattack == 'Confuse Ray' || $oattack == 'Flatter' || $oattack == 'Supersonic' || $oattack == 'Swagger' || $oattack == 'Sweet Kiss' || $oattack == 'Teeter Dance'){ // status effect attacks that do no damage
				echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . '';
			}
			elseif($oattack == 'Transform'){
				echo 'Ditto used Transform and turned into ' . $_SESSION['s'.$p][0] . '.';
			}
			elseif($oattack == 'Sketch'){
				echo $_SESSION['ops'.$q][0] . ' used ' . $oattack . ' and copied ' . $attack . '.';
			}
			else{
				echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . ' and ';
				if($hhh == 0){
					echo 'had no effect.';
				}
				else{
					echo 'did '. $hhh . ' HP damage.'; if($crit == 1 && !$_SESSION['attack_short'][9] == 'Status'){ echo '<br /><br />It was a critical hit!'; }
				}
	
				if($damages2 == 4 && $hhh != 0){
					echo '<br/><br/>The attack was ultra effective!';
				}
				if($damages2 == 2 && $hhh != 0){
					echo '<br/><br/>The attack was super effective!';
				}
				if($damages2 < 1 && $damages2 > 0 && $hhh != 0){
					echo '<br/><br/>The attack was not very effective.';
				}
				if($damages2 == 0 && $hhh != 0){
					echo '<br/><br/>The attack did no damage.';
				}
			}
			if($_SESSION['s'.$p][10] == 0){
				echo '<br/><br/>' . $_SESSION['s'.$p][0] . ' has fainted.';
			}
		}
		if($op_scared == 2){ // If your opponent is scared and didn't miss
			echo $_SESSION['ops'.$q][0] . ' is scared and could not attack.';
		}
		if($op_missed == 1){ // If the opponents attack missed
			echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . ' but missed';
		}
		if($state_op){
			echo '<br /><br />' . $_SESSION['ops'.$q][0] . ' ' . $state_op;
		}
		if($_SESSION['ops'.$n][14] == 'Sleep'){ // If the opponent is asleep
			echo $_SESSION['ops'.$q][0] . ' is fast asleep.';
		}
		if($wake_op == 1){ // If opponent wakes up
			echo $_SESSION['ops'.$q][0] . ' woke up.';
		}
		if($frz_op > 1){ // If the opponent is frozen
			echo $_SESSION['ops'.$q][0] . ' is frozen solid and could not move.';
		}
		if($frz_op == 1){ // If the opponent thaws out of freeze state
			echo $_SESSION['ops'.$q][0] . ' thawed out of it\'s frozen state.';
		}
		if($conf_op == 1){ // If the opponent is confused
			echo $_SESSION['ops'.$q][0] . ' hurt itself in it\'s confusion.';
		}
		if($para_op == 1){ // If the opponent is paralyzed
			echo $_SESSION['ops'.$q][0] . ' is paralyzed and could not move.';
		}

		echo '</strong></td><td style="width: 50%; padding: 0 15px;" valign="top"><strong>';
		
		//-------------------You attacking opponent------------------------//
		
				// If your attack hits, you're not scared, asleep, frozen, paralyzed or confused
		if($you_scared != 2 && !$u_missed && $_SESSION['s'.$u][14] != 'Sleep' && $conf_u != 1 && $frz_u != 1 && $para_u != 1){
			if($attack == 'Will-O-Wisp' || $attack == 'Glare' || $attack == 'Stun Spore' || $attack == 'Thunder Wave' || $attack == 'Poison Gas' || $attack == 'Poison Powder' || $attack == 'Toxic Spikes' || $attack == 'Toxic' || $attack == 'Dark Void' || $attack == 'Grasswhistle' || $attack == 'Hypnosis' || $attack == 'Lovely Kiss' || $attack == 'Rest' || $attack == 'Sing' || $attack == 'Sleep Powder' || $attack == 'Spore' || $attack == 'Yawn' || $attack == 'Confuse Ray' || $attack == 'Flatter' || $attack == 'Supersonic' || $attack == 'Swagger' || $attack == 'Sweet Kiss' || $attack == 'Teeter Dance'){ // status effect attacks that do no damage
				echo 'Your ' . $_SESSION['s'.$p][0] . ' attacked ' . $_SESSION['ops'.$q][0] . ' with ' . $attack . '';
			}
			elseif($attack == 'Transform'){
				echo 'Your Ditto used Transform and turned into ' . $_SESSION['ops'.$q][0] . '.';
			}
			elseif($attack == 'Sketch'){
				echo 'Your ' . $_SESSION['s'.$p][0] . ' used ' . $attack . ' and copied ' . $oattack . '.';
			}
			else{
				echo 'Your ' . $_SESSION['s'.$p][0] . ' attacked ' . $_SESSION['ops'.$q][0] . ' with ' . $attack . ' and ';
				if($www == 0){
					echo 'had no effect.';
				}
				else{
					echo 'did '. $www . ' HP damage.'; if($crit == 1 && !$_SESSION['attack_short'][8] == 'Status'){ echo '<br /><br />It was a critical hit!'; }
				}
				if($damages == 4 && $www != 0){
					echo '<br/><br/>The attack was ultra effective!';
				}
				if($damages == 2 && $www != 0){
					echo '<br/><br/>The attack was super effective!';
				}
				if($damages < 1 && $damages > 0 && $www != 0){
					echo '<br/><br/>The attack was not very effective.';
				}
				if($damages == 0){
					echo '<br/><br/>The attack did no damage.';
				}
			}
			if($_SESSION['ops'.$q][10] == 0){ // If the opponent has fainted
				echo '<br/><br/>' . $_SESSION['ops'.$q][0] . ' has fainted.';
			}
		}
		if($you_scared == 2){ // If your Pokemon is scared and didn't miss the attack
			echo $_SESSION['s'.$p][0] . ' is scared and could not attack.';
		}
		if($u_missed == 1){ // If your attack missed
			echo 'Your ' . $_SESSION['s'.$p][0] . ' attacked ' . $_SESSION['ops'.$q][0] . ' with ' . $attack . ' but missed';
		}
		if($state_u){
			echo '<br /><br />Your ' . $_SESSION['s'.$p][0] . ' ' . $state_u;
		}
		if($_SESSION['s'.$u][14] == 'Sleep'){ // You're asleep
			echo $_SESSION['s'.$p][0] . ' is fast asleep.';
		}
		if($wake_u == 1){ // You woke up
			echo $_SESSION['s'.$p][0] . ' woke up.';
		}
		if($frz_u > 1){ // You're frozen
			echo $_SESSION['s'.$p][0] . ' is frozen solid and could not move.';
		}
		if($frz_u == 1){ // You thawed out of freeze
			echo $_SESSION['s'.$p][0] . ' thawed out of it\'s frozen state.';
		}
		if($conf_u == 1){ // Hurt yourself in confusion
			echo $_SESSION['s'.$p][0] . ' hurt itself in it\'s confusion.';
		}
		if($para_u == 1){ // You're paralyzed
			echo $_SESSION['s'.$p][0] . ' is paralyzed and could not move.';
		}
		echo '</strong></td></tr><tr><td style="width:50%;"><div class="hr"></div></td><td style="width:50%;"><div class="hr"></div></td></tr>';
	}
	 //------------------------------------Damage to your Pokemon if you use an item-----------------------------------------------------//
	if($_POST['item']){
		echo '<tr><td style="width: 50%; padding: 0 15px;" valign="top"><strong>';
				// If the opponents attack didn't miss or opponent isn't scared
		if($op_scared != 2 && !$op_missed && $_SESSION['ops'.$n][14] != 'Sleep' && $conf_op != 1 && $frz_op != 1 && $para_op != 1){
			if($oattack == 'Will-O-Wisp' || $oattack == 'Glare' || $oattack == 'Stun Spore' || $oattack == 'Thunder Wave' || $oattack == 'Poison Gas' || $oattack == 'Poison Powder' || $oattack == 'Toxic Spikes' || $oattack == 'Toxic' || $oattack == 'Dark Void' || $oattack == 'Grasswhistle' || $oattack == 'Hypnosis' || $oattack == 'Lovely Kiss' || $oattack == 'Rest' || $oattack == 'Sing' || $oattack == 'Sleep Powder' || $oattack == 'Spore' || $oattack == 'Yawn' || $oattack == 'Confuse Ray' || $oattack == 'Flatter' || $oattack == 'Supersonic' || $oattack == 'Swagger' || $oattack == 'Sweet Kiss' || $oattack == 'Teeter Dance'){ // status effect attacks that do no damage
				echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . '';
			}
			elseif($oattack == 'Transform'){
				echo 'Ditto used Transform and turned into ' . $_SESSION['s'.$p][0] . '.';
			}
			elseif($oattack == 'Sketch'){
				echo $_SESSION['ops'.$q][0] . ' used ' . $oattack . ' and copied ' . $_SESSION['attack_short'][0] . '.';
			}
			else{
				echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . ' and ';
				if($hhh == 0){
					echo 'had no effect.';
				}
				else{
					echo 'did '. $hhh . ' HP damage.'; if($crit == '1' && !$_SESSION['attack_short'][8] == 'Status'){ echo '<br /><br />It was a critical hit!'; }
				}
				if($damages2 == '4' && $hhh != 0){
					echo '<br/><br/>The attack was ultra effective!';
				}
				if($damages2 == '2' && $hhh != 0){
					echo '<br/><br/>The attack was super effective!';
				}
				if($damages2 < 1 && $damages2 > 0 && $hhh != 0){
					echo '<br/><br/>The attack was not very effective.';
				}
				if($damages2 == '0' && $hhh != 0){
					echo '<br/><br/>The attack did no damage.';
				}
			}
			if($_SESSION['s'.$p][10] == 0){ // If your Pokemon fainted
				echo '<br/><br/>' . $_SESSION['s'.$p][0] . ' has fainted.';
			}
		}

		if($op_scared == '2'){ // If your opponent is scared and didn't miss the attack
			echo $_SESSION['ops'.$q][0] . ' is scared an could not attack.';
		}
		if($op_missed == '1'){ // If your opponent missed the attack
			echo $_SESSION['ops'.$q][0] . ' attacked your ' . $_SESSION['s'.$p][0] . ' with ' . $oattack . ' but missed ';
		}
		
		if($state){
			echo '<br /><br />Your ' . $_SESSION['s'.$p][0] . ' ' . $state;
		}

		echo '<br/><br/>' . $item_statement;
		

		echo '</strong></td><td style="width: 50%; padding: 0 15px;" valign="top"><strong>Your ' . $_SESSION['s'.$p][0] . ' could not attack.';

		echo '</strong></td></tr><tr><td style="width:50%;"><div class="hr"></div></td><td style="width:50%;"><div class="hr"></div></td></tr>';

	}
	//------------------------------------------ End attacking damages and item use calculations------------------------------------//
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
		echo '<input type="hidden" name="action" value="attack" /><br /><input type="submit" value="'.generateBattleButtonText('Attack').'" /></form>
		<div class="hr"></div><h2 style="margin-top: 30px;">Or Use an Item</h2>
		<table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
		<tr style="vertical-align: text-top;"><td>
		<form action="battle.php" method="post" id="itemForm" name="itemForm" onsubmit="get(\'/battle.php\', \'\', this); disableSubmitButton(this); return false;">
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
			echo '/> <label for="item2"><img src="html/static/images/items/' . $quick[$a] . '.png" height="24" width="24" align="absmiddle">';

			if($_SESSION['items'][$a] == 0){
				echo '<s>';
			}
			echo $quick[$a];
			if($_SESSION['items'][$a] == 0){
				echo '</s>';
			}
			echo '</label></td><td align="center">' . $_SESSION['items'][$a] . '</td></tr>';
		}
		echo '<tr><td colspan="2"><center><input name="items" type="submit" value="Use Item" /><br /></center></td></tr></td></tr></table></form></td></td></tr>';
	}
	if($_SESSION['ops'.$q][10] == 0 || $_SESSION['s'.$p][10] == 0){
		echo '<input name="choose" type="hidden" value="pokechu">';
		echo '<tr><td colspan="2"><center><input type="submit" value="'.generateBattleButtonText('Continue').'"'.(rand(1,2)===2?' style="margin-top: 25px;"':'').'></center></td></tr>';
	}
	echo "</table>";
}
if($_REQUEST['bid'] || $_REQUEST['sidequest'] || $_REQUEST['gymleader'] || $_REQUEST['eventtrainer'] || $_REQUEST['clanbattle']){
	
		/**** Set battle start JS-check token ****/
		$_SESSION['nojs-check-a'] = rand(11,20);
		$_SESSION['nojs-check-b'] = rand(1,10);
		$_SESSION['nojs-check'] = $_SESSION['nojs-check-a'] + $_SESSION['nojs-check-b'];
		/*****************************************/
	
		if($_REQUEST['eventtrainer']){
			$_REQUEST['eventtrainer'] = mysql_real_escape_string($_REQUEST['eventtrainer']);
			$get_op = mysql_query("SELECT s1, s2, s3, s4, s5, s6, id, trainer FROM event WHERE trainer = '{$_REQUEST['eventtrainer']}'");
			$type = 'event';
		}
		elseif($_REQUEST['gymleader']){
			$_REQUEST['gymleader'] = mysql_real_escape_string($_REQUEST['gymleader']);
			$get_op = mysql_query("SELECT s1, s2, s3, s4, s5, s6, id, leader FROM gym WHERE leader = '{$_REQUEST['gymleader']}'");
			$type = 'gym';
		}
		elseif($_REQUEST['sidequest']){
			$_REQUEST['sidequest'] = mysql_real_escape_string($_REQUEST['sidequest']);
			$get_op = mysql_query("SELECT s1, s2, s3, s4, s5, s6, id, name FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
			$type = 'side';
		}
		elseif($_REQUEST['clanbattle']){
			$_REQUEST['clanbattle'] = mysql_real_escape_string($_REQUEST['clanbattle']);
			$get_op = mysql_query("SELECT s1, s2, s3, s4, s5, s6, id, username FROM members WHERE secret_key = '{$_SESSION['clan_battle'][0]}'");
			$type = 'clan';
		}
		else{
			if(is_numeric($_REQUEST['bid'])){
				$_REQUEST['bid'] = mysql_real_escape_string($_REQUEST['bid']);
				$get_op = mysql_query("SELECT s1, s2, s3, s4, s5, s6, id, username FROM members WHERE id = '{$_REQUEST['bid']}'");
			}
			$type = '';
		}
		$count_op = mysql_num_rows($get_op);
		if($count_op == 0){
			if($type == 'event'){
				echo '<div class="errorMsg">The event trainer you requested does not exist.</div>';
			}
			elseif($type == 'gym'){
				echo '<div class="errorMsg">The gym leader you have submitted does not exist.</div>';
			}
			elseif($type == 'side'){
				echo '<div class="errorMsg">Sorry, an error occured with the sidequest battle you requested.</div>';
			}
			elseif($type == 'clan'){
				echo '<div class="errorMsg">Sorry, an error occurred with the clan battle you requested.</div>';
			}
			else{
				echo "<div class='errorMsg'>The username you have submitted does not exist.</div>";
			}
		}
		else{
			$get_op1 = mysql_fetch_array($get_op);
			if($type == 'clan'){
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
			}
			
			else{
				$a = $get_op1['s1'];$b = $get_op1['s2'];$c = $get_op1['s3'];$d = $get_op1['s4'];$e = $get_op1['s5'];$f = $get_op1['s6'];
				if($a && !$b){
					$t = mysql_query("SELECT * FROM {$type}pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a) ORDER BY FIELD(id,$a)");
					$o_num = 1;
				}
				if($b && !$c){
					$t = mysql_query("SELECT * FROM {$type}pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b) ORDER BY FIELD(id,$a,$b)");
					$o_num = 2;
				}
				if($c && !$d){
					$t = mysql_query("SELECT * FROM {$type}pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c) ORDER BY FIELD(id,$a,$b,$c)");
					$o_num = 3;
				}
				if($d && !$e){
					$t = mysql_query("SELECT * FROM {$type}pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c,$d) ORDER BY FIELD(id,$a,$b,$c,$d)");
					$o_num = 4;
				}
				if($e && !$f){
					$t = mysql_query("SELECT * FROM {$type}pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c,$d,$e) ORDER BY FIELD(id,$a,$b,$c,$d,$e)");
					$o_num = 5;
				}
				if($f){
					$t = mysql_query("SELECT * FROM {$type}pokemon WHERE owner = '{$get_op1['id']}' AND id IN($a,$b,$c,$d,$e,$f) ORDER BY FIELD(id,$a,$b,$c,$d,$e,$f)");
					$o_num = 6;
				}
			}
			if($type == 'event'){
				$_SESSION['opponent_profile'] = array("{$get_op1['id']}","{$get_op1['trainer']}","{$o_num}","{$type}");
			}
			elseif($type == 'gym'){
				$_SESSION['opponent_profile'] = array("{$get_op1['id']}","{$get_op1['leader']}","{$o_num}","{$type}");
			}
			elseif($type == 'side'){
				$_SESSION['opponent_profile'] = array("{$get_op1['id']}","{$get_op1['name']}","{$o_num}","{$type}");
			}
			elseif($type == 'clan'){
				$_SESSION['opponent_profile'] = array("{$get_op1['id']}","{$get_op1['username']}","{$o_num}","{$type}","{$_REQUEST['clanbattle']}");
			}
			else{
				$_SESSION['opponent_profile'] = array("{$get_op1['id']}","{$get_op1['username']}","{$o_num}","{$type}");
			}
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


				if(!isset($_SESSION['items'])){
					$it = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid'][0]}'");
					$itt = mysql_fetch_array($it);
					$_SESSION['items'] = array("{$itt['Potion']}","{$itt['Super_Potion']}","{$itt['Hyper_Potion']}","{$itt['Full_Heal']}","{$itt['Awakening']}","{$itt['Parlyz_Heal']}","{$itt['Antidote']}","{$itt['Burn_Heal']}","{$itt['Ice_Heal']}","{$itt['Poke_Ball']}","{$itt['Great_Ball']}","{$itt['Ultra_Ball']}","{$itt['Master_Ball']}");
}
					$pname = '';$pid = '';$ptype1 = '';$ptype2 = '';$plvl = '';$pexp = '';$pattack1 = '';$pattack2 = '';$pattack3 = '';$pattack4 = '';

					$a = $_SESSION['my_team'][0];
					$b = $_SESSION['my_team'][1];
					$c = $_SESSION['my_team'][2];
					$d = $_SESSION['my_team'][3];
					$e = $_SESSION['my_team'][4];
					$f = $_SESSION['my_team'][5];
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
					$_SESSION['your_profile'] = array("{$_SESSION['myid']}","{$_SESSION['myuser']}","{$u_num}","{$_SESSION['myeb']}");
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
			echo "<form action=\"/battle.php\" method=\"post\" name=\"{$random}\" id=\"{$random}\" onsubmit=\"solveJScap(); get('/battle.php', '', this); disableSubmitButton(this); return false;\">";
			if($_SESSION['position'] == 1 || $_POST['choose'] == "pokechu" ){
				$all_dead_op = 1;
				$all_dead_op = $_SESSION['ops1'][10] + $_SESSION['ops2'][10] + $_SESSION['ops3'][10] + $_SESSION['ops4'][10] + $_SESSION['ops5'][10] + $_SESSION['ops6'][10];
				$all_dead_u = $_SESSION['s1'][10] + $_SESSION['s2'][10] + $_SESSION['s3'][10] + $_SESSION['s4'][10] + $_SESSION['s5'][10] + $_SESSION['s6'][10];
				if($all_dead_op == 0 && isset($_SESSION['ops1'])){

					$timebefore = mysql_query("SELECT btime, uniques, battle, totalexp, total_poke FROM members WHERE id = '{$_SESSION['myid']}'");
					$tb = mysql_fetch_array($timebefore);
					$tbb = $tb['btime'];
					$time = time();
					$secs = $time - $tbb;
					if($secs < 10){
						echo '<div class="errorMsg">You have already completed a battle within the last 10 seconds. This is in effect to prevent cheating of any kind.</div>
						<p class="optionsList autowidth"><strong>Options:</strong><br />';
						if($_SESSION['opponent_profile'][3] == 'gym'){
							echo '<a href="/battle.php?gymleader=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'gymleader=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
						}
						elseif($_SESSION['opponent_profile'][3] == 'side'){
							echo '<a href="/battle.php?sidequest=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'sidequest=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
						}
						elseif($_SESSION['opponent_profile'][3] == 'event'){
							echo '<a href="/battle.php?eventtrainer=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'eventtrainer=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
						}
						elseif($_SESSION['opponent_profile'][3] == 'clan'){
							echo '<a href="/clans.php?view=Battle" class="deselected">Back To Clan Battles</a>';
						}
						else{
							echo '<a href="/battle.php?bid=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'bid=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
						}
						echo '</a><br />
						<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
						<a href="/your_pokemon.php" class="deselected">View All Pokemon</a><br />
						<a href="/items.php" class="deselected">Pok&eacute;mart</a></p>';
					}
					else{
						echo '<h2>Congratulations! You won the battle!</h2>
						<h3>Your team beat ' . htmlentities($_SESSION['opponent_profile'][1]) . '\'s team.</h3>';
						
						for($sa=1;$sa<=6;$sa++){
							if($_SESSION['s'.$sa][13] == 1){

								echo '<p><img src="html/static/images/pokemon/' . $_SESSION['s'.$sa][0] . '.gif" align="absmiddle"> <strong><a href="/pokedex?pid=' . $_SESSION['s'.$sa][1] . '" onclick="pokedexTab(\'pid=' . $_SESSION['s'.$sa][1] . '\', 1); return false;">' . $_SESSION['s'.$sa][0] . '</a></strong></p>';
								$ya += 1;
								$u_level += $_SESSION['s'.$sa][4];
							}
						}

						for($asw=1;$asw<=$_SESSION['opponent_profile'][2];$asw++){
							$amount_level += $_SESSION['ops'.$asw][4];
						}
						$exp2 = $amount_level / $u_level;
						$r_e_x = $exp2 * 500;
						$exp2 = round($r_e_x * $_SESSION['your_profile'][3]); // add * 2 to the end for double experience
						$tottal = 0;
						for($sa=1;$sa<=6;$sa++){
							if($_SESSION['s'.$sa][13] == 1){
								$tottal += $exp2;
								$id = $_SESSION['s'.$sa][1];
								$levl = $_SESSION['s'.$sa][4];
								$happy = rand(1,2);
								if($levl == '100'){
									mysql_query("UPDATE pokemon SET exp = exp + $exp2 WHERE id = '$id'");
									mysql_query("UPDATE pokemon_stats SET happiness = happiness + $happy WHERE id = '$id'");
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
									mysql_query("UPDATE pokemon_stats SET happiness = happiness + $happy WHERE id = '$id'");
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
							if(!isset($_SESSION['battle_count'])){
								$_SESSION['battle_count'] = 1;
							}
							else{
								$_SESSION['battle_count'] +=1;
							}
							if($_SESSION['battle_count'] >= 2){
								
							}
							echo ' experience points.<br />';
							if($_SESSION['opponent_profile'][3] == 'side'){
									mysql_query("UPDATE members SET sidequest = sidequest + 1 WHERE id = '{$_SESSION['myid']}'");
									$_SESSION['sidequest'] += 1;
								}
								elseif($_SESSION['opponent_profile'][3] == 'event'){
									$event = "g".$_SESSION['opponent_profile'][0];
									mysql_query("UPDATE events SET $event = '1' WHERE id = '{$_SESSION['myid']}'");
								}
								elseif($_SESSION['opponent_profile'][3] == 'gym'){
									$badges = $_SESSION['badges'];
									if($badges != 1){
										$badgeeee = "g".$_SESSION['opponent_profile'][0];
										mysql_query("UPDATE badges SET $badgeeee = '1' WHERE id = '{$_SESSION['myid']}'");
										$badges1 = mysql_query("SELECT * FROM badges WHERE id = '{$_SESSION['myid']}'");
										$badges2 = mysql_fetch_array($badges1);
										if($badges2['g1'] == 1 && $badges2['g2'] == 1 && $badges2['g3'] == 1 && $badges2['g4'] == 1 && $badges2['g5'] == 1 && $badges2['g6'] == 1 && $badges2['g7'] == 1 && $badges2['g8'] == 1 && $badges2['g9'] == 1 && $badges2['g10'] == 1 && $badges2['g11'] == 1 && $badges2['g12'] == 1 && $badges2['g13'] == 1 && $badges2['g14'] == 1 && $badges2['g15'] == 1 && $badges2['g16'] == 1 && $badges2['g17'] == 1 && $badges2['g18'] == 1 && $badges2['g19'] == 1 && $badges2['g20'] == 1 && $badges2['g21'] == 1 && $badges2['g22'] == 1 && $badges2['g23'] == 1 && $badges2['g24'] == 1 && $badges2['g25'] == 1 && $badges2['g26'] == 1 && $badges2['g27'] == 1 && $badges2['g28'] == 1 && $badges2['g29'] == 1 && $badges2['g30'] == 1 && $badges2['g31'] == 1 && $badges2['g32'] == 1 && $badges2['g33'] == 1 && $badges2['g34'] == 1 && $badges2['g35'] == 1 && $badges2['g36'] == 1 && $badges2['g37'] == 1 && $badges2['g38'] == 1 && $badges2['g39'] == 1 && $badges2['g40'] == 1 && $badges2['g41'] == 1 && $badges2['g42'] == 1 && $badges2['g43'] == 1 && $badges2['g44'] == 1 && $badges2['g46'] == 1 && $badges2['g47'] == 1 && $badges2['g48'] == 1 && $badges2['g49'] == 1 && $badges2['g50'] == 1 && $badges2['g51'] == 1 && $badges2['g52'] == 1 && $badges2['g53'] == 1 && $badges2['g54'] == 1 && $badges2['g55'] == 1 && $badges2['g56'] == 1 && $badges2['g57'] == 1 && $badges2['g58'] == 1 && $badges2['g59'] == 1 && $badges2['g60'] == 1 && $badges2['g61'] == 1 && $badges2['g62'] == 1 && $badges2['g63'] == 1 && $badges2['g64'] == 1 && $badges2['g65'] == 1 && $badges2['g66'] == 1 && $badges2['g67'] == 1 && $badges2['g68'] == 1 && $badges2['g69'] == 1 && $badges2['g70'] == 1 && $badges2['g71'] == 1 && $badges2['g72'] == 1 && $badges2['g73'] == 1 && $badges2['g74'] == 1 && $badges2['g75'] == 1 && $badges2['g76'] == 1 && $badges2['g77'] == 1 && $badges2['g78'] == 1 && $badges2['g79'] == 1 && $badges2['g80'] == 1 && $badges2['g81'] == 1 && $badges2['g82'] == 1 && $badges2['g83'] == 1 && $badges2['g84'] == 1 && $badges2['g85'] == 1 && $badges2['g86'] == 1 && $badges2['g87'] == 1 && $badges2['g88'] == 1 && $badges2['g89'] == 1 && $badges2['g90'] == 1 && $badges2['g91'] == 1 && $badges2['g92'] == 1 && $badges2['g93'] == 1 && $badges2['g94'] == 1 && $badges2['g95'] == 1){
											mysql_query("UPDATE members SET badges = '1' WHERE id = '{$_SESSION['myid']}'");
											$_SESSION['map_preferences'][0] = 1;
										}
									}
								}

								echo '<br />You also won <img src="html/static/images/misc/pmoney.gif">' . number_format($money) . ' to buy items with.</p>';
								echo '<p class="optionsList autowidth"><strong>Options:</strong><br />';
								if($_SESSION['opponent_profile'][3] == 'gym'){
									echo '<a href="/battle.php?gymleader=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'gymleader=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'side'){
									echo '<a href="/battle.php?sidequest=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'sidequest=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Next Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'event'){
									echo '<a href="/battle.php?eventtrainer=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'eventtrainer=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'clan'){
									echo '<a href="/clans.php?view=Battle" class="deselected">Back To Clan Battles</a>';
								}
								else{
									echo '<a href="/battle.php?bid=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'bid=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								echo '</a><br />
								<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
								<a href="/your_pokemon.php" class="deselected">View All Pokemon</a><br />
								<a href="/items.php" class="deselected">Pok&eacute;mart</a></p>';
							
								// Update the users stats
	
								$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
								$aiir2 = mysql_fetch_array($aiir);
								$unique = $tb['uniques'];
								$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
								$totalexp = $tb['totalexp'] + $tottal;
								$battle = $tb['battle'] + 1;
								$p1 = sqrt($totalexp);
								$p2 = sqrt($avgexp);
								$p3 = sqrt($unique);
								$p4 = log($battle);
								$p5 = $p1 * $p2 * $p3 * $p4;
								$p6 = $p5 / 1000;
								$p7 = round($p6, 1);
								mysql_query("UPDATE members SET btime = '$time', averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7', battle = '{$battle}', money = money + $money WHERE id = '{$_SESSION['myid']}'");

								if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
									mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
									$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
									$claexp = mysql_fetch_array($clanexp);
									mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
									$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
									$clan_info = mysql_fetch_array($claninfo);
									$wins = $clan_info['wins'];
									$expp = $clan_info['exp'];
									$members = $clan_info['members'];
									$avgexp = $expp / $members;
									$po0 = sqrt($members);
									$po1 = sqrt($expp);
									$po2 = sqrt($avgexp);
									$po3 = log($wins);
									$po4 = $po1 * $po2 * $po3 * $po0;
									$po5 = $po4 / 10000;
									$po6 = round($po5, 1);
									mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
								}
								
								// Update the clan stats if it was a clan battle
								
								if($_SESSION['opponent_profile'][3] == 'clan'){
									$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
									$clan_info = mysql_fetch_array($claninfo);
									$wins = $clan_info['wins'] + 1;
									$exp = $clan_info['exp'] + $tottal;
									$members = $clan_info['members'];
									$avgexp = $exp / $members;
									$p0 = sqrt($members);
									$p1 = sqrt($exp);
									$p2 = sqrt($avgexp);
									$p3 = log($wins);
									$p4 = $p1 * $p2 * $p3 * $p0;
									$p5 = $p4 / 10000;
									$p6 = round($p5, 1);
									mysql_query("UPDATE clans SET points = '$p6', exp = '$exp', wins = '$wins' WHERE name = '{$_SESSION['clan']}'");
									mysql_query("UPDATE clan_members SET exp = exp + '{$tottal}' WHERE id = '{$_SESSION['myid']}'");
									unset($_SESSION['clan_battle']);
								}
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
								<p class="optionsList autowidth"><strong>Options:</strong><br />';
								if($_SESSION['opponent_profile'][3] == 'gym'){
									echo '<a href="/battle.php?gymleader=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'gymleader=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'side'){
									echo '<a href="/battle.php?sidequest=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'sidequest=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'event'){
									echo '<a href="/battle.php?eventtrainer=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'eventtrainer=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'clan'){
									echo '<a href="/clans.php?view=Battle" class="deselected">Back To Clan Battles</a>';
								}
								else{
									echo '<a href="/battle.php?bid=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'bid=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								echo '</a><br />
								<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
								<a href="/your_pokemon.php" class="deselected">View All Pokemon</a><br />
								<a href="/items.php" class="deselected">Pok&eacute;mart</a></p>';
							}
							else{
								mysql_query("UPDATE members SET btime = '$time', losses = losses + 1 WHERE id = '{$_SESSION['myid']}'");
								if($_SESSION['opponent_profile'][3] == 'clan'){
									mysql_query("UPDATE clans SET losses = losses + 1 WHERE name = '{$_SESSION['clan']}'");
								}
								echo '<h2>Sorry, you lost the battle.</h2>
								<h3>Your team lost to ' . htmlentities($_SESSION['opponent_profile'][1]) . '\'s team.</h3>';
								echo '<p class="optionsList autowidth"><strong>Options:</strong><br />';
								if($_SESSION['opponent_profile'][3] == 'gym'){
									echo '<a href="/battle.php?gymleader=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'gymleader=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'side'){
									echo '<a href="/battle.php?sidequest=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'sidequest=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'event'){
									echo '<a href="/battle.php?eventtrainer=' . $_SESSION['opponent_profile'][1] . '" onclick="get(\'/battle.php\', \'eventtrainer=' . $_SESSION['opponent_profile'][1] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								elseif($_SESSION['opponent_profile'][3] == 'clan'){
									echo '<a href="/clans.php?view=Battle" class="deselected">Back To Clan Battles</a>';
								}
								else{
									echo '<a href="/battle.php?bid=' . $_SESSION['opponent_profile'][0] . '" onclick="get(\'/battle.php\', \'bid=' . $_SESSION['opponent_profile'][0] . '\'); return false;" class="deselected">Rebattle Opponent</a>';
								}
								echo '</a><br />
								<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
								<a href="/your_pokemon.php" class="deselected">View All Pokemon</a><br />
								<a href="/items.php" class="deselected">Pok&eacute;mart</a></p>';
							}
							unset($_SESSION['opponent_profile'],$_SESSION['s1'],$_SESSION['s2'],$_SESSION['s3'],$_SESSION['s4'],$_SESSION['s5'],$_SESSION['s6'],$_SESSION['ops1'],$_SESSION['ops2'],$_SESSION['ops3'],$_SESSION['ops4'],$_SESSION['ops5'],$_SESSION['ops6'],$_SESSION['position'],$_SESSION['your_profile'],$_SESSION['y_p']); 
						}
						elseif($all_dead_u == 0 && $all_dead_op == 0 && !isset($_SESSION['ops1'])){
							echo '<h2>An error has occurred, please refresh the page or return to the battle select page you came from.</h2>';
						}
						else{

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
							if($_SESSION['s'.$i][10] == 0){
								echo " disabled";
							}
							echo '/><img src="html/static/images/pokemon/' . $_SESSION['s'.$i][0] . '.gif" width="96" height="96" /></td><td><strong><a href="/pokedex?pid=' . $_SESSION['s'.$i][1] . '" onclick="pokedexTab(\'pid=' . $_SESSION['s'.$i][1] . '\', 1); return false;">';
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
						echo '<h2>' . htmlentities($_SESSION['opponent_profile'][1]) . '\'s Pok&eacute;mon Team:</h2>
						<h3>The order shown is the order you will battle them in.</h3>
						<table cellspacing="0" cellpadding="0" class="pokemonList">
						<tr>
						<td nowrap="nowrap" id="opponent_pokemon">';
	
						for($i=1;$i<=$_SESSION['opponent_profile'][2];$i++){
							echo '<table cellpadding="3" cellspacing="0"><tr><td>';
							echo '<img src="html/static/images/pokemon/' . $_SESSION['ops'.$i][0] . '.gif" width="96" height="96" /></td><td><p><strong><a href="/pokedex?';
							if($_SESSION['opponent_profile'][3] == 'gym' || $_SESSION['opponent_profile'][3] == 'side' || $_SESSION['opponent_profile'][3] == 'event'){
								echo'dex=' . $_SESSION['ops'.$i][0] . '" onclick="pokedexTab(\'dex=' . $_SESSION['ops'.$i][0] . '\', 1); return false;">';
							}
							else{
								echo'pid=' . $_SESSION['ops'.$i][1] . '" onclick="pokedexTab(\'pid=' . $_SESSION['ops'.$i][1] . '\', 1); return false;">';
							}
							if($_SESSION['ops'.$i][10] == 0){
								echo "<s>";
							}
							echo $_SESSION['ops'.$i][0];
							echo '</a></strong><br /><em>Level:</em> ' . $_SESSION['ops'.$i][4] . '<br /><em>HP:</em> ' . $_SESSION['ops'.$i][10];
							if($_SESSION['ops'.$i][10] == 0){
								echo "</s>";
							}
							echo "</p></td></tr></table>";
						}
						echo '</td></tr></table><input type="hidden" name="action" value="select_attack" />';

						displayNOJSpuzzle();

						echo '
							<p><input type="submit" value="'.generateBattleButtonText('Continue').'" /></p></form>';
						$_SESSION['position'] = 2;
					}
				}
				if(!$_REQUEST['bid'] && !isset($_SESSION['opponent_profile']) && !$_POST['choose']){
					echo '<div class="errorMsg">An error has occurred. Please try again later.</div>';
				}
					
				if(!$_REQUEST['ajax']){

					echo '</div>';
					include('disclaimer.php');
					echo '</div></div>
					</div>
					</div>
					</div>
					</body>
					<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
					</html>';
				} 
				include('pv_disconnect_from_db.php');
				?>