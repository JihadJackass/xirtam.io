<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
$_REQUEST['uid'] = mysql_real_escape_string($_REQUEST['uid']);
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
<title>Pok&eacute;mon Shqipe Battle Arena v3 - Members</title>
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
<li><a href="/pokedex.php" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
<li><a href="//members.php" id="membersTab" class="deselected"><em>Members</em></a></li>
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

<style>
td{
	valign: middle;
}
#mine{
	margin-left:15px;
}
</style>
<?php

function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}
if($_REQUEST['view'] && !$_REQUEST['uid']){
?>
<div id="notification" style="visibility: hidden;"></div>
<div id="loading"></div>
<div id="suggestResults"></div>
<div id="showDetails"></div>
<div id="errorBox"></div>
<div id="ajax">
<h3 style="text-align: center;">Members</h3>
<p class="optionsList" style="text-align: center;"><a href="//members.php?view=online_friends" onclick="membersTab('view=online_friends', 0); return false;" class="<? if($_REQUEST['view'] == "online_friends"){ echo "selected"; } else { echo "deselected"; } ?>">Friends Online</a> | <a href="//members.php?view=friends_list" onclick="membersTab('view=friends_list', 0); return false;" <? if($_REQUEST['view'] == "friends_list"){ ?>class="selected"<? } else { ?>class="deselected"<? } ?>>Friends List</a> | <a href="//members.php?view=ignore_list" onclick="membersTab('view=ignore_list', 0); return false;" class="<? if($_REQUEST['view'] == "ignore_list"){ echo "selected"; } else { echo "deselected"; } ?>">Ignore List</a><br /><a href="//members.php?view=online" onclick="membersTab('view=online', 0); return false;" class="<? if($_REQUEST['view'] == "online"){ echo "selected"; } else { echo "deselected"; } ?>">Online Members</a> | <a href="//members.php?view=top_trainers" onclick="membersTab('view=top_trainers', 0); return false;" <? if($_REQUEST['view'] == "top_trainers"){ ?>class="selected"<? } else { ?>class="deselected"<? } ?>>Top Trainers</a></p><h3 style="text-align: center;"><? if($_REQUEST['view'] == "top_trainers"){ ?>Top Trainers<? } if($_REQUEST['view'] == "friends_list"){ ?>Friends List<? } if($_REQUEST['view'] == "online"){ ?>Online Members<? } if($_REQUEST['view'] == "ignore_list"){ ?>Ignore List<? } if($_REQUEST['view'] == "online_friends"){ ?>Friends Online<? } if($_REQUEST['view'] == "search"){ ?>Search<? }?></strong></h3>
<div class="list autowidth">
<?php
if($_REQUEST['view'] == "top_trainers"){
$_SESSION['pageview'] = "top_trainers";
?>
<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
<tr>
<th style="width:45%;"><a href="//members.php?view=top_trainers" onclick="membersTab('view=top_trainers', 0); return false;">Rank / Username / Points</a></th>
<th style="width: 25%;"><a href="//members.php?view=top_trainers&order=exp" onclick="membersTab('view=top_trainers&order=exp', 0); return false;">Total / Avg Experience</a></th>
<th style="width: 15%;"><a href="//members.php?view=top_trainers&order=battles" onclick="membersTab('view=top_trainers&order=battles', 0); return false;">Battle Count</a></th>
<th style="width: 15%;"><a href="//members.php?view=top_trainers&order=uniques" onclick="membersTab('view=top_trainers&order=uniques', 0); return false;">Unique Pok&eacute;mon</a></th>
</tr>
<?
$number = 0;



if($_REQUEST['order'] == 'battles'){
$sideright = mysql_query("SELECT id, username, points, battle, uniques, averageexp, totalexp FROM members ORDER BY battle DESC LIMIT 0,100");
}
elseif($_REQUEST['order'] == 'exp'){
$sideright = mysql_query("SELECT id, username, points, battle, uniques, averageexp, totalexp FROM members ORDER BY totalexp DESC LIMIT 0,100");
}
elseif($_REQUEST['order'] == 'uniques'){
$sideright = mysql_query("SELECT id, username, points, battle, uniques, averageexp, totalexp FROM members ORDER BY uniques DESC LIMIT 0,100");
}
else{
$sideright = mysql_query("SELECT id, username, points, battle, uniques, averageexp, totalexp FROM members ORDER BY points DESC LIMIT 0,100");
}
while($sideright1 = mysql_fetch_array($sideright)){
$i = 1;
$number += $i;
?>
<tr class="<? 
if(checkNum($number) === TRUE){
  echo 'dark';
}else{
  echo 'light';
} ?>" nowrap="nowrap"><td style="text-align: left;"><strong>
<?
echo "$number. ";
echo "<a href=\"/members.php?uid=" . $sideright1['id'] . "\" ";
?>
onclick="membersTab('uid=<? echo $sideright1['id']; ?>', 1); return false;"<? echo "title=\"" . htmlentities($sideright1['username']) . "\">" . htmlentities($sideright1['username']);

?>
</a></strong><br /><span id="mine" align="left">
<?
echo number_format($sideright1['points']);
?></span></td><td style="width: 25%;"><? 

echo number_format($sideright1['totalexp']); 
echo "<br />";
echo number_format(round($sideright1['averageexp']));

 ?>
</td><td style="width: 15%;"><? 
echo number_format($sideright1['battle']); ?></td><td style="width: 15%;">
<? 
echo number_format($sideright1['uniques']); ?></td></tr>
<?
}

?>

</table>
<?

}

if($_REQUEST['view'] == 'online'){
$_SESSION['pageview'] = "online";
?>
<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
<tr>
<th style="width:45%;">Username</th>
<th style="width:55%;">Options</th>
</tr>
<?


$time = time();
$time1 = '1800';
$timeout = $time - $time1;

	
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) FROM online";
	$total_pages = mysql_fetch_row(mysql_query($query));
	$total_pages = $total_pages[0];
	
	/* Setup vars for query. */
	$limit = 50; 
	if(is_numeric($_REQUEST['page'])){	
	$page = $_REQUEST['page'];		
	}					//how many items to show per page
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$query = "SELECT username, id FROM online ORDER BY username ASC LIMIT $start, $limit";
	$portfolio = mysql_query($query);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"/members.php?view=online&page=$prev\" onclick=\"membersTab('view=online&page=$prev', 0); return false;\" class=\"deselected\">« Previous</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">« Previous</a>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
				else
					$pagination.= "<a href=\"/members.php?view=online&page=$counter\" onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
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
						$pagination.= "<a href=\"/members.php?view=online&page=$counter\" onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"/members.php?view=online&page=$lpm1\" onclick=\"membersTab('view=online&page=$lpm1', 0); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=$lastpage\" onclick=\"membersTab('view=online&page=$lastpage', 0); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"/members.php?view=online&page=1\" onclick=\"membersTab('view=online&page=`', 0); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=2\" onclick=\"membersTab('view=online&page=2', 0); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"/members.php?view=online&page=$counter\"onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"/members.php?view=online&page=$lpm1\" onclick=\"membersTab('view=online&page=$lpm1', 0); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=$lastpage\" onclick=\"membersTab('view=online&page=$lastpage', 0); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"/members.php?view=online&page=1\" onclick=\"membersTab('view=online&page=1', 0); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=2\" onclick=\"membersTab('view=online&page=2', 0); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"/members.php?view=online&view=online&page=$counter\"onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"/members.php?view=online&page=$next\" onclick=\"membersTab('view=online&page=$next', 0); return false;\" class=\"deselected\">Next »</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">Next »</a>";
		$pagination.= "\n";		
	}
