<?php
include('pv_connect_to_db.php');
$ips = $_SERVER['REMOTE_ADDR'];
if($_POST['action'] == 'send'){

	$type = mysql_real_escape_string($_POST['contact_type']);
	$from = mysql_real_escape_string($_POST['name']);
	$email = mysql_real_escape_string($_POST['email']);
	$subject = mysql_real_escape_string($_POST['subject']);
	$username = mysql_real_escape_string($_POST['login']);
	$message = mysql_real_escape_string($_POST['comments']);
	if($_POST['securitycode'] == $_POST['security']){
		if($from == '' || $email == '' || $subject == '' || $message == '' || $type == ''){
			$error = 2;
		}
		else{
			mysql_query("INSERT INTO `pms` ( `type` , `from` , `message` , `subject` , `email` , `username` , `ip` ) VALUES ('$type', '$from', '$message', '$subject', '$email', '$username', '$ips')");
			$emailmes = $message . '<br /><b>From:</b> ' . $from . '<br /><b>Type:</b> ' . $type . '<br /><b>Email:</b> ' . $email . '<br /><b>Username:</b> ' . $username . '<br /><b>IP Address:</b> ' . $ips;
			$name = "";
			$email = '';

			$headers  = 'From: ' . $name . '<' . $email . '>' . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			mail('', $subject, $emailmes, $headers);
			$sent = 1;
			$type = '';
			$from = '';
			$email = '';
			$subject = '';
			$username = '';
			$message = '';
		}
	}
	else{
		$error = 4;
	}
}
if(!$_REQUEST['ajax']){
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
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
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Vortex v3 - Contact Us</title>
</head>
<body>
<?php include_once("analytics.php"); ?>
<div id="alert"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<?php
include('/var/www/ads/headerad.php');
?></div>
<div id="title">
<h1><a href="index.php"><em>PokemonVortex.org</em></a></h1>
</div>
<ul id="homeNav">
<li><a href="login.php" id="loginTab" class="deselected"><em>Log In</em></a></li>
<li><a href="signup.php" id="signupTab" class="deselected"><em>Sign Up</em></a></li>
<li><a href="about.php" id="aboutTab" class="deselected"><em>About Us / FAQ</em></a></li>
</ul>
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
<p><a href="login.php" class="s">Log In</a><br />
<a href="signup.php" class="s">Sign Up</a><br />
<a href="#" class="s">Contact Us</a><br />
<a href="about.php" class="s">About Us / FAQ</a><br />
<a href="legal.php" class="s">Legal Info</a><br />
<a href="credits.php" class="s">Credits</a></p>
<h4>Other Features:</h4>
<div class="hr"></div>
<p><a href="index.php" class="s">Home/News</a><br />
<a href="news.php" class="s">News Archive</a><br />
<a href="http://forums.pokemon-shqipe.co.uk/" class="s">Forums</a><br />
<a href="http://facebook.com/" class="s">Vortex Facebook</a><br />
<a href="http://twitter.com/" class="s">Vortex Twitter</a><br />
<a href="http://plus.google.com/" class="s">Vortex Google+</a></p>
<div class="hr"></div>
<div style="text-align: center;">
<?php
include('/var/www/ads/sidead.php');
?></div>
</div>
</div>
<div id="rightbarBottom"></div>
</div>
<div id="scrollContent">
<div id="ajax">
	<?php
}
?>
<form action="contactus.php" method="post" onsubmit="get('/contactus.php', '', this); disableSubmitButton(this); return false;">
<?php 
if($error == 2) echo '<div class="errorMsg">Not all of the main fields were filled out.</div>'; 
if($error == 4) echo '<div class="errorMsg">Sorry the security codes did not match</div>';
if($sent == 1) echo '<div class="actionMsg">Your message has been sent to the webmaster.</div>';
?>
<center>
<div class="noticeMsg">
<b>Notice:</b> Before contacting us, please take a look through our <a href="/about.php" target="_BLANK">about page</a> to see if your question or problem has already been asked or resolved.
</div>
</center>
<table style="margin: 20px auto 0 auto;" cellpadding="5" cellspacing="1">
<tr> 
<td style="width: 120px; text-align: right;"><strong>Contact Type:</strong></td>
<td style="text-align: left;"><strong> 
<select name="contact_type" class="textbox" id="contact_type">
<option value="" selected>Please Choose</option>
<option value="Question">Question</option>
<option value="Support">Support Request</option>
<option value="Testimonial">Testimonial</option>
<option value="Other">Other</option>
</select>
</strong>
</td>
</tr>
<tr> 
<td style="width: 120px; text-align: right;"><strong>Your Name:</strong></td>
<td style="text-align: left;"><strong> 
<input name="name" type="text" class="textbox" id="name" size="30" value="<?php echo $from; ?>">
</strong></td>
</tr>
<tr> 
<td style="width: 120px; text-align: right;"><strong>Subject:</strong></td>
<td style="text-align: left;"><strong> 
<input name="subject" type="text" class="textbox" id="subject" size="30" value="<?php echo $subject; ?>">
</strong></td>
</tr>
<tr> 
<td style="width: 120px; text-align: right;"><strong>Your Email:</strong></td>
<td style="text-align: left;"><strong> 
<input name="email" type="text" class="textbox" id="email" size="30" value="<?php echo $email; ?>">
</strong></td>
</tr>
<tr> 
<td style="width: 120px; text-align: right;"><strong>Login:</strong></td>
<td style="text-align: left;"> 
<input name="login" type="text" class="textbox" id="login" size="15" value="<?php echo $_SESSION['myuser']; ?>">
(for current members only)</td>
</tr>
<tr> 
<td style="width: 120px; text-align: right;"><strong><br />
Comments/<br />
Questions:</strong></td>
<td style="text-align: left;"><strong> 
<textarea name="comments" cols="40" rows="10" class="textbox" id="comments"><?php echo $message; ?></textarea>
</strong>
</td>
</tr>
<?php
$r1 = rand(0,10);
$r2 = rand(0,10);
$r3 = rand(0,10);
$r4 = rand(0,10);
echo '<input type="hidden" name="securitycode" value="' , $r1 , $r2 , $r3 , $r4 , '">';
?>
<tr><td style="width: 120px; text-align: right;"><strong>Type the following number: 
<?php
echo $r1,$r2,$r3,$r4;
?>
</strong>
</td>
<td style="text-align: left;"> 
<strong> 
<input name="security" type="text" class="textbox" id="security">
</strong>
</td>
</tr>
</table>

<p style="text-align: center";><input type="hidden" name="action" value="send" /><input type="submit" name="submit" value="Send" /></p>
</form>
<center>Please note that if you do not provide a valid email or Vortex login, we cannot contact you back to help with your issue.<br/>We read every message carefully but we do not always respond to frequently asked questions.</center>
<?php
if(!$_REQUEST['ajax']){
	echo'</div>';
	include('disclaimer.php'); ?>
    </div>
    </div>
    </div>
    </div>
    </div>
    </body>
    <script type="text/javascript" language="javascript" src="html/static/js//v3/homeInit.js"></script>
    </html>
	<?php
} ?>