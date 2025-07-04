<?php
$starttime = microtime(true);
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
else{
	include('pv_connect_to_db.php');
	$time = time();
	
	function checkNum($number){
		return ($number%2) ? TRUE : FALSE;
	}
	if(isset($_POST['pc'])){
		$ui = $_POST['pagenum'];
		header("location: your_pokemon.php");
	}
	
	if(!$_REQUEST['ajax']){
		mysql_query("UPDATE online SET activity = 'Viewing all their Pokemon' WHERE id = '{$_SESSION['myid']}'");
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
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
if($_SESSION['layout'] == '2'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
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
<title>Pok&eacute;mon Shqipe v3 - Your Pok&eacute;mon</title>
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
<?php// include('includes/usernav.php'); ?>
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
<div id="ajax">
<?php } ?>
<h2>Your Pok&eacute;mon</h2>
<p class="optionsList autowidth"><strong>View:</strong> <a href="/your_pokemon.php" onclick="get('your_pokemon.php',''); return false;" class="<? if($_REQUEST['cat']){ echo "de"; } ?>selected">All Your Pok&eacute;mon</a> | <a href="/your_pokemon.php?cat=normal" onclick="get('your_pokemon.php','cat=normal'); return false;" class="<? if($_REQUEST['cat'] == "normal"){ echo "selected"; } else { echo "deselected"; }?>">Normal</a> | <a href="/your_pokemon.php?cat=metallic" onclick="get('your_pokemon.php','cat=metallic'); return false;" class="<? if($_REQUEST['cat'] == "metallic"){ echo "selected"; } else { echo "deselected"; }?>">Metallic</a> | <a href="/your_pokemon.php?cat=shadow" onclick="get('your_pokemon.php','cat=shadow'); return false;" class="<? if($_REQUEST['cat'] == "shadow"){ echo "selected"; } else { echo "deselected"; }?>">Shadow</a> | <a href="/your_pokemon.php?cat=shiny" onclick="get('your_pokemon.php','cat=shiny'); return false;" class="<? if($_REQUEST['cat'] == "shiny"){ echo "selected"; } else { echo "deselected"; }?>">Shiny</a> | <a href="/your_pokemon.php?cat=dark" onclick="get('your_pokemon.php','cat=dark'); return false;" class="<? if($_REQUEST['cat'] == "dark"){ echo "selected"; } else { echo "deselected"; }?>">Dark</a> | <a href="/your_pokemon.php?cat=mystic" onclick="get('your_pokemon.php','cat=mystic'); return false;" class="<? if($_REQUEST['cat'] == "mystic"){ echo "selected"; } else { echo "deselected"; }?>">Mystic</a></p><form id="pokemonSearch" name="pokemonSearch" action="/your_pokemon.php" method="post"><p><strong>Search:</strong> <input type="text" name="pokemon_name" id="pokemon_name" value="" size="30" maxlength="40" accesskey="n" autocomplete="off" onfocus="suggest('pokemonName', 'pokemon', 1);" onblur="hideSuggest(0);" onkeydown="suggestionJump(event, 'pokemonSearch');" /> <input type="hidden" name="search" value="1" /><input name="t" id="t" type="submit" value="Search" /></p></form>
<?php
if(isset($_POST['t'])){
	$search = 2;
	
	$_POST['pokemon_name'] = mysql_real_escape_string($_POST['pokemon_name']);
	$extra = " AND name LIKE '%{$_POST['pokemon_name']}%'";
}
else {
	if(!isset($_REQUEST['cat'])){
		$_REQUEST['cat'] = 1;
	}
	if($_REQUEST['cat'] != "shiny" && $_REQUEST['cat'] != "normal" && $_REQUEST['cat'] != "dark" && $_REQUEST['cat'] != "mystic" && $_REQUEST['cat'] != "metallic" && $_REQUEST['cat'] != "shadow"){
		$extra = "";
	}
	if($_REQUEST['cat'] == "shiny"){
		$extra = " AND name LIKE 'Shiny %'";
		$req = "&cat=shiny";
	}
	if($_REQUEST['cat'] == "normal"){
		$extra = " AND name NOT LIKE 'Dark %' AND name NOT LIKE 'Shiny %' AND name NOT LIKE 'Mystic %' AND name NOT LIKE 'Shadow %' AND name NOT LIKE 'Metallic %'";
		$req = "&cat=normal";
	}
	if($_REQUEST['cat'] == "dark"){
		$extra = " AND name LIKE 'Dark %'";
		$req = "&cat=dark";
	}
	if($_REQUEST['cat'] == "metallic"){
		$extra = " AND name LIKE 'Metallic %'";
		$req = "&cat=metallic";
	}
	if($_REQUEST['cat'] == "mystic"){
		$extra = " AND name LIKE 'Mystic %'";
		$req = "&cat=mystic";
	}
	if($_REQUEST['cat'] == "shadow"){
		$extra = " AND name LIKE 'Shadow %'";
		$req = "&cat=shadow";
	}
}
if($_REQUEST['order'] != "exp"){
	$ordervar = "ORDER BY name ASC";
}
else {
	$ordervar = "ORDER BY exp DESC";
	$req2 = "&order=exp";
}
$tbl_name = "pokemon";
$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE owner = '{$_SESSION['myid']}'$extra $ordervar";
	$total_pages = mysql_fetch_assoc(mysql_query($query));
	$total_pages = $total_pages['num'];
	
	/* Setup vars for query. */
	$targetpage = "your_pokemon.php"; 	//your file name  (the name of this file)
	$limit = 10; 								//how many items to show per page
	if(is_numeric($_REQUEST['page'])){	
	$page = $_REQUEST['page'];		
	}
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT name, pid, id, a1, a2, a3, a4, lvl, exp FROM $tbl_name WHERE owner = '{$_SESSION['myid']}'$extra $ordervar LIMIT $start, $limit";
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<p class=\"optionsList autowidth\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev$req$req2\" onclick=\"get('your_pokemon.php','page=$prev$req$req2'); return false;\" class=\"deselected\">&laquo; Previous</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">&laquo; Previous</a>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter$req$req2\" onclick=\"get('your_pokemon.php','page=$counter$req$req2'); return false;\" class=\"deselected\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$req$req2\" onclick=\"get('your_pokemon.php','page=$counter$req$req2'); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$req$req2\" onclick=\"get('your_pokemon.php','page=$lpm1$req$req2'); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage$req$req2\" onclick=\"get('your_pokemon.php','page=$lastpage$req$req2'); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1$req$req2\" onclick=\"get('your_pokemon.php','page=1$req$req2'); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2$req$req2\" onclick=\"get('your_pokemon.php','page=1$req$req2'); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$req$req2\" onclick=\"get('your_pokemon.php','page=$counter$req$req2'); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$req$req2\" onclick=\"get('your_pokemon.php','page=$lpm1$req$req2'); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage$req$req2\" onclick=\"get('your_pokemon.php','page=$lastpage$req$req2'); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1$req$req2\" onclick=\"get('your_pokemon.php','page=1$req$req2'); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2$req$req2\" onclick=\"get('your_pokemon.php','page=1$req$req2'); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$req$req2\" onclick=\"get('your_pokemon.php','page=$counter$req$req2'); return false;\" class=\"deselected\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next$req$req2\" onclick=\"get('your_pokemon.php','page=$next$req$req2'); return false;\" class=\"deselected\">Next &raquo;</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">Next &raquo;</a>";
		$pagination.= "</p>\n";		
	}
?>
<div class="list autowidth" style="margin: 10px auto;"><table cellpadding="5" cellspacing="0">
<tr>
<th>
<strong>
<?php 
if(!isset($_REQUEST['order'])){
	$_REQUEST['order'] = 1;
}
if($_REQUEST['order'] == "exp" && $_REQUEST['cat'] != "shiny" && $_REQUEST['cat'] != "normal" && $_REQUEST['cat'] != "dark" && $_REQUEST['cat'] != "mystic" && $_REQUEST['cat'] != "metallic" && $_REQUEST['cat'] != "shadow"){ ?><a href="your_pokemon.php"><? } ?><? if($_REQUEST['order'] == "exp" && $_REQUEST['cat'] == "normal"){ ?><a href="your_pokemon.php?cat=normal"><? } if($_REQUEST['order'] == "exp" && $_REQUEST['cat'] == "dark"){ ?><a href="your_pokemon.php?cat=dark"><? } if($_REQUEST['order'] == "exp" && $_REQUEST['cat'] == "shiny"){ ?><a href="your_pokemon.php?cat=shiny"><? } if($_REQUEST['order'] == "exp" && $_REQUEST['cat'] == "mystic"){ ?><a href="your_pokemon.php?cat=mystic"><? } if($_REQUEST['order'] == "exp" && $_REQUEST['cat'] == "metallic"){ ?><a href="your_pokemon.php?cat=metallic"><? } if($_REQUEST['order'] == "exp" && $_REQUEST['cat'] == "shadow"){ ?><a href="your_pokemon.php?cat=shadow"><? } ?>Pok&eacute;mon<? if($_REQUEST['order'] == "exp"){ ?> / Normal View</a><? } ?></strong>
</th>
<th style="width: 50px;">Level</th>
<th style="width: 70px;">
<?php
if($_REQUEST['order'] == "exp" || isset($_POST['t'])){
	?>
    <strong>Exp</strong>
	<?php
}
else {
	?>
    <a href="/your_pokemon.php?order=exp<? if($_REQUEST['cat']){ echo "&cat={$_REQUEST['cat']}"; } ?>" onclick="get('your_pokemon.php','order=exp<? if($_REQUEST['cat']){ echo "&cat={$_REQUEST['cat']}"; } ?>'); return false;">Exp</a><? } ?></th>
    <th style="width: 100px;">Attacks</th>
    <th style="width: 110px;">Actions</th>
    </tr>
	<?php
	while($row = mysql_fetch_array($result)){
		$i = 1;
		$number += $i;
		?>
        
        <tr class="<? if(checkNum($number) === TRUE){
			echo 'dark';
		}
		else{
			echo 'light';
		}
		?>">
        
        <td style="height: 70px; text-align: left; vertical-align: middle;">
        <img src="html/static/images/pokemon/<? echo $row['name']; ?>.gif" />
        <strong>
        <a href="pokedex.php?pid=<? echo $row['id']; ?>" onclick="pokedexTab('pid=<? echo $row['id']; ?>', 1); return false;">
		<? echo $row['name']; ?>
        </a>
        </strong>
        </td>
        <td style="width: 50px; height: 70px;">
		<? echo $row['lvl']; ?>
        </td>
        <td style="width: 70px; height: 70px;">
		<? echo number_format($row['exp']); ?>
        </td>
        <td style="width: 100px; height: 70px;">
		<? echo $row['a1']; ?>
        <br />
		<? echo $row['a2']; ?>
        <br />
		<? echo $row['a3']; ?>
        <br />
		<? echo $row['a4']; ?>
        </td>
        <td style="width: 110px; height: 70px;">
        <a href="/evolve.php?pid=<? echo mysql_real_escape_string($row['id']); ?>">
        Evolve
        </a>
        <br />
        <a href="/change_attacks.php?pid=<? echo mysql_real_escape_string($row['id']); ?>">
        Change Attacks
        </a>
        <br />
        <a href="/put_up_for_trade.php?pid=<? echo mysql_real_escape_string($row['id']); ?>">
        Trade
        </a>
        <br />
        <a href="/release.php?pid=<? echo mysql_real_escape_string($row['id']); ?>">
        Release
        </a>
        </td>
        </tr><?php
	} ?>
    
    </table><? if($total_pages == 0){
		?>
        <div class="errorMsg">You do not currently own any of the selected pok&eacute;mon.</div>
		<?php
	}
	?>
    </div>
	<?=$pagination?>
    <br/>
    <br/>
	<?php
    if(!$_REQUEST['ajax']){
		
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
        <?php
	}
}
$endtime = microtime(true);
$duration = $endtime - $starttime;
echo 'This page took ' . $duration . ' seconds to load.';
include('pv_disconnect_from_db.php'); ?>