<?php
include('pv_connect_to_db.php');
	if(!isset($_REQUEST['ajax'])){
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
		<script src="popup.js" ></script>
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
		<style>
		#element_to_pop_up { 
    			background-color:#fff;
    			border-radius:15px;
    			color:#000;
    			display:none; 
    			padding:20px;
    			width: 600px;
    			height: 400px;
			overflow-y: scroll;
		}
		.b-close{
    			cursor:pointer;
    			position:absolute;
			right:10px;
			top:5px;
		}</style>
		<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
		<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
		<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
		
		<meta name="description" content="Pok&eacute;mon Battle Arena v3 RPG. A free online Pok&eacute; game where you can catch, battle and trade all of your favourite Pok&eacute;mon.">
		<title>Pok&eacute;mon  v3 - Sign Up</title>
		</head>
		<body>';
		include_once("analytics.php");
		echo '<div id="alert"></div>
		<div id="container">
		<div id="header">
		<div id="headerAd">';
		
		include('/var/www/ads/headerad.php');

		echo '
		</div>
		<div id="title"><h1><a href="index.php"><em>Pokemon-Shqipe.co.uk</em></a></h1></div>
		<ul id="homeNav">
		  <li><a href="login.php" id="loginTab" class="deselected"><em>Log In</em></a></li>
		  <li><a href="signup.php" id="signupTab" class="deselected"><em>Signup</em></a></li>
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
		<a href="contactus.php" class="s">Contact Us</a><br />
		<a href="about.php" class="s">About Us / FAQ</a><br />
		<a href="legal.php" class="s">Legal Info</a><br />
		<a href="credits.php" class="s">Credits</a></p>
		<h4>Other Features:</h4>
		<div class="hr"></div>
		<p><a href="index.php" class="s">Home/News</a><br />
		<a href="news.php" class="s">News Archive</a><br />
		<a href="http://forums.Pokemon-Shqipe.co.uk/" class="s">Forums</a><br />
		<a href="http://facebook.com/" class="s">Facebook</a><br />
		<a href="http://twitter.com/" class="s">Twitter</a></p>
		<div class="hr"></div>
		<div style="text-align: center;">';
		
		include('/var/www/ads/sidead.php');

		echo '
		</div>
		</div></div><div id="rightbarBottom"></div>
		</div>
		<div id="scrollContent"><div id="ajax"><div style="text-align: center;">';
	}
	if(isset($_POST['submit'])){
		if($_POST['submit'] == 'Continue Sign-Up'){
			$username = mysql_real_escape_string(trim($_POST['user'])); $pass = mysql_real_escape_string($_POST['pass']); $pass2 = mysql_real_escape_string($_POST['pass2']); $email = mysql_real_escape_string($_POST['email']); $display = mysql_real_escape_string($_POST['allow_email']); $forum = mysql_real_escape_string($_POST['forum']); $skype = mysql_real_escape_string($_POST['skype']); $terms = mysql_real_escape_string($_POST['terms']);
			/*
			require_once('recaptchalib.php');
			$privatekey = "6Le7FAwAAAAAADz51sCkfmEbOhYE02uL_n8f6iRR";
			$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
									if (!$resp->is_valid) {
										$error = 7;
									}*/
			$omom = 1;
			if($omom != 1){
			}
			else{
				if($_POST['terms'] != "agree"){
					$error = 6;
				}
				else{
					if($pass != $pass2){
						$error = 3;
					}
					else{
						if($username == "" || $email == "" || $pass == "" || $pass2 == ""){
							$error = 5;
						}
						else{
							$s = mysql_query("SELECT username FROM members WHERE username = '$username'");
							$t = mysql_query("SELECT user FROM reg WHERE user = '$username'");
							$st = mysql_num_rows($s);
							$ts = mysql_num_rows($t);
							if($st > 0 || $ts > 0){
								$error = 4;
							}
							// unallowed characters and words in usernames
							elseif(strstr($username,"Patrick") || strstr($username,"!") || strstr($username,"�") || strstr($username,"`") || strstr($username,"�") || strstr($username,"$") || strstr($username,"%") || strstr($username,"^") || strstr($username,"&") || strstr($username,"*") || strstr($username,")") || strstr($username,")") || strstr($username,"+") || strstr($username,"=") || strstr($username,".") || strstr($username,">") || strstr($username,"?") || strstr($username,"/") || strstr($username,"|") || strstr($username,"<") || strstr($username,",") || strstr($username," ") || strstr($username,"'") || strstr($username,'"') || strstr($username,"#") || strstr($username,"~") || strstr($username,"@") || strstr($username,":") || strstr($username,";") || strstr($username,"[") || strstr($username,"]") || strstr($username,"{") || strstr($username,"}") || strstr($username,",") || stristr($username,"�") || stristr($username,"�") || stristr($username,"�") || stristr($username,"�") || stristr($username,"�") || strstr($username,"�") || strstr($username,"=")){
								$error = 8;
							}
							elseif(stristr($username,"fuck") || stristr($username,"admin") || stristr($username,"moderator") || stristr($username,"shit") || stristr($username,"cock") || stristr($username,"pussy") || stristr($username,"dick") || stristr($username,"vagina") || stristr($username,"sex") || stristr($username,"anal") || stristr($username,"nigger") || stristr($username,"paki") || stristr($username,"nigga") || stristr($username,"bastard") || stristr($username,"bitch")){
								$error = 9;
							}
							elseif(!strstr($email,"@")){ // Make sure the email has an @
								$error = 10;
							}
							else{
								$time = time();
								mysql_query("INSERT INTO reg (user, pass, email, skype, forum, display, time) VALUES ('$username', '$pass', '$email', '$skype', '$forum', '$display', '$time')");
																$r = mysql_insert_id();
								$_SESSION['encrypted'] = $r;
								$page = 2;
							}
						}
					}
				}
			}
		}
	}
	if(isset($_POST['submitstep2'])){
		$trainer = $_POST['sprite'];
		if($trainer < '1' || $trainer > '28'){
			$page = 2;
			$error2 = 2;
			$problem = "The trainer sprite you picked is invalid.";
		}
		else{
			$resultx = mysql_query("SELECT * FROM pguide WHERE name = '{$_POST['spoke']}' AND starter = 1");
			$asd = mysql_num_rows($resultx);
			if($asd != 1){

				$page = 2;
				$error2 = 2;
				$problem = "The Pok&eacute;mon you picked is invalid.";
			}
			else{
				$sell = mysql_query("SELECT * FROM reg WHERE id = '{$_SESSION['encrypted']}'");
				if(mysql_num_rows($sell) == 0){
					$error = 1;
				}
				else{
					$selly = mysql_fetch_array($sell);
					$pass = md5($selly['pass']);
					$ctime = time();
					$sec_key = rand(12345678,98765432123456789);
					$secret_key = md5($sec_key);
					$number = rand(1,18);
					$ips = $_SERVER['REMOTE_ADDR'];
					mysql_query("INSERT INTO members (username, password, email, registered, llogin, ip, eb, number, secret_key) VALUES ('{$selly['user']}', '$pass', '{$selly['email']}', '$ctime', '$ctime', '$ips', '1', '$number', '$secret_key')");
					$vb = mysql_insert_id();
					mysql_query("INSERT INTO members_options (id, trainer, forum, skype, display, memonmap, messonoff, messnotifyonoff, layout) VALUES ('$vb', '{$_POST['sprite']}', '{$_POST['forum']}', '{$_POST['skype']}', '{$selly['display']}', '0', '0', '0', '2')");
					$row = mysql_fetch_array($resultx);
					$gendrand = rand(1,2);
					if($gendrand == 1){
						$gender = Male;
					}
					else if($gendrand == 2){
						$gender = Female;
					}
					mysql_query("INSERT INTO pokemon (name, pid, a1, a2, a3, a4, lvl, t1, t2, exp, rowner, owner) VALUES ('{$_POST['spoke']}', '{$row['id']}', '{$row['a1']}', '{$row['a2']}', '{$row['a3']}', '{$row['a4']}', '18', '{$row['type1']}', '{$row['type2']}', '9000', '{$selly['user']}', '{$vb}')");
					$h3 = mysql_insert_id();
						// Include the stat generating pages
					include('stats/ivs.php');
					include('stats/natures.php');
					include('stats/signupabilities.php');
					mysql_query("INSERT INTO pokemon_stats (id, hp_iv, attack_iv, defense_iv, spatk_iv, spdef_iv, speed_iv, nature, ability, ball, gender, ot) VALUES ('$h3', '$hp_iv', '$attack_iv', '$defense_iv', '$spatk_iv', '$spdef_iv', '$speed_iv', '$nature', '$ability', 'Poke Ball', '$gender', '{$selly['user']}')");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$_POST['spoke']}'");
					mysql_query("UPDATE members SET s1 = '$h3' WHERE id = '$vb'");
					mysql_query("INSERT INTO badges (id) VALUES ('$vb')");
					mysql_query("INSERT INTO events (id) VALUES ('$vb')");
					mysql_query("INSERT INTO comments (userid) VALUES ('$vb')");
					mysql_query("INSERT INTO items (uid) VALUES ('$vb')");
					mysql_query("DELETE FROM reg WHERE user = '{$selly['user']}'");
					mysql_query("DELETE FROM members WHERE username = ''");
					mysql_query("DELETE FROM beta_codes WHERE code = '{$_REQUEST['id']}'");
					unset($_SESSION['encrypted']);
					echo '<h2>Creating account, please wait.</h2><br /><img src="html/static/images/loading2.gif" width="400" height="400" />';
					echo '<meta http-equiv="Refresh" content="4; url=http://www.Pokemon-Shqipe.co.uk.com/login.php?reg=1">';
				}
			}
		}
	}
	if(isset($page) && $page == 2){
		// change this once the bets registration table is made
		echo '<form method="post" action="signup.php"><div style="text-align: center; margin: 0 auto;"><h2 style="margin-top: 25px;">Step 2: Select sprite and starting pokemon</h2>';
		if(isset($error2) && $error2 == 2){
			echo '<div class="errorMsg">' . $problem . '</div>';
		}
		echo '<h5>Select a sprite:</h5></div>
		<center>
		<table style="text-align: center; float: center;"><br/>
		<tr>
		<td width="20"><img src="html/static/images/sprites/top3.gif"><br/><img src="html/static/images/sprites/3.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="3" checked="checked" /></td>
		<td width="20"><img src="html/static/images/sprites/top4.gif"><br/><img src="html/static/images/sprites/4.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="4"/></td>
		<td width="20"><img src="html/static/images/sprites/top5.gif"><br/><img src="html/static/images/sprites/5.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="5"/></td>
		<td width="20"><img src="html/static/images/sprites/top6.gif"><br/><img src="html/static/images/sprites/6.gif" align="absmiddle"><br/><input type="radio" name="sprite" value="6"/></td>
		<td width="20"><img src="html/static/images/sprites/top7.gif"><br/><img src="html/static/images/sprites/7.gif" align="middle"><br/><input type="radio" name="sprite" value="7"/></td>
		<td width="20"><img src="html/static/images/sprites/top1.gif"><br/><img src="html/static/images/sprites/1.gif" align="middle"><br/><input type="radio" name="sprite" value="1"/></td>
		<td width="20"><img src="html/static/images/sprites/top2.gif"><br/><img src="html/static/images/sprites/2.gif" align="middle"><br/><input type="radio" name="sprite" value="2"/></td>
		<td width="20"><img src="html/static/images/sprites/top10.gif"><br/><img src="html/static/images/sprites/10.gif" align="middle"><br/><input type="radio" name="sprite" value="10"/></td>
		<td width="20"><img src="html/static/images/sprites/top11.gif"><br/><img src="html/static/images/sprites/11.gif" align="middle"><br/><input type="radio" name="sprite" value="11"/></td>
		<td width="20"><img src="html/static/images/sprites/top8.gif"><br/><img src="html/static/images/sprites/8.gif" align="middle"><br/><input type="radio" name="sprite" value="8"/></td>
		<td width="20"><img src="html/static/images/sprites/top9.gif"><br/><img src="html/static/images/sprites/9.gif" align="middle"><br/><input type="radio" name="sprite" value="9"/></td>
		<td width="20"><img src="html/static/images/sprites/top12.gif"><br/><img src="html/static/images/sprites/12.gif" align="middle"><br/><input type="radio" name="sprite" value="12"/></td>
		<td width="20"><img src="html/static/images/sprites/top13.gif"><br/><img src="html/static/images/sprites/13.gif" align="middle"><br/><input type="radio" name="sprite" value="13"/></td>
		<td width="20"><img src="html/static/images/sprites/top14.gif" align="middle"><br/><img src="html/static/images/sprites/14.gif" align="middle"><br/><input type="radio" name="sprite" value="14" align="middle"/></td>
		</tr></table>
		<table style="text-align: center; float: center;"><br/>
		<tr>
		<td width="20"><img src="html/static/images/sprites/top15.gif"><br/><img src="html/static/images/sprites/15.gif" align="middle"><br/><input type="radio" name="sprite" value="15"/></td>
		<td width="20"><img src="html/static/images/sprites/top16.gif"><br/><img src="html/static/images/sprites/16.gif" align="middle"><br/><input type="radio" name="sprite" value="16"/></td>
		<td width="20"><img src="html/static/images/sprites/top17.gif"><br/><img src="html/static/images/sprites/17.gif" align="middle"><br/><input type="radio" name="sprite" value="17"/></td>
		<td width="20"><img src="html/static/images/sprites/top18.gif"><br/><img src="html/static/images/sprites/18.gif" align="middle"><br/><input type="radio" name="sprite" value="18"/></td>
		<td width="20"><img src="html/static/images/sprites/top19.gif"><br/><img src="html/static/images/sprites/19.gif" align="middle"><br/><input type="radio" name="sprite" value="19"/></td>
		<td width="20"><img src="html/static/images/sprites/top20.gif"><br/><img src="html/static/images/sprites/20.gif" align="middle"><br/><input type="radio" name="sprite" value="20"/></td>
		<td width="21"><img src="html/static/images/sprites/top21.gif"><br/><img src="html/static/images/sprites/21.gif" align="middle"><br/><input type="radio" name="sprite" value="21"/></td>
		<td width="22"><img src="html/static/images/sprites/top22.gif"><br/><img src="html/static/images/sprites/22.gif" align="middle"><br/><input type="radio" name="sprite" value="22"/></td>
		<td width="23"><img src="html/static/images/sprites/top23.gif"><br/><img src="html/static/images/sprites/23.gif" align="middle"><br/><input type="radio" name="sprite" value="23"/></td>
		<td width="24"><img src="html/static/images/sprites/top24.gif"><br/><img src="html/static/images/sprites/24.gif" align="middle"><br/><input type="radio" name="sprite" value="24"/></td>
		<td width="25"><img src="html/static/images/sprites/top25.gif"><br/><img src="html/static/images/sprites/25.gif" align="middle"><br/><input type="radio" name="sprite" value="25"/></td>
		<td width="26"><img src="html/static/images/sprites/top26.gif"><br/><img src="html/static/images/sprites/26.gif" align="middle"><br/><input type="radio" name="sprite" value="26"/></td>
		<td width="27"><img src="html/static/images/sprites/top27.gif"><br/><img src="html/static/images/sprites/27.gif" align="middle"><br/><input type="radio" name="sprite" value="27"/></td>
		<td width="28"><img src="html/static/images/sprites/top28.gif"><br/><img src="html/static/images/sprites/28.gif" align="middle"><br/><input type="radio" name="sprite" value="28"/></td>
		</tr></table></center>
		<div style="text-align: center; margin: 0 auto;"><br/><br/>
		<h5>Select a starting Pokemon:</h5></div>';
		echo '<center>
		<table style="text-align: center; float: center;"><br/>
		<tr>
		<td><img src="html/static/images/pokemon/Bulbasaur.gif" /><br/><span class="small">Bulbasaur</span><br /><input type="radio" name="spoke" value="Bulbasaur" checked="checked"/></td>
		<td><img src="html/static/images/pokemon/Charmander.gif" /><br/><span class="small">Charmander</span><br /><input type="radio" name="spoke" value="Charmander"/></td>
		<td><img src="html/static/images/pokemon/Squirtle.gif" /><br/><span class="small">Squirtle</span><br /><input type="radio" name="spoke" value="Squirtle"/></td>
		<td><img src="html/static/images/pokemon/Pidgey.gif" /><br/><span class="small">Pidgey</span><br /><input type="radio" name="spoke" value="Pidgey"/></td>
		</tr>
		<tr>
		<td><img src="html/static/images/pokemon/Chikorita.gif" /><br/><span class="small">Chikorita</span><br /><input type="radio" name="spoke" value="Chikorita"/></td>
		<td><img src="html/static/images/pokemon/Cyndaquil.gif" /><br/><span class="small">Cyndaquil</span><br /><input type="radio" name="spoke" value="Cyndaquil"/></td>
		<td><img src="html/static/images/pokemon/Totodile.gif" /><br/><span class="small">Totodile</span><br /><input type="radio" name="spoke" value="Totodile"/></td>
		<td><img src="html/static/images/pokemon/Pichu.gif" /><br/><span class="small">Pichu</span><br /><input type="radio" name="spoke" value="Pichu"/></td>
		</tr>
		<tr>
		<td><img src="html/static/images/pokemon/Treecko.gif" /><br/><span class="small">Treecko</span><br /><input type="radio" name="spoke" value="Treecko"/></td>
		<td><img src="html/static/images/pokemon/Torchic.gif" /><br/><span class="small">Torchic</span><br /><input type="radio" name="spoke" value="Torchic"/></td>
		<td><img src="html/static/images/pokemon/Mudkip.gif" /><br/><span class="small">Mudkip</span><br /><input type="radio" name="spoke" value="Mudkip"/></td>
		<td><img src="html/static/images/pokemon/Poochyena.gif" /><br/><span class="small">Poochyena</span><br /><input type="radio" name="spoke" value="Poochyena"/></td>
		</tr>
		<tr>
		<td><img src="html/static/images/pokemon/Turtwig.gif" /><br/><span class="small">Turtwig</span><br /><input type="radio" name="spoke" value="Turtwig"/></td>
		<td><img src="html/static/images/pokemon/Chimchar.gif" /><br/><span class="small">Chimchar</span><br /><input type="radio" name="spoke" value="Chimchar"/></td>
		<td><img src="html/static/images/pokemon/Piplup.gif" /><br/><span class="small">Piplup</span><br /><input type="radio" name="spoke" value="Piplup"/></td>
		<td><img src="html/static/images/pokemon/Shinx.gif" /><br/><span class="small">Shinx</span><br /><input type="radio" name="spoke" value="Shinx"/></td>
		</tr>
		<tr>
		<td><img src="html/static/images/pokemon/Snivy.gif" /><br/><span class="small">Snivy</span><br /><input type="radio" name="spoke" value="Snivy"/></td>
		<td><img src="html/static/images/pokemon/Tepig.gif" /><br/><span class="small">Tepig</span><br /><input type="radio" name="spoke" value="Tepig"/></td>
		<td><img src="html/static/images/pokemon/Oshawott.gif" /><br/><span class="small">Oshawott</span><br /><input type="radio" name="spoke" value="Oshawott"/></td>
		<td><img src="html/static/images/pokemon/Lillipup.gif" /><br/><span class="small">Lillipup</span><br /><input type="radio" name="spoke" value="Lillipup"/></td>
		</tr>
		<tr>
		<td><img src="html/static/images/pokemon/Chespin.gif" /><br /><span class="small">Chespin</span><br /><input type="radio" name="spoke" value="Chespin"/></td>
		<td><img src="html/static/images/pokemon/Fennekin.gif" /><br /><span class="small">Fennekin</span><br /><input type="radio" name="spoke" value="Fennekin"/></td>
		<td><img src="html/static/images/pokemon/Froakie.gif" /><br /><span class="small">Froakie</span><br /><input type="radio" name="spoke" value="Froakie"/></td>
		<td><img src="html/static/images/pokemon/Bunnelby.gif" /><br /><span class="small">Bunnelby</span><br /><input type="radio" name="spoke" value="Bunnelby"/></td>
		</tr>
		</table><br/>
		<input type="submit" name="submitstep2" value="Complete Signup"></center>
		</form>';
	}
	if(isset($error) || !isset($_POST['submit']) && !isset($_POST['submitstep2'])){
		echo '
		<h2>Step 1: Enter User Information</h2><form method="post" id="signup">
		<p><strong>Required fields are in <span style="color:#990000">red</span>.</strong></p>';
		if(isset($error) && $error == 1){
			echo '<p /><div class="actionMsg">There was an error with your sign-up. Please try again.</div>'; }
		if($error == 5){ echo '<p /><div class="errorMsg">Not all required fields were filled out.</div>'; }
		if($error == 6){ echo '<p /><div class="errorMsg">Please read and accept our terms of service.</div>'; }
		if($error == 3){ echo '<p /><div class="errorMsg">Your passwords did not match. Please re-type them.</div>'; } 
		if($error == 4){ echo '<p /><div class="errorMsg">This username is already in use.</div>'; }
		if($error == 7){ echo '<p /><div class="errorMsg">You typed an incorrect number for the verification.</div>'; }
		if($error == 8){ echo '<p /><div class="errorMsg">You cannot use special characters in your username. Please only use A-Z, 0-9 or dashes and underscores.</div>'; }
		if($error == 9){ echo '<p /><div class="errorMsg">Your username contains an anappropriate word.</div>'; }
		if($error == 10){ echo '<p /><div class="errorMsg">The email address you entered is invalid</div>'; }
		echo '<table border="0" cellspacing="0" cellpadding="4" style="width: 500px; margin: 0 auto;">
		<tr>
		<td style="text-align: right; font-weight: bold; vertical-align: top;" nowrap="nowrap"><span style="color: #990000;">Username:</span></td>
		<td style="text-align: left;"><input name="user" tabindex="1" alt="Username" type="text" id="username" size="30" maxlength="30" ';
		
		if(is_numeric($error) && $error != 4){ echo 'value="' . $_POST['username'] . '"'; } 
		if($error == 4){ echo 'style="border-color:#00FF00;"'; }
		echo ' />
		<p><span class="small">This username will be used for logging in and cannot be changed, so choose wisely. Also, if you enter in spaces before or after your username, they will be trimmed off, so take note of that.</span></p><div class="errorBox" id="usernameErrorBox"></div></td>
		</tr>
		<tr>
		<td style="text-align: right; font-weight: bold; vertical-align: top;" nowrap="nowrap"><span style="color: #990000;">Password:</span></td>
		<td style="text-align: left;"><input name="pass" tabindex="2" alt="Password" type="password" id="password1" size="20" maxlength="20" ';
		
		if(is_numeric($error) && $error != 3){ echo 'value="' . $_POST['pass'] . '"'; }
		if($error == 3){ echo 'style="border-color:#00FF00;"'; }
		echo '/><div class="errorBox" id="newPasswordErrorBox"></div></td>
		</tr>
		<tr>
		<td style="text-align: right; font-weight: bold; vertical-align: top;" nowrap="nowrap"><span style="color: #990000;">Re-Type Password:</span></td>
		<td style="text-align: left;"><input name="pass2" tabindex="3" alt="Re-Type Password" type="password" id="password2" size="20" maxlength="20" ';
		
		if(is_numeric($error) && $error != 3){ echo 'value="' . $_POST['pass2'] . '"'; } 
		if($error == 3){ echo 'style="border-color:#00FF00;"'; }
		echo '/></td>
		</tr>
		<tr>
		<td style="text-align: right; font-weight: bold; vertical-align: top;" nowrap="nowrap"><span style="color: #990000;">E-mail Address:</span></td>
		<td style="text-align: left;"><input name="email" placeholder="example@domain.com" tabindex="4" alt="E-mail Address" type="text" id="email" size="40" maxlength="40" ';
		
		if(is_numeric($error)){ echo 'value="' . $_POST['email'] . '"'; } 
		echo '/>
		<p>Allow others to see your email address?<br /><input name="allow_email" type="radio" value="Yes" id="radio-yes" /><label for="radio-yes"> Yes</label>&nbsp;&nbsp;&nbsp;<input name="allow_email" type="radio" value="No" id="radio-no" checked="checked" /><label for="radio-no"> No</label></p><div class="errorBox" id="emailErrorBox"></div></td>
		</tr>
		<tr>
		<td style="text-align: right; font-weight: bold; vertical-align: top;" nowrap="nowrap">Skype Username:</td>
		<td style="text-align: left;"><input name="skype" tabindex="5" alt="Skype Username" type="text" id="skype" size="20" maxlength="20"';
		if(is_numeric($error)){ echo 'value="' . $_POST['skype'] . '"'; }
		echo ' />
		<br /><span class="small">(Leave blank if you don\'t have one)</span></td>
		</tr>
		<tr>
		<td style="text-align: right; font-weight: bold; vertical-align: top;" nowrap="nowrap">Forum Username:</td>
		<td style="text-align: left;"><input name="forum" tabindex="6" alt="Forum Username" type="text" id="forum" size="20" maxlength="20" ';
		if(is_numeric($error)){ echo 'value="' . $_POST['forum'] . '"'; } 
		echo ' />
		<br /><span class="small">(Leave blank if you don\'t have one)</span></td>
		</tr>
		<tr>
		<td style="text-align: right; font-weight: bold; vertical-align: top;" nowrap="nowrap"><br /><span style="color: #990000;">Image Text:</span></td>
		<td style="text-align: left;"><p>';
		
		require_once('recaptchalib.php');
		$publickey = "6Le7FAwAAAAAAAZC_sEbjvGX4TYMkWUdZzd5UM_m"; // you got this from the signup page
		echo recaptcha_get_html($publickey);
		
		echo '		</p><p>Please enter the text in the image above in the text box (case-insensitive!).</p></td>
		</tr><div class="errorBox" id="captchaErrorBox"></div>
		<tr>
		<td style="text-align: right; font-weight: bold;"><span style="color: #990000;">Terms Agreement:</span></td>
		<td style="text-align: left;"><input type="checkbox" name="terms" id="terms" value="agree" tabindex="9" alt="Terms Agreement" /> I have read and agree to the <a href="#" id="pop-up">Terms of Service</a>.</td>
		<div id="element_to_pop_up">
			<a class="b-close"><img src="html/static/images/close.gif"></a>';
			include('terms.php');
		echo '</div>
		</tr>
		</table>
		<p><input type="hidden" name="action" value="check"><input type="submit" name="submit" value="Continue Sign-Up" /></p>
		</form>';
	}
	if(!isset($_REQUEST['ajax'])){
		echo '</div></div>';
		include('disclaimer.php');
		echo '</div></div>
		</div>
		</div>
		</div>
		</body>
		<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
		</html>';
	}
	include('pv_disconnect_from_db.php'); ?>