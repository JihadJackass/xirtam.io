<?php
include('pv_connect_to_db.php');
$get_atk = mysql_query("SELECT * FROM attacks ORDER BY accuracy DESC");
echo '<table>
<th style="width: 150;">Attack</th>
<th style="width: 150;">Power</th>
<th style="width: 150;">Category</th>
<th style="width: 150;">Accuracy</th>';

while($attack = mysql_fetch_array($get_atk)){
	echo "<tr><td>{$attack['attack']}</td><td>{$attack['power']}</td><td>{$attack['category']}</td><td>{$attack['accuracy']}</td></tr>";
}
echo '</table>';
?>