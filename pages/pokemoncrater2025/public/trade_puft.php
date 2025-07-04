<p class="optionsList autowidth"><a href="trade.php" onclick="get('trade.php',''); return false;" class="deselected">Trade home</a> | <a href="trade.php?cat=puft" onclick="get('trade.php','cat=puft'); return false;" class="selected">Select Pok&eacute;mon to put up for trade</a> | <a href="trade.php?cat=uft" onclick="get('trade.php','cat=uft'); return false;" class="deselected">Pokemon up for trade</a> | <a href="trade.php?cat=offered" onclick="get('trade.php','cat=offered'); return false;" class="deselected">Pokémon you have offered</a><br/><a href="trade.php?cat=notifications" onclick="get('trade.php','cat=notifications'); return false;" class="deselected">Recent trade notifications</a></p>
<?php
$time = time();
function updatepoints($te){
	$user_id = $_SESSION['myid'];
	$sideright = mysql_query("SELECT battle, id, total_poke FROM members WHERE id = '$user_id' LIMIT 1");
	$sideright1 = mysql_fetch_array($sideright);
	$aiir = mysql_query("SELECT SUM(exp) FROM pokemon WHERE owner = '{$sideright1['id']}'");
	$aiir2 = mysql_fetch_array($aiir);
	$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY pid");
	$unique = mysql_num_rows($result);
	unset($_SESSION['your_pokemon']);
	while($h = mysql_fetch_array($result)){
		$_SESSION['your_pokemon'][] = $h['pid'];
	}
	
	$totalexp = $aiir2['SUM(exp)'];
	$avgexp = $totalexp / ($sideright1['total_poke'] + $te);
	$battle = $sideright1['battle'];
	$p1 = sqrt($totalexp);
	$p2 = sqrt($avgexp);
	$p3 = sqrt($unique);
	$p4 = log($battle);
	$p5 = $p1 * $p2 * $p3 * $p4;
	$p6 = $p5 / 1000;
	$p7 = round($p6, 1);
	mysql_query("UPDATE members SET points = '$p7', total_poke = total_poke + $te, averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique' WHERE id = '$user_id'");
	if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
		mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
		$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
		$claexp = mysql_fetch_array($clanexp);
		mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
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
}

if(isset($_REQUEST['pid']) && is_numeric($_REQUEST['pid'])){
	$pid = mysql_real_escape_string($_REQUEST['pid']);
	$pokecheck = mysql_query("SELECT a1, a2, a3, a4, lvl, exp, id, owner, rowner, name FROM pokemon WHERE id = '$pid' AND owner = '{$_SESSION['myid']}'");
	$pokechec = mysql_num_rows($pokecheck);
	if($pokechec > 0){
		$slotcheck = mysql_query("SELECT s1, s2, s3, s4, s5, s6 FROM members WHERE id = '{$_SESSION['myid']}'");
		$slotchec = mysql_fetch_array($slotcheck);
		if($slotchec['s1'] == $pid || $slotchec['s2'] == $pid || $slotchec['s3'] == $pid || $slotchec['s4'] == $pid || $slotchec['s5'] == $pid || $slotchec['s6'] == $pid){
			echo '<div class="errorMsg">Sorry, but the pok&eacute;mon you have selected to put up for trade is currently in your team, so you can\'t put it up for trade. If you wish to put it up for trade, please remove it from your team.</div>';
		}
		else
		{
			$pokeche = mysql_fetch_array($pokecheck);
			mysql_query("INSERT INTO upfortrade (name, pid, owner, a1, a2, a3, a4, lvl, exp, rowner, date) VALUES ('{$pokeche['name']}', '{$pokeche['id']}', '{$pokeche['owner']}', '{$pokeche['a1']}', '{$pokeche['a2']}', '{$pokeche['a3']}', '{$pokeche['a4']}', '{$pokeche['lvl']}', '{$pokeche['exp']}', '{$pokeche['rowner']}', '$time')");
			mysql_query("UPDATE pokemon SET owner = '0', rowner = '' WHERE id = '{$pokeche['id']}' AND owner = '{$_SESSION['myid']}'");
			updatepoints(1);
			
			echo '<h3>Your '. $pokeche['name'] . ' has successfully been put up for trade!</h3><img src="/http://static.pokemon-vortex.com/images/pokemon/' . $pokeche['name'] . '.gif">';
		}
	}
	else
	{
		echo '<div class="errorMsg">Sorry, but the pok&eacute;mon you have selected to put up for trade doesn\'t exist, or doesn\'t belong to you.</div>';
	}
}

