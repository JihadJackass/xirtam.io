<?php
include('/var/www/html/v3/pv_connect_to_db.php');
if($_REQUEST['show']){ // KANTO
	echo "<br/><table border='1'>";
	$ae = 0;
	$at = 105;
	if($_REQUEST['show'] == 2){ // JOHTO
		$ae = 106;
		$at = 213;
	}
	if($_REQUEST['show'] == 3){ // SEVII ISLANDS
		$ae = 214;
		$at = 377;
	}
	if($_REQUEST['show'] == 4){ // ORANGE ISLANDS
		$ae = 378;
		$at = 604;
	}
	if($_REQUEST['show'] == 5){ // TCG ISLANDS
		$ae = 605;
		$at = 711;
	}
	if($_REQUEST['show'] == 6){ // NEW ISLAND
		$ae = 712;
		$at = 713;
	}
	if($_REQUEST['show'] == 7){ // VORTEX ISLAND
		$ae = 714;
		$at = 820;
	}
	if($_REQUEST['show'] == 8){ // FARAWAY ISLAND
		$ae = 821;
		$at = 822;
	}
	if($_REQUEST['show'] == 9){ // HOENN
		$ae = 823;
		$at = 931;
	}
	if($_REQUEST['show'] == 10){ // SOUTHERN ISLAND
		$ae = 932;
		$at = 934;
	}
	
	$ra = mysql_query("SELECT * FROM sidequests ORDER BY id LIMIT $ae, $at");
	while($ad = mysql_fetch_array($ra)){
		$a = $ad['s1'];$b = $ad['s2'];$c = $ad['s3'];$d = $ad['s4'];$e = $ad['s5'];$f = $ad['s6'];
		if($a && !$b){
			$t = mysql_query("SELECT * FROM sidepokemon WHERE id IN($a) ORDER BY FIELD(id,$a)");
		}
		if($b && !$c){
			$t = mysql_query("SELECT * FROM sidepokemon WHERE id IN($a,$b) ORDER BY FIELD(id,$a,$b)");
		}
		if($c && !$d){
			$t = mysql_query("SELECT * FROM sidepokemon WHERE id IN($a,$b,$c) ORDER BY FIELD(id,$a,$b,$c)");
		}
		if($d && !$e){
			$t = mysql_query("SELECT * FROM sidepokemon WHERE id IN($a,$b,$c,$d) ORDER BY FIELD(id,$a,$b,$c,$d)");
		}
		if($e && !$f){
			$t = mysql_query("SELECT * FROM sidepokemon WHERE id IN($a,$b,$c,$d,$e) ORDER BY FIELD(id,$a,$b,$c,$d,$e)");
		}
		if($f){
			$t = mysql_query("SELECT * FROM sidepokemon WHERE id IN($a,$b,$c,$d,$e,$f) ORDER BY FIELD(id,$a,$b,$c,$d,$e,$f)");
		}
		echo "<tr><td>{$ad['id']}</td><td>{$ad['name']}</td><td>{$ad['place']}</td>";
		while($am = mysql_fetch_array($t)){
			echo "<td>{$am['name']}, {$am['lvl']}</td>";
		}
		echo "</tr>";
	}
}
else{
	
	if(isset($_POST['add']) && isset($_POST['pokemon1']) && isset($_POST['lvl1'])){
		mysql_query("INSERT INTO sidequests (name, place) VALUES ('{$_POST['trainer']}', '{$_POST['location']}')");
		$r = mysql_insert_id();
		$e = mysql_query("SELECT a1, a2, a3, a4, type1, type2 FROM pguide WHERE name = '{$_POST['pokemon1']}'"); 
		$t = mysql_fetch_array($e);
		$exp = $_POST['lvl1'] * 500;
		mysql_query("INSERT INTO sidepokemon (name, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES('{$_POST['pokemon1']}', '$r', '{$t['a1']}', '{$t['a2']}', '{$t['a3']}', '{$t['a4']}', '{$_POST['lvl1']}', '{$t['type1']}', '{$t['type2']}', '{$exp}', '{$_POST['trainer']}')");
		$poke1 = mysql_insert_id();
		mysql_query("UPDATE sidequests SET s1 = '$poke1' WHERE id = '$r'");
		if(isset($_POST['pokemon2']) && is_numeric($_POST['lvl2'])){
			$e = mysql_query("SELECT a1, a2, a3, a4, type1, type2 FROM pguide WHERE name = '{$_POST['pokemon2']}'"); 
			$t = mysql_fetch_array($e);
			$exp = $_POST['lvl2'] * 500;
			mysql_query("INSERT INTO sidepokemon (name, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES('{$_POST['pokemon2']}', '$r', '{$t['a1']}', '{$t['a2']}', '{$t['a3']}', '{$t['a4']}', '{$_POST['lvl2']}', '{$t['type1']}', '{$t['type2']}', '{$exp}', '{$_POST['trainer']}')");
			$poke2 = mysql_insert_id();
			mysql_query("UPDATE sidequests SET s2 = '$poke2' WHERE id = '$r'");
		}
		
		if(isset($_POST['pokemon3']) && is_numeric($_POST['lvl3'])){
			$e = mysql_query("SELECT a1, a2, a3, a4, type1, type2 FROM pguide WHERE name = '{$_POST['pokemon3']}'"); 
			$t = mysql_fetch_array($e);
			$exp = $_POST['lvl3'] * 500;
			mysql_query("INSERT INTO sidepokemon (name, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES('{$_POST['pokemon3']}', '$r', '{$t['a1']}', '{$t['a2']}', '{$t['a3']}', '{$t['a4']}', '{$_POST['lvl3']}', '{$t['type1']}', '{$t['type2']}', '{$exp}', '{$_POST['trainer']}')");
			$poke3 = mysql_insert_id();
			mysql_query("UPDATE sidequests SET s3 = '$poke3' WHERE id = '$r'");
		}
		if(isset($_POST['pokemon4']) && is_numeric($_POST['lvl4'])){
			$e = mysql_query("SELECT a1, a2, a3, a4, type1, type2 FROM pguide WHERE name = '{$_POST['pokemon4']}'"); 
			$t = mysql_fetch_array($e);
			$exp = $_POST['lvl4'] * 500;
			mysql_query("INSERT INTO sidepokemon (name, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES('{$_POST['pokemon4']}', '$r', '{$t['a1']}', '{$t['a2']}', '{$t['a3']}', '{$t['a4']}', '{$_POST['lvl4']}', '{$t['type1']}', '{$t['type2']}', '{$exp}', '{$_POST['trainer']}')");
			$poke4 = mysql_insert_id();
			mysql_query("UPDATE sidequests SET s4 = '$poke4' WHERE id = '$r'");
		}
		if(isset($_POST['pokemon5']) && is_numeric($_POST['lvl5'])){
			$e = mysql_query("SELECT a1, a2, a3, a4, type1, type2 FROM pguide WHERE name = '{$_POST['pokemon5']}'"); 
			$t = mysql_fetch_array($e);
			$exp = $_POST['lvl5'] * 500;
			mysql_query("INSERT INTO sidepokemon (name, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES('{$_POST['pokemon5']}', '$r', '{$t['a1']}', '{$t['a2']}', '{$t['a3']}', '{$t['a4']}', '{$_POST['lvl5']}', '{$t['type1']}', '{$t['type2']}', '{$exp}', '{$_POST['trainer']}')");
			$poke5 = mysql_insert_id();
			mysql_query("UPDATE sidequests SET s5 = '$poke5' WHERE id = '$r'");
		}
		if(isset($_POST['pokemon6']) && is_numeric($_POST['lvl6'])){
			$e = mysql_query("SELECT a1, a2, a3, a4, type1, type2 FROM pguide WHERE name = '{$_POST['pokemon6']}'"); 
			$t = mysql_fetch_array($e);
			$exp = $_POST['lvl6'] * 500;
			mysql_query("INSERT INTO sidepokemon (name, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES('{$_POST['pokemon6']}', '$r', '{$t['a1']}', '{$t['a2']}', '{$t['a3']}', '{$t['a4']}', '{$_POST['lvl6']}', '{$t['type1']}', '{$t['type2']}', '{$exp}', '{$_POST['trainer']}')");
			$poke6 = mysql_insert_id();
			mysql_query("UPDATE sidequests SET s6 = '$poke6' WHERE id = '$r'");
		}
	}
	?>
    <form method="post">
    Trainer Name: <input type="text" name="trainer">  Location: <input type="text" name="location"><br/>
    Pokemon 1: <input type="text" name="pokemon1"> Lvl: <input type="text" name="lvl1"><br/>
    Pokemon 2: <input type="text" name="pokemon2"> Lvl: <input type="text" name="lvl2"><br/>
    Pokemon 3: <input type="text" name="pokemon3"> Lvl: <input type="text" name="lvl3"><br/>
    Pokemon 4: <input type="text" name="pokemon4"> Lvl: <input type="text" name="lvl4"><br/>
    Pokemon 5: <input type="text" name="pokemon5"> Lvl: <input type="text" name="lvl5"><br/>
    Pokemon 6: <input type="text" name="pokemon6"> Lvl: <input type="text" name="lvl6"><br/>
    <input type="submit" name="add" value="Add">
    </form>
    <?php
}
?>
<a href='sidekwests.php?show=1'>Kanto</a> | <a href='sidekwests.php?show=2'>Johto</a> | <a href='sidekwests.php?show=3'>Sevii Islands</a> | <a href='sidekwests.php?show=4'>Orange Islands</a> | <a href='sidekwests.php?show=5'>TCG Islands</a> | <a href='sidekwests.php?show=6'>New Island</a> | <a href='sidekwests.php?show=7'>Vortex Island</a> | <a href='sidekwests.php?show=8'>Faraway Island</a> | <a href='sidekwests.php?show=9'>Hoenn</a> | <a href='sidekwests.php?show=10'>Southern Island</a> |