?>

	<?php
		while($item = mysql_fetch_array($portfolio))
		{
$i = 1;
$number += $i;
?>


<tr class="<? if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>" nowrap="nowrap">
<td style="text-align: left;"><strong>
<? echo "<a href=\"/members.php?uid=" . $item['id'] . "\" "; ?>onclick="membersTab('uid=<? echo $item['id']; ?>', 1); return false;"<? echo "title=\"" . htmlentities($item['username']) . "\">" . htmlentities($item['username']);
?>
</a></strong></td><td style="width: 25%;"><a href="/battle.php?bid=<? echo $item['id'];?>">Battle</a> | <a href="messages.php?rid=<? echo $item['id']; ?>">Message</a> | <a href="trade.php?type=Username&search=<? echo $item['username']; ?>&page=1">View Trades</a>
</td></tr>
<?
		}
	?></table></div>
<br>
<p class="optionsList autowidth">
<?=$pagination?></p>

<?

}

if($_REQUEST['view'] == 'friends_list'){
$_SESSION['pageview'] = "friends_list";
?>
<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
<tr>
<th style="width:40%;">Username</th>
<th style="width:60%;">Options</th>
</tr>
<?
if(is_numeric($_REQUEST['remove'])){
mysql_query("DELETE FROM friends WHERE uid = '{$_SESSION['myid']}' AND fid = '{$_REQUEST['remove']}'");
} 
$friend = mysql_query("SELECT * FROM friends WHERE uid = '{$_SESSION['myid']}' ORDER BY fname ASC");
$check = mysql_num_rows($friend);
if($check < 1){
echo "<tr><td><center>No friends found.</center></td></tr>";
}
else {
while($friends = mysql_fetch_array($friend)){ $i = 1; $number += $i; ?>
<tr class="<? if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>" nowrap="nowrap"><td style="text-align: left;"><strong>
<a href="/members.php?uid=<? echo $friends['fid']; ?>" onclick="membersTab('uid=<? echo $friends['fid']; ?>', 1); return false;" title="<? echo htmlentities($friends['fname']); ?>"><? echo htmlentities($friends['fname']); ?>
</a></strong></td><td style="width: 25%;">
<a href="battle.php?bid=<? echo $friends['fid']; ?>">Battle</a> | <a href="messages.php?rid=<? echo $friends['fid']; ?>">Message</a> | <a href="trade.php?type=Username&search=<? echo $friends['fname']; ?>&page=1">View Trades</a> | <a href="/members.php?view=friends_list&remove=<? echo $friends['fid']; ?>" onclick="membersTab('view=friends_list&remove=<? echo $friends['fid']; ?>', 1); return false;">Remove</a>
</td></tr>
<? }}
echo "</table>";
}

