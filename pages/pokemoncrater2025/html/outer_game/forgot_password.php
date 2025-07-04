<?php
include('pv_connect_to_db.php');
$time = time() - 2592000;
mysql_query("DELETE FROM pr WHERE time < '$time'");
if(isset($_POST['submit_name'])){
	require_once('recaptchalib.php');
	$privatekey = "6LfHqQgAAAAAAK693Hj4MtpLhBNx4Hh9xf2qNxUx";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	if($resp->is_valid) {
		if($_POST['forgotuser'] == 'lolage'){
			$error = 7;
		}
		else{
			$_POST['forgotuser'] = mysql_real_escape_string($_POST['forgotuser']);
			$n = mysql_query("SELECT * FROM members WHERE username = '{$_POST['forgotuser']}'");
			$nm = mysql_num_rows($n);
			if($nm == 0 && !is_numeric($error)){
				$error = 3;
			}
			$nmm = mysql_fetch_array($n);
			if(!strstr($nmm['email'], '@') && !is_numeric($error)){
				$error = 4;
			}
			if(!is_numeric($error)){
				$rand1 = rand(0,1000000);
				$rand2 = rand(0,2000000);
				$rand3 = rand(0,4000000);
				$first = crypt($rand1,'PokemonVortexxx');
				$second = crypt($first,"$rand2");
				$third = crypt($second,"$rand3");
				$fourth = crypt($rand2,'VoRtEx');
				$time = time();
				mysql_query("INSERT INTO dat (id, username, time) VALUES ('$fourth', '{$nmm['username']}', '$time')");
				mysql_query("INSERT INTO pr (id, account, time) VALUES ('$third', '{$nmm['username']}', '$time')");
				$to = $nmm['email'];
				$password = $row['thing'];
				$subject = "Password Recovery";
				$message = "You have received this message from http://www.pokemon-vortex.com/
			
This is a password recovery email. If this isn't for you please delete it. 
			
Click the following link to change your account password.
http://www.pokemon-vortex.com/forgot_password.php?c=pass&rid={$third}&pr={$fourth}
			
Please do not reply to this message. This message is computer generated. ";
				$headers = 'From: no-reply@pokemon-vortex.com';
				mail($to,$subject,$message,$headers);
				$mail = 2;
			}
		}
	}
}
if($_POST['change_password']){
	$id = $_SESSION['f_p'][1];
	$account = $_SESSION['f_p'][0];
	$pass = mysql_real_escape_string($_POST['pass']);
	$pass2 = mysql_real_escape_string($_POST['pass2']);
	if($pass == $pass2){
		$enc = md5($pass);
		mysql_query("UPDATE members SET password = '$enc' WHERE username = '$account'");
		mysql_query("UPDATE flashchat_users SET password = '$enc' WHERE login = '$account'");
		mysql_query("DELETE FROM pr WHERE id = '$id' AND account = '$account'");
		mysql_query("DELETE FROM dat WHERE username = '$account'");
		header('location:http://www.pokemon-vortex.com/login.php?c=pass');
	}
	else {
		$error = 2;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/functions.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/home.css" media="screen" />
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/ie6-.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
	<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/ie7+.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/ie7+.css" media="screen" />
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" />  
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Vortex v3 - Password Recovery</title>
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
<div id="title"><h1><a href="index.php"><em>PokemonVortex.com</em></a></h1></div>
<ul id="homeNav">
  <li><a href="/login.php" id="loginTab" class="deselected"><em>Log In</em></a></li>
  <li><a href="/signup.php" id="signupTab" class="deselected"><em>Sign Up</em></a></li>
  <li><a href="/about.php" id="aboutTab" class="deselected"><em>About Us / FAQ</em></a></li>
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
<a href="about.php" class="s">About Us / FAQ</a><br />
<a href="legal.php" class="s">Legal Info</a><br />
<a href="credits.php" class="s">Credits</a></p>
<h4>Other Features:</h4>
<div class="hr"></div>
<p><a href="/" class="s">Home/News</a><br />
<a href="/news.php" class="s">News Archive</a><br />
<a href="http://forums.pokemonvortex.com/" class="s">Forums</a><br />
<a href="https://facebook.com/pokemonvortex" class="s" target="_blank">Vortex's Facebook</a><br />
<a href="https://twitter.com/Pokemon_Vortex" class="s" target="_blank">Vortex's Twitter</a><br />
<a href="http://plus.google.com/+pokemonvortex" class="s" target="_blank">Vortex's Google+</a></p>
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
<?php
if($_REQUEST['c'] == "pass" && $_REQUEST['rid'] && $_REQUEST['pr']){
	$_REQUEST['rid'] = mysql_real_escape_string($_REQUEST['rid']);
	$_REQUEST['pr'] = mysql_real_escape_string($_REQUEST['pr']);
	$check = mysql_query("SELECT * FROM pr WHERE id = '{$_REQUEST['rid']}'");
	$chec = mysql_num_rows($check);
	if($chec > 0){
		$new = mysql_fetch_array($check);
		$check_pr = mysql_query("SELECT * FROM dat WHERE id = '{$_REQUEST['pr']}'");
		$chec_pr = mysql_num_rows($check_pr);
		if($chec_pr > 0){
			$crypt = $new['id'];
			$account = $new['account'];
			?>
        
			<center><h2>Password modification for <?php echo $account; ?></h2>
        
			<?php
            if($error == 2){
				?>
			<div class="errorMsg">Your passwords did not match, please type them again.</div>
				<?php
			} ?>
        	<table><form method="post">
        	<tr><td style="text-align: right"><strong><span style="color: #990000;">New Password:</span></strong></td><td style="text-align: left"><input type="password" maxlength="30" name="pass" /></td></tr>
        	<tr><td style="text-align: right"><strong><span style="color: #990000;">Re-type Password:</span></strong></td><td style="text-align: left"><input type="password" maxlength="30" name="pass2" /></td></tr>
			</table>
			<p><input type="submit" name="change_password" value="Change Password" /></p>
		
			<?php
			$_SESSION['f_p'][0] = $account;
			$_SESSION['f_p'][1] = $crypt;
			?>
			</table>
			</center>
			<?php
			}
		}
		else{
			?>
			<center><h2>Notice</h2></center>
			<p>The recovery id that you have used has either expired or is invalid. Please repeat the Password Recovery process if you still wish to change your password.</p>
        	<?php
		}
	}
	else{
		if($mail == 2){
			?>
        
			<center><h2>Notice</h2>
			<p>An email has been sent to the email address for the specified account. Please follow the instructions in the email to change your account password.<br>This message can sometimes be sent to your junk mail. Please be sure to check there before requesting another email.</p></center>
			<?php
		}
		else{
			?>
			<form method="POST">
			<center>
			<h2>Password Retrieval</h2>
		
			<?php
			switch($error){
				case 2:
				echo "<div class=\"errorMsg\">The verification code you typed in was incorrect. Please try again.</div>";
				break;
			
				case 3:
				echo "<div class=\"errorMsg\">No members were found by the username you specified.</div>";
				break;
			
				case 4:
				echo "<div class=\"errorMsg\">Unfotunately, your account email is invalid. I encourage you to check your browser files for the password.</div>";
				break;

				case 7:
				echo "<div class=\"errorMsg\">That is not your account.</div>";
				break;
			} ?>
        
			<span class="small">Note: Using this form will send an email containing further information about your password to the email account that you registered with.</span>
			<p><strong><span style="color: #990000;">Account Username:</span></strong> <input type="text" name="forgotuser" value="<?php echo $_POST['forgotuser']; ?>" /></p>
			<p><?php require_once('recaptchalib.php');
			$publickey = " 	6LfHqQgAAAAAANGAOe-K4LYv76DQhBCQgb6CWg7P";
			echo recaptcha_get_html($publickey); ?></p>
        
			<p><input type="submit" name="submit_name" value="Send Email" /></p></center>
			</form>
			<?php
		}
	}
echo '<div id="copy">&copy;2008-2014 <a href="/">Pok&eacute;mon Vortex</a>. This site is not affiliated with Nintendo, The Pok&eacute;mon Company, Creatures, or GameFreak<br /><a href="contactus.php">Contact Us</a> | <a href="about.php">About Us / FAQ</a> | <a href="privacy.php">Privacy Policy &amp; Terms of Service</a> | <a href="legal.php">Legal Info</a> | <a href="credits.php">Credits</a></div>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/homeInit.js"></script>
</html>';
?>