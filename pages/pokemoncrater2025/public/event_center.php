<?php

/*
 * HOW THE EVENT CENTER WORKS
 * Whenever a new event is added, you need to include the pages from the directory /var/www/html/vortex/event_includes/
 * Once the event is ready to run, the event variable $event has to be set so the page will know which event is being unlocked and played
 * To close everyone's event page, run: UPDATE members_options SET event_page = '0', event = ''
 * The done_event table also must be emptied once the event period is over with: TRUNCATE `done_event`
 * This will tell the page you have not completed the event but locking the page again first negates this message.
 */


// --------------------------- Set the current event here ------------------------------- //

$event = 'none';

/*
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/

include('kick.php');
if(!isset($_SESSION['myid'])){ // Check if the user is logged in
	include('pv_disconnect_from_db.php');
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php'); // Connect to the database

if(!isset($_SESSION['event_ticket'])){ // Check if the event ticket session is set
	$get_ticket_count = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}'"); // Get items
	$items = mysql_fetch_array($get_ticket_count);
	$_SESSION['event_ticket'] = $items['event_ticket']; // Set the event ticket session
}
if($_POST['unlock']){
	if($event == 'none'){
		$noevent = 0;
	}
	else{
		$en = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}'");
		$tick = mysql_fetch_array($en);
		if($tick['event_ticket'] >= 1){
			mysql_query("UPDATE items SET event_ticket = event_ticket - 1 WHERE uid = '{$_SESSION['myid']}'");
			mysql_query("UPDATE members_options SET event_page = '1', event = '$event' WHERE id = '{$_SESSION['myid']}'");
			$unlock = 1;
		}
		else{
			$unlock = 0;
		}
	}
}

// Include files to redeem promo codes or any other event prizes here

include('event_includes/pikachu2015_claim.php'); // New year Pikachu Cosplay event
include('event_includes/kyurem_claim.php'); // Kyurem Black and White fusion event


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
.promoCode
{
	width: 40%;
	text-align: center;
	padding: 10px;
	margin: 10px 20px;
	background-color: #808080;
	border: 2px solid #181818;
	border-radius: 20px;
	box-shadow: 10px 10px 5px #888888;
}
</style>
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Shqipe v3 - Event Center</title>
</head>
<body>
<?php include_once("analytics.php"); ?>
<div id="alert"></div>
<div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<?php include_once("/var/www/ads/headerad.php"); ?>
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
<div style="float: right;"><p />
<?php include_once("/var/www/ads/sidead.php"); ?>
</div>
<div id="scrollContent">
<div id="ajax">
<?php

//----------------------------- Page unlock and prize redeem notifications ----------------------------------//

if($unlock == '1'){
	echo '<div class="actionMsg">Congratulations! You have unlocked the event center for a limited time while the current event runs.</div>';
}

if($unlock == '0'){
	echo '<div class="errorMsg">Sorry, you do not have an event ticket to unlock the event center.</div>';
}

if($promo == '1'){
	echo '<div class="actionMsg">You have claimed your promo code. You can use it on the <a href="/dashboard.php">dashboard</a>.</div>';
}

if($promo == '0'){
	echo '<div class="errorMsg">You have either already claimed your promo code or you are not eligable for one.</div>';
}

if($unowns == '0'){
	echo '<div class="errorMsg">You have not yet collected all the Unowns. Use your Pokedex to track which ones you have and which ones you still need.</div>';
}
if($splicers == '1'){
	echo '<div class="actionMsg">You have successfully purchased the DNA Splicers for your account. You are now able to fuse Pok&eacute;mon.</div>';
}
if($splicers == '0'){
	echo '<div class="errorMsg">You do not have enough money to purchase the DNA Splicers for your account.</div>';
}
if($splicererror == '1'){
	echo '<div class="errorMsg">An error occurred trying to purchase the DNA Splicers for your account.</div>';
}
if($ownererror == '1'){
	echo '<div class="errorMsg">You have not selected a Pok&eacute;mon to fuse or you do not own them.</div>';
}
if($typeerror == '1'){
	echo '<div class="errorMsg">The two Pok&eacute;mon you fuse need to be of the same type. Shiny and Shiny, for example.</div>';
}
if($fused == '1'){
	echo '<div class="actionMsg">You have successfully fused your Kyurem and ' . $reshiram_zekrom['name'] . ' and made a ' . $fusion . '.</div>';
}
if($noevent == '0'){
	echo '<div class="errorMsg">There is currently no running event that you can unlock the event center for. Please check back soon.</div>';
}

//---------------------- Has the user unlocked the page? -------------------------------//

$unlock_page = mysql_query("SELECT * FROM members_options WHERE id = '{$_SESSION['myid']}'");
$unlocked = mysql_fetch_array($unlock_page);
$_SESSION['event'] = $unlocked['event'];

//------------------------ Display the current event -------------------------------//

if($unlocked['event_page'] == '1' && $_SESSION['event'] == 'pikachu2015'){
	
	// Include the event page for Pikachu Cosplays

	include('event_includes/pikachu2015.php');
}

elseif($unlocked['event_page'] == '1' && $_SESSION['event'] == 'kyurem'){

	// Include the event page for Kyurem

	include('event_includes/kyurem.php');
}

else{
	
	// Show unlock page
	
	echo '<center><img src="html/static/images/event_center.png" alt="Event Center" /><p />
	You have ' . number_format($_SESSION['event_ticket']) . ' event tickets to use. <img src="html/static/images/items/memberscard.png" alt="Event Ticket" /><p />
	You have not yet unlocked the Event Center. You can do so by using one of your event tickets.<br />If you have no event tickets it could mean you either registered to Pok&eacute;mon ship after an event had started or there isn\'t currently an event running.';
	echo '<form action="event_center.php" id="action" method="post"><input type="hidden" name="unlock" id="unlock" value="unlock" /><input type="submit" name="submit" value="Unlock" /></form><br /><br /><h2>Event Center FAQ</h2><br /></center>';
	echo '<p style="text-align: left;"><b>Q</b> - Why do I need to "unlock" the page?<br />
	<b>A</b> - Because this way it stops people from creating accounts over and over to claim event prizes.<br /><br />
	<b>Q</b> - What is an Event Ticket and how do I get one?<br />
	<b>A</b> - An Event Ticket is an in-game item that is used to unlock the Event Center page for the current event that is taking place here in Pok&eacute;mon Shqipe.<br />You can get a ticket just by being active here on Pok&eacutemon; Vortex. A ticket may be given to you or you might have to win it somehow. It depends on the way we want to run the current event.<br /><br />
	<b>Q</b> - What happens if I have two event tickets and I want to do the event while it\'s still running?<br />
	<b>A</b> - You cannot complete a running event more than once, regardless of how many event tickets you have.<br />You must wait for special sitations where Pok&eacute;mon Vortex will open the event center for an old event. These chances to go back to old events will typically only run for 1 - 2 days.<br /><br />
	<b>Q</b> - I got a promo code for completing an event. Can I give it away?<br />
	<b>A</b> - Absolutely! If you\'re feeling generous and would like to give your promo code to a friend, it is usable on any account but like any promo code, it is only usable once, so be sure you want to give it away before you do.<br /><br />
	<b>Q</b> - I don\'t feel like taking part in this event, can I save my ticket for a later event?<br />
	<b>A</b> - Yes, you certainly can. While tickets are only given out at specific times, they are never taken from you - Even if you never use it.</p>
	';
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