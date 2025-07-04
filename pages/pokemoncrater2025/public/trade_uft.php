<p class="optionsList autowidth"><a href="trade.php" onclick="get('trade.php',''); return false;" class="deselected">Trade home</a> | <a href="trade.php?cat=puft" onclick="get('trade.php','cat=puft'); return false;" class="deselected">Select Pok&eacute;mon to put up for trade</a> | <a href="trade.php?cat=uft" onclick="get('trade.php','cat=uft'); return false;" class="selected">Pokemon up for trade</a> | <a href="trade.php?cat=offered" onclick="get('trade.php','cat=offered'); return false;" class="deselected">Pok&eacute;mon you have offered</a><br/><a href="trade.php?cat=notifications" onclick="get('trade.php','cat=notifications'); return false;" class="deselected">Recent trade notifications</a></p>
<div class="list autowidth" style="margin: 10px auto;">
<table cellpadding="5" cellspacing="0">
<tr>
<th><a href="trade.php?cat=uft" onclick="get('trade.php','cat=uft'); return false;" class="selected">Pok&eacute;mon</a></th>
<th style="width: 50px;"><a href="trade.php?cat=uft&order=level" onclick="get('trade.php','cat=uft&order=level'); return false;" class="selected">Level</a></th>
<th style="width: 70px;"><a href="trade.php?cat=uft&order=exp" onclick="get('trade.php','cat=uft&order=exp'); return false;" class="selected">Exp</a></th>
<th style="width: 100px;">Attacks</th>
<th style="width: 110px;"><a href="trade.php?cat=uft&order=offers" onclick="get('trade.php','cat=uft&order=offers'); return false;" class="selected">Actions</a></th>
<?php 
function updatepoints($user_id, $user_u, $te){
	$sideright = mysql_query("SELECT battle, id, total_poke FROM members WHERE id = '$user_id'");
	$sideright1 = mysql_fetch_array($sideright);
	$aiir = mysql_query("SELECT SUM(exp) FROM pokemon WHERE owner = '{$sideright1['id']}'");
	$aiir2 = mysql_fetch_array($aiir);
	$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY pid");
	$unique = mysql_num_rows($result);
	if($user_u == 1){
		unset($_SESSION['your_pokemon']);
		while($h = mysql_fetch_array($result)){
			$_SESSION['your_pokemon'][] = $h['pid'];
		}
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

if(is_numeric($_REQUEST['remove'])){
	$xz = mysql_query("SELECT pid FROM upfortrade WHERE owner = '{$_SESSION['myid']}' AND pid = '{$_REQUEST['remove']}'");
	$zx = mysql_num_rows($xz);
	if($zx == '1'){
		mysql_query("UPDATE pokemon SET owner = '{$_SESSION['myid']}', rowner = '{$_SESSION['myuser']}' WHERE id = '{$_REQUEST['remove']}'");
		mysql_query("DELETE FROM upfortrade WHERE pid = '{$_REQUEST['remove']}'");
		$vz = mysql_query("SELECT owner, rowner, id FROM utraded WHERE oid = '{$_REQUEST['remove']}'");
		$te = 0;
		while($zv = mysql_fetch_array($vz)){
			$te--;
			mysql_query("UPDATE pokemon SET owner = '{$zv['owner']}', rowner = '{$zv['rowner']}' WHERE id = '{$zv['id']}'");
			mysql_query("DELETE FROM utraded WHERE id = '{$zv['id']}'");
			$ower = $zv['owner'];
			updatepoints($ower, 0, $te);
		}
		updatepoints($_SESSION['myid'], 1, 1);
	}
}
if(isset($_REQUEST['order'])){
	if($_REQUEST['order'] == 'level'){
		$addon = 'ORDER BY lvl DESC';
		$rt = 'level';
	}
	elseif($_REQUEST['order'] == 'exp'){
		$addon = 'ORDER BY exp DESC';
		$rt = 'exp';
	}
	else{
		$addon = 'ORDER BY offers DESC';
		$rt = 'offers';
	}
	$rt = '&order=' . $rt;
}
else{
	$addon = 'ORDER BY name ASC';
}
$rt = 'cat=uft' . $rt;
$php_page = 'trade.php';
$table_used = 'upfortrade';
$query_used = 'WHERE owner = ' . $_SESSION['myid'];
$page = $_REQUEST['page'];
$page_name = $rt;
include('pagination.php');
$o = mysql_query("SELECT name, pid, a1, a2, a3, a4, lvl, exp, offers FROM upfortrade WHERE owner = '{$_SESSION['myid']}' $addon LIMIT $start, $limit");
$count = mysql_num_rows($o);
if($count == 0){
	?>
	<tr><td>No Pok&eacute;mon found.</td></tr>
	<?php
} ?>
</tr>
<?php
$i = 1;
while($oo = mysql_fetch_row($o)){
	$number += $i;
	?>
	<tr class="<?php if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>">
	<td style="height: 70px; text-align: left;"><img src="http://static.pokemon-vortex.com/images/pokemon/<?=$oo[0]; ?>.gif" /><strong><a href="pokedex.php?pid=<?=$oo[1]; ?>" onclick="pokedexTab('pid=<?=$oo[1]; ?>', 1); return false;"><?=$oo[0]; ?></a></strong></td><td style="width: 50px; height: 70px;"><?=$oo[6]; ?></td><td style="width: 70px; height: 70px;"><?=number_format($oo[7]); ?></td><td style="width: 100px; height: 70px;"><?=$oo[2]; ?><br /><?=$oo[3]; ?><br /><?=$oo[4]; ?><br /><?=$oo[5]; ?></td><td style="width: 110px; height: 70px;"><a href="view_offers.php?pid=<? echo $oo[1]; ?>">View Offers (<?=$oo[8]; ?>)</a><br/><br/><a onclick="get('trade.php','cat=uft&remove=<?=$oo[1]; ?>'); return false;" href="trade.php?cat=uft&remove=<?=$oo[1]; ?>">Remove</a></td></tr>
	<?php
} ?>
</table></div>
<p class="optionsList autowidth">
<?=$pagination;?></p>
