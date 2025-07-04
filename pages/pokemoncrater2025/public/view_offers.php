<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
$time = time();

$pid = mysql_real_escape_string($_REQUEST['pid']);
$_SESSION['pid'] = $pid;
if(!is_numeric($pid)){
	header("location: trade.php");
}
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
<title>Pok&eacute;mon Vortex v3 - View Offers</title>
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
<p />

<?php
include('/var/www/ads/sidead.php');
?>

</div>
<div id="scrollContent">
<div id="ajax">
<?php
$q = mysql_query("SELECT name, lvl, exp FROM upfortrade WHERE pid = '$pid' AND owner = '{$_SESSION['myid']}'");
$q2 = mysql_num_rows($q);
function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}
if($q2 == 0){
	echo "<div class=\"errorMsg\">The Pok&eacute;mon you requested does not belong to you, or does not exist.</div>";
}
else {
	$r = mysql_query("SELECT oid FROM utraded WHERE oid = '$pid'");
	$r3 = mysql_num_rows($r);
	$q3 = mysql_fetch_array($q); if($r3 == 0){
		?>
		<div class="errorMsg">Your <? echo $q3['name']; ?> currently has no offers on it.</div>
		<p class="optionsList autowidth"><strong>Options:</strong><br />
        <a href="#" onclick="history.go(-1)" class="deselected">Go Back</a><br />
        <a href="/trade.php" class="deselected">Trade Pok&eacute;mon</a><br />
        <a href="/your_pokemon.php" class="deselected">View All Pok&eacute;mon</a></p> 
		<?php
	}
	else{
		?>
        <h2>Accept / Decline Offers On Your <? echo $q3['name']; ?></h2>
        <p><img src="http://static.pokemon-vortex.com/images/pokemon/<? echo $q3['name']; ?>.gif" /></p>
        <p><i>Level</i>: <? echo $q3['lvl']; ?></p>
        <p><i>Experience</i>: <? echo number_format($q3['exp']); ?></p>
        <div class="list autowidth" style="margin: 10px auto;">
		<?php
		$ox = mysql_query("SELECT oid FROM utraded WHERE oid = '$pid'");
		if(mysql_num_rows($ox) == 1){
			$e = 1;
		}
		?>
        <table cellpadding="5" cellspacing="0">
        <tr>
        <th>Pok&eacute;mon</th>
        <th style="width: 50px;">Level</th>
        <th style="width: 70px;">Exp</th>
        <th style="width: 100px;">Attacks</th>
        <th style="width: 110px;">Actions</th>
        </tr>
        <tbody id="after"></tbody>
		<?php
		$yl = mysql_query("SELECT * FROM utraded WHERE oid = '{$pid}' GROUP BY owner, time");
		while($r2 = mysql_fetch_array($yl)){
			$y = mysql_query("SELECT * FROM utraded WHERE oid = '{$pid}' GROUP BY owner, time");
			$yy = mysql_fetch_array($y);
			$u = mysql_query("SELECT * FROM utraded WHERE oid = '{$pid}' AND time = '{$r2['time']}' AND owner = '{$r2['owner']}'");
			$u2 = mysql_fetch_array($u);
			$uj = mysql_num_rows($u);
			$l = 1;
			$number1 = $l;
			if($numberl > 1){
				echo "</tbody>";
			}
			echo "<tbody id=\"" . $r2['tradeid'] . "\"><tr><td colspan=\"5\"><strong>Offered By:</strong> <a href=\"/members.php?uid=" . $u2['owner'] . "\" onclick=\"membersTab('uid=" . $u2['owner'] . "', 1); return false;\">" . $u2['rowner'] . "</a></td></tr>";
$number = 0;

			$uq = mysql_query("SELECT * FROM utraded WHERE oid = '{$pid}'  AND time = '{$u2['time']}' AND owner = '{$u2['owner']}'");
			while($y2 = mysql_fetch_array($uq)){
				$i = 1;
				$number += $i;
			?>
			<tr class="<? if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>">
            <td style="height: 70px; text-align: left;">
            <img src="http://static.pokemon-vortex.com/images/pokemon/<? echo $y2['name']; ?>.gif" />
            <strong><a href="/pokedex.php?pid=<? echo $y2['id']; ?>" onclick="pokedexTab('pid=<? echo $y2['id']; ?>', 1); return false;">
            <? echo $y2['name']; ?></a></strong></td>
            <td style="width: 50px; height: 70px;"><? echo $y2['lvl']; ?></td>
            <td style="width: 70px; height: 70px;"><? echo number_format($y2['exp']); ?></td>
            <td style="width: 100px; height: 70px;"><? echo $y2['a1']; ?>
            <br /><? echo $y2['a2']; ?>
            <br /><? echo $y2['a3']; ?>
            <br /><? echo $y2['a4']; ?></td>
            <td style="width: 110px; height: 70px;">
            <?php
            if($number == 1){
				?>
				<a href="offer.php?pid=<? echo $_REQUEST['pid'];?>&uid=<? echo $y2['owner'];?>&o=accept&t=<? echo $y2['time'] * 17; ?>">Accept Offer</a>
				<br /><br /><br /><a href="offer.php?pid=<? echo $_REQUEST['pid'];?>&uid=<? echo $y2['owner'];?>&o=decline&t=<? echo $y2['time'] * 17; ?>" onclick="document.getElementById('<? echo $r2['tradeid']; ?>').style.display = 'none'; getu(); return false;">Decline Offer</a><? } ?></td></tr>
				<?php
			}
		}
		?>
        </tbody></table></div>
		<?php
	}
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
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/gameInit.js"></script>
</html>
<?php include('pv_disconnect_from_db.php'); ?>