<?php

// Show the event page for Pikachu Cosplay forms
	
	echo '<center><img src="html/static/images/newyear2015.png" alt="New Year 2015 Event" /><p />
	Hello everyone!<br />Welcome to Pok&eacute;mon \'s first event of 2015 - Our New Year event.<br />On this very special event, we present you with a New Year challenge like no other.<br />How is it like no other you ask? It\'s simple, where usually we give you a set trainer to beat maybe with Pok&eacute;mon leveled around the 120 range for a prize if one Pokemon, this time we\'ve upped the test and extended the prizes!<br /><br />
	What do you have to do? I hear you ask. It\'s simple, all you need to do is go to the maps and catch one of each <b>normal</b> type of Unown<br />Yes, every single one. That\'s A to Z as well as ? and !.<br />Once you have done this, come back to this page and claim your promo code for an exclusive (and random) Cosplay Pikachu. These promo codes can be redeemed on the <a href="/dashboard">dashboard</a> page to claim your Pikachu in one of it\'s six types.<br />
	BUT WAIT! THERE\'S MORE! You\'re probably thinking "Oh, well I could do it once and just trade them all to other accounts for more Pikachu\'s" WRONG! They all need to be caught on the same account you\'re using and have the same "Original Trainer" so you cannot use Unowns you get from a trade.<br /><br /><br />';
	
	$dun_event = mysql_query("SELECT * FROM done_event WHERE id = '{$_SESSION['myid']}'"); // Check if they've claimed a code yet
	$dun = mysql_num_rows($dun_event);
	if($dun == '0'){
		// Do Pokemon check for Unowns
		echo '<form action="event_center.php" id="action" method="post">
		<input type="hidden" name="claim_code_1_pikachu" id="claim_code_1_pikachu" value="claim_code_1_pikachu" />
		<input type="submit" name="submit" value="Check My Unowns" />
		</form>
		';
	}
	elseif($dun == '1'){
		$get_code = mysql_query("SELECT * FROM promo_codes WHERE owner = '{$_SESSION['myid']}' LIMIT 1");
		$code = mysql_fetch_array($get_code);
		if($code){
			echo '<h3>Your Promo Code:</h3>Congratulations, you\'ve completed the New Year 2015 event.<br />You can use the following promo code to claim a special Pikachu on the Dasboard.<br /><div class="promoCode"><strong><font color="red">' . $code['code'] . '</font></strong></div>';
		}
		elseif(!$code){
			echo '<h3>Your Promo Code:</h3>Congratulations, you\'ve completed the New Year 2015 event.<br />You can use the following promo code to claim a special Pikachu on the Dasboard.<br /><div class="promoCode"><strong><font color="red">You have used your code.</font></strong></div>';
		}
	}

?>