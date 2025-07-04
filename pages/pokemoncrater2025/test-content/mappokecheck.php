<?php
include('pv_connect_to_db.php');
echo '<b>PID - Pok&eacute;mon Name - Dex No.</b><br />__________________________________________<p />';
$get_pkmn = mysql_query("SELECT * FROM pguide");
while($get_pkmnn = mysql_fetch_array($get_pkmn)){
	echo "{$get_pkmnn['id']} - {$get_pkmnn['name']} - {$get_pkmnn['dex_num']}<br />";
}
?>