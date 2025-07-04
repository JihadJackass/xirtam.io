<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
$time = time();

if(isset($_POST['evolve'])){
	$_REQUEST['pid'] = mysql_real_escape_string($_REQUEST['pid']);
	$st = mysql_query("SELECT * FROM pguide WHERE name = '{$_SESSION['evpoke']}'");
	$ss = mysql_fetch_array($st);
	if($_POST['attacks'] == "yes"){
		mysql_query("UPDATE pokemon SET pid = '{$ss['id']}', name = '{$_SESSION['evpoke']}', t1 = '{$ss['type1']}', t2 = '{$ss['type2']}', a1 = '{$ss['a1']}', a2 = '{$ss['a2']}', a3 = '{$ss['a3']}', a4 = '{$ss['a4']}' WHERE id = '{$_SESSION['ev']}'");
		mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$_SESSION['evpoke']}'");
		mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
	}
	else {
		mysql_query("UPDATE pokemon SET pid = '{$ss['id']}', name = '{$_SESSION['evpoke']}', t1 = '{$ss['type1']}', t2 = '{$ss['type2']}' WHERE id = '{$_SESSION['ev']}'");
		mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$_SESSION['evpoke']}'");
		mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
	}
	
	$sideright = mysql_query("SELECT id, battle FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideright1 = mysql_fetch_array($sideright);
	$aiir = mysql_query("SELECT owner, SUM(exp), AVG(exp) FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY owner");
	$aiir2 = mysql_fetch_array($aiir);
	$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY pid");
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
	mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique', points = '$p7' WHERE id = '{$_SESSION['myid']}'");
	$mii = 1;
}

