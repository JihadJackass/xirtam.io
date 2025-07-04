<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawaxP=1");
	exit();
}
include('pv_connect_to_db.php');
unset($_SESSION['opponent_profile'],$_SESSION['s1'],$_SESSION['s2'],$_SESSION['s3'],$_SESSION['s4'],$_SESSION['s5'],$_SESSION['s6'],$_SESSION['ops1'],$_SESSION['ops2'],$_SESSION['ops3'],$_SESSION['ops4'],$_SESSION['ops5'],$_SESSION['ops6'],$_SESSION['position'],$_SESSION['pos'],$_SESSION['your_profile'],$_SESSION['y_p'],$_SESSION['live'][0]);
$time = time();
mysql_query("REPLACE INTO live_battle_members (userid, username, time) VALUES('{$_SESSION['myid']}', '{$_SESSION['myuser']}', '{$time}')");
$timeout = $time - 300;
mysql_query("DELETE FROM live_battle_members WHERE time < '$timeout'");
function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}
if($_REQUEST['view'] == 'decline' && $_REQUEST['uid']){
	mysql_query("DELETE FROM live_battle_offer WHERE offer_id = '{$_SESSION['myid']}' AND your_id = '{$_REQUEST['uid']}'");
}
if($_REQUEST['view'] == 'accept' && $_REQUEST['uid']){
	$rt = mysql_query("SELECT * FROM live_battle_offer WHERE offer_id = '{$_SESSION['myid']}' AND your_id = '{$_REQUEST['uid']}'");
	if(mysql_num_rows($rt) == 1){
			$_SESSION['live'][0] = 1;
			$_SESSION['live'][1] = 2;
			$_SESSION['live'][3] = $_REQUEST['uid'];
			mysql_query("UPDATE live_battle_offer SET offer = 1 WHERE offer_id = '{$_SESSION['myid']}' AND your_id = '{$_REQUEST['uid']}'");
			mysql_query("INSERT INTO live_battle (uid_1, uid_2) VALUES('{$_SESSION['myid']}', '{$_REQUEST['uid']}')");
			header("location:live_battle.php?battle=Live");
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
	<script type="text/javascript" language="javascript" src="html/static/js//ie6-.js"></script>
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon v3 - Live Battle</title>
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
</div>
<div id="scrollContent">
<div id="ajax">
		<?php
	}
	$live = 'deselected';
	$offers = 'deselected';
	$challenge = 'deselected';
	$members = 'deselected';
	if(isset($_REQUEST['view'])){
		$view = $_REQUEST['view'];
		if($view == 'Offers'){
			$offers = 'selected';
			$type = 2;
		}
		if($view == 'Challenge'){
			$challenge = 'selected';
			$type = 3;
		}

		if($view == 'Members'){
			$members = 'selected';
			$type = 4;
		}
	}
	else{
		$live = 'selected';
	}
	?>
<h2>Live Battle Arena!</h2>
<p class="optionsList autowidth"><strong>View:</strong> <a href="live_battle_arena.php" onclick="get('live_battle_arena.php',''); return false;" class="<?=$live?>">Live Battle Arena</a> | <a href="live_battle_arena.php?view=Offers" onclick="get('live_battle_arena.php','view=Offers'); return false;" class="<?=$offers?>">Offers</a> | <a href="live_battle_arena.php?view=Challenge" onclick="get('live_battle_arena.php','view=Challenge'); return false;" class="<?=$challenge?>">Challenge a Member</a> | <a href="live_battle_arena.php?view=Members" onclick="get('live_battle_arena.php','view=Members'); return false;" class="<?=$members?>">Members in Live Battle Arena</a></p>
	<?php
	if($type == 2){
		$re = mysql_query("SELECT * FROM live_battle_offer WHERE offer_id = '{$_SESSION['myid']}'");
		$my = mysql_num_rows($re);
		if($my == 0){
			echo '<h2>No live battle offers have been made to you.</h2>';
		}
		else{
			echo '<div class="list autowidth" style="width:70%">
			<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
			<tbody><tr>
			<th style="width: 45%;">Username</th>
			<th style="width: 55%;">Options</th>
			</tr>';

			$number = 0;
			while($gm = mysql_fetch_array($re)){
				$i = 1;
				$number += $i;
				if(checkNum($number) === TRUE){
					$class = 'dark';
				}
				else{
					$class = 'light';
				}
				echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $gm['your_id'] . '" onclick="membersTab(\'uid=' . $gm['your_id'] . '\', 1); return false;" title="' . $gm['your_username'] . '">' . $gm['your_username'] . '</a></strong></td><td style="width: 25%;"><a href="/live_battle_arena.php?view=accept&uid=' . $gm['your_id'] . '">Accept</a> | <a href="/live_battle_arena.php?view=decline&uid=' . $gm['your_id'] . '">Decline</a></td></tr>';
			}
			echo '</table></div>';
		}
	}
	elseif($type == 3){
		if($_REQUEST['uid'] || $_SESSION['waiting']){
			if(is_numeric($_SESSION['waiting'])){
				$rt = mysql_query("SELECT * FROM live_battle_offer WHERE offer_id = '{$_SESSION['waiting']}' AND your_id = '{$_SESSION['myid']}'");
				if(mysql_num_rows($rt) == 1){
					$re = mysql_fetch_array($rt);
					if($re['offer'] == '1'){
						$_SESSION['live'][0] = 2;
						$_SESSION['live'][1] = 1;
						$_SESSION['live'][3] = $_SESSION['waiting'];
						mysql_query("DELETE FROM live_battle_offer WHERE offer_id = '{$_SESSION['waiting']}' AND your_id = '{$_SESSION['myid']}'");
						unset($_SESSION['waiting']);
						echo '<h2><a href="/live_battle.php?battle=Live">Battle has been accepted! Click here to continue.</a></h2>';
					}
					else{
						echo '<h2>Waiting for the member to respond...<a href="/live_battle_arena.php?view=Challenge&uid=' . $_SESSION['waiting'] . '">Click here to refresh</a></h2>';
					}
				}
				else{
					echo '<h2>Sorry your offer has been declined.</h2>';
					unset($_SESSION['waiting']);
				}
			}
			else{
				$yt = mysql_query("SELECT userid FROM live_battle_members WHERE userid = '{$_REQUEST['uid']}'");
				$ty = mysql_num_rows($yt);
				if($ty > 0){
					mysql_query("DELETE FROM live_battle_offer WHERE your_id = '{$_SESSION['myid']}'");
					mysql_query("INSERT INTO live_battle_offer (offer_id, your_id, your_username, time) VALUES ('{$_REQUEST['uid']}', '{$_SESSION['myid']}', '{$_SESSION['myuser']}', '$time')");
					echo '<h2>Waiting for the member to respond...<a href="/live_battle_arena.php?view=Challenge">Click here to refresh</a></h2>';
					$_SESSION['waiting'] = $_REQUEST['uid'];
				}
				else{
					echo '<div class="errorMsg">Sorry the member you have entered is not in the live battle arena at this time.</div>';
				}
			}
		}
		else{
			if($_POST['submitb']){
				if($_POST['battle'] == "Username"){
					$quer = mysql_query("SELECT * FROM live_battle_members WHERE username = '{$_POST['buser']}'");
					$query = mysql_fetch_array($quer);
					if(mysql_num_rows($quer) == 1){
						echo '<h2>Member found!</h2> Would your like to live battle ' . $query['username'] . '? <a href="/live_battle_arena.php?view=Challenge&uid=' . $query['userid'] . '">Yes</a>';
					}
					else{
						echo '<div class="errorMsg">The username specified isn\'t currently in the live battle arena';
					}
				}
				else{
					$quer = mysql_query("SELECT * FROM live_battle_members WHERE userid = '{$_POST['buser']}'");
					$query = mysql_fetch_array($quer);
					if(mysql_num_rows($quer) == 1){
						echo '<h2>Member found!</h2> Would your like to live battle ' . $query['username'] . '? <a href="/live_battle_arena.php?view=Challenge&uid=' . $query['userid'] . '">Yes</a>';
					}
					else{
						echo '<div class="errorMsg">The username specified isn\'t currently in the live battle arena';
					}
				}
			}
			else{
				echo '<form method="post" action="/live_battle_arena.php?view=Challenge">
				Search: <select name="battle"><option>Username</option><option>User ID</option></select> <input type="text" name="buser">
				<p><span class="small">You must provide an exact username to find a member.</span></p>
				<br><input name="submitb" type="submit" value="Find"></form>';
			}
		}
	}
	elseif($type == 4){
		$get_members = mysql_query("SELECT * FROM live_battle_members ORDER BY username");
		echo '<div class="list autowidth" style="width:70%">
		<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
		<tbody><tr>
		<th style="width: 45%;">Username</th>
		<th style="width: 55%;">Options</th>
		</tr>';

		$number = 0;
		while($gm = mysql_fetch_array($get_members)){
			$i = 1;
			$number += $i;
			if(checkNum($number) === TRUE){
				$class = 'dark';
			}
			else{
				$class = 'light';
			}
			echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $gm['userid'] . '" onclick="membersTab(\'uid=' . $gm['userid'] . '\', 1); return false;" title="' . $gm['username'] . '">' . $gm['username'] . '</a></strong></td><td style="width: 25%;"><a href="/live_battle_arena.php?view=Challenge&uid=' . $gm['userid'] . '">Live Battle</a> | <a href="messages.php?rid=' . $gm['userid'] . '">Message</a></td></tr>';
		}
		echo '</table></div>';
	}
	else{
		?>
		Welcome to the live battle arena. The live battle arena is where you can battle other trainers in real time. They control their Pokemon. Come in and join the fun.<br/><br/>You must be active in the Live Battle Arena within the past 5 minutes to be able to accept live battles.
		<?php
	}


if(!$_REQUEST['ajax']){
	?>
	</div>
    <div id="copy">&copy; 2008-2014 <a href="/">The Pok&eacute;mon</a>. This site is not affiliated with Nintendo, The Pok&eacute;mon Company, Creatures, or GameFreak<br /><a href="contactus.php">Contact Us</a> | <a href="about.php">About Us / FAQ</a> | <a href="privacy.php">Privacy Policy &amp; Terms of Service</a> | <a href="/credits.php">Credits</a></div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </body>
    <script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
    </html>
    <?php
}
include('pv_disconnect_from_db.php'); ?>