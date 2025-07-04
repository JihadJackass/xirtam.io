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
	if(isset($_POST['bye'])){
		$r = mysql_query("SELECT battle, s1, s2, s3, s4, s5, s6 FROM members WHERE id = '{$_SESSION['myid']}'");
		$re = mysql_fetch_array($r);
		switch($_POST['byeinfo']){
			case $re['s1']:
			$team = 2;
			break;
			case $re['s2']:
			$team = 2;
			break;
			case $re['s3']:
			$team = 2;
			break;
			case $re['s4']:
			$team = 2;
			break;
			case $re['s5']:
			$team = 2;
			break;
			case $re['s6']:
			$team = 2;
			break;
			default:
			$team = 3;
			break;
		}
		if($team == 3){
			mysql_query("DELETE FROM pokemon WHERE id = '{$_POST['byeinfo']}' AND owner = '{$_SESSION['myid']}'");
			mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_POST['byename']}'");
			mysql_query("UPDATE members SET total_poke = total_poke - 1 WHERE id = '{$_SESSION['myid']}'");
			$sideright = $r;
			$sideright1 = $re;
			$aiir = mysql_query("SELECT owner, SUM(exp), AVG(exp) FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY owner");
			$aiir2 = mysql_fetch_array($aiir);

			$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid");
			unset($_SESSION['your_pokemon']);
			while($h = mysql_fetch_array($result)){
				$_SESSION['your_pokemon'][] = $h['pid'];
			}
			$unique = mysql_num_rows($result);
			$avgexp = $aiir2['AVG(exp)'];
			$totalexp = $aiir2['SUM(exp)'];
			$battle = $sideright1['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET points = '$p7', averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique' WHERE id = '{$_SESSION['myid']}'");
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
		}
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
<?php
if($_SESSION['layout'] == '2'){
	echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/game.css" media="screen" />';
}
if($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/game.css" media="screen" />';
}
if($_SESSION['layout'] == '1'){
	echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/blue/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/blue/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/ie6-.js"></script>
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Vortex v3 - Release a Pok&eacute;mon</title>
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
          $('body').html("<center><h2>Oh no, You have AdBlocker</h2><img src=\"http://static.pokemon-vortex.com/images/pika_cry.gif\"><p />We noticed you have an active Ad Blocker.<br />Pok&eacute;mon Vortex is 100% funded by advertisements, we promise our ads are of high quality and are unobtrusive.<br />Please whitelist this site from your ad blocker so we can continue to provide this website for as long as possible and for free.<br />Thank You.");
      }
  },1000);
});
</script>
</div>
<div id="title">
<h1><a href="http://www.pokemon-vortex.com/"><em>PokemonVortex.com</em></a></h1>
</div>
<ul id="nav">
<li><a href="/map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li>
<li><a href="/battle_select.php" id="battleTab" class="deselected"><em>Battle</em></a></li>
<li><a href="/your_account.php" id="yourAccountTab" class="selected"><em>Your Account</em></a></li>
<li><a href="community.php" id="communityTab" class="deselected"><em>Communtiy</em></a></li>
</ul>
<ul id="logout">
<li><a href="/logout.php">Logout</a></li>
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
<li><a href="/pokedex.php" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
<li><a href="/members.php" id="membersTab" class="deselected"><em>Members</em></a></li>
<li><a href="/options.php" id="optionsTab" class="deselected"><em>Options</em></a></li>
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
    if($team == 2){
		echo "<div class=\"errorMsg\">The pok&eacute;mon you wish to release is in your team, so you can't release it. To release it, take it out of your team and then try again.</div>"; ?>
		<p class="optionsList autowidth"><strong>Options:</strong><br />
		<a href="/dashboard.php" class="deselected">Your Dashboard</a><br />
        <a href="/your_team.php" class="deselected">View/Modify Team</a><br />
        <a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
		</p>
		<?php
	}
	elseif($team == 3){
		echo "<div class=\"actionMsg\">Your ".$_POST['byename']." was successfully released back into the wild.</div>"; ?>
        <p class="optionsList autowidth"><strong>Options:</strong><br />
        <a href="/dashboard.php" class="deselected">Your Dashboard</a><br />
        <a href="/your_team.php" class="deselected">View/Modify Team</a><br />
        <a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
        <?php
	}
	elseif(!is_numeric($_REQUEST['pid'])){
		echo "<div class=\"errorMsg\">No pok&eacute;mon was selected to release.</div>"; ?>
        <p class="optionsList autowidth"><strong>Options:</strong><br />
        <a href="/dashboard.php" class="deselected">Your Dashboard</a><br />
        <a href="/your_team.php" class="deselected">View/Modify Team</a><br />
        <a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
        </p>
        <?php
	}
	else {
		$xt = mysql_query("SELECT * FROM pokemon WHERE id = '{$_REQUEST['pid']}' AND owner = '{$_SESSION['myid']}'");
		$xxt = mysql_fetch_array($xt);
		mysql_query("UPDATE online SET activity = 'Releasing their {$xxt['name']}' WHERE id = '{$_SESSION['myid']}'");
		?>
        <div class="noticeMsg">Your <?php echo $xxt['name']; ?> will be gone forever if you continue. Click the button below to verify that you really want to do so.</div>
        <img src="http://static.pokemon-vortex.com/images/pokemon/<?php echo $xxt['name']; ?>.gif" height="96" width="96">
        <form method="POST">
        <input name="bye" type="submit" value="Release" />
        <input name="byeinfo" type="hidden" value="<?php echo $_REQUEST['pid']; ?>" />
        <input name="byename" type="hidden" value="<?php echo $xxt['name']; ?>" />
        </form>
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
	<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/gameInit.js"></script>
	</html>
	<?php
}
else {
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
}
include('pv_disconnect_from_db.php');
?>