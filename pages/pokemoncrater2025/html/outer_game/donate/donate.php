<?php
header('location:http://www.pokemon-shqipe.co.uk/');
exit();
require "config.php";
require "connect.php";

// Determining the URL of the page:
$url = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
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
<script src="popup.js"></script>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pok&eacute;mon Vortex v3 - Donate</title>
<style>
#element_to_pop_up { 
	background-color: #fff;
	border-radius: 15px;
	color: #000;
	display: none; 
	padding: 20px;
	width: 600px;
	height: 400px;
	overflow-y: scroll;
	overflow-x: hidden;
}

.b-close{
	cursor: pointer;
	position: absolute;
	right: 10px;
	top: 5px;
}

.donors{
	margin-top: 30px;
}

.donations{
	text-align: right;
	width: 340px;
}

.comments{
	margin-top: 0px;
}

.comment{
	background-color: #6f7468;
	padding: 20px;
	position: relative;
	margin-bottom: 20px;
	border-radius: 20px;
}

.name{
	color: #6f7468;
	font-size: 22px;
	font-weight: bold;
	position: relative;
}

.name a.url{
	color: #C0D39C;
	font-weight: normal;
	padding-left: 10px;
}

.tip{
	width: 0;
	height: 0;
	bottom: -40px;
	left: 20px;
	border:20px solid #f9faf7;
	border-width: 20px 15px;
	border-top-color: #6f7468;
	position: absolute;
	
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
<h1><a href="/"><em>Pokemon-shqipe.co.uk</em></a></h1>
</div>
<ul id="homeNav">
<li><a href="/login.php" id="loginTab" class="deselected"><em>Log In</em></a></li>
<li><a href="/signup.php" id="signupTab" class="deselected"><em>Sign Up</em></a></li>
<li><a href="/about.php" id="aboutTab" class="selected"><em>About Us / FAQ</em></a></li>
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
<p><a href="/login.php" class="s">Log In</a><br />
<a href="/signup.php" class="s">Sign Up</a><br />
<a href="/contactus.php" class="s">Contact Us</a><br />
<a href="/about.php" class="s">About Us / FAQ</a><br />
<a href="/legal.php" class="s">Legal Info</a><br />
<a href="/credits.php" class="s">Credits</a></p>
<h4>Other Features:</h4>
<div class="hr"></div>
<p><a href="/" class="s">Home/News</a><br />
<a href="/news.php" class="s">News Archive</a><br />
<a href="http://forums.pokemon-shqipe.co.uk/" class="s">Forums</a><br />
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
<h1>Donation Center</h1>
<h2>Show your support for Pok&eacute;mon Vortex</h2>
<div class="lightSection">
<p>By donating to Pok&eacute;mon Vortex you will help us raise costs to run the game and keep it free to play.<br />While donations are completely 100% optional, they're also greatly appreciated.</p>
<p>So, what can you get from donating? Well besides the self satisfaction of knowing you helped us out, you will also get a choice of any Arceus (Fairy) type that you'd like from Normal, Shiny, Dark, Mystic, Shadow and Metallic.</p>
<p>Click the Arceus Donate button below and you will be taken to PayPal with a set amount of $10. You can donate as many times as you like for as many Arceus' you like. Once you have completed the donation process on PayPal, you will be directed back to Pokemon Vortex where you will be presented with the choice of Arceus (Fairy) and option to join our donor list.<br />Once submitted, you will be given your promo code for Arceus that can be redeemed on the dashboard.<br />(Make a note of this code as this will be the only time it is given to you)</p>
<p>Please complete the entire process in one go or you might miss out on your Arceus as this is now a fully automated system. If you're having any problems, just <a href="mailto:patrick@pokemonmountain.com">email us</a> and we'll get back to you as soon as possible.

<!-- The PayPal Donation Button -->

<form action="<?php echo $payPalURL?>" method="post" class="payPalForm">
<div>
<input type="hidden" name="cmd" value="_donations" />
<input type="hidden" name="item_name" value="Donation" />

<!-- Your PayPal email: -->
<input type="hidden" name="business" value="<?php echo $myPayPalEmail?>" />

<!-- PayPal will send an IPN notification to this URL: -->
<input type="hidden" name="notify_url" value="<?php echo $url.'/ipn.vortex.php'?>" /> 

<!-- The return page to which the user is navigated after the donations is complete: -->
<input type="hidden" name="return" value="<?php echo $url.'/thankyou.php'?>" /> 

<!-- Signifies that the transaction data will be passed to the return page by POST -->
<input type="hidden" name="rm" value="2" /> 

<!-- 	General configuration variables for the paypal landing page. Consult 
http://www.paypal.com/IntegrationCenter/ic_std-variable-ref-donate.html for more info  -->

<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="cbt" value="Go Back To The Site" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="lc" value="US" />
<input type="hidden" name="currency_code" value="USD" />
<input type="hidden" name="amount" value="0.01">

<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest" />

<!-- You can change the image of the button: -->
<input type="image" style="border: none; background: transparent;" src="html/static/images/donate.png" name="submit" alt="PayPal - The safer, easier way to pay online!" />

<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</div>
</form>

</div>
<div class="clear"></div>

<div class="donors">
<h3>The Donor List</h3>

<a href="#" id="pop-up">Click here to show a list of people who showed their support</a>

<div id="element_to_pop_up">
<a class="b-close"><img src="html/static/images/close.gif"></a>
<div class="comments">

<?php
$comments = mysql_query("SELECT * FROM dc_comments WHERE message != '' ORDER BY id DESC");

// Building the Donor List:
echo '<center><h2>The Donor List</h2>A huge thank you to everyone below.</center>';
if(mysql_num_rows($comments)){
	while($row = mysql_fetch_assoc($comments)){
		?>

		<div class="entry">
		<p class="comment">
		<?php
		echo '<i><sup>' . $row['dt'] . '</sup></i><br /><br />';
		echo nl2br($row['message']); // Converting the newlines of the comment to <br /> tags
		?>
		<span class="tip"></span>
		</p>

		<div class="name">
		<?php echo $row['username']?> <a class="url" href="<?php echo $row['url']?>"><?php echo $row['url']?></a>
		</div>
		</div>
		<?php
	}
}
?>
</div>

</div>
<? include('/var/www/html/disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/homeInit.js"></script>
</html>