elseif(isset($_POST['put_up_for_trade'])){
	echo '<h2>The following Pok&eacute;mon have been put up for trade!</h2>';
	$box = $_POST['mycheckbox'];
	$dea = mysql_query("SELECT s1, s2, s3, s4, s5, s6 FROM members WHERE id ='{$_SESSION['myid']}'");
	$ead = mysql_fetch_array($dea);
	$te = 0;
	$quer = 'SELECT * FROM pokemon WHERE owner = ' . $_SESSION['myid'] . ' AND id IN(' . implode(',', $box) . ')';
	$get_poke = mysql_query($quer);
	while($ret_poke = mysql_fetch_array($get_poke)){
		$te++;
		$pokedata[] = '("' . $ret_poke['name'] . '", "' . $ret_poke['id'] . '", "' . $ret_poke['owner'] . '", "' . $ret_poke['a1'] . '", "' . $ret_poke['a2'] . '", "' . $ret_poke['a3'] . '", "' . $ret_poke['a4'] . '", "' . $ret_poke['lvl'] . '", "' . $ret_poke['exp'] . '", "' . $ret_poke['rowner'] . '", "' . $time . '")';  
echo '<img src="http://static.pokemon-vortex.com/images/pokemon/' . $ret_poke['name'] . '.gif"><br/><strong><a href="pokedex.php?pid=' . $ret_poke['id'] . '" onclick="pokedexTab(\'pid=' . $ret_poke['id'] . '\', 1); return false;">' . $ret_poke['name'] . '</a></strong><br/>';
	}
	
	if(mysql_num_rows($get_poke) != 0){
		
		$sql_query = 'INSERT INTO upfortrade (name, pid, owner, a1, a2, a3, a4, lvl, exp, rowner, date) VALUES' . implode(',', $pokedata);
		mysql_query($sql_query);
		mysql_query("UPDATE pokemon SET owner = '0', rowner = '' WHERE id IN(" . implode(',', $box) . ")");
	}
	updatepoints($te);
}
else
{
	$a = array('deselected','deselected','deselected','deselected','deselected','deselected','deselected');
	if(isset($_REQUEST['type'])){
		$type = $_REQUEST['type'];
		$r = mysql_query("SELECT s1, s2, s3, s4, s5, s6 FROM members WHERE id = '{$_SESSION['myid']}'");
		$re = mysql_fetch_object($r);
		$s1 = $re->s1;
		$s2 = $re->s2;
		$s3 = $re->s3;
		$s4 = $re->s4;
		$s5 = $re->s5;
		$s6 = $re->s6;
		
		if($type == 'All'){
			$a[0] = 'selected';
			$query = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id != '$s1' AND id != '$s2' AND id != '$s3' AND id != '$s4' AND id != '$s5' AND id != '$s6' ORDER BY name ASC");
		}
		elseif($type == 'Normal'){
			$a[1] = 'selected';
			$query = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND name NOT LIKE 'Dark %' AND name NOT LIKE 'Metallic %' AND name NOT LIKE 'Shiny %' AND name NOT LIKE 'Mystic %' AND name NOT LIKE 'Shadow %' AND id != '$s1' AND id != '$s2' AND id != '$s3' AND id != '$s4' AND id != '$s5' AND id != '$s6' ORDER BY name ASC");
		}
		else
		{
			if($type == 'Metallic'){
				$a[2] = 'selected';
			}
			if($type == 'Mystic'){
				$a[5] = 'selected';
			}
			if($type == 'Dark'){
				$a[4] = 'selected';
			}
			if($type == 'Shiny'){
				$a[3] = 'selected';
			}
			if($type == 'Shadow'){
				$a[6] = 'selected';
			}
			$query = mysql_query("SELECT id, name, lvl, exp FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND name LIKE '$type %' AND id != '$s1' AND id != '$s2' AND id != '$s3' AND id != '$s4' AND id != '$s5' AND id != '$s6' ORDER BY name ASC");
		}
	}
	?>
    
    <h2>Put Multiple Pok&eacute;mon Up For Trade:</h2>
    <p class="optionsList autowidth"><strong>View:</strong> <a href="trade.php?cat=puft&type=All" class="<?=$a[0];?>">All Your Pok&eacute;mon</a> | <a href="trade.php?cat=puft&type=Normal" class="<?=$a[1];?>">Normal</a> | <a href="trade.php?cat=puft&type=Metallic" class="<?=$a[2];?>">Metallic</a> | <a href="trade.php?cat=puft&type=Shiny" class="<?=$a[3];?>">Shiny</a> | <a href="trade.php?cat=puft&type=Dark"  class="<?=$a[4];?>">Dark</a> | <a href="trade.php?cat=puft&type=Mystic" class="<?=$a[5];?>">Mystic</a> | <a href="trade.php?cat=puft&type=Shadow" class="<?=$a[6];?>">Shadow</a></p>
    <div class="list mediumwidth" style="margin: 10px auto;height:600px;overflow:auto;">
    <form method="post">
    <table cellpadding="5" cellspacing="0">
    <tr>
    <th style="width: 200px;">Pok&eacute;mon</th>
    <th style="width: 50px;">Level</th>
    <th style="width: 70px;">Exp</th>
    </tr>
    
    <?php
    
	while($quer = mysql_fetch_row($query)){
		echo '<tr id="' . $quer[0] . '" class="dark"><td style="height: 70px; text-align: left;">
<input type="checkbox" onclick="checkbox(' . $quer[0] . ');" name="mycheckbox[]" value="' . $quer[0] . '" /><img src="http://static.pokemon-vortex.com/images/pokemon/' . $quer[1] . '.gif" />
<strong><a href="pokedex.php?pid=' . $quer[0] . '" onclick="pokedexTab(\'pid=' . $quer[0] . '\', 1); return false;">' . $quer[1] . '</a></strong></td><td style="width: 50px; height: 70px;">' . $quer[2] . '</td><td style="width: 70px; height: 70px;">' . number_format($quer[3]) . '</td></tr>';
	}
	
    echo '</table></div><p><input type="submit" name="put_up_for_trade" value="Put Up For Trade"/></p></form>';
}
?>
