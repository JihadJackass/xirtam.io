<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:/login.php?goawayxP=1");
}
include('pv_connect_to_db.php');

if(isset($_POST['submit'])){
	$r = mysql_query("SELECT s1, s2, s3, s4, s5, s6 FROM members WHERE id = '{$_SESSION['myid']}'");
	$re = mysql_fetch_object($r);
	$s1 = $re->s1;
	$s2 = $re->s2;
	$s3 = $re->s3;
	$s4 = $re->s4;
	$s5 = $re->s5;
	$s6 = $re->s6;
	$s = $_POST['teamPokemon'];
	$r = $_POST['replacement'];
	$qw = mysql_query("SELECT id FROM pokemon WHERE id = '{$r}' AND owner = '{$_SESSION['myid']}'");
	$te = mysql_num_rows($qw);
	if($te > 0){
		if(is_numeric($r) && $r != $re->s1 && $r != $re->s2 && $r != $re->s3 && $r != $re->s4 && $r != $re->s5 && $r != $re->s6){
			switch($s){
				case 0:
				mysql_query("UPDATE members SET s1 = '$r' WHERE id = '{$_SESSION['myid']}'");
				$s1 = $r;
				$_SESSION['my_team'][0] = $r;
				break;
				case 1:
				mysql_query("UPDATE members SET s2 = '$r' WHERE id = '{$_SESSION['myid']}'");
				$s2 = $r;
				$_SESSION['my_team'][1] = $r;
				break;
				case 2:
				mysql_query("UPDATE members SET s3 = '$r' WHERE id = '{$_SESSION['myid']}'");
				$s3 = $r;
				$_SESSION['my_team'][2] = $r;
				break;
				case 3:
				mysql_query("UPDATE members SET s4 = '$r' WHERE id = '{$_SESSION['myid']}'");
				$s4 = $r;
				$_SESSION['my_team'][3] = $r;
				break;
				case 4:
				mysql_query("UPDATE members SET s5 = '$r' WHERE id = '{$_SESSION['myid']}'");
				$s5 = $r;
				$_SESSION['my_team'][4] = $r;
				break;
				case 5:
				mysql_query("UPDATE members SET s6 = '$r' WHERE id = '{$_SESSION['myid']}'");
				$s6 = $r;
				$_SESSION['my_team'][5] = $r;
				break;
			}
		}
	}
}
else {
	$r = mysql_query("SELECT s1, s2, s3, s4, s5, s6 FROM members WHERE id = '{$_SESSION['myid']}'");
	$re = mysql_fetch_object($r);
	$s1 = $re->s1;
	$s2 = $re->s2;
	$s3 = $re->s3;
	$s4 = $re->s4;
	$s5 = $re->s5;
	$s6 = $re->s6;
}
mysql_query("UPDATE online SET activity = 'Changing their team' WHERE id = '{$_SESSION['myid']}'");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/team.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>';
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
echo '<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie6-.js"></script>
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Shqipe v3 - Change Team</title>
</head>
<body>';
include_once("analytics.php");
echo '<div id="alert"></div><div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">';

include('/var/www/ads/headerad.php');
?>
<script>
$(function(){
   setTimeout(function(){
      if($("#headerAd").css('display')=="none")
      {
          $('body').html("<center><h2>Oh no, You have AdBlocker</h2><img src=\"html/static/images/pika_cry.gif\"><p />We noticed you have an active Ad Blocker.<br />Pok&eacute;mon Shqipe is 100% funded by advertisements, we promise our ads are of high quality and are unobtrusive.<br />Please whitelist this site from your ad blocker so we can continue to provide this website for as long as possible and for free.<br />Thank You.");
      }
  },1000);
});
</script>
<?php echo '</div>
<div id="title"><h1><a href="index.php"><em>pokemon-shqipe.co.uk</em></a></h1></div>
<ul id="nav">
<li><a href="map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li>
<li><a href="battle_select.php" id="battleTab" class="deselected"><em>Battle</em></a></li>
<li><a href="your_account.php" id="yourAccountTab" class="deselected"><em>Your Account</em></a></li>
<li><a href="community.php" id="communityTab" class="deselected"><em>Communtiy</em></a></li>
</ul>
<ul id="logout">
<li><a href="logout.php">Logout</a></li>
</ul>
</div>';
include('includes/usernav.php');
echo'<div id="contentContainer">
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
<p>';

include('/var/www/ads/sidead.php');

echo '</div><p />
<div id="ajax">
<h2>Change Your Team</h2>
<form method="POST"><p><strong>Search:</strong> <input type="text" name="pokemonName" id="pokemonName" value="" size="30" maxlength="40" /> <input name="go" type="submit" value="Search" /></p></form>';
$type = $_REQUEST['type'];

