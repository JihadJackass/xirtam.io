<?php
header('location:http://www.pokemon-vortex.com/');
exit();

require "config.php";
require "connect.php";

if(isset($_POST['submitform']) && isset($_POST['txn_id'])){
	$_POST['nameField'] = esc($_POST['nameField']);
	$_POST['pokemonField'] =  esc($_POST['pokemonField']);
	
	$error = array();
	
	if(mb_strlen($_POST['nameField'],"utf-8")<2){
		$error[] = 'Please fill in a valid username.';
	}
	
	if(!$_POST['pokemonField'] == 'Arceus (Fairy)' || !$_POST['pokemonField'] == 'Shiny Arceus (Fairy)' || !$_POST['pokemonField'] == 'Dark Arceus (Fairy)' || !$_POST['pokemonField'] == 'Mystic Arceus (Fairy)' || !$_POST['pokemonField'] == 'Shadow Arceus (Fairy)' || !$_POST['pokemonField'] == 'Metallic Arceus (Fairy)'){
		$error[] = 'Please pick a valid donation Pokemon';
	}

	$errorString = '';
	if(count($error)){
		$errorString = join('<br />',$error);
	}
	else{
		$handle = fopen('logz/paypal_log/ipn_log.txt', 'r');
		$valid = false; // init as false
		while (($buffer = fgets($handle)) !== false) {
    			if (strpos($buffer, 'txn_id=' . $_POST['txn_id'] . '') !== false) {
        			$valid = TRUE;
        			break; // Once you find the string, you should break out the loop.
    			}      
		}
		fclose($handle);

		// Protect the posted data
		if($valid == 'TRUE'){
			mysql_query("INSERT INTO dc_comments (transaction_id, username, email, pokemon, message, url)
							VALUES (
								'".esc($_POST['txn_id'])."',
								'".$_POST['nameField']."',
								'".$_POST['payer_email']."',
								'".$_POST['pokemonField']."',
								'".$_POST['messageField']."',
								'".$_POST['websiteField']."'
							)");
		}
		if(mysql_affected_rows($link)==1 && $valid == 'TRUE'){

			// Generate the promo code

			$get_uid = mysql_fetch_array(mysql_query("SELECT * FROM members WHERE username = '{$_POST['nameField']}'"));
			$random_code = rand(30,4309877342082);
			$promoo = md5($random_code);
			$promo = strtoupper($promoo);
			mysql_query("INSERT INTO promo_codes (code, prize, type, owner) VALUES ('$promo', '{$_POST['pokemonField']}', 'pokemon', '{$get_uid['id']}')");

			$messageString = '<a href="donate.php">You were added to our donor list! &raquo;</a><br /><br /><h3>Your Promo Code:</h3><div class="promoCode"><b><font color="red">' . $promo . '</font></b></div>';
		}
		else{
			$errorString = '<font color="red"><b>Donation not verified. You either did not donate or an error has occurred.<br />If this is a system error, please contact us.</b></font>';
		}
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
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pok&eacute;mon Vortex v3 - Donate</title>
<style>
.promoCode{
	width: 40%;
	text-align: center;
	padding: 10px;
	margin: 10px 20px;
	background-color: #808080;
	border: 2px solid #181818;
	border-radius: 20px;
	box-shadow: 10px 10px 5px #888888;
}
</style>
</head>
<body>
<div id="alert"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<?php
include('/var/www/ads/headerad.php');
?>
</div>
<div id="title">
<h1><a href="index.php"><em>Pokemon-Vortex.com</em></a></h1>
</div>
<ul id="homeNav">
<li><a href="login.php" id="loginTab" class="deselected"><em>Log In</em></a></li>
<li><a href="signup.php" id="signupTab" class="deselected"><em>Sign Up</em></a></li>
<li><a href="about.php" id="aboutTab" class="selected"><em>About Us / FAQ</em></a></li>
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
<a href="contactus.php" class="s">Contact Us</a><br />
<a href="about.php" class="s">About Us / FAQ</a><br />
<a href="legal.php" class="s">Legal Info</a><br />
<a href="credits.php" class="s">Credits</a><br />
<a href="#" class="s">Donate</a></p>
<h4>Other Features:</h4>
<div class="hr"></div>
<p><a href="index.php" class="s">Home/News</a><br />
<a href="news.php" class="s">News Archive</a><br />
<a href="http://forums.pokemon-vortex.com/" class="s">Forums</a><br />
<a href="http://facebook.com/pokemonvortex" class="s">Vortex Facebook</a><br />
<a href="http://twitter.com/Pokemon_Vortex" class="s">Vortex Twitter</a><br />
<a href="http://plus.google.com/+pokemonvortex">Vortex Google+</a></p>
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
<center>
<h1>Thank you!</h1>
<h2>Add Yourself to our Donor Section</h2>
<p>Use this section to choose the Pokemon you want for donating and to add yourself to our donor list.</p>
<p>Please note that website to enter is optional and if you do choose to enter one then use the http:// or https:// prefix.</p>
<p><b>Do not</b> leave this page until you have been given your promo code or you will not be able to recieve one.</p>
<p>This website is for all ages so in your comments, it is very much appreciated that you keep it clean, thank you.</p>
<p><i>Wish to remain anonymous? Leave the message and website section blank.</i></p>
<form action="" method="post">
<table>

<tr>
<div class="field">
<td><label for="nameField">Username:<font color="red"><b>*</b></font> </label></td>
<td><input type="text" id="nameField" name="nameField" /></td>
</div>
</tr>

<tr>
<div class="field">
<td><label for="payer_email">PayPal Email:<font color="red"><b>*</b></font> </label></td>
<td><input type="text" id="payer_email" name="payer_email" /></td>
</div>
</tr>

<tr>
<div class="field">
<td><label for="pokemonField">Pokemon:<font color="red"><b>*</b></font> </label></td>
<td><select name="pokemonField"><option>Arceus (Fairy)</option><option>Shiny Arceus (Fairy)</option><option>Dark Arceus (Fairy)</option><option>Mystic Arceus (Fairy)</option><option>Shadow Arceus (Fairy)</option><option>Metallic Arceus (Fairy)</option></select></td>
</div>
</tr>

<tr>
<div class="field">
<td><label for="websiteField">Website: </label></td>
<td><input type="text" id="websiteField" name="websiteField" /></td>
</div>
</tr>

<tr>
<div class="field">
<td><label for="messageField">Message: </label></td>
<td><textarea name="messageField" id="messageField"></textarea></td>
</div>
</tr>
</table>

<table>
<tr>
<div class="button">
<td><input type="submit" value="Submit" /></td>
<td><input type="hidden" name="submitform" value="1" /></td>
<td><input type="hidden" name="txn_id" value="<?php echo $_POST['txn_id']?>" /></td>
</div>
</tr>
</table>
</form>

<?php
if($errorString){
	echo '<p class="error">'.$errorString.'</p>';
}
else if($messageString){
	echo '<p class="success">'.$messageString.'</p>';
}
?>

</center>
</div>
<? include('/var/www/html/disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="http://static.pokemon-vortex.com/js/v3/homeInit.js"></script>
</html>
<?php
function esc($str){
	global $link;
	if(ini_get('magic_quotes_gpc'))
	$str = stripslashes($str);
	return mysql_real_escape_string(htmlspecialchars(strip_tags($str)),$link);
}
function validateURL($str){
	return preg_match('/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:\/~\+#]*[\w\-\@?^=%&amp;\/~\+#])?/i',$str);
}
?>
