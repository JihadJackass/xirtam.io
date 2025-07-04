<!-- User Nav -->
<?php
// GET TOTAL CHAT USERS
$ch = mysql_num_rows(mysql_query("SELECT id FROM flashchat_connections WHERE userid >= 1"));
// GET TOTAL NEW MESSAGES
$sm = mysql_num_rows(mysql_query("SELECT id FROM messages WHERE receiverid = '{$_SESSION['myid']}' AND receiverdelete = '1' AND receiverread = '1'"));
// GET POKEMON UP FOR TRADE WITH OFFERS ON
$trd = mysql_num_rows(mysql_query("SELECT offers FROM upfortrade WHERE owner = '{$_SESSION['myid']}' AND offers > 0"));
// GET CLAN REQUESTS
if($_SESSION['clanowner'] == 1){
	$claow = mysql_num_rows(mysql_query("SELECT * FROM clan_requests WHERE clan = '{$_SESSION['clan']}'"));
	$clanr = $claow;
}
else{
	$clame = mysql_num_rows(mysql_query("SELECT * FROM clan_requests WHERE id = '{$_SESSION['myid']}'"));
	$clanr = $clame;
}
?>
<div id="usernav">Logged in as: <a href="members.php?uid=<?php echo $_SESSION['myid']; ?>" onclick="membersTab('uid=<?php echo $_SESSION['myid']; ?>', 1); return false;" title="<?php echo $_SESSION['myuser']; ?>"><?php echo $_SESSION['myuser']; ?></a> | New Messages: <a href="/messages.php"><?=$sm?></a> | Trade Offers: <a href="/trade.php?cat=uft&order=offers"><?=$trd?></a> | Clan Requests: <a href="/clans.php?view=Requests"><?=$clanr?></a> | Chat Users: <a href="chat.php">20+</a></div>
<!-- End User Nav -->