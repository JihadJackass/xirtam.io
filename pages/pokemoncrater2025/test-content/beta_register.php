<?php
header('location:/');
include('pv_connect_to_db1.php');
if($_POST['action'] == 'send'){
	// PROTECT THE DATA
	$game_name = mysql_real_escape_string($_POST['username']);
	$forum_name = mysql_real_escape_string($_POST['forum']);
	$email = mysql_real_escape_string($_POST['email']);
	$active = mysql_real_escape_string($_POST['active']);
	$gameactive = mysql_real_escape_string($_POST['gameactive']);
	$accounts = mysql_real_escape_string($_POST['accounts']);
	$age = mysql_real_escape_string($_POST['age']);
	$reason = mysql_real_escape_string($_POST['reason']);
	$previous = mysql_real_escape_string($_POST['previous']);
	$games = mysql_real_escape_string($_POST['games']);
	if($game_name == '' || $forum_name == '' || $email == '' || $active == '' || $gameactive == '' || $accounts == '' || $age == '' || $reason == '' || $previous == ''){
		$error = 1;
	}
	else if($previous == 'Yes' && $games == ''){
		$error = 2;
	}
	else {
		mysql_query("INSERT INTO `beta_test` ( `username` , `forum_name` , `email` , `active` , `play_time` , `account_count` , `age` , `reason` , `previous` , `games`) VALUES ('$game_name', '$forum_name', '$email', '$active', '$gameactive', '$accounts', '$age', '$reason', '$previous', '$games')");
		$sent = 1;
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
<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/black/home.css" media="screen" />
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie6-.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie7+.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie7+.css" media="screen" />
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="shortcut icon" href="http://www.pokemonmastermania.zoomshare.com/files/pokeball_1_.gif" type="image/x-icon" />  
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>v3 Beta Register</title>
</head>

<body>
<div id="alert"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<iframe src="adv.php" width="728" height="90" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe></div>
<div id="title"><h1><a href="#"><em>Pokemonshqipe.co.uk</em></a></h1></div><ul id="homeNav"><li><a href="#" id="loginTab" class="selected"><em>Log In</em></a></li><li><a href="#" id="signupTab" class="deselected"><em>Sign Up</em></a></li><li><a href="#" id="aboutTab" class="deselected"><em>About Us / FAQ</em></a></li></ul>
</div>
<div id="contentContainer">
<div id="content">
<div id="loading"></div>
<div id="scroll">
<div id="showDetails"></div>
<div id="errorBox"></div>
<div id="rightbarContainer">
<div id="rightbarTop"></div>
<div id="rightbar">
<div id="rightbarContent">
<h4>Battle Arena:</h4>
<div class="hr"></div>
<p><a href="http://www.pokemon-shqipe.co.uk/login.php" class="s">Log In</a><br />
<a href="http://signup.php" class="s">Sign Up</a><br />
<a href="http://www.pokemon-shqipe.co.uk/" class="s">Version 2</a><br />
<a href="http://www.pokemon-shqipe.co.uk/contactus.php" class="s">Contact Us</a><br />
<a href="http://www.pokemon-shqipe.co.uk/about.php" class="s">About Us / FAQ</a><br />
<a href="http://www.pokemon-shqipe.co.uk/legal.php" class="s">Legal Info</a><br />
<a href="http://www.pokemon-shqipe.co.uk/credits.php" class="s">Credits</a></p>
<h4>Other Features:</h4>
<div class="hr"></div>
<p><a href="http://www.pokemon-shqipe.co.uk/index.php" class="s">Home/News</a><br />
<a href="http://www.pokemon-shqipe.co.uk/news.php" class="s">News Archive</a><br />
<a href="http://forums.pokemon-shqipe.co.uk/" class="s">Forums</a><br />
<a href="http://facebook.com/pokemon" class="s"> Facebook</a><br />
<a href="http://twitter.com/Pokemon_" class="s"> Twitter</a></p>
<div class="hr"></div>
<div style="text-align: center;">
<iframe src="adv.php?type=h" allowtransparency="true" scrolling="no" width="160" height="600" frameborder="0"></iframe>
</div>
</div></div><div id="rightbarBottom"></div>
</div>
<div id="scrollContent">
<div id="ajax">
<?php }
if($error == 1){ echo '<div class="errorMsg">Not all of the main fields were filled out.</div>'; }
if($error == 2){ echo '<div class="errorMsg">Please specify which games you have beta tested in</div>';}
if($sent == 1){ echo '<div class="actionMsg">Your beta test application has been submitted.<br />Thank you for applying.</div>';}
?>
<center><h2>Pok&eacute;mon  v3 Beta Test Register</h2>
<form action="beta_register.php" method="post" onsubmit="get('/beta_register.php', '', this); disableSubmitButton(this); return false;">
<strong>Game Username:</strong> <input type="text" name="username" id="username" maxlength="15"><p />
<strong>Forum Username:</strong> <input type="text" name="forum" id="forum" maxlength="15"><p />
<strong>Email Address:</strong> <input type="text" name="email" id="email" maxlength="30"><p />
<strong>Are you active on the forums?<br /></strong>
<input type="radio" name="active" id="active" value="Yes">Yes<br />
<input type="radio" name="active" id="active" value="No">No<p />
<strong>How often do you play Pok&eacute;mon ?<br /></strong>
<input type="radio" name="gameactive" id="gameactive" value="Less than 1 hour">Less than 1 hour per week<br />
<input type="radio" name="gameactive" id="gameactive" value="1 to 3 hours">1 - 3 hours per week<br />
<input type="radio" name="gameactive" id="gameactive" value="4 to 8 hours">4 - 8 hours per week<br />
<input type="radio" name="gameactive" id="gameactive" value="9 to 15 hours">9 - 15 hours per week<br />
<input type="radio" name="gameactive" id="gameactive" value="over 15 hours">Over 15 hours per week<p />
<strong>How many game accounts do you have on Pok&eacute;mon ?</strong> <input type="text" name="accounts" id="accounts" maxlength="3" size=3"><p />
<strong>How old are you?</strong> <input type="text" name="age" id="age" maxlength="2" size="2"><p />
<strong>Why do you feel you would be a good Beta tester for Pok&eacute;mon  v3?</strong><br />
<textarea name="reason" cols="40" rows="10" class="textbox" id="reason" maxlength="200"></textarea><p />
<strong>Do you have previous beta testing experience in a game?<br /></strong>
<input type="radio" name="previous" id="previous" value="Yes">Yes<br />
<input type="radio" name="previous" id="previous" value="No">No<p />
<strong>If you answered yes in the previous question, please write the game(s) you beta tested below</strong><br />
<textarea name="games" cols="40" rows="10" class="textbox" id="games" maxlength="150"></textarea><p />
<p style="text-align: center";><input type="hidden" name="action" value="send" /><input type="submit" name="submit" value="Send" /></p>
</form>
</div>

<?php
if(!$_REQUEST['ajax']){
include('disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php } ?>