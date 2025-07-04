<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
$time = time();
function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}
$r = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
$re = mysql_fetch_array($r);
$a = $re['s1'];$b = $re['s2'];$c = $re['s3'];$d = $re['s4'];$e = $re['s5'];$f = $re['s6'];
switch($_REQUEST['action']){
	case "rebuild":
	mysql_query("UPDATE members SET s1 = '$a', s2 = '$b', s3 = '$c', s4 = '$d', s5 = '$e', s6 = '$f' WHERE id = '{$_SESSION['myid']}'");
	break;
	case "move_down":
	$fall = $_REQUEST['id'];
	if($fall == 1 && $b){
		$sv = "s1";$sv2 = "s2";$vv = $b;$vv2 = $a;
		$_SESSION['my_team'][0] = $b;
		$_SESSION['my_team'][1] = $a;
	}
	if($fall == 2 && $c){
		$sv = "s2";$sv2 = "s3";$vv = $c;$vv2 = $b;
		$_SESSION['my_team'][1] = $c;
		$_SESSION['my_team'][2] = $b;
	}
	if($fall == 3 && $d){
		$sv = "s3";$sv2 = "s4";$vv = $d;$vv2 = $c;
		$_SESSION['my_team'][2] = $d;
		$_SESSION['my_team'][3] = $c;
	}
	if($fall == 4 && $e){
		$sv = "s4";$sv2 = "s5";$vv = $e;$vv2 = $d;
		$_SESSION['my_team'][3] = $e;
		$_SESSION['my_team'][4] = $d;
	}
	if($fall == 5 && $f){
		$sv = "s5";$sv2 = "s6";$vv = $f;$vv2 = $e;
		$_SESSION['my_team'][4] = $f;
		$_SESSION['my_team'][5] = $e;
	}
	mysql_query("UPDATE members SET $sv = '$vv', $sv2 = '$vv2' WHERE id = '{$_SESSION['myid']}'");
	break;
	case "move_up":
	$jump = $_REQUEST['id'];
	if($jump == 2 && $a){
		$ev = "s1";$ev2 = "s2";$rv = $b;$rv2 = $a;
		$_SESSION['my_team'][0] = $b;
		$_SESSION['my_team'][1] = $a;
	}
	if($jump == 3 && $b){
		$ev = "s2";$ev2 = "s3";$rv = $c;$rv2 = $b;
		$_SESSION['my_team'][1] = $c;
		$_SESSION['my_team'][2] = $b;
	}
	if($jump == 4 && $c){
		$ev = "s3";$ev2 = "s4";$rv = $d;$rv2 = $c;
		$_SESSION['my_team'][2] = $d;
		$_SESSION['my_team'][3] = $c;
	}
	if($jump == 5 && $d){
		$ev = "s4";$ev2 = "s5";$rv = $e;$rv2 = $d;
		$_SESSION['my_team'][3] = $e;
		$_SESSION['my_team'][4] = $d;
	}
	if($jump == 6 && $e){
		$ev = "s5";$ev2 = "s6";$rv = $f;$rv2 = $e;
		$_SESSION['my_team'][4] = $f;
		$_SESSION['my_team'][5] = $e;
	}
	mysql_query("UPDATE members SET $ev = '$rv', $ev2 = '$rv2' WHERE id = '{$_SESSION['myid']}'");
	break;
}
if(!$_REQUEST['ajax']){
	mysql_query("UPDATE online SET activity = 'Viewing their team' WHERE id = '{$_SESSION['myid']}'");
	echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>';
if($_SESSION['layout'] == '1'){
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/blue/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/blue/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/red/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '2'){
echo '<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/game.css?1" media="screen" />';
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
<title>Pok&eacute;mon Vortex v3 - Modify Your Team</title>
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
<h1><a href="index"><em>PokemonVortex.com</em></a></h1>
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
} 
echo '<h2>Your Pok&eacute;mon Team</h2>
<p class="optionsList autowidth"><strong>Options:</strong> <a href="change_team.php" class="deselected">Change the Pok&eacute;mon in your team</a></p> <div class="list autowidth" style="margin: 10px auto;"><table cellpadding="5" cellspacing="0">
<tr>
<th>Pok&eacute;mon</th>
<th style="width: 50px;">Level</th>
<th style="width: 70px;">Exp</th>
<th style="width: 100px;">Attacks</th>
<th style="width: 110px;">Actions</th>
</tr>';
$r = mysql_query("SELECT s1, s2, s3, s4, s5, s6 FROM members WHERE id = '{$_SESSION['myid']}'");
$re = mysql_fetch_array($r);
$a = $re['s1'];$b = $re['s2'];$c = $re['s3'];$d = $re['s4'];$e = $re['s5'];$f = $re['s6'];
if($a && !$b){
	$t = mysql_query("SELECT name, lvl, a1, a2, a3, a4, exp FROM pokemon WHERE id IN($a) ORDER BY FIELD(id,$a)");
}
if($b && !$c){
	$t = mysql_query("SELECT name, lvl, a1, a2, a3, a4, exp FROM pokemon WHERE id IN($a,$b) ORDER BY FIELD(id,$a,$b)");
}
if($c && !$d){
	$t = mysql_query("SELECT name, lvl, a1, a2, a3, a4, exp FROM pokemon WHERE id IN($a,$b,$c) ORDER BY FIELD(id,$a,$b,$c)");
}
if($d && !$e){
	$t = mysql_query("SELECT name, lvl, a1, a2, a3, a4, exp FROM pokemon WHERE id IN($a,$b,$c,$d) ORDER BY FIELD(id,$a,$b,$c,$d)");
}
if($e && !$f){
	$t = mysql_query("SELECT name, lvl, a1, a2, a3, a4, exp FROM pokemon WHERE id IN($a,$b,$c,$d,$e) ORDER BY FIELD(id,$a,$b,$c,$d,$e)");
}
if($f){
	$t = mysql_query("SELECT name, lvl, a1, a2, a3, a4, exp FROM pokemon WHERE id IN($a,$b,$c,$d,$e,$f) ORDER BY FIELD(id,$a,$b,$c,$d,$e,$f)");
}

while($goo = mysql_fetch_assoc($t)){
	$pname[] = $goo['name'];
	$plvl[] = $goo['lvl'];
	$pa1[] = $goo['a1'];
	$pa2[] = $goo['a2'];
	$pa3[] = $goo['a3'];
	$pa4[] = $goo['a4'];
	$pexp[] = $goo['exp'];
}
$abc = array("a","b","c","d","e","f");
for($i=0;$i<6;$i++){
	$lete = ${$abc[$i]};
	if(is_numeric($lete)){
		if(checkNum($number) === TRUE){
			$edit = 'dark';
		}
		else {
			$edit = 'light';
		}
		
		echo '<tr class="' . $edit . '"><td style="height: 70px; text-align: left;"><img src="http://static.pokemon-vortex.com/images/pokemon/' . $pname[$i] . '.gif" /><strong><a href="/pokedex?pid=' . $lete . '" onclick="pokedexTab(\'pid=' . $lete . '\', 1); return false;">' . $pname[$i] . '</a></strong></td><td style="width: 50px; height: 70px;">' . $plvl[$i] . '</td><td style="width: 70px; height: 70px;">' . number_format($pexp[$i]) . '</td><td style="width: 100px; height: 70px;">' . $pa1[$i] . '<br />' . $pa2[$i] . '<br />' . $pa3[$i] . '<br />' . $pa4[$i] . '</td><td style="width: 110px; height: 70px;"><a href="change_attacks.php?pid=' . $lete . '">Change Attacks</a><br /><a href="evolve.php?pid=' . $lete . '">Evolve</a><br />';
		
		$y = $i + 1;
		$r = $i - 1;
		$leto = ${$abc[$r]};
		$letr = ${$abc[$y]};
		if(is_numeric($leto)){
			echo '<a href="your_team?action=move_up&id=' . $y . '" onclick="get(\'your_team.php\',\'action=move_up&id=' . $y . '\'); return false;">&uarr; Move Up</a><br />';
		}
		else{
			echo '<s>&uarr; Move Up</s><br />';
		}
		if(is_numeric($letr)){
			echo '<a href="your_team?action=move_down&id=' . $y .'" onclick="get(\'your_team.php\',\'action=move_down&id=' . $y . '\'); return false;">&darr; Move Down</a>';
		}
		else {
			echo "<s>&darr; Move Down</s>";
		}
		echo '</td></tr>';
	}
	else{
		break;
	}
}
echo '</table></div>
<p><strong><em>If your team is displaying incorrectly, <a href="your_team.php?action=rebuild">click here</a> to rebuild it.</em></strong></p>';
if(!$_REQUEST['ajax']){
	echo '';
	include('disclaimer.php');
	echo '
	</div>
	</div>
	</div>
	</div>
	</div>
	</body>
	<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/gameInit.js"></script>
	</html>';
}
include('pv_disconnect_from_db.php'); ?>