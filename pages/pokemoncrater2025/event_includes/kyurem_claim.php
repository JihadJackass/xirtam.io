<?php

// Purchasing the DNA Splicers request handler
 
if($_POST['buy_dna_splicers']){
	$got_splicers = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}'");
	$splicers = mysql_fetch_array($got_splicers);
	if($splicers['DNA_Splicers'] == '0'){

		// Check to make sure they don't yet have DNA Splicers

		$get_money = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
		$money = mysql_fetch_array($get_money);
		if($money['money'] >= 500000){

			// Check to make sure they can afford the DNA Splicers

			mysql_query("UPDATE members SET money = money - 500000 WHERE id = '{$_SESSION['myid']}'");
			mysql_query("UPDATE items SET DNA_Splicers = '1' WHERE uid = '{$_SESSION['myid']}'");
			$splicers = 1;
		}
		else{
			$splicers = 0;
		}
	}
	else{
		$splicererror = 1;
	}
}

// Fusion request handler

if($_POST['fuse_kyurem']){

	$_POST['kyurem'] = mysql_real_escape_string($_POST['kyurem']);
	$_POST['reshiram_zekrom'] = mysql_real_escape_string($_POST['reshiram_zekrom']);
	$myid = $_SESSION['myid'];

	// Make sure the requester is fusing their own Pokemon

	$check_kyurem = mysql_query("SELECT * FROM pokemon WHERE id = '{$_POST['kyurem']}' AND owner = '{$_SESSION['myid']}'");
	$kyurem = mysql_fetch_array($check_kyurem);
	$kyuremowner = $kyurem['owner'];
	$check_reshiram_zekrom = mysql_query("SELECT * FROM pokemon WHERE id = '{$_POST['reshiram_zekrom']}' AND owner = '{$_SESSION['myid']}'");
	$reshiram_zekrom = mysql_fetch_array($check_reshiram_zekrom);
	$reshzekowner = $reshiram_zekrom['owner'];
	$total = $kyurem['exp'] + $reshiram_zekrom['exp'];

	if($kyuremowner && $reshzekowner){

		// Check if the Pokemon types match

		if($kyurem['name'] === 'Kyurem' && $reshiram_zekrom['name'] === 'Reshiram'){
			
			// Fuse to Kyurem (White)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Kyurem (White)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Turboblaze', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Kyurem (White)'");
			$fused = 1;
			$fusion = 'Kyurem (White)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}

		}
		elseif($kyurem['name'] === 'Kyurem' && $reshiram_zekrom['name'] === 'Zekrom'){

			// Fuse to Kyurem (Black)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Kyurem (Black)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Teravolt', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Kyurem (Black)'");
			$fused = 1;
			$fusion = 'Kyurem (Black)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Shiny Kyurem' && $reshiram_zekrom['name'] === 'Shiny Reshiram'){

			// Fuse to Shiny Kyurem (White)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Shiny Kyurem (White)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Turboblaze', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Shiny Kyurem (White)'");
			$fused = 1;
			$fusion = 'Shiny Kyurem (White)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Shiny Kyurem' && $reshiram_zekrom['name'] === 'Shiny Zekrom'){

			// Fuse to Shiny Kyurem (Black)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Shiny Kyurem (Black)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Teravolt', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Shiny Kyurem (Black)'");
			$fused = 1;
			$fusion = 'Shiny Kyurem (Black)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Dark Kyurem' && $reshiram_zekrom['name'] === 'Dark Reshiram'){

			// Fuse to Dark Kyurem (White)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Dark Kyurem (White)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Turboblaze', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Dark Kyurem (White)'");
			$fused = 1;
			$fusion = 'Dark Kyurem (White)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Dark Kyurem' && $reshiram_zekrom['name'] === 'Dark Zekrom'){

			// Fuse to Dark Kyurem (Black)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Dark Kyurem (Black)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Teravolt', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Dark Kyurem (Black)'");
			$fused = 1;
			$fusion = 'Dark Kyurem (Black)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Mystic Kyurem' && $reshiram_zekrom['name'] === 'Mystic Reshiram'){

			// Fuse to Mystic Kyurem (White)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Mystic Kyurem (White)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Turboblaze', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Mystic Kyurem (White)'");
			$fused = 1;
			$fusion = 'Mystic Kyurem (White)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Mystic Kyurem' && $reshiram_zekrom['name'] === 'Mystic Zekrom'){

			// Fuse to Mystic Kyurem (Black)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Mystic Kyurem (Black)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Teravolt', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Mystic Kyurem (Black)'");
			$fused = 1;
			$fusion = 'Mystic Kyurem (Black)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Shadow Kyurem' && $reshiram_zekrom['name'] === 'Shadow Reshiram'){

			// Fuse to Shadow Kyurem (White)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Shadow Kyurem (White)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Turboblaze', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Shadow Kyurem (White)'");
			$fused = 1;
			$fusion = 'Shadow Kyurem (White)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Shadow Kyurem' && $reshiram_zekrom['name'] === 'Shadow Zekrom'){

			// Fuse to Shadow Kyurem (Black)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Shadow Kyurem (Black)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Teravolt', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '	Shadow Kyurem (Black)'");
			$fused = 1;
			$fusion = 'Shadow Kyurem (Black)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Metallic Kyurem' && $reshiram_zekrom['name'] === 'Metallic Reshiram'){

			// Fuse to Metallic Kyurem (White)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Metallic Kyurem (White)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Turboblaze', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Metallic Kyurem (White)'");
			$fused = 1;
			$fusion = 'Metallic Kyurem (White)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		elseif($kyurem['name'] === 'Metallic Kyurem' && $reshiram_zekrom['name'] === 'Metallic Zekrom'){

			// Fuse to Metallic Kyurem (Black)
			// Update old Kyurem, delete Reshiram/Zekrom, update ability

			$update = mysql_query("UPDATE pokemon SET name = 'Metallic Kyurem (Black)', lvl = '100', exp = '50000' WHERE id = '{$kyurem['id']}'");
			$update2 = mysql_query("UPDATE pokemon_stats SET ability = 'Teravolt', ball = 'Cherish Ball' WHERE id = '{$kyurem['id']}'");
			$delete = mysql_query("DELETE FROM pokemon WHERE id = '{$reshiram_zekrom['id']}'");
			$delete2 = mysql_query("DELETE FROM pokmeon_stats WHERE id = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s1 = '' WHERE s1 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s2 = '' WHERE s2 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s3 = '' WHERE s3 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s4 = '' WHERE s4 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s5 = '' WHERE s5 = '{$reshiram_zekrom['id']}'");
			$slot1 = mysql_query("UPDATE members SET s6 = '' WHERE s6 = '{$reshiram_zekrom['id']}'");
			$pguide = mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = 'Metallic Kyurem (Black)'");
			$fused = 1;
			$fusion = 'Metallic Kyurem (Black)';

			// Update users points and users clan points

			$aiir = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$aiir2 = mysql_fetch_array($aiir);
			$unique = mysql_num_rows(mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid"));
			$totalexp = $aiir2['totalexp'] - $total + 50000;
			$avgexp = $aiir2['totalexp'] / $aiir2['total_poke'];
			$battle = $aiir2['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', points = '$p7' WHERE id = '{$_SESSION['myid']}'");

			if(isset($_SESSION['clan'])){ // update your clan points if you're in a clan
				mysql_query("UPDATE clan_members SET exp = $totalexp WHERE id = '{$_SESSION['myid']}'");
				$clanexp = mysql_query("SELECT SUM(exp) FROM clan_members WHERE clan_name = '{$_SESSION['clan']}'");
				$claexp = mysql_fetch_array($clanexp);
				mysql_query("UPDATE clans SET exp = '{$claexp['SUM(exp)']}' WHERE name = '{$_SESSION['clan']}'");
				$claninfo = mysql_query("SELECT * FROM clans WHERE name = '{$_SESSION['clan']}'");
				$clan_info = mysql_fetch_array($claninfo);
				$wins = $clan_info['wins'];
				$expp = $clan_info['exp'];
				$members = $clan_info['members'];
				$avgexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avgexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		}
		else{
			$typeerror = 1;
		}
	}
	else{
		$ownererror = 1;
	}
}
?>
