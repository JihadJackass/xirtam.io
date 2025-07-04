<?php
include('kick.php');
include('pv_connect_to_db.php');

$total = mysql_query("SELECT * FROM sidequests");
$totall = mysql_num_rows($total);

$percent0 = $_SESSION['sidequest'] / $totall * 100;
$percent = round($percent0);
?>
<html>
<head>
<style>
.progress {
	width: 200px;
	height: 10px;
	border: 1px solid black;
	border-radius: 25px;
	overflow: hidden;
	margin-left: auto ;
	margin-right: auto ;
</style>
</head>
<body>
<?php

echo '<h5>Sidequest Progress</h5>
<div class="progress" style="align:center;">
<img src="html/static/images/misc/hpbar.gif" height="10" width="<?php echo '' . $percent . '';%" />
</div>
<b>' . $percent . '%</b>
';
?>
</body>
</html>
