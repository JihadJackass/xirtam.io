<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:/login?goawaxP=1");
	exit();
}
include('pv_connect_to_db.php');
function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}
//---------------------------Create a clan request handler---------------------------------------//
if($_POST['action'] == 'create'){ // Check if the user is creating a clan
	if($_POST['clanname'] == '' || $_POST['tag'] == ''){ // Make sure both a clan name and tag was submitted
		echo '<div class="errorMsg">You need to enter a clan name and a clan tag</div>';
	}
	else{ // protect the data
		$clanname = mysql_real_escape_string($_POST['clanname']);
		$tag = mysql_real_escape_string($_POST['tag']);
		$forum = mysql_real_escape_string($_POST['forum']);
		$comment = mysql_real_escape_string($_POST['comment']);
		
		$req = mysql_query("SELECT * FROM clan_requests WHERE id = '{$_SESSION['myid']}'");
		$request = mysql_num_rows($req);
		$alr = mysql_query("SELECT * FROM clan_members WHERE id = '{$_SESSION['myid']}'");
		$alre = mysql_num_rows($alr);
		
		$check = mysql_query("SELECT * FROM clans WHERE name = '$clanname'");
		$checkk = mysql_fetch_array($check);
		if($checkk){ // Make sure the clan isn't being created with a duplicate name
			echo '<div class="errorMsg">There is already a clan by that name, please choose something else.</div>';
		}
		elseif($alre >= 1){
			echo '<div class="errorMsg">You are already a member of a clan or you already own one. You cannot join another clan.</div>';
		}
		elseif($request >= 1){
			echo '<div class="errorMsg">You already have an active request to join another clan. If you no longer want to join that clan go to \'Pending Clan Requests\' and cancel your request to join that clan.</div>';
		}
		elseif(stristr($clanname,'admin') || stristr($clanname,'fuck') || stristr($clanname,'pokemon shqipe') || stristr($clanname,'shit') || stristr($clanname,'patrick') || stristr($clanname,'rob') || stristr($clanname,'dean')){ // Forbidden clan name strings
			echo '<div class="errorMsg">The clan name you entered has been automatically filtered out as inappropriate. Please choose something else.</div>';
		}
		else{ // Create the clan
			$makeclan = mysql_query("INSERT INTO clans (name, owner, link, motto, tag, points) VALUES ('$clanname', '{$_SESSION['myuser']}', '$forum', '$comment', '$tag', '0.0')");
			$id = mysql_insert_id();
			$do_member = mysql_query("INSERT INTO clan_members (id, clan_name, clan_id, owner, username) VALUES ('{$_SESSION['myid']}', '$clanname', '$id', '1', '{$_SESSION['myuser']}')");
			$update_member = mysql_query("UPDATE members SET clan_name = '$clanname', clan_tag = '$tag' WHERE id = '{$_SESSION['myid']}'");
			$online = mysql_query("UPDATE online SET clan_tag = '$tag' WHERE id = '{$_SESSION['myid']}'");
			if(!$makeclan || !$do_member){
				echo '<div class="errorMsg">Sorry, an error has occurred. Please try again later.</div>';
			}
			else{ // Create the clan user and update clan's exp
				$_SESSION['clan'] = $clanname;
				$get_owner = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
				$owner = mysql_fetch_array($get_owner);
				$update_clan = mysql_query("UPDATE clans SET exp = '{$owner['totalexp']}' WHERE id = '$id'");
				$exp = mysql_query("UPDATE clan_members SET exp = '{$owner['totalexp']}' WHERE id = '{$_SESSION['myid']}'");
				$prof = mysql_query("UPDATE members SET clan_name = '$clanname', clan_tag = '$tag' WHERE id = '{$_SESSION['myid']}");
				if(!$get_owner || !$update_clan){
					echo '<div class="errorMsg">Sorry, an error has occured. Please try again later.</div>';
				}
				else{
					echo '<div class="actionMsg">Your clan has successfully been submitted for review. Please be patient while we look through it.</div>';
					$_SESSION['clanowner'] = 1;
				}
			}			
		}
	}
}
//----------------Join clan request handler-------------------------//
if($_POST['join'] && is_numeric($_POST['clanid'])){
	$clan_id = mysql_real_escape_string($_POST['clanid']);
	$req = mysql_query("SELECT * FROM clan_requests WHERE id = '{$_SESSION['myid']}'");
	$request = mysql_num_rows($req);
	$alr = mysql_query("SELECT * FROM clan_members WHERE id = '{$_SESSION['myid']}'");
	$alre = mysql_num_rows($alr);
	$clmem = mysql_query("SELECT * FROM clans WHERE id = '$clan_id'");
	$clfull = mysql_fetch_array($clmem);
	if($clfull['members'] >= 400){
		echo '<div class="errorMsg">The clan you\'re requesting to join is full.</div>';
	}
	if($alre >= 1){
		echo '<div class="errorMsg">You are already a member of a clan or you already own one. You cannot join another clan.</div>';
	}
	if($request >= 1){
		echo '<div class="errorMsg">You already have an active request to join another clan. If you no longer want to join that clan go to \'Pending Clan Requests\' and cancel your request to join that clan.</div>';
	}
	elseif($request == 0 && $alre == 0){
		$getclan = mysql_query("SELECT * FROM clans WHERE id = '$clan_id'");
		$get_clan = mysql_fetch_array($getclan);
		$join = mysql_query("INSERT INTO clan_requests (id, username, clan, clan_id) VALUES ('{$_SESSION['myid']}', '{$_SESSION['myuser']}', '{$get_clan['name']}', '$clan_id')");
		echo '<div class="actionMsg">You have requested to join the clan, please allow time for the owner to accept or decline.</div>';
	}
} 
elseif($_POST['join'] && !is_numeric($_POST['clanid'])){
	echo '<div class="errorMsg">You did not specify a clan to join.</div>';
}
//--------------Cancel your clan request-------------------//
if($_POST['cancel'] && is_numeric($_POST['clan_id'])){
	$cancel = mysql_query("DELETE FROM clan_requests WHERE ID = '{$_SESSION['myid']}'");
	if(!$cancel){
		echo '<div class="errorMsg">Sorry, an error occurred, please try again later</div>';
	}
	else{
		echo '<div class="actionMsg">You have cancelled your request to join ' . $gm['clan'] . '</div>';
	}
}

