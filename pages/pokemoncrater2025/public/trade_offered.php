<p class="optionsList autowidth"><a href="trade.php" onclick="get('trade.php',''); return false;" class="deselected">Trade home</a> | <a href="trade.php?cat=puft" onclick="get('trade.php','cat=puft'); return false;" class="deselected">Select Pok&eacute;mon to put up for trade</a> | <a href="trade.php?cat=uft" onclick="get('trade.php','cat=uft'); return false;" class="deselected">Pokemon up for trade</a> | <a href="trade.php?cat=offered" onclick="get('trade.php','cat=offered'); return false;" class="selected">Pokémon you have offered</a><br/><a href="trade.php?cat=notifications" onclick="get('trade.php','cat=notifications'); return false;" class="deselected">Recent trade notifications</a></p>

<h2>Pok&eacute;mon you have offered in trade:</h2>
<div class="list autowidth" style="margin: 10px auto;">
<table cellpadding="5" cellspacing="0">
<tr>
<th>Pok&eacute;mon</th>
<th style="width: 50px;">Level</th>
<th style="width: 70px;">Exp</th>
<th style="width: 100px;">Attacks</th>
<th style="width: 110px;">Actions</th>
<?php 
$tr = mysql_query("SELECT oid, name, id, lvl, exp, a1, a2, a3, a4, time FROM utraded WHERE owner = '{$_SESSION['myid']}'");
$trr = mysql_num_rows($tr);

if($trr == 0){ ?><tr><td>No current pok&eacute;mon offered.</td></tr><?php } ?>
</tr>
<?php
while($select = mysql_fetch_row($tr)){
$my = mysql_query("SELECT pid, name FROM upfortrade WHERE pid = '{$select[0]}'");
$mmy = mysql_fetch_row($my);

$i = 1;
$number += $i;
?>
<tr class="<?php if(checkNum($number) === TRUE){ echo 'dark'; } else { echo 'light'; } ?>">
<td style="height: 70px; text-align: left;"><img src="html/static/images/pokemon/<?=$select[1]; ?>.gif" /><strong><a href="pokedex.php?pid=<?=$select[2]; ?>" onclick="pokedexTab('pid=<?=$select[2]; ?>', 1); return false;"><?=$select[1]; ?></a></strong></td><td style="width: 50px; height: 70px;"><?=$select[3]; ?></td><td style="width: 70px; height: 70px;"><?=number_format($select[4]); ?></td><td style="width: 100px; height: 70px;"><?=$select[5]; ?><br /><?=$select[6]; ?><br /><?=$select[7]; ?><br /><?=$select[8]; ?></td><td style="width: 110px; height: 70px;"><strong>Offered For:</strong><br /><a href="pokedex.php?pid=<?=$mmy[0]; ?>" onclick="pokedexTab('pid=<?=$mmy[0]; ?>', 1); return false;"><?=$mmy[1]; ?></a><br /><br /><a href="make_an_offer.php?tid=<?=$select[0]; ?>&t=<?=$select[9];?>">Remove from trade</a></td></tr>
<? } ?>
</table></div>