<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
if($_SESSION['access'] == 9){
	include('pv_connect_to_db.php');
	$time = time();
	function updatepoints(){
		$sideright = mysql_query("SELECT id, battle FROM members WHERE id = '{$_SESSION['myid']}'");
		$sideright1 = mysql_fetch_array($sideright);
		$aiir = mysql_query("SELECT owner, SUM(exp), AVG(exp) FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY owner");
		$aiir2 = mysql_fetch_array($aiir);
		
		$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY pid");
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
	
	if(isset($_POST['submit'])){
		$box = $_POST['mycheckbox'];
		$dea = mysql_query("SELECT * FROM members WHERE id ='{$_SESSION['myid']}'");
		$ead = mysql_fetch_array($dea);
		while (list ($key,$val) = @each ($box)){
			if($ead['s1'] != $val && $ead['s2'] != $val && $ead['s3'] != $val && $ead['s4'] != $val && $ead['s5'] != $val && $ead['s6'] != $val){ 
			$slotcheck = mysql_query("SELECT * FROM pokemon WHERE id = '{$val}' AND owner = '{$_SESSION['myid']}'");
			$slotchec = mysql_fetch_array($slotcheck);
			if(mysql_num_rows($slotcheck) != 0){
				mysql_query("INSERT INTO upfortrade (name, pid, owner, a1, a2, a3, a4, lvl, exp, rowner, date) VALUES ('{$slotchec['name']}', '{$slotchec['id']}', '{$slotchec['owner']}', '{$slotchec['a1']}', '{$slotchec['a2']}', '{$slotchec['a3']}', '{$slotchec['a4']}', '{$slotchec['lvl']}', '{$slotchec['exp']}', '{$slotchec['rowner']}', '$time')");
				mysql_query("UPDATE pokemon SET owner = '0', rowner = '' WHERE id = '{$val}'");
				mysql_query("UPDATE members SET total_poke = total_poke - 1 WHERE id = '{$_SESSION['myid']}'");
			}
			}
		}
		updatepoints();
		$update = 2;
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
if($_SESSION['layout'] == '0'){
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
<title>Pok&eacute;mon v3 - Put a Pok&eacute;mon Up for Trade</title>
</head>
<body>
<?php include_once("analytics.php"); ?>
<div id="alert"></div><div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<noscript>
<img src="http://static.pokemonvortex.org/images/fbbanner.png" width="728" height="90" marginwidth="0" marginheight="0" style="border:1px solid #990000;">
</noscript>
<?php
include('/var/www/ads/headerad.php');
?>
</div>
<div id="title">
<h1><a href="index.php"><em>PokemonShqipe.co.uk</em></a></h1>
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
if($_REQUEST['type'] != "multiple"){
	$pid = mysql_real_escape_string($_REQUEST['pid']);
	$pokecheck = mysql_query("SELECT * FROM pokemon WHERE id = '$pid' AND owner = '{$_SESSION['myid']}'");
	$pokechec = mysql_num_rows($pokecheck);
	$slotcheck = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$slotchec = mysql_fetch_array($slotcheck);
	if($pokechec == 0){
		?>
        <div class="errorMsg">Sorry, but the pok&eacute;mon you have selected to put up for trade doesn't exist, or doesn't belong to you.</div>
        <p class="optionsList autowidth"><strong>Options:</strong><br />
        <a href="trade.php" class="deselected">Trade Page</a><br />
        <a href="your_team.php" class="deselected">View/Modify Team</a><br />
        <a href="your_pokemon.php" class="deselected">View All Pokemon</a></p>
		<?php
	}
	else
	{
		if($slotchec['s1'] == $pid || $slotchec['s2'] == $pid || $slotchec['s3'] == $pid || $slotchec['s4'] == $pid || $slotchec['s5'] == $pid || $slotchec['s6'] == $pid){
			?>
            <div class="errorMsg">Sorry, but the pok&eacute;mon you have selected to put up for trade is currently in your team, so you can't put it up for trade. If you wish to put it up for trade, please remove it from your team.</div>
            <p class="optionsList autowidth"><strong>Options:</strong><br />
            <a href="trade.php" class="deselected">Trade Page</a><br />
            <a href="your_team.php" class="deselected">View/Modify Team</a><br />
            <a href="your_pokemon.php" class="deselected">View All Pokemon</a></p>
			<?php
		}
		else
		{
			$pokeche = mysql_fetch_array($pokecheck);
			mysql_query("INSERT INTO upfortrade (name, pid, owner, a1, a2, a3, a4, lvl, exp, rowner, date) VALUES ('{$pokeche['name']}', '{$pokeche['id']}', '{$pokeche['owner']}', '{$pokeche['a1']}', '{$pokeche['a2']}', '{$pokeche['a3']}', '{$pokeche['a4']}', '{$pokeche['lvl']}', '{$pokeche['exp']}', '{$pokeche['rowner']}', '$time')");
			mysql_query("UPDATE pokemon SET owner = '0', rowner = '' WHERE id = '{$pokeche['id']}' AND owner = '{$_SESSION['myid']}'");
			updatepoints();
			?>
            
            
            <h3>Your <?php echo $pokeche['name']; ?> has successfully been put up for trade!</h3>
            <img src="html/static/images/pokemon/<?php echo $pokeche['name']; ?>.gif">
            <p class="optionsList autowidth"><strong>Options:</strong><br />
            <a href="trade.php" class="deselected">Trade Page</a><br />
            <a href="your_team.php" class="deselected">View/Modify Team</a><br />
            <a href="your_pokemon.php" class="deselected">View All Pokemon</a></p>
			<?php
		}
	}
}
elseif($update != 2){
	$pre = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$pre2 = mysql_fetch_array($pre);
	$r = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id != '{$pre2['s1']}' AND id != '{$pre2['s2']}' AND id != '{$pre2['s3']}' AND id != '{$pre2['s4']}' AND id != '{$pre2['s5']}' AND id != '{$pre2['s6']}' ORDER BY name ASC");
	function checkNum($number){
		return ($number%2) ? TRUE : FALSE;
	}
	?>
    <h2>Put Multiple Pok&eacute;mon Up For Trade:</h2>
    <div class="list mediumwidth" style="margin: 10px auto;height:600px;overflow:auto;">
    <form method="post">
    <table cellpadding="5" cellspacing="0">
    <tr>
    <th style="width: 200px;">Pok&eacute;mon</th>
    <th style="width: 50px;">Level</th>
    <th style="width: 70px;">Exp</th>
    </tr>
    
	<?php
    while($rr = mysql_fetch_array($r)){
		$i = 1;
		$number += $i;
		?>
        
        <tr class="<?php if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>">
        <td style="height: 70px; text-align: left;">
        <input type="checkbox" name="mycheckbox[]" value="<? echo $rr['id']; ?>" /><img src="http://static.pokemonvortex.org/images/pokemon/<?php echo $rr['name']; ?>.gif" />
        <strong><a href="pokedex.php?pid=<?php echo $rr['id']; ?>" onclick="pokedexTab('pid=<?php echo $rr['id']; ?>', 1); return false;"><?php echo $rr['name']; ?></a></strong></td><td style="width: 50px; height: 70px;"><?php echo $rr['lvl']; ?></td><td style="width: 70px; height: 70px;"><?php echo number_format($rr['exp']); ?></td></tr>
		
		<?php
	}
	?>
    </table></div><input type="submit" name="submit" value="Put Up For Trade"/></form>
    <?php
}
else
{
	?>
    
    <div class="actionMsg">Your selected pok&eacute;mon have been put up for trade.</div>
    <p class="optionsList autowidth"><strong>Options:</strong><br />
    <a href="trade.php" class="deselected">Trade Pok&eacute;mon</a><br />
    <a href="your_team.php" class="deselected">View/Modify Team</a><br />
    <a href="your_pokemon.php" class="deselected">View All Pokemon</a></p>
    <a href="items.php" class="deselected">Pok&eacute;mart</a></p>
	
	<?php
}
include('disclaimer.php');
?>
</div></div></div></div></div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php
}
else {
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
?>