echo '<p class="optionsList autowidth"><strong>View:</strong> <a href="change_team.php?type=All" class="';
if($type == 'All'){
echo 'selected'; } else { echo 'deselected'; } 
echo '">All Your Pok&eacute;mon</a> | <a href="change_team.php?type=Normal" class="';
if($type == 'Normal'){ echo 'selected'; } else { echo 'deselected'; } 
echo '">Normal</a> | <a href="change_team.php?type=Metallic" class="';
if($type == 'Metallic'){ echo "selected"; } else { echo "deselected"; } 
echo '">Metallic</a> | <a href="change_team.php?type=Shiny" class="';
if($type == 'Shiny'){ echo "selected"; } else { echo "deselected"; } 
echo '">Shiny</a> | <a href="change_team.php?type=Dark" class="';
if($type == 'Dark'){ echo "selected"; } else { echo "deselected"; } 
echo '">Dark</a> | <a href="change_team.php?type=Mystic" class="';
if($type == 'Mystic'){ echo "selected"; } else { echo "deselected"; } 
echo '">Mystic</a> | <a href="change_team.php?type=Shadow" class="';
if($type == 'Shadow'){ echo "selected";} else { echo "deselected"; }
echo '">Shadow</a></p>
<form method="POST">
<table cellpadding="0" cellspacing="0" style="text-align: center; margin: 0 auto;">
<tr><td style="width: 260px; vertical-align: top;">
<h3>Your Pok&eacute;mon:</h3>
<div id="currentTeam" style="height: 400px; overflow: auto; overflow-y: scroll; overflow-x: hidden;" class="list">
<table cellpadding="5" cellspacing="0" style="width: 260px;">';

function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}
if(isset($_POST['go'])){
	$show = mysql_real_escape_string($_POST['pokemonName']);
	
	$get_type = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND name LIKE '%$show%' AND id != '$s1' AND id != '$s2' AND id != '$s3' AND id != '$s4' AND id != '$s5' AND id != '$s6' ORDER BY name ASC");
}

else {
	if($type == 'Normal' || $type == 'Metallic' || $type == 'Dark' || $type == 'Mystic' || $type == 'Shiny' || $type == 'Shadow' || $type == 'All'){
		if($type == 'All'){
			$get_type = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id != '$s1' AND id != '$s2' AND id != '$s3' AND id != '$s4' AND id != '$s5' AND id != '$s6' ORDER BY name ASC");
		}
		
		elseif($type == 'Normal'){
			$get_type = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND name NOT LIKE 'Dark %' AND name NOT LIKE 'Metallic %' AND name NOT LIKE 'Shiny %' AND name NOT LIKE 'Mystic %' AND name NOT LIKE 'Shadow %' AND id != '$s1' AND id != '$s2' AND id != '$s3' AND id != '$s4' AND id != '$s5' AND id != '$s6' ORDER BY name ASC");
		}
		
		else {
			$get_type = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND name LIKE '$type %' AND id != '$s1' AND id != '$s2' AND id != '$s3' AND id != '$s4' AND id != '$s5' AND id != '$s6' ORDER BY name ASC");
		}
	}
	
	else {
		$lmaa = 1;
	}
}
if($lmaa == 1){
	echo '<b>Please select an option above.</b>';
}
else{
	echo '<tr>
	<th>&nbsp;</th>
	<th style="width: 260px;">Pok&eacute;mon / Info</th>';
	
	while($gt = mysql_fetch_object($get_type)){
		$i = 1;
		$number += $i;
		echo '<tr class="';
		
		if(checkNum($number) === TRUE){
			echo 'dark';
		}
		else {
			echo 'light';
		}
		
		echo '"><td style="text-align: center;"><input type="radio" name="replacement" id="replacement" value="' . $gt->id . '"';
		if($number == 1){
			echo ' checked="checked"';
		}
		echo '/></td><td style="width: 260px; text-align: center; white-space: nowrap;" id="listy"><img src="html/static/images/pokemon/' . $gt->name . '.gif" /><br /><strong> <a href="/pokedex.php?pid=' . $gt->id . '" onclick="pokedexTab(\'pid=' . $gt->id . '\', 1); return false;">' . $gt->name . '</a></strong><br /><strong>Level: </strong>' . $gt->lvl . '<br /><strong>Exp: </strong>' . number_format($gt->exp) . '</td></tr>';
	}
}
echo '</table>
</div></td><td style="vertical-align: middle; width: 120px;">
<div style="width: 2px; height: 150px; background: #666666; margin: 0 auto 0 auto;">
</div>
<p><input name="submit" id="submit" type="submit" value="&larr; Switch &rarr;" title="Add to Pok&eacute;mon Team" style="width: 80px;" /></p>
<div style="width: 2px; height: 170px; background: #666666; margin: 0 auto 0 auto;">
</div>
</td>
<td style="width: 260px; vertical-align: top;">
<h3>Your current team:</h3>
<div id="currentTeam" style="height: 400px; overflow: auto; overflow-y: scroll; overflow-x: hidden;" class="list">
<table cellpadding="5" cellspacing="0" style="width: 260px;">
<tr>
<th>&nbsp;</th>
<th>Pok&eacute;mon / Info</th>
</tr>';

