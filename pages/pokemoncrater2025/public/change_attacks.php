<?php
include('kick.php');
if(!isset($_SESSION['myid']) || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
$time = time();
$r = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
$re = mysql_fetch_array($r);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
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
<title>Pok&eacute;mon Vortex v3 - Change Attacks</title>
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

<?php
$pid = mysql_real_escape_string($_REQUEST['pid']);
$t = mysql_query("SELECT * FROM pokemon WHERE id = '$pid' AND owner = '{$_SESSION['myid']}'");
$cth = mysql_num_rows($t);

if($cth == '0'){
	echo '<div class="errorMsg">Error. Either this isn\'t your pokemon or an unseen error has occured.</div>';
}
if($cth != '0'){
	$th = mysql_fetch_array($t);
	echo '<h2>Change an attack for your ' . $th['name'] . '</h2>';
	
	if($_REQUEST['error']){
		if($_REQUEST['error'] == '1'){
			echo '<div class="errorMsg">You need to select an attack from your pokemon and an attack to change it to.</div>';
		}
		if($_REQUEST['error'] == '2'){
			echo '<div class="errorMsg">An error occured.</div>';
		}
		if($_REQUEST['error'] == '3'){
			echo '<div class="errorMsg">You do not have enough money.</div>';
		}
		if($_REQUEST['error'] == '4'){
			echo '<div class="errorMsg">You cannot teach your Pok&eacute;mon an attack it already knows.</div>';
		}
	}
	if($_REQUEST['updated'] == '1'){
		echo '<div class="actionMsg">Pokemon attack has been updated.</div>';
	}
	?>
	<img src="http://static.pokemon-vortex.com/images/pokemon/<?php echo $th['name'];?>.gif" /><br><a href="/pokedex?pid=<?php echo $pid;?>" onclick="pokedexTab('pid=<?php echo $pid;?>', 1); return false;"><?php echo $th['name'];?></a>
	<br>
	<h3>Please choose an attack to change.</h3><br>
	<form method="POST" action="change_attacks_1.php" onsubmit="return disableSubmitButton(this)">
	<center>
	<input type="hidden" name="pid" value="<?php echo $pid;?>">
	<div style="text-align:left;margin:0px 0px 0px 350px;">
	<input type="radio" name="attack" value="a1"> 1. <?php echo $th['a1']; ?><br/>
	<input type="radio" name="attack" value="a2"> 2. <?php echo $th['a2']; ?><br/>
	<input type="radio" name="attack" value="a3"> 3. <?php echo $th['a3']; ?><br/>
	<input type="radio" name="attack" value="a4"> 4. <?php echo $th['a4']; ?>
	</div>
	</center>
	<br>
	<div class="hr" style="width:400px;text-align:center;margin:0 auto;"></div>
	<div class="noticeMsg">While v3 is still in beta, you cannot yet change attacks for Pok&eacute;mon that begin with the letters:<br />L, M or T.<br />These will be added as soon as they're complete.</div>
	<h3>Please choose an attack to change to.</h3>
	<strong>Money:</strong> <img src="http://static.pokemon-vortex.com/images/misc/pmoney.gif" align="absmiddle"> <?php echo number_format($re['money']); ?><br />
	<center><br />
	<?php
	// Include external change attack scripts.
	include('changeattacks/a.php');
	include('changeattacks/b.php');
	include('changeattacks/c.php');
	include('changeattacks/d.php');
	include('changeattacks/e.php');
	include('changeattacks/f.php');
	include('changeattacks/g.php');
	include('changeattacks/h.php');
	include('changeattacks/i.php');
	include('changeattacks/j.php');
	include('changeattacks/k.php');
	include('changeattacks/l.php');
	include('changeattacks/m.php');
	include('changeattacks/n.php');
	include('changeattacks/o.php');
	include('changeattacks/p.php');
	include('changeattacks/q.php');
	include('changeattacks/r.php');
	include('changeattacks/s.php');
	include('changeattacks/t.php');
	include('changeattacks/u.php');
	include('changeattacks/v.php');
	include('changeattacks/w.php');
	include('changeattacks/x.php');
	include('changeattacks/y.php');
	include('changeattacks/z.php');
	?>
	</center>
	<input type="submit" value="Change!"></form>
	<?php
}
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
include('pv_disconnect_from_db.php');
?>