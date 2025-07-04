<?php include('/var/www/html/kick.php');

if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	echo '<h3>Your session has expired, please log back in</h3>';
	exit();
}
include('/var/www/html/pv_connect_to_db.php');

function checkNum($number){
  return ($number%2) ? TRUE : FALSE;
}
$_REQUEST['uid'] = mysql_real_escape_string($_REQUEST['uid']);
echo '
<style>
td{
	valign: middle;
}
#mine{
	margin-left:15px;
}
</style>';
if($_REQUEST['view']){
	$view = $_REQUEST['view'];
	$_SESSION['pageview'] = $view;
}
$number = 0;
if($view && !$_REQUEST['uid'] && $view != 'online'){
	echo '
	<div id="notification" style="visibility: hidden;"></div><div id="loading"></div>
	<div id="suggestResults"></div><div id="showDetails"></div><div id="errorBox"></div>
	<div id="ajax"><h3 style="text-align: center;">Members</h3><p class="optionsList" style="text-align: center;"><a href="members.php?view=online_friends" onclick="membersTab(\'view=online_friends\', 0); return false;" class="';
	if($view == "online_friends"){ echo 'selected'; } else { echo 'deselected'; } 
	echo '">Friends Online</a> | <a href="members.php?view=friends_list" onclick="membersTab(\'view=friends_list\', 0); return false;" class="';
	if($view == "friends_list"){ echo 'selected"'; } else { echo 'deselected'; }
	echo '">Friends List</a> | <a href="members.php?view=ignore_list" onclick="membersTab(\'view=ignore_list\', 0); return false;" class="';
	if($view == "ignore_list"){ echo 'selected'; } else { echo 'deselected'; } 
	echo '">Ignore List</a> | <a href="members.php?view=online" onclick="membersTab(\'view=online\', 0); return false;" class="';
	if($view == "online"){ echo "selected"; } else { echo "deselected"; } 
	echo '">Online Members</a> | <a href="members.php?view=top_trainers" onclick="membersTab(\'view=top_trainers\', 0); return false;" class="';
	if($view == "top_trainers"){ echo 'selected'; }else { echo 'deselected'; }
	echo '">Top Trainers</a> | <a href="members.php?view=top_richest" onclick="membersTab(\'view=top_richest\', 0); return false;" class="';
	if($view == "top_richest"){ echo 'selected'; }else { echo 'deselected'; }
	echo '">Richest Users</a><br /><a href="members.php?view=top_pokemon" onclick="membersTab(\'view=top_pokemon\', 0); return false;" class="';
	if($view == "top_pokemon"){ echo 'selected'; }else { echo 'deselected';}
	echo '">Top Pok&eacute;mon</a> | <a href="members.php?view=top_clans" onclick="membersTab(\'view=top_clans\', 0); return false;" class="';
	if($view == "top_clans"){ echo 'selected'; }else {echo 'deselected';}
	echo '">Top Clans</a></p><h3 style="text-align: center;">';
	
switch($view){
	case top_trainers:
	echo 'Top Trainers';
	break;
	case friends_list:
	echo 'Friends List';
	break;
	case online:
	echo 'Online Members';
	break; 
	case ignore_list:
	echo 'Ignore List';
	break;
	case online_friends:
	echo 'Friends Online';
	break;
	case top_richest:
	echo 'Richest Users';
	break;
	case top_pokemon:
	echo 'Top Pok&eacute;mon';
	break;
	case top_clans:
	echo 'Top Clans';
	break;
	case search:
	echo 'Search';
	break;
}
echo '</strong></h3>
<div class="list autowidth">';

// TOP TRAINERS LIST

if($view == "top_trainers"){
	mysql_query("UPDATE online SET activity = 'Browsing the Top Trainers list' WHERE id = '{$_SESSION['myid']}'");
	echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
	<tr>
	<th style="width:45%;"><a href="members.php?view=top_trainers" onclick="membersTab(\'view=top_trainers\', 0); return false;">Rank / Username</a?</th>
	<th style="width: 25%;"><a href="members.php?view=top_trainers&order=exp" onclick="membersTab(\'view=top_trainers&order=exp\', 0); return false;">Total / Avg Experience</a></th>
	<th style="width: 15%;"><a href="members.php?view=top_trainers&order=battles" onclick="membersTab(\'view=top_trainers&order=battles\', 0); return false;">Battle Count</a></th>
	<th style="width: 15%;"><a href="members.php?view=top_trainers&order=uniques" onclick="membersTab(\'view=top_trainers&order=uniques\', 0); return false;">Unique Pok&eacute;mon</a></th></tr>';
	
	if($_REQUEST['order'] == 'battles'){
		$order = 'battle';
	}
	elseif($_REQUEST['order'] == 'exp'){
		$order = 'totalexp';
	}
	elseif($_REQUEST['order'] == 'uniques'){
		$order = 'uniques';
	}
	else{
		$order = 'points';
	}
	
	$sideright = mysql_query("SELECT id, username, points, battle, uniques, averageexp, totalexp FROM members WHERE banned != '1' ORDER BY $order DESC LIMIT 100");
	while($sideright1 = mysql_fetch_object($sideright)){
		$i = 1;
		$number += $i;
		echo '<tr class="'; 
		if(checkNum($number) === TRUE){
			echo 'dark';
		}else{
			echo 'light';
		}
		echo '" nowrap="nowrap"><td style="text-align: left;"><strong>' . $number . '. <a href="members.php?uid=' . $sideright1->id . '" onclick="membersTab(\'uid=' . $sideright1->id . '\', 1); return false;" title="' . htmlentities($sideright1->username) . '">' . htmlentities($sideright1->username) . '</a></strong><br /><span id="mine" align="left"><i>Points:</i> ' . number_format($sideright1->points) . '</span></td><td style="width: 25%;">' . number_format($sideright1->totalexp) . '<br />' . number_format(round($sideright1->averageexp)) . '</td><td style="width: 15%;">' . number_format($sideright1->battle) . '</td><td style="width: 15%;">' . number_format($sideright1->uniques) . '</td></tr>';
	}
	echo '</table>';
}

// TOP POKEMON LIST

if($view == "top_pokemon"){
	mysql_query("UPDATE online SET activity = 'Browsing the Top Pok�mon list' WHERE id = '{$_SESSION['myid']}'");
	echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
	<tr>
	<th style="width:50%;">Rank / Pok&eacute;mon</th>
	<th style="width:10%;">Experience</th>
	<th style="width: 50%;">Owner</th></tr>';
	$sideright = mysql_query("SELECT id, name, exp, owner, rowner FROM pokemon WHERE owner != '0' ORDER BY exp DESC LIMIT 100");
	while($sideright1 = mysql_fetch_object($sideright)){
		$i = 1;
		$number += $i;
		echo '<tr class="'; 
		if(checkNum($number) === TRUE){
			echo 'dark';
		}else{
			echo 'light';
		}
		echo '" nowrap="nowrap"><td style="text-align: left;"><strong>' . $number . '. <a href="pokedex.php?pid=' . $sideright1->id . '" onclick="pokedexTab(\'pid=' . $sideright1->id . '\', 1); return false;" title="' . htmlentities($sideright1->name) . '">' . htmlentities($sideright1->name) . '</a></strong></td><td style="width: 10%;">' . number_format($sideright1->exp) . '</td><td style="width: 40%;"><a href="members.php?uid=' . $sideright1->owner . '" onclick="membersTab(\'uid=' . $sideright1->owner . '\', 1); return false;" title="' . htmlentities($sideright1->rowner) . '"><strong>' . htmlentities($sideright1->rowner) . '</a></strong></td></tr>';
	}
	echo '</table>';
}


// TOP RICHEST LIST

if($view == "top_richest"){
	mysql_query("UPDATE online SET activity = 'Browsing the Richest Users list' WHERE id = '{$_SESSION['myid']}'");
	echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
	<tr>
	<th style="width:45%;">Rank / Username</th>
	<th style="width: 55%;">Money</th></tr>';
	
	$sideright = mysql_query("SELECT id, username, money FROM members ORDER BY money DESC LIMIT 100");
	while($sideright1 = mysql_fetch_object($sideright)){
		$i = 1;
		$number += $i;
		echo '<tr class="'; 
		if(checkNum($number) === TRUE){
			echo 'dark';
		}else{
			echo 'light';
		}
		echo '" nowrap="nowrap"><td style="text-align: left;"><strong>' . $number . '. <a href="members.php?uid=' . $sideright1->id . '" onclick="membersTab(\'uid=' . $sideright1->id . '\', 1); return false;" title="' . htmlentities($sideright1->username) . '">' . htmlentities($sideright1->username) . '</a></strong><br /></td><td style="width: 55%;"><img src="html/static/images/misc/pmoney.gif">' . number_format($sideright1->money) . '</td></tr>';
	}
	echo '</table>';
}

// TOP CLAN LIST

if($view == 'top_clans'){
	mysql_query("UPDATE online SET activity = 'Browsing the Top Clans list' WHERE id = '{$_SESSION['myid']}'");
	echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
	<tr>
	<th style="width: 30%;">Rank / Clan</th>
	<th style="width: 25%;">Owner / Members</th>
	<th style="width: 15%;">Wins / Losses</th>
	<th style="width: 30%;">Experience</th></tr>';
	
	$clanz = mysql_query("SELECT id, name, owner, members, wins, losses, exp, tag, points FROM clans WHERE approved = '1' ORDER BY points DESC LIMIT 100");
	while($clans = mysql_fetch_object($clanz)){
		$i = 1;
		$number += $i;
		echo '<tr class="'; 
		if(checkNum($number) === TRUE){
			echo 'dark';
		}else{
			echo 'light';
		}
		echo '" nowrap="nowrap"><td style="text-align: left;"><strong>' . $number . '. <a href="clans.php?cid=' . $clans->id . '" target="_BLANK" title="' . htmlentities($clans->name) . '">' . htmlentities($clans->name) . '</a><sup> [' . htmlentities($clans->tag) . ']</sup></strong><br /><i>Points: </i>' . number_format($clans->points) . '</td><td style="width: 25%;">' . htmlentities($clans->owner) . '<br />' . number_format($clans->members) . '</td><td style="width: 15%;">' . number_format($clans->wins) . ' / ' . number_format($clans->losses) . '</td><td style="width: 30%;">' . number_format($clans->exp) . '</td></tr>';
	}
	echo '</table>';
}

// REQUEST USERS FRIEND LIST

if($view == 'friends_list'){
	mysql_query("UPDATE online SET activity = 'Browsing their friends list' WHERE id = '{$_SESSION['myid']}'");
	echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;"><tr><th style="width:40%;">Username</th><th style="width:60%;">Options</th></tr>';
	if(is_numeric($_REQUEST['remove'])){
		mysql_query("DELETE FROM friends WHERE uid = '{$_SESSION['myid']}' AND fid = '{$_REQUEST['remove']}'");
	}
	
	// CHECK HOW MANY FRIENDS THE USER HAS
	
	$friend = mysql_query("SELECT * FROM friends WHERE uid = '{$_SESSION['myid']}' ORDER BY fname ASC");
	$check = mysql_num_rows($friend);
	if($check < 1){
		echo "<tr><td><center>No friends found.</center></td></tr>";
	}
	else {
		
		// DISPLAY THE USERS FRIENDS
		while($friends = mysql_fetch_object($friend)){ 
		$i = 1; 
		$number += $i; 
		echo '<tr class="'; 
		if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; }
		echo '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $friends->fid . '" onclick="membersTab(\'uid=' . $friends->fid . '\', 1); return false;" title="' . htmlentities($friends->fname). '">' . htmlentities($friends->fname) . '</a></strong></td><td style="width: 25%;"><a href="battle.php?bid=' . $friends->fid . '">Battle</a> | <a href="messages.php?rid=' . $friends->fid . '">Message</a> | <a href="trade.php?type=Username&search=' . $friends->fname . '&page=1">View Trades</a> | <a href="members.php?view=friends_list&remove=' . $friends->fid . '" onclick="membersTab(\'view=friends_list&remove=' . $friends->fid . '\', 1); return false;">Remove</a>
		</td></tr>';
		}
	}
	echo '</table>';
}

// REQUEST THE USERS ONLINE FRIENDS

if($view == 'online_friends'){
       mysql_query("UPDATE online SET activity = 'Browsing their online friends list' WHERE id = '{$_SESSION['myid']}'");
	echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;"><tr><th style="width:40%;">Username</th><th style="width:60%;">Options</th></tr>';
	$time = time();
	$time1 = '2400';
	$timeout = $time - $time1;
	$friend = mysql_query("SELECT * FROM friends WHERE uid = '{$_SESSION['myid']}' ORDER BY fname ASC");
	while($friends = mysql_fetch_object($friend)){
		$e2 = mysql_query("SELECT id, username FROM online WHERE id = '{$friends->fid}'");
		$e3 = mysql_fetch_object($e2);
		$et = mysql_num_rows($e2);
		if($et > 0){
			$vau = 7;
			$i = 1; 
			$number += $i;
			
			// DISPLAY THE USERS ONLINE FRIENDS
			
			echo '<tr class="';
			if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } 
			echo '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $e3->id . '" onclick="membersTab(\'uid=' . $e3->id . '\', 1); return false;" title="' . htmlentities($e3->username) . '">' . htmlentities($e3->username) . '</a></strong></td><td style="width: 25%;"><a href="battle.php?bid=' . $e3->id . '">Battle</a> | <a href="messages.php?rid=' . $e3->id . '">Message</a> | <a href="trade.php?type=Username&search=' . htmlentities($e3->username). '&page=1">View Trades</a> | <a href="members.php?view=friends_list&remove=' . $e3->id . '" onclick="membersTab(\'view=friends_list&remove=' . $e3->id . '\', 1); return false;">Remove</a></td></tr>';
		}
	}
	if($vau != 7){ echo '<tr><td><center>No friends found.</center></td></tr>'; }
	echo '</table>';
}

// REQUEST THE USERS BLOCKED USERS LIST

if($view == 'ignore_list'){
       mysql_query("UPDATE online SET activity = 'Browsing their blocked user list' WHERE id = '{$_SESSION['myid']}'");
	if(is_numeric($_REQUEST['remove'])){
		mysql_query("DELETE FROM blocked WHERE uid = '{$_SESSION['myid']}' AND bid = '{$_REQUEST['remove']}'");
	}
	echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;"><tr><th style="width:45%;">Username</th><th style="width:55%;">Options</th></tr>';
	$friend = mysql_query("SELECT * FROM blocked WHERE uid = '{$_SESSION['myid']}'");
	$rt = mysql_num_rows($friend);
	
	// DISPLAY THE USERS BLOCKED USERS LIST
	
	if($rt <= 0){
		echo "<tr><td><center>You currently have no members blocked.</center></td></tr>";
	}
	while($friends = mysql_fetch_object($friend)){
		$i = 1; 
		$number += $i;
		echo '<tr class="';
		if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; }
		echo '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $friends->bid . '" onclick="membersTab(\'uid=' . $friends->bid . '\', 1); return false;" title="' . htmlentities($friends->bname) . '">' . htmlentities($friends->bname) . '</a></strong></td><td style="width: 25%;"><a href="battle.php?bid=' . $friends->bid . '">Battle</a> | <a href="members.php?view=ignore_list&remove=' . $friends->bid . '" onclick="membersTab(\'view=ignore_list&remove=' . $friends->bid . '\', 1); return false;">Remove</a></td></tr>';
	}
	echo '</table>';
}

// REQUEST USER SEARCH

if($view == 'search'){
       echo '<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;"><tr><th style="width:45%;">Username</th><th style="width:55%;">Options</th></tr>';
	$_POST['search'] = addslashes($_POST['search']);
	if($_POST['search_type'] == "all"){
		$search = mysql_query("SELECT * FROM members WHERE username = '{$_POST['search']}'");
		$search1 = mysql_fetch_object($search);
		$searchc = mysql_num_rows($search);
	}
	
	// SEARCH THE ONLINE MEMBERS
	
	if($_POST['search_type'] == "online"){
		$time = time();
		$time1 = '2400';
		$timeout = $time - $time1;
		$search = mysql_query("SELECT * FROM online WHERE username = '{$_POST['search']}'");
		$search1 = mysql_fetch_object($search);
		$searchc = mysql_num_rows($search);
	}
	if($searchc == '0'){
		echo '<tr><td><center>No matches found.</center></td></tr>';
	}
	if($searchc > '0'){
		echo '<tr class="dark" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $search1->id . '" onclick="membersTab(\'uid=' . $search1->id . '\', 1); return false;" title="' . htmlentities($search1->username) . '">' . htmlentities($search1->username) . '</a></strong></td><td style="width: 25%;"><a href="/battle.php?bid=' . $search1->id . '">Battle</a> | Message | <a href="members.php?uid=' . $search1->id . '&amp;add=yes" onclick="membersTab(\'uid=' . $search1->id . '&amp;add=yes\', 1); return false;">Add to friends</a></td></tr>';
	}
	echo '</table>';
}

echo '</div><div class="hr"></div><form action="members.php?view=search" method="post" onsubmit="getSidebar(\'/members.php\', \'view=search\', \'membersTab\', 0, this); return false;"><p style="text-align: center;"><strong>Search <select name="search_type"><option value="all">All</option><option value="online">Online</option></select> Members: </strong><input name="search" value="" size="15" type="text"> <input name="submit" value="Search" type="submit"><br><span class="small">You must provide an exact username to find a member.</span></p><p>&nbsp;</p></form></div><div id="copy">&copy; 2008-2015 <a href="/">shqipe Battle Arena.</a> This site is not affiliated with Nintendo, The Pok&eacute;mon Company, Creatures, or GameFreak<br></div></div>';

}

// VIEW A USERS PROFILE

if($_REQUEST['uid'] && !$view && is_numeric($_REQUEST['uid'])){
	// GET THE USERS TEAM
	
	$vart = mysql_query("SELECT * FROM members WHERE id = '{$_REQUEST['uid']}'");
	$vart2 = mysql_num_rows($vart);
	$vart1 = mysql_fetch_object($vart);
	$set = mysql_query("SELECT * FROM members_options WHERE id = '{$_REQUEST['uid']}'");
	$sett = mysql_fetch_object($set);
	
	$a = $vart1->s1;$b = $vart1->s2;$c = $vart1->s3;$d = $vart1->s4;$e = $vart1->s5;$f = $vart1->s6;
       mysql_query("UPDATE online SET activity = 'Viewing {$vart1->username}\'\s profile' WHERE id = '{$_SESSION['myid']}'");
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
	
	// DISPLAY THE USER FUNCTIONS SUCH AS ADD, BLOCK, TRADE AND MESSAGE
	
	echo '<br/><center><h2>' . htmlentities($vart1->username) . '\'s Profile</h2><p class="optionsList"><a href="members.php?uid=' . $vart1->id . '&view=all" onclick="membersTab(\'uid=' . $vart1->id . '&view=all\', 1); return false;" class="deselected">View all of member\'s Pok&eacute;mon</a> | <a href="/trade.php?type=Username&search=' . $vart1->username . '&page=1" class="deselected">View member\'s Pok&eacute;mon for trade</a>  <br /><a href="battle.php?bid=' . $vart1->id . '" class="deselected">Battle</a> | <a href="members.php?uid=' . $vart1->id . '&add=yes" onclick="membersTab(\'uid=' . $vart1->id . '&add=yes\', 1); return false;" class="deselected">Add to friends</a> | <a href="members.php?uid=' . $vart1->id . '&block=yes" onclick="membersTab(\'uid=' . $vart1->id . '&block=yes\', 1); return false;" class="deselected">Ignore</a> | <a href="messages.php?rid=' . $vart1->id . '" class="deselected">Send message</a> | <a href="members.php?view=' . $_SESSION['pageview'] . '" onclick="membersTab(\'view=' . $_SESSION['pageview'] . '\', 1); return false;" class="deselected">Back</a>';
	//------- admin ban option -------//
	if($_SESSION['banned'] == 3){
		echo ' | <a href="members.php?uid=' . $vart1->id . '&banz=yes" onclick="membersTab(\'uid=' . $vart1->id . '&banz=yes\', 1); return false;" class="deselected"><font color="red">Ban</font><!-- <img src="http://www.darkfta.com/Forum/images/smilies/ban%20button.gif" /> --></a>';
	}
	echo '</p></center>';
	
	// ADD THE REQUESTED USER AS A FRIEND
	
	if($_REQUEST['add'] == "yes" && $_REQUEST['uid']){
		
		// CHECK IF THE REQUESTED FRIEND IS ALREADY ADDED AS A FRIEND
		
		$care = mysql_query("SELECT fid FROM friends WHERE uid = '{$_SESSION['myid']}' AND fid = '{$_REQUEST['uid']}'");
		$checkcare = mysql_num_rows($care);
		
		// CHECK IF THE REQUESTED FRIEND IS ALSO BLOCKED
		
		$new = mysql_query("SELECT bid FROM blocked WHERE uid = '{$_SESSION['myid']}' AND bid = '{$_REQUEST['uid']}'");
		$newrr = mysql_num_rows($new);
		if($newrr > 0){
			echo '<div class="noticeMsg">You cannot add someone to your friends list when you have them blocked.</div>';
		}
		else {
			if($checkcare > 0){
				echo '<div class="noticeMsg">Friend has already been added.</div>';
			}
			else {
				if($vart2 == '1'){
					mysql_query("INSERT INTO friends (uid, fid, fname) VALUES ('{$_SESSION['myid']}', '{$vart1->id}', '{$vart1->username}')");
					$timee = time();
					echo '<div class="noticeMsg">Friend added.</div>';
				}
				else
				{
					echo '<div class="noticeMsg">Error Occurred</div>';
				}
			}
		}
	}
	
	// BLOCK THE REQUESTED USER
	
	if($_REQUEST['block'] == "yes" && $_REQUEST['uid'] && is_numeric($_REQUEST['uid'])){
		
		// CHECK IF THE REQUESTED USER IS ALREADY BLOCKED
		
		$care = mysql_query("SELECT bid FROM blocked WHERE uid = '{$_SESSION['myid']}' AND bid = '{$_REQUEST['uid']}'");
		$checkcare = mysql_num_rows($care);
		
		// CHECK IF THE REQUESTED USER IS ADDED AS A FRIEND
		
		$new = mysql_query("SELECT fid FROM friends WHERE uid = '{$_SESSION['myid']}' AND fid = '{$_REQUEST['uid']}'");
		$newrr = mysql_num_rows($new);
		if($newrr > 0){
			echo '<div class="noticeMsg">You cannot block someone who is in your friends list.</div>';
		}
		else {
			if($checkcare > 0){
				echo '<div class="noticeMsg">You have already blocked this member.</div>';
			}
			else {
				if($vart2 == '1'){
					mysql_query("INSERT INTO blocked (uid, bid, bname) VALUES ('{$_SESSION['myid']}', '{$vart1->id}', '{$vart1->username}')");
					echo '<div class="noticeMsg">Member blocked.</div>';
				}
				else
				{
					echo '<div class="noticeMsg">Error Occurred</div>';
				}
			}
		}
	}
	
	// BAN THE REQUESTED USER
	if($_REQUEST['banz'] == "yes" && $_REQUEST['uid'] && is_numeric($_REQUEST['uid'])){
		// CHECK IF THE REQUESTED USER IS ALREADY BANNED
		$banned = mysql_query("SELECT * FROM members WHERE id = '{$_REQUEST['uid']}'");
		$bannedd = mysql_fetch_array($banned);
		if($bannedd['banned'] == 1){
			echo '<div class="errorMsg">This user is already banned</div>';
		}
		elseif($bannedd['banned'] == 0){
			mysql_query("UPDATE members SET banned = '1', email = 'admin@pokemon-shqipe.co.uk', money = '0', eb = '0.000' WHERE id = '{$_REQUEST['uid']}'");
			mysql_query("UPDATE comments SET comment = 'This account has been banned by Pokemon shqipe' WHERE userid = '{$_REQUEST['uid']}'");
			mysql_query("UPDATE pokemon SET exp = '0' WHERE owner = '{$_REQUEST['uid']}'");
			mysql_query("UPDATE items SET Master_Ball = '0' WHERE uid = '{$_REQUEST['uid']}'");
			echo '<div class="actionMsg">This account has been banned</div>';
		}
		else{
			echo '<div class="noticeMsg">This account cannot be banned</div>';
		}
	}
	
	// DISPLAY THE PROFILE AND STATS AND COLLECT ONLINE INFO
	
	
	$onl = mysql_query("SELECT * FROM online WHERE id = '{$_REQUEST['uid']}'");
	$onl1 = mysql_fetch_object($onl);
	if(!$onl1){
		$online1 = '<font color="red">No</font> <img src="html/static/images/misc/npb.gif">';
	}
	else{
		$online1 = '<font color="green">Yes</font> <img src="html/static/images/misc/pb.gif">';
	}
	echo '<table><tr><td><b><br/>Sprite:</b></td><td><img src="html/static/images/sprites/top' . $sett->trainer . '.gif"><br/><img src="html/static/images/sprites/' . $sett->trainer . '.gif"></td></tr></table><table><tr><td><b>Wins/Losses:</b> ' . number_format($vart1->battle) . ' / ' . number_format($vart1->losses) . '</td></tr>';
	$activity = htmlentities($onl1->activity);
	if($sett->display == 'Yes'){
		$email = htmlentities($vart1->email);
		$skype = htmlentities($sett->skype);
		$forum = htmlentities($sett->forum);
		echo "<tr><td><b><u>Email:</u></b> <a href=\"mailto:{$email}\">{$email}</a></td></tr>
		<tr><td><b><u>Skype:</u></b> {$skype}</td></tr>
		<tr><td><b><u>Forum:</u></b> {$forum}</td></tr>";
	}
	echo "<tr><td><b>Online:</b> {$online1}</td></tr>
			<tr><td><b>Activity:</b><i> {$activity}</i></td></tr>";
	echo '<tr><td><b>Points:</b> ' . number_format($vart1->points) . '</td></tr>';
	
	$result2d = mysql_query("SELECT * FROM comments WHERE userid = '{$_REQUEST['uid']}'") or die(mysql_error());
	$air2d = mysql_fetch_object($result2d);
	if($vart1->clan_name != ""){
		echo '<tr><td><b>Clan:</b> ' . $vart1->clan_name . '</td></tr>';
	}
	echo '<tr><td><b>Unique Pokemon:</b> ' . number_format($vart1->uniques) . ' / 5,274</td></tr>
	<tr><td><b>Total Experience:</b> ' . number_format($vart1->totalexp) . '</td></tr>
	<tr><td><b>Average Experience:</b> ' . number_format(round($vart1->averageexp)) . '</td></tr>
	<tr><td><b>Date Registered:</b> ';echo (date("F d, Y", $vart1->registered));
	echo '</td></tr><tr><td><b>Last Login:</b> ';
	echo (date("F d, Y", $vart1->llogin));
	echo '</td></tr>';
	if($air2d->comment != ""){
		echo "<tr><td><b>Comments:</b></td></tr>";
		$codep = htmlentities($air2d->comment);
		$code2 = $codep;
		$code = nl2br($code2);
		
		// REPLACE AND DISPLAY FILTERED WORDS AND BB CODES IN REQUESTED USERS COMMENTS
		
		$replace = array("Damn","Cock","Dick","Bitch","Shit","Fuck","FUCK","FUck","fuck","bitch","damn","shit","cock","dick","[u]","[/u]","[i]","[/i]","[b]","[/b]","[s]","[/s]","[sub]","[/sub]","[sup]","[/sup]","[quote]","[/quote]");
		$with111 = array("****","****","****","*****","****","****","****","****","****","*****","****","****","****","****","<u>","</u>","<i>","</i>","<b>","</b>","<s>","</s>","<sub>","</sub>","<sup>","</sup>","<blockquote style=\"border:1px solid #990000;background-color:Ivory;padding:1px;\"><center><strong>&#8220;</strong>","<strong>&#8221;</strong></center></blockquote>");
		$newcode = str_replace($replace, $with111, $code);
		echo '<tr><td>' . $newcode . '</td></tr>';
	}
	
	// DISPLAY REQUESTED USERS TEAM
	echo '<tr><td><hr></td></tr><tr><td><b>Pok&eacute;mon Team:</b></td></tr></table>';
	
	echo '<div style="width:600px;min-height:100px;"><table style="margin-left: 0px; text-align: left;width: 600px;">';
	
	$ram = array('a','b','c','d','e','f');
	for($z=0;$z<6;$z++){
		$letter = ${$ram[$z]};
		if(!$letter){
			if($ram[$z] == 'c' || $ram[$z] == 'e'){
				echo '<tr>';
			}
			echo '<td width="80"></td><td width="120"></td>';
			if($ram[$z] == 'b' || $ram[$z] == 'd' || $ram[$z] == 'f'){
				echo '</tr>';
			}
		}
		else
		{
			if($ram[$z] == 'c' || $ram[$z] == 'e' || $ram[$z] == 'a'){
				echo '<tr>';
			}
			echo '<td width="80"><img src="html/static/images/pokemon/' . $pname[$z] . '.gif"></td><td width="140"><strong><a href="/pokedex.php?pid=' . ${$ram[$z]} . '" onclick="pokedexTab(\'pid=' . ${$ram[$z]} . '\', 1); return false;">' . $pname[$z] . '</a></strong><br> <i>Level:</i> ' . $plvl[$z] . ' <i>HP:</i> ';
			
			// CALCULATE AND DISPLAY POKEMON'S HP
			
			$hp = $plvl[$z] * 4;
			$hps = $plvl[$z] * 5;
			if(strstr($pname[$z],'Shiny ')){
				echo $hps;
			}
			else {
				echo $hp;
			}
			echo '<br><i>Exp:</i> ' . number_format($pexp[$z]) . '</td>';
			
			if($ram[$z] == 'b' || $ram[$z] == 'd' || $ram[$z] == 'f'){
				echo '</tr>';
			}
		}
	}
	echo '</table></div><div style="margin:10px; padding:10px; width:150px; border-top:2px solid #666666"><a href="#" onclick="getBadges(' . $_REQUEST['uid'] . '); return false;">Show Badges</div><div id="badges"></div>';
}

// VIEW ALL OF THE REQUESTED USERS POKEMON

if($view == "all" && $_REQUEST['uid'] && !$_REQUEST['add']){
	
	
	$vart = mysql_query("SELECT username FROM members WHERE id = '{$_REQUEST['uid']}'");
	$vart1 = mysql_fetch_object($vart);
	$ripe = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_REQUEST['uid']}' ORDER BY name");
	echo '<center><h2>' . $vart1->username . '\'s Pokemon</h2></center><table>';
	echo '<center><p class="optionsList"><a href="members.php?uid=' . $_REQUEST['uid'] . '" onclick="membersTab(\'uid=' . $_REQUEST['uid'] . '\', 1); return false;" class="deselected">Back</a></p></center>';
	while($rip = mysql_fetch_object($ripe)){
		$i = 1;
		$number += $i;
		if(checkNum($number) === TRUE){
			echo '<tr>';
		}
		echo '<td width="300" align="center"><p><a href="/pokedex.php?pid=' . $rip->id . '" onclick="pokedexTab(\'pid=' . $rip->id . '\', 1); return false;">' . $rip->name . '</a><br/><img src="html/static/images/pokemon/' . $rip->name .'.gif"><br/><strong>Level:</strong> ' . $rip->lvl . '<br/><strong>Experience:</strong> ' . number_format($rip->exp) . '</p></td>';
		if(checkNum($number) === TRUE){
		}
		else {
			echo '</tr>';
		}
	}
	echo '</table>';
}