if($_REQUEST['view'] == 'online_friends'){
$_SESSION['pageview'] = "online_friends";
?>
<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
<tr>
<th style="width:40%;">Username</th>
<th style="width:60%;">Options</th>
</tr>
<?
$time = time();
$time1 = '2400';
$timeout = $time - $time1;
$friend = mysql_query("SELECT * FROM members WHERE time BETWEEN '$timeout' AND '$time'");
while($friends = mysql_fetch_array($friend)){ 
$e2 = mysql_query("SELECT * FROM friends WHERE fid = '{$friends['id']}' AND uid = '{$_SESSION['myid']}' ORDER BY fname ASC");
$e3 = mysql_fetch_array($e2);
$et = mysql_num_rows($e2);
if($et > 0){
$vau = 7;
$e4 = $e3['fid'];
$e5 = htmlentities($e3['fname']);
$i = 1; $number += $i; ?>
<tr class="<? if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>" nowrap="nowrap"><td style="text-align: left;"><strong>
<a href="/members.php?uid=<? echo $e4; ?>" onclick="membersTab('uid=<? echo $e4; ?>', 1); return false;" title="<? echo $e5;?>"><? echo $e5; ?>
</a></strong></td><td style="width: 25%;">
<a href="battle.php?bid=<? echo $e4; ?>">Battle</a> | <a href="messages.php?rid=<? echo $e4; ?>">Message</a> | <a href="trade.php?type=Username&search=<? echo $e5; ?>&page=1">View Trades</a> | <a href="/members.php?view=friends_list&remove=<? echo $e4; ?>" onclick="membersTab('view=friends_list&remove=<? echo $e4; ?>', 1); return false;">Remove</a>
</td></tr>
<? }}
if($vau != 7){ echo "<tr><td><center>No friends found.</center></td></tr>"; }
echo "</table>";
}
if($_REQUEST['view'] == 'ignore_list'){
$_SESSION['pageview'] = "ignore_list";
if(is_numeric($_REQUEST['remove'])){
mysql_query("DELETE FROM blocked WHERE uid = '{$_SESSION['myid']}' AND bid = '{$_REQUEST['remove']}'");
} 
?>
<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
<tr>
<th style="width:45%;">Username</th>
<th style="width:55%;">Options</th>
</tr>
<?
$friend = mysql_query("SELECT * FROM blocked WHERE uid = '{$_SESSION['myid']}'");
$rt = mysql_num_rows($friend);
if($rt <= 0){
echo "<tr><td><center>You currently have no members blocked.</center></td></tr>";
}
while($friends = mysql_fetch_array($friend)){ 
$i = 1; $number += $i; ?>
<tr class="<? if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>" nowrap="nowrap"><td style="text-align: left;"><strong>
<a href="/members.php?uid=<? echo $friends['bid']; ?>" onclick="membersTab('uid=<? echo $friends['bid']; ?>', 1); return false;" title="<? echo htmlentities($friends['bname']);?>"><? echo htmlentities($friends['bname']); ?>
</a></strong></td><td style="width: 25%;">
<a href="battle.php?bid=<? echo $friends['bid']; ?>">Battle</a> | <a href="/members.php?view=ignore_list&remove=<? echo $friends['bid']; ?>" onclick="membersTab('view=ignore_list&remove=<? echo $friends['bid']; ?>', 1); return false;">Remove</a>
</td></tr>
<? }
echo "</table>";
}
if($_REQUEST['view'] == 'search'){
$_SESSION['pageview'] = "online";
?>
<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
<tr>
<th style="width:45%;">Username</th>
<th style="width:55%;">Options</th>
</tr>
<?
$_POST['search'] = addslashes($_POST['search']);
if($_POST['search_type'] == "all"){
$search = mysql_query("SELECT id, username FROM members WHERE username = '{$_POST['search']}'");
$search1 = mysql_fetch_array($search);
$searchc = mysql_num_rows($search);
}
if($_POST['search_type'] == "online"){
$time = time();
$time1 = '2400';
$timeout = $time - $time1;
$search = mysql_query("SELECT id, username FROM online WHERE username = '{$_POST['search']}'");
$search1 = mysql_fetch_array($search);
$searchc = mysql_num_rows($search);
}
if($searchc == '0'){
echo "<tr><td><center>No matches found.</center></td></tr>";
}
if($searchc > '0'){
?>
<tr class="dark" nowrap="nowrap">
<td style="text-align: left;"><strong>
<? echo "<a href=\"/members.php?uid=" . $search1['id'] . "\" "; ?>onclick="membersTab('uid=<? echo $search1['id']; ?>', 1); return false;"<? echo "title=\"" . htmlentities($search1['username']) . "\">" . htmlentities($search1['username']);
?>
</a></strong></td><td style="width: 25%;"><a href="/battle.php?bid=<? echo $search1['id'];?>">Battle</a> | Message | <a href="/members.php?uid=<? echo  $search1['id'];?>&amp;add=yes" onclick="membersTab('uid=<? echo $search1['id'];?>&amp;add=yes', 1); return false;">Add to friends</a>
</td></tr>
<?
}
echo "</table>";
}
?>
</div>
<div class="hr"></div><form action="/members.php?view=search" method="post" onsubmit="getSidebar('//members.php', 'view=search', 'membersTab', 0, this); return false;"><p style="text-align: center;"><strong>Search <select name="search_type"><option value="all">All</option><option value="online">Online</option></select> Members: </strong><input name="search" value="" size="15" type="text"> <input name="submit" value="Search" type="submit"><br><span class="small">You must provide an exact username to find a member.</span></p><p>&nbsp;</p></form></div><div id="copy">&copy; 2008-2009 <a href="http://www.pokemoncrater.com/">The PokÃ©mon Shqipe.</a> This site is not affiliated with Nintendo, The Po&eacute;mon Company, Creatures, or GameFreak<br><a href="/contactus.php">Contact Us</a> | <a href="/about.php">About Us / FAQ</a> | <a href="/privacy.php">Privacy Policy &amp; Terms of Service</a> | <a href="/donate.php">Donate</a></div></div>
<?
}
if($_REQUEST['uid'] && !$_REQUEST['view'] && is_numeric($_REQUEST['uid'])){

$vart = mysql_query("SELECT * FROM members WHERE id = '{$_REQUEST['uid']}'");
$vart1 = mysql_fetch_array($vart);
$a = $vart1['s1'];$b = $vart1['s2'];$c = $vart1['s3'];$d = $vart1['s4'];$e = $vart1['s5'];$f = $vart1['s6'];
if($a && !$b){
$t = mysql_query("SELECT * FROM pokemon WHERE id IN($a) ORDER BY FIELD(id,$a)");
}
if($b && !$c){
$t = mysql_query("SELECT * FROM pokemon WHERE id IN($a,$b) ORDER BY FIELD(id,$a,$b)");
}
if($c && !$d){
$t = mysql_query("SELECT * FROM pokemon WHERE id IN($a,$b,$c) ORDER BY FIELD(id,$a,$b,$c)");
}
if($d && !$e){
$t = mysql_query("SELECT * FROM pokemon WHERE id IN($a,$b,$c,$d) ORDER BY FIELD(id,$a,$b,$c,$d)");
}
if($e && !$f){
$t = mysql_query("SELECT * FROM pokemon WHERE id IN($a,$b,$c,$d,$e) ORDER BY FIELD(id,$a,$b,$c,$d,$e)");
}
if($f){
$t = mysql_query("SELECT * FROM pokemon WHERE id IN($a,$b,$c,$d,$e,$f) ORDER BY FIELD(id,$a,$b,$c,$d,$e,$f)");
}

while($goo = mysql_fetch_assoc($t)){
$pname[] = $goo['name'];
$plvl[] = $goo['lvl'];
$pexp[] = $goo['exp'];
}
echo "<br/><center><h2>" . htmlentities($vart1['username']) . "'s Profile</h2><p class=\"optionsList\"><a href=\"/members.php?uid=" . $_REQUEST['uid'] . "&view=all\" onclick=\"membersTab('uid=" . $_REQUEST['uid'] . "&view=all', 1); return false;\" class=\"deselected\">View all of member's Pok&eacute;mon</a> | <a href=\"/trade.php?type=Username&search=" . $vart1['username'] . "&page=1\" class=\"deselected\">View member's Pok&eacute;mon for trade</a>  <br /><a href=\"battle.php?bid=" . $_REQUEST['uid'] . "\" class=\"deselected\">Battle</a> | <a href=\"/members.php?uid=" . $_REQUEST['uid'] . "&add=yes\" onclick=\"membersTab('uid=" . $_REQUEST['uid'] . "&add=yes', 1); return false;\" class=\"deselected\">Add to friends</a> | <a href=\"/members.php?uid=" . $_REQUEST['uid'] . "&block=yes\" onclick=\"membersTab('uid=" . $_REQUEST['uid'] . "&block=yes', 1); return false;\" class=\"deselected\">Ignore</a> | <a href=\"messages.php?rid=" . $_REQUEST['uid'] . "\" class=\"deselected\">Send message</a> | <a href=\"/members.php?view=" . $_SESSION['pageview'] . "\" onclick=\"membersTab('view=" . $_SESSION['pageview'] . "', 1); return false;\" class=\"deselected\">Back</a></p></center>";
if($_REQUEST['add'] == "yes" && $_REQUEST['uid'] && is_numeric($_REQUEST['uid'])){
$care = mysql_query("SELECT * FROM friends WHERE uid = '{$_SESSION['myid']}' AND fid = '{$_REQUEST['uid']}'");
$checkcare = mysql_num_rows($care);
$new = mysql_query("SELECT * FROM blocked WHERE uid = '{$_SESSION['myid']}' AND bid = '{$_REQUEST['uid']}'");
$newrr = mysql_num_rows($new);
if($newrr > 0){
echo "<div class=\"noticeMsg\">You cannot add someone to your friends list when you have them blocked.</div>";
}
else {
if($checkcare > 0){
echo "<div class=\"noticeMsg\">Friend has already been added.</div>";
}
else {
$findout = mysql_query("SELECT username FROM members WHERE id = '{$_REQUEST['uid']}'");
$fino = mysql_fetch_array($findout);
$finoro = mysql_num_rows($findout);
if($finoro == '1'){
mysql_query("INSERT INTO friends (uid, fid, fname) VALUES ('{$_SESSION['myid']}', '{$_REQUEST['uid']}', '{$fino['username']}')");
$timee = time();
echo "<div class=\"noticeMsg\">Friend added.</div>";
}
else
{
echo "<div class=\"noticeMsg\">Error Occurred</div>";
}
}}}
if($_REQUEST['block'] == "yes" && $_REQUEST['uid'] && is_numeric($_REQUEST['uid'])){
$care = mysql_query("SELECT * FROM blocked WHERE uid = '{$_SESSION['myid']}' AND bid = '{$_REQUEST['uid']}'");
$checkcare = mysql_num_rows($care);
$new = mysql_query("SELECT * FROM friends WHERE uid = '{$_SESSION['myid']}' AND fid = '{$_REQUEST['uid']}'");
$newrr = mysql_num_rows($new);
if($newrr > 0){
echo "<div class=\"noticeMsg\">You cannot block someone who is in your friends list.</div>";
}
else {
if($checkcare > 0){
echo "<div class=\"noticeMsg\">You have already blocked this member.</div>";
}
else {
$findout = mysql_query("SELECT username FROM members WHERE id = '{$_REQUEST['uid']}'");
$fino = mysql_fetch_array($findout);
$finoro = mysql_num_rows($findout);
if($finoro == '1'){
mysql_query("INSERT INTO blocked (uid, bid, bname) VALUES ('{$_SESSION['myid']}', '{$_REQUEST['uid']}', '{$fino['username']}')");
echo "<div class=\"noticeMsg\">Member blocked.</div>";
}
else
{
echo "<div class=\"noticeMsg\">Error Occurred</div>";
}
}}}
echo "<table><tr><td><b><br/>Sprite:</b></td><td><img src=\"html/static/images/sprites/top" . $vart1['trainer'] . ".gif\"><br/><img src=\"html/static/images/sprites/" . $vart1['trainer'] . ".gif\"></td></tr></table>";
echo "<table>";
echo "<tr><td><b>Wins/Losses:</b> ";
echo number_format($vart1['battle']);
echo " / ";
echo number_format($vart1['losses']);
echo "</td></tr>";
if($vart1['display'] == 'Yes'){
$email = htmlentities($vart1['email']);
$aim = htmlentities($vart1['aim']);
$msn = htmlentities($vart1['msn']);
echo "<tr><td><b><u>Email:</u></b> <a href=\"mailto:{$email}\">{$email}</a></td></tr>
<tr><td><b><u>AIM:</u></b> {$aim}</td></tr>
<tr><td><b><u>MSN:</u></b> {$msn}</td></tr>";
}
echo "<tr><td><b>Points:</b> ";
echo number_format($vart1['points']);
echo "</td></tr>";
$aird = "SELECT * FROM comments WHERE userid = '{$_REQUEST['uid']}'";
$result2d = mysql_query($aird) or die(mysql_error());
$air2d = mysql_fetch_array($result2d);
echo "<tr><td><b>Unique Pokemon:</b> ";
echo number_format($vart1['uniques']);
echo "</td></tr>";
echo "<tr><td><b>Total Experience:</b> ";
echo number_format($vart1['totalexp']);
echo "</td></tr>";
echo "<tr><td><b>Average Experience:</b> ";
echo number_format(round($vart1['averageexp']));
echo "</td></tr>";
echo "<tr><td><b>Date Registered:</b> ";
echo (date("F d, Y", $vart1['registered']));
echo "</td></tr>";
echo "<tr><td><b>Last Login:</b> ";
echo (date("F d, Y", $vart1['llogin']));
echo "</td></tr>";
if($air2d['comment'] != ""){
echo "<tr><td><b>Comments:</b></td></tr>";
$codep = htmlentities($air2d['comment']);
$code2 = $codep;
$code = nl2br($code2);
$replace = array("Damn","Cock","Dick","Bitch","Shit","Fuck","fuck","bitch","damn","shit","cock","dick","[u]","[/u]","[i]","[/i]","[b]","[/b]","[s]","[/s]","[sub]","[/sub]","[sup]","[/sup]","[quote]","[/quote]");
$with111 = array("****","****","****","*****","****","****","****","*****","****","****","****","****","<u>","</u>","<i>","</i>","<b>","</b>","<s>","</s>","<sub>","</sub>","<sup>","</sup>","<blockquote style=\"border:1px solid #990000;background-color:Ivory;padding:1px;\"><center><strong>&#8220;</strong>","<strong>&#8221;</strong></center></blockquote>");
$newcode = str_replace($replace, $with111, $code);
echo "<tr><td>" . $newcode . "</td></tr>";
}
echo "<tr><td><hr></td></tr>";
echo "<tr><td><b>Pok&eacute;mon Team:</b></td></tr>";
echo "</table>";
?>
<div style="width:400px;min-height:100px;">
<table style="margin-left: 0px; text-align: left;width: 400px;">
<?
if($a){
echo "<tr><td width=\"80\"><img src=\"html/static/images/pokemon/" . $pname[0] . ".gif\"></td><td width=\"120\"><strong><a href=\"/pokedex.php?pid=" . $a . "\" onclick=\"pokedexTab('pid=" . $a . "', 1); return false;\">" . $pname[0] . "</a></strong><br> <i>Level:</i> " . $plvl[0] . " <i>HP:</i> ";
$hp = $plvl[0] * 4;
$hps = $plvl[0] * 5;
if(strstr($pname[0],'Shiny')){
echo $hps;
}
else {
echo $hp;
}
echo "<br><i>Exp:</i> ";
echo number_format($pexp[0]);
echo "</td>";
}
if(!$b){
echo '<td width=\"80\"></td><td width=\"120\"></td></tr>';
}
if($b){
echo "<td width=\"80\"><img src=\"html/static/images/pokemon/" . $pname[1] . ".gif\"></td><td width=\"120\"><strong><a href=\"/pokedex.php?pid=" . $b . "\" onclick=\"pokedexTab('pid=" . $b . "', 1); return false;\">" . $pname[1] . "</a></strong><br> <i>Level:</i> " . $plvl[1] . " <i>HP:</i> ";
$hp = $plvl[1] * 4;
$hps = $plvl[1] * 5;
if(strstr($pname[1],'Shiny')){
echo $hps;
}
else {
echo $hp;
}
echo "<br><i>Exp:</i> ";
echo number_format($pexp[1]);
echo "</td></tr>";
}
if($c){
echo "<tr><td width=\"80\"><img src=\"html/static/images/pokemon/" . $pname[2] . ".gif\"></td><td width=\"120\"><strong><a href=\"/pokedex.php?pid=" . $c . "\" onclick=\"pokedexTab('pid=" . $c . "', 1); return false;\">" . $pname[2] . "</a></strong><br> <i>Level:</i> " . $plvl[2] . " <i>HP:</i> ";
$hp = $plvl[2] * 4;
$hps = $plvl[2] * 5;
if(strstr($pname[2],'Shiny')){
echo $hps;
}
else {
echo $hp;
}
echo "<br><i>Exp:</i> ";
echo number_format($pexp[2]);
echo "</td>";
}
if(!$d){
echo '<td width=\"80\"></td><td width=\"120\"></td></tr>';
}
if($d){
echo "<td width=\"80\"><img src=\"html/static/images/pokemon/" . $pname[3] . ".gif\"></td><td width=\"120\"><strong><a href=\"/pokedex.php?pid=" . $d . "\" onclick=\"pokedexTab('pid=" . $d . "', 1); return false;\">" . $pname[3] . "</a></strong><br> <i>Level:</i> " . $plvl[3] . " <i>HP:</i> ";
$hp = $plvl[3] * 4;
$hps = $plvl[3] * 5;
if(strstr($pname[3],'Shiny')){
echo $hps;
}
else {
echo $hp;
}
echo "<br><i>Exp:</i> ";
echo number_format($pexp[3]);
echo "</td></tr>";
}
if($e){
echo "<tr><td width=\"80\"><img src=\"html/static/images/pokemon/" . $pname[4] . ".gif\"></td><td width=\"120\"><strong><a href=\"/pokedex.php?pid=" . $e . "\" onclick=\"pokedexTab('pid=" . $e . "', 1); return false;\">" . $pname[4] . "</a></strong><br> <i>Level:</i> " . $plvl[4] . " <i>HP:</i> ";
$hp = $plvl[4] * 4;
$hps = $plvl[4] * 5;
if(strstr($pname[4],'Shiny')){
echo $hps;
}
else {
echo $hp;
}
echo "<br><i>Exp:</i> ";
echo number_format($pexp[4]);
echo "</td>";
}
if(!$f){
echo '<td width=\"80\"></td><td width=\"120\"></td></tr>';
}
if($f){
echo "<td width=\"80\"><img src=\"html/static/images/pokemon/" . $pname[5] . ".gif\"></td><td width=\"120\"><strong><a href=\"/pokedex.php?pid=" . $f . "\" onclick=\"pokedexTab('pid=" . $f . "', 1); return false;\">" . $pname[5] . "</a></strong><br> <i>Level:</i> " . $plvl[5] . " <i>HP:</i> ";
$hp = $plvl[5] * 4;
$hps = $plvl[5] * 5;
if(strstr($pname[5],'Shiny')){
echo $hps;
}
else {
echo $hp;
}
echo "<br><i>Exp:</i> ";
echo number_format($pexp[5]);
echo "</td></tr>";
}
echo "</table></div><div style=\"margin:10px; padding:10px; width:150px; border-top:2px solid #666666\"><a href=\"#\" onclick=\"getBadges({$_REQUEST['uid']}); return false;\">Show Badges</div><div id=\"badges\"></div>";
}
if($_REQUEST['view'] == "all" && $_REQUEST['uid'] && !$_REQUEST['add'] && is_numeric($_REQUEST['uid'])){
$vart = mysql_query("SELECT * FROM members WHERE id = '{$_REQUEST['uid']}'");
$vart1 = mysql_fetch_array($vart);
$ripe = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_REQUEST['uid']}' ORDER BY name");
echo "<center><h2>{$vart1['username']}'s Pokemon</h2></center><table>";
while($rip = mysql_fetch_array($ripe)){
$i = 1;
$number += $i;
if(checkNum($number) === TRUE){
echo "<tr>"; }
echo "<td width=\"200\" align=\"center\"><p><a href=\"/pokedex.php?pid={$rip['id']}\" onclick=\"pokedexTab('pid={$rip['id']}', 1); return false;\">{$rip['name']}</a><br/><img src=\"html/static/images/pokemon/{$rip['name']}.gif\"><br/><strong>Level:</strong> {$rip['lvl']}<br/><strong>Experience:</strong> ";
echo number_format($rip['exp']);
echo "</p></td>";
if(checkNum($number) === TRUE){
}
else {
echo "</tr>";
}}
echo "</table>"; }
if(!$_REQUEST['view'] && !$_REQUEST['uid']){
?>
<div id="notification" style="visibility: hidden;"></div><div id="loading"></div>
<div id="suggestResults"></div><div id="showDetails"></div><div id="errorBox"></div>
<div id="ajax"><h3 style="text-align: center;">Members</h3><p class="optionsList" style="text-align: center;"><a href="//members.php?view=online_friends" onclick="membersTab('view=online_friends', 0); return false;" class="deselected">Friends Online</a> | <a href="//members.php?view=friends_list" onclick="membersTab('view=friends_list', 0); return false;" class="deselected">Friends List</a> | <a href="//members.php?view=ignore_list" onclick="membersTab('view=ignore_list', 0); return false;" class="deselected">Ignore List</a><br /><a href="//members.php?view=online" onclick="membersTab('view=online', 0); return false;" class="selected">Online Members</a> | <a href="//members.php?view=top_trainers" onclick="membersTab('view=top_trainers', 0); return false;" class="deselected">Top Trainers</a></p><h3 style="text-align: center;">Online Members</strong></h3>
<div class="list autowidth">

<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
<tr>
<th style="width:45%;">Username</th>
<th style="width:55%;">Options</th>
</tr>
<?

$time = time();
$time1 = '1800';
$timeout = $time - $time1;

	
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) FROM online";
	$total_pages = mysql_fetch_row(mysql_query($query));
	$total_pages = $total_pages[0];
	
	/* Setup vars for query. */
	$limit = 50; 								//how many items to show per page
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$query = "SELECT username, id FROM online ORDER BY username ASC LIMIT $start, $limit";
	$portfolio = mysql_query($query);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"/members.php?view=online&page=$prev\" onclick=\"membersTab('view=online&page=$prev', 0); return false;\" class=\"deselected\">« Previous</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">« Previous</a>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
				else
					$pagination.= "<a href=\"/members.php?view=online&page=$counter\" onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
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
						$pagination.= "<a href=\"/members.php?view=online&page=$counter\" onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"/members.php?view=online&page=$lpm1\" onclick=\"membersTab('view=online&page=$lpm1', 0); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=$lastpage\" onclick=\"membersTab('view=online&page=$lastpage', 0); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"/members.php?view=online&page=1\" onclick=\"membersTab('view=online&page=`', 0); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=2\" onclick=\"membersTab('view=online&page=2', 0); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"/members.php?view=online&page=$counter\"onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"/members.php?view=online&page=$lpm1\" onclick=\"membersTab('view=online&page=$lpm1', 0); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=$lastpage\" onclick=\"membersTab('view=online&page=$lastpage', 0); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"/members.php?view=online&page=1\" onclick=\"membersTab('view=online&page=1', 0); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"/members.php?view=online&page=2\" onclick=\"membersTab('view=online&page=2', 0); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"/members.php?view=online&view=online&page=$counter\"onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"/members.php?view=online&page=$next\" onclick=\"membersTab('view=online&page=$next', 0); return false;\" class=\"deselected\">Next »</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">Next »</a>";
		$pagination.= "\n";		
	}
