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

<title>Pok&eacute;mon Vortex v3 - Twitch</title>
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

</div>
<div id="scrollContent">
<div id="ajax">

<h2>Pok&eacute;mon Vortex: Live Stream</h2>
<!----------- iframe the Twitch.tv stream and chat --------------->
<div>
<table>
<tr>
<td>
<iframe src="http://www.twitch.tv/pokemonvortexrpg/embed" frameborder="0" scrolling="no" height="378" width="620"></iframe>
</td>
<td>
<iframe src="http://www.twitch.tv/pokemonvortexrpg/chat?popout=" frameborder="0" scrolling="no" height="378" width="340"></iframe>
</td>
</tr>
</table>
</div>

<!----------- End iframe ------------->

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