// VIEWING THE ONLINE USER LIST

if(!$view && !$_REQUEST['uid'] || $view == 'online'){
	mysql_query("UPDATE online SET activity = 'Browsing the online user list' WHERE id = '{$_SESSION['myid']}'");
	
	echo '	<div id="notification" style="visibility: hidden;"></div><div id="loading"></div>
	<div id="suggestResults"></div><div id="showDetails"></div><div id="errorBox"></div>
	<div id="ajax"><h3 style="text-align: center;">Members</h3><p class="optionsList" style="text-align: center;"><a href="members.php?view=online_friends" onclick="membersTab(\'view=online_friends\', 0); return false;" class="';
	if($view == "online_friends"){ echo 'selected'; } else { echo 'deselected'; } 
	echo '">Friends Online</a> | <a href="members.php?view=friends_list" onclick="membersTab(\'view=friends_list\', 0); return false;" class="';
	if($view == "friends_list"){ echo 'selected"'; } else { echo 'deselected'; }
	echo '">Friends List</a> | <a href="members.php?view=ignore_list" onclick="membersTab(\'view=ignore_list\', 0); return false;" class="';
	if($view == "ignore_list"){ echo 'selected'; } else { echo 'deselected'; } 
	echo '">Ignore List</a> | <a href="members.php?view=online" onclick="membersTab(\'view=online\', 0); return false;" class="';
	if($view == "online"){ echo "selected"; } else { echo "deselected"; } 
	echo '">Online Members</a> | <a href="members.php?view=top_trainers" onclick="membersTab(\'view=top_trainers\', 0); return false;" class="';
	if($view == "top_trainers"){ echo 'selected'; }else { echo 'deselected'; }
	echo '">Top Trainers</a> | <a href="members.php?view=top_richest" onclick="membersTab(\'view=top_richest\', 0); return false;" class="';
	if($view == "top_richest"){ echo 'selected'; }else { echo 'deselected'; }
	echo '">Richest Users</a><br /><a href="members.php?view=top_pokemon" onclick="membersTab(\'view=top_pokemon\', 0); return false;" class="';
	if($view == "top_pokemon"){ echo 'selected'; }else { echo 'deselected';}
	echo '">Top Pok&eacute;mon</a> | <a href="members.php?view=top_clans" onclick="membersTab(\'view=top_clans\', 0); return false;" class="';
	if($view == "top_clans"){ echo 'selected'; }else {echo 'deselected';}
	echo '">Top Clans</a></p><h3 style="text-align: center;">';

include('/var/www/ads/tabad.php');
	echo '
	<h3 style="text-align: center;">Online Members</strong></h3>
	<div class="list autowidth">
	<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
	<tr>
	<th style="width:45%;">Username</th>
	<th style="width:55%;">Options</th>
	</tr>';
	if(is_numeric($_REQUEST['page'])){
		$page = $_REQUEST['page'];
	}
	$time = time();
	$time1 = '1800';
	$timeout = $time - $time1;
	
	// PAGINATION

	
	// HOW MANY ADJACENT PAGES SHOULD BE SHOWN ON EACH SIDE?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) FROM online";
	$total_pages = mysql_fetch_row(mysql_query($query));
	$total_pages = $total_pages[0];
	
	/* Setup vars for query. */
	$limit = 50; 								//HOW MANY ITEMS TO SHOW PER PAGE
	if($page) 
		$start = ($page - 1) * $limit; 			//FIRST ITEM TO DISPLAY ON THIS PAGE
	else
		$start = 0;								//IF NO PAGE VAR IS GIVEN, SET START TO 0
	
	/* Get data. */
	$query = "SELECT username, id, clan_tag FROM online ORDER BY id ASC LIMIT $start, $limit";
	$portfolio = mysql_query($query);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//IF NO PAGE VAR IS GIVEN, DEFAULT TO 1
	$prev = $page - 1;							//PREVIOUS PAGE IS PAGE - 1
	$next = $page + 1;							//NEXT PAGE IS PAGE + 1
	$lastpage = ceil($total_pages/$limit);		//LAST PAGE IS = TOTAL PAGES / ITEMS PER PAGE, ROUNDED UP
	$lpm1 = $lastpage - 1;						//LAST PAGE MINUS 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"members.php?view=online&page=$prev\" onclick=\"membersTab('view=online&page=$prev', 0); return false;\" class=\"deselected\">&laquo; Previous</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">&laquo; Previous</a>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//NOT ENOUGH PAGES TO BOTHER BREAKING IT UP
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
				else
					$pagination.= "<a href=\"members.php?view=online&page=$counter\" onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//ENOUGH PAGES TO HIDE SOME
		{
			//CLOSE TO BEGINNING; ONLY HIDE LATER PAGES
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"members.php?view=online&page=$counter\" onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"members.php?view=online&page=$lpm1\" onclick=\"membersTab('view=online&page=$lpm1', 0); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"members.php?view=online&page=$lastpage\" onclick=\"membersTab('view=online&page=$lastpage', 0); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//IN THE MIDDLE; HIDE SOME FRONT AND SOME BACK
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"members.php?view=online&page=1\" onclick=\"membersTab('view=online&page=`', 0); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"members.php?view=online&page=2\" onclick=\"membersTab('view=online&page=2', 0); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"members.php?view=online&page=$counter\"onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"members.php?view=online&page=$lpm1\" onclick=\"membersTab('view=online&page=$lpm1', 0); return false;\" class=\"deselected\">$lpm1</a>";
				$pagination.= "<a href=\"members.php?view=online&page=$lastpage\" onclick=\"membersTab('view=online&page=$lastpage', 0); return false;\" class=\"deselected\">$lastpage</a>";		
			}
			//CLOSE TO END; ONLY HIDE START PAGES
			else
			{
				$pagination.= "<a href=\"members.php?view=online&page=1\" onclick=\"membersTab('view=online&page=1', 0); return false;\" class=\"deselected\">1</a>";
				$pagination.= "<a href=\"members.php?view=online&page=2\" onclick=\"membersTab('view=online&page=2', 0); return false;\" class=\"deselected\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href=\"#\" class=\"selected\">$counter</a>";
					else
						$pagination.= "<a href=\"members.php?view=online&view=online&page=$counter\"onclick=\"membersTab('view=online&page=$counter', 0); return false;\" class=\"deselected\">$counter</a>";					
				}
			}
		}
		
		//NEXT BUTTON
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"members.php?view=online&page=$next\" onclick=\"membersTab('view=online&page=$next', 0); return false;\" class=\"deselected\">Next &raquo;</a>";
		else
			$pagination.= "<a href=\"#\" class=\"deselected\">Next &raquo;</a>";
		$pagination.= "\n";		
	}
