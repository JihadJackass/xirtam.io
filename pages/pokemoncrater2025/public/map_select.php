<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
if($_SESSION['access'] == 9){
include('pv_connect_to_db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/suggest.js"></script>
<?php
if($_SESSION['layout'] == '1'){
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/blue/global.css" media="screen" />';
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/blue/game.css" media="screen" />';
}
if($_SESSION['layout'] == '0'){
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/global.css" media="screen" />';
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/game.css" media="screen" />';
}
if($_SESSION['layout'] == '2'){
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/global.css" media="screen" />';
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/ie6-.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
	<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/ie7+.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/ie7+.css" media="screen" />
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title>Vortex Battle Arena v3 - Map Select</title>
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
<h1><a href="index.php"><em>PokemonVortex.com</em></a></h1>
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
<div style="float: right;">

<?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<div id="ajax">

<h2>Select a map region to explore:</h2>
<a href="http://forums.pokemonvortex.org/index.php?showforum=81">Click here for the Vortex Pok&eacute;mon location guide.</a><p>
<h5>Grass Maps</h5>
<a href="/map.php?map=1"><img src="http://static.pokemon-vortex.com/images/maps/map1.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=4"><img src="http://static.pokemon-vortex.com/images/maps/map4.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=7"><img src="http://static.pokemon-vortex.com/images/maps/map7.png" height="100" width="100" style="border: 2px solid black;"></a><br />
<a href="/map.php?map=2"><img src="http://static.pokemon-vortex.com/images/maps/map2.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=5"><img src="http://static.pokemon-vortex.com/images/maps/map5.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=8"><img src="http://static.pokemon-vortex.com/images/maps/map8.png" height="100" width="100" style="border: 2px solid black;"></a><br />
<a href="/map.php?map=3"><img src="http://static.pokemon-vortex.com/images/maps/map3.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=6"><img src="http://static.pokemon-vortex.com/images/maps/map6.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=9"><img src="http://static.pokemon-vortex.com/images/maps/map9.png" height="100" width="100" style="border: 2px solid black;"></a>
<h5>Cave Maps</h5>
<a href="/map.php?map=10"><img src="http://static.pokemon-vortex.com/images/maps/map10.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=13"><img src="http://static.pokemon-vortex.com/images/maps/map13.png" height="100" width="100" style="border: 2px solid black;"></a><br />
<a href="/map.php?map=11"><img src="http://static.pokemon-vortex.com/images/maps/map11.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=14"><img src="http://static.pokemon-vortex.com/images/maps/map14.png" height="100" width="100" style="border: 2px solid black;"></a><br />
<a href="/map.php?map=12"><img src="http://static.pokemon-vortex.com/images/maps/map12.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=15"><img src="http://static.pokemon-vortex.com/images/maps/map15.png" height="100" width="100" style="border: 2px solid black;"></a>
<h5>Electric Maps</h5>
<a href="/map.php?map=16"><img src="http://static.pokemon-vortex.com/images/maps/map16.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=17"><img src="http://static.pokemon-vortex.com/images/maps/map17.png" height="100" width="100" style="border: 2px solid black;"></a>
<h5>Fire Maps</h5>
<a href="/map.php?map=18"><img src="http://static.pokemon-vortex.com/images/maps/map18.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=20"><img src="http://static.pokemon-vortex.com/images/maps/map20.png" height="100" width="100" style="border: 2px solid black;"></a><br />
<a href="/map.php?map=19"><img src="http://static.pokemon-vortex.com/images/maps/map19.png" height="100" width="100" style="border: 2px solid black;"></a>
<a href="/map.php?map=21"><img src="http://static.pokemon-vortex.com/images/maps/map21.png" height="100" width="100" style="border: 2px solid black;"></a>
<h5>Ice Maps</h5>
<a href="/map.php?map=23"><img src="http://static.pokemon-vortex.com/images/maps/map23.png" height="100" width="100" style="border: 2px solid black;"></a><br /><br />
<a href="/map.php?map=22"><img src="http://static.pokemon-vortex.com/images/maps/map22.png" height="100" width="100" style="border: 2px solid black;"></a>
<h5>Ghost Maps</h5>
<a href="/map.php?map=24"><img src="http://static.pokemon-vortex.com/images/maps/map24.png" height="100" width="100" style="border: 2px solid black;"></a><br /><br />
<a href="/map.php?map=25"><img src="http://static.pokemon-vortex.com/images/maps/map25.png" height="100" width="100" style="border: 2px solid black;"></a><p>
<p>

</div>
<?php include('disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/gameInit.js"></script>
</html>
<?php
}
else {
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_disconnect_from_db.php'); ?>
