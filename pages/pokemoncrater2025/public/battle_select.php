<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){ // IF LOGIN SESSION IS NOT VALID
	include('pv_disconnect_from_db.php');
	header("location:login?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
$time = time();
if(isset($_POST['submitb'])){
	if($_POST['battle'] == "Username"){ // REQUEST A USERNAME TO BATTLE
		$quer = mysql_query("SELECT * FROM members WHERE username = '{$_POST['buser']}'");
		$query = mysql_fetch_array($quer);
		if(mysql_num_rows($quer) == 1){
			header("location: battle.php?bid={$query['id']}");
			exit();
		}
		else {
			$con = 2;
		}
	}
	else {
		$quer = mysql_query("SELECT * FROM members WHERE id = '{$_POST['buser']}'");
		if(mysql_num_rows($quer) == 1){
			header("location: battle.php?bid={$_POST['buser']}");
			exit();
		}
		else {
			$con = 2;
		}
	}
}
mysql_query("UPDATE online SET activity = 'Looking for an opponent to battle' WHERE id = '{$_SESSION['myid']}'");
$_SESSION['battle_count'] = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<?php
if($_SESSION['layout'] == '1'){ // BLUE LAYOUT
echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){ // RED LAYOUT
echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '2'){ // BLACK LAYOUT
echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
    <script type="text/javascript" language="javascript" src="html/static/js//v3/ie6-.js"></script>
    <link rel="stylesheet" type="text/css" href="html/static/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
    <script type="text/javascript" language="javascript" src="html/static/js//v3/ie7+.js"></script>
    <link rel="stylesheet" type="text/css" href="html/static/css/ie7+.css" media="screen" />
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Shqipe v3 - Battle Select</title>
</head>

<body>
<?php include_once("analytics.php"); ?>
<div id="alert"></div>
<div id="menuBox"></div>
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
<li><a href="logout">Logout</a></li>
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
<li><a href="pokedex.php" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
<li><a href="members.php" id="membersTab" class="deselected"><em>Members</em></a></li>
<li><a href="options.php" id="optionsTab" class="deselected"><em>Options</em></a></li>
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
<?php if($_REQUEST['type'] == "gym"){
	$get_badges = mysql_query("SELECT * FROM badges WHERE id = '{$_SESSION['myid']}'"); // Get completed gyms
	$badges = mysql_fetch_array($get_badges);
	// ------------------------------------------- GYM BATTLES ------------------------------------------ //
	?>
Completing all gyms, elite 4, champions battle frontiers and the battle maison will enable you to find legendary Pokemon on the maps.<br>You can track your progress from this page or from your profile by checking your obtained badges.
<?php
if(!$_REQUEST['region']){
	echo '<br /><br /><br /><br /><h2>Select a league:</h2><p />';
	echo '<a href="battle_select.php?type=gym&region=kanto"><img src="html/static/images/gyms/kanto.png"></a><p />
	<a href="battle_select.php?type=gym&region=orangeislands"><img src="html/static/images/gyms/orangeislands.png"></a><p />
	<a href="battle_select.php?type=gym&region=johto"><img src="http://pokemon-shqipe.co.uk/images/gyms/johto.png"></a><p />
	<a href="battle_select.php?type=gym&region=hoenn"><img src="http://pokemon-shqipe.co.uk/images/gyms/hoenn.png"></a><p />
	<a href="battle_select.php?type=gym&region=sinnoh"><img src="html/static/images/gyms/sinnoh.png"></a><p />
	<a href="battle_select.php?type=gym&region=unova"><img src="html/static/images/gyms/unova.png"></a><p />
	<a href="battle_select.php?type=gym&region=kalos"><img src="html/static/images/gyms/kalos.png"></a><p />';
}

if($_REQUEST['region'] == "kanto"){
	?>
<!---------------------------------------------------------------------------- KANTO ------------------------------------------------------------------------------------->
<p /><a href="battle_select.php?type=gym">Click here</a> to go back to the gym selection page.
<div class="hr"></div><h2>Kanto Pok&eacutemon League</h2><h3>Gyms</h3>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Brock">Pewter City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/brock.gif"style="float: right;"><center>Brock<br />Boulder Badge<br /><img src="html/static/images/badges/boulder.gif"><br /><?php if($badges['g1'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Misty">Cerulean City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/misty.gif"style="float: left;"><center>Misty<br />Cascade Badge<br /><img src="html/static/images/badges/cascade.gif"><br /><?php if($badges['g2'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Lt. Surge">Vermilion City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/lt. surge.gif"style="float: right;"><center>Lt. Surge<br />Thunder Badge<br /><img src="html/static/images/badges/thunder.gif"><br /><?php if($badges['g3'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Erika">Celadon City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/erika.gif"style="float: left;"><center>Erika<br />Rainbow Badge<br /><img src="html/static/images/badges/rainbow.gif"><br /><?php if($badges['g4'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Sabrina">Saffron City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/sabrina.gif"style="float: right;"><center>Sabrina<br />Marsh Badge<br /><img src="html/static/images/badges/marsh.gif"><br /><?php if($badges['g5'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Janine">Fuchsia City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/janine.gif"style="float: left;"><center>Janine<br />Soul Badge<br /><img src="html/static/images/badges/soul.gif"><br /><?php if($badges['g6'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Blaine">Cinnabar Island Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/blaine.gif"style="float: right;"><center>Blaine<br />Volcano Badge<br /><img src="html/static/images/badges/volcano.gif"><br /><?php if($badges['g7'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Giovanni">Viridian City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/giovanni.gif"style="float: left;"><center>Giovanni<br />Earth Badge<br /><img src="html/static/images/badges/earth.gif"><br /><?php if($badges['g8'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Elite 4</h3>
<table cellspacing="5" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Will">#1) Will</a></center><br /></strong><img src="html/static/images/sprites/trainers/will.gif"style="float: right;"><center>Will<br />Will's Elite Badge<br /><?php if($badges['g46'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Koga">#2) Koga</a></center><br /></strong><img src="html/static/images/sprites/trainers/koga.gif"style="float: left;"><center>Koga<br />Koga's Elite Badge<br /><?php if($badges['g47'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Bruno">#3) Bruno</a></center><br /></strong><img src="html/static/images/sprites/trainers/bruno.gif"style="float: right;"><center>Bruno<br />Bruno's Elite Badge<br /><?php if($badges['g48'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Karen">#4) Karen</a></center><br /></strong><img src="html/static/images/sprites/trainers/karen.gif"style="float: left;"><center>Karen<br />Karen's Elite Badge<br /><?php if($badges['g49'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Champion</h3><center>
<div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Blue">Kanto Champion</a></center><br /></strong><img src="html/static/images/sprites/trainers/blue.gif"style="float: left;"><center>Blue<br />Kanto League Champion<br /><?php if($badges['g62'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br /><br /><br />


<?php
}
if($_REQUEST['region'] == "orangeislands"){
?>
<!--------------------------------------------------------------------------- ORANGE ISLANDS ------------------------------------------------------------------------------>
<p /><a href="battle_select.php?type=gym">Click here</a> to go back to the gym selection page.
<div class="hr"></div><h2>Orange Crew</h2><h3>Gyms</h3>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Cissy">Mikan Island Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/cissy.gif"style="float: right;"><center>Cissy<br />Coral Eye Badge<br /><img src="html/static/images/badges/coral.gif"><br /><?php if($badges['g9'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Danny">Navel Island Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/danny.gif"style="float: left;"><center>Danny<br />Sea Ruby Badge<br /><img src="html/static/images/badges/ruby.gif"><br /><?php if($badges['g10'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Rudy">Trovita Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/rudy.gif"style="float: right;"><center>Rudy<br />SpikeShellBadge<br /><img src="html/static/images/badges/spike.gif"><br /><?php if($badges['g11'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Luana">Kumquat Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/luana.gif"style="float: left;"><center>Luana<br />Jade Star Badge<br /><img src="html/static/images/badges/jade.gif"><br /><?php if($badges['g12'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table><center>
<div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Champion Drake">Pummelo Stadium</a></center><br /></strong><img src="html/static/images/sprites/trainers/championdrake.gif"style="float: left;"><center>Drake<br />Winners Trophy<br /><img src="html/static/images/badges/winners trophy.gif"><br /><?php if($badges['g13'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br /><br /><br />


<?php
}
if($_REQUEST['region'] == "johto"){
?>
<!---------------------------------------------------------------------------- JOHTO ------------------------------------------------------------------------------------->
<p /><a href="battle_select.php?type=gym">Click here</a> to go back to the gym selection page.
<div class="hr"></div><h2>Johto Pok&eacutemon League</h2><h3>Gyms</h3>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Falkner">Violet City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/falkner.gif"style="float: right;"><center>Falkner<br />Zephyr Badge<br /><img src="html/static/images/badges/zephyr.gif"><br /><?php if($badges['g14'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Bugsy">Azalea Town Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/bugsy.gif"style="float: left;"><center>Bugsy<br />Hive Badge<br /><img src="html/static/images/badges/hive.gif"><br /><?php if($badges['g15'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Whitney">Goldenrod City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/whitney.gif"style="float: right;"><center>Whitney<br />Plain Badge<br /><img src="html/static/images/badges/plain.gif"><br /><?php if($badges['g16'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Morty">Ecruteak City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/morty.gif"style="float: left;"><center>Morty<br />Fog Badge<br /><img src="html/static/images/badges/fog.gif"><br /><?php if($badges['g17'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Chuck">Cianwood City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/chuck.gif"style="float: right;"><center>Chuck<br />Storm Badge<br /><img src="html/static/images/badges/storm.gif"><br /><?php if($badges['g18'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Jasmine">Olivine City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/jasmine.gif"style="float: left;"><center>Jasmine<br />Mineral Badge<br /><img src="html/static/images/badges/mineral.gif"><br /><?php if($badges['g19'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Pryce">Mahogany City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/pryce.gif"style="float: right;"><center>Pryce<br />Glacier Badge<br /><img src="html/static/images/badges/glacier.gif"><br /><?php if($badges['g20'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Clair">Blackthorn City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/clair.gif"style="float: left;"><center>Clair<br />Rising Badge<br /><img src="html/static/images/badges/rising.gif"><br /><?php if($badges['g21'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Elite 4</h3>
<table cellspacing="5" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Will">#1) Will</a></center><br /></strong><img src="html/static/images/sprites/trainers/will.gif"style="float: right;"><center>Will<br />Will's Elite Badge<br /><?php if($badges['g46'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>


<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Koga">#2) Koga</a></center><br /></strong><img src="html/static/images/sprites/trainers/koga.gif"style="float: left;"><center>Koga<br />Koga's Elite Badge<br /><?php if($badges['g47'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Bruno">#3) Bruno</a></center><br /></strong><img src="http://pokemon-shqipe.co.uk/images/sprites/trainers/bruno.gif"style="float: right;"><center>Bruno<br />Bruno's Elite Badge<br /><?php if($badges['g48'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Karen">#4) Karen</a></center><br /></strong><img src="html/static/images/sprites/trainers/karen.gif"style="float: left;"><center>Karen<br />Karen's Elite Badge<br /><?php if($badges['g49'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Champion</h3><center>
<div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Lance">Johto Champion</a></center><br /></strong><img src="html/static/images/sprites/trainers/lance.gif"style="float: left;"><center>Lance<br />Johto League Champion<br /><?php if($badges['g63'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br /><br /><br />
<?php
}
if($_REQUEST['region'] == "hoenn"){
?>
<!---------------------------------------------------------------------------- HOENN ------------------------------------------------------------------------------------->
<p /><a href="battle_select.php?type=gym">Click here</a> to go back to the gym selection page.
<div class="hr"></div><h2>Hoenn Pok&eacutemon League</h2><h3>Gyms</h3>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Roxanne">Rustboro City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/roxanne.gif"style="float: right;"><center>Roxanne<br />Stone Badge<br /><img src="html/static/images/badges/stone.gif"><br /><?php if($badges['g22'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Brawly">Dewford Town Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/brawly.gif"style="float: left;"><center>Brawly<br />Knuckle Badge<br /><img src="html/static/images/badges/knuckle.gif"><br /><?php if($badges['g23'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Wattson">Mauville City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/wattson.gif"style="float: right;"><center>Wattson<br />Dynamo Badge<br /><img src="html/static/images/badges/dynamo.gif"><br /><?php if($badges['g24'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Flannery">Lavaridge City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/flannery.gif"style="float: left;"><center>Flannery<br />Heat Badge<br /><img src="html/static/images/badges/heat.gif"><br /><?php if($badges['g25'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Norman">Petalburg City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/norman.gif"style="float: right;"><center>Norman<br />Balance Badge<br /><img src="html/static/images/badges/balance.gif"><br /><?php if($badges['g26'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Winona">Fortree City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/winona.gif"style="float: left;"><center>Winona<br />Feather Badge<br /><img src="html/static/images/badges/feather.gif"><br /><?php if($badges['g27'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Liza and Tate">Mossdeep City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/lizaandtate.gif"style="float: right;"><center>Liza and Tate<br />Mind Badge<br /><img src="html/static/images/badges/mind.gif"><br /><?php if($badges['g28'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Juan">Sootopolis City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/juan.gif"style="float: left;"><center>Juan<br />Rain Badge<br /><img src="html/static/images/badges/rain.gif"><br /><?php if($badges['g64'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Elite 4</h3>
<table cellspacing="5" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Sidney">#1) Sidney</a></center><br /></strong><img src="html/static/images/sprites/trainers/sidney.gif"style="float: right;"><center>Sidney<br />Sidney's Elite Badge<br /><?php if($badges['g50'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Phoebe">#2) Phoebe</a></center><br /></strong><img src="html/static/images/sprites/trainers/phoebe.gif"style="float: left;"><center>Phoebe<br />Phoebe's Elite Badge<br /><?php if($badges['g51'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Glacia">#3) Glacia</a></center><br /></strong><img src="html/static/images/sprites/trainers/glacia.gif"style="float: right;"><center>Glacia<br />Glacia's Elite Badge<br /><?php if($badges['g52'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Drake">#4) Drake</a></center><br /></strong><img src="html/static/images/sprites/trainers/drake.gif"style="float: left;"><center>Drake<br />Drake's Elite Badge<br /><?php if($badges['g53'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Champion</h3><center>
<div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Wallace">Hoenn Champion</a></center><br /></strong><img src="html/static/images/sprites/trainers/wallace.gif"style="float: left;"><center>Wallace<br />Hoenn League Champion<br /><?php if($badges['g29'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br /><br /><br />

<?php
}
if($_REQUEST['region'] == "sinnoh"){
?>
<!---------------------------------------------------------------------------- SINNOH ------------------------------------------------------------------------------------->
<p /><a href="battle_select.php?type=gym">Click here</a> to go back to the gym selection page.
<div class="hr"></div><h2>Sinnoh Pok&eacutemon League</h2><h3>Gyms</h3>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Roark">Oreburgh City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/roark.gif"style="float: right;"><center>Roark<br />Coal Badge<br /><img src="html/static/images/badges/coal.gif"><br /><?php if($badges['g30'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Gardenia">Eterna City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/gardenia.gif"style="float: left;"><center>Gardenia<br />Forest Badge<br /><img src="html/static/images/badges/forest.gif"><br /><?php if($badges['g31'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Maylene">Veilstone City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/maylene.gif"style="float: right;"><center>Maylene<br />Cobble Badge<br /><img src="html/static/images/badges/cobble.gif"><br /><?php if($badges['g32'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Wake">Pastoria City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/wake.gif"style="float: left;"><center>Crasher Wake<br />Fen Badge<br /><img src="html/static/images/badges/fen.gif"><br /><?php if($badges['g33'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Fantina">Hearthome City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/fantina.gif"style="float: right;"><center>Fantina<br />Relic Badge<br /><img src="html/static/images/badges/relic.gif"><br /><?php if($badges['g34'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Byron">Canalave City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/byron.gif"style="float: left;"><center>Byron<br />Mine Badge<br /><img src="html/static/images/badges/mine.gif"><br /><?php if($badges['g35'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Candice">Snowpoint City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/candice.gif"style="float: right;"><center>Candice<br />Icicle Badge<br /><img src="html/static/images/badges/icicle.gif"><br /><?php if($badges['g36'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Volkner">Sunyshore City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/volkner.gif"style="float: left;"><center>Volkner<br />Beacon Badge<br /><img src="html/static/images/badges/beacon.gif"><br /><?php if($badges['g37'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Elite 4</h3>
<table cellspacing="5" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Aaron">#1) Aaron</a></center><br /></strong><img src="html/static/images/sprites/trainers/aaron.gif"style="float: right;"><center>Aaron<br />Aaron's Elite Badge<br /><?php if($badges['g54'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Bertha">#2) Bertha</a></center><br /></strong><img src="html/static/images/sprites/trainers/bertha.gif"style="float: left;"><center>Bertha<br />Bertha's Elite Badge<br /><?php if($badges['g55'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Flint">#3) Flint</a></center><br /></strong><img src="html/static/images/sprites/trainers/flint.gif"style="float: right;"><center>Flint<br />Flint's Elite Badge<br /><?php if($badges['g56'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Lucian">#4) Lucian</a></center><br /></strong><img src="html/static/images/sprites/trainers/lucian.gif"style="float: left;"><center>Lucian<br />Lucian's Elite Badge<br /><?php if($badges['g57'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Champion</h3><center>
<div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Cynthia">Sinnoh Champion</a></center><br /></strong><img src="html/static/images/sprites/trainers/cynthia.gif"style="float: left;"><center>Cynthia<br />Sinnoh League Champion<br /><?php if($badges['g65'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br /><br /><br />
<?php
}
if($_REQUEST['region'] == "unova"){
?>
<!---------------------------------------------------------------------------- UNOVA ------------------------------------------------------------------------------------->
<p /><a href="battle_select.php?type=gym">Click here</a> to go back to the gym selection page.
<div class="hr"></div><h2>Unova Pok&eacutemon League</h2><h3>Gyms</h3>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Cheren">Aspertia City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/cheren.gif"style="float: right;"><center>Cheren<br />Basic Badge<br /><img src="html/static/images/badges/basic.gif"><br /><?php if($badges['g38'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Roxie">Virbank City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/roxie.gif"style="float: left;"><center>Roxie<br />Toxic Badge<br /><img src="html/static/images/badges/toxic.gif"><br /><?php if($badges['g39'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Burgh">Castelia City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/burgh.gif"style="float: right;"><center>Burgh<br />Insect Badge<br /><img src="html/static/images/badges/insect.gif"><br /><?php if($badges['g40'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Elesa">Nimbasa City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/elesa.gif"style="float: left;"><center>Elesa<br />Bolt Badge<br /><img src="html/static/images/badges/bolt.gif"><br /><?php if($badges['g41'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Clay">Driftveil City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/clay.gif"style="float: right;"><center>Clay<br />Quake Badge<br /><img src="html/static/images/badges/quake.gif"><br /><?php if($badges['g42'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Skyla">Mistralton City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/skyla.gif"style="float: left;"><center>Skyla<br />Jet Badge<br /><img src="html/static/images/badges/jet.gif"><br /><?php if($badges['g43'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Drayden">Opelucid City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/drayden.gif"style="float: right;"><center>Drayden<br />Legend Badge<br /><img src="html/static/images/badges/legend.gif"><br /><?php if($badges['g44'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Marlon">Humilau City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/marlon.gif"style="float: left;"><center>Marlon<br />Wave Badge<br /><img src="html/static/images/badges/wave.gif"><br /><?php if($badges['g45'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Elite 4</h3>
<table cellspacing="5" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Shauntal">#1) Shauntal</a></center><br /></strong><img src="html/static/images/sprites/trainers/shauntal.gif"style="float: right;"><center>Shauntal<br />Shauntal's Elite Badge<br /><?php if($badges['g58'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Marshal">#2) Marshal</a></center><br /></strong><img src="html/static/images/sprites/trainers/marshal.gif"style="float: left;"><center>Marshal<br />Marshal's Elite Badge<br /><?php if($badges['g61'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Grimsley">#3) Grimsley</a></center><br /></strong><img src="html/static/images/sprites/trainers/grimsley.gif"style="float: right;"><center>Grimsley<br />Grimsley's Elite Badge<br /><?php if($badges['g59'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Caitlin">#4) Caitlin</a></center><br /></strong><img src="html/static/images/sprites/trainers/caitlin.gif"style="float: left;"><center>Caitlin<br />Caitlin's Elite Badge<br /><?php if($badges['g60'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Champion</h3><center>
<div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Iris">Unova Champion</a></center><br /></strong><img src="html/static/images/sprites/trainers/iris.gif"style="float: left;"><center>Iris<br />Unova League Champion<br /><?php if($badges['g66'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br /><br /><br />
<?php
}
if($_REQUEST['region'] == "kalos"){
?>
<!---------------------------------------------------------------------------- KALOS ------------------------------------------------------------------------------------->
<p /><a href="battle_select.php?type=gym">Click here</a> to go back to the gym selection page.
<div class="hr"></div><h2>Kalos Pok&eacutemon League</h2><h3>Gyms</h3>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">

<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Viola">Santalune City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/viola.gif"style="float: right;"><center>Viola<br />Bug Badge<br /><img src="html/static/images/badges/bug.gif"><br /><?php if($badges['g79'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Grant">Cyllage City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/grant.gif"style="float: left;"><center>Grant<br />Cliff Badge<br /><img src="html/static/images/badges/cliff.gif"><br /><?php if($badges['g80'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Korrina">Shalour City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/korrina.gif"style="float: right;"><center>Korrina<br />Rumble Badge<br /><img src="html/static/images/badges/rumble.gif"><br /><?php if($badges['g81'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Ramos">Coumarine City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/ramos.gif"style="float: left;"><center>Ramos<br />Plant Badge<br /><img src="html/static/images/badges/plant.gif"><br /><?php if($badges['g82'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Clemont">Lumiose City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/clemont.gif"style="float: right;"><center>Clemont<br />Voltage Badge<br /><img src="html/static/images/badges/voltage.gif"><br /><?php if($badges['g83'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Valerie">Laverre City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/valerie.gif"style="float: left;"><center>Valerie<br />Fairy Badge<br /><img src="html/static/images/badges/fairy.gif"><br /><?php if($badges['g84'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Olympia">Anistar City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/olympia.gif"style="float: right;"><center>Olympia<br />Psychic Badge<br /><img src="html/static/images/badges/psychic.gif"><br /><?php if($badges['g85'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Wulfric">Snowbelle City Gym</a></center><br /></strong><img src="html/static/images/sprites/trainers/wulfric.gif"style="float: left;"><center>Wulfric<br />Iceberg Badge<br /><img src="html/static/images/badges/iceberg.gif"><br /><?php if($badges['g86'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Elite 4</h3>
<table cellspacing="5" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Wikstrom">#1) Wikstrom</a></center><br /></strong><img src="html/static/images/sprites/trainers/wikstrom.gif"style="float: right;"><center>Wikstrom<br />Wikstrom's Elite Badge<br /><?php if($badges['g88'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Malva">#2) Malva</a></center><br /></strong><img src="html/static/images/sprites/trainers/malva.gif"style="float: left;"><center>Malva<br />Malva's Elite Badge<br /><?php if($badges['g87'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Drasna">#3) Drasna</a></center><br /></strong><img src="html/static/images/sprites/trainers/drasna.gif"style="float: right;"><center>Drasna<br />Drasna's Elite Badge<br /><?php if($badges['g89'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Siebold">#4) Siebold</a></center><br /></strong><img src="html/static/images/sprites/trainers/siebold.gif"style="float: left;"><center>Siebold<br />Siebold's Elite Badge<br /><?php if($badges['g90'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr></table>
<h3>Champion</h3><center>
<div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Diantha">Kalos Champion</a></center><br /></strong><img src="html/static/images/sprites/trainers/diantha.gif"style="float: left;"><center>Diantha<br />Kalos League Champion<br /><?php if($badges['g91'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br /><br /><br />
<?php
}
} // ------------------------------------------- FRONTIER BATTLES ------------------------------------------ //
if($_REQUEST['type'] == "frontier"){
	$get_badges = mysql_query("SELECT * FROM badges WHERE id = '{$_SESSION['myid']}'"); // Get completed gyms
	$badges = mysql_fetch_array($get_badges);
	?>
<div style="margin-right:65px;">
Complete each of the battle frontiers and the Kalos battle maison for them to be added to your badges profile.<br />
Completing all gyms, elite 4's, champions, battle frontiers and the battle maison will enable you to find legendary Pokemon on the maps.<br /><a href="battle_select.php?type=frontier">Click here</a> to go back to the battle frontier selection page.<br /><br /></div>
<?php
if(!$_REQUEST['region']){
	?>
	<h3>Select a battle institution</h3>
    <a href="/battle_select.php?type=frontier&region=hoenn"><img src="html/static/images/gyms/hbf.png" /></a><p />
    <a href="/battle_select.php?type=frontier&region=sinnoh"><img src="html/static/images/gyms/sbf.png" /></a><p />
    <a href="/battle_select.php?type=frontier&region=kalos"><img src="html/static/images/gyms/battlemaison.png" /></a><p />

<?php
}
if($_REQUEST['region'] == "hoenn"){
	?>
<h2>Hoenn Battle Frontier</h2>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Salon Maiden Anabel">Battle Tower</a></center><br /></strong><img src="html/static/images/sprites/trainers/anabel.gif"style="float: right;"><center>Salon Maiden Anabel<br />Ability Symbol<br /><img src="html/static/images/badges/ability symbol.gif"><br /><?php if($badges['g67'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Palace Mavern Spenser">Battle Palace</a></center><br /></strong><img src="html/static/images/sprites/trainers/spenser.gif"style="float: left;"><center>Palace Mavern Spenser<br />Spirit Symbol<br /><img src="html/static/images/badges/spirit symbol.gif"><br /><?php if($badges['g68'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Factory Head Noland">Battle Factory</a></center><br /></strong><img src="html/static/images/sprites/trainers/noland.gif"style="float: right;"><center>Factory Head Noland<br />Knowledge Symbol<br /><img src="html/static/images/badges/knowledge symbol.gif"><br /><?php if($badges['g69'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Pyramid King Brandon">Battle Pyramid</a></center><br /></strong><img src="html/static/images/sprites/trainers/brandon.gif"style="float: left;"><center>Pyramid King Brandon<br />Brave Symbol<br /><img src="html/static/images/badges/brave symbol.gif"><br /><?php if($badges['g70'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?><br /></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Dome Ace Tucker">Battle Dome</a></center><br /></strong><img src="html/static/images/sprites/trainers/tucker.gif"style="float: right;"><center>Dome Ace Tucker<br />Tactics Symbol<br /><img src="html/static/images/badges/tactics symbol.gif"><br /><?php if($badges['g71'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Arena Tycoon Greta">Battle Arena</a></center><br /></strong><img src="html/static/images/sprites/trainers/greta.gif"style="float: left;"><center>Arena Tycoon Greta<br />Guts Symbol<br /><img src="html/static/images/badges/guts symbol.gif"><br /><?php if($badges['g72'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
</table>
<p /><center><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Pike Queen Lucy">Battle Pike</a></center><br /></strong><img src="html/static/images/sprites/trainers/lucy.gif" style="float: left;" /><center>Pike Queen Lucy<br />Luck Symbol<br /><img src="html/static/images/badges/luck symbol.gif" /><br /><?php if($badges['g73'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><br /><br /><br />

<?php
}
if($_REQUEST['region'] == "sinnoh"){
	?>
    <h2>Sinnoh Battle Frontier</h2>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Tower Tycoon Palmer">Battle Tower</a></center><br /></strong><img src="html/static/images/sprites/trainers/palmer.gif"style="float: right;"><center>Tower Tycoon Palmer<br />Palmer Symbol<br /><img src="html/static/images/badges/palmer symbol.gif"><br /><?php if($badges['g74'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Factory Head Thorton">Battle Factory</a></center><br /></strong><img src="html/static/images/sprites/trainers/thorton.gif"style="float: left;"><center>Factory Head Thorton<br />Thorton Symbol<br /><img src="html/static/images/badges/thorton symbol.gif"><br /><?php if($badges['g75'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Arcade Star Dahlia">Battle Arcade</a></center><br /></strong><img src="html/static/images/sprites/trainers/dahlia.gif"style="float: right;"><center>Arcade Star Dahlia<br />Dahlia Symbol<br /><img src="html/static/images/badges/dahlia symbol.gif"><br /><?php if($badges['g76'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Castle Valet Darach">Battle Castle</a></center><br /></strong><img src="html/static/images/sprites/trainers/darach.gif"style="float: left;"><center>Castle Valet Darach<br />Darach Symbol<br /><img src="html/static/images/badges/darach symbol.gif"><br /><?php if($badges['g77'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
</table>
<p /><center><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Hall Matron Argenta">Battle Hall</a></center><br /></strong><img src="html/static/images/sprites/trainers/argenta.gif" style="float: left;" /><center>Hall Matron Argenta<br />Argenta Symbol<br /><img src="html/static/images/badges/argenta symbol.gif" /><br /><?php if($badges['g78'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></center><p />
<?php
}
if($_REQUEST['region'] == "kalos"){
	?>
<h2><br />Kalos Battle Maison</h2>
<table cellspacing="7" cellpadding="0" style="width: 60%; margin: 0 auto; text-align: left;">
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Battle Chatelaine Nita">Battle Chatelaine Nita</a></center><br /></strong><img src="html/static/images/sprites/trainers/nita.gif"style="float: right;"><center><?php if($badges['g92'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Battle Chatelaine Evelyn">Battle Chatelaine Evelyn</a></center><br /></strong><img src="html/static/images/sprites/trainers/evelyn.gif"style="float: left;"><center><?php if($badges['g93'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
<tr>
<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Battle Chatelaine Dana">Battle Chatelaine Dana</a></center><br /></strong><img src="html/static/images/sprites/trainers/dana.gif"style="float: right;"><center><?php if($badges['g94'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>

<td><div id="rightbarContainer"><div id="rightbarTop"></div><div id="rightbar"><div id="rightbarContent">
<strong><center><a href="battle.php?gymleader=Battle Chatelaine Morgan">Battle Chatelaine Morgan</a></center><br /></strong><img src="html/static/images/sprites/trainers/morgan.gif"style="float: left;"><center><?php if($badges['g95'] == '1'){ echo '<font color="green">Complete</font>'; }else{ echo '<font color="red">Incomplete</font>';} ?></center></div></div><div id="rightbarBottom"></div></div></td>
</tr>
</table>
<?php } ?>

<?php
} // ------------------------------------------- EVENT BATTLES ------------------------------------------ //
if($_REQUEST['type'] == "event"){
	$get_events = mysql_query("SELECT * FROM events WHERE id = '{$_SESSION['myid']}'"); // Get completed events
	$events = mysql_fetch_array($get_events);
	?>
<div style="margin-right:65px;">
You must defeat each trainer from the set to complete the event and obtain the events badge.<br>Every so often we will hold special one off events, they will be at the bottom of the page.<br />
<a href="battle_select.php?type=event">Click here</a> to go back to the event selection page.<p />

<?php
if(!$_REQUEST['team']){
	?>
	<a href="battle_select.php?type=event&team=rocket"><img src="html/static/images/gyms/teamrocket.png" /></a><p />
    <a href="battle_select.php?type=event&team=aqua"><img src="html/static/images/gyms/teamaqua.png" /></a><p />
    <a href="battle_select.php?type=event&team=magma"><img src="html/static/images/gyms/teammagma.png" /></a><p />
    <a href="battle_select.php?type=event&team=galactic"><img src="html/static/images/gyms/teamgalactic.png" /></a><p />
    <a href="battle_select.php?type=event&team=plasma"><img src="html/static/images/gyms/teamplasma.png" /></a><p />
    <a href="battle_select.php?type=event&team=flare"><img src="html/static/images/gyms/teamflare.png" /></a><p />
    <a href="battle_select.php?type=event&team=admins"><img src="html/static/images/gyms/admins.png" /></a><p />
    <?php
}
if($_REQUEST['team'] == "rocket"){
	?>
<h2>Team Rocket</h2>
<table cellspacing="7" cellpadding="0" style="width: 80%; margin: 0 auto; text-align: left;">
<tr><td><h4><strong><a href="battle.php?eventtrainer=James">James</a></strong></h4><p><img src="html/static/images/sprites/events/james.gif" style="float: left;"></p></td><td><h4><strong><a href="battle.php?eventtrainer=Jessie">Jessie</a></strong></h4><p><img src="html/static/images/sprites/events/jessie.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Butch">Butch</a></strong></h4><p><img src="html/static/images/sprites/events/butch.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Cassidy">Cassidy</a></strong></h4><p><img src="html/static/images/sprites/events/cassidy.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Rocket Giovanni">Giovanni</a></strong></h4><p><img src="html/static/images/sprites/trainers/giovanni.gif" style="float: left;"></td></tr></table>
<?php
}
if($_REQUEST['team'] == "aqua"){
	?>
<h2><br>Team Aqua</h2><table border="0" cellspacing="5" cellpadding="0" style="width: 80%; margin: 0 auto 0 auto; text-align: left;"><tr><td><h4><strong><a href="battle.php?eventtrainer=Mellisa">Mellisa</a></strong></h4><p><img src="html/static/images/sprites/events/mellisa.gif" style="float: left;"></p></td><td><h4><strong><a href="battle.php?eventtrainer=Amber">Amber</a></strong></h4><p><img src="html/static/images/sprites/events/amber.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Matt">Matt</a></strong></h4><p><img src="html/static/images/sprites/events/matt.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Shelly">Shelly</a></strong></h4><p><img src="html/static/images/sprites/events/shelly.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Archie">Archie</a></strong></h4><p><img src="html/static/images/sprites/events/archie.gif" style="float: left;"></td></tr></table>
<?php
}
if($_REQUEST['team'] == "magma"){
	?>
<h2><br>Team Magma</h2><table border="0" cellspacing="5" cellpadding="0" style="width: 80%; margin: 0 auto 0 auto; text-align: left;"><tr><td><h4><strong><a href="battle.php?eventtrainer=Kate">Kate</a></strong></h4><p><img src="html/static/images/sprites/events/kate.gif" style="float: left;"></p></td><td><h4><strong><a href="battle.php?eventtrainer=Mack">Mack</a></strong></h4><p><img src="html/static/images/sprites/events/mack.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Courtney">Courtney</a></strong></h4><p><img src="html/static/images/sprites/events/courtney.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Tabitha">Tabitha</a></strong></h4><p><img src="html/static/images/sprites/events/tabitha.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Maxie">Maxie</a></strong></h4><p><img src="html/static/images/sprites/events/maxie.gif" style="float: left;"></td></tr></table>
<?php
}
if($_REQUEST['team'] == "galactic"){
	?>
<h2><br>Team Galactic</h2><table border="0" cellspacing="5" cellpadding="0" style="width: 80%; margin: 0 auto 0 auto; text-align: left;"><tr><td><h4><strong><a href="battle.php?eventtrainer=Sird">Sird</a></strong></h4><p><img src="html/static/images/sprites/events/sird.gif" style="float: left;"></p></td><td><h4><strong><a href="battle.php?eventtrainer=Jupiter">Jupiter</a></strong></h4><p><img src="html/static/images/sprites/events/jupiter.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Saturn">Saturn</a></strong></h4><p><img src="html/static/images/sprites/events/saturn.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Mars">Mars</a></strong></h4><p><img src="html/static/images/sprites/events/mars.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Cyrus">Cyrus</a></strong></h4><p><img src="html/static/images/sprites/events/cyrus.gif" style="float: left;"></td></tr></table>
<?php
}
if($_REQUEST['team'] == "plasma"){
	?>
<h2><br>Team Plasma</h2><table border="0" cellspacing="5" cellpadding="0" style="width: 80%; margin: 0 auto 0 auto; text-align: left;"><tr><td><h4><strong><a href="battle.php?eventtrainer=Plasma Grunt">Plasma Grunt</a></strong></h4><p><img src="html/static/images/sprites/events/plasmagrunt.gif" style="float: left;"></p></td><td><h4><strong><a href="battle.php?eventtrainer=Plasma Grunt 2">Plasma Grunt 2</a></strong></h4><p><img src="html/static/images/sprites/events/plasmagrunt2.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=N">N</a></strong></h4><p><img src="html/static/images/sprites/events/n.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Ghetsis">Ghetsis</a></strong></h4><p><img src="html/static/images/sprites/events/geechisu.gif" style="float: left;"></td></tr></table>
<?php
}
if($_REQUEST['team'] == "flare"){
	?>
<h2><br>Team Flare</h2><table border="0" cellspacing="5" cellpadding="0" style="width: 80%; margin: 0 auto 0 auto; text-align: left;"><tr><td><h4><strong><a href="battle.php?eventtrainer=Aliana">Aliana</a></strong></h4><p><img src="html/static/images/sprites/events/aliana.gif" style="float: left;"></p></td><td><h4><strong><a href="battle.php?eventtrainer=Bryony">Bryony</a></strong></h4><p><img src="html/static/images/sprites/events/bryony.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Celosia">Celosia</a></strong></h4><p><img src="html/static/images/sprites/events/celosia.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Mable">Mable</a></strong></h4><p><img src="html/static/images/sprites/events/mable.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Xerosic">Xerosic</a></strong></h4><p><img src="html/static/images/sprites/events/xerosic.gif" style="float: left;"></td>
<td><h4><strong><a href="battle.php?eventtrainer=Lysandre">Lysandre</a></strong></h4><p><img src="html/static/images/sprites/events/lysandre.gif" style="float: left;"></td></tr></table>
<?php
}
if($_REQUEST['team'] == "admins"){
	?>
<h2><br>Shqipe Admins</h2><table border="0" cellspacing="5" cellpadding="0" style="width: 80%; margin: 0 auto 0 auto; text-align: left;"><tr><td><h4><strong><a href="battle.php?eventtrainer=Rob">Rob</a></strong></h4><p><img src="html/static/images/sprites/events/rob.gif" style="float: left;"></td><td><h4><strong><a href="battle.php?eventtrainer=Patrick">Patrick</a></strong></h4><p><img src="html/static/images/sprites/events/patrick.gif" style="float: left;"></td></tr></table>
<?php } ?>

</div>
<?php
}
if($_REQUEST['type'] == "member"){
	if($con == 2){ ?>
<div class="errorMsg">No specified match was found for the member you entered.</div><? } ?>
<form method="post">
Search: <select name="battle"><option>Username</option><option>User ID</option></select> <input type="text" name="buser">
<p><span class="small">You must provide an exact username to find a member.</span></p>
<br><input name="submitb" type="submit" value="Battle!"></form>
<?php
}
if($_REQUEST['type'] == "live"){ ?>
<div class="errorMsg">This feature has not yet been completed. Be patient and we'll do our hardest to make it.</div>
<p class="optionsList autowidth"><strong>Options:</strong><br />
<a href="/dashboard" class="deselected">Dashboard</a><br />
<a href="/your_team" class="deselected">View/Modify Team</a><br />
<a href="/your_pokemon" class="deselected">View All Pokemon</a></p>
<?php
}

if($_REQUEST['type'] != 'live' && $_REQUEST['type'] != 'member' && $_REQUEST['type'] != 'frontier' && $_REQUEST['type'] != 'gym' && $_REQUEST['type'] != 'event'){ ?>
<h2>Battle Options</h2><div style="text-align: center; width: 350px; margin: 0 auto 0 auto;">
<p><img src="html/static/images/misc/gym.gif" title="gym"></p>
<h3><br /><a href="/battle_select.php?type=gym">Battle In a Gym.</a></h3>
<p>Battle all your favourite gyms leaders from the different regions. Fight the Elite Four from all regions and become a pok&eacute;mon master!</p>
<h3><br /><a href="/sidequest">Sidequests</a></h3>
<p>Battle difficult trainers for prizes and more.</p>
<h3><br /><a href="/battle_select.php?type=live">Battle Online Members</a></h3>
<p>Battle an online member. For those who would like to test their battling skill.</p>
<h3><br /><a href="/battle_select.php?type=member">Battle Computer Controlled Members</a></h3>
<p>Battle any member that has joined the game. Their account will be computer controlled.</p>
<h3><br /><a href="battle_select.php?type=event">Event Battles</a></h3>
<p>Battle the set events such as Team Rocket and special events set at certain periods of the year.</p>
</div>
<?php
}
?>
</div>
<?php include('disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php include('pv_disconnect_from_db.php'); ?>