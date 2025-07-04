<?php
if($_POST['claim_code_1_pikachu']){
	$done_event = mysql_query("SELECT * FROM done_event WHERE id = '{$_SESSION['myid']}'");
	$done = mysql_num_rows($done_event);
	if($done == '0'){
		// Check unowns
		$unown = mysql_query("SELECT name FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND ot = '{$_SESSION['myuser']}' AND name LIKE 'Unown%' GROUP BY pid");
		$unown2 = mysql_num_rows($unown);
		if($unown2 == '28'){
			// generate a code and insert the user to done_event
			$ins = mysql_query("INSERT INTO done_event (id, username, ip) VALUES ('{$_SESSION['myid']}', '{$_SESSION['myuser']}', '{$_SERVER['REMOTE_ADDR']}')");
			if($ins){
				$code_generate = rand(0,9999999999999999999);
				$code = md5($code_generate);
				$codee = strtoupper($code);
				$pkmn = rand(1,5);
				if($pkmn == '1'){
					$pokemon = 'Pikachu (Belle)';
				}
				if($pkmn == '2'){
					$pokemon = 'Pikachu (Libre)';
				}
				if($pkmn == '3'){
					$pokemon = 'Pikachu (Ph. D.)';
				}
				if($pkmn == '4'){
					$pokemon = 'Pikachu (Pop Star)';
				}
				if($pkmn == '5'){
					$pokemon = 'Pikachu (Rock Star)';
				}
				$type = rand(1,6);
				if($type == '1'){
					$name = '';
				}
				if($type == '2'){
					$name = 'Shiny ';
				}
				if($type == '3'){
					$name = 'Dark ';
				}
				if($type == '4'){
					$name = 'Mystic ';
				}
				if($type == '5'){
					$name = 'Metallic ';
				}
				if($type == '6'){
					$name = 'Shadow ';
				}
				mysql_query("INSERT INTO promo_codes (code, prize, type, owner) VALUES ('{$codee}', '{$name}{$pokemon}', 'pokemon', '{$_SESSION['myid']}')");
				$promo = 1;
			}
		}
		else{
			$unowns = 0;
		}
	}
	elseif($done == '1'){
		// do nothing
		$promo = 0;
	}
}
?>