//---------------Clan owner requests------------------------//
if($_POST['accept'] && is_numeric($_POST['userid_accept'])){
	$members = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
	$mem_tot = mysql_fetch_array($members);
	if($mem_tot['members'] >= 400){
		echo '<div class="errorMsg">Your clan is full. Each clan can only have 400 members.</div>';
	}
	else{
		$user = mysql_real_escape_string($_POST['userid_accept']);
		$getuser = mysql_query("SELECT * FROM members WHERE id = '$user'");
		$get_user = mysql_fetch_array($getuser);
		mysql_query("UPDATE clans SET exp = exp + {$get_user['totalexp']}, members = members + 1 WHERE name = '{$_SESSION['clan']}'");
		$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
		$clan_info = mysql_fetch_array($claninfo);
		$wins = $clan_info['wins'];
		$exp = $clan_info['exp'];
		$members = $clan_info['members'];
		$avgexp = $exp / $members;
		$p0 = sqrt($members);
		$p1 = sqrt($exp);
		$p2 = sqrt($avgexp);
		$p3 = log($wins);
		$p4 = $p1 * $p2 * $p3 * $p0;
		$p5 = $p4 / 10000;
		$p6 = round($p5, 1);
		mysql_query("UPDATE clans SET points = '$p6' WHERE name = '{$_SESSION['clan']}'");
		mysql_query("DELETE FROM clan_requests WHERE id = '$user'");
		mysql_query("INSERT INTO clan_members (id, clan_name, clan_id, owner, username, exp) VALUES ('$user', '{$clan_info['name']}', '{$clan_info['id']}', '0', '{$get_user['username']}', '{$get_user['totalexp']}')");
		mysql_query("UPDATE online SET clan_tag = '{$clan_info['tag']}' WHERE id = '$user'");
		mysql_query("UPDATE members SET clan_name = '{$clan_info['name']}', clan_tag = '{$clan_info['tag']}' WHERE id = '$user'");
		echo '<div class="actionMsg">You have accepted ' . $get_user['username'] . ' into your clan.</div>';
	}
}
elseif($_POST['accept'] && !is_numeric($_POST['userid_accept'])){
	echo '<div class="errorMsg">No user was selected to accept to your clan</div>';
}
if($_POST['decline'] && is_numeric($_POST['userid_decline'])){
	$user = mysql_real_escape_string($_POST['userid_decline']);
	$declined = mysql_query("DELETE FROM clan_requests WHERE id = '$user'");
	if(!$declined){
		echo '<div class="errorMsg">Sorry, an error occurred, please try again later.</div>';
	}
	else{
		echo '<div class="actionMsg">User Declined</div>';
	}
}
elseif($_POST['decline'] && !is_numeric($_POST['userid_decline'])){
	echo '<div class="errorMsg">No user was selected to decline</div>';
}
//-----------------------Clan battle request handler--------------------//
if($_POST['battle']){
	if($_POST['id'] == ''){
		echo '<div class="errorMsg">Sorry, an error occurred while getting another clan member to battle. Please try again later.</div>';
	}
	else{
		$battle = mysql_real_escape_string($_POST['id']);
		header('location:/battle.php?clanbattle=' . $battle . '');
	}
}
//----------------------Leave a clan----------------------------//
if($_POST['leave']){
	if(is_numeric($_POST['clanid'])){
		$get_me = mysql_query("SELECT * FROM clan_members WHERE id = '{$_SESSION['myid']}'");
		$me = mysql_fetch_array($get_me);
		$update = mysql_query("UPDATE clans SET exp = exp  - '{$me['exp']}', members = members - 1 WHERE name = '{$_SESSION['clan']}'");
		if($update){
			$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
			$clan_info = mysql_fetch_array($claninfo);
			$wins = $clan_info['wins'];
			$exp = $clan_info['exp'];
			$members = $clan_info['members'];
			$avgexp = $exp / $members;
			$p0 = sqrt($members);
			$p1 = sqrt($exp);
			$p2 = sqrt($avgexp);
			$p3 = log($wins);
			$p4 = $p1 * $p2 * $p3 * $p0;
			$p5 = $p4 / 10000;
			$p6 = round($p5, 1);
			mysql_query("UPDATE clans SET points = '$p6' WHERE name = '{$_SESSION['clan']}'");
			unset($_SESSION['clan']);
			mysql_query("DELETE FROM clan_members WHERE id = '{$_SESSION['myid']}'");
			mysql_query("UPDATE members SET clan_tag = '', clan_name = '' WHERE id = '{$_SESSION['myid']}'");
			mysql_query("UPDATE online SET clan_tag = '' WHERE id = '{$_SESSION['myid']}'");
			echo '<div class="actionMsg">You have successfully left your clan.</div>';
		}
		else{
			echo '<div class="errorMsg">An error has occurred.</div>';
		}
	}
}
if(!$_REQUEST['ajax']){
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
if($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
if($_SESSION['layout'] == '2'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//v3/ie6-.js"></script>
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pok&eacute;mon Shqipe - Clans</title>
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
<div id="title"><h1><a href="index.php"><em>pokemon-shqipe.co.uk</em></a></h1></div>
<ul id="nav"><li><a href="map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li><li><a href="battle_select.php" id="battleTab" class="deselected"><em>Battle</em></a></li><li><a href="your_account.php" id="yourAccountTab" class="deselected"><em>Your Account</em></a></li><li><a href="community.php" id="communityTab" class="deselected"><em>Communtiy</em></a></li></ul><ul id="logout"><li><a href="logout.php">Logout</a></li></ul>
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
<div id="notification" style="visibility: hidden;"></div><div id="loading"></div>
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
//----------Ajax Menu------------//
$clans = 'deselected';
$yourclan = 'deselected';
$create = 'deselected';
$requests = 'deselected';
$battle = 'deselected';
if(isset($_REQUEST['view'])){
	$view = $_REQUEST['view'];
	if($view == 'YourClan'){
		$yourclan = 'selected';
		$type = 2;
	}
	if($view == 'Create'){
		$create = 'selected';
		$type = 3;
	}
	if($view == 'Requests'){
		$requests = 'selected';
		$type = 4;
	}
	if($view == 'Battle'){
		$battle = 'selected';
		$type = 5;
	}
}
else{
	$clans = 'selected';
       $type = 6;
}?>


<h2>Pok&eacute;mon Shqipe Clans</h2>
<p class="optionsList autowidth"><strong>View:</strong> <a href="clans.php" onclick="get('clans.php',''); return false;" class="<?=$clans?>">Clan List</a> | <a href="clans.php?view=YourClan" onclick="get('clans.php','view=YourClan'); return false;" class="<?=$yourclan?>">Your Clan</a> | <a href="clans.php?view=Create" onclick="get('clans.php','view=Create'); return false;" class="<?=$create?>">Create a Clan</a> | <a href="clans.php?view=Requests" onclick="get('clans.php','view=Requests'); return false;" class="<?=$requests?>">Pending Clan Requests</a> | <a href="clans.php?view=Battle" onclick="get('clans.php','view=Battle'); return false;" class="<?=$battle?>">Battle a Clan Member</a></p>

<?php
if($type == 2){ //----------View my clan------------//
	$re = mysql_query("SELECT * FROM clan_members WHERE id = '{$_SESSION['myid']}'");
	$my = mysql_num_rows($re);
	if($my == 0){ //----------Not in a Clan------------//
		echo '<h2>You are currently not a member of a clan.</h2><br />
		<h4>Options:</h4>
		Create a clan<br />
		Request to join a clan<br />
		View open clans<br />
		<h4>Why join a clan?</h4>
		Joining a clan just adds to the fun that is Pok&eacute;mon Shqipe. Upon signup you can request to join a currently open clan or you can get stuck in and complete all the gym leaders, elite 4s, champions and battle frontiers to create your own clan and have your friends team up with you to be the best clan on Pok&eacute;mon Shqipe.<br />';
	}
	else{ //----------Are in a clan------------//
		$are = mysql_query("SELECT * FROM clan_members WHERE id = '{$_SESSION['myid']}'");
		$arei = mysql_fetch_array($are);
		$_SESSION['clan'] = $arei['clan_name'];
		$clanz = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
		$clan_get = mysql_fetch_array($clanz);
		echo '<h3>Your Clan</h3>

		<p style="text-align: left;">
		<strong>Clan:</strong> ' . htmlentities($_SESSION['clan']) . '<br />
		<strong>Clan Tag:</strong> [' . $clan_get['tag'] . ']<br />
		<strong>Owner:</strong> ' . htmlentities($clan_get['owner']) . '<br />
		<strong>Points:</strong> ' . number_format($clan_get['points']) . '<br />
		<strong>Experience:</strong> ' . number_format($clan_get['exp']) . '<br />
		<strong>Wins:</strong> ' . number_format($clan_get['wins']) . '<br />
		<strong>Losses:</strong> ' . number_format($clan_get['losses']) . '<br />
		<strong>Forum Link:</strong> <a href="' . htmlentities($clan_get['link']) . '" target="_BLANK">' . htmlentities($clan_get['link']) . '</a><br />
		<strong>Member Count:</strong> ' . number_format($clan_get['members']) . ' / 400<br />';
		
		if($clan_get['owner'] == $_SESSION['myuser']){
			echo '';
		}
		else{
			echo '<form action="clans.php" id="action" method="post" onsubmit="get(\'clans.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="clanid" id="clanid" value="' . $clan_get['id'] . '" /><input type="hidden" name="leave" id="cancel" value="cancel" /><input type="submit" name="submit" value="Leave" /></form></td>';
		}
		
		echo '</p>
		<div class="list autowidth" style="width:90%">
		<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
		<tbody><tr>
		<th style="width: 30%;">Username</th>
		<th style="width: 40%;">Options</th>
		<th style="width: 30%;">Experience</th>
		</tr>';
		$php_page = 'clans.php';
		$table_used = 'clan_members';
		$query_used = 'WHERE clan_name = \'' . $_SESSION['clan'] . '\'';
		$page = $_REQUEST['page'];
		$page_name = 'view=YourClan';
		include('pagination.php');
		

		
		$number = 0;
		$gcm = mysql_query("SELECT id, owner, username, exp FROM clan_members WHERE clan_name = '{$_SESSION['clan']}' ORDER BY exp DESC LIMIT $start, $limit");
		while($gm = mysql_fetch_array($gcm)){
			$get_ban = mysql_query("SELECT * FROM members WHERE id = '{$gm['id']}'");
			$banned = mysql_fetch_array($get_ban);
			$i = 1;
			$number += $i;
			if(checkNum($number) === TRUE){
				$class = 'dark';
			}
			else{
				$class = 'light';
			}
			echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;"><strong>' . $number . '. <a href="members.php?uid=' . $gm['id'] . '" onclick="membersTab(\'uid=' . $gm['id'] . '\', 1); return false;" title="' . htmlentities($gm['username']) . '">' . htmlentities($gm['username']) . '</a> <sup>[' . $clan_get['tag'] . ']</sup></a></strong>'; if($banned['banned'] == '1'){ echo ' (Banned)'; } echo '</td><td style="width: 40%;"><a href="battle.php?bid=' . $gm['id'] . '">Battle</a> | <a href="messages.php?rid=' . $gm['id'] . '">Message</a> | <a href="trade.php?type=Username&search=' . htmlentities($gm['username']) . '&page=1">View Trades</a></td><td style="width: 30%;">' . number_format($gm['exp']) . '</td></tr>';
		}
		echo '</table></div><p class="optionsList autowidth">'; ?> <?=$pagination;?><?php echo '</p>';
	}
}
if($type == 3){
	//----------------------------------------------------------Create a Clan-------------------------------------------------------------//
	if($_SESSION['map_preferences'][0] == 1){
		echo '<h3>Create a Clan</h3><span class="small">Fields marked with a<font color="red"> *</font> must be entered. Other fields are optional.</span>
		</p>
		<form action="clans.php" id="action" method="post" onsubmit="get(\'clans.php\', \'\', this); disableSubmitButton(this); return false;">
		
		<script>
		$(function () {
			var form = $("#action");

			var input1 = $("#clanname");
			var input2 = $("#tag");

  			form.submit(function (evt) {
				if (input1.val() == "") {
					evt.preventDefault();
				}
			});
		});
		</script>
		
		<table width="300" border="0" cellspacing="0" cellpadding="4" style="margin: 0 auto 0 auto; text-align: left;">
		<tr>
		<td style="text-align: right;" valign="middle">Clan Name<font color="red"> *</font></td>
		<td><input type="text" class="req" required="required" maxlength="20" name="clanname" id="clanname"></td>
		</tr>
		<tr>
		<td style="text-align: right;" valign="middle">Clan Tag<font color="red"> *</font></td>
		<td><input type="text" class="req" required="required" maxlength="3" name="tag" id="tag"></td>
		</tr>
		<tr>
		<td style="text-align: right;" valign="middle">Forum Topic</td>
		<td><input type="text" name="forum" id="forum" maxlength="30" value="http://forums.pokemonvortex.org/index.php?showtopic="></td>
		</tr>
		<tr>
		<td style="text-align: right;" valign="middle">Motto / Comments</td>
		<td><input type="text" name="comment" maxlength="50" id="comment"></td>
		</table>
		<input type="hidden" class="btn" id="action" name="action" value="create" /><input type="submit" name="submit" value="Create" />
		</form>

		<h4>Rules for creating a clan</h4>
		<ul style="text-align: left;">
		<li>Do not use profane language in your clan name or clan tag. (This includes making your clan tag an inappropriate word using symbols)</li>
		<li>Do not put any links in the forum topic section, other than a Pok&eacute;mon Shqipe Forum link.</li>
		<li>If your clan does not and will not have a forum topic, leave it blank.</li>
		<li>Again, do not use profane language in the motto/comments section.</li>
		<li>All clans that are created go under moderation before they are able to be viewed by everyone to make sure all of these rules are followed.<br />
		If you break any of these rules and submit a clan for approval, we will decline the application and your account will be given a strike.<br />
		If you then submit another clan for approval that doesn\'t follow these rules, you will lose the ability to create a clan.</li>
		</ul>
		<h4>Clan FAQ</h4>
		<p style="text-align: left;">
		<strong>Q: </strong>Why can\'t I or other people see my clan in the clans list?<br />
		<strong>A: </strong>It is most likely because your clan has not yet been approved by an administrator. When you create a clan, it must be sent for approval to make sure the name, tag, link and comments are appropriate enough to be displayed to all members. Once it has been approved, it will appear in the public clans list and people can then request to join. Also, you cannot see your own clan in the clan list.<br /><br />
		<strong>Q: </strong>What is a clan tag?<br />
		<strong>A: </strong>A clan tag is a mixture of three letters, numbers or characters that will resemble your clan. It can be the name abbreviated or mean something to the clan. It can even be random if you want. They can only be three characters so choose them wisely.<br /><br />
		<strong>Q: </strong>Can I delete my clan once I\'ve created one?<br />
		<strong>A: </strong>No, unfortunately clans cannot be deleted so make sure before you submit one, it has the name and tag you want to keep for your entire time here at Pok&eacute;mon Shqipe.<br /><br />
		<strong>Q: </strong>Why can\'t I invite people to join my clan?<br />
		<strong>A: </strong>This is to cut down on people spamming invites to other members just to climb the clan leaderboard. If someone wants to join your clan, they will request to join you.<br /><br />
		<strong>Q: </strong>Why can\'t I own a clan and join someone elses?<br />
		<strong>A: </strong>You can only be a member of one clan, whether you made it or joined it, that will be your only clan. After all, why would you want to represent two teams?<br /><br />
		<strong>Q: </strong>If I join someone elses clan, can I leave if I decide to make my own?<br />
		<strong>A: </strong>Yes. All clans not created by you that you join can be left in case you decide to create your own. However, once you create one, you cannot leave or delete it.<br /><br />
		<strong>Q: </strong>If I leave a clan, can I request to join the same clan again?<br />
		<strong>A: </strong>While this would be a slightly pointless thing to do, yes, you can do that. Whether the owner accepts you again after leaving is entirely up to them though.<br /><br />
		

		
		
		
		</p>';
	}
	else{
		echo 'You must complete all gyms, elite 4\'s, champions and battle frontier\'s before you can create a clan.<br />You also cannot create more than one clan.';
	}
}
if($type == 4){
	//----------------------------------------------------------Clan Requests-------------------------------------------------------------//
	if($_SESSION['clanowner'] == 1){
		$get_requests = mysql_query("SELECT * FROM clan_requests WHERE clan = '{$_SESSION['clan']}'");
		$requests = mysql_fetch_array($get_requests);
		
		echo '<h3>Pending Requests</h3>
		<div class="list autowidth" style="width:90%">
		<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
		<tbody><tr>
		<th style="width: 30%;">Username</th>
		<th style="width: 40%;">Options</th>
		<th style="width: 30%;">Experience</th>
		</tr>';
		$php_page = 'clans.php';
		$table_used = 'clan_requests';
		$query_used = 'WHERE clan = \'' . $_SESSION['clan'] . '\'';
		$page = $_REQUEST['page'];
		$page_name = 'view=Requests';
		include('pagination.php');

		if(is_numeric($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		}

		
		$number = 0;
		$gcm = mysql_query("SELECT * FROM clan_requests WHERE clan = '{$_SESSION['clan']}' LIMIT $start, $limit");
		while($gm = mysql_fetch_array($gcm)){
			$expp = mysql_query("SELECT totalexp FROM members WHERE id = '{$gm['id']}'");
			$exppp = mysql_fetch_array($expp);
			$i = 1;
			$number += $i;
			if(checkNum($number) === TRUE){
				$class = 'dark';
			}
			else{
				$class = 'light';
			}
			echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $gm['id'] . '" onclick="membersTab(\'uid=' . $gm['id'] . '\', 1); return false;" title="' . htmlentities($gm['username']) . '">' . htmlentities($gm['username']) . '</a></strong></td><td style="width: 40%;"><form action="clans.php" id="action" method="post" onsubmit="get(\'clans.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="userid_accept" id="userid_accept" value="' . $gm['id'] . '" /><input type="hidden" name="accept" id="accept" value="accept" /><input type="submit" name="submit" value="Accept" /></form> <form action="clans.php" id="action" method="post" onsubmit="get(\'clans.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="userid_decline" id="userid_decline" value="' . $gm['id'] . '" /><input type="hidden" name="decline" id="decline" value="decline" /><input type="submit" name="submit" value="Decline" /></form></td><td style="width: 30%;">' . number_format($exppp['totalexp']) . '</td></tr>';
		}
		echo '</table></div><p class="optionsList autowidth">'; ?> <?=$pagination;?><?php echo '</p>';
	}
	else{
		$get_request = mysql_query("SELECT * FROM clan_requests WHERE id = '{$_SESSION['myid']}'");
		if(!$get_request){
			echo '<div class="noticeMsg>You have not yet requested to join a clan and you don\'t own a clan to accept people into.</div>';
		}
		else{
			echo '<h3>Pending Requests</h3>
			<div class="list autowidth" style="width:90%">
			<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
			<tbody><tr>
			<th style="width: 30%;">Clan</th>
			<th style="width: 40%;">Options</th>
			<th style="width: 30%;">Status</th>
			</tr>';
			if(is_numeric($_REQUEST['page'])){
				$page = $_REQUEST['page'];
			}
	
			
			$number = 0;
			$gcm = mysql_query("SELECT * FROM clan_requests WHERE id = '{$_SESSION['myid']}'");
			while($gm = mysql_fetch_array($gcm)){
				$i = 1;
				$number += $i;
				if(checkNum($number) === TRUE){
					$class = 'dark';
				}
				else{
					$class = 'light';
				}
				echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="clans.php?cid=' . $gm['clan_id'] . '">' . htmlentities($gm['clan']) . '</a></strong></td><td style="width: 40%;"><form action="clans.php" id="action" method="post" onsubmit="get(\'clans.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="clan_id" id="clan_id" value="' . $gm['clan_id'] . '" /><input type="hidden" name="cancel" id="cancel" value="cancel" /><input type="submit" name="submit" value="Cancel" /></form></td><td style="width: 30%;"><font color="red">Not Yet Accepted</font></td></tr>';
			}
			echo '</table></div></p>';
		}
	}
}
if($type == 5){
	//-----------------------------------------------------------Clan Battle--------------------------------------------------------------//
	if(isset($_SESSION['clan'])){
		if(!isset($_SESSION['clan_battle'])){
			$battle = mysql_query("SELECT secret_key, id, username, clan_name, clan_tag FROM members WHERE NOT clan_name = '{$_SESSION['clan']}' ORDER BY RAND() LIMIT 1");
			$battlee = mysql_fetch_array($battle);
			$_SESSION['clan_battle'] = array("{$battlee['secret_key']}","{$battlee['id']}","{$battlee['username']}","{$battlee['clan_name']}","{$battlee['clan_tag']}");
		}
		echo '<h3>Clan Battles</h3><span class="small">Note: Your opponent will change when they have been defeated or after a significant amount of time.</span></p>Here you will be able to battle random members of other clans to get your clans win count up and earn points.<br />Be sure to win, your clan is counting on you...<br /><br /><h4>Opponent:</h4><strong>' . $_SESSION['clan_battle'][2] . '</strong> from the clan ' . $_SESSION['clan_battle'][3] . '<sup> [' . $_SESSION['clan_battle'][4] . ']</sup></p>';
		echo '<form action="clans.php" id="action" method="post"><input type="hidden" name="id" id="id" value="' . $_SESSION['clan_battle'][0] . '" /><input type="hidden" name="battle" id="battle" value="battle" /><input type="submit" name="submit" value="Battle!" /></form>';
	}
	else{
		echo '<div class="noticeMsg">It seems you are not in a clan yet, you cannot participate in clan battles if you are not a member of a clan.</div>';
	}
}
if($type == 6){
	//-----------------------------------------------------Clan List (Default Drop Page)--------------------------------------------------//
	if(is_numeric($_REQUEST['cid'])){
		//------------------------------------------------------View A Specific Clan------------------------------------------------------//
		$clanid = mysql_real_escape_string($_REQUEST['cid']);
		$get_the_clan = mysql_query("SELECT * FROM clans WHERE id = '$clanid' && approved = '1'");
		$clanget = mysql_fetch_array($get_the_clan);
		
		echo '<h3>Viewing Clan: ' . htmlentities($clanget['name']) . '</h3>

		<p style="text-align: left;">
		<strong>Clan:</strong> ' . htmlentities($clanget['name']) . '<br />
		<strong>Clan Tag:</strong> [' . $clanget['tag'] . ']<br />
		<strong>Owner:</strong> ' . htmlentities($clanget['owner']) . '<br />
		<strong>Points:</strong> ' . number_format($clanget['points']) . '<br />
		<strong>Experience:</strong> ' . number_format($clanget['exp']) . '<br />
		<strong>Wins:</strong> ' . number_format($clanget['wins']) . '<br />
		<strong>Losses:</strong> ' . number_format($clanget['losses']) . '<br />
		<strong>Forum Link:</strong> <a href="' . htmlentities($clanget['link']) . '" target="_BLANK">' . htmlentities($clanget['link']) . '</a><br />
		<strong>Member Count:</strong> ' . number_format($clanget['members']) . '<br />';
		
		echo '</p>
		<h3>Members</h3>
		<div class="list autowidth" style="width:90%">
		<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
		<tbody><tr>
		<th style="width: 30%;">Username</th>
		<th style="width: 40%;">Options</th>
		<th style="width: 30%;">Experience</th>
		</tr>';
		$php_page = 'clans.php';
		$table_used = 'clan_members';
		$query_used = 'WHERE clan_name = \'' . $clanget['name'] . '\'';
		$page = $_REQUEST['page'];
		$page_name = 'cid=' . $clanid . '';
		include('pagination.php');

		if(is_numeric($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		}

		
		$number = 0;
		$gcm = mysql_query("SELECT id, owner, username, exp FROM clan_members WHERE clan_id = '$clanid' ORDER BY exp DESC LIMIT $start, $limit");
		while($gm = mysql_fetch_array($gcm)){
			$i = 1;
			$number += $i;
			if(checkNum($number) === TRUE){
				$class = 'dark';
			}
			else{
				$class = 'light';
			}
			echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $gm['id'] . '" onclick="membersTab(\'uid=' . $gm['id'] . '\', 1); return false;" title="' . htmlentities($gm['username']) . '">' . htmlentities($gm['username']) . '</a> <sup>[' . $clanget['tag'] . ']</sup></a></strong></td><td style="width: 40%;"><a href="battle.php?bid=' . $gm['id'] . '">Battle</a> | <a href="messages.php?rid=' . $gm['id'] . '">Message</a> | <a href="trade.php?type=Username&search=' . $gm['username'] . '&page=1">View Trades</a></td><td style="width: 30%;">' . number_format($gm['exp']) . '</td></tr>';
		}
		echo '</table></div><p class="optionsList autowidth">'; ?> <?=$pagination;?><?php echo '</p>';
	}
	else{
		//-------------------------------------------------View All Clans---------------------------------------------------//
		echo '</p><span class="small">Note: Your own clan is not visible on this list.</span></p>
		<div class="list autowidth" style="width:90%">
		<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
		<tbody><tr>
		<th style="width: 30%;">Clan Name / Clan Tag</th>
		<th style="width: 30%;">Options</th>
		<th style="width: 20%;">Points</th>
		<th style="width: 20%;">Members</th>
		</tr>';
		$php_page = 'clans.php';
		$table_used = 'clans';
		$query_used = 'WHERE approved = \'1\'';
		$page = $_REQUEST['page'];
		$page_name = '';
		include('pagination.php');

		if(is_numeric($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		}
	

			
		$number = 0;
		$clanzz = mysql_query("SELECT * FROM clans WHERE approved = '1' AND NOT name = '{$_SESSION['clan']}' ORDER BY name LIMIT $start, $limit");
		while($clan_gett = mysql_fetch_array($clanzz)){
			$i = 1;
			$number += $i;
			if(checkNum($number) === TRUE){
				$class = 'dark';
			}
			else{
				$class = 'light';
			}
			echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="clans.php?cid=' . $clan_gett['id'] . '" title="' . htmlentities($clan_gett['name']) . '">' . htmlentities($clan_gett['name']) . '</a> <sup>[' . $clan_gett['tag'] . ']</sup></a></strong></td><td style="width: 30%;">'; if($clan_gett['members'] >= 400){ echo '<font color="red">This clan is full</font>'; }else{ echo '<form action="clans.php" id="action" method="post" onsubmit="get(\'clans.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="clanid" id="clanid" value="' . $clan_gett['id'] . '" /><input type="hidden" name="join" id="join" value="join" /><input type="submit" name="submit" value="Join" /></form>'; } echo '</td><td style="width: 20%;">' . number_format($clan_gett['points']) . '</td><td style="width: 20%;">' . number_format($clan_gett['members']) . ' / 400</tr>';
		}
		echo '</table></div><p class="optionsList autowidth">'; ?> <?=$pagination;?><?php echo '</p>';
	}
}
if(!$_REQUEST['ajax']){
	?>
</div>
<div id="copy">&copy; 2008-2015 <a href="/">Shqipe Battle Arena</a>. This site is not affiliated with Nintendo, The Pok&eacute;mon Company, Creatures, or GameFreak<br /><a href="contactus.php">Contact Us</a> | <a href="about.php">About Us / FAQ</a> | <a href="privacy.php">Privacy Policy &amp; Terms of Service</a> | <a href="/legal.php">Legal Info</a> | <a href="/credits.php">Credits</a></div>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php
} ?>