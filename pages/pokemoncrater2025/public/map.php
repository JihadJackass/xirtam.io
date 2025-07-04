<?php
$timyi = microtime();
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}

if($_SESSION['access'] == 9){
	include('pv_connect_to_db.php');

	$div_scramble = rand(1622,9581);

	$_REQUEST['map'] = max(min((int)$_REQUEST['map'],25),1);

	if($_SESSION['mapp'] != $_REQUEST['map']){
		unset($_SESSION['mapx']);
		unset($_SESSION['mapy']);
	}
	if(!$_SESSION['map'] && !$_REQUEST['map']){
		header("location:map_select.php");
	}
	mysql_query("UPDATE online SET activity = 'Searching map {$_REQUEST['map']} for Pok�mon' WHERE id = '{$_SESSION['myid']}'");

	$first = $_SESSION['myid'];


	$traine = $_SESSION['map_preferences'][2];
	$map = $_SESSION['map'];
	if($_REQUEST['map']&& is_numeric($_REQUEST['map'])){
		$map = $_REQUEST['map'];
	}
	$xarray = array("27","6","16","5","6");
	$yarray = array("6","6","9","12","12");
	if($map == 2){
		$xarray = array("27","8","14","3","22");
		$yarray = array("9","8","20","22","20");
	}
	if($map == 3){
		$xarray = array("10","7","16","25","27");
		$yarray = array("15","20","9","21","12");
	}
	if($map == 4){
		$xarray = array("21","27","15","8","8");
		$yarray = array("9","17","14","11","19");
	}
	if($map == 5){
		$xarray = array("22","25","16","10","6");
		$yarray = array("6","14","18","21","9");
	}
	if($map == 6){
		$xarray = array("6","16","22","28","6");
		$yarray = array("21","20","19","13","12");
	}
	if($map == 7){
		$xarray = array("18","22","16","18","6");
		$yarray = array("21","13","9","8","12");
	}
	if($map == 8){
		$xarray = array("8","12","18","18","6");
		$yarray = array("17","12","21","7","12");
	}
	if($map == 9){
		$xarray = array("26","12","16","18","6");
		$yarray = array("6","22","9","7","12");
	}
	if($map == 10 || $map == 11){
		$xarray = array("27","6","17","18","6");
		$yarray = array("6","6","11","7","12");
	}
	if($map == 12){
		$xarray = array("27","6","16","18","6");
		$yarray = array("6","7","10","7","12");
	}
	if($map == 15){
		$xarray = array("27","6","16","18","6");
		$yarray = array("6","6","9","7","14");
	}
	if($map == 19){
		$xarray = array("27","6","16","18","6");
		$yarray = array("12","6","9","7","12");
	}
	if($map == 21){
		$xarray = array("27","13","16","18","6");
		$yarray = array("6","7","9","7","12");
	}
	if($map == 23){
		$xarray = array("27","6","16","18","6");
		$yarray = array("6","6","9","8","12");
	}

	$random_number = rand(0,4);
	$xxarray = $xarray[$random_number];
	$yyarray = $yarray[$random_number];
	if(is_numeric($_SESSION['mapx']) && is_numeric($_SESSION['mapy'])){
		$xxarray = $_SESSION['mapx'];
		$yyarray = $_SESSION['mapy'];
	}
	unset($_SESSION['mapx'],$_SESSION['mapy']);
	$_SESSION['map'] = $map;
	$max1 = "1800";
	$time = time();
	$time2 = $time - $max1;
	mysql_query("DELETE FROM mapusers WHERE id = '$first' OR time < '$time2'");
	if($first){
		mysql_query("INSERT INTO mapusers (map, id, x, y, username, trainer, time) VALUES('$map', '$first', '$xxarray', '$yyarray', '{$_SESSION['myuser']}', '$traine', '$time' ) "); 
	}


	$omo = $_SESSION['map_preferences'][1];
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/map.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/movement.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js" ></script>
<script type="text/javascript">
function updatePkmn() {
	var url="/includes/feed.php";
	jQuery("#getPkmn").load(url).hide().fadeIn(3000).delay(4000).fadeOut(3000);
}
setInterval("updatePkmn()", 10000);
</script>
<?php
if($_SESSION['layout'] == '1'){
echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />';
echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
}
if($_SESSION['layout'] == '0'){
echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />';
echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
if($_SESSION['layout'] == '2'){
echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css?1" media="screen" />';
echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}

?>
<link rel="stylesheet" type="text/css" href="html/static/css/mapv3.css?1" media="screen" />
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie6-.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie7+.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie7+.css" media="screen" />
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <link rel="icon" href="/favicon.png" type="image/x-icon" /> 
    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<title>Shqipe Battle Arena v3 - Explore Maps</title>
	<?php
	if($omo == '0'){
		$sql = mysql_query("SELECT * FROM mapusers WHERE map = '$map' AND id != '$first'");
		$countusers = mysql_num_rows($sql);

		while($getevery = mysql_fetch_object($sql)) 
		{
			$userid2[] = $getevery->id;
			$trainerx2[] = $getevery->x;
			$trainery2[] = $getevery->y;
			$trainer2[] = $getevery->trainer;
			$username2[] = $getevery->username; 
		}
	}
	echo '<script type="text/javascript">';
	if($omo == '0'){
		if($countusers > '0'){
			$w = implode("\",\"",$userid2);
			$ww = implode("\",\"",$trainerx2);
			$www = implode("\",\"",$trainery2);
			foreach ($username2 as $k => $u) {
				$username2[$k] = htmlentities($u);
			}
			$wwww = implode("\",\"",$username2);
			$wwwww = implode("\",\"",$trainer2);

			echo 'var userid = new Array("' . $w . '");
			';
			echo 'var playerx = new Array("' . $ww . '");
			';
			echo 'var playery = new Array("' . $www . '");
			';
			echo 'var usern = new Array("' . $wwww . '");
			';
			echo 'var trainers = new Array("' . $wwwww . '");
			';
		}
	}
	echo 'var loadMap = function(){
		getMap(' . $xxarray . ',' . $yyarray . ',11);


		loadPlayers(' . $xxarray . ',' . $yyarray . ');


	}
	var AjaxMove = function(xnew,ynew,direction){
	var battle = 0;
	var new_map = 0;
	var x_map = 0;
	var y_map = 0;';
			

	switch($map){
		case 1:
		echo 'if(xnew == "31"){
			new_map = 4; x_map = 1; y_map = ynew;
		}
		else if(ynew == "26"){
			new_map = 2; x_map = xnew; y_map = 2;
		}
		else if(xnew == "7" && ynew == "3"){
			new_map = 22; x_map = 15; y_map = 24;
		}';
		break; 
		case 2:
		echo 'if(ynew == "1"){
			new_map = 1; x_map = xnew; y_map = 25;
		}
		else if(xnew == "31"){
			new_map = 5; x_map = 1; y_map = ynew;
		}
		else if(ynew == "26"){
			new_map = 3; x_map = xnew; y_map = 2;
		}';
		break;
		case 3:
		echo 'if(ynew == "1"){
			new_map = 2; x_map = xnew; y_map = 25;
		}
		else if(xnew == "31"){
			new_map = 6; x_map = 1; y_map = ynew;
		}
		else if(ynew == "18" && xnew == "14"){
			new_map = 12; x_map = 15; y_map = 24;
		}';
		break;
		case 4:
		echo 'if(xnew == "0"){
			new_map = 1; x_map = 30; y_map = ynew;
		}
		else if(xnew == "31"){
			new_map = 7; x_map = 1; y_map = ynew;
		}';
		break;
		case 5:
		echo 'if(xnew == "31"){
			new_map = 8; x_map = 1; y_map = ynew;
		}
		else if(xnew == "0"){
			new_map = 2; x_map = 30; y_map = ynew;
		}';
		break;
		case 6:
		echo 'if(xnew == "31"){
			new_map = 9; x_map = 1; y_map = ynew;
		}
		else if(xnew == "0"){
			new_map = 3; x_map = 30; y_map = ynew;
		}';
		break;
		case 7:
		echo 'if(xnew == "0"){
			new_map = 4; x_map = 30; y_map = ynew;
		}
		else if(ynew == "26"){
			new_map = 8; x_map = xnew; y_map = 2;
		}
		else if(xnew == "24" && ynew == "9"){
			new_map = 21; x_map = 21; y_map = 24;
		}'; 
		break;
		case 8:
		echo 'if(xnew == "0"){
			new_map = 5; x_map = 30; y_map = ynew;
		}
		else if(ynew == "1"){
			new_map = 7; x_map = xnew; y_map = 25;
		}
		else if(ynew == "26"){
			new_map = 9; x_map = xnew; y_map = 2;
		}
		else if(ynew == "9" && xnew == "6"){
			new_map = 16; x_map = 9; y_map = 25;
		}';
		break;
		case 9:
		echo 'if(xnew == "0"){
			new_map = 6; x_map = 30; y_map = ynew;
		}
		else if(ynew == "1"){
			new_map = 8; x_map = xnew; y_map = 25;
		}';
		break;
		case 10:
		echo 'if(ynew == "26"){
			new_map = 11; x_map = xnew; y_map = 2;
		}
		else if(xnew == "31"){
			new_map = 13; x_map = 1; y_map = ynew;
		}';
		break;
		case 11:
		echo 'if(ynew == "26"){
			new_map = 12; x_map = xnew; y_map = 2;
		}
		else if(ynew == "1"){
			new_map = 10; x_map = xnew; y_map = 25;
		}
		else if(xnew == "31"){
			new_map = 14; x_map = 1; y_map = ynew;
		}';
		break;
		case 12:
		echo 'if(ynew == "1"){
			new_map = 11; x_map = xnew; y_map = 25;
		}
		else if(xnew == "31"){
			new_map = 15; x_map = 1; y_map = ynew;
		}
		else if(xnew == "15" && ynew == "25"){
			new_map = 3; x_map = 14; y_map = 19;
		}';
		break;
		case 13:
		echo 'if(ynew == "26"){
			new_map = 14; x_map = xnew; y_map = 2;
		}
		else if(xnew == "0"){
			new_map = 10; x_map = 30; y_map = ynew;
		}';
		break;
		case 14:
		echo 'if(ynew == "26"){
			new_map = 15; x_map = xnew; y_map = 2;
		}
		else if(ynew == "1"){
			new_map = 13; x_map = xnew; y_map = 25;
		}
		else if(xnew == "0"){
			new_map = 11; x_map = 30; y_map = ynew;
		}
		';
		break;
		case 15:
		echo 'if(ynew == "1"){
			new_map = 14; x_map = xnew; y_map = 25;
		}
		else if(xnew == "0"){
			new_map = 12; x_map = 30; y_map = ynew;
		}';
		break;
		case 16:
		echo 'if(xnew == "31"){
			new_map = 17; x_map = 1; y_map = ynew;
		}
		else if(ynew == "26"){
			new_map = 8; x_map = 6; y_map = 10;
		}';
		break;
		case 17:
		echo 'if(xnew == "0"){
			new_map = 16; x_map = 30; y_map = ynew;
		}';
		break;
		case 18:
		echo 'if(xnew == "31"){
			new_map = 20; x_map = 1; y_map = ynew;
		}
		else if(ynew == "26"){
			new_map = 19; x_map = xnew; y_map = 1;
		}';
		break;
		case 19:
		echo 'if(ynew == "0"){
			new_map = 18; x_map = xnew; y_map = 25;
		}
		else if(xnew == "31"){
			new_map = 21; x_map = 1; y_map = ynew;
		}';
		break;
		case 20:
		echo 'if(ynew == "26"){
			new_map = 21; x_map = xnew; y_map = 1;
		}
		else if(xnew == "0"){
			new_map = 18; x_map = 30; y_map = ynew;
		}';
		break;
		case 21:
		echo 'if(xnew == "0"){
			new_map = 19; x_map = 30; y_map = ynew;
		}
		else if(ynew == "0"){
			new_map = 20; x_map = xnew; y_map = 25;
		}
		else if(xnew == "21" && ynew == "25"){
			new_map = 7; x_map = 24; y_map = 10;
		}';
		break;
		case 22:
		echo 'if(ynew == "0"){
			new_map = 23; x_map = xnew; y_map = 25;
		}
		else if(xnew == "15" && ynew == "25"){
			new_map = 1; x_map = 7; y_map = 4;
		}';
		break;
		case 23:
		echo 'if(ynew == "26"){
			new_map = 22; x_map = xnew; y_map = 1;
		}';
		break;
		case 24:
		echo 'if(ynew == "26"){
			new_map = 25; x_map = xnew; y_map = 1;
		}';
		break;
		case 25:
		echo 'if(ynew == "0"){
			new_map = 24; x_map = xnew; y_map = 25;
		}';
	}
	echo '
	else{
		getMap(xnew,ynew,direction);
	}
	if(new_map !== 0){
		var request = new AjaxRequest();
		request.method = \'post\';
		request.url = \'xml/map.php\';
		request.query = \'map=\' + new_map + \'&x=\' + x_map + \'&y=\' + y_map;
		request.showLoading = \'map\';
 		request.responseHandler = function()
		{
			window.location=\'/map.php?map=\' + new_map;
		}
		request.send();
	}
	else if(battle !== 0){
		var request = new AjaxRequest();
		request.method = \'post\';
		request.url = \'battle.php\';
		request.responseHandler = function()
		{
			window.location=\'/battle.php?bid=\' + battle;
		}
		request.send();
	}
	else
	{
	for(y = 1; y <= 25; y++){for(x = 1; x <= 30; x++){document.getElementById(x + "_" + y).style.background = "transparent";document.getElementById(x + "_" + y).innerHTML = "";}}

		loadPlayers(Number(xnew),Number(ynew));
	}
}
var loadPlayers = function(x_coordinate, y_coordinate){';


if($omo == '0'){
	if($countusers > '0'){


		echo '
		for (i=0;i<' . $countusers . ';i++){
			if(playerx[i] > 0 && playery[i] > 0 && playerx[i] < 31 && playery[i] < 26){
				document.getElementById(playerx[i] + "_" + playery[i]).style.background="url(html/static/images/sprites/" + trainers[i] + ".gif)";
				document.getElementById(playerx[i] + "_" + playery[i]).style.backgroundRepeat="no-repeat";
				document.getElementById(playerx[i] + "_" + (playery[i] - 1)).innerHTML=\'<img src="html/static/images/sprites/top\' + trainers[i] + \'.gif" border="0" />\';
			}
		}
';
	}
}

echo '
document.getElementById(x_coordinate + "_" + y_coordinate).style.background="url(html/static/images/sprites/o' . $traine . '.gif)";
document.getElementById(x_coordinate + "_" + y_coordinate).style.backgroundRepeat="no-repeat";
document.getElementById(x_coordinate + "_" + (y_coordinate - 1)).innerHTML=\'<img src="html/static/images/sprites/otop' . $traine . '.gif" border="0" />\';';
if($omo == '0'){
	if($countusers > '0'){

		echo 'for (i=0;i<' . $countusers . ';i++){
			if(playerx[i] > 0 && playery[i] > 0 && playerx[i] < 31 && playery[i] < 26){
				var yourup = document.getElementById(playerx[i] + "_" + playery[i]);
				yourup.innerHTML = "<div id=\'cell_" + playerx[i] + "_" + playery[i] + "\' onclick=\'showusers(" + playerx[i] + "," + playery[i] + ")\' class=\'mapsquare\' style=\'cursor:pointer;\'>" + yourup.innerHTML + "</div>";
			}
		}';

	}
}
echo '
var yourup = document.getElementById(x_coordinate + "_" + y_coordinate);
yourup.innerHTML = "<div id=\'cell_" + x_coordinate + "_" + y_coordinate + "\' onclick=\'showusers(" + x_coordinate + "," + y_coordinate + ", 1)\' class=\'mapsquare\' style=\'cursor:pointer;\'>" + yourup.innerHTML + "</div>";

}
var getMap = function(x_user,y_user,user_direction)
{
                var request = new AjaxRequest();
		request.url = \'xml/toolbox.php\';';
if($map == 3){
	echo 'if(y_user > "18" && x_user > "1"){var map_mode = 4;}else{';
}
if($map == 6){
	echo 'if(y_user > "18" && x_user > "0"){var map_mode = 4;}else{';
}
if($map == 9){
	echo 'if(y_user > "18" && x_user > "0"){var map_mode = 4;}else{';
}
if($map == 11){
	echo 'if(x_user > "16" && y_user > "16"){var map_mode = 10;}else{';
}
if($map == 12){
	echo 'if(x_user > "16" && y_user < "8"){var map_mode = 10;}else{';
}
if($map == 14){
	echo 'if(x_user < "10" && y_user > "16"){var map_mode = 10;}else{';
}
if($map == 15){
	echo 'if(x_user < "10" && y_user < "10"){var map_mode = 10;}else{';
}
if($map == 13){
	echo 'if(x_user > "12" && y_user < "10" && x_user < "27"){var map_mode = 10;}else{';
}

switch($map){
	case ($map == 1 || $map == 2 || $map == 3 || $map == 4 || $map == 4 || $map == 5 || $map == 6 || $map == 7 || $map == 8 || $map == 9):
	echo "		var map_mode = 1;";
	break;
	case ($map == 10 || $map == 11 || $map == 12 || $map == 13 || $map == 14 || $map == 15):
	echo "		var map_mode = 8;";
	break;
	case ($map == 16 || $map == 17):
	echo "		var map_mode = 5;";
	break;
	case ($map == 18 || $map == 19 || $map == 20 || $map == 21):
	echo "		var map_mode = 7;";
	break;
	case ($map == 22 || $map == 23):
	echo "		var map_mode = 6;";
	break;
	case ($map == 24 || $map == 25):
	echo "		var map_mode = 3;";
	break;
}  
if($map == 3 || $map == 6 || $map == 9 || $map == 11 || $map == 12 || $map == 14 || $map == 15 || $map == 13){echo "}";}

echo '		user_map = ' . $_REQUEST['map'] . ';
		arrows(Number(x_user),Number(y_user));
		request.query = \'map=\' + map_mode + \'&move=\' + user_direction + \'&main=\' + user_map;
		request.showLoading = \'map\';
		var foundPokemon = document.getElementById(\'pkmnappear\');

		document.getElementById(\'pkmnappear\').innerHTML = \'<p class="large">Searching for Pok&eacute;mon...</p><p>Please wait...</p>\';

			request.responseHandler = function()
		{
  		if (request.responseXML){		
			if(request.responseXML.getElementsByTagName(\'foundPokemon\')[0])
				{		
					foundPokemon.innerHTML = request.responseXML.getElementsByTagName(\'foundPokemon\')[0].firstChild.nodeValue;
					
				}
			else if (request.responseXML.getElementsByTagName(\'sessionExpired\')[0])
				{
					foundPokemon.innerHTML = \'<p class="large">No wild Pok&eacute;mon appeared.</p><p>Your session has expired.</p>\';
					showAlert(\'<p>Your session has expired. Please login again.</p><p><input type="button" name="ok" value="OK" onclick="removeAlert();" id="alertFocus"></p>\');

				}
			else
				{
					showAlert(\'<p>An error occured while requesting the data. Please refresh the page and try again.</p><p><input type="button" name="ok" value="OK" onclick="removeAlert();" id="alertFocus"></p>\');
				}
                        }
                 }
 request.send();
}


var arrows = function(x_arrows,y_arrows){';

$cannotblock = mysql_query("SELECT xblock, yblock FROM map_blocks WHERE mapnumber = '$map'");
while ($cantall = mysql_fetch_array($cannotblock, MYSQL_ASSOC)) 
{
	$cantx[] = $cantall['xblock'];
	$canty[] = $cantall['yblock'];
}
echo "var y_block = new Array(\"";
echo implode("\", \"",$canty);
echo "\");
";

echo "var x_block = new Array(\"";
echo implode("\", \"",$cantx);
echo "\");
";

echo '
loadArrows(x_arrows,y_arrows,y_block,x_block,' . $_SESSION['map_preferences'][2] . ',' . $map . ');
}
addLoadEvent(loadMap);
var showusers = function(x_position,y_position, flag){

var personal = \'<div class="list autowidth"><table style="width: 100%;" border="0" cellpadding="3" cellspacing="0"><tr><th style="width: 35%;text-align:left;">Username</th><th style="width: 65%;">Options</th></tr>\';';


if($omo == '0'){
	if(count($countusers) > 0){


		echo '
		for(i=0;i<' . $countusers . ';i++){
			if(x_position == playerx[i] && y_position == playery[i]){
				if(playerx[i] > 0 && playery[i] > 0 && playerx[i] < 31 && playery[i] < 26){
					personal = personal + \'<tr class="dark" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=\' + userid[i] + \'" onclick="membersTab(\\\'uid=\' + userid[i] + \'\\\', 1); return false;">\' + usern[i] + \'</a></strong></td><td style="width: 25%;"><a href="/battle.php?bid=\' + userid[i] + \'">Battle</a> | <a href="messages.php?rid=\' + userid[i] + \'">Message</a> | <a href="trade.php?type=Username&amp;search=\' + usern[i] + \'&amp;page=1">Trades</a></td></tr>\';
				}

			}
		}';
	}
}
echo '
if(flag){
	personal = personal + \'<tr class="dark" nowrap="nowrap"><td style="text-align: left;"><strong><a href="members.php?uid=' . $_SESSION['myid']. '" onclick="membersTab(\\\'uid=' . $_SESSION['myid'] . '\\\', 1); return false;">' . htmlentities($_SESSION['myuser']) . '</a></strong></td><td style="width: 25%;"><a href="/battle.php?bid=' . $_SESSION['myid'] . '">Battle</a> | <a href="messages.php?rid=' . $_SESSION['myid'] . '">Message</a> | <a href="trade.php?type=Username&amp;search=' . htmlentities($_SESSION['myuser']) . '&amp;page=1">Trades</a></td></tr>\';
}
personal = personal + \'</table></div>\';

document.getElementById(\'suggestResults\').innerHTML = personal;
var userinfo = "suggestResults";
var place = x_position + \'_\' + y_position;
showDetails(userinfo, place, 1);';?>

}
</script>
</head>
<body>
<?php include_once("analytics.php"); ?>
<div id="alert"></div>
<div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<?php
include('/var/www/ads/headerad.php');
?>
</div>
<script>
$(function(){
   setTimeout(function(){
      if($("#headerAd").css('display')=="none")
      {
          $('body').html("<center><h2>Oh no, You have AdBlocker</h2><img src=\"html/static/images/pika_cry.gif\"><p />We noticed you have an active Ad Blocker.<br />Pok&eacute;mon Shqipe is 100% funded by advertisements, we promise our ads are of high quality and are unobtrusive.<br />Please whitelist this site from your ad blocker so we can continue to provide this website for as long as possible and for free.<br />Thank You.");
      }
  },1000);
});
</script>
<div id="title"><h1><a href="index.php"><em>pokemon-shqipe.co.uk</em></a></h1></div>
<ul id="nav">
	<li><a href="map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li>
    <li><a href="battle_select.php" id="battleTab" class="deselected"><em>Battle</em></a></li>
    <li><a href="your_account.php" id="yourAccountTab" class="deselected"><em>Your Account</em></a></li>
    <li><a href="community.php" id="communityTab" class="deselected"><em>Communtiy</em></a></li>
</ul>
<ul id="logout">
	<li><a href="logout.php">Logout</a></li>
</ul>
</div>
<?php include('includes/usernav.php'); ?>
<div id="contentContainer">
<div id="sidebar">
<div id="sidebarContainer">
<div id="sidebarLoading"></div>
<div id="sidebarContent"></div>
</div>
<ul id="sidebarTabs">
    <li><a href="pokedex.php" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
    <li><a href="members.php" id="membersTab" class="deselected"><em>Members</em></a></li>
    <li><a href="options.php" id="optionsTab" class="deselected"><em>Options</em></a></li>
</ul>
</div>
<div id="content">
<div id="notification" style="visibility: hidden;"></div>
<div id="loading"></div>
<div id="scroll">
<div id="suggestResults"></div>
<div id="showDetails"></div>
<div id="errorBox"></div>
<div style="float: right;"><p>
<?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<center><span class="small">Use the options tab to transition between night and day and find different Pok&eacute;mon</span></center>
<div style="position:absolute;float:right;left: 515px;top: 40px;"><div style="width:280px;text-align:center;">
<div id="arrows" align="center">
<!--[if IE 6]>
<div class="noticeMsg"><strong>Notice:</strong> Your browser is unsupported for map use.</div>
<![endif]-->
<noscript>
<div class="noticeMsg"><strong>Notice:</strong> Maps require Javascript, it is recommended that Javascript be turned on for the best playing experience.</div>
</noscript>
</div><br><div class="explainmap"><p><span class="small">Use the compass above to move around the map. You are outlined in yellow while no one else is. If the map does not load <a href="/map.php?map=<?=$map?>">click here.</a></p><p><span class="small">You can also use keyboard navigation to move around. (Arrow keys, numpad and WASD)</span></div>

<div style="width:90%;height:20px;"></div><div id="pkmnappear">
</div>
</div>
</div>
<div id="MapTop"></div>
<div id="MapContainer">
<div id="MapContent">
<div id="mapLoading"></div>
<?php
if($_SESSION['night'] == '1'){
	?>
	<div id="overlay<?=$map?>"></div>
	<?php
}
else{
	?>
	<div id="dayoverlay<?=$map?>"></div>
	<?php
}
?>
<div style="background: transparent url(html/static/images/maps/v3/map<?=$map?>.png) repeat scroll 0% 0%; background-clip: initial; background-origin: initial; background-inline-policy: initial;width: 480px; height: 400px;	border: 2px solid #666666;">
<div class="mapsquare" id="1_1"></div><div class="mapsquare" id="2_1"></div><div class="mapsquare" id="3_1"></div><div class="mapsquare" id="4_1"></div><div class="mapsquare" id="5_1"></div><div class="mapsquare" id="6_1"></div><div class="mapsquare" id="7_1"></div><div class="mapsquare" id="8_1"></div><div class="mapsquare" id="9_1"></div><div class="mapsquare" id="10_1"></div><div class="mapsquare" id="11_1"></div><div class="mapsquare" id="12_1"></div><div class="mapsquare" id="13_1"></div><div class="mapsquare" id="14_1"></div><div class="mapsquare" id="15_1"></div><div class="mapsquare" id="16_1"></div><div class="mapsquare" id="17_1"></div><div class="mapsquare" id="18_1"></div><div class="mapsquare" id="19_1"></div><div class="mapsquare" id="20_1"></div><div class="mapsquare" id="21_1"></div><div class="mapsquare" id="22_1"></div><div class="mapsquare" id="23_1"></div><div class="mapsquare" id="24_1"></div><div class="mapsquare" id="25_1"></div><div class="mapsquare" id="26_1"></div><div class="mapsquare" id="27_1"></div><div class="mapsquare" id="28_1"></div><div class="mapsquare" id="29_1"></div><div class="mapsquare" id="30_1"></div>
<div class="mapsquare" id="1_2"></div><div class="mapsquare" id="2_2"></div><div class="mapsquare" id="3_2"></div><div class="mapsquare" id="4_2"></div><div class="mapsquare" id="5_2"></div><div class="mapsquare" id="6_2"></div><div class="mapsquare" id="7_2"></div><div class="mapsquare" id="8_2"></div><div class="mapsquare" id="9_2"></div><div class="mapsquare" id="10_2"></div><div class="mapsquare" id="11_2"></div><div class="mapsquare" id="12_2"></div><div class="mapsquare" id="13_2"></div><div class="mapsquare" id="14_2"></div><div class="mapsquare" id="15_2"></div><div class="mapsquare" id="16_2"></div><div class="mapsquare" id="17_2"></div><div class="mapsquare" id="18_2"></div><div class="mapsquare" id="19_2"></div><div class="mapsquare" id="20_2"></div><div class="mapsquare" id="21_2"></div><div class="mapsquare" id="22_2"></div><div class="mapsquare" id="23_2"></div><div class="mapsquare" id="24_2"></div><div class="mapsquare" id="25_2"></div><div class="mapsquare" id="26_2"></div><div class="mapsquare" id="27_2"></div><div class="mapsquare" id="28_2"></div><div class="mapsquare" id="29_2"></div><div class="mapsquare" id="30_2"></div>
<div class="mapsquare" id="1_3"></div><div class="mapsquare" id="2_3"></div><div class="mapsquare" id="3_3"></div><div class="mapsquare" id="4_3"></div><div class="mapsquare" id="5_3"></div><div class="mapsquare" id="6_3"></div><div class="mapsquare" id="7_3"></div><div class="mapsquare" id="8_3"></div><div class="mapsquare" id="9_3"></div><div class="mapsquare" id="10_3"></div><div class="mapsquare" id="11_3"></div><div class="mapsquare" id="12_3"></div><div class="mapsquare" id="13_3"></div><div class="mapsquare" id="14_3"></div><div class="mapsquare" id="15_3"></div><div class="mapsquare" id="16_3"></div><div class="mapsquare" id="17_3"></div><div class="mapsquare" id="18_3"></div><div class="mapsquare" id="19_3"></div><div class="mapsquare" id="20_3"></div><div class="mapsquare" id="21_3"></div><div class="mapsquare" id="22_3"></div><div class="mapsquare" id="23_3"></div><div class="mapsquare" id="24_3"></div><div class="mapsquare" id="25_3"></div><div class="mapsquare" id="26_3"></div><div class="mapsquare" id="27_3"></div><div class="mapsquare" id="28_3"></div><div class="mapsquare" id="29_3"></div><div class="mapsquare" id="30_3"></div>
<div class="mapsquare" id="1_4"></div><div class="mapsquare" id="2_4"></div><div class="mapsquare" id="3_4"></div><div class="mapsquare" id="4_4"></div><div class="mapsquare" id="5_4"></div><div class="mapsquare" id="6_4"></div><div class="mapsquare" id="7_4"></div><div class="mapsquare" id="8_4"></div><div class="mapsquare" id="9_4"></div><div class="mapsquare" id="10_4"></div><div class="mapsquare" id="11_4"></div><div class="mapsquare" id="12_4"></div><div class="mapsquare" id="13_4"></div><div class="mapsquare" id="14_4"></div><div class="mapsquare" id="15_4"></div><div class="mapsquare" id="16_4"></div><div class="mapsquare" id="17_4"></div><div class="mapsquare" id="18_4"></div><div class="mapsquare" id="19_4"></div><div class="mapsquare" id="20_4"></div><div class="mapsquare" id="21_4"></div><div class="mapsquare" id="22_4"></div><div class="mapsquare" id="23_4"></div><div class="mapsquare" id="24_4"></div><div class="mapsquare" id="25_4"></div><div class="mapsquare" id="26_4"></div><div class="mapsquare" id="27_4"></div><div class="mapsquare" id="28_4"></div><div class="mapsquare" id="29_4"></div><div class="mapsquare" id="30_4"></div>
<div class="mapsquare" id="1_5"></div><div class="mapsquare" id="2_5"></div><div class="mapsquare" id="3_5"></div><div class="mapsquare" id="4_5"></div><div class="mapsquare" id="5_5"></div><div class="mapsquare" id="6_5"></div><div class="mapsquare" id="7_5"></div><div class="mapsquare" id="8_5"></div><div class="mapsquare" id="9_5"></div><div class="mapsquare" id="10_5"></div><div class="mapsquare" id="11_5"></div><div class="mapsquare" id="12_5"></div><div class="mapsquare" id="13_5"></div><div class="mapsquare" id="14_5"></div><div class="mapsquare" id="15_5"></div><div class="mapsquare" id="16_5"></div><div class="mapsquare" id="17_5"></div><div class="mapsquare" id="18_5"></div><div class="mapsquare" id="19_5"></div><div class="mapsquare" id="20_5"></div><div class="mapsquare" id="21_5"></div><div class="mapsquare" id="22_5"></div><div class="mapsquare" id="23_5"></div><div class="mapsquare" id="24_5"></div><div class="mapsquare" id="25_5"></div><div class="mapsquare" id="26_5"></div><div class="mapsquare" id="27_5"></div><div class="mapsquare" id="28_5"></div><div class="mapsquare" id="29_5"></div><div class="mapsquare" id="30_5"></div>
<div class="mapsquare" id="1_6"></div><div class="mapsquare" id="2_6"></div><div class="mapsquare" id="3_6"></div><div class="mapsquare" id="4_6"></div><div class="mapsquare" id="5_6"></div><div class="mapsquare" id="6_6"></div><div class="mapsquare" id="7_6"></div><div class="mapsquare" id="8_6"></div><div class="mapsquare" id="9_6"></div><div class="mapsquare" id="10_6"></div><div class="mapsquare" id="11_6"></div><div class="mapsquare" id="12_6"></div><div class="mapsquare" id="13_6"></div><div class="mapsquare" id="14_6"></div><div class="mapsquare" id="15_6"></div><div class="mapsquare" id="16_6"></div><div class="mapsquare" id="17_6"></div><div class="mapsquare" id="18_6"></div><div class="mapsquare" id="19_6"></div><div class="mapsquare" id="20_6"></div><div class="mapsquare" id="21_6"></div><div class="mapsquare" id="22_6"></div><div class="mapsquare" id="23_6"></div><div class="mapsquare" id="24_6"></div><div class="mapsquare" id="25_6"></div><div class="mapsquare" id="26_6"></div><div class="mapsquare" id="27_6"></div><div class="mapsquare" id="28_6"></div><div class="mapsquare" id="29_6"></div><div class="mapsquare" id="30_6"></div>
<div class="mapsquare" id="1_7"></div><div class="mapsquare" id="2_7"></div><div class="mapsquare" id="3_7"></div><div class="mapsquare" id="4_7"></div><div class="mapsquare" id="5_7"></div><div class="mapsquare" id="6_7"></div><div class="mapsquare" id="7_7"></div><div class="mapsquare" id="8_7"></div><div class="mapsquare" id="9_7"></div><div class="mapsquare" id="10_7"></div><div class="mapsquare" id="11_7"></div><div class="mapsquare" id="12_7"></div><div class="mapsquare" id="13_7"></div><div class="mapsquare" id="14_7"></div><div class="mapsquare" id="15_7"></div><div class="mapsquare" id="16_7"></div><div class="mapsquare" id="17_7"></div><div class="mapsquare" id="18_7"></div><div class="mapsquare" id="19_7"></div><div class="mapsquare" id="20_7"></div><div class="mapsquare" id="21_7"></div><div class="mapsquare" id="22_7"></div><div class="mapsquare" id="23_7"></div><div class="mapsquare" id="24_7"></div><div class="mapsquare" id="25_7"></div><div class="mapsquare" id="26_7"></div><div class="mapsquare" id="27_7"></div><div class="mapsquare" id="28_7"></div><div class="mapsquare" id="29_7"></div><div class="mapsquare" id="30_7"></div>
<div class="mapsquare" id="1_8"></div><div class="mapsquare" id="2_8"></div><div class="mapsquare" id="3_8"></div><div class="mapsquare" id="4_8"></div><div class="mapsquare" id="5_8"></div><div class="mapsquare" id="6_8"></div><div class="mapsquare" id="7_8"></div><div class="mapsquare" id="8_8"></div><div class="mapsquare" id="9_8"></div><div class="mapsquare" id="10_8"></div><div class="mapsquare" id="11_8"></div><div class="mapsquare" id="12_8"></div><div class="mapsquare" id="13_8"></div><div class="mapsquare" id="14_8"></div><div class="mapsquare" id="15_8"></div><div class="mapsquare" id="16_8"></div><div class="mapsquare" id="17_8"></div><div class="mapsquare" id="18_8"></div><div class="mapsquare" id="19_8"></div><div class="mapsquare" id="20_8"></div><div class="mapsquare" id="21_8"></div><div class="mapsquare" id="22_8"></div><div class="mapsquare" id="23_8"></div><div class="mapsquare" id="24_8"></div><div class="mapsquare" id="25_8"></div><div class="mapsquare" id="26_8"></div><div class="mapsquare" id="27_8"></div><div class="mapsquare" id="28_8"></div><div class="mapsquare" id="29_8"></div><div class="mapsquare" id="30_8"></div>
<div class="mapsquare" id="1_9"></div><div class="mapsquare" id="2_9"></div><div class="mapsquare" id="3_9"></div><div class="mapsquare" id="4_9"></div><div class="mapsquare" id="5_9"></div><div class="mapsquare" id="6_9"></div><div class="mapsquare" id="7_9"></div><div class="mapsquare" id="8_9"></div><div class="mapsquare" id="9_9"></div><div class="mapsquare" id="10_9"></div><div class="mapsquare" id="11_9"></div><div class="mapsquare" id="12_9"></div><div class="mapsquare" id="13_9"></div><div class="mapsquare" id="14_9"></div><div class="mapsquare" id="15_9"></div><div class="mapsquare" id="16_9"></div><div class="mapsquare" id="17_9"></div><div class="mapsquare" id="18_9"></div><div class="mapsquare" id="19_9"></div><div class="mapsquare" id="20_9"></div><div class="mapsquare" id="21_9"></div><div class="mapsquare" id="22_9"></div><div class="mapsquare" id="23_9"></div><div class="mapsquare" id="24_9"></div><div class="mapsquare" id="25_9"></div><div class="mapsquare" id="26_9"></div><div class="mapsquare" id="27_9"></div><div class="mapsquare" id="28_9"></div><div class="mapsquare" id="29_9"></div><div class="mapsquare" id="30_9"></div>
<div class="mapsquare" id="1_10"></div><div class="mapsquare" id="2_10"></div><div class="mapsquare" id="3_10"></div><div class="mapsquare" id="4_10"></div><div class="mapsquare" id="5_10"></div><div class="mapsquare" id="6_10"></div><div class="mapsquare" id="7_10"></div><div class="mapsquare" id="8_10"></div><div class="mapsquare" id="9_10"></div><div class="mapsquare" id="10_10"></div><div class="mapsquare" id="11_10"></div><div class="mapsquare" id="12_10"></div><div class="mapsquare" id="13_10"></div><div class="mapsquare" id="14_10"></div><div class="mapsquare" id="15_10"></div><div class="mapsquare" id="16_10"></div><div class="mapsquare" id="17_10"></div><div class="mapsquare" id="18_10"></div><div class="mapsquare" id="19_10"></div><div class="mapsquare" id="20_10"></div><div class="mapsquare" id="21_10"></div><div class="mapsquare" id="22_10"></div><div class="mapsquare" id="23_10"></div><div class="mapsquare" id="24_10"></div><div class="mapsquare" id="25_10"></div><div class="mapsquare" id="26_10"></div><div class="mapsquare" id="27_10"></div><div class="mapsquare" id="28_10"></div><div class="mapsquare" id="29_10"></div><div class="mapsquare" id="30_10"></div>
<div class="mapsquare" id="1_11"></div><div class="mapsquare" id="2_11"></div><div class="mapsquare" id="3_11"></div><div class="mapsquare" id="4_11"></div><div class="mapsquare" id="5_11"></div><div class="mapsquare" id="6_11"></div><div class="mapsquare" id="7_11"></div><div class="mapsquare" id="8_11"></div><div class="mapsquare" id="9_11"></div><div class="mapsquare" id="10_11"></div><div class="mapsquare" id="11_11"></div><div class="mapsquare" id="12_11"></div><div class="mapsquare" id="13_11"></div><div class="mapsquare" id="14_11"></div><div class="mapsquare" id="15_11"></div><div class="mapsquare" id="16_11"></div><div class="mapsquare" id="17_11"></div><div class="mapsquare" id="18_11"></div><div class="mapsquare" id="19_11"></div><div class="mapsquare" id="20_11"></div><div class="mapsquare" id="21_11"></div><div class="mapsquare" id="22_11"></div><div class="mapsquare" id="23_11"></div><div class="mapsquare" id="24_11"></div><div class="mapsquare" id="25_11"></div><div class="mapsquare" id="26_11"></div><div class="mapsquare" id="27_11"></div><div class="mapsquare" id="28_11"></div><div class="mapsquare" id="29_11"></div><div class="mapsquare" id="30_11"></div>
<div class="mapsquare" id="1_12"></div><div class="mapsquare" id="2_12"></div><div class="mapsquare" id="3_12"></div><div class="mapsquare" id="4_12"></div><div class="mapsquare" id="5_12"></div><div class="mapsquare" id="6_12"></div><div class="mapsquare" id="7_12"></div><div class="mapsquare" id="8_12"></div><div class="mapsquare" id="9_12"></div><div class="mapsquare" id="10_12"></div><div class="mapsquare" id="11_12"></div><div class="mapsquare" id="12_12"></div><div class="mapsquare" id="13_12"></div><div class="mapsquare" id="14_12"></div><div class="mapsquare" id="15_12"></div><div class="mapsquare" id="16_12"></div><div class="mapsquare" id="17_12"></div><div class="mapsquare" id="18_12"></div><div class="mapsquare" id="19_12"></div><div class="mapsquare" id="20_12"></div><div class="mapsquare" id="21_12"></div><div class="mapsquare" id="22_12"></div><div class="mapsquare" id="23_12"></div><div class="mapsquare" id="24_12"></div><div class="mapsquare" id="25_12"></div><div class="mapsquare" id="26_12"></div><div class="mapsquare" id="27_12"></div><div class="mapsquare" id="28_12"></div><div class="mapsquare" id="29_12"></div><div class="mapsquare" id="30_12"></div>
<div class="mapsquare" id="1_13"></div><div class="mapsquare" id="2_13"></div><div class="mapsquare" id="3_13"></div><div class="mapsquare" id="4_13"></div><div class="mapsquare" id="5_13"></div><div class="mapsquare" id="6_13"></div><div class="mapsquare" id="7_13"></div><div class="mapsquare" id="8_13"></div><div class="mapsquare" id="9_13"></div><div class="mapsquare" id="10_13"></div><div class="mapsquare" id="11_13"></div><div class="mapsquare" id="12_13"></div><div class="mapsquare" id="13_13"></div><div class="mapsquare" id="14_13"></div><div class="mapsquare" id="15_13"></div><div class="mapsquare" id="16_13"></div><div class="mapsquare" id="17_13"></div><div class="mapsquare" id="18_13"></div><div class="mapsquare" id="19_13"></div><div class="mapsquare" id="20_13"></div><div class="mapsquare" id="21_13"></div><div class="mapsquare" id="22_13"></div><div class="mapsquare" id="23_13"></div><div class="mapsquare" id="24_13"></div><div class="mapsquare" id="25_13"></div><div class="mapsquare" id="26_13"></div><div class="mapsquare" id="27_13"></div><div class="mapsquare" id="28_13"></div><div class="mapsquare" id="29_13"></div><div class="mapsquare" id="30_13"></div>
<div class="mapsquare" id="1_14"></div><div class="mapsquare" id="2_14"></div><div class="mapsquare" id="3_14"></div><div class="mapsquare" id="4_14"></div><div class="mapsquare" id="5_14"></div><div class="mapsquare" id="6_14"></div><div class="mapsquare" id="7_14"></div><div class="mapsquare" id="8_14"></div><div class="mapsquare" id="9_14"></div><div class="mapsquare" id="10_14"></div><div class="mapsquare" id="11_14"></div><div class="mapsquare" id="12_14"></div><div class="mapsquare" id="13_14"></div><div class="mapsquare" id="14_14"></div><div class="mapsquare" id="15_14"></div><div class="mapsquare" id="16_14"></div><div class="mapsquare" id="17_14"></div><div class="mapsquare" id="18_14"></div><div class="mapsquare" id="19_14"></div><div class="mapsquare" id="20_14"></div><div class="mapsquare" id="21_14"></div><div class="mapsquare" id="22_14"></div><div class="mapsquare" id="23_14"></div><div class="mapsquare" id="24_14"></div><div class="mapsquare" id="25_14"></div><div class="mapsquare" id="26_14"></div><div class="mapsquare" id="27_14"></div><div class="mapsquare" id="28_14"></div><div class="mapsquare" id="29_14"></div><div class="mapsquare" id="30_14"></div>
<div class="mapsquare" id="1_15"></div><div class="mapsquare" id="2_15"></div><div class="mapsquare" id="3_15"></div><div class="mapsquare" id="4_15"></div><div class="mapsquare" id="5_15"></div><div class="mapsquare" id="6_15"></div><div class="mapsquare" id="7_15"></div><div class="mapsquare" id="8_15"></div><div class="mapsquare" id="9_15"></div><div class="mapsquare" id="10_15"></div><div class="mapsquare" id="11_15"></div><div class="mapsquare" id="12_15"></div><div class="mapsquare" id="13_15"></div><div class="mapsquare" id="14_15"></div><div class="mapsquare" id="15_15"></div><div class="mapsquare" id="16_15"></div><div class="mapsquare" id="17_15"></div><div class="mapsquare" id="18_15"></div><div class="mapsquare" id="19_15"></div><div class="mapsquare" id="20_15"></div><div class="mapsquare" id="21_15"></div><div class="mapsquare" id="22_15"></div><div class="mapsquare" id="23_15"></div><div class="mapsquare" id="24_15"></div><div class="mapsquare" id="25_15"></div><div class="mapsquare" id="26_15"></div><div class="mapsquare" id="27_15"></div><div class="mapsquare" id="28_15"></div><div class="mapsquare" id="29_15"></div><div class="mapsquare" id="30_15"></div>
<div class="mapsquare" id="1_16"></div><div class="mapsquare" id="2_16"></div><div class="mapsquare" id="3_16"></div><div class="mapsquare" id="4_16"></div><div class="mapsquare" id="5_16"></div><div class="mapsquare" id="6_16"></div><div class="mapsquare" id="7_16"></div><div class="mapsquare" id="8_16"></div><div class="mapsquare" id="9_16"></div><div class="mapsquare" id="10_16"></div><div class="mapsquare" id="11_16"></div><div class="mapsquare" id="12_16"></div><div class="mapsquare" id="13_16"></div><div class="mapsquare" id="14_16"></div><div class="mapsquare" id="15_16"></div><div class="mapsquare" id="16_16"></div><div class="mapsquare" id="17_16"></div><div class="mapsquare" id="18_16"></div><div class="mapsquare" id="19_16"></div><div class="mapsquare" id="20_16"></div><div class="mapsquare" id="21_16"></div><div class="mapsquare" id="22_16"></div><div class="mapsquare" id="23_16"></div><div class="mapsquare" id="24_16"></div><div class="mapsquare" id="25_16"></div><div class="mapsquare" id="26_16"></div><div class="mapsquare" id="27_16"></div><div class="mapsquare" id="28_16"></div><div class="mapsquare" id="29_16"></div><div class="mapsquare" id="30_16"></div>
<div class="mapsquare" id="1_17"></div><div class="mapsquare" id="2_17"></div><div class="mapsquare" id="3_17"></div><div class="mapsquare" id="4_17"></div><div class="mapsquare" id="5_17"></div><div class="mapsquare" id="6_17"></div><div class="mapsquare" id="7_17"></div><div class="mapsquare" id="8_17"></div><div class="mapsquare" id="9_17"></div><div class="mapsquare" id="10_17"></div><div class="mapsquare" id="11_17"></div><div class="mapsquare" id="12_17"></div><div class="mapsquare" id="13_17"></div><div class="mapsquare" id="14_17"></div><div class="mapsquare" id="15_17"></div><div class="mapsquare" id="16_17"></div><div class="mapsquare" id="17_17"></div><div class="mapsquare" id="18_17"></div><div class="mapsquare" id="19_17"></div><div class="mapsquare" id="20_17"></div><div class="mapsquare" id="21_17"></div><div class="mapsquare" id="22_17"></div><div class="mapsquare" id="23_17"></div><div class="mapsquare" id="24_17"></div><div class="mapsquare" id="25_17"></div><div class="mapsquare" id="26_17"></div><div class="mapsquare" id="27_17"></div><div class="mapsquare" id="28_17"></div><div class="mapsquare" id="29_17"></div><div class="mapsquare" id="30_17"></div>
<div class="mapsquare" id="1_18"></div><div class="mapsquare" id="2_18"></div><div class="mapsquare" id="3_18"></div><div class="mapsquare" id="4_18"></div><div class="mapsquare" id="5_18"></div><div class="mapsquare" id="6_18"></div><div class="mapsquare" id="7_18"></div><div class="mapsquare" id="8_18"></div><div class="mapsquare" id="9_18"></div><div class="mapsquare" id="10_18"></div><div class="mapsquare" id="11_18"></div><div class="mapsquare" id="12_18"></div><div class="mapsquare" id="13_18"></div><div class="mapsquare" id="14_18"></div><div class="mapsquare" id="15_18"></div><div class="mapsquare" id="16_18"></div><div class="mapsquare" id="17_18"></div><div class="mapsquare" id="18_18"></div><div class="mapsquare" id="19_18"></div><div class="mapsquare" id="20_18"></div><div class="mapsquare" id="21_18"></div><div class="mapsquare" id="22_18"></div><div class="mapsquare" id="23_18"></div><div class="mapsquare" id="24_18"></div><div class="mapsquare" id="25_18"></div><div class="mapsquare" id="26_18"></div><div class="mapsquare" id="27_18"></div><div class="mapsquare" id="28_18"></div><div class="mapsquare" id="29_18"></div><div class="mapsquare" id="30_18"></div>
<div class="mapsquare" id="1_19"></div><div class="mapsquare" id="2_19"></div><div class="mapsquare" id="3_19"></div><div class="mapsquare" id="4_19"></div><div class="mapsquare" id="5_19"></div><div class="mapsquare" id="6_19"></div><div class="mapsquare" id="7_19"></div><div class="mapsquare" id="8_19"></div><div class="mapsquare" id="9_19"></div><div class="mapsquare" id="10_19"></div><div class="mapsquare" id="11_19"></div><div class="mapsquare" id="12_19"></div><div class="mapsquare" id="13_19"></div><div class="mapsquare" id="14_19"></div><div class="mapsquare" id="15_19"></div><div class="mapsquare" id="16_19"></div><div class="mapsquare" id="17_19"></div><div class="mapsquare" id="18_19"></div><div class="mapsquare" id="19_19"></div><div class="mapsquare" id="20_19"></div><div class="mapsquare" id="21_19"></div><div class="mapsquare" id="22_19"></div><div class="mapsquare" id="23_19"></div><div class="mapsquare" id="24_19"></div><div class="mapsquare" id="25_19"></div><div class="mapsquare" id="26_19"></div><div class="mapsquare" id="27_19"></div><div class="mapsquare" id="28_19"></div><div class="mapsquare" id="29_19"></div><div class="mapsquare" id="30_19"></div>
<div class="mapsquare" id="1_20"></div><div class="mapsquare" id="2_20"></div><div class="mapsquare" id="3_20"></div><div class="mapsquare" id="4_20"></div><div class="mapsquare" id="5_20"></div><div class="mapsquare" id="6_20"></div><div class="mapsquare" id="7_20"></div><div class="mapsquare" id="8_20"></div><div class="mapsquare" id="9_20"></div><div class="mapsquare" id="10_20"></div><div class="mapsquare" id="11_20"></div><div class="mapsquare" id="12_20"></div><div class="mapsquare" id="13_20"></div><div class="mapsquare" id="14_20"></div><div class="mapsquare" id="15_20"></div><div class="mapsquare" id="16_20"></div><div class="mapsquare" id="17_20"></div><div class="mapsquare" id="18_20"></div><div class="mapsquare" id="19_20"></div><div class="mapsquare" id="20_20"></div><div class="mapsquare" id="21_20"></div><div class="mapsquare" id="22_20"></div><div class="mapsquare" id="23_20"></div><div class="mapsquare" id="24_20"></div><div class="mapsquare" id="25_20"></div><div class="mapsquare" id="26_20"></div><div class="mapsquare" id="27_20"></div><div class="mapsquare" id="28_20"></div><div class="mapsquare" id="29_20"></div><div class="mapsquare" id="30_20"></div>
<div class="mapsquare" id="1_21"></div><div class="mapsquare" id="2_21"></div><div class="mapsquare" id="3_21"></div><div class="mapsquare" id="4_21"></div><div class="mapsquare" id="5_21"></div><div class="mapsquare" id="6_21"></div><div class="mapsquare" id="7_21"></div><div class="mapsquare" id="8_21"></div><div class="mapsquare" id="9_21"></div><div class="mapsquare" id="10_21"></div><div class="mapsquare" id="11_21"></div><div class="mapsquare" id="12_21"></div><div class="mapsquare" id="13_21"></div><div class="mapsquare" id="14_21"></div><div class="mapsquare" id="15_21"></div><div class="mapsquare" id="16_21"></div><div class="mapsquare" id="17_21"></div><div class="mapsquare" id="18_21"></div><div class="mapsquare" id="19_21"></div><div class="mapsquare" id="20_21"></div><div class="mapsquare" id="21_21"></div><div class="mapsquare" id="22_21"></div><div class="mapsquare" id="23_21"></div><div class="mapsquare" id="24_21"></div><div class="mapsquare" id="25_21"></div><div class="mapsquare" id="26_21"></div><div class="mapsquare" id="27_21"></div><div class="mapsquare" id="28_21"></div><div class="mapsquare" id="29_21"></div><div class="mapsquare" id="30_21"></div>
<div class="mapsquare" id="1_22"></div><div class="mapsquare" id="2_22"></div><div class="mapsquare" id="3_22"></div><div class="mapsquare" id="4_22"></div><div class="mapsquare" id="5_22"></div><div class="mapsquare" id="6_22"></div><div class="mapsquare" id="7_22"></div><div class="mapsquare" id="8_22"></div><div class="mapsquare" id="9_22"></div><div class="mapsquare" id="10_22"></div><div class="mapsquare" id="11_22"></div><div class="mapsquare" id="12_22"></div><div class="mapsquare" id="13_22"></div><div class="mapsquare" id="14_22"></div><div class="mapsquare" id="15_22"></div><div class="mapsquare" id="16_22"></div><div class="mapsquare" id="17_22"></div><div class="mapsquare" id="18_22"></div><div class="mapsquare" id="19_22"></div><div class="mapsquare" id="20_22"></div><div class="mapsquare" id="21_22"></div><div class="mapsquare" id="22_22"></div><div class="mapsquare" id="23_22"></div><div class="mapsquare" id="24_22"></div><div class="mapsquare" id="25_22"></div><div class="mapsquare" id="26_22"></div><div class="mapsquare" id="27_22"></div><div class="mapsquare" id="28_22"></div><div class="mapsquare" id="29_22"></div><div class="mapsquare" id="30_22"></div>
<div class="mapsquare" id="1_23"></div><div class="mapsquare" id="2_23"></div><div class="mapsquare" id="3_23"></div><div class="mapsquare" id="4_23"></div><div class="mapsquare" id="5_23"></div><div class="mapsquare" id="6_23"></div><div class="mapsquare" id="7_23"></div><div class="mapsquare" id="8_23"></div><div class="mapsquare" id="9_23"></div><div class="mapsquare" id="10_23"></div><div class="mapsquare" id="11_23"></div><div class="mapsquare" id="12_23"></div><div class="mapsquare" id="13_23"></div><div class="mapsquare" id="14_23"></div><div class="mapsquare" id="15_23"></div><div class="mapsquare" id="16_23"></div><div class="mapsquare" id="17_23"></div><div class="mapsquare" id="18_23"></div><div class="mapsquare" id="19_23"></div><div class="mapsquare" id="20_23"></div><div class="mapsquare" id="21_23"></div><div class="mapsquare" id="22_23"></div><div class="mapsquare" id="23_23"></div><div class="mapsquare" id="24_23"></div><div class="mapsquare" id="25_23"></div><div class="mapsquare" id="26_23"></div><div class="mapsquare" id="27_23"></div><div class="mapsquare" id="28_23"></div><div class="mapsquare" id="29_23"></div><div class="mapsquare" id="30_23"></div>
<div class="mapsquare" id="1_24"></div><div class="mapsquare" id="2_24"></div><div class="mapsquare" id="3_24"></div><div class="mapsquare" id="4_24"></div><div class="mapsquare" id="5_24"></div><div class="mapsquare" id="6_24"></div><div class="mapsquare" id="7_24"></div><div class="mapsquare" id="8_24"></div><div class="mapsquare" id="9_24"></div><div class="mapsquare" id="10_24"></div><div class="mapsquare" id="11_24"></div><div class="mapsquare" id="12_24"></div><div class="mapsquare" id="13_24"></div><div class="mapsquare" id="14_24"></div><div class="mapsquare" id="15_24"></div><div class="mapsquare" id="16_24"></div><div class="mapsquare" id="17_24"></div><div class="mapsquare" id="18_24"></div><div class="mapsquare" id="19_24"></div><div class="mapsquare" id="20_24"></div><div class="mapsquare" id="21_24"></div><div class="mapsquare" id="22_24"></div><div class="mapsquare" id="23_24"></div><div class="mapsquare" id="24_24"></div><div class="mapsquare" id="25_24"></div><div class="mapsquare" id="26_24"></div><div class="mapsquare" id="27_24"></div><div class="mapsquare" id="28_24"></div><div class="mapsquare" id="29_24"></div><div class="mapsquare" id="30_24"></div>
<div class="mapsquare" id="1_25"></div><div class="mapsquare" id="2_25"></div><div class="mapsquare" id="3_25"></div><div class="mapsquare" id="4_25"></div><div class="mapsquare" id="5_25"></div><div class="mapsquare" id="6_25"></div><div class="mapsquare" id="7_25"></div><div class="mapsquare" id="8_25"></div><div class="mapsquare" id="9_25"></div><div class="mapsquare" id="10_25"></div><div class="mapsquare" id="11_25"></div><div class="mapsquare" id="12_25"></div><div class="mapsquare" id="13_25"></div><div class="mapsquare" id="14_25"></div><div class="mapsquare" id="15_25"></div><div class="mapsquare" id="16_25"></div><div class="mapsquare" id="17_25"></div><div class="mapsquare" id="18_25"></div><div class="mapsquare" id="19_25"></div><div class="mapsquare" id="20_25"></div><div class="mapsquare" id="21_25"></div><div class="mapsquare" id="22_25"></div><div class="mapsquare" id="23_25"></div><div class="mapsquare" id="24_25"></div><div class="mapsquare" id="25_25"></div><div class="mapsquare" id="26_25"></div><div class="mapsquare" id="27_25"></div><div class="mapsquare" id="28_25"></div><div class="mapsquare" id="29_25"></div><div class="mapsquare" id="30_25"></div>

</div>

<div id="center">
<?php

$time = time();
$time1 = '1800';
$timeout = $time - $time1;
$online = mysql_query("SELECT COUNT(*) FROM online");
$online1 = mysql_fetch_row($online);
if($online1[0] == 1){
	echo "<a href=\"/members.php?view=online\" onclick=\"membersTab('view=online', 1); return false;\">{$online1[0]} online member</a>";
}
if($online1[0] != 1){
	echo "<a href=\"/members.php?view=online\" onclick=\"membersTab('view=online', 1); return false;\">{$online1[0]} online members</a>";
}

$amonmap1 = $countusers + 1;
if($omo == '0'){
	if($amonmap1 == 1){
		echo " | <a href=\"/options.php?map={$map}&id={$_SESSION['myid']}\" onclick=\"optionsTab('map={$map}&id={$_SESSION['myid']}', 1); return false;\">$amonmap1 member on this map.</a>";
	}
	if($amonmap1 != 1){
		echo " | <a href=\"/options.php?map={$map}&id={$_SESSION['myid']}\" onclick=\"optionsTab('map={$map}&id={$_SESSION['myid']}', 1); return false;\">$amonmap1 members on this map.</a>";
	}
}
?>
</div>
</div>
</div>
<div id="MapBottom"></div>
<p /><center><span class="small">Map Activity</span><p /><div id="backgetPkmn"><div id="getPkmn"></div></div></center>
<br />
<?php
include('disclaimer.php'); ?>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php
}
else {
	header("location:login.php?goawayxP=1");
}
include('pv_disconnect_from_db.php'); ?>