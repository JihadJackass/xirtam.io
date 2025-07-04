<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}

// Show the event page for Kyurem (Black) & Kyurem (White)

echo '<center><img src="http://static.pokemon-vortex.com/images/events/kyurem.png" alt="Kyurem (Black) & (White) Event" /><p />
Hello everyone!<br />Welcome to the next installment of Pok&eacute;mon Vortex\'s events - The long awaited Kyurem (Black) & Kyurem (White) event.<br />On this very special event, we present 
you with a challenge much more time consuming than usual. You must catch legendaries. That\'s right! We said it! Legendaries!<br />Now, before you give up without starting, let us explain what 
it is you have to do:<br /> This event can be broken down into simple steps, first you must purchase the DNA Splicers which costs <img src="http://static.pokemon-vortex.com/images/misc/pmoney.gif" alt="$" />500,000.
<br />This is a one-time purchase to allow you to be able to fuse Pok&eacute;mon together.<br />Once you have the DNA Splicers on your account, the fun begins...<br />
Now you need to get your hands on a Kyurem <b>AND</b> a Reshiram or Zekrom to fuse them together.<br />
There is a LOT to note about this event so please read the information below.<br /><br />';

$items = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}' LIMIT 1");
$dnasplicer = mysql_fetch_array($items);

if($dnasplicer['DNA_Splicers'] == '0'){
	echo '<img src="http://static.pokemon-vortex.com/images/items/DNA Splicers.png" alt="DNA Splicers" /><br />
	<img src="http://static.pokemon-vortex.com/images/misc/pmoney.gif" alt="$" />500,000 <p />
	<form action="event_center.php" id="action" method="post">
	<input type="hidden" name="buy_dna_splicers" id="buy_dna_splicers" value="buy_dna_splicers" />
	<input type="submit" name="submit" value="Purchase" />
	</form>';
}
elseif($dnasplicer['DNA_Splicers'] == '1'){
	echo '<img src="http://static.pokemon-vortex.com/images/items/DNA Splicers.png" alt="DNA Splicers" /> Your account has DNA Splicers attached, you are able to fuse Kyurem with Reshiram or Zekrom <img src="http://static.pokemon-vortex.com/images/items/DNA Splicers.png" alt="DNA Splicers" /><br /><br />';

	$get_kyurems = mysql_query("SELECT * FROM pokemon WHERE name LIKE '%Kyurem' AND owner = '{$_SESSION['myid']}' AND id != '{$_SESSION['my_team'][0]}' AND id != '{$_SESSION['my_team'][1]}' AND id != '{$_SESSION['my_team'][2]}' AND id != '{$_SESSION['my_team'][3]}' AND id != '{$_SESSION['my_team'][4]}' AND id != '{$_SESSION['my_team'][5]}'");
	$count_kyurems = mysql_num_rows($get_kyurems);

	$get_reshirams = mysql_query("SELECT * FROM pokemon WHERE name LIKE '%Reshiram' AND owner = '{$_SESSION['myid']}' AND id != '{$_SESSION['my_team'][0]}' AND id != '{$_SESSION['my_team'][1]}' AND id != '{$_SESSION['my_team'][2]}' AND id != '{$_SESSION['my_team'][3]}' AND id != '{$_SESSION['my_team'][4]}' AND id != '{$_SESSION['my_team'][5]}' OR name LIKE '%Zekrom' AND owner = '{$_SESSION['myid']}' AND id != '{$_SESSION['my_team'][0]}' AND id != '{$_SESSION['my_team'][1]}' AND id != '{$_SESSION['my_team'][2]}' AND id != '{$_SESSION['my_team'][3]}' AND id != '{$_SESSION['my_team'][4]}' AND id != '{$_SESSION['my_team'][5]}'");
	$count_reshirams = mysql_num_rows($get_reshirams);


	echo '
	<table style="width: 800px;">
	<form action="event_center.php" id="action" method="post">
	<tbody>
	<tr>
	<th style="width: 45%"><img src="http://static.pokemon-vortex.com/images/misc/pb.gif" /> Your Kyurems</th>
	<th style="width: 10%"> </th>
	<th style="width: 45%"><img src="http://static.pokemon-vortex.com/images/misc/pb.gif" /> Your Reshirams / Zekroms</th>
	</tr>
	<tr><td style="vertical-align: top;">
	<div class="list autowidth" style="width: 90%;">
	<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
	<tbody><tr>
	<th style="width: 55%;">Name</th>
	<th style="width: 15%;">Level</th>
	<th style="width: 30%;">Experience</th>
	</tr>';

	$number = 0;
	while($kyurems = mysql_fetch_array($get_kyurems)){
		$i = 1;
		$number += $i;
		if(checkNum($number) === TRUE){
			$class = 'dark';
		}
		else{
			$class = 'light';
		}
		echo '<tr class="' . $class . '" nowrap="nowrap"><td style="width: 55%;"><input type="radio"'; if($number == '1'){ echo 'checked="checked"'; } echo 'name="kyurem" id="kyurem" value="' . $kyurems['id'] . '" /> <strong>' . $kyurems['name'] . '</strong></td><td style="width: 15%;">' . $kyurems['lvl'] . '</td><td style="width: 30%;">' . number_format($kyurems['exp']) . '</td></tr>';
	}
	echo '</table></div></td>';

	echo '<td style="text-align: center;"><img src="http://static.pokemon-vortex.com/images/maps/arrows/arrow_right.gif" /><br /><input type="hidden" name="fuse_kyurem" id="fuse_kyurem" value="fuse_kyurem" /><input type="submit" id="submit" title="Fuse Kyurem" name="submit" value="Fuse" /><br /><img src="http://static.pokemon-vortex.com/images/maps/arrows/arrow_right.gif" /></td>';

	echo '<td style="vertical-align: top;">
	<div class="list autowidth" style="width: 90%;">
	<table style="width: 100%;" border="0" cellpadding="3" cellspacing="0">
	<tbody><tr>
	<th style="width: 55%;">Name</th>
	<th style="width: 15%;">Level</th>
	<th style="width: 30%;">Experience</th>
	</tr>';

	$number = 0;
	while($reshirams = mysql_fetch_array($get_reshirams)){
		$i = 1;
		$number += $i;
		if(checkNum($number) === TRUE){
			$class = 'dark';
		}
		else{
			$class = 'light';
	 	}
		echo '<tr class="' . $class . '" nowrap="nowrap"><td style="width: 55%;"><input type="radio"'; if($number == '1'){ echo 'checked="checked"'; } echo 'name="reshiram_zekrom" id="reshiram_zekrom" value="' . $reshirams['id'] . '" /> <strong>' . $reshirams['name'] . '</strong></td><td style="width: 15%;">' . $reshirams['lvl'] . '</td><td style="width: 30%;">' . number_format($reshirams['exp']) . '</td></tr>';
	}
	echo '</table></div></td></tr></form></table>';
}
?>

