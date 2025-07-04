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
	$_REQUEST['pid'] = mysql_real_escape_string($_REQUEST['pid']);

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
			$po4 = $po1 * $po2 * $po3 * $po0;
			$po5 = $po4 / 10000;
			$po6 = round($po5, 1);
			mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
		}
	} // End update your points
	
	function updatetherepoints($thereid, $te){ // update the other users points
		$sideright = mysql_query("SELECT * FROM members WHERE id = '{$thereid}'");
		$sideright1 = mysql_fetch_array($sideright);
		if($sideright1['clan_name']){ // remove their total exp from the clan to update later
			$theirexp = $sideright1['totalexp'];
			mysql_query("UPDATE clans SET exp = exp - $theirexp WHERE name = '{$sideright1['clan_name']}'");
		}
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
		if($sideright1['clan_name']){ // update their clan points if they're in a clan
			mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$thereid}'");
			mysql_query("UPDATE clans SET exp = exp + $totalexp WHERE name = '{$sideright1['clan_name']}'");
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
			$po4 = $po1 * $po2 * $po3 * $po0;
			$po5 = $po4 / 10000;
			$po6 = round($po5, 1);
			mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$sideright1['clan_name']}'");
		}
	} // End update their points
	
	if($_POST['offer']){
		$qq = mysql_query("SELECT * FROM upfortrade WHERE pid = '{$_POST['pid']}'");
		$qw = mysql_num_rows($qq);
		if($qw > 0){
			$fields = $_POST['check_list']; 
			$och = count($fields);
			if($och > 0){
				$quer = 'SELECT * FROM pokemon WHERE owner = ' . $_SESSION['myid'] . ' AND id IN(' . implode(',', $fields) . ')';
				$get_poke = mysql_query($quer);
				while($ret_poke = mysql_fetch_array($get_poke)){
					$te++;
					$pokedata[] = '("' . $_POST['pid'] . '", "' . $ret_poke['name'] . '", "' . $ret_poke['id'] . '", "' . $ret_poke['a1'] . '", "' . $ret_poke['a2'] . '", "' . $ret_poke['a3'] . '", "' . $ret_poke['a4'] . '", "' . $ret_poke['lvl'] . '", "' . $ret_poke['exp'] . '", "' . $_SESSION['myuser'] . '", "' . $ret_poke['owner'] . '", "' . $time . '")';  
				}
				if(mysql_num_rows($get_poke) != 0){

					$sql_query = 'INSERT INTO utraded (oid, name, id, a1, a2, a3, a4, lvl, exp, rowner, owner, time) VALUES' . implode(',', $pokedata);
					$ree = mysql_query($sql_query);
					if($ree){
						mysql_query("UPDATE pokemon SET owner = '0', rowner = '' WHERE id IN(" . implode(',', $fields) . ")");
						mysql_query("UPDATE upfortrade SET offers = offers + 1 WHERE pid = '{$_POST['pid']}'");
					}
				}
				updatepoints($te);
			}
		}
	}
	if($_POST['ro']){
		$ti = mysql_query("SELECT * FROM utraded WHERE oid = '{$_SESSION['rid2']}' AND owner = '{$_SESSION['myid']}' AND time = '{$_SESSION['riddle']}'");
		$tii = mysql_num_rows($ti);
		if($tii > '0'){
			$te = 0;
			while($te = mysql_fetch_array($ti)){
				$te--;
				$q2 = mysql_query("UPDATE pokemon SET owner='{$_SESSION['myid']}', rowner = '{$_SESSION['myuser']}' WHERE id = '{$te['id']}'");
				$q1 = mysql_query("DELETE FROM utraded WHERE id = '{$te['id']}'");
			}
			mysql_query("UPDATE upfortrade SET offers = offers - 1 WHERE pid = '{$_SESSION['rid2']}'");
			updatepoints($i);
		}
		unset($_SESSION['riddle'], $_SESSION['rid2']);
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
elseif($_SESSION['layout'] == '2'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />';
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
<title>Shqipe Battle Arena v3 - Make An Offer</title>
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
<?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<div id="ajax">
	<?php
	if(!$_REQUEST['tid'] && !$_POST['ro']){ 
		$pid = $_REQUEST['pid'];
		$r = mysql_query("SELECT * FROM upfortrade WHERE pid = '$pid'");
		$rrr = mysql_num_rows($r);
		if($rrr == 0){
			echo "<h2>The pokemon you wish to offer on does not exist, or there was an error with your request.</h2>"; ?>
			<p class="optionsList autowidth"><strong>Options:</strong><br />
			<a href="trade.php" class="deselected">Trade Page</a><br />
			<a href="your_team.php" class="deselected">View/Modify Team</a><br />
			<a href="your_pokemon.php" class="deselected">View All Pokemon</a></p>
			<?php
		}
		else{ 
			$rr = mysql_fetch_array($r);
			function checkNum($number){
				return ($number%2) ? TRUE : FALSE;
			}
			$pre = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$pre2 = mysql_fetch_array($pre);
			$s = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id != '{$pre2['s1']}' AND id != '{$pre2['s2']}' AND id != '{$pre2['s3']}' AND id != '{$pre2['s4']}' AND id != '{$pre2['s5']}' AND id != '{$pre2['s6']}' ORDER BY name ASC"); 
			
			if($_POST['offer']){
				echo "<h2>Offer has been made.";
			}
			if(!$_POST['offer']){
				?>

				<h2>Make an offer for <a href="members.php?uid=<? echo $rr['owner']; ?>" onclick="membersTab('uid=<? echo $rr['owner']; ?>', 1); return false;"><? echo htmlentities($rr['rowner']); ?></a>'s <a href="pokedex.php?pid=<? echo $rr['id']; ?>" onclick="pokedexTab('pid=<? echo $rr['id']; ?>', 1); return false;"><? echo $rr['name']; ?></a>:</h2>
				<p><img src="html/static/images/pokemon/<? echo $rr['name']; ?>.gif"></p>
                <p><i>Level</i>: <? echo $rr['lvl']; ?></p>
                <p><i>Experience</i>: <? echo number_format($rr['exp']); ?></p>
                <span class="small">Please offer for the pok&eacute;mon you are interested in.</span>
                <div class="list mediumwidth" style="margin: 10px auto;height:400px;overflow:auto;">
                <form method="post" name="myform" >
                <table cellpadding="5" cellspacing="0">
                <tr>
                
                <th style="width: 20px;" id="checking"></th>
                <th style="width: 180px;">Pok&eacute;mon</th>
                <th style="width: 50px;">Level</th>
                <th style="width: 70px;">Exp</th>
                </tr>
				<?php
                while($ss = mysql_fetch_array($s)){ 
					$i = 1;
					$number += $i;
					?>
                    <tr class="<? if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>">
                    <td style="height: 20px; text-align: left;">
                    <input type="checkbox" name="check_list[]" value="<? echo $ss['id']; ?>" /></td><td style="height: 70px; text-align: left;"><img src="html/static/images/pokemon/<? echo $ss['name']; ?>.gif" />
                    <strong><a href="pokedex.php?pid=<? echo $ss['id']; ?>" onclick="pokedexTab('pid=<? echo $ss['id']; ?>', 1); return false;"><? echo $ss['name']; ?></a></strong></td><td style="width: 50px; height: 70px;"><? echo $ss['lvl']; ?></td><td style="width: 70px; height: 70px;"><? echo number_format($ss['exp']); ?></td></tr>
					<?php
				}
				?>
                </table></div>
                <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'];?>">
                <input type="submit" name="offer" value="Offer Pok&eacute;mon" /><form>
				<?php
			}
		}
	}
	else{
		$_SESSION['rid2'] = $_REQUEST['tid']; $_SESSION['riddle'] = $_REQUEST['t'];

		if($_POST['ro']){
			echo "<h2>Offer Removed</h2>";
		}
		if(!$_POST['ro']){
			?>
            <h2>Verify Action</h2>
			<span class="small">By removing this pok&eacute;mon from your offer, you will be removing your entire offer for that pok&eacute;mon.</span>
			<form method="post" action="">
			<input type="submit" name="ro" value="Continue" />
			</form>
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
    <script type="text/javascript" language="javascript" src="html/static/js//gameInit.js"></script>
    </html>
    <?php
}
else{
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_disconnect_from_db.php'); ?>