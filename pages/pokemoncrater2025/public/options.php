<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:/login.php?goawayxP=1");
	exit();
}
if($_SESSION['access'] == 9){
	include('pv_connect_to_db.php');
	$time = time();
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
elseif($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '2'){
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
<title>Pok&eacute;mon Vortex v3 - Options</title>
</head>
<body>
<?php include_once("analytics.php"); ?>
<div id="alert"></div>
<div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<iframe src="adv.php" width="728" height="90" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>
</div>
<div id="title">
<h1><a href="index.php"><em>PokemonVortex.com</em></a></h1>
</div>
<ul id="nav">
<li><a href="map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li><li>
<a href="battle_select.php" id="battleTab" class="deselected"><em>Battle</em></a></li><li>
<a href="your_account.php" id="yourAccountTab" class="deselected"><em>Your Account</em></a></li>
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
<div id="scrollContent">
<div id="ajax">
<?php
if($_REQUEST['map'] && $_REQUEST['id']){
	$_REQUEST['map'] = mysql_real_escape_string($_REQUEST['map']);
	$_REQUEST['id'] = mysql_real_escape_string($_REQUEST['id']);
	$se = mysql_query("SELECT * FROM mapusers WHERE map = '{$_REQUEST['map']}' AND id != '{$_SESSION['myid']}'");
	$s2 = mysql_num_rows($se);
	echo "<h5>Members on Map " . $_REQUEST['map'] . "</h5>";
	echo '<div class="list autowidth"><table border="0" cellspacing="0" cellpadding="3" style="width: 100%;"><tr><th style="width:45%;">Username</th><th style="width:55%;">Options</th></tr>';
	if($s2 == 0){
		echo "<p>Sorry, there are no other members on this map at this time, besides yourself.</p>";
	}
	else {
		while($s = mysql_fetch_array($se)){
			echo "<tr class=\"dark\" nowrap=\"nowrap\">
			<td style=\"text-align: left;\"><strong>
			<a href=\"members.php?uid=" . $s['id'] . "\" onclick=\"membersTab('uid=" . $s['id'] . "', 1); return false;\">" . $s['username'] . "</a></strong></td><td style=\"width: 25%;\"><a href=\"/battle.php?bid=" . $s['id'] . "\">Battle</a> | <a href=\"message.php?rid=" . $s['id'] . "\">Message</a> | <a href=\"trade.php?type=Username&input=" . $s['username'] . "&search=1\">View Trades</a>
			</td></tr>
			";
		}
	}
	echo "</table></div>";
}
else {
	if($_REQUEST['map'] == 'memberson' || $_REQUEST['map'] == 'membersoff'){
		if($_REQUEST['map'] == 'membersoff'){
			$nt = 1;
		}
		else{
			$nt = 0;
		}
		$_SESSION['map_preferences'][1] = $nt;
		$a = mysql_query("UPDATE members SET memonmap ='$nt' WHERE id = '{$_SESSION['myid']}'");
	}
	if($_REQUEST['msg_notify']){
		$nug = '0';
		if($_REQUEST['msg_notify'] == 'off'){
			$nug = '1';
		}
		$a = mysql_query("UPDATE members SET messnotifyonoff = '$nug' WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['message_preferences'][0] = $nug;
	}
	if($_REQUEST['messages']){
		$qz = 0;
		if($_REQUEST['messages'] == 'off'){
			$qz = 1;
		}
		$a = mysql_query("UPDATE members SET messonoff = '$qz' WHERE id = '{$_SESSION['myid']}'");
	}
	$mm = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$j = mysql_fetch_array($mm);
	$which = "deselected";
	$ahi = "selected";
	if($j['memonmap'] == 0){
		$which = "selected";
		$ahi = "deselected";
	}
	$qw = 'deselected';
	$wq = 'selected';
	if($j['messonoff']==1){
		$qw = 'selected';
		$wq = 'deselected';
	}
	$rw ='deselected';
	$wr = 'selected';
		if($j['messnotifyonoff'] == 1){
			$rw ='selected';
			$wr = 'deselected';
		}
		?>
		<center><h1>Options</h1></center>
		<?php
		if($a){
			?>
			<div class="actionMsg">Profile Updated.</div>
			<?php
		}
		?>
        <ul class="optionsList">
        <p style="font-size:13px;">Show members on map? <a class="<?=$which?>" href="options.php?map=memberson" onclick="optionsTab('map=memberson', 0); return false;">Yes</a> | <a class="<?=$ahi?>" href="options.php?map=membersoff" onclick="optionsTab('map=membersoff', 0); return false;">No</a></p>
        
        <p style="font-size:13px;">Allow messages: <a href="your_profile.php?messages=on" onclick="optionsTab('messages=on', 0); return false;" class="<?=$wq?>">On</a> | <a href="your_profile.php?messages=off" onclick="optionsTab('messages=off', 0); return false;" class="<?=$qw?>">Off</a></p>
        
        
        <p style="font-size:13px;">Show New message notifications: <a href="your_profile.php?msg_notify=on" onclick="optionsTab('msg_notify=on', 0); return false;" class="<?=$wr?>">On</a> | <a href="your_profile.php?msg_notify=off" onclick="optionsTab('msg_notify=off', 0); return false;" class="<?=$rw?>">Off</a></p>
        
        </ul>
        <?php
	}
	?>
	</div>
	<?php
	include('disclaimer.php');
	?>
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
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
}
?>