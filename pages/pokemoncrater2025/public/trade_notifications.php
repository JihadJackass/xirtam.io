<p class="optionsList autowidth"><a href="trade.php" onclick="get('trade.php',''); return false;" class="deselected">Trade home</a> | <a href="trade.php?cat=puft" onclick="get('trade.php','cat=puft'); return false;" class="deselected">Select Pok&eacute;mon to put up for trade</a> | <a href="trade.php?cat=uft" onclick="get('trade.php','cat=uft'); return false;" class="deselected">Pok&eacute;mon up for trade</a> | <a href="trade.php?cat=offered" onclick="get('trade.php','cat=offered'); return false;" class="deselected">Pok&eacute;mon you have offered</a><br/><a href="trade.php?cat=notifications" onclick="get('trade.php','cat=notifications'); return false;" class="selected">Recent trade notifications</a></p>

<h2>Recent trade notifications:</h2>
<p>[ <a onclick="get('trade.php','cat=notifications&r=all'); return false;" href="trade.php?cat=notifications&r=all">Remove all recent trade notifications</a> ]</p>
<div class="list autowidth" style="margin: 10px auto;">

<table cellpadding="5" cellspacing="0">
<tr>
<th>Pok&eacute;mon</th>
<th style="width: 50px;">Level</th>
<th style="width: 70px;">Exp</th>
<th style="width: 100px;">Attacks</th>
<th style="width: 110px;">Actions</th>
<?php
if(isset($_REQUEST['r'])){
	if(is_numeric($_REQUEST['r'])){
		$notify1 = mysql_query("DELETE FROM unotify WHERE owner = '{$_SESSION['myid']}' AND id = '{$_REQUEST['r']}'");
	}
	if($_REQUEST['r'] == 'all'){
		$notify2 = mysql_query("DELETE FROM unotify WHERE owner = '{$_SESSION['myid']}'");
	}
}
$php_page = 'trade.php';
$table_used = 'unotify';
$query_used = 'WHERE owner = ' . $_SESSION['myid'];
$page = $_REQUEST['page'];
$page_name = 'cat=notifications';
include('pagination.php');

$get_notifications = mysql_query("SELECT * FROM unotify WHERE owner = '{$_SESSION['myid']}' LIMIT $start, $limit");
$num_rows = mysql_num_rows($get_notifications);
if($num_rows == 0){ 
	echo '<tr><td>No current notifications.</td></tr>';
}
echo '</tr>';
while($select = mysql_fetch_row($get_notifications)){
	$i = 1;
	$number += $i;
	$r = mysql_query("SELECT name, a1, a2, a3, a4, exp, lvl FROM pokemon WHERE id = '{$select[2]}'");
	$rr = mysql_fetch_row($r);
	?>
	<tr class="<?php if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>">
	<td style="height: 70px; text-align: left;"><img src="html/static/images/pokemon/<?=$rr[0]; ?>.gif" /><strong><a href="pokedex.php?pid=<?=$select[2]; ?>" onclick="pokedexTab('pid=<?=$select[2]; ?>', 1); return false;"><?=$rr[0]; ?></a></strong></td><td style="width: 50px; height: 70px;"><?=$rr[6]; ?></td><td style="width: 70px; height: 70px;"><?=number_format($rr[5]); ?></td><td style="width: 100px; height: 70px;"><?=$rr[1]; ?><br /><?=$rr[2]; ?><br /><?=$rr[3]; ?><br /><?=$rr[4]; ?></td><td style="width: 110px; height: 70px;"><strong><? if($select[5]=='0'){?>Received From:<?}else{?>Declined By:<?}?></strong><br /><a href="members.php?uid=<? echo $select[3]; ?>" onclick="membersTab('uid=<? echo $select[3]; ?>', 1); return false;"><? echo $select[4]; ?></a><br /><br /><a onclick="get('trade.php','cat=notifications&r=<? echo $select[0];?>'); return false;" href="trade.php?cat=notifications&r=<? echo $select[0];?>">Remove</a></td></tr>
	<?php
} ?>
</table></div><p class="optionsList autowidth">
<?=$pagination;?></p>