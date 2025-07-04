<?php
include('kick.php');
if(!$_SESSION['myid']){
	include('pv_disconnect_from_db.php');
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
if($_SESSION['access'] == 9){
	include('pv_connect_to_db.php');
	$time = time();
	
	mysql_query("DELETE FROM messages WHERE receiverdelete = '0' AND senderdelete = '0'");
	mysql_query("UPDATE members SET messnotify = '0' WHERE id = '{$_SESSION['myid']}'");
	$rid4 = "deselected";
	if(is_numeric($_REQUEST['rid'])){
		$rid = mysql_query("SELECT username FROM members WHERE id = '{$_REQUEST['rid']}' LIMIT 1");
		$rid1 = mysql_num_rows($rid);
		if($rid1 > '0'){
			$rid2 = mysql_fetch_array($rid);
			$rid3 = $rid2['username'];
			$rid4 = "selected";
		}
	}
	
	if($_POST['messageusername'] && $_POST['messagetitle'] && $_POST['messagetext']){
		if(!$_SESSION['message_preferences'][1]){
			$_SESSION['message_preferences'][1] = 0;
		}
		
		$t_i = $time - $_SESSION['message_preferences'][1];
		if($t_i < 29){
			$b = 9;
		}
		if($t_i > 29){
			$_SESSION['message_preferences'][1] = time();
			$_POST['messageusername'] = mysql_real_escape_string($_POST['messageusername']);
			$_POST['messagetitle'] = mysql_real_escape_string($_POST['messagetitle']);
			$_POST['messagetext'] = mysql_real_escape_string($_POST['messagetext']);
			
			$keep = 0;
			if($_POST['keep'] == '1'){
				$keep = 1;
			}
			
			$kkjs = mysql_query("SELECT id, username FROM members WHERE username = '{$_POST['messageusername']}' LIMIT 1");
			$kma = mysql_num_rows($kkjs);
			$am = mysql_fetch_array($kkjs);
			$r = mysql_query("SELECT * FROM blocked WHERE bid = '{$_SESSION['myid']}' AND uid = '{$am['id']}'");
			$rma = mysql_num_rows($r);
			
			if($kma > '0' && $rma == '0'){
				if($am['messonoff'] == 0){
					$titlecheck = $_POST['messagetitle'];
					if(!$titlecheck){
						$b = 6;
					}
					elseif(stristr($titlecheck,'<') || stristr($titlecheck,'>') || stristr($titlecheck,'=') || stristr($titlecheck,';') || stristr($titlecheck,'(') || stristr($titlecheck,')')){
						$b = 5;
					}
					else{
						$illegal = 0;
						$temp = $_POST['messagetext'];
						if(stristr($temp, 'representative') || stristr($temp, 'change email') || stristr($temp, 'your password') || stristr($temp, 'ship staff') || stristr($temp, 'your email')){
							$ffs = 1;
							$x = 1;
						}
						else {
							$ffs = 0;
						}
					
						$my = mysql_query("INSERT INTO messages (time, subject, message, receiverid, receiverusername, senderid, senderusername, receiverdelete, senderdelete, receiverread, senderread, ffs) VALUES ('$time', '{$_POST['messagetitle']}', '{$_POST['messagetext']}', '{$am['id']}', '{$am['username']}', '{$_SESSION['myid']}', '{$_SESSION['myuser']}', '1', '{$keep}', '1', '1', '$ffs')");
					
						if($x != 1){
							mysql_query("INSERT INTO message_notify (id, sid, suser, subject, time) VALUES('{$am['id']}', '{$_SESSION['myid']}', '{$_SESSION['myuser']}', '{$_POST['messagetitle']}', '$time') ON DUPLICATE KEY UPDATE sid = '{$_SESSION['myid']}', suser = '{$_SESSION['myuser']}', subject = '{$_POST['messagetitle']}', time = '$time'");
						}
					}
				}
				
				if($am['messonoff'] == 1){
					$b = '4';
				}
				if($my){
					$b = '1';
				}
			}
		}
		if($kma == '0'){
			$b = '2';
		}
		if($rma > 0){
			$b = '24';
		}
	}
	if($_POST['send'] && !$_POST['messageusername'] || $_POST['send'] && !$_POST['messagetitle'] || $_POST['send'] && !$_POST['messagetext']){
		$b = '3';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/messages.js"></script>
<?php
if($_SESSION['layout'] == '1'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
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
<title>Pok&eacute;mon  v3 - Messages</title>
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
<div style="height:20px;width:100%;"></div>
<center>
<?php
echo date("l F d, Y, h:i A");
?>
</center>
<ul id="messageFunctions">
<li id="deletebutton"><a href="messages.php" id="delete" onclick="return false;"><em><img src="html/static/images/message/delete.png" title="Delete" alt="Delete"/></em></a></li>
<li id="forwardbutton"><a href="messages.php" id="forward" onclick="return false;"><em><img src="html/static/images/message/forward.png" title="Forward" alt="Forward"/></em></a></li>
<li id="replybutton"><a href="messages.php" id="reply" onclick="return false;"><em><img src="html/static/images/message/reply.png" title="Reply" alt="Reply"/></em></a></li>
</ul>
<div class="errorMsg"><strong>Notice:</strong> People who ask for your password or to change your email address in messages are not Pok&eacute;mon representatives and are trying to scam you out of your account. Please ignore these messages and <a href="http://forums.pokemon-shqipe.co.uk/index.php/forum/34-reports/" target="_BLANK">report</a> them to us. Remember, we <strong>never</strong> need your password under any circumstance.</div>

<ul id="messageTabs"><li><a href="messages.php?option=inbox" id="inboxTab" class="deselected" onclick="messageoption('inbox'); return false;"><em>Inbox</em></a></li><li><a href="messages.php?option=sent" id="sentTab" class="deselected" onclick="messageoption('sent'); return false;"><em>Sent</em></a></li><li><a href="messages.php?option=new" id="newMessageTab" class="<?=$rid4?>" onclick="messageoption('newMessage'); return false;"><em>New Message</em></a></li></ul><div style="height:28px; align: right; border-bottom: 2px solid #666666;"></div>



<div id="messageContainer"><div id="messageList" style="height:300px;"><div class="actionMsg">Please choose an option above. There are Inbox, sent messages, and new message to choose from.</div></div><div id="message" style="height:300px;">
<div id="messageContent">
<?php if($b == 1 || $b == 2 || $b == 3 || $b == 4 || $b == 9 || $b == 24 || $b == 5 || $b == 6){
	if($b == 6){
		echo '<div class="errorMsg">Your message title cannot be blank.</div>';
	}
	if($b == 5){
		echo '<div class="errorMsg">Your message contained characters not allowed. Message was <b>not</b> sent.</div>';
	}
	if($x == 1){
		$text = " This message, however was flagged for spam or scamming. It will be reviewed by an administrator, and will be sent accordingly if there is nothing wrong with it.";
	}
	if($b==24){
		echo '<div class="errorMsg">Message not sent - the user has blocked you.</div>';
	}
	if($b==9){
		echo '<div class="errorMsg">Flood control. You have tried to send more then one message in the past 30seconds.</div>';
	}
	if($b==1){
		echo "<div class=\"actionMsg\">Message Sent." . $text . "</div>";
	}
	if($b==2){
		echo "<div class=\"errorMsg\">Username does not exist! Message <b>NOT</b> sent.</div>";
	}
	if($b==3){
		echo "<div class=\"errorMsg\">All fields must be completed. Message <b>NOT</b> sent.</div>";
	}
	if($b==4){
		echo '<div class="errorMsg">Member appears to have the messages turned off.</div>';
	}
}
if($rid3){
	echo '
<div id="newMessage" style="height:300px;">
<form method="post" action="messages.php" onsubmit="return disableSubmitButton(this);return false;">
<table>
<tr>
<td>Username:</td>
<td><input type="text" id="messageusername" name="messageusername" size="30" value="'.htmlentities($rid3).'"></td>
</tr>
<tr>
<td>Title:</td>
<td><input type="text" id="messagetitle" name="messagetitle" size="30"></td>
</tr>
<tr>
<td valign="top">Message:</td>
<td><textarea name="messagetext" id="messagetext" rows="10" cols="60"></textarea></td>
</tr>
<tr>
<td>Save to Sent Items?<input type="checkbox" name="keep" id="keep" value="1"></td>
<td><input type="submit" name="send" value="Send"></td>
</tr>
</table>
</form>
</div>';
}
if(!$rid3 && !$b){
	echo "<h2>No message selected.</h2>";
} ?>
<br />
<br />
Click on a message subject to the left to view.
</div>
</div>
</div>
<?php include('disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php
}
else{
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
include('pv_disconnect_from_db.php');
?>