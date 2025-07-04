<?php
include('kick.php');
session_start();

include('pv_connect_to_db.php');

mysql_query("SELECT * FROM members WHERE id = '11'");
mysql_query("UPDATE members SET battle = battle + 1 WHERE id = '11'");
mysql_query("UPDATE members SET money = money + 4319 WHERE id = '11'");
mysql_query("UPDATE members SET totalexp = totalexp + 3300 WHERE id = '11'");
mysql_query("UPDATE members SET averageexp = averageexp + 7 WHERE id = '11'");
mysql_query("SELECT exp FROM pokemon WHERE id = '9389049'");
mysql_query("UPDATE pokemon SET exp = exp + 3300 WHERE id = '9389049'");

?>