if($mii != 1){
	$_REQUEST['pid'] = mysql_real_escape_string($_REQUEST['pid']);
	$r = mysql_query("SELECT * FROM pokemon WHERE id = '{$_REQUEST['pid']}' AND owner = '{$_SESSION['myid']}'"); 
	$rr = mysql_num_rows($r);
	$rrr = $rr;
	if($rrr > 0){
		$rrrr = mysql_fetch_array($r);
		$_SESSION['evid'] = $_REQUEST['pid'];
		$_SESSION['evname'] = $rrrr['name'];
		$se = mysql_query("SELECT * FROM pguide WHERE name = '{$rrrr['name']}'");
		$see = mysql_fetch_array($se);
		$evlvl = $see['ev']; 
		$pklvl = $rrrr['lvl'];
		if($evlvl > $pklvl){
			$b = 3;
		}

		if($evlvl <= $pklvl){
			$b = 4;
			$_SESSION['ev'] = $_REQUEST['pid'];
			$_SESSION['evpoke'] = $see['ep'];
		}
		if($see['ev'] == 0){
			$b = 5;
		}
		if(strstr($_SESSION['evname'],'Golbat')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Chansey')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Pichu')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Cleffa')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Igglybuff')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Togepi')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Azurill')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Budew')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Buneary')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Chingling')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Munchlax')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Riolu')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Woobat')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Swadloon')){
			$gethappy = mysql_query("SELECT * FROM pokemon_stats WHERE id = '{$_SESSION['evid']}'");
			$happy = mysql_fetch_array($gethappy);
			if($happy['happiness'] >= 220){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($happy['happiness'] < 220){
				$b = 8;
			}
		}
		if(strstr($_SESSION['evname'],'Combee')){
			$getgender = mysql_query("SELECT * FROM pokemon WHERE id = '{$_SESSION['evid']}'");
			$gender = mysql_fetch_array($getgender);
			if($gender['gender'] == 'Female'){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else if($gender['gender'] == 'Male'){
				$b = 10;
			}
		}
		if(strstr($_SESSION['evname'],'Rayquaza') && !strstr($_SESSION['evname'],'(Mega)')){
			if($rrrr['a1'] == 'Dragon Ascent' || $rrrr['a2'] == 'Dragon Ascent' || $rrrr['a3'] == 'Dragon Ascent' || $rrrr['a4'] == 'Dragon Ascent'){
				$b = 4;
				$_SESSION['ev'] = $_REQUEST['pid'];
				$_SESSION['evpoke'] = $see['ep'];
			}
			else{
				$b = 9;
			}
		}
		if(strstr($_SESSION['evname'],'Spewpa')){
			$b = 7;
			$getvivil = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$getvivi = mysql_fetch_array($getvivil);
			if($getvivi['number'] == '1'){
				$see['ep'] = $see['ep'];
			}
			if($getvivi['number'] == '2'){
				$see['ep'] = $see['ep2'];
			}
			if($getvivi['number'] == '3'){
				$see['ep'] = $see['ep3'];
			}
			if($getvivi['number'] == '4'){
				$see['ep'] = $see['ep4'];
			}
			if($getvivi['number'] == '5'){
				$see['ep'] = $see['ep5'];
			}
			if($getvivi['number'] == '6'){
				$see['ep'] = $see['ep6'];
			}
			if($getvivi['number'] == '7'){
				$see['ep'] = $see['ep7'];
			}
			if($getvivi['number'] == '8'){
				$see['ep'] = $see['ep8'];
			}
			if($getvivi['number'] == '9'){
				$see['ep'] = $see['ep9'];
			}
			if($getvivi['number'] == '10'){
				$see['ep'] = $see['ep10'];
			}
			if($getvivi['number'] == '11'){
				$see['ep'] = $see['ep11'];
			}
			if($getvivi['number'] == '12'){
				$see['ep'] = $see['ep12'];
			}
			if($getvivi['number'] == '13'){
				$see['ep'] = $see['ep14'];
			}
			if($getvivi['number'] == '14'){
				$see['ep'] = $see['ep15'];
			}
			if($getvivi['number'] == '15'){
				$see['ep'] = $see['ep16'];
			}
			if($getvivi['number'] == '16'){
				$see['ep'] = $see['ep17'];
			}
			if($getvivi['number'] == '17'){
				$see['ep'] = $see['ep18'];
			}
			if($getvivi['number'] == '18'){
				$see['ep'] = $see['ep19'];
			}
			if($getvivi['number'] == '19'){
				$see['ep'] = $see['ep13'];
			}
			if($getvivi['number'] == '20'){
				$see['ep'] = $see['ep20'];
			}
			$_SESSION['ev'] = $_REQUEST['pid'];
			$_SESSION['evpoke'] = $see['ep'];
		}
		else{
			if($see['ev2'] > 0 || !is_numeric($see['ev2']) ||  strstr($see['ev'],'Stone') || strstr($see['ev2'],'Stone') || strstr($see['ev'],'ite') ||  strstr($see['ev'],'Dragon Scale') ||  strstr($see['ev'],'Dubious Disc') ||  strstr($see['ev'],'Kings Rock') ||  strstr($see['ev'],'Magmarizer') ||  strstr($see['ev'],'Metal Coat') ||  strstr($see['ev'],'Prism Scale') ||  strstr($see['ev'],'Protector') ||  strstr($see['ev'],'Razor Claw') ||  strstr($see['ev'],'Razor Fang') ||  strstr($see['ev'],'Reaper Cloth') ||  strstr($see['ev'],'Up Grade')  ||  strstr($see['ev'],'Electirizer') ||  strstr($see['ev'],'Sachet') ||  strstr($see['ev'],'Whipped Dream') || strstr($see['ev'],'Orb')){
				$b = 6;
			}
		}
	}
	else {
		$b = 2;
	}
	if($b == 6){
		header("location: spevo.php?pid={$_REQUEST['pid']}");
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
<title>Pok&eacute;mon Shqipe v3 Evolve a Pok&eacute;mon</title>
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
?><script>
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
<div style="float: right;">

<?php
include('/var/www/ads/sidead.php');
?>
</div><div id="scrollContent">
<div id="ajax">
<?php
if($mii != 1){
	switch($b){
		case 2:
		echo "<div class=\"errorMsg\">This pokemon does not exist or does not belong to you.</div><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Your Trades</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
		break;
		
		case 3:
		echo "<h5>Your " . $_SESSION['evname'] . " will evolve into " . $see['ep'] . " at level " . $evlvl . ".</h5><br /><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" align=\"center\"> <font size=\"2\">&rarr;</font> <img src=\"html/static/images/pokemon/" . $see['ep'] . ".gif\" align=\"center\"><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Your Trades</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
		break;
		
		case 4:
		echo "<h5>Your " . $_SESSION['evname'] . " will evolve into " . $see['ep'] . ".</h5><br/><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" align=\"center\"> <font size=\"2\">&rarr;</font> <img src=\"html/static/images/pokemon/" . $see['ep'] . ".gif\" align=\"center\"><form method=\"post\"><input type=\"checkbox\" name=\"attacks\" checked=\"true\" value=\"yes\"/> Replace " . $_SESSION['evname'] . "'s attacks with " . $see['ep'] . "'s attacks.<br/><input type=\"submit\" value=\"Evolve!\" name=\"evolve\" /></form>";
		mysql_query("UPDATE online SET activity = 'Evolving a {$_SESSION['evname']}' WHERE id = '{$_SESSION['myid']}'");
		break;
		
		case 5:
		echo "<h5>Your " . $_SESSION['evname'] . " is in its final stage of evolution.</h5><br /><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" /><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Your Trades</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
		break;

		case 10:
		echo "<h5>Your " . $_SESSION['evname'] . " is not the right gender to evolve.</h5><br /><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" /><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Your Trades</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
		break;
		
		case 7:
		echo "<div class=\"noticeMsg\">Your account can only evolve Spewpa to one form of Vivillon. To get the rest, you must trade for them.</div>";
		echo "<h5>Your " . $_SESSION['evname'] . " will evolve into " . $see['ep'] . ".</h5><br/><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" align=\"center\"> <font size=\"2\">&rarr;</font> <img src=\"html/static/images/pokemon/" . $see['ep'] . ".gif\" align=\"center\"><form method=\"post\"><input type=\"checkbox\" name=\"attacks\" checked=\"true\" value=\"yes\"/> Replace " . $_SESSION['evname'] . "'s attacks with " . $see['ep'] . "'s attacks.<br/><input type=\"submit\" value=\"Evolve!\" name=\"evolve\" /></form>";
		mysql_query("UPDATE online SET activity = 'Evolving a {$_SESSION['evname']}' WHERE id = '{$_SESSION['myid']}'");
		break;

		case 8:
		echo "<h5>Your " . $_SESSION['evname'] . " does not have enough happiness to evolve.</h5><br />You need to battle more with this Pok&eacute;mon to raise it's happiness.<br /><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" /><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Your Trades</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
		break;

		case 9:
		echo "<h5>Your " . $_SESSION['evname'] . " needs to know the attack Dragon Ascent to evolve.</h5><br />You can teach your Pokemon specific attacks by visting the 'change attacks' page from viewing your team or viewing all Pok&eacute;mon.<br /><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" /><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Your Trades</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
		break;
	}
}
else {
	?>
    <h5>Congratulations! Your pok&eacute;mon has evolved into <? echo $_SESSION['evpoke']; ?>.</h5>
    <img src="html/static/images/pokemon/<? echo $_SESSION['evpoke']; ?>.gif" />
    <p class="optionsList autowidth"><strong>Options:</strong><br /><a href="/your_team.php" class="deselected">View/Modify Team</a><br /><a href="/trade.php" class="deselected">Your Trades</a><br /><a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
    <?php
}
echo '</div>';
include('disclaimer.php');
?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php
include('pv_disconnect_from_db.php');
?>