$sids = array();
foreach (array($s1,$s2,$s3,$s4,$s5,$s6) as $sid) {
	if (isset($sid) && (int)$sid == $sid) {
		$sids[] = (int)$sid;
	}
}
$sids = implode(',', $sids);
$t = mysql_query("SELECT name, id, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id IN($sids) ORDER BY FIELD(id,$sids)");
$pname = array();
$pid = array();
while($goo = mysql_fetch_object($t)){
	$pname[] = $goo->name;
	$pid[] = $goo->id;
	$plvl[] = $goo->lvl;
	$pexp[] = $goo->exp;
}
echo '
<tr class="dark"><td style="width: 30px; text-align: center;"><input type="radio" name="teamPokemon" id="teamPokemon" value="0" checked="checked" /></td><td style="height: 70px; text-align: center; white-space: nowrap;"><img src="html/static/images/pokemon/' . $pname[0] . '.gif" /><br /><strong> <a href="/pokedex.php?pid=' . $pid[0] . '" onclick="pokedexTab(\'pid=' . $pid[0] . '\', 1); return false;">' . $pname[0] . '</a><br />Level: </strong>' . $plvl[0] . '<br /><strong>Exp: </strong>' . number_format($pexp[0]) . '</td>';
if(is_numeric($s2)){
	echo '<tr class="dark"><td style="width: 30px; text-align: center;"><input type="radio" name="teamPokemon" id="teamPokemon" value="1"/></td><td style="height: 70px; text-align: center; white-space: nowrap;"><img src="html/static/images/pokemon/' . $pname[1] . '.gif" /><br /><strong> <a href="/pokedex.php?pid=' . $pid[1] . '" onclick="pokedexTab(\'pid=' . $pid[1] . '\', 1); return false;">' . $pname[1] . '</a><br />Level: </strong>' . $plvl[1] . '<br /><strong>Exp: </strong>' . number_format($pexp[1]) . '</strong></td>';
} 
if(is_numeric($s3)){
	echo '<tr class="dark"><td style="width: 30px; text-align: center;"><input type="radio" name="teamPokemon" id="teamPokemon" value="2"/></td><td style="height: 70px; text-align: center; white-space: nowrap;"><img src="html/static/images/pokemon/' . $pname[2] . '.gif" /><br /><strong> <a href="/pokedex.php?pid=' . $pid[2] . '" onclick="pokedexTab(\'pid=' . $pid[2] . '\', 1); return false;">' . $pname[2] . '</a><br />Level: </strong>' . $plvl[2] . '<br /><strong>Exp: </strong>' . number_format($pexp[2]) . '</strong></td>';
} 
if(is_numeric($s4)){
	echo '<tr class="dark"><td style="width: 30px; text-align: center;"><input type="radio" name="teamPokemon" id="teamPokemon" value="3"/></td><td style="height: 70px; text-align: center; white-space: nowrap;"><img src="html/static/images/pokemon/' . $pname[3] . '.gif" /><br /><strong> <a href="/pokedex.php?pid=' . $pid[3] . '" onclick="pokedexTab(\'pid=' . $pid[3] . '\', 1); return false;">' . $pname[3] . '</a><br />Level: </strong>' . $plvl[3] . '<br /><strong>Exp: </strong>' . number_format($pexp[3]) . '</strong></td>';
} 
if(is_numeric($s5)){
	echo '<tr class="dark"><td style="width: 30px; text-align: center;"><input type="radio" name="teamPokemon" id="teamPokemon" value="4"/></td><td style="height: 70px; text-align: center; white-space: nowrap;"><img src="html/static/images/pokemon/' . $pname[4] . '.gif" /><br /><strong> <a href="/pokedex.php?pid=' . $pid[4] . '" onclick="pokedexTab(\'pid=' . $pid[4] . '\', 1); return false;">' . $pname[4] . '</a><br />Level: </strong>' . $plvl[4] . '<br /><strong>Exp: </strong>' . number_format($pexp[4]) . '</strong></td>';
} 
if(is_numeric($s6)){
	echo '<tr class="dark"><td style="width: 30px; text-align: center;"><input type="radio" name="teamPokemon" id="teamPokemon" value="5"/></td><td style="height: 70px; text-align: center; white-space: nowrap;"><img src="html/static/images/pokemon/' . $pname[5] . '.gif" /><br /><strong> <a href="/pokedex.php?pid=' . $pid[5] . '" onclick="pokedexTab(\'pid=' . $pid[5] . '\', 1); return false;">' . $pname[5] . '</a><br />Level: </strong>' . $plvl[5] . '<br /><strong>Exp: </strong>' . number_format($pexp[5]) . '</strong></td>';
} 
echo '
</table></div>
</td></tr></table></form><br/><br/>';
include('disclaimer.php');
echo '</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>';
include('pv_disconnect_from_db.php');
?>