<!---------------------------- Event FAQ --------------------------->

<br /><h4>Kyurem (Black) & Kyurem (White) Event FAQ</h4>
<br />
<div style="text-align: left;">
<b>Q</b> - I just caught a Kyurem/Reshiram/Zekrom and I can't see it on the list but it's in my Pokemon, where is it?<br />
<b>A</b> - If you have put it in your team, you must remove it to fuse it. You can only fuse Pokemon that are currently in your storage.
<br /><br />
<b>Q</b> - When I fuse my Kyurem with a Reshiram or a Zekrom, do I lose the two original Pok&eacute;mon?<br />
<b>A</b> - Yes, you do. Your two fused Pok&eacute;mon will disappear and be replaced with the all powerful Kyurem (Black) or Kyurem (White).
<br /><br />
<b>Q</b> - Can I do more than one fusion?<br />
<b>A</b> - Yes. You can continue to fuse your Kyurems until the event is over and then it will no longer be available to do.
<br /><br />
<b>Q</b> - Do I need to buy the DNA Splicers after each fusion I do?<br />
<b>A</b> - No. The DNA Splicers is a one time purchase that will remain on your account forever, even if there is a similar event in the future.
<br /><br />
<b>Q</b> - Does the Kyurem and Reshiram/Zekrom have to be the same type to fuse them?<br />
<b>A</b> - Yes. For example, if the Kyurem you're trying to fuse is Shiny, then it must be fused with a Shiny Reshiram or Zekrom.
<br /><br />
<b>Q</b> - If my Kyurem is level 80 and my Zekrom is level 100, what level will my Kyurem (Black) be?<br />
<b>A</b> - Every time you fuse a Kyurem, the result will be level 100 no matter what level the Pok&eacute;mon were before fusing.
</div>
<br /><br />