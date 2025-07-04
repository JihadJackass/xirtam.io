<?php
include('kick.php');
if(!isset($_SESSION['myid']) || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');

// Get the users items
$fossilz = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}'");
$fossils = mysql_fetch_array($fossilz);

// Turn the fossil to a Pokemon
if($_POST['Omanyte'] && $fossils['Helix_Fossil'] > 0 || $_POST['Kabuto'] && $fossils['Dome_Fossil'] > 0 || $_POST['Aerodactyl'] && $fossils['Old_Amber'] > 0 || $_POST['Lileep'] && $fossils['Root_Fossil'] > 0 || $_POST['Anorith'] && $fossils['Claw_Fossil'] > 0 || $_POST['Cranidos'] && $fossils['Skull_Fossil'] > 0 || $_POST['Shieldon'] && $fossils['Armor_Fossil'] > 0 || $_POST['Tirtouga'] && $fossils['Cover_Fossil'] > 0 || $_POST['Archen'] && $fossils['Plume_Fossil'] > 0 || $_POST['Tyrunt'] && $fossils['Jaw_Fossil'] > 0 || $_POST['Amaura'] && $fossils['Sail_Fossil'] > 0){

	//-------------------------------OMANYTE-----------------------------------------//

	if($_POST['Omanyte'] && $fossils['Helix_Fossil'] > 0){
		mysql_query("UPDATE items SET Helix_Fossil = Helix_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Omanyte';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Omanyte';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Omanyte';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Omanyte';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Omanyte';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Omanyte';
		}
		$fossil = Omanyte;
	}
	
	//-------------------------------KABUTO-----------------------------------------//

	if($_POST['Kabuto'] && $fossils['Dome_Fossil'] > 0){
		mysql_query("UPDATE items SET Dome_Fossil = Dome_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Kabuto';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Kabuto';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Kabuto';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Kabuto';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Kabuto';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Kabuto';
		}
		$fossil = Kabuto;
	}
	
	//-------------------------------AERODACTYL-----------------------------------------//

	if($_POST['Aerodactyl'] && $fossils['Old_Amber'] > 0){
		mysql_query("UPDATE items SET Old_Amber = Old_Amber - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Aerodactyl';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Aerodactyl';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Aerodactyl';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Aerodactyl';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Aerodactyl';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Aerodactyl';
		}
		$fossil = Aerodactyl;
	}

	//-------------------------------LILEEP-----------------------------------------//

	if($_POST['Lileep'] && $fossils['Root_Fossil'] > 0){
		mysql_query("UPDATE items SET Root_Fossil = Root_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Lileep';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Lileep';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Lileep';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Lileep';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Lileep';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Lileep';
		}
		$fossil = Lileep;
	}
	
	//-------------------------------ANORITH-----------------------------------------//

	if($_POST['Anorith'] && $fossils['Claw_Fossil'] > 0){
		mysql_query("UPDATE items SET Claw_Fossil = Claw_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Anorith';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Anorith';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Anorith';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Anorith';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Anorith';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Anorith';
		}
		$fossil = Anorith;
	}
	
	//-------------------------------CRANIDOS-----------------------------------------//

	if($_POST['Cranidos'] && $fossils['Skull_Fossil'] > 0){
		mysql_query("UPDATE items SET Skull_Fossil = Skull_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Cranidos';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Cranidos';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Cranidos';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Cranidos';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Cranidos';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Cranidos';
		}
		$fossil = Cranidos;
	}
	
	//-------------------------------SHIELDON-----------------------------------------//

	if($_POST['Shieldon'] && $fossils['Armor_Fossil'] > 0){
		mysql_query("UPDATE items SET Armor_Fossil = Armor_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Shieldon';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Shieldon';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Shieldon';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Shieldon';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Shieldon';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Shieldon';
		}
		$fossil = Shieldon;
	}
	
	//-------------------------------TIRTOUGA-----------------------------------------//

	if($_POST['Tirtouga'] && $fossils['Cover_Fossil'] > 0){
		mysql_query("UPDATE items SET Cover_Fossil = Cover_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Tirtouga';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Tirtouga';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Tirtouga';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Tirtouga';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Tirtouga';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Tirtouga';
		}
		$fossil = Tirtouga;
	}
	
	//-------------------------------ARCHEN-----------------------------------------//

	if($_POST['Archen'] && $fossils['Plume_Fossil'] > 0){
		mysql_query("UPDATE items SET Plume_Fossil = Plume_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Archen';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Archen';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Archen';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Archen';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Archen';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Archen';
		}
		$fossil = Archen;
	}
	
	//-------------------------------TYRUNT-----------------------------------------//

	if($_POST['Tyrunt'] && $fossils['Jaw_Fossil'] > 0){
		mysql_query("UPDATE items SET Jaw_Fossil = Jaw_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Tyrunt';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Tyrunt';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Tyrunt';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Tyrunt';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Tyrunt';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Tyrunt';
		}
		$fossil = Tyrunt;
	}
	
	//-------------------------------AMAURA-----------------------------------------//

	if($_POST['Amaura'] && $fossils['Sail_Fossil'] > 0){
		mysql_query("UPDATE items SET Sail_Fossil = Sail_Fossil - 1 WHERE uid = '{$_SESSION['myid']}'");
		$rand = rand(1,10); // Determine if the Pokemon is normal or not
		$gend = rand(1,2); // Determine the Pokemons gender
		if($gend == '1'){
			$gender = Male;
		}
		else if($gend == '2'){
			$gender = Female;
		}
		if($rand == '1'){ // If the Pokemon is Shiny
			$name = 'Shiny Amaura';
		}
		else if($rand == '2'){ // If the Pokemon is Dark
			$name = 'Dark Amaura';
		}
		else if($rand == '3'){ // If the Pokemon is Mystic
			$name = 'Mystic Amaura';
		}
		else if($rand == '4'){ // If the Pokemon is Shadow
			$name = 'Shadow Amaura';
		}
		else if($rand == '5'){ // If the Pokemon is Metallic
			$name = 'Metallic Amaura';
		}
		else if($rand > 5){ // If the Pokemon is Normal
			$name = 'Amaura';
		}
		$fossil = Amaura;
	}
	
	//------------------Insert the Pokemon and update user/clan stats---------------------//
	
	$get_pkmn = mysql_query("SELECT * FROM pguide WHERE name = '$name'");
	$getpkmn = mysql_fetch_array($get_pkmn);
	mysql_query("INSERT INTO pokemon (name, pid, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES ('$name', '{$getpkmn['id']}', '{$_SESSION['myid']}', '{$getpkmn['a1']}', '{$getpkmn['a2']}', '{$getpkmn['a3']}', '{$getpkmn['a4']}', '5', '{$getpkmn['type1']}', '{$getpkmn['type2']}', '2500', '{$_SESSION['myuser']}')");
	$h3 = mysql_insert_id();
		// Include the stat generating pages
	include('stats/ivs.php');
	include('stats/natures.php');
	include('stats/fossilabilities.php');
	mysql_query("INSERT INTO pokemon_stats (id, hp_iv, attack_iv, defense_iv, spatk_iv, spdef_iv, speed_iv, nature, ability, ot, gender, ball) VALUES ('$h3', '$hp_iv', '$attack_iv', '$defense_iv', '$spatk_iv', '$spdef_iv', '$speed_iv', '$nature', '$ability', '{$_SESSION['myuser']}', '$gender', 'Poke Ball')");
	mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '$name'");
	$uniq = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid");
	$unique = mysql_num_rows($uniq);
	$account = mysql_query("SELECT totalexp, total_poke, battle FROM members WHERE id = '{$_SESSION['myid']}'");
	$acc = mysql_fetch_array($account);
	// Update Points
	$totalexp = $acc['totalexp'] + 2500;
	$avgexp = $totalexp / ($acc['total_poke'] + 1) ;
	$battle = $acc['battle'];
	$p1 = sqrt($totalexp);
	$p2 = sqrt($avgexp);
	$p3 = sqrt($unique);
	$p4 = log($battle);
	$p5 = $p1 * $p2 * $p3 * $p4;
	$p6 = $p5 / 1000;
	$p7 = round($p6, 1);
	mysql_query("UPDATE members SET total_poke = total_poke + 1, averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique', points = '$p7' WHERE id = '{$_SESSION['myid']}'");
	if(isset($_SESSION['clan'])){
		mysql_query("UPDATE clan_members SET exp = exp + 2500 WHERE id = '{$_SESSION['myid']}'");
		mysql_query("UPDATE clans SET exp = exp + 2500 WHERE name = '{$_SESSION['clan']}'");
		$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
		$clan_info = mysql_fetch_array($claninfo);
		$wins = $clan_info['wins'];
		$expp = $clan_info['exp'];
		$members = $clan_info['members'];
		$avegexp = $expp / $members;
		$po0 = sqrt($members);
		$po1 = sqrt($expp);
		$po2 = sqrt($avegexp);
		$po3 = log($wins);
		$po4 = $po1 * $po2 * $po3 * $po0;
		$po5 = $po4 / 10000;
		$po6 = round($po5, 1);
		mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
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
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Shqipe v3 - Fossil Lab</title>
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
<script>
$(function(){
   setTimeout(function(){
      if($("#headerAd").css('display')=="none")
      {
          $('body').html("<center><h2>Oh no, You have AdBlocker</h2><img src=\"html/static/images/pika_cry.gif\"><p />We noticed you have an active Ad Blocker.<br />Pok&eacute;mon Shqipe is 100% funded by advertisements, we promise our ads are of high quality and are unobtrusive.<br />Please whitelist this site from your ad blocker so we can continue to provide this website for as long as possible and for free.<br />Thank You.");
      }
  },1000);
});
</script>
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
<div style="float: right;"><p>
<?php
include('/var/www/ads/sidead.php');
?></p></div>
<div id="scrollContent">
<div id="ajax">
<?php
if($fossil == 'Omanyte'){
	echo '<div class="actionMsg">You successfully regenerated your Helix Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Kabuto'){
	echo '<div class="actionMsg">You successfully regenerated your Dome Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Aerodactyl'){
	echo '<div class="actionMsg">You successfully regenerated your Old Amber into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Lileeep'){
	echo '<div class="actionMsg">You successfully regenerated your Root Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Anorith'){
	echo '<div class="actionMsg">You successfully regenerated your Claw Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Cranidos'){
	echo '<div class="actionMsg">You successfully regenerated your Skull Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Shieldon'){
	echo '<div class="actionMsg">You successfully regenerated your Armor Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Tirtouga'){
	echo '<div class="actionMsg">You successfully regenerated your Cover Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Archen'){
	echo '<div class="actionMsg">You successfully regenerated your Plume Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Tyrunt'){
	echo '<div class="actionMsg">You successfully regenerated your Jaw Fossil into a <strong>' . $name . '</strong></div>';
}
if($fossil == 'Amaura'){
	echo '<div class="actionMsg">You successfully regenerated your Sail Fossil into a <strong>' . $name . '</strong></div>';
}
?>
<center><img src="html/static/images/fossil_lab.png" /><p />

<span class="small">Note: If your options says 'Sidequests' It means you do not have that fossil and you can win it from completing regions in Sidequests</span></center><p />

<table style="margin-left: auto; border: 2px solid #666666; margin-right: auto;">
	<th style="border: 1px dotted #666666;" width="150" align="center">Fossil</th>
	<th style="border: 1px dotted #666666;" width="150" align="center">Quantity</th>
	<th style="border: 1px dotted #666666;" width="150" align="center">Generates</th>
	<th style="border: 1px dotted #666666;" width="150" align="center">Options</th>
    
	<!-- OMANYTE -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Helix Fossil.png" /></td><td> Helix Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Helix_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Omanyte.gif" /></td><td> Omanyte</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Helix_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Omanyte" id="Omanyte" value="Omanyte" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- KABUTO -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Dome Fossil.png" /></td><td> Dome Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Dome_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Kabuto.gif" /></td><td> Kabuto</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Dome_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Kabuto" id="Kabuto" value="Kabuto" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- AERODACTYL -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Old Amber.png" /></td><td> Old Amber</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Old_Amber']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Aerodactyl.gif" /></td><td> Aerodactyl</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Old_Amber'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Aerodactyl" id="Aerodactyl" value="Aerodactyl" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- LILEEP -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Root Fossil.png" /></td><td> Root Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Root_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Lileep.gif" /></td><td> Lileep</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Root_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Lileep" id="Lileep" value="Lileep" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- ANORITH -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Claw Fossil.png" /></td><td> Claw Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Claw_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Anorith.gif" /></td><td> Anorith</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Claw_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Anorith" id="Anorith" value="Anorith" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- CRANIDOS -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Skull Fossil.png" /></td><td> Skull Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Skull_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Cranidos.gif" /></td><td> Cranidos</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Skull_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Cranidos" id="Cranidos" value="Cranidos" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- SHIELDON -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Armor Fossil.png" /></td><td> Armor Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Armor_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Shieldon.gif" /></td><td> Shieldon</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Armor_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Shieldon" id="Shieldon" value="Shieldon" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- TIRTOUGA -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Cover Fossil.png" /></td><td> Cover Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Cover_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Tirtouga.gif" /></td><td> Tirtouga</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Cover_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Tirtouga" id="Tirtouga" value="Tirtouga" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- ARCHEN -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Plume Fossil.png" /></td><td> Plume Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Plume_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Archen.gif" /></td><td> Archen</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Plume_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Archen" id="Archen" value="Archen" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- TYRUNT -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Jaw Fossil.png" /></td><td> Jaw Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Jaw_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Tyrunt.gif" /></td><td> Tyrunt</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Jaw_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Tyrunt" id="Tyrunt" value="Tyrunt" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>
    
	<!-- AMAURA -->
    
	<tr><td style="border: 1px dotted #666666;" width="150" align="center"><table><tr><td><img src="html/static/images/items/Sail Fossil.png" /></td><td> Sail Fossil</td></tr></table></td><td style="border: 1px dotted #000000;" width="150" align="center"><?=$fossils['Sail_Fossil']; ?></td><td style="border: 1px dotted #000000;" width="150" align="center"><table><tr><td><img src="html/static/images/fossils/Amaura.gif" /></td><td> Amaura</td></tr></table><td style="border: 1px dotted #000000;" width="150" align="center"><?php if($fossils['Sail_Fossil'] >= 1){ ?> <form action="fossil_lab.php" id="action" method="post" onsubmit="get(\'fossil_lab.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="Amaura" id="Amaura" value="Amaura" /><input type="hidden" name="regenerate" id="regenerate" value="regenerate" /><input type="submit" name="submit" value="Regenerate" /></form> <?php } else { ?><a href="/sidequest.php">Sidequests</a><?php } ?></td></tr>

</table><p />
<?php
include('disclaimer.php');
?>
</div></div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php
include('pv_disconnect_from_db.php');
?>