<?php
include('kick.php');

// CHECK THE USER IS LOGGED IN

if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}

// DATABASE CONNECTION

include('pv_connect_to_db.php');
$time = time();

// CHANGE THE USERS MESSAGE NOTIFICATION SETTINGS

if($_REQUEST['msg_notify']){
	$nug = '0';
	if($_REQUEST['msg_notify'] == 'off'){
		$nug = '1';
	}
	mysql_query("UPDATE members_options SET messnotifyonoff = '$nug' WHERE id = '{$_SESSION['myid']}'");
	$_SESSION['message_preferences'][0] = $nug;
	$qz = 15;
}
if($_REQUEST['messages']){
	if($_REQUEST['messages'] == 'on'){
		mysql_query("UPDATE members_options SET messonoff = '0' WHERE id = '{$_SESSION['myid']}'");
		$qz = 1;
	}
	if($_REQUEST['messages'] == 'off'){
		mysql_query("UPDATE members_options SET messonoff = '1' WHERE id = '{$_SESSION['myid']}'");
		$qz = 2;
	}
}

// CHANGE USERS LAYOUT SETTINGS

if($_REQUEST['layout']){
	/*
	*Uncomment the layout options when they're to be re-added to the games options.
	*They're currently disabled on v3 due to not being optimized for v3's larger content sections

	if($_REQUEST['layout'] == 'blue' && $_SESSION['layout'] == '0'){
		$la = mysql_query("UPDATE members_options SET layout = '1' WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['layout'] +=1;
	}
	if($_REQUEST['layout'] == 'blue' && $_SESSION['layout'] == '2'){
		$la = mysql_query("UPDATE members_options SET layout = '1' WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['layout'] -=1;
	}
	if($_REQUEST['layout'] == 'red' && $_SESSION['layout'] == '1'){
		$la = mysql_query("UPDATE members_options SET layout = '0' WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['layout'] -=1;
	}
	if($_REQUEST['layout'] == 'red' && $_SESSION['layout'] == '2'){
		$la = mysql_query("UPDATE members_options SET layout = '0' WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['layout'] -=2;
	}
	*/
	if($_REQUEST['layout'] == 'black' && $_SESSION['layout'] == '0'){
		$la = mysql_query("UPDATE members_options SET layout = '2' WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['layout'] +=2;
	}
	if($_REQUEST['layout'] == 'black' && $_SESSION['layout'] == '1'){
		$la = mysql_query("UPDATE members_options SET layout = '2' WHERE id = '{$_SESSION['myid']}'");
		$_SESSION['layout'] +=1;
	}
}

// CHANGE THE USERS PASSWORD

if(isset($_POST['update'])){
	$checkmem = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
	$checkmems = mysql_fetch_array($checkmem);
	$old = mysql_real_escape_string($_POST['oldPassword']);
	$old2 = md5($old);
	if($checkmems['password'] != $old2){ // IF THE OLD PASSWORD IS INCORRECT
		$_SESSION['var2'] = 2;
		header("location:your_profile.php?action=password");
	}
	else{ // CONTINUE IF THE OLD PASSWORD IS CORRECT
		if($_POST['password1'] == $_POST['password2']){ // CHECK IF THE NEW PASSWORDS MATCH
			$mypassword = $_POST['password1'];
			$mypassword = stripslashes(mysql_real_escape_string($mypassword));
			$rite = md5($mypassword); // ENCRYPT THE PASSWORD
			$_SESSION['v'] = 3;
			mysql_query("UPDATE members SET password = '$rite' WHERE id = '{$_SESSION['myid']}'"); // UPDATE THE PASSWORD
			mysql_query("UPDATE flashchat_users SET password = '$rite' WHERE id = '{$_SESSION['myid']}'"); // UPDATE CHAT PASSWORD
			header("location:your_profile.php?update=password");
		}
		else{
			$_SESSION['var2'] = 4; // IF THE PASSWORDS ARE NOT THE SAME
			header("location:your_profile.php?action=password");
		}
	}
}

// EDIT THE USERS PROFILE FIELDS

if($_POST['show']){
	if($_POST['sprite'] > 0 && $_POST['sprite'] < 29){ // CHECK THE USERS SPRITE IS VALID
		if(!strstr($_POST['email'],'@')){
			$ei = 1;
		}
		else{
			$string = mysql_real_escape_string($_POST['comments']); // PROTECT THE COMMENTS FIELD FROM SQLI
			$_POST['email'] = mysql_real_escape_string($_POST['email']); // PROTECT THE EMAIL FIELD FROM SQLI
			$_POST['sprite'] = mysql_real_escape_string($_POST['sprite']); // PROTECT THE SPRITE SELECTION FROM SQLI
			$_POST['skype'] = mysql_real_escape_string($_POST['skype']); // PROTECT THE SKYPE FIELD FROM SQLI
			$_POST['forum'] = mysql_real_escape_string($_POST['forum']); // PROTECT THE FORUM FIELD FROM SQLI
			$_POST['show'] = mysql_real_escape_string($_POST['show']); // PROTECT THE REQUEST FROM SQLI
		
			// UPDATE THE REQUESTED CHANGES
			
			mysql_query("UPDATE comments SET comment = '$string' WHERE userid = '{$_SESSION['myid']}'");
			$ema = mysql_query("UPDATE members SET email = '{$_POST['email']}' WHERE id = '{$_SESSION['myid']}'");
			mysql_query("UPDATE members_options SET trainer = '{$_POST['sprite']}', forum = '{$_POST['forum']}', skype = '{$_POST['skype']}', display = '{$_POST['show']}' WHERE id = '{$_SESSION['myid']}'");
			$_SESSION['map_preferences'][2] = $_POST['sprite'];
		}
	}
}

// GET THE CURRENT INFO TO DISPLAY THE PROFILE

$pro = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
$prof = mysql_fetch_array($pro);
$set = mysql_query("SELECT * FROM members_options WHERE id = '{$_SESSION['myid']}'");
$sett = mysql_fetch_array($set);
$ai = "SELECT * FROM comments WHERE userid ='{$_SESSION['myid']}'";;
$ai2 = mysql_query($ai);
$ai3 = mysql_fetch_array($ai2);

if(!$_REQUEST['ajax']){
	mysql_query("UPDATE online SET activity = 'Viewing their profile' WHERE id = '{$_SESSION['myid']}'");
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
    <script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
    <script type="text/javascript" src="html/static/js//v3/jquery.js"></script>
    <script type="text/javascript" src="html/static/js//v3/slimbox2.js"></script>
    <?php
	
	// DISPLAY THE USERS SELECTED LAYOUT
	
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
    <title>Pok&eacute;mon Shqipe v3 - View/Edit Your Profile</title>
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
$_REQUEST['action'] = mysql_real_escape_string($_REQUEST['action']);
if($_REQUEST['action'] == "edit"){
	
	// DISPLAY THE EDIT PROFILE PAGE
	
	?>

    <noscript><div class="noticeMsg">You will need to turn your javascript on to use many of the features when you're modifying your profile, however it can still be completed without it, if you wish.</div></noscript>
    <h2>Edit your profile:</h2><form name="edit" method="post" onsubmit="get('/your_profile.php', 'update=profile', this); disableSubmitButton(this); return false;">
    <center><table style="text-align: center;"><br/>
    <tr>
    <td width="20"><img src="html/static/images/sprites/top3.gif"><br/><img src="html/static/images/sprites/3.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="3" <?if($sett['trainer'] == 3){echo "checked='checked'";}?> /></td>
    <td width="20"><img src="html/static/images/sprites/top4.gif"><br/><img src="html/static/images/sprites/4.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="4" <?if($sett['trainer'] == 4){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top5.gif"><br/><img src="html/static/images/sprites/5.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="5" <?if($sett['trainer'] == 5){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top6.gif"><br/><img src="html/static/images/sprites/6.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="6" <?if($sett['trainer'] == 6){echo "checked='checked'";}?> /></td>
    <td width="20"><img src="html/static/images/sprites/top7.gif"><br/><img src="html/static/images/sprites/7.gif" align="middle"><br/><input type="radio" name="sprite" value="7" <?if($sett['trainer'] == 7){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top1.gif"><br/><img src="html/static/images/sprites/1.gif" align="middle"><br/><input type="radio" name="sprite" value="1" <?if($sett['trainer'] == 1){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top2.gif"><br/><img src="html/static/images/sprites/2.gif" align="middle"><br/><input type="radio" name="sprite" value="2" <?if($sett['trainer'] == 2){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top10.gif"><br/><img src="html/static/images/sprites/10.gif" align="middle"><br/><input type="radio" name="sprite" value="10" <?if($sett['trainer'] == 10){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top11.gif"><br/><img src="html/static/images/sprites/11.gif" align="middle"><br/><input type="radio" name="sprite" value="11" <?if($sett['trainer'] == 11){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top8.gif"><br/><img src="html/static/images/sprites/8.gif" align="middle"><br/><input type="radio" name="sprite" value="8" <?if($sett['trainer'] == 8){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top9.gif"><br/><img src="html/static/images/sprites/9.gif" align="middle"><br/><input type="radio" name="sprite" value="9" <?if($sett['trainer'] == 9){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top12.gif"><br/><img src="html/static/images/sprites/12.gif" align="middle"><br/><input type="radio" name="sprite" value="12" <?if($sett['trainer'] == 12){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top13.gif"><br/><img src="html/static/images/sprites/13.gif" align="middle"><br/><input type="radio" name="sprite" value="13" <?if($sett['trainer'] == 13){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top14.gif" align="middle"><br/><img src="html/static/images/sprites/14.gif" align="middle"><br/><input type="radio" name="sprite" value="14" align="middle" <?if($sett['trainer'] == 14){echo "checked='checked'";}?>/></td></tr></table>
    <table style="text-align: center;"><br/>
    <tr>
    <td width="20"><img src="html/static/images/sprites/top15.gif"><br/><img src="html/static/images/sprites/15.gif" align="middle"><br/><input type="radio" name="sprite" value="15" <?if($sett['trainer'] == 15){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top16.gif"><br/><img src="html/static/images/sprites/16.gif" align="middle"><br/><input type="radio" name="sprite" value="16" <?if($sett['trainer'] == 16){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top17.gif"><br/><img src="html/static/images/sprites/17.gif" align="middle"><br/><input type="radio" name="sprite" value="17" <?if($sett['trainer'] == 17){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top18.gif"><br/><img src="html/static/images/sprites/18.gif" align="middle"><br/><input type="radio" name="sprite" value="18" <?if($sett['trainer'] == 18){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top19.gif"><br/><img src="html/static/images/sprites/19.gif" align="middle"><br/><input type="radio" name="sprite" value="19" <?if($sett['trainer'] == 19){echo "checked='checked'";}?>/></td>
    <td width="20"><img src="html/static/images/sprites/top20.gif"><br/><img src="html/static/images/sprites/20.gif" align="middle"><br/><input type="radio" name="sprite" value="20" <?if($sett['trainer'] == 20){echo "checked='checked'";}?>/></td>
    <td width="21"><img src="html/static/images/sprites/top21.gif"><br/><img src="html/static/images/sprites/21.gif" align="middle"><br/><input type="radio" name="sprite" value="21" <?if($sett['trainer'] == 21){echo "checked='checked'";}?>/></td>
    <td width="22"><img src="html/static/images/sprites/top22.gif"><br/><img src="html/static/images/sprites/22.gif" align="middle"><br/><input type="radio" name="sprite" value="22" <?if($sett['trainer'] == 22){echo "checked='checked'";}?>/></td>
    <td width="23"><img src="html/static/images/sprites/top23.gif"><br/><img src="html/static/images/sprites/23.gif" align="middle"><br/><input type="radio" name="sprite" value="23" <?if($sett['trainer'] == 23){echo "checked='checked'";}?>/></td>
    <td width="24"><img src="html/static/images/sprites/top24.gif"><br/><img src="html/static/images/sprites/24.gif" align="middle"><br/><input type="radio" name="sprite" value="24" <?if($sett['trainer'] == 24){echo "checked='checked'";}?>/></td>
    <td width="25"><img src="html/static/images/sprites/top25.gif"><br/><img src="html/static/images/sprites/25.gif" align="middle"><br/><input type="radio" name="sprite" value="25" <?if($sett['trainer'] == 25){echo "checked='checked'";}?>/></td>
    <td width="26"><img src="html/static/images/sprites/top26.gif"><br/><img src="html/static/images/sprites/26.gif" align="middle"><br/><input type="radio" name="sprite" value="26" <?if($sett['trainer'] == 26){echo "checked='checked'";}?>/></td>
    <td width="27"><img src="html/static/images/sprites/top27.gif"><br/><img src="html/static/images/sprites/27.gif" align="middle"><br/><input type="radio" name="sprite" value="27" <?if($sett['trainer'] == 27){echo "checked='checked'";}?>/></td>
    <td width="28"><img src="html/static/images/sprites/top28.gif"><br/><img src="html/static/images/sprites/28.gif" align="middle"><br/><input type="radio" name="sprite" value="28" <?if($sett['trainer'] == 28){echo "checked='checked'";}?>/></td>


    </tr></table></center>
    <p><strong>Email Address: </strong></td><td><input type="text" name="email" value="<?=$prof['email']?>"></p>
    <p><strong>Skype Username: </strong></td><td><input type="text" name="skype" value="<?=$sett['skype']?>"></p>
    <p><strong>Forum Username: </strong></td><td><input type="text" name="forum" value="<?=$sett['forum']?>"></p>
    <p>Allow others to see your email address, Skype name, and Forum name?<br><input type="radio" name="show" value="Yes" <?php if($sett['display']=='Yes'){echo'checked="checked"';}?>> Yes <input type="radio" name="show" value="No" <?php if($sett['display']=='No'){echo'checked="checked"';}?>> No
    </p><p>
    <strong>Profile Comment</strong>
    
    
    <textarea id="comments" name="comments" wrap="physical" rows="4" cols="30"><?php echo $ai3['comment']; ?></textarea>
    </p>
    <br>
    <input type="submit" name="editsub" value="Update Profile" />
    </form>
	<?php
}
// DISPLAY THE CHANGE PASSWORD PAGE

elseif($_REQUEST['action'] == "password"){
	?>
    <h2>Change your password:</h2>
    <form name="changePassword" method="post">
    <table cellpadding="0" cellspacing="4" style="margin: 0 auto 0 auto;">
    <tr><td style="text-align: right;">
    <strong>Old Password:</strong>
    </td>
    <td style="text-align: left;">
    <input type="password" name="oldPassword" size="30" maxlength="30"<?php if($_SESSION['var2'] == 2){ ?> style="border:1px solid #E6524F;"<?php } ?> />
    <div class="errorBox" id="oldPasswordErrorBox"></div>
    </td></tr>
    <tr><td style="text-align: right;">
    <strong>New Password:</strong></td>
    <td style="text-align: left;">
    <input type="password" name="password1" size="30" maxlength="30"<?php if($_SESSION['var2'] == 4){ ?> style="border:1px solid #E6524F;"<?php } ?> /></td></tr>
    <tr><td style="text-align: right;"><strong>Re-Type New Password:</strong></td>
    <td style="text-align: left;"><input type="password" name="password2" size="30" maxlength="30"<?php if($_SESSION['var2'] == 4){ ?> style="border:1px solid #E6524F;"<?php } ?> />
    </td></tr>
    <?php if($_SESSION['var2'] == 2){ unset($_SESSION['var2']); ?><font color="#E6524F">Password entered did not match your old one.</font><?php } ?><?php if($_SESSION['var2'] == 4){ unset($_SESSION['var2']); ?><font color="#E6524F">New passwords did not match.</font><?php } ?>
    <tr><td style="text-align: center;" colspan="2"><strong>
    <br />Remember my new password on this computer:</strong>
    <br /><input type="radio" name="rememberlogin" value="Yes" /> Yes &nbsp; <input type="radio" name="rememberlogin" value="No" checked="checked" /> No</td></tr>
    <tr><td style="text-align: center;" colspan="2"><br />
    <input type="hidden" name="action" value="update_password">
    <input type="submit" name="update" value="Update Password" />
    </table></form><br />
	<?php
}
else {
	if($_REQUEST['update'] == "password"){ // SUCCESSFUL PASSWORD CHANGE
		?>
        <div class="actionMsg">Password successfully changed.</div>
		<?php
	}
	if($_REQUEST['update'] == "profile" && $ema){ // SUCCESSFUL PROFILE UPDATE
		?>
        <div class="actionMsg">Profile successfully updated.</div>
		<?php
	}
	
	// REQUEST TO UPDATE THE USERS STATS
	
	if($_REQUEST['action'] == "update"){
		$sideright = mysql_query("SELECT uniques, battle, total_poke, totalexp FROM members WHERE id = '{$_SESSION['myid']}'");
		$sideright1 = mysql_fetch_array($sideright);

		$unique = $sideright1['uniques'];
		$totalexp = $sideright1['totalexp'];
		$avgexp = $totalexp / $sideright1['total_poke'] ;
		$battle = $sideright1['battle'];
		$p1 = sqrt($totalexp);
		$p2 = sqrt($avgexp);
		$p3 = sqrt($unique);
		$p4 = log($battle);
		$p5 = $p1 * $p2 * $p3 * $p4;
		$p6 = $p5 / 1000;
		$p7 = round($p6, 1);
		
		mysql_query("UPDATE members SET points = '{$p7}', uniques = '{$unique}', averageexp = '{$avgexp}', totalexp = '{$totalexp}' WHERE id = '{$_SESSION['myid']}'"); // UPDATE THE USERS STATS
		echo '<div class="actionMsg">Your stats have been successfully updated. Refreshing is needed.</div>';
	}
	
	if($sk){
		?>
		<div class="actionMsg">Skin choice successfully changed.</div>
		<?php
	}
	if($qz){
		?>
		<div class="actionMsg">Message choice successfully updated.</div>
		<?php
	}
	if($la){
		?>
		<div class="actionMsg">Layout choice successfully changed.</div>
		<?php
	}
	if($ei){
		?>
		<div class="errorMsg">You did not enter a valid Email address</div>
		<?php
	}
	?>
    <div style="width: 600px; margin: 0 auto 0 auto;">
    <h2>Your Profile:</h2>
    <p class="optionsList">
    <!-- <a href="/your_profile.php?action=update" onclick="get('/your_profile.php','action=update');return false;" class="deselected">Update Stats</a> | --><a href="/your_profile.php?action=edit" onclick="get('/your_profile.php','action=edit'); return false;" class="deselected">Edit your profile</a> | <a href="/your_profile.php?action=password" onclick="get('/your_profile.php','action=password'); return false;" class="deselected">Change your password</a></p>
    <div style="text-align: left;" id="profile">
    <div style="text-align: center; float: right; width: 150px;">
    
	<?php
	
	// DISPLAY THE USERS ACCOUNT OPTIONS
	
	$qw = 'deselected';
	$wq = 'selected';
	if($prof['messonoff']==1){ // MESSAGES
		$qw = 'selected';
		$wq = 'deselected';
	}
	
	$rw ='deselected';
	$wr = 'selected';
	if($prof['messnotifyonoff'] == 1){ // MESSAGE NOTIFICATIONS
		$rw ='selected';
		$wr = 'deselected';
	}
	
	$red = 'deselected';
	$blue = 'selected';
	$black = 'deselected';
	if($_SESSION['layout'] == '0'){ // RED LAYOUT
		$red = 'selected';
		$blue = 'deselected';
		$black = 'deselected';
	}
	elseif($_SESSION['layout'] == '2'){ // BLACK LAYOUT
		$red = 'deselected';
		$blue = 'deselected';
		$black = 'selected';
	}
	?>
<h3>Options:</h3><p class="optionsList">Allow Messages:<br/><a href="/your_profile.php?messages=on" onclick="get('/your_profile.php','messages=on'); return false;" class="<?=$wq?>">On</a> | <a href="/your_profile.php?messages=off" onclick="get('/your_profile.php','messages=off'); return false;" class="<?=$qw?>">Off</a>


<br /><br />Show New Message<br />Notifications:<br /><a href="/your_profile.php?msg_notify=on" onclick="get('/your_profile.php','msg_notify=on'); return false;" class="<?=$wr?>">On</a> | <a href="/your_profile.php?msg_notify=off" onclick="get('/your_profile.php','msg_notify=off'); return false;" class="<?=$rw?>">Off</a><br />&nbsp;

<br />Change Layout:<br /><a href="/your_profile.php?layout=blue" onclick="get('/your_profile.php','layout=blue'); return false;" class="<?=$blue?>"><s>Blue</s></a> | <a href="/your_profile.php?layout=red" onclick="get('/your_profile.php','layout=red'); return false;" class="<?=$red?>"><s>Red</s></a> | <a href="/your_profile.php?layout=black" onclick="get('/your_profile.php','layout=black'); return false;" class="<?=$black?>">Black</a><br />&nbsp;

</div>
<p><strong>Sprite:</strong> <img style="vertical-align:middle;" src="html/static/images/sprites/<?=$sett['trainer']?>whole.gif"> </p>
<p><strong>Email Address:</strong> <?php echo $prof['email']; if($prof['display'] == "No"){ ?> (Hidden)<?php } ?><br />
<strong>Skype Username:</strong> <?php echo $sett['skype']; if($sett['display'] == "No"){ ?> (Hidden)<?php } ?><br />
<strong>Forum Username:</strong> <?php echo $sett['forum']; if($sett['display'] == "No"){ ?> (Hidden)<?php } ?></p>
<p><strong>Wins/Losses:</strong> <?php echo number_format($prof['battle']); ?> / <?php echo number_format($prof['losses']); ?><br />

<strong>Points:</strong> <?php echo number_format($prof['points'], 1); ?><br />
<strong>Unique Pokemon:</strong> <?php echo number_format($prof['uniques']); ?> / 5,394<br />
<strong>Total Experience:</strong> <?php echo number_format($prof['totalexp']); ?><br />
<strong>Average Experience:</strong> <?php echo number_format(round($prof['averageexp'])); ?><br />
<strong>Money:</strong> <img src="html/static/images/misc/pmoney.gif" align="absmiddle"><?php echo number_format($prof['money']); ?><br />
<strong>Date Registered:</strong> <?php echo date("F d, Y", $prof['registered']); ?></p>

<strong>Comments:</strong><br />
<?php
$code = htmlentities($ai3['comment']);
$pattern[0] = '/\[url=(.*?)\](.*?)\[\/url\]/i';
$replace[0] = '<a href="$1">$2</a>';
$pattern[1] = '/\[color=(.*?)\](.*?)\[\/color\]/i';
$replace[1] = '<span style="color:$1">$2</span>';
$pattern[2] = '/\[font=(.*?)\](.*?)\[\/font\]/i';
$replace[2] = '<font face="color:$1">$2</font>';
$code2 = preg_replace($pattern, $replace, $code);
$replace = array("Damn","Cock","Dick","Bitch","Shit","Fuck","fuck","bitch","damn","shit","cock","dick","[u]","[/u]","[i]","[/i]","[b]","[/b]","[s]","[/s]","[sub]","[/sub]","[sup]","[/sup]","[quote]","[/quote]");
$with = array("****","****","****","*****","****","****","****","*****","****","****","****","****","<u>","</u>","<i>","</i>","<b>","</b>","<s>","</s>","<sub>","</sub>","<sup>","</sup>","<blockquote style=\"border:1px solid #990000;background-color:Ivory;padding:1px;\"><center><strong>&#8220;</strong>","<strong>&#8221;</strong></center></blockquote>");
$newcode = str_replace($replace, $with, $code2);
echo nl2br($newcode); ?></p></div>

<?php

// DISPLAY THE USERS BADGES

$bad = mysql_query("SELECT * FROM badges WHERE id = '{$_SESSION['myid']}'"); // Get gym badge info
$ad = mysql_fetch_array($bad);
$acc = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'"); // Get member info
$ac = mysql_fetch_array($acc);
$eve = mysql_query("SELECT * FROM events WHERE id = '{$_SESSION['myid']}'"); // Get event badge info
$ev = mysql_fetch_array($eve);
if($_SESSION['map_preferences'][0] == '1'){
	echo '<div class="actionMsg">Your collected badges have unlocked the ability to encounter legendary Pok&eacute;mon on the maps.</div>';
}
else{
	echo '<div class="noticeMsg">You have not yet collected enough badges to encounter legendary Pok&eacute;mon on the maps.</div>';
}
?>
<table width="600" style="text-align:left;"><tr><td style="vertical-align: top; width:200px;">

<!-- Kanto badges -->

<p><strong>Indigo League Badges:</strong><ul style="line-height: 150%">
<?php if($ad['g1'] == 1){?>
<li>Boulder <img src="html/static/images/badges/boulder.gif" align="absmiddle" /></li>
<?php } if($ad['g2'] == 1){?>
<li>Cascade <img src="html/static/images/badges/cascade.gif" align="absmiddle" /></li>
<?php } if($ad['g3'] == 1){?>
<li>Thunder <img src="html/static/images/badges/thunder.gif" align="absmiddle" /></li>
<?php } if($ad['g4'] == 1){?>
<li>Rainbow <img src="html/static/images/badges/rainbow.gif" align="absmiddle" /></li>
<?php } if($ad['g5'] == 1){?>
<li>Marsh <img src="html/static/images/badges/marsh.gif" align="absmiddle" /></li>
<?php } if($ad['g6'] == 1){?>
<li>Soul <img src="html/static/images/badges/soul.gif" align="absmiddle" /></li>
<?php } if($ad['g7'] == 1){?>
<li>Volcano <img src="html/static/images/badges/volcano.gif" align="absmiddle" /></li>
<?php } if($ad['g8'] == 1){?>
<li>Earth <img src="html/static/images/badges/earth.gif" align="absmiddle" /></li>
<?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Orange Island badges -->

<p><strong>Orange Island Badges:</strong><ul style="line-height: 150%">
<?php if($ad['g9'] == 1){?>
<li>Coral-Eye <img src="html/static/images/badges/coral.gif" align="absmiddle" /></li>
<?php } if($ad['g10'] == 1){?>
<li>Sea Ruby <img src="html/static/images/badges/ruby.gif" align="absmiddle" /></li>
<?php } if($ad['g11'] == 1){?>
<li>Spike Shell <img src="html/static/images/badges/spike.gif" align="absmiddle" /></li>
<?php } if($ad['g12'] == 1){?>
<li>Jade Star <img src="html/static/images/badges/jade.gif" align="absmiddle" /></li>
<?php } if($ad['g13'] == 1){?>
<li>Winners Trophy <img src="html/static/images/badges/winners trophy.gif" align="absmiddle" /></li>
<?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Johto badges -->

<p><strong>Johto League Badges:</strong><ul style="line-height: 150%">
<?php if($ad['g14'] == 1){?>
<li>Zephyr <img src="html/static/images/badges/zephyr.gif" align="absmiddle" /></li>
<?php } if($ad['g15'] == 1){?>
<li>Hive <img src="html/static/images/badges/hive.gif" align="absmiddle" /></li>
<?php } if($ad['g16'] == 1){?>
<li>Plain <img src="html/static/images/badges/plain.gif" align="absmiddle" /></li>
<?php } if($ad['g17'] == 1){?>
<li>Fog <img src="html/static/images/badges/fog.gif" align="absmiddle" /></li>
<?php } if($ad['g18'] == 1){?>
<li>Storm <img src="html/static/images/badges/storm.gif" align="absmiddle" /></li>
<?php } if($ad['g19'] == 1){?>
<li>Mineral <img src="html/static/images/badges/mineral.gif" align="absmiddle" /></li>
<?php } if($ad['g20'] == 1){?>
<li>Glacier <img src="html/static/images/badges/glacier.gif" align="absmiddle" /></li>
<?php } if($ad['g21'] == 1){?>
<li>Rising <img src="html/static/images/badges/rising.gif" align="absmiddle" /></li><?php } ?></ul></p></td></tr><tr><td style="vertical-align: top; width:200px;">

<!-- Hoenn badges -->

<p><strong>Hoenn League Badges:</strong><ul style="line-height: 150%">
<?php if($ad['g22'] == 1){?>
<li>Stone <img src="html/static/images/badges/stone.gif" align="absmiddle" /></li>
<?php } if($ad['g23'] == 1){?>
<li>Knuckle <img src="html/static/images/badges/knuckle.gif" align="absmiddle" /></li>
<?php } if($ad['g24'] == 1){?>
<li>Dynamo <img src="html/static/images/badges/dynamo.gif" align="absmiddle" /></li>
<?php } if($ad['g25'] == 1){?>
<li>Heat <img src="html/static/images/badges/heat.gif" align="absmiddle" /></li>
<?php } if($ad['g26'] == 1){?>
<li>Balance <img src="html/static/images/badges/balance.gif" align="absmiddle" /></li>
<?php } if($ad['g27'] == 1){?>
<li>Feather <img src="html/static/images/badges/feather.gif" align="absmiddle" /></li>
<?php } if($ad['g28'] == 1){?>
<li>Mind <img src="html/static/images/badges/mind.gif" align="absmiddle" /></li>
<?php } if($ad['g64'] == 1){?>
<li>Rain <img src="html/static/images/badges/rain.gif" align="absmiddle" /></li>
<?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Sinnoh badges -->

<p><strong>Sinnoh League Badges:</strong><ul style="line-height: 150%">
<?php if($ad['g30'] == 1){?>
<li>Coal <img src="html/static/images/badges/coal.gif" align="absmiddle" /></li>
<?php } if($ad['g31'] == 1){?>
<li>Forest <img src="html/static/images/badges/forest.gif" align="absmiddle" /></li>
<?php } if($ad['g32'] == 1){?>
<li>Cobble <img src="html/static/images/badges/cobble.gif" align="absmiddle" /></li>
<?php } if($ad['g33'] == 1){?>
<li>Fen <img src="html/static/images/badges/fen.gif" align="absmiddle" /></li>
<?php } if($ad['g34'] == 1){?>
<li>Relic <img src="html/static/images/badges/relic.gif" align="absmiddle" /></li>
<?php } if($ad['g35'] == 1){?>
<li>Mine <img src="html/static/images/badges/mine.gif" align="absmiddle" /></li>
<?php } if($ad['g36'] == 1){?>
<li>Icicle <img src="html/static/images/badges/icicle.gif" align="absmiddle" /></li>
<?php } if($ad['g37'] == 1){?>
<li>Beacon <img src="html/static/images/badges/beacon.gif" align="absmiddle" /></li>
<?php }?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Unova badges -->

<p><strong>Unova League Badges:</strong><ul style="line-height: 150%">
<?php if($ad['g38'] == 1){?>
<li>Basic <img src="html/static/images/badges/basic.gif" align="absmiddle" /></li>
<?php } if($ad['g39'] == 1){?>
<li>Toxic <img src="html/static/images/badges/toxic.gif" align="absmiddle" /></li>
<?php } if($ad['g40'] == 1){?>
<li>Beetle <img src="html/static/images/badges/beetle.gif" align="absmiddle" /></li>
<?php } if($ad['g41'] == 1){?>
<li>Bolt <img src="html/static/images/badges/bolt.gif" align="absmiddle" /></li>
<?php } if($ad['g42'] == 1){?>
<li>Quake <img src="html/static/images/badges/quake.gif" align="absmiddle" /></li>
<?php } if($ad['g43'] == 1){?>
<li>Jet <img src="html/static/images/badges/jet.gif" align="absmiddle" /></li>
<?php } if($ad['g44'] == 1){?>
<li>Legend <img src="html/static/images/badges/legend.gif" align="absmiddle" /></li>
<?php } if($ad['g45'] == 1){?>
<li>Wave <img src="html/static/images/badges/wave.gif" align="absmiddle" /></li>
<?php }?></ul></td></tr><tr><td style="vertical-align: top; width:200px;">

<!-- Kalos badges -->
<p><strong>Kalos League Badges:</strong><ul style="line-height: 150%">
<?php if($ad['g79'] == 1){?>
<li>Bug <img src="html/static/images/badges/bug.gif" align="absmiddle" /></li>
<?php } if($ad['g80'] == 1){?>
<li>Cliff <img src="html/static/images/badges/cliff.gif" align="absmiddle" /></li>
<?php } if($ad['g81'] == 1){?>
<li>Rumble <img src="html/static/images/badges/rumble.gif" align="absmiddle" /></li>
<?php } if($ad['g82'] == 1){?>
<li>Plant <img src="html/static/images/badges/plant.gif" align="absmiddle" /></li>
<?php } if($ad['g83'] == 1){?>
<li>Voltage <img src="html/static/images/badges/voltage.gif" align="absmiddle" /></li>
<?php } if($ad['g84'] == 1){?>
<li>Fairy <img src="html/static/images/badges/fairy.gif" align="absmiddle" /></li>
<?php } if($ad['g85'] == 1){?>
<li>Psychic <img src="html/static/images/badges/psychic.gif" align="absmiddle" /></li>
<?php } if($ad['g86'] == 1){?>
<li>Iceberg <img src="html/static/images/badges/iceberg.gif" align="absmiddle" /></li>
<?php }?></ul></td><td style="vertical-align: top; width:200px;">

<!-- Hoenn battle frontier -->

<p><strong>Hoenn Frontier Symbols:</strong><ul style="line-height: 150%">
<?php if($ad['g67'] == 1){?>
<li>Ability <img src="html/static/images/badges/ability symbol.gif" /></li>
<?php } if($ad['g68'] == 1){?>
<li>Spirit <img src="html/static/images/badges/spirit symbol.gif" /></li>
<?php } if($ad['g69'] == 1){?>
<li>Knowledge <img src="html/static/images/badges/knowledge symbol.gif" /></li>
<?php } if($ad['g70'] == 1){?>
<li>Brave <img src="html/static/images/badges/brave symbol.gif" /></li>
<?php } if($ad['g71'] == 1){?>
<li>Tactics <img src="html/static/images/badges/tactics symbol.gif" /></li>
<?php } if($ad['g72'] == 1){?>
<li>Guts <img src="html/static/images/badges/guts symbol.gif" /></li>
<?php } if($ad['g73'] == 1){?>
<li>Luck <img src="html/static/images/badges/luck symbol.gif" /></li><?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Sinnoh battle frontier -->

<p><strong>Sinnoh Frontier Symbols:</strong><ul style="line-height: 150%">
<?php if($ad['g74'] == 1){?>
<li>Palmer <img src="html/static/images/badges/palmer symbol.gif" /></li>
<?php } if($ad['g75'] == 1){?>
<li>Thorton <img src="html/static/images/badges/thorton symbol.gif" /></li>
<?php } if($ad['g76'] == 1){?>
<li>Dahlia <img src="html/static/images/badges/dahlia symbol.gif" /></li>
<?php } if($ad['g77'] == 1){?>
<li>Darach <img src="html/static/images/badges/darach symbol.gif" /></li>
<?php } if($ad['g78'] == 1){?>
<li>Argenta <img src="html/static/images/badges/argenta symbol.gif" /></li><?php } ?></ul></p></td></tr><tr><td style="vertical-align: top; width:200px;">


<!-- Kanto & Johto elite 4s -->

<p><strong>Indigo/Johto Elite Four:</strong><ul style="line-height: 150%">
<?php if($ad['g46'] == 1){?><li>Will</li>
<?php } if($ad['g47'] == 1){?><li>Koga</li>
<?php } if($ad['g48'] == 1){?><li>Bruno</li>
<?php } if($ad['g49'] == 1){?><li>Karen</li><?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Hoenn elite 4s -->

<p><strong>Hoenn Elite Four:</strong><ul style="line-height: 150%">
<?php if($ad['g50'] == 1){?><li>Sidney</li>
<?php } if($ad['g51'] == 1){?><li>Phoebe</li>
<?php } if($ad['g52'] == 1){?><li>Glacia</li>
<?php } if($ad['g53'] == 1){?><li>Drake</li><?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Sinnoh elite 4s -->

<p><strong>Sinnoh Elite Four:</strong><ul style="line-height: 150%">
<?php if($ad['g54'] == 1){?><li>Aaron</li>
<?php } if($ad['g55'] == 1){?><li>Bertha</li>
<?php } if($ad['g56'] == 1){?><li>Flint</li>
<?php } if($ad['g57'] == 1){?><li>Lucian</li><?php } ?></ul></p></td></tr><tr><td style="vertical-align: top; width:200px;">

<!-- Unova elite 4s -->

<p><strong>Unova Elite Four:</strong><ul style="line-height: 150%">
<?php if($ad['g58'] == 1){?><li>Shauntal</li>
<?php } if($ad['g59'] == 1){?><li>Grimsley</li>
<?php } if($ad['g60'] == 1){?><li>Caitlin</li>
<?php } if($ad['g61'] == 1){?><li>Marshal</li><?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Kalos elite 4s -->

<p><strong>Kalos Elite Four:</strong><ul style="line-height: 150%">
<?php if($ad['g87'] == 1){?><li>Malva</li>
<?php } if($ad['g88'] == 1){?><li>Wikstrom</li>
<?php } if($ad['g89'] == 1){?><li>Drasna</li>
<?php } if($ad['g90'] == 1){?><li>Siebold</li><?php } ?></ul></p></td><td style="vertical-align: top; width:200px;">

<!-- Kalos Battle Maison -->

<p><strong>Kalos Battle Maison:</strong><ul style="line-height: 150%">
<?php if($ad['g92'] == 1){?><li>Chatelaine Nita</li>
<?php } if($ad['g93'] == 1){?><li>Chatelaine Evelyn</li>
<?php } if($ad['g94'] == 1){?><li>Chatelaine Dana</li>
<?php } if($ad['g95'] == 1){?><li>Chatelaine Morgan</li><?php } ?></ul></p></td></tr><tr><td style="vertical-align: top; width:200px;">

<!-- Champions -->

<p><strong>Champions Defeated:</strong><ul style="line-height: 150%">
<?php if($ad['g62'] == 1){?><li>Blue</li>
<?php } if($ad['g63'] == 1){?><li>Lance</li>
<?php } if($ad['g29'] == 1){?><li>Wallace</li>
<?php } if($ad['g65'] == 1){?><li>Cynthia</li>
<?php } if($ad['g66'] == 1){?><li>Iris</li>
<?php } if($ad['g91'] == 1){?><li>Diantha</li><?php } ?></ul></p></td></tr></table>

<!-- Events -->

<p><center><strong>Events:</strong></p>
<?php if($ev['g31'] == 1){?> <img src="html/static/images/specialbadges/santabadge.gif" TITLE="Christmas 2014" /><?php } ?>
<?php if($ev['g38'] == 1){?> <img src="html/static/images/specialbadges/halloween2014.gif" TITLE="Halloween 2014" /><?php } ?>
<?php if($ev['g1'] == 1 && $ev['g2'] == 1 && $ev['g3'] == 1 && $ev['g4'] == 1 && $ev['g5'] == 1){?> <img src="html/static/images/specialbadges/rocket.gif" TITLE="Team Rocket" /><?php } ?>
<?php if($ev['g6'] == 1 && $ev['g7'] == 1 && $ev['g8'] == 1 && $ev['g9'] == 1 && $ev['g10'] == 1){?> <img src="html/static/images/specialbadges/aqua.gif" TITLE="Team Aqua" /><?php } ?>
<?php if($ev['g11'] == 1 && $ev['g12'] == 1 && $ev['g13'] == 1 && $ev['g14'] == 1 && $ev['g15'] == 1){?> <img src="html/static/images/specialbadges/magma.gif" TITLE="Team Magma" /><?php } ?>
<?php if($ev['g16'] == 1 && $ev['g17'] == 1 && $ev['g18'] == 1 && $ev['g19'] == 1 && $ev['g20'] == 1){?> <img src="html/static/images/specialbadges/galactic.gif" TITLE="Team Galactic" /><?php } ?>
<?php if($ev['g21'] == 1 && $ev['g22'] == 1 && $ev['g23'] == 1 && $ev['g24'] == 1){?> <img src="html/static/images/specialbadges/plasma.gif" TITLE="Team Plasma" /><?php } ?>
<?php if($ev['g32'] == 1 && $ev['g33'] == 1 && $ev['g34'] == 1 && $ev['g35'] == 1 && $ev['g36'] == 1 && $ev['g37'] == 1){?> <img src="html/static/images/specialbadges/flare.gif" TITLE="Team Flare" /><?php } ?>
<?php if($ev['g26'] == 1 && $ev['g27'] == 1){?> <img src="html/static/images/specialbadges/admins.gif" TITLE="Pok&eacute;mon Shqipe Admins" /><?php } ?>
<?php if($ev['g28'] == 1){?> <img src="html/static/images/specialbadges/xd.gif" TITLE="Cipher" /><?php } ?>
<?php if($ev['g29'] == 1){?> <img src="html/static/images/specialbadges/gordor.gif" TITLE="Gordor" /><?php } ?>
<?php if($ev['g30'] == 1){?> <img src="html/static/images/specialbadges/pokemon4ever.gif" TITLE="Iron-Masked Marauder" /><?php } ?></center>






<center><p><strong>Achievements:</strong><p>
<u>Wins:</u><br><?php if($ac['battle'] >= 100){?><img src="html/static/images/achievements/v3/100wins.gif" TITLE="100 Wins" />
<?php } if($ac['battle'] >= 250){?><img src="html/static/images/achievements/v3/250wins.gif" TITLE="250 Wins" />
<?php } if($ac['battle'] >= 500){?><img src="html/static/images/achievements/v3/500wins.gif" TITLE="500 Wins" />
<?php } if($ac['battle'] >= 1000){?><img src="html/static/images/achievements/v3/1000wins.gif" TITLE="1,000 Wins" />
<?php } if($ac['battle'] >= 10000){?><img src="html/static/images/achievements/v3/10000wins.gif" TITLE="10,000 Wins" />
<?php } ?>
<br><u>Unique Pokemon:</u><br><?php if($ac['uniques'] >= 1000){?><img src="html/static/images/achievements/v3/1000uniques.gif" TITLE="1,000 Unique Pok&eacute;mon" />
<?php } if($ac['uniques'] >= 2000){?><img src="html/static/images/achievements/v3/2000uniques.gif" TITLE="2,000 Unique Pok&eacute;mon" />
<?php } if($ac['uniques'] >= 3000){?><img src="html/static/images/achievements/v3/3000uniques.gif" TITLE="3,000 Unique Pok&eacute;mon" />
<?php } if($ac['uniques'] >= 4000){?><img src="html/static/images/achievements/v3/4000uniques.gif" TITLE="4,000 Unique Pok&eacute;mon" />
<?php } if($ac['uniques'] >= 5394){?><img src="html/static/images/achievements/v3/completedex.gif" TITLE="Complete Pok&eacute;dex" />
<?php } ?>
<br><u>Experience:</u><br><?php if($ac['totalexp'] >= 10000000){?><img src="html/static/images/achievements/v3/10milexp.gif" TITLE="10,000,000 Experience" />
<?php } if($ac['totalexp'] >= 50000000){?><img src="html/static/images/achievements/v3/50milexp.gif" TITLE="50,000,000 Experience" />
<?php } if($ac['totalexp'] >= 100000000){?><img src="html/static/images/achievements/v3/100milexp.gif" TITLE="100,000,000 Experience" />
<?php } if($ac['totalexp'] >= 200000000){?><img src="html/static/images/achievements/v3/200milexp.gif" TITLE="200,000,000 Experience" />
<?php } if($ac['totalexp'] >= 500000000){?><img src="html/static/images/achievements/v3/500milexp.gif" TITLE="500,000,000 Experience" />
<?php } if($ac['averageexp'] >= 100000){?><img src="html/static/images/achievements/v3/100000avexp.gif" TITLE="100,000 Average Experience" />
<?php } if($ac['averageexp'] >= 200000){?><img src="html/static/images/achievements/v3/200000avexp.gif" TITLE="200,000 Average Experience" />
<?php } if($ac['averageexp'] >= 500000){?><img src="html/static/images/achievements/v3/500000avexp.gif" TITLE="500,000 Average Experience" />
<?php } ?>
<br><u>Badges:</u><br><?php if($ac['badges'] == 1){?><img src="html/static/images/achievements/v3/leaguechampion.gif" TITLE="All Gyms & Elite 4's Complete" />
<?php } if($ad['g68'] == 1 && $ad['g69'] == 1 && $ad['g70'] == 1 && $ad['g71'] == 1 && $ad['g72'] == 1 && $ad['g73'] == 1 && $ad['g74'] == 1){?><img src="html/static/images/achievements/v3/hoennfrontier.gif" TITLE="Hoenn Battle Frontier Complete" />
<?php } if($ad['g75'] == 1 && $ad['g76'] == 1 && $ad['g77'] == 1 && $ad['g78'] == 1 && $ad['g79'] == 1){?><img src="html/static/images/achievements/v3/sinnohfrontier.gif" TITLE="Sinnoh Battle Frontier Complete" />
<?php } if($ac['sidequest'] >= 103){?><img src="html/static/images/achievements/v3/kantosidequests.gif" TITLE="Kanto Sidequest Complete" />
<?php } if($ac['sidequest'] >= 207){?><img src="html/static/images/achievements/v3/johtosidequests.gif" TITLE="Johto Sidequest Complete" />
<?php } if($ac['sidequest'] >= 308){?><img src="html/static/images/achievements/v3/seviiislandssidequests.gif" TITLE="Sevii Islands Sidequest Complete" />
<?php } if($ac['sidequest'] >= 362){?><img src="html/static/images/achievements/v3/tcgsidequests.gif" TITLE="TCG Sidequests Complete" />
<?php } if($ac['sidequest'] >= 483){?><img src="html/static/images/achievements/v3/orangeislandssidequests.gif" TITLE="Orange Islands Sidequests Complete" />
<?php } if($ac['sidequest'] >= 696){?><img src="html/static/images/achievements/v3/hoennsidequests.gif" TITLE="Hoenn Sidequests Complete" />
<?php } ?>

<br><u>Points:</u><br><?php if($ac['points'] > 1000){?><img src="html/static/images/achievements/v3/1000points.gif" TITLE="1,000 Points" />
<?php } if($ac['points'] > 10000){?><img src="html/static/images/achievements/v3/10000points.gif" TITLE="10,000 Points" />
<?php } if($ac['points'] > 100000){?><img src="html/static/images/achievements/v3/100000points.gif" TITLE="100,000 Points" />
<?php } if($ac['points'] > 200000){?><img src="html/static/images/achievements/v3/200000points.gif" TITLE="200,000 Points" /><?php } ?>
<br><u>Extras:</u><br><?php if($ac['lotto'] == 1){?><img src="html/static/images/achievements/v3/lottowinner.gif" TITLE="Lottery Winner" />
<?php } if($ac['events'] == 1){?><img src="html/static/images/achievements/v3/events.gif" TITLE="All Events Complete" />
<?php } if($ac['donator'] == 1){?><img src="html/static/images/achievements/v3/donator.gif" TITLE="Pok&eacute;mon Shqipe Donor" />
<?php } if($ac['money'] >= 1000000){?><img src="html/static/images/achievements/v3/millionaire.gif" TITLE="Millionaire" />
<?php } ?></p><br>
</div>
<?php } 
if(!$_REQUEST['ajax']){
	echo '</div>';
	include('/var/www/html/v3/disclaimer.php');
	?>
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
include('pv_disconnect_from_db.php');
?>