<?php
include('kick.php');
session_start();

include('pv_connect_to_db.php');

mysql_query("SELECT * FROM members WHERE id = '516834'");
mysql_query("UPDATE members SET battle = battle + 1 WHERE id = '516834'");
mysql_query("UPDATE members SET totalexp = totalexp + 3000 WHERE id = '516834'");
mysql_query("UPDATE members SET averageexp = averageexp + 3000 WHERE id = '516834'");
mysql_query("UPDATE members SET money = money + 4312 WHERE id = '516834'");
mysql_query("SELECT exp FROM pokemon WHERE id = '9717950'");
mysql_query("UPDATE pokemon SET exp = exp + 3000 WHERE id = '9717950'");

mysql_query("SELECT * FROM members WHERE id = '16605'");
mysql_query("UPDATE members SET battle = battle + 1 WHERE id = '16605'");
mysql_query("UPDATE members SET totalexp = totalexp + 3300 WHERE id = '16605'");
mysql_query("UPDATE members SET averageexp = averageexp + 23 WHERE id = '16605'");
mysql_query("UPDATE members SET money = money + 4312 WHERE id = '16605'");
mysql_query("SELECT exp FROM pokemon WHERE id = '8374193'");
mysql_query("UPDATE pokemon SET exp = exp + 3300 WHERE id = '8374193'");

mysql_query("SELECT * FROM members WHERE id = '1'");
mysql_query("UPDATE members SET battle = battle + 1 WHERE id = '1'");
mysql_query("UPDATE members SET totalexp = totalexp + 3300 WHERE id = '1'");
mysql_query("UPDATE members SET averageexp = averageexp + 23 WHERE id = '1'");
mysql_query("UPDATE members SET money = money + 4312 WHERE id = '1'");
mysql_query("SELECT exp FROM pokemon WHERE id = '9531117'");
mysql_query("UPDATE pokemon SET exp = exp + 3300 WHERE id = '9531117'");

?>

 