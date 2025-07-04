<?php
include('kick.php');
if(!isset($_SESSION['myid']) || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
  <script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
  <script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
  <?php
  if($_SESSION['layout'] == '1'){
	  echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />
	  <link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
  }
  elseif($_SESSION['layout'] == '0'){
	  echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />
	  <link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
  }
  elseif($_SESSION['layout'] == '2'){
	  echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
	  <link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
  }
  ?>
  <!--[if lt IE 7]>
      <script type="text/javascript" language="javascript" src="html/static/js//v3/ie6-.js"></script>
      <link rel="stylesheet" type="text/css" href="html/static/css/ie6-.css" media="screen" />
  <![endif]-->
  <!--[if gte IE 7]>
      <script type="text/javascript" language="javascript" src="html/static/js//v3/ie7+.js"></script>
      <link rel="stylesheet" type="text/css" href="html/static/css/ie7+.css" media="screen" />
  <![endif]-->
  <noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon" /> 
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <title>Pok&eacute;mon shqipe v3 - <?=$_REQUEST['pokemon'];?> - Pok&eacute;dex</title>
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
<div id="title"><h1><a href="index.php"><em>pokemon-shqipe.co.uk</em></a></h1></div>
<ul id="nav"><li><a href="map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li>
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
<div id="sidebarContainer"><div id="sidebarLoading"></div><div id="sidebarContent"></div></div>
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


<?php
// Protect the request

$pokemon = mysql_real_escape_string($_REQUEST['pokemon']);

// Make sure a Pokemon is chosen to display

if(!$pokemon){
	echo '<center><h2>Please choose a Pok&eacute;mon to get a detailed analysis.</h2></center><br />';
}
else{
	$get_normal_pogey = mysql_query("SELECT * FROM pguide WHERE name = '{$pokemon}'");
	$get_normal_pokemon = mysql_fetch_array($get_normal_pogey);
	
	// Make sure the Pokemon name is valid
	
	if(!$get_normal_pokemon['name']){
		echo '<center><h2>Invalid Pok&eacute;mon, please choose another.</h2></center>';
	}
	else{
		$get_shiny_pogey = mysql_query("SELECT amount FROM pguide WHERE name = 'Shiny {$pokemon}'");
		$get_shiny_pokemon = mysql_fetch_array($get_shiny_pogey);
		
		// Make sure variant Pokemon can't be shown and cause page errors
		
		if(!$get_shiny_pokemon){
			echo '<center><h2>Invalid Pok&eacute;mon, please choose another.</h2></center>';
		}
		else{
			mysql_query("UPDATE online SET activity = 'Viewing {$pokemon}\'\s Pok�dex entry' WHERE id = '{$_SESSION['myid']}'");
			$get_metallic_pogey = mysql_query("SELECT amount FROM pguide WHERE name = 'Metallic {$pokemon}'");
			$get_metallic_pokemon = mysql_fetch_array($get_metallic_pogey);
			
			$get_mystic_pogey = mysql_query("SELECT amount FROM pguide WHERE name = 'Mystic {$pokemon}'");
			$get_mystic_pokemon = mysql_fetch_array($get_mystic_pogey);
			
			$get_dark_pogey = mysql_query("SELECT amount FROM pguide WHERE name = 'Dark {$pokemon}'");
			$get_dark_pokemon = mysql_fetch_array($get_dark_pogey);
			
			$get_shadow_pogey = mysql_query("SELECT amount FROM pguide WHERE name = 'Shadow {$pokemon}'");
			$get_shadow_pokemon = mysql_fetch_array($get_shadow_pogey);
			
			// Display basic Pokemon info. Name, image, number, types, quantity owned.	
			
			echo '<center><h2>#' . $get_normal_pokemon['dex_num'] . ' ' . $get_normal_pokemon['name'] . '</h2><br/><img src="html/static/images/pokemon/' . $get_normal_pokemon['name'] . '.gif"><br />
			<img src="html/static/images/types/' . $get_normal_pokemon['type1'] . '.gif">';
			
			// Check if the Pokemon has two types to display
			
			if(!$get_normal_pokemon['type2'] == ''){
				echo '<br /><img src="html/static/images/types/' . $get_normal_pokemon['type2'] . '.gif">';
			}
			
			echo '<p>There are currently ' . number_format($get_normal_pokemon['amount']) . ' Normal ' . $get_normal_pokemon['name'] . '(s) in Shqipe<p>';
			
			// Display catch locations
			
			echo '<h5>Location:</h5> <a href="http://forums.pokemon-shqipe.co.uk/index.php/topic/299-pok%C3%A9mon-location-guide-v3/#' . $get_normal_pokemon['name'] . '" target="_BLANK">Click Here</a>';
			
			// Display variants and quantity owned of each
			
			echo'<h5>Other Variants:</h5>
			<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000;">
			<tr>
			<td style="border: 1px solid #000000; text-align: center;"><b>Metallic</b></td><td style="border: 1px solid #000000; text-align: center;"><b>Dark</b></td>
			</tr>
			<tr>
			<td style="border: 1px solid #000000; height: 100px; width: 192px; text-align: center;"><img src="html/static/images/pokemon/Metallic ' . $get_normal_pokemon['name'] . '.gif" /><br /><sup>' . number_format($get_metallic_pokemon['amount']) . ' in Shqipe</sup></td><td style="border: 1px solid #000000; height: 100px; width: 192px; text-align: center;"><img src="html/static/images/pokemon/Dark ' . $get_normal_pokemon['name'] . '.gif" /><br /><sup>' . number_format($get_dark_pokemon['amount']) . ' in Shqipe</sup></td>
			</tr>
			<tr>
			<td style="border: 1px solid #000000; text-align: center;"><b>Mystic</b></td><td style="border: 1px solid #000000; text-align: center;"><b>Shiny</b></td>
			</tr>
			<tr>
			<td style="border: 1px solid #000000; height: 100px; width: 192px; text-align: center;"><img src="html/static/images/pokemon/Mystic ' . $get_normal_pokemon['name'] . '.gif" /><br /><sup>' . number_format($get_mystic_pokemon['amount']) . ' in Shqipe</sup></td><td style="border: 1px solid #000000; height: 100px; width: 192px; text-align: center;"><img src="html/static/images/pokemon/Shiny ' . $get_normal_pokemon['name'] . '.gif" /><br /><sup>' . number_format($get_shiny_pokemon['amount']) . ' in Shqipe</sup></td>
			</tr>
			</table>
			<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000; margin-left: 0px; margin-top: -1px;">
			<tr>
			<td style="border: 1px solid #000000; text-align: center;"><b>Shadow</b></td>
			</tr>
			<tr>
			<td style="border: 1px solid #000000; width: 192px; height: 100px;  text-align: center;"><img src="html/static/images/pokemon/Shadow ' . $get_normal_pokemon['name'] . '.gif" /><br /><sup>' . number_format($get_shadow_pokemon['amount']) . ' in Shqipe</sup></td>
			</tr>
			</table>';
			
			// Display evolutions and evolution requirements
			
			echo'<h5>Evolutions & Evolution Method:</h5>';
			
			// No evolution
			
			if($get_normal_pokemon['ep'] == '0'){
				echo 'This Pok&eacute;mon does not evolve';
			}
			
			// One evolution
			
			if(!$get_normal_pokemon['ep'] == '0' && $get_normal_pokemon['ep2'] == '0'){
				echo '<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep'] . '.gif"></td>
				</tr></table>';
			}
			
			// Two evolutions
			
			if(!$get_normal_pokemon['ep2'] == '0' && $get_normal_pokemon['ep3'] == '0'){
				echo '<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev2'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep2'] . '.gif" /></td>
				</tr></table>';
			}
			
			// Three evolutions
			
			if(!$get_normal_pokemon['ep3'] == '0' && $get_normal_pokemon['ep4'] == '0'){
				echo '<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev2'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev3'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep2'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep3'] . '.gif" /></td>
				</tr></table>';
			}
			
			// Eight evolutions
			
			if(!$get_normal_pokemon['ep8'] == '0' && $get_normal_pokemon['ep8'] == 'Sylveon'){
				echo '<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev2'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev3'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev4'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep2'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep3'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep4'] . '.gif" /></td>
				</tr></table>
				<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000; margin-left: 0px; margin-top: -1px;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev5'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev6'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev7'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>' . $get_normal_pokemon['ev8'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep5'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep6'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep7'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep8'] . '.gif" /></td>
				</tr></table>';
			}
			
			// Twenty Evolutions
			
						if(!$get_normal_pokemon['ep20'] == '0'){
				echo '<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev2'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev2'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev3'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev3'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev4'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev4'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev5'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev5'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep2'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep3'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep4'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep5'] . '.gif" /></td>
				</tr></table>
				<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000; margin-left: 0px; margin-top: -1px;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev6'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev6'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev7'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev7'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev8'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev8'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev9'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev9'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev10'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev10'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep6'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep7'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep8'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep9'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep10'] . '.gif" /></td>
				</tr></table>
				<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000; margin-left: 0px; margin-top: -1px;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev11'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev11'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev12'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev12'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev13'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev13'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev14'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev14'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev15'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev15'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep11'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep12'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep13'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep14'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep15'] . '.gif" /></td>
				</tr></table>
				<table cellspacing="1" cellpadding="1" style="border: 1px solid #000000; margin-left: 0px; margin-top: -1px;">
				<tr>
				<td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev16'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev16'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev17'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev17'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev18'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev18'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev19'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev19'] . '</b></td><td style="border: 1px solid #000000; text-align: center;"><b>'; if(is_numeric($get_normal_pokemon['ev20'])){ echo 'Level: '; } echo'' . $get_normal_pokemon['ev20'] . '</b></td>
				</tr>
				<tr>
				<td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep16'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep17'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep18'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="http://static./images/pokemon/' . $get_normal_pokemon['ep19'] . '.gif" /></td><td style="border: 1px solid #000000; height: 96px; width: 96px;"><img src="html/static/images/pokemon/' . $get_normal_pokemon['ep20'] . '.gif" /></td>
				</tr></table>';
			}
			
			echo '<h5>Base Attacks:</h5>' . $get_normal_pokemon['a1'] . '<br/>' . $get_normal_pokemon['a2'] . '<br/>' . $get_normal_pokemon['a3'] . '<br/>' . $get_normal_pokemon['a4'] . '</center><p />';
		}
	}
}
?>

</div>
<?php include('disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php include('pv_disconnect_from_db.php'); ?>