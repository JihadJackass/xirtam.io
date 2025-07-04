<h2>Search Results:</h2>
<?php
//---------------------- Timing how long ago a trade was added ------------------------------//
function lengthTiming($time){
	$time = time() - $time; // to get the time since that moment
	$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
	);

	foreach ($tokens as $unit => $text){
		if($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	}
}
//------------------------------- End timing -----------------------------------------//
$php_page = 'trade.php';
$table_used = 'upfortrade';
if(is_numeric($_REQUEST['page'])){
	$page = $_REQUEST['page'];
}
if($_REQUEST['type'] == 'Username'){
	$_REQUEST['search'] = mysql_real_escape_string($_REQUEST['search']);
	$query_used = 'WHERE rowner = \'' . $_REQUEST['search'] . '\' ORDER BY name';
	$page_name = 'type=' . $_REQUEST['type'] . '&search=' . $_REQUEST['search'];
	$page_this = $page_name;
	if($_REQUEST['order']){
		$page_name = 'type=' . $_REQUEST['type'] . '&search=' . $_REQUEST['search'] . '&order=' . $_REQUEST['order'];
		$query_used = 'WHERE rowner = \'' . $_REQUEST['search'] . '\' ORDER BY exp DESC';
		if($_REQUEST['order'] == 'level'){
			$query_used = 'WHERE rowner = \'' . $_REQUEST['search'] . '\' ORDER BY lvl DESC';
		}
		elseif($_REQUEST['order'] == 'added'){
			$query_used = 'WHERE rowner = \'' . $_REQUEST['search'] . '\' ORDER BY date DESC';
		}
	}
}
else{
	$_REQUEST['ptype'] = mysql_real_escape_string($_REQUEST['ptype']);
	$_REQUEST['pokemon'] = mysql_real_escape_string($_REQUEST['pokemon']);
	$query_used = 'WHERE BINARY name LIKE \'' . $_REQUEST['ptype'] . $_REQUEST['pokemon'] . '\' ORDER BY name';
	$page_name = 'type=' . $_REQUEST['type'] . '&pokemon=' . $_REQUEST['ptype'] . $_REQUEST['pokemon'];
	$page_this = $page_name;
	if($_REQUEST['order']){
		$page_name = 'type=' . $_REQUEST['type'] . '&pokemon=' . $_REQUEST['ptype'] . $_REQUEST['pokemon'] . '&order=' . $_REQUEST['order'];
		$query_used = 'WHERE BINARY name LIKE \'' . $_REQUEST['ptype'] . $_REQUEST['pokemon'] . '\' ORDER BY exp DESC';

		if($_REQUEST['order'] == 'level'){
			$query_used = 'WHERE BINARY name LIKE \'' . $_REQUEST['ptype'] . $_REQUEST['pokemon'] . '\' ORDER BY lvl DESC';
		}
		if($_REQUEST['order'] == 'added'){
			$query_used = 'WHERE BINARY name LIKE \'' . $_REQUEST['ptype'] . $_REQUEST['pokemon'] . '\' ORDER BY date DESC';
		}
	}
}
include('pagination.php');
$search_uft = mysql_query("SELECT * FROM $table_used $query_used LIMIT $start, $limit");
$num_rows = mysql_num_rows($search_uft);
if($num_rows == 0){ 
	echo '<div class="errorMsg">We could not find an exact match to the pok&eacute;mon or trainer you specified. This could also mean that the trainer you specified has no pok&eacute;mon up for trade.</div>';
}
else{
	echo '<div class="list autowidth" style="margin: 10px auto;">
	<table cellpadding="5" cellspacing="0">
	<tr>
	<th><a href="/trade.php?' . $page_this . '" onclick="get(\'trade.php\',\'' . $page_this . '\'); return false;" class="selected">Pok&eacute;mon</a></th>
	<th style="width: 80px;"><a href="trade.php?' . $page_this . '&order=added" onclick="get(\'trade.php\',\'' . $page_this . '&order=added\'); return false;" class="selected">Added</a></th>
	<th style="width: 50px;"><a href="trade.php?' . $page_this . '&order=level" onclick="get(\'trade.php\',\'' . $page_this . '&order=level\'); return false;" class="selected">Level</a></th>
	<th style="width: 70px;"><a href="trade.php?' . $page_this . '&order=exp" onclick="get(\'trade.php\',\'' . $page_this . '&order=exp\'); return false;" class="selected">Exp</a></th>
	<th style="width: 100px;">Attacks</th>
	<th style="width: 110px;">Actions</th>';
	$i = 1;
	while($var = mysql_fetch_array($search_uft)){
		$number += $i;
		if(checkNum($number) === TRUE){ $vart = 'dark'; } else { $vart = 'light'; }

		$time = $var['date'];

		echo '<tr class="' . $vart . '"><td style="height: 70px; text-align: left;"><img src="http://static.pokemon-vortex.com/images/pokemon/' . $var['name'] . '.gif" /><strong><a href="pokedex.php?pid=' . $var['pid'] . '" onclick="pokedexTab(\'pid=' . $var['pid'] . '\', 1); return false;">' . $var['name'] . '</a></strong></td><td style="width: 80px; height: 70px;">' . lengthTiming($time) . ' ago</td><td style="width: 50px; height: 70px;">' . $var['lvl'] . '</td><td style="width: 70px; height: 70px;">' . number_format($var['exp']) . '</td><td style="width: 100px; height: 70px;">' . $var['a1'] . '<br />' . $var['a2'] . '<br />' . $var['a3'] . '<br />' . $var['a4'] . '</td><td style="width: 110px; height: 70px;"><strong>Owner:</strong><br /><a href="members.php?uid=' . $var['owner'] . '" onclick="membersTab(\'uid=' . $var['owner'] . '\', 1); return false;">' . $var['rowner'] . '</a><br /><br /><a href="make_an_offer.php?pid=' . $var['pid'] . '">Make an offer</a></td></tr>';
	}
	echo '</table></div>';
} ?>
<p class="optionsList autowidth">
<?=$pagination;?></p>


