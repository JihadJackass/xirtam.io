<?php
include('kick.php');
if(!isset($_SESSION['myid'])){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');

if($_POST['claim'] && $_POST['kantoprize']){ // Claim prize for Kanto Sidequests
	$side = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideq = mysql_fetch_array($side);
	if($sideq['sidequest'] == '102'){ // Make sure the session is correct for the prize
		$_SESSION['sidequest'] += 1;
		mysql_query("UPDATE members SET sidequest = sidequest + 1 WHERE id = '{$_SESSION['myid']}'");
		$money = rand(20000,30000); // Random money prize between $20,000 and $30,000
		mysql_query("UPDATE members SET money = money + $money WHERE id = '{$_SESSION['myid']}'");
		$fossil = rand(1,3); // Random Kanto fossil prize
		$kanto = 1;
		if($fossil == '1'){
			$prize = "a Helix Fossil";
			mysql_query("UPDATE items SET Helix_Fossil = Helix_Fossil + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
		elseif($fossil == '2'){
			$prize = "a Dome Fossil";
			mysql_query("UPDATE items SET Dome_Fossil = Dome_Fossil + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
		elseif($fossil == '3'){
			$prize = "an Old Amber";
			mysql_query("UPDATE items SET Old_Amber = Old_Amber + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
	}
}
if($_POST['claim'] && $_POST['johtoprize']){ // Claim prize for Johto Sidequests
	$side = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideq = mysql_fetch_array($side);
	if($sideq['sidequest'] == '206'){ // Make sure the session is correct for the prize
		$_SESSION['sidequest'] += 1;
		mysql_query("UPDATE members SET sidequest = sidequest + 1 WHERE id = '{$_SESSION['myid']}'");
		$johto = 1;
		$money = rand(20000,30000); // Random money prize between $20,000 and $30,000
		mysql_query("UPDATE members SET money = money + $money WHERE id = '{$_SESSION['myid']}'");
		$item = rand(1,3); // Random Johto item prize
		if($item == '1'){
			$prize = "50 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 50 WHERE uid = '{$_SESSION['myid']}'");
		}
		elseif($item == '2'){
			$prize = "a Latiasite";
			mysql_query("UPDATE items SET Latiasite = Latiasite + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
		elseif($item == '3'){
			$prize = "a Latiosite";
			mysql_query("UPDATE items SET Latiosite = Latiosite + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
	}
}
if($_POST['claim'] && $_POST['seviiislandsprize']){ // Claim prize for Sevii Islands Sidequests
	$side = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideq = mysql_fetch_array($side);
	if($sideq['sidequest'] == '307'){ // Make sure the session is correct for the prize
		mysql_query("UPDATE members SET sidequest = sidequest + 1 WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['sidequest'] += 1;
		$seviiislands = 1;
		$money = rand(20000,30000); // Random money prize between $20,000 and $30,000
		mysql_query("UPDATE members SET money = money + $money WHERE id = '{$_SESSION['myid']}'");
		$item = rand(1,3); // Random Sevii Islands item prize
		if($item == '1'){
			$prize = "50 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 50 WHERE uid = '{$_SESSION['myid']}'");
		}
		elseif($item == '2'){
			$prize = "a Latiosite";
			mysql_query("UPDATE items SET Latiosite = Latiosite + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
		elseif($item == '3'){
			$prize = "a Latiasite";
			mysql_query("UPDATE items SET Latiasite = Latiasite + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
	}
}
if($_POST['claim'] && $_POST['tcgprize']){ // Claim prize for TCG Island
	$side = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideq = mysql_fetch_array($side);
	if($sideq['sidequest'] == '362'){ // Make sure the session is correct for the prize
		mysql_query("UPDATE members SET sidequest = sidequest + 1 WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['sidequest'] += 1;
		$tcg = 1;
		$money = rand(20000,30000); // Random money prize between $20,000 and $30,000
		mysql_query("UPDATE members SET money = money + $money WHERE id = '{$_SESSION['myid']}'");
		$item = rand(1,3);
		if($item == '1'){
			$prize = "10 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 10 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '2'){
			$prize = "20 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 20 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '3'){
			$prize = "30 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 30 WHERE uid = '{$_SESSION['myid']}'");
		}
	}
}
if($_POST['claim'] && $_POST['orangeislandprize']){ // Claim prize for Orange Islands
	$side = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideq = mysql_fetch_array($side);
	if($sideq['sidequest'] == '483'){ // Make sure the session is correct for the prize
		mysql_query("UPDATE members SET sidequest = sidequest + 1 WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['sidequest'] += 1;
		$orangeislands = 1;
		$money = rand(20000,30000); // Random money prize between $20,000 and $30,000
		mysql_query("UPDATE members SET money = money + $money WHERE id = '{$_SESSION['myid']}'");
		$item = rand(1,3);
		if($item == '1'){
			$prize = "10 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 10 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '2'){
			$prize = "20 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 20 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '3'){
			$prize = "30 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 30 WHERE uid = '{$_SESSION['myid']}'");
		}
	}
}
if($_POST['claim'] && $_POST['hoennprize']){ // Claim prize for Hoenn
	$side = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideq = mysql_fetch_array($side);
	if($sideq['sidequest'] == '696'){ // Make sure the session is correct for the prize
		mysql_query("UPDATE members SET sidequest = sidequest + 1 WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['sidequest'] +=1;
		$hoenn = 1;
		$money = rand(20000,30000); // Random money prize between $20,000 and $30,000
		mysql_query("UPDATE members SET money = money + $money WHERE id = '{$_SESSION['myid']}'");
		$item = rand(1,5);
		if($item == '1'){
			$prize = "10 Masterballs";
			mysql_query("UPDATE items SET Master_Ball = Master_Ball + 10 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '2'){
			$prize = "a Blue Orb";
			mysql_query("UPDATE items SET Blue_Orb = Blue_Orb + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '3'){
			$prize = "a Red Orb";
			mysql_query("UPDATE items SET Red_Orb = Red_Orb + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '4'){
			$prize = "a Root Fossil";
			mysql_query("UPDATE items SET Root_Fossil = Root_Fossil + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
		if($item == '5'){
			$prize = "a Claw Fossil";
			mysql_query("UPDATE items SET Claw_Fossil = Claw_Fossil + 1 WHERE uid = '{$_SESSION['myid']}'");
		}
	}
}
$total = mysql_query("SELECT * FROM sidequests");
$totall = mysql_num_rows($total);

$percent0 = $_SESSION['sidequest'] / $totall * 100;
$percent = round($percent0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
<script src="popup.js" ></script>
<?php
if($_SESSION['layout'] == '1'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '2'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
    <script type="text/javascript" language="javascript" src="html/static/js//ie6-.js"></script>
    <link rel="stylesheet" type="text/css" href="html/static/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
    <script type="text/javascript" language="javascript" src="html/static/js//ie7+.js"></script>
    <link rel="stylesheet" type="text/css" href="html/static/css/ie7+.css" media="screen" />
<![endif]-->
<style>
#element_to_pop_up{ 
	background-color:#fff;
	border-radius:15px;
	color:#000;
	display:none; 
	padding:20px;
	width: 850px;
	height: 550px;
	overflow-y: scroll;

}
.b-close{
	cursor:pointer;
	position:absolute;
	right:10px;
	top:5px;
}
.progress {
	width: 200px;
	height: 10px;
	border: 1px solid black;
	border-radius: 25px;
	overflow: hidden;
	margin-left: auto ;
	margin-right: auto ;
}
</style>
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Shqipe v3 - Sidequests</title>
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
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
<div id="contentContainer">
<div id="sidebar">
<div id="sidebarContainer"><div id="sidebarLoading"></div><div id="sidebarContent"></div></div>
<ul id="sidebarTabs">
<li><a href="pokedex.php" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
<li><a href="members.php" id="membersTab" class="deselected"><em>Members</em></a></li>
<li><a href="options.php" id="optionsTab" class="deselected"><em>Options</em></a></li>
</ul>
</div>
<div id="content">
<div id="notification" style="visibility: hidden;"></div><div id="loading"></div>
<div id="scroll"><div id="suggestResults"></div><div id="showDetails"></div><div id="errorBox"></div>
<div style="float: right;">

<?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<div id="ajaxx">
<?php //-----------------------------Prize notifications----------------------------------//
if($kanto == 1){
	echo '<div class="actionMsg">You have won <strong>' . $prize . '</strong> and <img src="html/static/images/misc/pmoney.gif">' . number_format($money) . '<br />You have also won the Kanto Sidequest achievement ribbon for your profile.</div>';
}
if($johto == 1){
	echo '<div class="actionMsg">You have won <strong> ' . $prize . '</strong> and <img src="html/static/images/misc/pmoney.gif">' . number_format($money) . '<br />You have also won the Johto Sidequest achievement ribbon for your profile.</div>';
}
if($seviiislands == 1){
	echo '<div class="actionMsg">You have won <strong> ' . $prize . '</strong> and <img src="html/static/images/misc/pmoney.gif">' . number_format($money) . '<br />You have also won the Sevii Islands Sidequest achievement ribbon for your profile.</div>';
}
if($tcg == 1){
	echo '<div class="actionMsg">You have won <strong> ' . $prize . '</strong> and <img src="html/static/images/misc/pmoney.gif">' . number_format($money) . '<br />You have also won the TCG Island Sidequest achievement ribbon for your profile.</div>';
}
if($orangeislands == 1){
	echo '<div class="actionMsg">You have won <strong> ' . $prize . '</strong> and <img src="html/static/images/misc/pmoney.gif">' . number_format($money) . '<br />You have also won the Orange Islands Sidequest achievement ribbon for your profile.</div>';
}
if($hoenn == 1){
	echo '<div class="actionMsg">You have won <strong> ' . $prize . '</strong> and <img src="html/static/images/misc/pmoney.gif">' . number_format($money) . '<br />You have also won the Hoenn Sidequest achievement ribbon for your profile.</div>';
}
?>

<center><h5>Sidequests Progress</h5>
<b><?php echo '' . $percent . '';?>%</b><br /></center>
<div class="progress">
<img src="html/static/images/misc/hpbar.gif" height="10" width="<?php echo '' . $percent . '';?>%" />
</div>
<center>
<?php //----------------------------Kanto Sidequests---------------------------------//

if($_SESSION['sidequest'] > 0 && $_SESSION['sidequest'] < 102){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>Kanto Sidequests</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/kanto.png" /></a></center>
	</div>';
}
// --------------------------- Kanto sidequest prize ------------------------------ //
if($_SESSION['sidequest'] == '102'){
	echo '<img src="html/static/images/sqprize.png"><p />
	Congratulations, you have completed the Kanto sidequests, click below to claim your prize and to continue with another region.<p />';
	echo '<form action="sidequest.php" id="action" method="post"><input type="hidden" name="kantoprize" id="kantoprize" value="kantoprize" /><input type="hidden" name="claim" id="claim" value="claim" /><input type="submit" name="submit" value="Claim" /></form></td>';
}
// --------------------------- Johto Sidequests ------------------------------ //
if($_SESSION['sidequest'] >= 103 && $_SESSION['sidequest'] < 206){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>Johto Sidequests</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/johto.png" border="1" /></a></center>
	</div>';
}
// --------------------------- Johto Sidequest prize ---------------------------- //
if($_SESSION['sidequest'] == '206'){
	echo '<img src="html/static/images/sqprize.png"><p />
	Congratulations, you have completed the Johto sidequests, click below to claim your prize and to continue with another region.<p />';
	echo '<form action="sidequest.php" id="action" method="post"><input type="hidden" name="johtoprize" id="johtoprize" value="johtoprize" /><input type="hidden" name="claim" id="claim" value="claim" /><input type="submit" name="submit" value="Claim" /></form></td>';
}
// --------------------------- Sevii Islands Sidequests ------------------------------ //
if($_SESSION['sidequest'] >= 207 && $_SESSION['sidequest'] < 307){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>Sevii Islands Sidequests</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/seviiislands.png" border="1" /></a></center>
	</div>';
}
// --------------------------- Sevii Islands Sidequest prize ---------------------------- //
if($_SESSION['sidequest'] == '307'){
	echo '<img src="html/static/images/sqprize.png"><p />
	Congratulations, you have completed the Sevii Islands sidequests, click below to claim your prize and to continue with another region.<p />';
	echo '<form action="sidequest.php" id="action" method="post"><input type="hidden" name="seviiislandsprize" id="seviiislandsprize" value="seviiislandsprize" /><input type="hidden" name="claim" id="claim" value="claim" /><input type="submit" name="submit" value="Claim" /></form></td>';
}
// --------------------------- Navel Rock Sidequests ------------------------------ //
if($_SESSION['sidequest'] == 308){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>Navel Rock Sidequest</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/seviiislands.png" border="1" /></a></center>
	</div>';
}
// --------------------------- Birth Island Sidequests ------------------------------ //
if($_SESSION['sidequest'] >= 309 && $_SESSION['sidequest'] < 312){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>Birth Island Sidequest</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/seviiislands.png" border="1" /></a></center>
	</div>';
}
// ------------------------- TCG Island Sidequests ---------------------------------- //
if($_SESSION['sidequest'] >= 312 && $_SESSION['sidequest'] < 362){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>TCG Island Sidequest</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/tcg.png" border="1" /></a></center>
	</div>';
}
// --------------------------- TCG Island Sidequest prize ---------------------------- //
if($_SESSION['sidequest'] == '362'){
	echo '<img src="html/static/images/sqprize.png"><p />
	Congratulations, you have completed the TCG Island sidequests, click below to claim your prize and to continue with another region.<p />';
	echo '<form action="sidequest.php" id="action" method="post"><input type="hidden" name="tcgprize" id="tcgprize" value="tcgprize" /><input type="hidden" name="claim" id="claim" value="claim" /><input type="submit" name="submit" value="Claim" /></form></td>';
}
// ------------------------- Orange Islands Sidequests ---------------------------------- //
if($_SESSION['sidequest'] >= 363 && $_SESSION['sidequest'] < 483){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>Orange Islands Sidequest</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/orangeislands.png" border="1" /></a></center>
	</div>';
}
// --------------------------- Orange Islands Sidequest prize ---------------------------- //
if($_SESSION['sidequest'] == '483'){
	echo '<img src="html/static/images/sqprize.png"><p />
	Congratulations, you have completed the Orange Islands sidequests, click below to claim your prize and to continue with another region.<p />';
	echo '<form action="sidequest.php" id="action" method="post"><input type="hidden" name="orangeislandprize" id="orangeislandprize" value="orangeislandprize" /><input type="hidden" name="claim" id="claim" value="claim" /><input type="submit" name="submit" value="Claim" /></form></td>';
}
// ------------------------- Hoenn Sidequests ---------------------------------- //
if($_SESSION['sidequest'] >= 484 && $_SESSION['sidequest'] < 696){
	$side_trainer = mysql_query("SELECT * FROM sidequests WHERE id = '{$_SESSION['sidequest']}'");
	$trainer = mysql_fetch_array($side_trainer);
	$side_pokemon = mysql_query("SELECT name, a1, a2, a3, a4, lvl FROM sidepokemon WHERE rowner = '{$trainer['name']}'");
	$pkmn = mysql_fetch_array($side_pokemon);
	echo '<h1>Sidequests</h1>
	<center><h4>Hoenn Sidequest</h4><br />
	<strong>Location: </strong>' . $trainer['place'] . '<p />
	<strong>Trainer: </strong>' . $trainer['name'] . '<p />
	<p /><a href="#" id="pop-up">Click here to see your Sidequest map and start the battle</a>
	<div id="element_to_pop_up">
	<a class="b-close"><img src="html/static/images/close.gif"></a>
	<center><h4>Click the map to start the battle</h4><br />
	<a href="battle.php?sidequest=' . $_SESSION['sidequest'] . '"><img src="html/static/images/sidemaps/hoenn.png" border="1" /></a></center>
	</div>';
}
// --------------------------- Hoenn Sidequest prize ---------------------------- //
if($_SESSION['sidequest'] == '696'){
	echo '<img src="html/static/images/sqprize.png"><p />
	Congratulations, you have completed the Hoenn sidequests, click below to claim your prize and to continue with another region.<p />';
	echo '<form action="sidequest.php" id="action" method="post"><input type="hidden" name="hoennprize" id="hoennprize" value="hoennprize" /><input type="hidden" name="claim" id="claim" value="claim" /><input type="submit" name="submit" value="Claim" /></form></td>';
}
// ------------------------ Anything over not completed yet ---------------------------- //
if($_SESSION['sidequest'] > 696){
	echo '<div class="noticeMsg">You have finished what is ready of Sidequests so far, please be patient while more is added</div>';
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