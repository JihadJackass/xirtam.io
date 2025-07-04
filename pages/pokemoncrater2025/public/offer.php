<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
if($_SESSION['access'] == 9){
	include('pv_connect_to_db.php');
	$time = time();
	function updatepoints($te){ // Update your points
		$user_id = $_SESSION['myid'];
		$sideright = mysql_query("SELECT battle, id, total_poke, totalexp FROM members WHERE id = '$user_id' LIMIT 1");
		$sideright1 = mysql_fetch_array($sideright);
		$aiir = mysql_query("SELECT SUM(exp) FROM pokemon WHERE owner = '{$sideright1['id']}'");
		$aiir2 = mysql_fetch_array($aiir);
		$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY pid");
		$unique = mysql_num_rows($result);
		unset($_SESSION['your_pokemon']);
		while($h = mysql_fetch_array($result)){
			$_SESSION['your_pokemon'][] = $h['pid'];
		}
		$totalexp = $aiir2['SUM(exp)'];
		$avgexp = $totalexp / ($sideright1['total_poke'] + $te);
		$battle = $sideright1['battle'];
		$p1 = sqrt($totalexp);
		$p2 = sqrt($avgexp);
		$p3 = sqrt($unique);
		$p4 = log($battle);
		$p5 = $p1 * $p2 * $p3 * $p4;
		$p6 = $p5 / 1000;
		$p7 = round($p6, 1);
		mysql_query("UPDATE members SET points = '$p7', averageexp = '{$avgexp}', total_poke = total_poke + $te, totalexp = '{$totalexp}', uniques = '$unique' WHERE id = '$user_id'");
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
			$avegexp = $expp / $members;
			$po0 = sqrt($members);
			$po1 = sqrt($expp);
			$po2 = sqrt($avegexp);
			$po3 = log($wins);
			$po4 = $po1 * $po2 * $po3 * po0;
			$po5 = $po4 / 10000;
			$po6 = round($po5, 1);
			mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
		}
	} // End update your points
	
	function updatetherepoints($thereid, $te){ // update the other users points
		$sideright = mysql_query("SELECT * FROM members WHERE id = '{$thereid}'");
		$sideright1 = mysql_fetch_array($sideright);
		$aiir = mysql_query("SELECT SUM(exp) FROM pokemon WHERE owner = '{$thereid}'");
		$aiir2 = mysql_fetch_array($aiir);
		$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$thereid}' GROUP BY pid");
		$unique = mysql_num_rows($result);
		$totalexp = $aiir2['SUM(exp)'];
		$avgexp = $totalexp / ($sideright1['total_poke'] + $te);
		$battle = $sideright1['battle'];
		$p1 = sqrt($totalexp);
		$p2 = sqrt($avgexp);
		$p3 = sqrt($unique);
		$p4 = log($battle);
		$p5 = $p1 * $p2 * $p3 * $p4;
		$p6 = $p5 / 1000;
		$p7 = round($p6, 1);
		mysql_query("UPDATE members SET points = '$p7', total_poke = total_poke + $te, averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique' WHERE id = '{$thereid}'");
		if($sideright1['clan_name']){ // update their clan points if you're in a clan
			mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$thereid}'");
			$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$sideright1['clan_name']}'");
			$claexp = mysql_fetch_array($clanexp);
			mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$sideright['clan_name']}'");
			$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$sideright1['clan_name']}'");
			$clan_info = mysql_fetch_array($claninfo);
			$wins = $clan_info['wins'];
			$expp = $clan_info['exp'];
			$members = $clan_info['members'];
			$avegexp = $expp / $members;
			$po0 = sqrt($members);
			$po1 = sqrt($expp);
			$po2 = sqrt($avegexp);
			$po3 = log($wins);
			$po4 = $po1 * $po2 * $po3 * $po4;
			$po5 = $po4 / 10000;
			$po6 = round($po5, 1);
			mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$sideright1['clan_name']}'");
		}
	}
	if($_POST['uid'] && $_POST['t'] && $_POST['o'] && $_POST['pid']){
		$re = mysql_query("SELECT * FROM members WHERE id = '{$_POST['uid']}'");
		$rr = mysql_fetch_array($re);
		mysql_query("INSERT INTO unotify (owner, pid, powner, prowner, ra) VALUES ('{$_POST['uid']}', '{$_POST['pid']}', '{$_SESSION['myid']}','{$_SESSION['myuser']}', '0')");
		$tim = $_POST['t'] / 17;
		if($_POST['o'] == 'accept'){
			$yr = mysql_query("SELECT pid FROM upfortrade WHERE pid = '{$_POST['pid']}'");
			$err = mysql_num_rows($yr);
			$uq = mysql_query("SELECT * FROM utraded WHERE owner = '{$_POST['uid']}' AND time = '{$tim}' AND oid = '{$_POST['pid']}'");
			$rrww = mysql_num_rows($uq);
			if($rrww > 0 && $err != 0){
				$haha = mysql_query("DELETE FROM upfortrade WHERE pid = '{$_POST['pid']}'");
				$te = 0;
				while($jm = mysql_fetch_array($uq)){
					$te++;
					$jjj = mysql_query("UPDATE pokemon SET owner = '{$_SESSION['myid']}', rowner = '{$_SESSION['myuser']}' WHERE id = '{$jm['id']}'");
					mysql_query("INSERT INTO unotify (owner, pid, powner, prowner, ra) VALUES ('{$_SESSION['myid']}', '{$jm['id']}', '{$_POST['uid']}','{$rr['username']}', '0')");
					if($jjj){
						mysql_query("DELETE FROM utraded WHERE id = '{$jm['id']}'");
					}
				}
				$y = mysql_query("SELECT * FROM utraded WHERE oid = '{$_POST['pid']}'");
				while($dq = mysql_fetch_array($y)){
					mysql_query("UPDATE pokemon SET owner = '{$dq['owner']}', rowner = '{$dq['rowner']}' WHERE id = '{$dq['id']}'");
					mysql_query("INSERT INTO unotify (owner, pid, powner, prowner, ra) VALUES ('{$dq['owner']}', '{$dq['id']}', '{$_SESSION['myid']}','{$_SESSION['myuser']}', '1')");
					updatetherepoints($dp['owner'], -1);
				}
				mysql_query("DELETE FROM utraded WHERE oid = '{$_POST['pid']}'");
				$d = mysql_query("UPDATE pokemon SET owner = '{$_POST['uid']}', rowner = '{$rr['username']}' WHERE id = '{$_POST['pid']}'");
	
				updatetherepoints($_POST['uid'], 1);
			}
			updatepoints($te);
		}
	}
	if($_REQUEST['uid'] && $_REQUEST['t'] && $_REQUEST['o'] =='decline' && $_REQUEST['pid']){
		$timm = $_REQUEST['t'] / 17;
		$mnm = mysql_query("SELECT * FROM utraded WHERE owner = '{$_REQUEST['uid']}' AND time = '{$timm}' AND oid = '{$_REQUEST['pid']}'");
		$te = 0;
		while($nmn = mysql_fetch_array($mnm)){
			$te++;
			mysql_query("INSERT INTO unotify (owner, pid, powner, prowner, ra) VALUES ('{$nmn['owner']}', '{$nmn['id']}', '{$_SESSION['myid']}','{$_SESSION['myuser']}', '1')");
			$ba = mysql_query("UPDATE pokemon SET owner = '{$nmn['owner']}', rowner = '{$nmn['rowner']}' WHERE id = '{$nmn['id']}'");
			if($ba){
				$dd = mysql_query("DELETE FROM utraded WHERE id = '{$nmn['id']}'");
			}
		}
		updatetherepoints($_REQUEST['uid'], $te);
		mysql_query("UPDATE upfortrade SET offers = offers - 1 WHERE pid = '{$_REQUEST['pid']}'");
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<?php
if($_SESSION['layout'] == '1'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
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
<title>Pok&eacute;mon Shqipe v3 - Trade Offer</title>
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
<p /><?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<div id="ajax">
	<?php
    if($_GET['uid'] && $_GET['t'] && $_GET['o'] == 'accept' && $_GET['pid']){
        ?>
        Are you sure you want to accept? <b>Note: This cannot be undone.</b> <form action="offer.php" method="POST"><input type="hidden" name="uid" value="<?php echo $_REQUEST['uid'];?>"><input type="hidden" name="t" value="<?php echo $_REQUEST['t'];?>"><input type="hidden" name="o" value="<?php echo $_REQUEST['o'];?>"><input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'];?>"><input type="submit" name="trade" value="Accept!"></form>
        <?php
    }
    if($d && $haha){
        echo '<h2>Offer Accepted!</h2>';
    }
    if($dd){
        echo '<h2>Offer Declined</h2>';
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
    <?php
}
else {
	header("location:login.php?goawayxP=1");
}
include('pv_disconnect_from_db.php'); ?>