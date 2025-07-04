<?php
include('kick.php');
//Check the user has an active session
if(!isset($_SESSION['myid'])){
	include('pv_disconnect_from_db.php');
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
	exit();
}
//Include database connection
include('pv_connect_to_db.php');
mysql_query("UPDATE online SET activity = 'Dashboard' WHERE id = '{$_SESSION['myid']}'");

// Kyurem Event - Give the user an event ticket if they have not yet received one and have completed all gyms

$getticket = mysql_query("SELECT * FROM done_event WHERE id = '{$_SESSION['myid']}'");
$ticket = mysql_fetch_array($getticket);
if($ticket){
	// Do nothing
}
else{
	if($_SESSION['map_preferences'][0] == '1'){
		$giveticket = mysql_query("UPDATE items SET event_ticket = event_ticket + 1 WHERE uid = '{$_SESSION['myid']}'");
		$ins = mysql_query("INSERT INTO done_event (id, username, ip) VALUES ('{$_SESSION['myid']}', '{$_SESSION['myuser']}', '{$_SERVER['REMOTE_ADDR']}')");
	}
}

if($_POST['action'] == 'send'){
	if($_POST['code']){
		$_POST['code'] = mysql_real_escape_string($_POST['code']);
		// ONCE THE USER HAS PRESSED REDEEM CODE
		$checkk_code = mysql_query("SELECT * FROM promo_codes WHERE code = '{$_POST['code']}'");
		$check_code = mysql_fetch_array($checkk_code);
		if(!$check_code){
			// RETURN INVALID CODES
			echo '<div class="errorMsg">This code is invalid or has expired.<br />Please check you entered it correctly.</div>';
		}
		else{
			if($check_code['type'] == 'item'){
				$update_items = mysql_query("UPDATE items SET Master_Ball = Master_Ball + {$check_code['quantity']} WHERE uid = '{$_SESSION['myid']}'");
				if($update_items){
					mysql_query("DELETE FROM promo_codes WHERE code = '{$_POST['code']}'");
					echo '<div class="actionMsg">You claimed ' . $check_code['quantity'] . ' Master Balls</div>';
				}
			}
			else if($check_code['type'] == 'pokemon'){
				// Do Pokemon sequence
				$get_pkmn = mysql_query("SELECT * FROM pguide WHERE name = '{$check_code['prize']}'");
				$getpkmn = mysql_fetch_array($get_pkmn);
				mysql_query("INSERT INTO pokemon (name, pid, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES ('{$getpkmn['name']}', '{$getpkmn['id']}', '{$_SESSION['myid']}', '{$getpkmn['a1']}', '{$getpkmn['a2']}', '{$getpkmn['a3']}', '{$getpkmn['a4']}', '100', '{$getpkmn['type1']}', '{$getpkmn['type2']}', '50000', '{$_SESSION['myuser']}')");
				$h3 = mysql_insert_id();
				include('stats/ivs.php');
				include('stats/natures.php');
				include('stats/fossilabilities.php');
				mysql_query("INSERT INTO pokemon_stats (id, hp_iv, attack_iv, defense_iv, spatk_iv, spdef_iv, speed_iv, nature, ability, ot, gender, ball) VALUES ('$h3', '$hp_iv', '$attack_iv', '$defense_iv', '$spatk_iv', '$spdef_iv', '$speed_iv', '$nature', '$ability', '{$_SESSION['myuser']}', 'None', 'Cherish Ball')");
				mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$getpkmn['name']}'");
				$uniq = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid");
				$unique = mysql_num_rows($uniq);
				$account = mysql_query("SELECT totalexp, total_poke, battle FROM members WHERE id = '{$_SESSION['myid']}'");
				$acc = mysql_fetch_array($account);
				// Update Points
				$totalexp = $acc['totalexp'] + 50000;
				$avgexp = $totalexp / ($acc['total_poke'] + 1) ;
				$battle = $acc['battle'];
				$p1 = sqrt($totalexp);
				$p2 = sqrt($avgexp);
				$p3 = sqrt($unique);
				$p4 = log($battle);
				$p5 = $p1 * $p2 * $p3 * $p4;
				$p6 = $p5 / 1000;
				$p7 = round($p6, 1);
				mysql_query("UPDATE members SET total_poke = total_poke + 1, averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique', points = '$p7' WHERE id = '{$_SESSION['myid']}'");
				if(isset($_SESSION['clan'])){
					mysql_query("UPDATE clan_members SET exp = exp + 50000 WHERE id = '{$_SESSION['myid']}'");
					mysql_query("UPDATE clans SET exp = exp + 50000 WHERE name = '{$_SESSION['clan']}'");
					$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
					$clan_info = mysql_fetch_array($claninfo);
					$wins = $clan_info['wins'];
					$expp = $clan_info['exp'];
					$members = $clan_info['members'];
					$avegexp = $expp / $members;
					$po0 = sqrt($members);
					$po1 = sqrt($expp);
					$po2 = sqrt($avegexp);
					$po3 = log($wins);
					$po4 = $po1 * $po2 * $po3 * $po0;
					$po5 = $po4 / 10000;
					$po6 = round($po5, 1);
					mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
				}
				mysql_query("DELETE FROM promo_codes WHERE code = '{$_POST['code']}'");
				echo '<div class="actionMsg">You claimed a <b>' . $getpkmn['name'] . '</b>.</div>';
			}
			else if($check_code['type'] == 'event'){
				// Do event ticket sequence
			}
			else if($check_code['type'] == 'money'){
				$update_money = mysql_query("UPDATE members SET money = money + {$check_code['quantity']} WHERE id = '{$_SESSION['myid']}'");
				if($update_money){
					echo '<div class="actionMsg">You claimed <img src="html/static/images/misc/pmoney.gif">' . number_format($check_code['quantity']) . '</div>';
				}
			}
		}
	}
}
if(!$_REQUEST['ajax']){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js?"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js?1"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
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
echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css?1" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}
?>
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
<title>Pok&eacute;mon Shqipe v3</title>
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
<script>
$(function(){
   setTimeout(function(){
      if($("#headerAd").css('display')=="none")
      {
          $('body').html("<center><h2>Oh no, You have AdBlocker</h2><img src=\"html/static/images/pika_cry.gif\"><p />We noticed you have an active Ad Blocker.<br />Pok&eacute;mon Shqipe is 100% funded by advertisements, we promise our ads are of high quality and are unobtrusive.<br />Please whitelist this site from your ad blocker so we can continue to provide this website for as long as possible and for free.<br />Thank You.");
      }
  },1000);
});
</script>
</div>
<div id="title"><h1><a href="index.php"><em>pokemon-shqipe.co.uk</em></a></h1></div>
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

<table cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-left: 10px; vertical-align: top;">
      <div style="border-right: 2px solid #666666; padding-right: 10px; margin: 0 10px 0 0; text-align: left;">
        <!----------------------- News and version feature list ------------------------------->
<!-- <br /><iframe src="http://www.twitch.tv/pokemonvortexrpg/embed" frameborder="0" scrolling="no" height="378" width="620"></iframe> -->
<div class="betaMsg">
<center><h3>Rules and guidelines of Pok&eacute;mon Shqipe Beta</h3>
<br/>
<b>Bugs and glitches:</b></center><br /> All bugs and glitches must be reported to an admin. Any abuse of a bug will result in the permanent loss of your beta account.<br/>
If you do find a problem you'd like to be addressed, I.E (Account problems, something out of place, spelling errors and game functions not working correctly) You can contact me in the following ways:<br />
<u>Email:</u> admin@pokemon-shqipe.co.uk - Please title the email Pokemon Shqipe Beta.<br />
<u>Skype:</u> Shqipe<br />
<u>In-Game Message:</u> You can message me directly here in the game. Username is <i>Shqipe</i> <br /><br />
Please do not report bugs that are on the list below. Thank you.
<!---------- Bug list ---------->
<div class="noticeMsg"><center><b>Known bugs being fixed:</b></center>
<s>Message notifications not showing</s><br />
<s>Battle Chatelaine and Team Flare sprites not showing</s><br />
<s>Tyrogue only showing one evolution in the Pokedex tab</s>
<s>Not very effective showing up when neutral damage is dealt</s>
<s>Sleep status effect never ends</s><br />
<s>Pokemon still able to attack when frozen</s><br />
Steel type Pokemon are able to be poisoned<br />
Some items max out when you use them all<br />
Electric moves paralyz ground types<br />
<s>Gyarados missing from the Pokedex</s><br />
<s>Poliwhirl and Slowpoke evolutions only showing one evolution choice</s><br />
<s>Maximum money showing on some accounts</s><br />
<s>Clan points dropping to 0 after certain things done in the game</s><br />
Shadow Pokemon are not immune to status effects, this is not a bug it just hasn't been added yet while it's still tested.<br />
<s>There is no location guide yet. This is not a glitch, it's just unfinished.</s><br />
</div>
<!---------- End bug list --------->
<div class="actionMsg"><center><b>Sidequests added so far</b></center>
Kanto<br />
Johto<br />
Sevii Islands<br />
Navel Rock<br />
Birth Island<br />
TCG Island<br />
Orange Islands<br />
Hoenn<br /></div>
<br />
</div>
        
        <center><h1>Current Features Of Shqipe</h1></center>

        <h5>Day / Night</h5>
         You can now customise the maps to determine the time of day. In the options tab you can choose whether you want to search through the maps during the day or night.<br />
        (Please note the Pok&eacute;mon found are different during day and night)<br />As expected, you will find things such as Murkrow and Hoothoot only at night.
        
        <h5>In-Game Clans</h5>
        The biggest of v3's new features is the introduction of clans which was once just a forum based thing.<br />You can now create a clan (providing you have met the requirements), join another person's clan and work as a team to be the best. Battle for your clan, collect Pok&eacute;mon for your clan and more.<br />Clans have their own ranking leaderboard which is based on every member of that specific clan which will make a total point count. Things that effect the points are the same as a typical single account's points; Win count, experience, and members.
        
        <h5>New Pok&eacute;mon</h5>
         A big change is that Ancient Pok&eacute;mon have been removed and replaced with the classic "Metallic" type. Along with these, a whole new type has been implemented called Shadow. Every Pok&eacute;mon can be obtained in Metallic and Shadow for you to add to your collection.<br />
        What can Shadow type Pok&eacute;mon do? They are immunte to status effects.<br />
        Not only have two new types been added but there is some of the new Pok&eacute;mon from your favourite <a href="http://nintendo.com/" target="_BLANK">Nintendo</a> games. These Pok&eacute;mon include Mega evolutions and generation six Pok&eacute;mon from the Kalos region.
        These Pok&eacute;mon can be obtained in their respected ways in all six types; Normal, Shiny, Dark, Mystic, Metallic and Shadow.
        
        <h5>New Evolution Methods</h5>
        Along with the new Pok&eacute;mon come the new evolution methods for existing Pok&eacute;mon and the new Pok&eacute;mon from the Kalos region. Obtain Mega stones and varions other evolution items from the Pok&eacute;mart in the 'Your Account' tab at the top of the page.<br />Pok&eacute;mon now evolve based on happiness or gender as well as a whole load of items such as Magmarizer and Metal Coat.
        
        <h5>Fossil Lab</h5>
        One thing you may notice is Fossil Pok&eacute;mon are no longer on the maps - Instead you will have to obtain the pre-state fossils as prizes in the sidequest battles which can be found in the 'Battle' tab at the top of the page.<br />Once you've obtained a fossil, you can visit the Fossil Lab to have it resurrected back to it's Pok&eacute;mon living state. This applies for all fossil Pok&eacute;mon.
        
        <h5>Event Center</h5>
        The Event Center is where you'll go to take part in special events held here on Pok&eacute;mon Shqipe. To enter, you will need an 'Event Key' to unlock the page. These are one-time use items that will unlock the page to take part in the event.<br />You may be given an event key by Pok&eacute;mon Shqipe or you may have to win one, this depends on the event and how we choose to run that specific event.
        
        <h5>Pok&eacute;dex</h5>
        The Pok&eacute;dex side tab has had a re-design to make it more accessible on information for members.<br />You can now click a Pok&eacute;mon's name to bring up a detailed page about that Pok&eacute;mon which will specify things such as how many people own it, where it can be caught, evolutions/evolution methods and more.
        
        <h5>Sidequests</h5>
        The sidequests is now complete with every region from Kanto to Kalos which features over 1400 battles to get you prizes, ribbons, experience and wins.<br />Some prizes that can be won are exclusive and can only be obtained through sidequests such as fossils and Pok&eacute;mon forms.
        
        <h5>Nav Bar</h5>
        There is a new navigational bar that hovers at the top of every page which will track who you are logged in as, new messages, Pok&eacute;mon you have up for trade, clan requests and people online on our chat, all of which are quick links to their page where you can view them in more detail.
        
        <h5>Leaderboards</h5>
        There are three new leaderboards for you to work your way to the top of, along with the already mentioned top clans, there is also top Pok&eacute;mon and top richest.<br />Both can be accessed from the members tab<br /><br />
      </div>
    </td>
    
    <!-------------------------------------- Welcome message ----------------------------------------------->
    
    <td style="width: 350px; text-align: center; vertical-align: top;">
	<h5>Welcome <a href="members.php?uid=<?php echo $_SESSION['myid']; ?>" onclick="membersTab('uid=<?php echo $_SESSION['myid']; ?>', 1); return false;" title="<?php echo $_SESSION['myuser']; ?>"><?php echo $_SESSION['myuser']; ?></a></h5>
	<p>Your Messages: <a href="messages.php"><?=$sm?> New</a> | <a href="messages.php"><?=$ms?> Inbox</a></p>
    You have <a href="trade.php?cat=uft&order=offers"><?=$trd?> Pok&eacute;mon</a> up for trade with offers on.</p>
	<div id="ajax">
	<!---------------------------------- Promo code entry ----------------------------------------------->

	<h5>Promo Code Entry</h5>
	<form action="dashboard.php" id="action" method="post" onsubmit="get('dashboard.php', '', this); disableSubmitButton(this); return false;">
	<script>
	$(function () {
		var form = $("#action");

		var input1 = $("#code");


  		form.submit(function (evt) {
    			if (input1.val() == "") {
				evt.preventDefault();
			}
		});
	});
	</script>
	<input type="text" class="req" name="code" id="code" required="required" maxlength="32"><br />
	<input type="hidden" class="btn" id="action" name="action" value="send" /><input type="submit" name="submit" value="Redeem" />
	</form>
	</div>
      </p>
	<!-- <a href="http://www.pokemon-shqipe.co.uk/donate/donate.php" target="_BLANK"><img src="html/static/images/donate.png"></a></p> -->

	
	<!------------------------------- Test content ----------------------------------------------------->
	
	
      <noscript>
        <div class="noticeMsg">
          <strong>Notice:</strong> While this site does not require Javascript, it is recommended that Javascript be turned on for the best playing experience.
        </div>
      </noscript>
      <div class="hr"></div>
      
      <!-------------------------------- Game statistics ------------------------------------------------->
      
	<?php
	$onl = mysql_query("SELECT COUNT(*) FROM online");
	$online = mysql_fetch_row($onl);
	/* $pok = mysql_query("SELECT COUNT(*) FROM pokemon");
	$pokemon = mysql_fetch_row($pok);
	$mem = mysql_query("SELECT COUNT(*) FROM members");
	$members = mysql_fetch_row($mem);
	$trd = mysql_query("SELECT COUNT(*) FROM upfortrade");
	$uft = mysql_fetch_row($trd); */
	?>
      There are currently <?=number_format($online[0])?> members online.</p>
	<!-- <?=number_format($members[0])?> people have signed up to Pokemon Shqipe.</p>
	There are <?=number_format($uft[0])?> Pokemon up for trade.</p>
	<?=number_format($pokemon[0])?> Pokemon have been caught so far.</p> -->
      <p>
      <?php
include('/var/www/ads/squaread.php');
?>
	<p>
    </td>
  </tr>
</table>
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
include('pv_disconnect_from_db.php'); ?>