?>

	<?php
		while($item = mysql_fetch_array($portfolio))
		{
$i = 1;
$number += $i;
?>


<tr class="<? if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>" nowrap="nowrap">
<td style="text-align: left;"><strong>
<? echo "<a href=\"/members.php?uid=" . $item['id'] . "\" "; ?>onclick="membersTab('uid=<? echo $item['id']; ?>', 1); return false;"<? echo "title=\"" . htmlentities($item['username']) . "\">" . htmlentities($item['username']);
?>
</a></strong></td><td style="width: 25%;"><a href="/battle.php?bid=<? echo $item['id'];?>">Battle</a> | <a href="messages.php?rid=<? echo $item['id']; ?>">Message</a> | <a href="trade.php?type=Username&search=<? echo $item['username']; ?>&page=1">View Trades</a>
</td></tr>
<?
		}
	?></table></div>
<br>
<p class="optionsList autowidth">
<?=$pagination?></p>
</div>
<div class="hr"></div><form action="/members.php?view=search" method="post" onsubmit="getSidebar('//members.php', 'view=search', 'membersTab', 0, this); return false;"><p style="text-align: center;"><strong>Search <select name="search_type"><option value="all">All</option><option value="online">Online</option></select> Members: </strong><input name="search" value="" size="15" type="text"> <input name="submit" value="Search" type="submit"><br><span class="small">You must provide an exact username to find a member.</span></p><p>&nbsp;</p></form></div><?
}


?>
<? include('disclaimer.php'); ?>
</div></div>
</div>
</div>
</div>

</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<? include('pv_disconnect_from_db.php'); ?>