?>

	<?php
		while($item = mysql_fetch_object($portfolio))
		{
			$i = 1;
			$number += $i;
			
			echo '<tr class="';
			if(checkNum($number) === TRUE){
				echo 'dark';
			}
			else{
				echo 'light';
			} 
			echo '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $item->id . '" onclick="membersTab(\'uid=' . $item->id . '\', 1); return false;" title="' . htmlentities($item->username) . '">'; if($item->username == 'Patrick' || $item->username == 'Rob'){ echo '<span style="background:url(html/static/images/admin_flare.gif);color:red;font-weight:bold;text-shadow:0 0 .9em #df0101;">'; } echo '' . htmlentities($item->username) . '</a>'; if($item->username == 'Patrick' || $item->username == 'Rob'){ echo '</span>';} if($item->clan_tag){ echo '<sup> [' . $item->clan_tag . ']</sup>'; } echo '</strong></td><td style="width: 25%;"><a href="/battle.php?bid=' . $item->id . '">Battle</a> | <a href="messages.php?rid=' . $item->id . '">Message</a> | <a href="trade.php?type=Username&search=' . htmlentities($item->username) . '&page=1">View Trades</a></td></tr>';
		}
		echo '</table></div>
		<br>
		<p class="optionsList autowidth">
		' . $pagination . '</p>
		</div>
		<div class="hr"></div><form action="members.php?view=search" method="post" onsubmit="getSidebar(\'/members.php\', \'view=search\', \'membersTab\', 0, this); return false;"><p style="text-align: center;"><strong>Search <select name="search_type"><option value="all">All</option><option value="online">Online</option></select> Members: </strong><input name="search" value="" size="15" type="text"> <input name="submit" value="Search" type="submit"><br><span class="small">You must provide an exact username to find a member.</span></p><p>&nbsp;</p></form></div>';
}
include('/var/www/html/pv_disconnect_from_db.php');
?>