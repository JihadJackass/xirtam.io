<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
$_REQUEST['pid'] = mysql_real_escape_string($_REQUEST['pid']);
$time = time();
function updatep(){
	$sideright = mysql_query("SELECT id, battle FROM members WHERE id = '{$_SESSION['myid']}'");
	$sideright1 = mysql_fetch_array($sideright);
	$aiir = mysql_query("SELECT owner, SUM(exp), AVG(exp) FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY owner");
	$aiir2 = mysql_fetch_array($aiir);
	$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$sideright1['id']}' GROUP BY pid");
	unset($_SESSION['your_pokemon']);
	while($h = mysql_fetch_array($result)){
		$_SESSION['your_pokemon'][] = $h['pid'];
	}
	$unique = mysql_num_rows($result);
	$avgexp = $aiir2['AVG(exp)'];
	$totalexp = $aiir2['SUM(exp)'];
	$battle = $sideright1['battle'];
	$p1 = sqrt($totalexp);
	$p2 = sqrt($avgexp);
	$p3 = sqrt($unique);
	$p4 = log($battle);
	$p5 = $p1 * $p2 * $p3 * $p4;
	$p6 = $p5 / 1000;
	$p7 = round($p6, 1);
	mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique', points = '$p7' WHERE id = '{$_SESSION['myid']}'");
}

	$req = $_REQUEST['pid'];
	$me = $_SESSION['myid'];
	if(isset($_POST['submit'])){
		switch($_SESSION['evtype']){
			case 1:
			$s = mysql_query("SELECT * FROM pguide WHERE name = '{$_SESSION['epname']}'");
			$sh = mysql_fetch_array($s);
			$code = $_SESSION['evitem'];
			$replace = ' ';
			$with111 = '_';
			$newcode = str_replace($replace, $with111, $code);
			mysql_query("UPDATE `items` SET $newcode = $newcode - 1 WHERE uid = '$me' AND $newcode > 0");
			if($sh['name'] == ''){
				header('location:/spevo');
			}
			else{
				if($_POST['attacks'] == "yes"){
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
				else {
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
			}
			$nv = 3;
			break;
			case 2:
			switch($_POST['ev']){
				case 1:
				$v = $_SESSION['ev'];
				break;
				case 2:
				$v = $_SESSION['ev2'];
				break;
				case 3:
				$v = $_SESSION['ev3'];
				break;
				case 4:
				$v = $_SESSION['ev4'];
				break;
				case 5:
				$v = $_SESSION['ev5'];
				break;
				case 6:
				$v = $_SESSION['ev6'];
				break;
				case 7:
				$v = $_SESSION['ev7'];
				break;
				case 8:
				$v = $_SESSION['ev8'];
			}
			$s = mysql_query("SELECT * FROM pguide WHERE name = '{$v[1]}'");
			$sh = mysql_fetch_array($s);
			$code = $v[0];
			$replace = ' ';
			$with111 = '_';
			$newcode = str_replace($replace, $with111, $code);
			mysql_query("UPDATE `items` SET $newcode = $newcode - 1 WHERE uid = '$me' AND $newcode > 0");
			if($sh['name'] == ''){
				header('location:/spevo');
			}
			else{
				if($_POST['attacks'] == "yes"){
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
				else {
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
			}
			$nv = 3;
			break;
			case 3:
			switch($_POST['ev']){
				case 1:
				$v = $_SESSION['ev'];
				break;
				case 2:
				$v = $_SESSION['ev2'];
				break;
				case 3:
				$v = $_SESSION['ev3'];
				break;
			}
			$s = mysql_query("SELECT * FROM pguide WHERE name = '{$v[1]}'");
			$sh = mysql_fetch_array($s);
			if($sh['name'] == ''){
				header('location:/spevo');
			}
			else{
				if($_POST['attacks'] == "yes"){
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
				else {
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
			}
			$nv = 3;
			break;
			case 4:
			switch($_POST['ev']){
				case 1:
				$v = $_SESSION['ev'];
				break;
				case 2:
				$v = $_SESSION['ev2'];
				break;
			}
			$s = mysql_query("SELECT * FROM pguide WHERE name = '{$v[1]}'");
			$sh = mysql_fetch_array($s);
			if($sh['name'] == ''){
				header('location:/spevo');
			}
			else{
				if($_POST['attacks'] == "yes"){
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
				else {
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
			}
			$nv = 3;
			break;
			case 5:
			switch($_POST['ev']){
				case 1:
				$v = $_SESSION['ev'];
				if($v[3] >= $v[0]){
					$s = mysql_query("SELECT * FROM pguide WHERE name = '{$v[1]}'");
					$sh = mysql_fetch_array($s);
					if($sh['name'] == ''){
						header('location:/spevo');
					}
					else{
						if($_POST['attacks'] == "yes"){
							mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
							mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
							mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
							updatep();
						}
						else {
							mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', SET name = '{$sh['name']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
							mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
							mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
							updatep();
						}
					}
					$nv = 3;
				}
				else {
					$nv = 6;
				}
				break;
				case 2:
				$v = $_SESSION['ev2'];
				$it = mysql_query("SELECT * FROM `items` WHERE uid = '$me'");
				$itt = mysql_fetch_array($it);
				switch($v[0]){
					case 'Water Stone':
					$var = $itt['Water_Stone'];
					break;
					case 'Fire Stone':
					$var = $itt['Fire_Stone'];
					break;
					case 'Thunder Stone':
					$var = $itt['Thunder_Stone'];
					break;
					case 'Leaf Stone':
					$var = $itt['Leaf_Stone'];
					break;
					case 'Dusk Stone':
					$var = $itt['Dusk_Stone'];
					break;
					case 'Moon Stone':
					$var = $itt['Moon_Stone'];
					break;
					case 'Shiny Stone':
					$var = $itt['Shiny_Stone'];
					break;
					case 'Dawn Stone':
					$var = $itt['Dawn_Stone'];
					break;
					case 'Sun Stone':
					$var = $itt['Sun_Stone'];
					break;
					case 'Oval Stone':
					$var = $itt['Oval_Stone'];
					break;
					case 'Moss Rock':
					$var = $itt['Moss_Rock'];
					break;
					case 'Ice Rock':
					$var = $itt['Ice_Rock'];
					break;
					case 'Kings Rock':
					$var = $itt['Kings_Rock'];
					break;
					
				}
				if($var >= 1){ 
					$s = mysql_query("SELECT * FROM pguide WHERE name = '{$v[1]}'");
					$sh = mysql_fetch_array($s);
					$code = $v[0];
					$replace = ' ';
					$with111 = '_';
					$newcode = str_replace($replace, $with111, $code);
					mysql_query("UPDATE `items` SET $newcode = $newcode - 1 WHERE uid = '$me' AND $newcode > 0");
					if($sh['name'] == ''){
						header('location:/spevo');
					}
					else{
						if($_POST['attacks'] == "yes"){
							mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$v[1]}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
							mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$v['1']}'");
							mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
							updatep();
						}
						else {
							mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$v[1]}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
							mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$v['1']}'");
							mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
							updatep();
						}
					}
					$nv = 3;
				}
				else {
					$nv = 2;
					$o = 1;
				}
				break;
			}
			break;
			case 6:
			switch($_POST['ev']){
				case 1:
				$v = $_SESSION['ev'];
				break;
				case 2:
				$v = $_SESSION['ev2'];
				break;
			}
			$it = mysql_query("SELECT * FROM `items` WHERE uid = '$me'");
			$itt = mysql_fetch_array($it);
			switch($v[0]){
				case 'Water Stone':
				$var = $itt['Water_Stone'];
				break;
				case 'Fire Stone':
				$var = $itt['Fire_Stone'];
				break;
				case 'Thunder Stone':
				$var = $itt['Thunder_Stone'];
				break;
				case 'Leaf Stone':
				$var = $itt['Leaf_Stone'];
				break;
				case 'Dusk Stone':
				$var = $itt['Dusk_Stone'];
				break;
				case 'Moon Stone':
				$var = $itt['Moon_Stone'];
				break;
				case 'Shiny Stone':
				$var = $itt['Shiny_Stone'];
				break;
				case 'Dawn Stone':
				$var = $itt['Dawn_Stone'];
				break;
				case 'Sun Stone':
				$var = $itt['Sun_Stone'];
				break;
				case 'Oval Stone':
				$var = $itt['Oval_Stone'];
				break;
				case 'Deepseascale':
				$var = $itt['Deepseascale'];
				break;
				case 'Deepseatooth':
				$var = $itt['Deepseatooth'];
				break;
				case 'CharizarditeY':
				$var = $itt['CharizarditeY'];
				break;
				case 'CharizarditeX':
				$var = $itt['CharizarditeX'];
				break;
				case 'MewtwoniteY':
				$var = $itt['MewtwoniteY'];
				break;
				case 'MewtwoniteX':
				$var = $itt['MewtwoniteX'];
				break;
				case 'Kings Rock':
				$var = $itt['Kings_Rock'];
				break;

			}
			if($var >= 1){ 
				$s = mysql_query("SELECT * FROM pguide WHERE name = '{$v[1]}'");
				$sh = mysql_fetch_array($s);
				$code = $v[0];
				$replace = ' ';
				$with111 = '_';
				$newcode = str_replace($replace, $with111, $code);
				mysql_query("UPDATE `items` SET $newcode = $newcode - 1 WHERE uid = '$me' AND $newcode > 0");
				if($sh['name'] == ''){
					header('location:/spevo');
				}
				else{
					if($_POST['attacks'] == "yes"){
						mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$v[1]}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
						mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$v['1']}'");
						mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
						updatep();
					}
					else {
						mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$v[1]}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
						mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$v['1']}'");
						mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
						updatep();
					}
				}
				$nv = 3;
			}
			else {
				$nv = 2;
				$o = 1;
			}
			break;
			case 7:
			$s = mysql_query("SELECT * FROM pguide WHERE name = '{$_SESSION['ev'][1]}'");
			$sh = mysql_fetch_array($s);
			if($sh['name'] == ''){
				header('location:/spevo');
			}
			else{
				if($_POST['attacks'] == "yes"){
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', a1 = '{$sh['a1']}', a2 = '{$sh['a2']}', a3 = '{$sh['a3']}', a4 = '{$sh['a4']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
				else {
					mysql_query("UPDATE pokemon SET pid = '{$sh['id']}', name = '{$sh['name']}', t1 = '{$sh['type1']}', t2 = '{$sh['type2']}' WHERE id = '{$_SESSION['evid']}'");
					mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$sh['name']}'");
					mysql_query("UPDATE pguide SET amount = amount - 1 WHERE name = '{$_SESSION['evname']}'");
					updatep();
				}
			}
			$nv = 3;
			break;
		}
	}
	if(is_numeric($req)){
	mysql_query("UPDATE online SET activity = 'Evolving a {$_SESSION['evname']}' WHERE id = '{$_SESSION['myid']}'");
	$mm = mysql_query("SELECT * FROM pokemon WHERE id = '$req' AND owner = '$me'");
	$mms = mysql_fetch_array($mm);
	$stats = mysql_query("SELECT * FROM pokemon_stats WHERE id = '$req'");
	$statss = mysql_fetch_array($stats);
	$tt = mysql_query("SELECT * FROM pguide WHERE name = '{$mms['name']}'");
	$tts = mysql_fetch_array($tt);
	$_SESSION['evid'] = $req;
	$_SESSION['evname'] = $mms['name'];
	$_SESSION['mye'] = $tts['ev'];
	if(strstr($_SESSION['evname'],'Eevee')){
		$happy = $statss['happiness'];
		$_SESSION['evtype'] = 2;
		$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1");
		$_SESSION['ev2'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
		$_SESSION['ev3'] = array("{$tts['ev3']}","{$tts['ep3']}","3");
		$_SESSION['ev4'] = array("{$tts['ev4']}","{$tts['ep4']}","4");
		$_SESSION['ev5'] = array("{$tts['ev5']}","{$tts['ep5']}","5");
		if($happy >= 220){
			$_SESSION['ev6'] = array("{$tts['ev6']}","{$tts['ep6']}","6");
			$_SESSION['ev7'] = array("{$tts['ev7']}","{$tts['ep7']}","7");
		}
		if($happy >= 255){
			$_SESSION['ev8'] = array("{$tts['ev8']}","{$tts['ep8']}","8");
		}

		$it = mysql_query("SELECT * FROM `items` WHERE uid = '$me'");
		$itt = mysql_fetch_array($it);
		$t = $_SESSION['evitem'][0];
		switch($_SESSION['ev'][0]){
			case 'Water Stone':
			$var = $itt['Water_Stone'];
		}
		switch($_SESSION['ev2'][0]){
			case 'Fire Stone':
			$var2 = $itt['Fire_Stone'];
			break;
		}
		switch($_SESSION['ev3'][0]){
			case 'Thunder Stone':
			$var3 = $itt['Thunder_Stone'];
			break;
		}
		switch($_SESSION['ev4'][0]){
			case 'Moss Rock':
			$var4 = $itt['Moss_Rock'];
			break;
		}
		switch($_SESSION['ev5'][0]){
			case 'Ice Rock':
			$var5 = $itt['Ice_Rock'];
			break;
		}
		switch($_SESSION['ev6'][0]){
			case 'Happiness':
			$var6 = $happy;
			break;
		}
		switch($_SESSION['ev7'][0]){
			case 'Happiness':
			$var7 = $happy;
			break;
		}
		switch($_SESSION['ev8'][0]){
			case 'Happiness':
			$var8 = $happy;
			break;
		}
		$itemused = $_SESSION['ev'][0];
		if($var >= 1){
			$nv = 4;
		}
		else {
			$boo1 = 1;
			$e = "disabled";
		}
		if($var2 >= 1){
			$nv = 4;
		}
		else {
			$boo2 = 1;
			$e2 = "disabled";
		}
		if($var3 >= 1){
			$nv = 4;
		}
		else {
			$boo3 = 1;
			$e3 = "disabled";
		}
		if($var4 >= 1){
			$nv = 4;
		}
		else {
			$boo4 = 1;
			$e4 = "disabled";
		}
		if($var5 >= 1){
			$nv = 4;
		}
		else {
			$boo5 = 1;
			$e5 = "disabled";
		}
		if($var6 >= 220){
			$nv = 4;
		}
		if($var7 >= 220){
			$nv = 4;
		}
		if($boo1 == 1 && $boo2 == 1 && $boo3 == 1 && $boo4 == 1 && $boo5 == 1 && $happy < 220){
			$all = 1;
			$nv = 2;
		}
	}

	elseif(strstr($tts['ev'],'Stone') && $tts['ev3'] == 0 && strstr($tts['ev2'],'Stone') || strstr($tts['ev'],'Deepsea') || strstr($tts['ev2'],'ite') || strstr($tts['ev'],'Rock') && strstr($tts['ev2'],'Stone')){
		$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1");
		$_SESSION['ev2'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
		$it = mysql_query("SELECT * FROM `items` WHERE uid = '$me'");
		$itt = mysql_fetch_array($it);
		$t = $_SESSION['ev'][0];
		switch($_SESSION['ev'][0]){
			case 'Water Stone':
			$var = $itt['Water_Stone'];
			break;
			case 'Fire Stone':
			$var = $itt['Fire_Stone'];
			break;
			case 'Thunder Stone':
			$var = $itt['Thunder_Stone'];
			break;
			case 'Leaf Stone':
			$var = $itt['Leaf_Stone'];
			break;
			case 'Dusk Stone':
			$var = $itt['Dusk_Stone'];
			break;
			case 'Moon Stone':
			$var = $itt['Moon_Stone'];
			break;
			case 'Shiny Stone':
			$var = $itt['Shiny_Stone'];
			break;
			case 'Dawn Stone':
			$var = $itt['Dawn_Stone'];
			break;
			case 'Sun Stone':
			$var = $itt['Sun_Stone'];
			break;
			case 'Oval Stone':
			$var = $itt['Oval_Stone'];
			break;
			case 'Deepseatooth':
			$var = $itt['Deepseatooth'];
			break;
			case 'Deepseascale':
			$var = $itt['Deepseascale'];
			break;
			case 'CharizarditeX':
			$var = $itt['CharizarditeX'];
			break;
			case 'MewtwoniteX':
			$var = $itt['MewtwoniteX'];
			break;
			case 'Kings Rock':
			$var = $itt['Kings_Rock'];
			break;
		}
		switch($_SESSION['ev2'][0]){
			case 'Water Stone':
			$var2 = $itt['Water_Stone'];
			break;
			case 'Fire Stone':
			$var2 = $itt['Fire_Stone'];
			break;
			case 'Thunder Stone':
			$var2 = $itt['Thunder_Stone'];
			break;
			case 'Leaf Stone':
			$var2 = $itt['Leaf_Stone'];
			break;
			case 'Dusk Stone':
			$var2 = $itt['Dusk_Stone'];
			break;
			case 'Moon Stone':
			$var2 = $itt['Moon_Stone'];
			break;
			case 'Shiny Stone':
			$var2 = $itt['Shiny_Stone'];
			break;
			case 'Dawn Stone':
			$var2 = $itt['Dawn_Stone'];
			break;
			case 'Sun Stone':
			$var2 = $itt['Sun_Stone'];
			break;
			case 'Oval Stone':
			$var2 = $itt['Oval_Stone'];
			break;
			case 'Deepseatooth':
			$var2 = $itt['Deepseatooth'];
			break;
			case 'Deepseascale':
			$var2 = $itt['Deepseascale'];
			break;
			case 'CharizarditeY':
			$var2 = $itt['CharizarditeY'];
			break;
			case 'MewtwoniteY':
			$var2 = $itt['MewtwoniteY'];
			break;
			case 'Kings Rock':
			$var2 = $itt['Kings_Rock'];
			break;

		}
		$itemused = $_SESSION['ev'][0];
		if($var >= 1){
			$nv = 7;
		}
		else {
			$bo = 1;
			$w = "disabled";
		}
		if($var2 >= 1){
			$nv = 7;
		}
		else {
			$boa = 1;
			$w2 = "disabled";
		}
		if($bo == 1 && $boa == 1){
			$both = 1;
			$nv = 2;
		}
		$_SESSION['evtype'] = 6;
	}
	elseif(strstr($tts['ev'],'Stone') && $tts['ev2'] == 0 || strstr($tts['ev'],'ite') || strstr($tts['ev'],'Dragon Scale') || strstr($tts['ev'],'Dubious Disc') || strstr($tts['ev'],'Kings Rock') ||  strstr($tts['ev'],'Magmarizer') ||  strstr($tts['ev'],'Metal Coat') ||  strstr($tts['ev'],'Prism Scale') ||  strstr($tts['ev'],'Protector') ||  strstr($tts['ev'],'Razor Claw') ||  strstr($tts['ev'],'Razor Fang') ||  strstr($tts['ev'],'Reaper Cloth') ||  strstr($tts['ev'],'Electirizer') ||  strstr($tts['ev'],'Sachet') ||  strstr($tts['ev'],'Whipped Dream') ||  strstr($tts['ev'],'Up Grade') || strstr($tts['ev'],'Orb')){
		$_SESSION['evitem'] = $tts['ev'];
		$_SESSION['epname'] = $tts['ep'];
		$it = mysql_query("SELECT * FROM `items` WHERE uid = '$me'");
		$itt = mysql_fetch_array($it);
		$t = $_SESSION['evitem'];
		switch($_SESSION['evitem']){
			case 'Water Stone':
			$var = $itt['Water_Stone'];
			break;
			case 'Fire Stone':
			$var = $itt['Fire_Stone'];
			break;
			case 'Thunder Stone':
			$var = $itt['Thunder_Stone'];
			break;
			case 'Leaf Stone':
			$var = $itt['Leaf_Stone'];
			break;
			case 'Dusk Stone':
			$var = $itt['Dusk_Stone'];
			break;
			case 'Moon Stone':
			$var = $itt['Moon_Stone'];
			break;
			case 'Shiny Stone':
			$var = $itt['Shiny_Stone'];
			break;
			case 'Dawn Stone':
			$var = $itt['Dawn_Stone'];
			break;
			case 'Sun Stone':
			$var = $itt['Sun_Stone'];
			break;
			case 'Oval Stone':
			$var = $itt['Oval_Stone'];
			break;
			case 'Dragon Scale':
			$var = $itt['Dragon_Scale'];
			break;
			case 'Dubious Disc':
			$var = $itt['Dubious_Disc'];
			break;
			case 'Kings Rock':
			$var = $itt['Kings_Rock'];
			break;
			case 'Magmarizer':
			$var = $itt['Magmarizer'];
			break;
			case 'Metal Coat':
			$var = $itt['Metal_Coat'];
			break;
			case 'Prism Scale':
			$var = $itt['Prism_Scale'];
			break;
			case 'Protector':
			$var = $itt['Protector'];
			break;
			case 'Razor Claw':
			$var = $itt['Razor_Claw'];
			break;
			case 'Razor Fang':
			$var = $itt['Razor_Fang'];
			break;
			case 'Reaper Cloth':
			$var = $itt['Reaper_Cloth'];
			break;
			case 'Up Grade':
			$var = $itt['Up_Grade'];
			break;
			case 'Latiasite':
			$var = $itt['Latiasite'];
			break;
			case 'Abomasite':
			$var = $itt['Abomasite'];
			break;
			case 'Absolite':
			$var = $itt['Absolite'];
			break;
			case 'Aerodactylite':
			$var = $itt['Aerodactylite'];
			break;
			case 'Aggronite':
			$var = $itt['Aggronite'];
			break;
			case 'Alakazite':
			$var = $itt['Alakazite'];
			break;
			case 'Ampharosite':
			$var = $itt['Ampharosite'];
			break;
			case 'Banettite':
			$var = $itt['Banettite'];
			break;
			case 'Blastoisinite':
			$var = $itt['Blastoisinite'];
			break;
			case 'Blazikenite':
			$var = $itt['Blazikenite'];
			break;
			case 'Garchompite':
			$var = $itt['Garchompite'];
			break;
			case 'Gardevoirite':
			$var = $itt['Gardevoirite'];
			break;
			case 'Gengarite':
			$var = $itt['Gengarite'];
			break;
			case 'Gyaradosite':
			$var = $itt['Gyaradosite'];
			break;
			case 'Heracronite':
			$var = $itt['Heracronite'];
			break;
			case 'Houndoominite':
			$var = $itt['Houndoominite'];
			break;
			case 'Kangaskhanite':
			$var = $itt['Kangaskhanite'];
			break;
			case 'Lucarionite':
			$var = $itt['Lucarionite'];
			break;
			case 'Manectite':
			$var = $itt['Manectite'];
			break;
			case 'Mawilite':
			$var = $itt['Mawilite'];
			break;
			case 'Medichamite':
			$var = $itt['Medichamite'];
			break;
			case 'Pinsirite':
			$var = $itt['Pinsirite'];
			break;
			case 'Scizorite':
			$var = $itt['Scizorite'];
			break;
			case 'Tyranitarite':
			$var = $itt['Tyranitarite'];
			break;
			case 'Venusaurite':
			$var = $itt['Venusaurite'];
			break;
			case 'Latiosite':
			$var = $itt['Latiosite'];
			break;
			case 'Electirizer':
			$var = $itt['Electirizer'];
			break;
			case 'Sachet':
			$var = $itt['Sachet'];
			break;
			case 'Whipped Dream':
			$var = $itt['Whipped_Dream'];
			break;
			case 'Moss Rock':
			$var = $itt['Moss_Rock'];
			break;
			case 'Ice Rock':
			$var = $itt['Ice_Rock'];
			break;
			case 'Altarianite':
			$var = $itt['Altarianite'];
			break;
			case 'Audinite':
			$var = $itt['Audinite'];
			break;
			case 'Beedrillite':
			$var = $itt['Beedrillite'];
			break;
			case 'Cameruptite':
			$var = $itt['Cameruptite'];
			break;
			case 'Diancite':
			$var = $itt['Diancite'];
			break;
			case 'Galladite':
			$var = $itt['Galladite'];
			break;
			case 'Glalitite':
			$var = $itt['Glalitite'];
			break;
			case 'Lopunnite':
			$var = $itt['Lopunnite'];
			break;
			case 'Metagrossite':
			$var = $itt['Metagrossite'];
			break;
			case 'Pidgeotite':
			$var = $itt['Pidgeotite'];
			break;
			case 'Sablenite':
			$var = $itt['Sablenite'];
			break;
			case 'Salamencite':
			$var = $itt['Salamencite'];
			break;
			case 'Sceptilite':
			$var = $itt['Sceptilite'];
			break;
			case 'Sharpedonite':
			$var = $itt['Sharpedonite'];
			break;
			case 'Slowbronite':
			$var = $itt['Slowbronite'];
			break;
			case 'Steelixite':
			$var = $itt['Steelixite'];
			break;
			case 'Swampertite':
			$var = $itt['Swampertite'];
			break;
			case 'Blue Orb':
			$var = $itt['Blue_Orb'];
			break;
			case 'Red Orb':
			$var = $itt['Red_Orb'];
			break;
		}
		$itemused = $_SESSION['evitem'];
		if($var >= 1){ 
			$nv = 1;
			$_SESSION['evtype'] = 1;
		}
		else {
			$nv = 2;
		}
	}

	//--------------------- Pokemon gender specific and tree evolutions------------------------//

	elseif(strstr($_SESSION['evname'],'Tyrogue')){ // Tyrogue split evo
		if($mms['lvl'] < 20){
			$nv = 6;
		}
		else {
			$_SESSION['ev'] = array("20","{$tts['ep']}","1");
			$_SESSION['ev2'] = array("20","{$tts['ep2']}","2");
			$_SESSION['ev3'] = array("20","{$tts['ep3']}","3");
			$_SESSION['evtype'] = 3;
			$nv = 5;
		}
	}
	elseif(strstr($_SESSION['evname'],'Slowpoke')){ // Slowpoke split evo, level 37 and kings rock
		if($mms['lvl'] < 37){
			$nv = 6;
		}
		else{
			$_SESSION['ev'] = array("37","{$tts['ep']}","1","{$mms['lvl']}");
			$_SESSION['ev2'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
			$_SESSION['evtype'] = 5;
			$nv = 7;
		}
	}
	elseif(strstr($_SESSION['evname'],'Poliwhirl')){ // Poliwhirl split evo, water stone and kings rock
		$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1");
		$_SESSION['ev2'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
		$_SESSION['evtype'] = 5;
		$nv = 7;
	}
	elseif(strstr($_SESSION['evname'],'Espurr')){ // Espurr split evo, level 25 and gender based
		if($mms['lvl'] < 25){
			$nv = 6;
		}
		else{
			if($statss['gender'] == 'Male'){
				$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1");
				$_SESSION['evtype'] = 7;
				$nv = 8;
			}
			if($statss['gender'] == 'Female'){
				$_SESSION['ev'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
				$_SESSION['evtype'] = 7;
				$nv = 8;
			}
		}
	}
	elseif(strstr($_SESSION['evname'],'Snorunt')){ // Snorunt split evo, level 42 and gender based with dawn stone
		if($statss['gender'] == 'Male'){
			$_SESSION['ev'] = array("42","{$tts['ep']}","1","{$mms['lvl']}");
			$_SESSION['evtype'] = 7;
			$nv = 8;
		}
		elseif($statss['gender'] == 'Female'){
			$_SESSION['ev'] = array("42","{$tts['ep']}","1","{$mms['lvl']}");
			$_SESSION['ev2'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
			$_SESSION['evtype'] = 5;
			$nv = 7;
		}
	}
	elseif(strstr($_SESSION['evname'],'Kirlia')){ // Kirlia split evo, level 30 and gender based with dawn stone
		if($statss['gender'] == 'Female'){
			$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1","{$mms['lvl']}");
			$_SESSION['evtype'] = 7;
			$nv = 8;
		}
		elseif($statss['gender'] == 'Male'){
			$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1","{$mms['lvl']}");
			$_SESSION['ev2'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
			$_SESSION['evtype'] = 5;
			$nv = 7;
		}
	}
	elseif(strstr($_SESSION['evname'],'Burmy')){ // Burmy split evo, level 20 and gender based
		if($mms['lvl'] < 20){
			$nv = 6;
		}
		else{
			if($statss['gender'] == 'Male'){
				$_SESSION['ev'] = array("20","{$tts['ep2']}","1");
				$_SESSION['evtype'] = 7;
				$nv = 8;
			}
			elseif($statss['gender'] == 'Female'){
				$_SESSION['ev'] = array("20","{$tts['ep']}","1");
				$_SESSION['evtype'] = 7;
				$nv = 8;
			}
		}
	}
	elseif($tts['ev'] > 0 && $tts['ev2'] > 0){
		if($mms['lvl'] < $tts['ev']){
			$nv = 6;
		}
		else {
			$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1");
			$_SESSION['ev2'] = array("{$tts['ev']}","{$tts['ep2']}","2");
			$_SESSION['evtype'] = 3;
			$nv = 7;
			$_SESSION['evtype'] = 4;
		}
	}
	elseif($tts['ev'] > 0 && strstr($tts['ev2'],'Stone')){
		$_SESSION['ev'] = array("{$tts['ev']}","{$tts['ep']}","1","{$mms['lvl']}");
		$_SESSION['ev2'] = array("{$tts['ev2']}","{$tts['ep2']}","2");
		$nv = 7;
		$_SESSION['evtype'] = 5;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
<?php
if($_SESSION['layout'] == '1'){
echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '2'){
echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie6-.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//ie7+.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie7+.css" media="screen" />
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon Shqipe v3 - Evolve a Pok&eacute;mon</title>
</head>
<script language="javascript">
function disableclick(event)
{
  if(event.button==2)
   {
     alert(status);
     return false;    
   }
}
</script>
<body oncontextmenu="return false">
<?php include_once("analytics.php"); ?>
<div id="alert"></div><div id="menuBox"></div>
<div id="container">
<div id="header">
<div id="headerAd">
<?php
include('/var/www/ads/headerad.php');
?>
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
</div>
<div id="title">
<h1><a href="index.php"><em>pokemon-shqipe.co.uk</em></a></h1>
</div>
<ul id="nav">
<li><a href="map_select.php" id="mapsTab" class="deselected"><em>Maps</em></a></li>
<li><a href="battle_select.php" id="battleTab" class="deselected"><em>Battle</em></a></li>
<li><a href="your_account.php" id="yourAccountTab" class="deselected"><em>Your Account</em></a></li>
<li><a href="community.php" id="communityTab" class="deselected"><em>Communtiy</em></a></li>
</ul>
<ul id="logout">
<li><a href="/logout.php">Logout</a></li>
</ul>
</div>
<?php include('includes/usernav.php'); ?>
<div id="contentContainer">
<div id="sidebar">
<div id="sidebarContainer"><div id="sidebarLoading"></div><div id="sidebarContent"></div></div>
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
<div style="float: right;">
<?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<div id="ajax">
<?php
switch($nv){
	case 1:
	echo "<h3>By using a " . $tts['ev'] . " your " . $tts['name'] . " will evolve into " . $tts['ep'] . ".</h3>";
	echo "<p><img src=\"html/static/images/pokemon/" . $tts['name'] . ".gif\" align=\"center\" /> <font size=\"2\">&rarr;</font> <img src=\"html/static/images/pokemon/" . $tts['ep'] . ".gif\" align=\"center\" /></p>";
	echo "<p><form action=\"spevo.php\" method=\"post\"><input type=\"checkbox\" name=\"attacks\" checked=\"true\" value=\"yes\"/> Replace " . $tts['name'] . "'s attacks with " . $tts['ep'] . "'s attacks.<br /><input type=\"submit\" name=\"submit\" value=\"Evolve!\" /></p>";
	break;
	case 2:
	if($o == 0){
		$var = $_SESSION['mye'];
	}
	else {
		$var = $_SESSION['ev2'][0];
	}
	if($both == 1){
		$var = $_SESSION['ev'][0] . " or " . $_SESSION['ev2'][0];
	}
	if($all == 1){
		$var = $_SESSION['ev'][0] . " / " . $_SESSION['ev2'][0] . " / " . $_SESSION['ev3'][0] . " / " . $_SESSION['ev4'][0] . " / " . $_SESSION['ev5'][0] . " or have enough happiness";
	}
	echo "<h3>In order to evolve " . $_SESSION['evname'] . " you must have a " . $var . ".</h3><p><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" align=\"center\" /></p><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Trade Pok&eacute;mon</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a><br /><a href=\"/items.php\" class=\"deselected\">Pok&eacute;mart</a></p>";
	break;
	case 3:
	echo "<h3>Your " . $_SESSION['evname'] . " has evolved into " . $sh['name'] . ".</h3>";
	echo "<p><img src=\"html/static/images/pokemon/" . $sh['name'] . ".gif\" align=\"center\" /></p>";
	echo "<p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Trade Pok&eacute;mon</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
	break;
	case 4:
	echo "<h3>Your " . $_SESSION['evname'] . " can evolve into several different Pokemon. Choose the evolution.</h3>";
	echo "<p><form action=\"spevo.php\" method=\"post\"><input type=\"radio\" " . $e . " name=\"ev\" value=\"" . $_SESSION['ev'][2] . "\" /><img src=\"html/static/images/pokemon/" . $_SESSION['ev'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"radio\" " . $e2 . " name=\"ev\" value=\"" . $_SESSION['ev2'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev2'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"radio\" " . $e3 . " name=\"ev\" value=\"" . $_SESSION['ev3'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev3'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"radio\" " . $e4 . " name=\"ev\" value=\"" . $_SESSION['ev4'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev4'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"radio\" " . $e5 . " name=\"ev\" value=\"" . $_SESSION['ev5'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev5'][1] . ".gif\" align=\"center\" /></p>";
	if($happy >= 220){
		echo "<p><input type=\"radio\" name=\"ev\" value=\"" . $_SESSION['ev6'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev6'][1] . ".gif\" align=\"center\" /></p>";
		echo "<p><input type=\"radio\" name=\"ev\" value=\"" . $_SESSION['ev7'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev7'][1] . ".gif\" align=\"center\" /></p>";
	}
	if($happy >= 255){
		echo "<p><input type=\"radio\" name=\"ev\" value=\"" . $_SESSION['ev8'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev8'][1] . ".gif\" align=\"center\" /></p>";
	}
	echo "<p><input type=\"checkbox\" name=\"attacks\" checked=\"true\" value=\"yes\"/> Replace " . $tts['name'] . "'s attacks with evolution's attacks.<br /><input type=\"submit\" name=\"submit\" value=\"Evolve!\" /></p>";
	break;
	case 5:
	echo "<h3>Your " . $_SESSION['evname'] . " can evolve into three different Pokemon. Choose the evolution.</h3>";
	echo "<p><form action=\"spevo.php\" method=\"post\"><input type=\"radio\" name=\"ev\" value=\"" . $_SESSION['ev'][2] . "\" /><img src=\"html/static/images/pokemon/" . $_SESSION['ev'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"radio\" name=\"ev\" value=\"" . $_SESSION['ev2'][2] . "\" /><img src=\"html/static/images/pokemon/" . $_SESSION['ev2'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"radio\" name=\"ev\" value=\"" . $_SESSION['ev3'][2] . "\" /><img src=\"html/static/images/pokemon/" . $_SESSION['ev3'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"checkbox\" name=\"attacks\" checked=\"true\" value=\"yes\"/> Replace " . $tts['name'] . "'s attacks with evolution's attacks.<br /><input type=\"submit\" name=\"submit\" value=\"Evolve!\" /></p>";
	break;
	case 6:
	echo "<h3>In order to evolve " . $_SESSION['evname'] . ", it must be at least level " . $_SESSION['mye'] . ".</h3><p><img src=\"html/static/images/pokemon/" . $_SESSION['evname'] . ".gif\" align=\"center\" /></p><p class=\"optionsList autowidth\"><strong>Options:</strong><br /><a href=\"/your_team.php\" class=\"deselected\">View/Modify Team</a><br /><a href=\"/trade.php\" class=\"deselected\">Trade Pok&eacute;mon</a><br /><a href=\"/your_pokemon.php\" class=\"deselected\">View All Pokemon</a></p>";
	break;
	case 7:
	echo "<h3>Your " . $_SESSION['evname'] . " can evolve into two different Pokemon. Choose the evolution.</h3>";
	echo "<p><form action=\"spevo.php\" method=\"post\"><input type=\"radio\" " . $w . " name=\"ev\" value=\"" . $_SESSION['ev'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"radio\" " . $w2 . " name=\"ev\" value=\"" . $_SESSION['ev2'][2] . "\"  /><img src=\"html/static/images/pokemon/" . $_SESSION['ev2'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><input type=\"checkbox\" name=\"attacks\" checked=\"true\" value=\"yes\"/> Replace " . $tts['name'] . "'s attacks with evolution's attacks.<br /><input type=\"submit\" name=\"submit\" value=\"Evolve!\" /></p>";
	break;
	case 8:
	echo "<h3>Your " . $tts['name'] . " will evolve into " . $_SESSION['ev'][1] . ".</h3>";
	echo "<p><img src=\"html/static/images/pokemon/" . $tts['name'] . ".gif\" align=\"center\" /> <font size=\"2\">&rarr;</font> <img src=\"html/static/images/pokemon/" . $_SESSION['ev'][1] . ".gif\" align=\"center\" /></p>";
	echo "<p><form action=\"spevo.php\" method=\"post\"><input type=\"checkbox\" name=\"attacks\" checked=\"true\" value=\"yes\"/> Replace " . $tts['name'] . "'s attacks with " . $_SESSION['ev'][1] . "'s attacks.<br /><input type=\"submit\" name=\"submit\" value=\"Evolve!\" /></p>";
	break;

}
?>
</div>
<div id="copy">&copy; 2008-2014 <a href="http://www.pokemon-shqipe.co.uk/">The Pok&eacute;mon Shqipe</a>. This site is not affiliated with Nintendo, The Pok&eacute;mon Company, Creatures, or GameFreak<br /><a href="/contactus.php">Contact Us</a> | <a href="/about.php">About Us / FAQ</a> | <a href="/privacy.php">Privacy Policy &amp; Terms of Service</a> | <a href="/legal.php">Legal Info</a> | <a href="/credits.php">Credits</a>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" language="javascript" src="html/static/js//v3/gameInit.js"></script>
</html>
<?php
include('pv_disconnect_from_db.php'); ?>