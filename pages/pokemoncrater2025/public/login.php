<?php
header("location:login.php");
exit();
setcookie("regg", 1, time()-3600);
setcookie("reggg", 1, time()-3600);
session_start();
session_destroy();
session_unset(); 
$ip = $_SERVER['REMOTE_ADDR'];
$DOWN_FOR_MAINTANCE = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/black/home.css" media="screen" />
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
<title>Pok&eacute;mon Shqipe v3 - Log In</title>
</head>
<body>
<div id="alert"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<noscript>
<img src="html/static/images/fbbanner.png" width="728" height="90" marginwidth="0" marginheight="0">
</noscript>
<?php
include('/var/www/ads/headerad.php');
?>
</div>
<div id="title"><h1><a href="index"><em>pokemon-shqipe.co.ukm</em></a></h1></div><ul id="homeNav"><li><a href="#" id="loginTab" class="selected"><em>Log In</em></a></li><li><a href="/signup" id="signupTab" class="deselected"><em>Sign Up</em></a></li><li><a href="/about" id="aboutTab" class="deselected"><em>About Us / FAQ</em></a></li></ul>
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
<p><a href="#" class="s">Log In</a><br />
<a href="signup" class="s">Sign Up</a><br />
<a href="http://pokemon-shqipe.co.uk/" class="s">Version 2</a><br />
<a href="contactus" class="s">Contact Us</a><br />
<a href="about" class="s">About Us / FAQ</a><br />
<a href="legal" class="s">Legal Info</a><br />
<a href="credits" class="s">Credits</a></p>
<h4>Other Features:</h4>
<div class="hr"></div>
<p><a href="index" class="s">Home/News</a><br />
<a href="news" class="s">News Archive</a><br />
<a href="http://forums.pokemon-shqipe.co.uk/" class="s">Forums</a><br />
<a href="chat" class="s">Chat Room</a><br />
<a href="http://facebook.com/pokemon-shqipe" class="s">Shqipe Facebook</a><br />
<a href="http://twitter.com/Pokemon_Shqipe" class="s">Shqipe Twitter</a></p>
<div class="hr"></div>
<div style="text-align: center;">
<?php
include('/var/www/ads/sidead.php');
?>
</div>
</div>
</div>
<div id="rightbarBottom"></div>
</div>
<div id="scrollContent">
			<?php
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Banned'){
				echo '<center><div class="errorMsg">This account has been banned by Pok&eacute;mon Shqipe</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ServerDown'){
				echo '<center><div class="errorMsg">The <b>Server</b> is currently down due to maintenance. Sorry for any inconvenience.</div></center>';
			}
			if(isset($_REQUEST['c'])){ 
				echo '<center><div class="actionMsg">Your password has been successfully changed, you may now login.</div></center>'; 
			}
			if(isset($_REQUEST['reg'])){ 
				echo '<center><div class="actionMsg">You are now registered and may login.</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Logout'){ 
				echo '<center><div class="actionMsg">You are now logged out.</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Attempts'){ 
				echo '<center><div class="errorMsg">Error: Too many incorrect guesses. The account is locked for 30 mins</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Error'){ 
				if($_REQUEST['type'] == 'User_Pass'){
					echo '<center><div class="errorMsg">Username or Password you entered is incorrect.</div></center>';
				}
			}
			if(isset($_REQUEST['goawayxP'])){ 
				echo '<div class="errorMsg"><center>Your session has expired.</center></div>';
			}
			if($DOWN_FOR_MAINTANCE == 1){
				echo '<div style="text-align: center; margin: 0 auto;"><img src="html/static/images/maintenance.png"></div><br/><div class="errorMsg"><center>Shqipe Battle Arena is down for maintenance and will be back up as soon as possible.<br/>Please refrain from asking questions about it on our <a href="http://facebook.com/pokemonvortex" target="_BLANK">Facebook</a>, <a href="http://pokemon-shqipe.co.uk/chat/" target="_BLANK">Chatroom</a> and <a href="http://twitter.com/Pokemon_Shqipe" target="_BLANK">Twitter</a>.<br/> Thank you for your patience.</center></div>';
			}
			else{
				$actions = array('checklogin.php', 'checklogin.php'); 
				$which = rand(0,1); 
			?> 
			<form method="post" action="<?php echo $actions[$which]; ?>"><div style="text-align: center; margin: 0 auto;">	
<div class="errorMsg"><center>You must <a href="/signup">create a new account</a> to use v3 of Pok&eacute;mon Shqipe even if you previously had an account in <a href="http://pokemon-shqipe.co.uk">v2</a>.<br />You cannot yet create accounts for v3 as it is not complete.<br />Follow us on <a href="http://facebook.com/pokemonvortex">Facebook</a> to be notified when v3 is complete and ready for sign-ups.</center></div>
<h2 style="margin-top: 25px;">Enter your username and password to login:</h2>
		    <table border="0" cellspacing="0" cellpadding="4" style="margin: 0 auto 0 auto; text-align: left;">
              <tr><?php if(isset($_REQUEST['goo']) && $_REQUEST['goo'] == 1){ ?><input type="hidden" name="this" value="1" /><?php } ?>
                <td style="text-align: right;" valign="middle">Username:</td>
                <td><input name="myusername" type="text" id="myusername"<?php if(isset($_COOKIE['UCookie'])){ echo " value=\"{$_COOKIE['UCookie']}\""; } ?> /></td>
              </tr>
              <tr>
                <td style="text-align: right;" valign="middle">Password:</td>
                <td><input name="mypassword" type="password" id="mypassword"<?php if(isset($_COOKIE['PCookie'])){ echo " value=\"{$_COOKIE['PCookie']}\""; } ?>></td>
              </tr>
 <tr style="text-align: center;" valign="middle">
                <td colspan="2"></td>
              </tr>
              <tr style="text-align: center;" valign="middle">
                <td colspan="2"><input type="submit" name="Submit" value="Log in" onclick="this.disabled = true; this.value = 'Logging In...'; this.form.submit();">
				</td>
              </tr>
              <tr style="text-align: center;" valign="middle">
                <td colspan="2"><a href="about">Having trouble logging in?</a> | <a href="forgot_password">Forgot your password?</a> | <a href="http://pokemon-shqipe.co.uk/">Version 2</a></td>
              </tr>
            </table></div></form>
		<?php } ?>
<div class="noticeMsg"><strong>Notice:</strong> <em>Do not give your password to anyone else under any circumstances.</em><br />pokemon-shqipe.co.uk representatives will <strong>never</strong> ask for your password and you should <strong>never</strong> give it to anyone who does ask for it.</div><br />
<?php include('disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//homeInit.js"></script>
</html>