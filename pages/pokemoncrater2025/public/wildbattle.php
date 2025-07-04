<?php
include('kick.php');

if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:login.php?goawayxP=1");
	exit();
}
include('pv_connect_to_db.php');
if(is_numeric($_REQUEST['bid'])){
	unset($_SESSION['adonefor']);
}
$_SESSION['abattleusername'] = $_SESSION['myuser'];
$_SESSION['abattleid'] = $_SESSION['myid'];
$time = time();



if(!$_REQUEST['ajax']){
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js?2"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
<?
if($_SESSION['layout'] == '1'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/blue/game.css" media="screen" />';
}
elseif($_SESSION['layout'] == '0'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/red/game.css" media="screen" />';
}
if($_SESSION['layout'] == '2'){
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/global.css" media="screen" />';
	echo '<link rel="stylesheet" type="text/css" href="html/static/css/black/game.css" media="screen" />';
}
?>
<!--[if lt IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//v3/ie6-.js"></script>
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Shqipe Battle Arena v3 - Wild Battle</title>
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
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
<?php include('includes/usernav.php');


echo '<!-- <embed src="bw_wild.mp3" autostart="true" volume="50%" loop="true" width="2" height="0"></embed> -->';
?>
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
<div style="float: right;">
<?php
include('/var/www/ads/sidead.php');
?>
</div>
<div id="scrollContent">
<div id="ajax">
<?php
}
if($_SESSION['adonefor'][0] == 3 || $_SESSION['adonefor'][1] == 2){
	if(!isset($_SESSION['map'])){
		$_SESSION['map'] = 1;
	}
	if($_SESSION['adonefor'][2] != "t"){
		$timebefore = mysql_query("SELECT btime FROM members WHERE id = '{$_SESSION['myid']}'");
		$tb = mysql_fetch_array($timebefore);
		$tbb = $tb['btime'];
		$time = time();
		$secs = $time - $tbb;
		if($secs < 10){
			$no = "no";
		}
		else {
			mysql_query("UPDATE members SET btime = '$time' WHERE id = '{$_SESSION['myid']}'");
			$no = "yes";
		}
	}
}
if($_SESSION['adonefor'][0] == 3){
	if($_SESSION['adonefor'][2] != "t"){
		if($no == "no"){
			?>
<div class="errorMsg">You have already completed a battle within the last 10 seconds. This is in effect to prevent cheating of any kind.</div>
<p class="optionsList autowidth"><strong>Options:</strong><br />
<a href="/map.php?map=<?php echo $_SESSION['map']; ?>" class="deselected">Return to the Map</a><br />
<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
<a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
			<?php
		}
		else{
			if($_SESSION['alost'] == "yes"){
				$steve = 3;
			}
			if($_SESSION['adonefor'][1] == 2){
				$money = rand(100,5000);
				if($steve != 3){
					function afterbattle(){
						$adhd = $_SESSION['atest1'] + $_SESSION['atest2'] + $_SESSION['atest3'] + $_SESSION['atest4'] + $_SESSION['atest5'] + $_SESSION['atest6'];
						$adds = $adhd / $_SESSION['acount'];
						$addo = $_SESSION['aop1'][5];
						if($_SESSION['aop1'][10] == 1){} else {
							$addo = $add / 2;
						}
						$over = $addo / $adds;
						$m = $over * 500;
						$exp = $m * $_SESSION['aop1'][10];
						$exp = $exp * $_SESSION['myeb'];
						$exp2 = round($exp / $_SESSION['acount']);
						return $exp2;
					}
					$exp2 = afterbattle();
					function randmoney($exp){
						$rvar = rand(1,1000);
						switch($rvar){
							case ($rvar <= 500):
							$moni = round($exp * 0.5);
							break;
							case ($rvar >= 501 && $rvar <= 800):
							$moni = round($exp * 1.2);
							break;
							case ($rvar >= 801 && $rvar <= 950):
							$moni = round($exp * 1.5);
							break;
							case ($rvar >= 951 && $rvar <= 994):
							$moni = round($exp * 2);
							break;
							case ($rvar >= 995 && $rvar <= 999):
							$moni = round($exp * 4);
							break;
							case ($rvar == 1000):
							$moni = round($exp * 7.5);
							break;
						}
						return $moni;
					}
					$money = randmoney($exp2);
					$tv = $_SESSION['anum'];
					
					foreach($tv as $x){
						if($x != 0 && $x != ""){
							$happy = rand(1,2);
							mysql_query("UPDATE pokemon SET exp = exp + $exp2 WHERE id = '$x'");
							mysql_query("UPDATE pokemon_stats SET happiness = happiness + $happy WHERE id = '$x'");
							$trial = mysql_query("SELECT exp FROM pokemon WHERE id = '$x'");
							$lala = mysql_fetch_array($trial);
							$lala2 = floor($lala['exp'] / 500);
							if($lala2 >= 100){


								mysql_query("UPDATE pokemon SET lvl = '100' WHERE id = '$x'");
							}
							else {
								mysql_query("UPDATE pokemon SET lvl = '$lala2' WHERE id = '$x'");
							}
						}
					}
					$qu = "battle = battle + 1";
					$sign = "+";
				}
				else {
					$qu = "losses = losses + 1";
					$sign = "-";
				}
				$sideright = mysql_query("SELECT uniques, battle, total_poke, totalexp, money FROM members WHERE id = '{$_SESSION['myid']}'");
				$sideright1 = mysql_fetch_array($sideright);
				if($sign == "-"){
					if($sideright1['money'] < $money){
						$money = $sideright1['money'];
					}
				}
				
				$unique = $sideright1['uniques'];
				$totalexp = $sideright1['totalexp'] + $exp2;
				$avgexp = $totalexp / $sideright1['total_poke'] ;
				$battle = $sideright1['battle'];
				$p1 = sqrt($totalexp);
				$p2 = sqrt($avgexp);
				$p3 = sqrt($unique);
				$p4 = log($battle);
				$p5 = $p1 * $p2 * $p3 * $p4;
				$p6 = $p5 / 1000;
				$p7 = round($p6, 1);
				mysql_query("UPDATE members SET averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique', points = '$p7', $qu, money = money $sign $money WHERE id = '{$_SESSION['myid']}'");
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
					$avegexp = $expp / $members;
					$po0 = sqrt($members);
					$po1 = sqrt($expp);
					$po2 = sqrt($avegexp);
					$po3 = log($wins);
					$po4 = $po1 * $po2 * $po3 * $po0;
					$po5 = $po4 / 10000;
					$po6 = round($po5, 1);
					mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
				}
				if($steve != 3){
					?>
                    
                    <h2>Congratulations! You won the battle!</h2>
                    <h3>Your team beat Wild <?php echo $_SESSION['aop1'][0]; ?>.</h3>
					
					<?php
				}
				else {
					?>
                    
                    <h2>Sorry, you lost the battle.</h2>
                    <h3>Your team lost to <?php echo $_SESSION['aop1'][0]; ?>.</h3>
					
					<?php
				}
				?>
                <table cellpadding="0" cellspacing="0" class="pokemonList">
				<?php if($steve != 3){
					?>
                    <tr><td>
					<?php if(is_numeric($_SESSION['anum'][0])){
						?>
                        <p><img src="html/static/images/pokemon/<?php echo $_SESSION['as1'][0]; ?>.gif" align="absmiddle"> <strong><a href="/pokedex.php?pid=<?php echo $_SESSION['as1'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as1'][1]; ?>', 1); return false;"><?php echo $_SESSION['as1'][0]; ?></a></strong></p>
						<?php
					}
					if(is_numeric($_SESSION['anum'][1])){
						?>
                        <p><img src="http://static.pokemon-shqipe.co.ukm/images/pokemon/<?php echo $_SESSION['as2'][0]; ?>.gif" align="absmiddle"> <strong><a href="/pokedex.php?pid=<?php echo $_SESSION['as2'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as2'][1]; ?>', 1); return false;"><?php echo $_SESSION['as2'][0]; ?></a></strong></p>
						<?php
					}
					if(is_numeric($_SESSION['anum'][2])){
						?>
                        <p><img src="html/static/images/pokemon/<?php echo $_SESSION['as3'][0]; ?>.gif" align="absmiddle"> <strong><a href="/pokedex.php?pid=<?php echo $_SESSION['as3'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as3'][1]; ?>', 1); return false;"><?php echo $_SESSION['as3'][0]; ?></a></strong></p>
						<?php
					}
					if(is_numeric($_SESSION['anum'][3])){
						?>
                        <p><img src="html/static/images/pokemon/<?php echo $_SESSION['as4'][0]; ?>.gif" align="absmiddle"> <strong><a href="/pokedex.php?pid=<?php echo $_SESSION['as4'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as4'][1]; ?>', 1); return false;"><?php echo $_SESSION['as4'][0]; ?></a></strong></p>
						<?php
					}
					if(is_numeric($_SESSION['anum'][4])){
						?>
                        <p><img src="html/static/images/pokemon/<?php echo $_SESSION['as5'][0]; ?>.gif" align="absmiddle"> <strong><a href="/pokedex.php?pid=<?php echo $_SESSION['as5'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as5'][1]; ?>', 1); return false;"><?php echo $_SESSION['as5'][0]; ?></a></strong></p>
						<?php
					}
					if(is_numeric($_SESSION['anum'][5])){
						?>
                        <p><img src="html/static/images/pokemon/<?php echo $_SESSION['as6'][0]; ?>.gif" align="absmiddle"> <strong><a href="/pokedex.php?pid=<?php echo $_SESSION['as6'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as6'][1]; ?>', 1); return false;"><?php echo $_SESSION['as6'][0]; ?></a></strong></p>
						<?php
					}
					?>
                    </td></tr>
					<?php
				}
				?>
                </table>
				<?php if($steve != 3){
					?>
                    <p>Each Pokemon above gained <?php echo number_format($exp2); ?> experience points.
                    <br />You also won <img src="html/static/images/misc/pmoney.gif"><?php echo number_format($money); ?> to buy items with.</p>
					<?php
				}
				else {
					?>
                    <p>You also lost <img src="html/static/images/misc/pmoney.gif"><?php echo number_format($money); ?>.</p>
					<?php
				}
			}
			else {
				?>
                <div class="errorMsg">You have either already completed the battle or an error has occurred.</div>
				<?php
			}
			?>
            <p class="optionsList autowidth"><strong>Options:</strong><br />
            <a href="/map.php?map=<? echo $_SESSION['map']; ?>" class="deselected">Return to the Map</a><br />
            <a href="/your_team.php" class="deselected">View/Modify Team</a><br />
            <a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
			<?php
		}
	}
	else { 
		$hi = mysql_query("SELECT * FROM pguide WHERE name = '{$_SESSION['aop1'][0]}'");
		$hii = mysql_fetch_array($hi);
		$lvl = $_SESSION['aop1'][5] * 500;
		if($_SESSION['abattleid'] && $_SESSION['abattleusername'] && is_numeric($lvl) && $lvl > 5){
				// Determine the Pokemon's gender
				// Pokemon that can only be female
			if(strstr($_SESSION['aop1'][0],'Nidoran (F)') || strstr($_SESSION['aop1'][0],'Nidorina') || strstr($_SESSION['aop1'][0],'Nidoqueen') || strstr($_SESSION['aop1'][0],'Chansey') || strstr($_SESSION['aop1'][0],'Kangaskhan') || strstr($_SESSION['aop1'][0],'Jynx') || strstr($_SESSION['aop1'][0],'Miltank') || strstr($_SESSION['aop1'][0],'Blissey') || strstr($_SESSION['aop1'][0],'Illumise') || strstr($_SESSION['aop1'][0],'Wormadam') || strstr($_SESSION['aop1'][0],'Vespiquen') || strstr($_SESSION['aop1'][0],'Froslass') || strstr($_SESSION['aop1'][0],'Petlil') || strstr($_SESSION['aop1'][0],'Lilligant') || strstr($_SESSION['aop1'][0],'Vullaby') || strstr($_SESSION['aop1'][0],'Mandibuzz') || strstr($_SESSION['aop1'][0],'Flabebe') || strstr($_SESSION['aop1'][0],'Floette') || strstr($_SESSION['aop1'][0],'Florges') || strstr($_SESSION['aop1'][0],'Smoochum') || strstr($_SESSION['aop1'][0],'Latias') || strstr($_SESSION['aop1'][0],'Happiny') || strstr($_SESSION['aop1'][0],'Cresselia')){
				$gender = Female;
			}
				// Pokemon that can only be male
			elseif(strstr($_SESSION['aop1'][0],'Nidoran (M)') || strstr($_SESSION['aop1'][0],'Nidorino') || strstr($_SESSION['aop1'][0],'Nidoking') || strstr($_SESSION['aop1'][0],'Hitmonlee') || strstr($_SESSION['aop1'][0],'Hitmonchan') || strstr($_SESSION['aop1'][0],'Tauros') || strstr($_SESSION['aop1'][0],'Hitmontop') || strstr($_SESSION['aop1'][0],'Volbeat') || strstr($_SESSION['aop1'][0],'Mothim') || strstr($_SESSION['aop1'][0],'Gallade') || strstr($_SESSION['aop1'][0],'Throh') || strstr($_SESSION['aop1'][0],'Sawk') || strstr($_SESSION['aop1'][0],'Rufflet') || strstr($_SESSION['aop1'][0],'Braviary') || strstr($_SESSION['aop1'][0],'Tyrogue') || strstr($_SESSION['aop1'][0],'Latios') || strstr($_SESSION['aop1'][0],'Tornadus') || strstr($_SESSION['aop1'][0],'Thundurus') || strstr($_SESSION['aop1'][0],'Landorus')){
				$gender = Male;
			}
				// Pokemon that are genderless
			elseif(strstr($_SESSION['aop1'][0],'Magnemite') || strstr($_SESSION['aop1'][0],'Magneton') || strstr($_SESSION['aop1'][0],'Voltorb') || strstr($_SESSION['aop1'][0],'Electrode') || strstr($_SESSION['aop1'][0],'Staryu') || strstr($_SESSION['aop1'][0],'Starmie') || strstr($_SESSION['aop1'][0],'Porygon') || strstr($_SESSION['aop1'][0],'Porygon2') || strstr($_SESSION['aop1'][0],'Shedinja') || strstr($_SESSION['aop1'][0],'Lunatone') || strstr($_SESSION['aop1'][0],'Solrock') || strstr($_SESSION['aop1'][0],'Baltoy') || strstr($_SESSION['aop1'][0],'Claydol') || strstr($_SESSION['aop1'][0],'Beldum') || strstr($_SESSION['aop1'][0],'Metang') || strstr($_SESSION['aop1'][0],'Metagross') || strstr($_SESSION['aop1'][0],'Bronzor') || strstr($_SESSION['aop1'][0],'Bronzong') || strstr($_SESSION['aop1'][0],'Magnezone') || strstr($_SESSION['aop1'][0],'Porygon-Z') || strstr($_SESSION['aop1'][0],'Rotom') || strstr($_SESSION['aop1'][0],'Phione') || strstr($_SESSION['aop1'][0],'Manaphy') || strstr($_SESSION['aop1'][0],'Klink') || strstr($_SESSION['aop1'][0],'Klang') || strstr($_SESSION['aop1'][0],'Klinklang') || strstr($_SESSION['aop1'][0],'Cryogonal') || strstr($_SESSION['aop1'][0],'Golett') || strstr($_SESSION['aop1'][0],'Golurk') || strstr($_SESSION['aop1'][0],'Carbink') || strstr($_SESSION['aop1'][0],'Ditto') || strstr($_SESSION['aop1'][0],'Articuno') || strstr($_SESSION['aop1'][0],'Zapdos') || strstr($_SESSION['aop1'][0],'Moltres') || strstr($_SESSION['aop1'][0],'Mewtwo') || strstr($_SESSION['aop1'][0],'Mew') || strstr($_SESSION['aop1'][0],'Unown') || strstr($_SESSION['aop1'][0],'Raikou') || strstr($_SESSION['aop1'][0],'Entei') || strstr($_SESSION['aop1'][0],'Suicune') || strstr($_SESSION['aop1'][0],'Lugia') || strstr($_SESSION['aop1'][0],'Ho-oh') || strstr($_SESSION['aop1'][0],'Celebi') || strstr($_SESSION['aop1'][0],'Regirock') || strstr($_SESSION['aop1'][0],'Regice') || strstr($_SESSION['aop1'][0],'Registeel') || strstr($_SESSION['aop1'][0],'Kyogre') || strstr($_SESSION['aop1'][0],'Groudon') || strstr($_SESSION['aop1'][0],'Rayquaza') || strstr($_SESSION['aop1'][0],'Jirachi') || strstr($_SESSION['aop1'][0],'Deoxys') || strstr($_SESSION['aop1'][0],'Uxie') || strstr($_SESSION['aop1'][0],'Mesprit') || strstr($_SESSION['aop1'][0],'Azelf') || strstr($_SESSION['aop1'][0],'Dialga') || strstr($_SESSION['aop1'][0],'Palkia') || strstr($_SESSION['aop1'][0],'Regigigas') || strstr($_SESSION['aop1'][0],'Giratina') || strstr($_SESSION['aop1'][0],'Darkrai') || strstr($_SESSION['aop1'][0],'Darkrown') || strstr($_SESSION['aop1'][0],'Shaymin') || strstr($_SESSION['aop1'][0],'Arceus') || strstr($_SESSION['aop1'][0],'Victini') || strstr($_SESSION['aop1'][0],'Cobalion') || strstr($_SESSION['aop1'][0],'Terrakion') || strstr($_SESSION['aop1'][0],'Virizion') || strstr($_SESSION['aop1'][0],'Reshiram') || strstr($_SESSION['aop1'][0],'Zekrom') || strstr($_SESSION['aop1'][0],'Kyurem') || strstr($_SESSION['aop1'][0],'Keldeo') || strstr($_SESSION['aop1'][0],'Meloetta') || strstr($_SESSION['aop1'][0],'Genesect') || strstr($_SESSION['aop1'][0],'Xerneas') || strstr($_SESSION['aop1'][0],'Yveltal') || strstr($_SESSION['aop1'][0],'Zygarde') || strstr($_SESSION['aop1'][0],'Missingno') || strstr($_SESSION['aop1'][0],'Volcanion')){
				$gender = None;
			}
			elseif(strstr($_SESSION['aop1'][0],'Combee')){ // combee has a 12.5% chance of being a female, this overrides the original gender determination
				$gend = rand(1,8);
				if($gend == '1'){
					$gender = Female;
				}
				elseif($gend > 1){
					$gender = Male;
				}
			}
			else{
				$gend = rand(1,2);
				if($gend == '1'){
					$gender = Male;
				}
				elseif($gend == '2'){
					$gender = Female;
				}
			}
			mysql_query("INSERT INTO pokemon (name, pid, owner, a1, a2, a3, a4, lvl, t1, t2, exp, rowner) VALUES ('{$_SESSION['aop1'][0]}', '{$hii['id']}', '{$_SESSION['myid']}', '{$hii['a1']}', '{$hii['a2']}', '{$hii['a3']}', '{$hii['a4']}', '{$_SESSION['aop1'][5]}', '{$hii['type1']}', '{$hii['type2']}', '$lvl', '{$_SESSION['myuser']}')");
			$h3 = mysql_insert_id();
				// Include the stat generating pages
			include('stats/ivs.php');
			include('stats/natures.php');
			include('stats/abilities.php');
			mysql_query("INSERT INTO pokemon_stats (id, hp_iv, attack_iv, defense_iv, spatk_iv, spdef_iv, speed_iv, nature, ability, ot, gender, ball) VALUES ('$h3', '$hp_iv', '$attack_iv', '$defense_iv', '$spatk_iv', '$spdef_iv', '$speed_iv', '$nature', '$ability', '{$_SESSION['myuser']}', '$gender', '{$_SESSION['pokeball']}')");
			mysql_query("UPDATE pguide SET amount = amount + 1 WHERE name = '{$_SESSION['aop1'][0]}'");
			$sideright = mysql_query("SELECT totalexp, total_poke, battle FROM members WHERE id = '{$_SESSION['myid']}'");
			$sideright1 = mysql_fetch_array($sideright);
			$result = mysql_query("SELECT pid FROM pokemon WHERE owner = '{$_SESSION['myid']}' GROUP BY pid");
		
			unset($_SESSION['your_pokemon']);
			while($h = mysql_fetch_array($result)){
				$_SESSION['your_pokemon'][] = $h['pid'];
			}
			$unique = mysql_num_rows($result);
			$totalexp = $sideright1['totalexp'] + $exp + $lvl;
			$avgexp = $totalexp / ($sideright1['total_poke'] + 1) ;
			$battle = $sideright1['battle'];
			$p1 = sqrt($totalexp);
			$p2 = sqrt($avgexp);
			$p3 = sqrt($unique);
			$p4 = log($battle);
			$p5 = $p1 * $p2 * $p3 * $p4;
			$p6 = $p5 / 1000;
			$p7 = round($p6, 1);
			mysql_query("UPDATE members SET total_poke = total_poke + 1, averageexp = '{$avgexp}', totalexp = '{$totalexp}', uniques = '$unique', points = '$p7' WHERE id = '{$_SESSION['myid']}'");
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
				$avegexp = $expp / $members;
				$po0 = sqrt($members);
				$po1 = sqrt($expp);
				$po2 = sqrt($avegexp);
				$po3 = log($wins);
				$po4 = $po1 * $po2 * $po3 * $po0;
				$po5 = $po4 / 10000;
				$po6 = round($po5, 1);
				mysql_query("UPDATE clans SET points = '$po6' WHERE name = '{$_SESSION['clan']}'");
			}
		
		$r = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
		$rr = mysql_fetch_array($r);
		if(!is_numeric($rr['s2'])){
			mysql_query("UPDATE members SET s2 = '$h3' WHERE id = '{$_SESSION['myid']}'");
			$_SESSION['my_team'][1] = $h3;
		}
		elseif(!is_numeric($rr['s3'])){
			mysql_query("UPDATE members SET s3 = '$h3' WHERE id = '{$_SESSION['myid']}'");
			$_SESSION['my_team'][2] = $h3;
		}
		elseif(!is_numeric($rr['s4'])){
			mysql_query("UPDATE members SET s4 = '$h3' WHERE id = '{$_SESSION['myid']}'");
			$_SESSION['my_team'][3] = $h3;
		}
		elseif(!is_numeric($rr['s5'])){
			mysql_query("UPDATE members SET s5 = '$h3' WHERE id = '{$_SESSION['myid']}'");
			$_SESSION['my_team'][4] = $h3;
		}
		elseif(!is_numeric($rr['s6'])){
			mysql_query("UPDATE members SET s6 = '$h3' WHERE id = '{$_SESSION['myid']}'");
			$_SESSION['my_team'][5] = $h3;
		}
	}
	?>
    
    <div class="actionMsg">You have captured Wild <?php echo $_SESSION['aop1'][0]; ?>.</div>
    <p><img src="html/static/images/pokemon/<?php echo $_SESSION['aop1'][0]; ?>.gif"></p>
    <p class="optionsList autowidth"><strong>Options:</strong><br />
    <a href="/map.php?map=<? echo $_SESSION['map']; ?>" class="deselected">Return to the Map</a><br />
    <a href="/your_team.php" class="deselected">View/Modify Team</a><br />
    <a href="/your_pokemon.php" class="deselected">View All Pok&eacute;mon</a></p>
	<?php
	}
    $ar1 = array("4","5"); $_SESSION['adonefor'] = $ar1; unset($_SESSION['aerror'], $_SESSION['achange'], $_SESSION['acheck'], $_SESSION['aca1'], $_SESSION['aca2'], $_SESSION['aca3'], $_SESSION['aca4'], $_SESSION['aoca1'], $_SESSION['aoca2'], $_SESSION['aoca3'], $_SESSION['aoca4'], $_SESSION['atest1'], $_SESSION['atest2'], $_SESSION['atest3'], $_SESSION['atest4'], $_SESSION['atest5'], $_SESSION['atest6'], $_SESSION['anum2'], $_SESSION['anum3'], $_SESSION['anum4'], $_SESSION['anum5'], $_SESSION['anum6'], $_SESSION['alost'], $_SESSION['acount'], $_SESSION['anum'], $_SESSION['aocurrent'], $_SESSION['acurrent'], $_SESSION['as1'], $_SESSION['as2'], $_SESSION['as3'], $_SESSION['as4'], $_SESSION['as5'], $_SESSION['as6'], $_SESSION['aop1'], $_SESSION['aop2'], $_SESSION['aop3'], $_SESSION['aop4'], $_SESSION['aop5'], $_SESSION['aop6']);
}
else {
	if(!isset($_POST['wildpoke']) && !$_POST['bat']){
		if(!isset($_SESSION['map'])){
			$_SESSION['map'] = 1;
		}
		echo "<div class=\"errorMsg\">No wild pok&eacute;mon are around to battle, please return to the maps if you would like to battle one.</div>";
		?>
        <p class="optionsList autowidth"><strong>Options:</strong><br />
        <a href="/map.php?map=<? echo $_SESSION['map']; ?>" class="deselected">Return to the Map</a><br />
        <a href="/your_team.php" class="deselected">View/Modify Team</a><br />
        <a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
		
		<?php
       unset($_SESSION['aerror'], $_SESSION['achange'], $_SESSION['acheck'], $_SESSION['aca1'], $_SESSION['aca2'], $_SESSION['aca3'], $_SESSION['aca4'], $_SESSION['aoca1'], $_SESSION['aoca2'], $_SESSION['aoca3'], $_SESSION['aoca4'], $_SESSION['atest1'], $_SESSION['atest2'], $_SESSION['atest3'], $_SESSION['atest4'], $_SESSION['atest5'], $_SESSION['atest6'], $_SESSION['anum2'], $_SESSION['anum3'], $_SESSION['anum4'], $_SESSION['anum5'], $_SESSION['anum6'], $_SESSION['alost'], $_SESSION['acount'], $_SESSION['anum'], $_SESSION['aocurrent'], $_SESSION['acurrent'], $_SESSION['as1'], $_SESSION['as2'], $_SESSION['as3'], $_SESSION['as4'], $_SESSION['as5'], $_SESSION['as6'], $_SESSION['aop1'], $_SESSION['aop2'], $_SESSION['aop3'], $_SESSION['aop4'], $_SESSION['aop5'], $_SESSION['aop6']);
	}
	else {
		if(isset($_POST['wildpoke']) && $_SESSION['lvl'] >= 5 && $_SESSION['lvl'] < 100){
			unset($_SESSION['aerror'], $_SESSION['achange'], $_SESSION['acheck'], $_SESSION['aca1'], $_SESSION['aca2'], $_SESSION['aca3'], $_SESSION['aca4'], $_SESSION['aoca1'], $_SESSION['aoca2'], $_SESSION['aoca3'], $_SESSION['aoca4'], $_SESSION['atest1'], $_SESSION['atest2'], $_SESSION['atest3'], $_SESSION['atest4'], $_SESSION['atest5'], $_SESSION['atest6'], $_SESSION['anum2'], $_SESSION['anum3'], $_SESSION['anum4'], $_SESSION['anum5'], $_SESSION['anum6'], $_SESSION['alost'], $_SESSION['acount'], $_SESSION['anum'], $_SESSION['aocurrent'], $_SESSION['acurrent'], $_SESSION['as1'], $_SESSION['as2'], $_SESSION['as3'], $_SESSION['as4'], $_SESSION['as5'], $_SESSION['as6'], $_SESSION['aop1'], $_SESSION['aop2'], $_SESSION['aop3'], $_SESSION['aop4'], $_SESSION['aop5'], $_SESSION['aop6']);
			$ar2 = array("7","8");
			$_SESSION['adonefor'] = $ar2;
			$_SESSION['acheck'] = 6;
			$_SESSION['acount'] = 0;
			$it = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}'");
			$itt = mysql_fetch_array($it);
			$_SESSION['aitems'] = array("{$itt['Potion']}","{$itt['Super_Potion']}","{$itt['Hyper_Potion']}","{$itt['Full_Heal']}","{$itt['Awakening']}","{$itt['Parlyz_Heal']}","{$itt['Antidote']}","{$itt['Burn_Heal']}","{$itt['Ice_Heal']}","{$itt['Poke_Ball']}","{$itt['Great_Ball']}","{$itt['Ultra_Ball']}","{$itt['Master_Ball']}");
			
			// Opponent var set
			$name = $_SESSION['wb'];
			$lvl = $_SESSION['lvl'];
			unset($_SESSION['wb'], $_SESSION['lvl']);
			$rij = mysql_query("SELECT * FROM pguide WHERE id = '$name'");
			$riji = mysql_fetch_array($rij);
			if(strstr($riji['name'],'Shiny')){
				$tem = $lvl * 5;
			}
			else {
				$tem = $lvl * 4;
			}
			$array = array("{$riji['name']}","{$riji['a1']}","{$riji['a2']}","{$riji['a3']}","{$riji['a4']}","$lvl","100","$tem","$tem","1","1","{$riji['type1']}","{$riji['type2']}","n");
			$_SESSION['aop1'] = $array;
			
			// your var set
			$r = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			$re = mysql_fetch_array($r);
			$_SESSION['as1'] = $re['s1'];
			$_SESSION['as2'] = $re['s2'];
			$_SESSION['as3'] = $re['s3'];
			$_SESSION['as4'] = $re['s4'];
			$_SESSION['as5'] = $re['s5'];
			$_SESSION['as6'] = $re['s6'];
			$suno = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id = '{$_SESSION['as1']}'");
			$sduno = mysql_fetch_array($suno);
			if(strstr($sduno['name'],'Shiny')){
				$tem = $sduno['lvl'] * 5;
			}
			else {
				$tem = $sduno['lvl'] * 4;
			}
			$array = array("{$sduno['name']}","{$sduno['id']}","{$sduno['a1']}","{$sduno['a2']}","{$sduno['a3']}","{$sduno['a4']}","{$sduno['lvl']}","100","$tem","$tem","1","{$sduno['t1']}","{$sduno['t2']}","n");
			$_SESSION['as1'] = $array;
			if(is_numeric($re['s2'])){
				$auno = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id = '{$_SESSION['as2']}'");
				$aduno = mysql_fetch_array($auno);
				if(strstr($aduno['name'],'Shiny')){
					$tem = $aduno['lvl'] * 5;
				}
				else {
					$tem = $aduno['lvl'] * 4;
				}
				$array = array("{$aduno['name']}","{$aduno['id']}","{$aduno['a1']}","{$aduno['a2']}","{$aduno['a3']}","{$aduno['a4']}","{$aduno['lvl']}","100","$tem","$tem","2","{$aduno['t1']}","{$aduno['t2']}","n");
				$_SESSION['as2'] = $array;
			}
			if(is_numeric($re['s3'])){
				$buno = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id = '{$_SESSION['as3']}'");
				$bduno = mysql_fetch_array($buno);
				if(strstr($bduno['name'],'Shiny')){
					$tem = $bduno['lvl'] * 5;
				}
				else {
					$tem = $bduno['lvl'] * 4;
				}
				$array = array("{$bduno['name']}","{$bduno['id']}","{$bduno['a1']}","{$bduno['a2']}","{$bduno['a3']}","{$bduno['a4']}","{$bduno['lvl']}","100","$tem","$tem","3","{$bduno['t1']}","{$bduno['t2']}","n");
				$_SESSION['as3'] = $array;
			}
			if(is_numeric($re['s4'])){
				$cuno = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id = '{$_SESSION['as4']}'");
				$cduno = mysql_fetch_array($cuno);
				if(strstr($cduno['name'],'Shiny')){
					$tem = $cduno['lvl'] * 5;
				}
				else {
					$tem = $cduno['lvl'] * 4;
				}
				$array = array("{$cduno['name']}","{$cduno['id']}","{$cduno['a1']}","{$cduno['a2']}","{$cduno['a3']}","{$cduno['a4']}","{$cduno['lvl']}","100","$tem","$tem","4","{$cduno['t1']}","{$cduno['t2']}","n");
				$_SESSION['as4'] = $array;
			}
			if(is_numeric($re['s5'])){
				$duno = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id = '{$_SESSION['as5']}'");
				$dduno = mysql_fetch_array($duno);
				if(strstr($dduno['name'],'Shiny')){
					$tem = $dduno['lvl'] * 5;
				}
				else {
					$tem = $dduno['lvl'] * 4;
				}
				$array = array("{$dduno['name']}","{$dduno['id']}","{$dduno['a1']}","{$dduno['a2']}","{$dduno['a3']}","{$dduno['a4']}","{$dduno['lvl']}","100","$tem","$tem","5","{$dduno['t1']}","{$dduno['t2']}","n");
				$_SESSION['as5'] = $array;
			}
			if(is_numeric($re['s6'])){
				$euno = mysql_query("SELECT * FROM pokemon WHERE owner = '{$_SESSION['myid']}' AND id = '{$_SESSION['as6']}'");
				$eduno = mysql_fetch_array($euno);
				if(strstr($eduno['name'],'Shiny')){
					$tem = $eduno['lvl'] * 5;
				}
				else {
					$tem = $eduno['lvl'] * 4;

				}
				$array = array("{$eduno['name']}","{$eduno['id']}","{$eduno['a1']}","{$eduno['a2']}","{$eduno['a3']}","{$eduno['a4']}","{$eduno['lvl']}","100","$tem","$tem","6","{$eduno['t1']}","{$eduno['t2']}","n");
				$_SESSION['as6'] = $array;
			}
		}
		?>
		<form action="/wildbattle.php" method="post" name="battleForm" id="battleForm" onsubmit="get('/wildbattle.php', '', this); disableSubmitButton(this); return false;">
		<?php if($_SESSION['adonefor'][1] == 5 || $_SESSION['adonefor'][0] == 4){
			$var = "y";
			if(!isset($_SESSION['map'])){
				$_SESSION['map'] = 1;
			}
			?>
            
			<div class="errorMsg">It seems as though you have already completed this battle. No need to linger in the past.</div>
		<p class="optionsList autowidth"><strong>Options:</strong><br />
		<a href="/map.php?map=<? echo $_SESSION['map']; ?>" class="deselected">Return to the Map</a><br />
		<a href="/your_team.php" class="deselected">View/Modify Team</a><br />
		<a href="/your_pokemon.php" class="deselected">View All Pokemon</a></p>
			<?php
		}
		if($_POST['action'] && $_POST['bat'] && !$_POST['wildpoke'] && $var != "y"){
			if($_POST['action'] && $_POST['actionattack'] && $var != "y"){
				if(is_null($_SESSION['aocurrent'])){
					$been = "t";
				}
				if($_SESSION['aocurrent'][7] != 0 && $_SESSION['acurrent'][8] != 0){
					if($_POST['item']){
						function itemconvtr($iname, $iuser){
							$a = $iname;
							$b = " ";
							$c = "_";
							$d = str_replace($b, $c, $a);
							switch($iname){
								case "Potion":
								$e = "regained 20 HP.";
								$_SESSION['aitems'][0] = $_SESSION['aitems'][0] - 1;
								$g = 20;
								$_SESSION['acurrent'][8] = $_SESSION['acurrent'][8] + 20;
								$worked = 1;
								break;
								case "Super Potion":
								$e = "regained 100 HP.";
								$_SESSION['aitems'][1] = $_SESSION['aitems'][1] - 1;
								$g = 100;
								$_SESSION['acurrent'][8] = $_SESSION['acurrent'][8] + 100;
								$worked = 1;
								break;
								case "Hyper Potion":
								$e = "regained 250 HP.";
								$_SESSION['aitems'][2] = $_SESSION['aitems'][2] - 1;
								$g = 250;
								$_SESSION['acurrent'][8] = $_SESSION['acurrent'][8] + 250;
								$worked = 1;
								break;
								case "Full Heal":
								$e = "been healed of it's status affliction.";
								$_SESSION['aitems'][3] = $_SESSION['aitems'][3] - 1;
								$g = 0;
								$_SESSION['current'][13] = "n";
								$worked = 1;
								break;
								case "Awakening":
								$e = "woke up."; $_SESSION['aitems'][4] = $_SESSION['aitems'][4] - 1; $g = 0; $_SESSION['current'][13] = "n";
								$worked = 1;
								break;
								case "Parlyz Heal":
								$e = "been healed of it's paralysis."; $_SESSION['aitems'][5] = $_SESSION['aitems'][5] - 1; $g = 0; $_SESSION['current'][13] = "n";
								$worked = 1;
								break;
								case "Antidote":
								$e = "been healed of it's poison."; $_SESSION['aitems'][6] = $_SESSION['aitems'][6] - 1; $g = 0; $_SESSION['current'][13] = "n";
								$worked = 1;
								break;
								case "Burn Heal":
								$e = "been healed of it's burn."; $_SESSION['aitems'][7] = $_SESSION['aitems'][7] - 1; $g = 0; $_SESSION['current'][13] = "n";
								$worked = 1;
								break;
								case "Ice Heal":
								$e = "been defrosted."; $_SESSION['aitems'][8] = $_SESSION['aitems'][8] - 1; $g = 0; $_SESSION['current'][13] = "n";
								$worked = 1;
								break;
								case "Pokeball":
								$d = "Poke_ball";
								$rand = rand(1,3);
								$capture = "r";
								if($_SESSION['aitems'][9] < 1){
									$capture = "r";
									$worked = 0;
								}
								else{
									$check_item = mysql_fetch_array(mysql_query("Select * FROM items WHERE uid = '{$_SESSION['myid']}'"));
									if($check_item['Poke_Ball'] == '0'){
										$capture = "r";
										$worked = 0;
									}
									else{
										if($_SESSION['aocurrent'][7] < 20 && $rand == 1){
											$_SESSION['pokeball'] = "Poke Ball";
											$capture = "t";
										}
										if($_SESSION['aocurrent'][7] < 10 && $rand < 3){
											$_SESSION['pokeball'] = "Poke Ball";
											$capture = "t";
										}
										$_SESSION['aitems'][9] = $_SESSION['aitems'][9] - 1;
										$worked = 1;
									}
								}
								break;
								case "Great Ball":
								$rand = rand(1,10);
								$capture = "r";
								if($_SESSION['aitems'][10] < 1){
									$capture = "r";
									$worked = 0;
								}
								else{
									$check_item = mysql_fetch_array(mysql_query("Select * FROM items WHERE uid = '{$_SESSION['myid']}'"));
									if($check_item['Great_Ball'] == '0'){
										$capture = "r";
										$worked = 0;
									}
									else{
										if($_SESSION['aocurrent'][7] < 100 && $rand < 2){
											$_SESSION['pokeball'] = "Great Ball";
											$capture = "t";
										}
										if($_SESSION['aocurrent'][7] < 40 && $rand < 5){
											$_SESSION['pokeball'] = "Great Ball";
											$capture = "t";
										}
	
										if($_SESSION['aocurrent'][7] < 10 && $rand < 7){
											$_SESSION['pokeball'] = "Great Ball";
											$capture = "t";
										}
										$_SESSION['aitems'][10] = $_SESSION['aitems'][10] - 1;
										$worked = 1;
									}
								}
								break;
								case "Ultra Ball":
								$rand = rand(1,10);
								$capture = "r";

								if($_SESSION['aitems'][11] < 1){
									$capture = "r";
									$worked = 0;
								}
								else{
									$check_item = mysql_fetch_array(mysql_query("Select * FROM items WHERE uid = '{$_SESSION['myid']}'"));
									if($check_item['Ultra_Ball'] == '0'){
										$capture = "r";
										$worked = 0;
									}
									else{
										if($_SESSION['aocurrent'][7] < 200 && $rand < 3 || $_SESSION['myid'] == '3'){
											$_SESSION['pokeball'] = "Ultra Ball";
											$capture = "t";
										}
										if($_SESSION['aocurrent'][7] < 100 && $rand < 7){
											$_SESSION['pokeball'] = "Ultra Ball";
											$capture = "t";
										}
										if($_SESSION['aocurrent'][7] < 30 && $rand < 10){
											$_SESSION['pokeball'] = "Ultra Ball";
											$capture = "t";
										}
										$_SESSION['aitems'][11] = $_SESSION['aitems'][11] - 1;
										$worked = 1;
									}
								}
								break;
								case "Master Ball":
								if($_SESSION['aitems'][12] < 1){
									$capture = "r";
									$worked = 0;
								}
								else{
									$check_item = mysql_fetch_array(mysql_query("Select * FROM items WHERE uid = '{$_SESSION['myid']}'"));
									if($check_item['Master_Ball'] == '0'){
										$capture = "r";
										$worked = 0;
									}
									else{
										$_SESSION['pokeball'] = "Master Ball";
										$capture = "t";
										$_SESSION['aitems'][12] = $_SESSION['aitems'][12] - 1;
										$worked = 1;
									}
								}
								break;
							}
							$f = "Your " .  $_SESSION['acurrent'][0]  . " has " . $e;
							if($worked == 1){
								mysql_query("UPDATE items SET $d = $d - 1 WHERE uid = '{$_SESSION['myid']}'");
							}
							$_SESSION['acurrent'][8] = $_SESSION['acurrent'][8];
							if($_SESSION['acurrent'][8] > $_SESSION['acurrent'][9]){
								$_SESSION['acurrent'][8] = $_SESSION['acurrent'][9];
							}
							$h = array("$iname","$f","$capture");
							return $h;
						}
						$newvar = itemconvtr("{$_POST['item']}","{$_SESSION['current'][0]}");
					}
					switch($_POST['attack']){
						case 1:
						$attack = $_POST['1'];
						$power = $_SESSION['aca1'][0];
						$type = $_SESSION['aca1'][1];
						$accuracy = $_SESSION['aca1'][2];
						$category = $_SESSION['aca1'][3];
						break;
						case 2:
						$attack = $_POST['2'];
						$power = $_SESSION['aca2'][0];
						$type = $_SESSION['aca2'][1];
						$accuracy = $_SESSION['aca1'][2];
						$category = $_SESSION['aca1'][3];
						break;
						case 3:
						$attack = $_POST['3'];
						$power = $_SESSION['aca3'][0];
						$type = $_SESSION['aca3'][1];
						$accuracy = $_SESSION['aca1'][2];
						$category = $_SESSION['aca1'][3];
						break;
						case 4:
						$attack = $_POST['4'];
						$power = $_SESSION['aca4'][0];
						$type = $_SESSION['aca4'][1];
						$accuracy = $_SESSION['aca1'][2];
						$category = $_SESSION['aca1'][3];
						break;
					}
					$rn = rand(1,4);
					switch($rn){
						case 1:
						$attack2 = $_POST['o1'];
						$power2 = $_SESSION['aoca1'][0];
						$type2 = $_SESSION['aoca1'][1];
						$accuracy = $_SESSION['aoca1'][2];
						$category = $_SESSION['aoca1'][3];
						break;
						case 2:
						$attack2 = $_POST['o2'];
						$power2 = $_SESSION['aoca2'][0];
						$type2 = $_SESSION['aoca2'][1];
						$accuracy = $_SESSION['aoca1'][2];
						$category = $_SESSION['aoca1'][3];
						break;
						case 3:
						$attack2 = $_POST['o3'];
						$power2 = $_SESSION['aoca3'][0];
						$type2 = $_SESSION['aoca3'][1];
						$accuracy = $_SESSION['aoca1'][2];
						$category = $_SESSION['aoca1'][3];
						break;
						case 4:
						$attack2 = $_POST['o4'];
						$power2 = $_SESSION['aoca4'][0];
						$type2 = $_SESSION['aoca4'][1];
						$accuracy = $_SESSION['aoca1'][2];
						$category = $_SESSION['aoca1'][3];
						break;
					}
					include('typo.php');
					if(strstr($_SESSION['aocurrent'][0],'Mystic')){
						$ran = rand(1,4);
						if($ran == 2){
							$varo = 2;
						}
					}
					if(strstr($_SESSION['acurrent'][0],'Mystic')){
						$rand = rand(1,4);
						if($rand == 2){
							$varc = 2;
						}
					}
					$w = $_SESSION['aocurrent'][5] / 30;
					$ww = $power2 / 2;
					if($type2 == $_SESSION['aocurrent'][11] || $type2 == $_SESSION['aocurrent'][12]){
						$multn = 1.5;
					}
					else {
						$multn = 1;
					}
					$y = $type2;
					$u = $_SESSION['acurrent'][11];
					$f = $_SESSION['acurrent'][12];
					$damages = convert("$y", "$u", "$f");
					if(strstr($_SESSION['aocurrent'][0],'Dark ') || strstr($_SESSION['acurrent'][0],'Metallic ')){
						$d_a = 1;
						if(strstr($_SESSION['acurrent'][0],'Metallic ')){
							$d_a = $d_a - 0.25;
						}
						if(strstr($_SESSION['aocurrent'][0],'Dark ')){
							$d_a = $d_a + 0.25;
						}
						$w2 = $w * $ww;
						$w3 = $w2 * $d_a;
						$w4 = $w3 * $damages;
						$www = round($w4 * $multn);
					}
					else {
						$w2 = $w * $ww;
						$w3 = $w2 * $damages;
						$www = round($w3 * $multn);
					}
					if($varc == 2){
						$www = 0;
					}
					$_SESSION['acurrent'][8] = $_SESSION['acurrent'][8] - $www;
					$mult = $_SESSION['acurrent'][8] / $_SESSION['acurrent'][9];
					$_SESSION['acurrent'][7] = $mult * 100;
					if(!$item){
						$h = $_SESSION['acurrent'][6] / 30;
						$hh = $power / 2;
						if($type == $_SESSION['acurrent'][11] || $type == $_SESSION['acurrent'][12]){
							$multn = 1.5;
						}
						else {
							$multn = 1;
						}
						$y = $type;
						$u = $_SESSION['aocurrent'][11];
						$f = $_SESSION['aocurrent'][12];
						$damages2 = convert("$y", "$u", "$f");
						if(strstr($_SESSION['acurrent'][0],'Dark ') || strstr($_SESSION['aocurrent'][0],'Metallic ')){
							$d_a = 1;
							if(strstr($_SESSION['aocurrent'][0],'Metallic ')){
								$d_a = $d_a - 0.25;
							}
							if(strstr($_SESSION['acurrent'][0],'Dark ')){
								$d_a = $d_a + 0.25;
							}
							$h2 = $h * $hh;
							$h3 = $h2 * $d_a;
							$h4 = $h3 * $damages2;
							$hhh = round($h4 * $multn);
						}
						else {
							$h2 = $h * $hh;
							$h3 = $h2 * $damages2;
							$hhh = round($h3 * $multn);
						}
						if($varo == 2){
							$hhh = 0;
						}
						$_SESSION['aocurrent'][7] = $_SESSION['aocurrent'][7] - $hhh;
						$div = $_SESSION['aocurrent'][7] / $_SESSION['aocurrent'][8];
						$_SESSION['aocurrent'][6] = $div * 100;
					}
				}
				else {
					$been = "t";
				}
				if($_SESSION['acurrent'][8] <= 0){
					$_SESSION['acurrent'][8] = 0;
					$_SESSION['acurrent'][7] = 0;
					$changeout = 666;
				}
				if($_SESSION['aocurrent'][7] <= 0){
					$_SESSION['aocurrent'][7] = 0;
					$_SESSION['aocurrent'][6] = 0;
					$_SESSION['aop1'] = $_SESSION['aocurrent'];
					$_SESSION['afinished'] = 2;
					$down = 666;
				}
				$_SESSION['aop1'] = $_SESSION['aocurrent'];
				switch($_SESSION['acurrent'][10]){
					case 1:
					$_SESSION['as1'] = $_SESSION['acurrent'];
					break;
					case 2:
					$_SESSION['as2'] = $_SESSION['acurrent'];
					break;
					case 3:
					$_SESSION['as3'] = $_SESSION['acurrent'];
					break;
					case 4:
					$_SESSION['as4'] = $_SESSION['acurrent'];
					break;
					case 5:
					$_SESSION['as5'] = $_SESSION['acurrent'];
					break;
					case 6:
					$_SESSION['as6'] = $_SESSION['acurrent'];
					break;
				}
				
				if($_SESSION['as1'][8] == 0 && $_SESSION['as2'][8] == 0 && $_SESSION['as3'][8] == 0 && $_SESSION['as4'][8] == 0 && $_SESSION['as5'][8] == 0 && $_SESSION['as6'][8] == 0){
					$_SESSION['afinished'] = 2;
					$_SESSION['alost'] = "yes";
				}
			}
			if(!$_POST['actionattack'] && $_POST['active_pokemon']){
				if($_SESSION['as1'][1] == $_POST['active_pokemon']){
					$_SESSION['acurrent'] = $_SESSION['as1'];
					$_SESSION['anum'][0] = $_SESSION['as1'][1];;
					$_SESSION['acount'] = 1;
				}
				if($_SESSION['as2'][1] == $_POST['active_pokemon']){
					$_SESSION['acurrent'] = $_SESSION['as2'];
					$_SESSION['anum'][1] = $_SESSION['as2'][1];;
					$_SESSION['acount'] = 2;
				}
				if($_SESSION['as3'][1] == $_POST['active_pokemon']){
					$_SESSION['acurrent'] = $_SESSION['as3'];
					$_SESSION['anum'][2] = $_SESSION['as3'][1];;
					$_SESSION['acount'] = 3;
				}
				if($_SESSION['as4'][1] == $_POST['active_pokemon']){
					$_SESSION['acurrent'] = $_SESSION['as4'];
					$_SESSION['anum'][3] = $_SESSION['as4'][1];;
					$_SESSION['acount'] = 4;
				}
				if($_SESSION['as5'][1] == $_POST['active_pokemon']){
					$_SESSION['acurrent'] = $_SESSION['as5'];
					$_SESSION['anum'][4] = $_SESSION['as5'][1];;
					$_SESSION['acount'] = 5;
				}
				if($_SESSION['as6'][1] == $_POST['active_pokemon']){
					$_SESSION['acurrent'] = $_SESSION['as6'];
					$_SESSION['anum'][5] = $_SESSION['as6'][1];;
					$_SESSION['acount'] = 6;
				}
				$num = 2;
				$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['acurrent'][$num]}'");
				$myss = mysql_fetch_array($mys);
				$_SESSION['aca1'][0] = $myss['power'];
				$_SESSION['aca1'][1] = $myss['type'];
				$_SESSION['aca1'][2] = $myss['accuracy'];
				$_SESSION['aca1'][3] = $myss['category'];
				$num = 3;
				$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['acurrent'][$num]}'");
				$myss = mysql_fetch_array($mys);
				$_SESSION['aca2'][0] = $myss['power'];
				$_SESSION['aca2'][1] = $myss['type'];
				$_SESSION['aca1'][2] = $myss['accuracy'];
				$_SESSION['aca1'][3] = $myss['category'];
				$num = 4;
				$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['acurrent'][$num]}'");
				$myss = mysql_fetch_array($mys);
				$_SESSION['aca3'][0] = $myss['power'];
				$_SESSION['aca3'][1] = $myss['type'];
				$_SESSION['aca1'][2] = $myss['accuracy'];
				$_SESSION['aca1'][3] = $myss['category'];
				$num = 5;
				$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['acurrent'][$num]}'");
				$myss = mysql_fetch_array($mys);
				$_SESSION['aca4'][0] = $myss['power'];
				$_SESSION['aca4'][1] = $myss['type'];
				$_SESSION['aca1'][2] = $myss['accuracy'];
				$_SESSION['aca1'][3] = $myss['category'];
				switch($_SESSION['acount']){
					case 1:
					$_SESSION['atest1'] = $_SESSION['acurrent'][6];
					break;
					case 2:
					$_SESSION['atest2'] = $_SESSION['acurrent'][6];
					break;
					case 3:
					$_SESSION['atest3'] = $_SESSION['acurrent'][6];
					break;
					case 4:
					$_SESSION['atest4'] = $_SESSION['acurrent'][6];
					break;
					case 5:
					$_SESSION['atest5'] = $_SESSION['acurrent'][6];
					break;
					case 6:
					$_SESSION['atest6'] = $_SESSION['acurrent'][6];
					break;
				}
				if($_SESSION['acheck'] == 6){
					$_SESSION['aocurrent'] = $_SESSION['aop1'];
					unset($_SESSION['acheck']); 
					$num = 1;
					$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['aocurrent'][$num]}'");
					$myss = mysql_fetch_array($mys);
					$_SESSION['aoca1'][0] = $myss['power'];
					$_SESSION['aoca1'][1] = $myss['type'];
					$_SESSION['aoca1'][2] = $myss['accuracy'];
					$_SESSION['aoca1'][3] = $myss['category'];
					$num = 2;
					$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['aocurrent'][$num]}'");
					$myss = mysql_fetch_array($mys);
					$_SESSION['aoca2'][0] = $myss['power'];
					$_SESSION['aoca2'][1] = $myss['type'];
					$_SESSION['aoca1'][2] = $myss['accuracy'];
					$_SESSION['aoca1'][3] = $myss['category'];
					$num = 3;
					$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['aocurrent'][$num]}'");
					$myss = mysql_fetch_array($mys);
					$_SESSION['aoca3'][0] = $myss['power'];
					$_SESSION['aoca3'][1] = $myss['type'];
					$_SESSION['aoca1'][2] = $myss['accuracy'];
					$_SESSION['aoca1'][3] = $myss['category'];
					$num = 4;
					$mys = mysql_query("SELECT * FROM attacks WHERE attack = '{$_SESSION['aocurrent'][$num]}'");
					$myss = mysql_fetch_array($mys);
					$_SESSION['aoca4'][0] = $myss['power'];
					$_SESSION['aoca4'][1] = $myss['type'];
					$_SESSION['aoca1'][2] = $myss['accuracy'];
					$_SESSION['aoca1'][3] = $myss['category'];
				}
				else {
				}
			}
			if($_SESSION['afinished'] == 2){
				$ar = array("3","2"); $_SESSION['adonefor'] = $ar; unset($_SESSION['afinished']);
			}
			?>
			<?php if($changeout != 666){
				?>
                <input type="hidden" value="1" name="action"/>
				<?php
			}
			?>
            <input type="hidden" value="1" name="bat"/>
			<?php if(!$_POST['actionattack']){
				?>
                <input type="hidden" value="1" name="actionattack"/><?php
			}
			?>
            <h2><?php if($been == "t"){
				echo "Notice";
				?>
                </h2><p>You have either gone back in your browser, gone back to a previous battle in your history, or clicked the submit button multiple times. To continue to your point in your current battle, please press Continue.</p>
                <p><input type="submit" value="Continue!" /></p>
				<?
			}
			else {
				if($_POST['actionattack']){
					?>Attack results<?php
				}
				else {
					?>Choose an attack<?php
				}
				?>
                </h2><table cellpadding="0" cellspacing="0" style="width: 80%; text-align: center; margin: 0 auto;">
                <tr style="vertical-align: bottom;">
                <td style="width: 50%;">
                <h3>Your <? echo $_SESSION['acurrent'][0]; echo "</h3><img src=\"html/static/images/pokemon/{$_SESSION['acurrent'][0]}.gif\" width=\"96\" height=\"96\" />"; ?><br /><em>Level:</em> <?php echo $_SESSION['acurrent'][6]; ?></td>
                <td style="width: 50%;">
                <h3>Wild <? echo $_SESSION['aocurrent'][0]; ?></h3><img src="html/static/images/pokemon/<?php echo $_SESSION['aocurrent'][0]; ?>.gif" width="96" height="96" /><br /><em>Level:</em> <?php echo $_SESSION['aocurrent'][5]; ?></span></td>
                </tr>
                <tr style="vertical-align: middle;">
                <td style="width: 50%; padding: 10px 0;">
                <strong>HP: <img src="html/static/images/misc/hpbar.gif" height="10" width="<? echo $_SESSION['acurrent'][7]; ?>" border="0" /> <?php echo $_SESSION['acurrent'][8]; ?></strong></td>
                <td style="width: 50%; padding: 10px 0;">
                <strong>HP: <img src="html/static/images/misc/hpbar.gif" height="10" width="<? echo $_SESSION['aocurrent'][6]; ?>" border="0" /> <?php echo $_SESSION['aocurrent'][7]; ?></strong></td>
                </tr>
                <tr valign="top">
				<?php
			}
			if($_POST['actionattack'] && $been != "t"){
				?>
                <td style="width: 50%; padding: 0 15px;">
                <p><strong><?php if($varc == 2){ echo $_SESSION['aocurrent'][0] . " is scared and could not attack."; } else { echo $_SESSION['aocurrent'][0]; ?> attacked your <?php echo $_SESSION['acurrent'][0]; ?> with <?php echo $attack2; ?> and <?php if($www == "0"){ ?>had no effect.<?php } else { ?>did <?php echo $www; ?> HP damage.<?php } ?></p><?php } if($damages == 2 && $varc != 2){ ?><p>The attack was super effective!</p><?php } elseif($damages == 4 && $varc != 2){ ?><p>The attack was ultra effective!</p><?php } elseif($damages2 == 0.25 && $varc != 2){ ?><p>The attack was extremely uneffective.</p><?php } elseif($damages == 0.5 && $varc != 2){ ?><p>The attack was not very effective.</p><?php } if($newvar && !strstr($newvar['0'],'all')){ ?><p><?php echo $newvar[1] . "</p>";  } if($changeout == 666){ echo "<p>Your "; echo $_SESSION['acurrent'][0]; ?> has fainted.</p><?php } ?></strong></td>
                <td style="width: 50%; padding: 0 15px;">
                <p><strong><?php if($newvar){ echo "You used a(n) " . $newvar[0] . " and could not attack."; if($newvar[2] == "t"){ $ar = array("3","2","t"); $_SESSION['adonefor'] = $ar; unset($_SESSION['afinished']); echo "<p>The wild pok&eacute;mon has been caught.</p>"; } } else { if($varo == 2){ echo "Your " . $_SESSION['acurrent'][0] . " is scared and could not attack."; } else { ?>Your <?php echo $_SESSION['acurrent'][0]; ?> attacked <?php echo $_SESSION['aocurrent'][0]; ?> with <?php echo $attack; ?> and <? if($hhh == "0"){ ?>had no effect.<? } else { ?>did <?php echo $hhh; ?> HP damage.<?php } ?></p><?php } if($damages2 == 2 && $varo != 2){ ?><p>The attack was super effective!</p><?php } elseif($damages2 == 4 && $varo != 2){ ?><p>The attack was ultra effective!</p><?php } elseif($damages2 == 0.25 && $varo != 2){ ?><p>The attack was extremely uneffective.</p><?php } elseif($damages2 == 0.5 && $varo != 2){ ?><p>The attack was not very effective.</p><?php } if($down == 666){ ?><p><?php echo $_SESSION['aocurrent'][0]; ?> has fainted.</p><?php }} ?></strong></td>
                </tr>
                </table>
                <br/>
                <input type="submit" value="Continue!" />
				<?php
			}
			elseif($been != "t"){
				?>
                <td style="width: 50%; padding: 0 10px;">
                <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 0 auto; text-align: left;"><tr><td><p><strong>Select an attack:</strong></p><p><input type="radio" name="attack" id="attack1" value="1" checked="checked" />1. <?php echo $_SESSION['acurrent'][2]; ?><br /><input type="radio" name="attack" id="attack2" value="2" />2. <?php echo $_SESSION['acurrent'][3]; ?><br /><input type="radio" name="attack" id="attack3" value="3" />3. <?php echo $_SESSION['acurrent'][4]; ?><br /><input type="radio" name="attack" id="attack4" value="4" />4. <?php echo $_SESSION['acurrent'][5]; ?></p></td></tr></table></td>
                <input type="hidden" name="1" value="<? echo $_SESSION['acurrent'][2]; ?>">
                <input type="hidden" name="2" value="<? echo $_SESSION['acurrent'][3]; ?>">
                <input type="hidden" name="3" value="<? echo $_SESSION['acurrent'][4]; ?>">
                <input type="hidden" name="4" value="<? echo $_SESSION['acurrent'][5]; ?>">
                <td style="width: 50%; padding: 0 10px;">
                <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 0 auto; text-align: left;"><tr><td><p><strong>Attacks:</strong></p><p>1. <?php echo $_SESSION['aocurrent'][1]; ?><br />2. <?php echo $_SESSION['aocurrent'][2]; ?><br />3. <?php echo $_SESSION['aocurrent'][3]; ?><br />4. <?php echo $_SESSION['aocurrent'][4]; ?></p></td></tr></table></td>
                <input type="hidden" name="o1" value="<? echo $_SESSION['aocurrent'][1]; ?>">
                <input type="hidden" name="o2" value="<? echo $_SESSION['aocurrent'][2]; ?>">
                <input type="hidden" name="o3" value="<? echo $_SESSION['aocurrent'][3]; ?>">
                <input type="hidden" name="o4" value="<? echo $_SESSION['aocurrent'][4]; ?>">
                </tr>
                </table>
                <input type="hidden" name="action" value="attack" /><br /><input type="submit" value="Attack!" /></form>
                <div class="hr"></div><h2 style="margin-top: 30px;">Or Use an Item</h2>
                <table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                <tr style="vertical-align: text-top;"><td>
                <form action="wildbattle.php" method="post" id="itemForm" name="itemForm"  onsubmit="get('/wildbattle.php', '', this); disableSubmitButton(this); return false;">
                <input type="hidden" name="o1" value="<? echo $_SESSION['aocurrent'][1]; ?>">
                <input type="hidden" name="o2" value="<? echo $_SESSION['aocurrent'][2]; ?>">
                <input type="hidden" name="o3" value="<? echo $_SESSION['aocurrent'][3]; ?>">
                <input type="hidden" name="o4" value="<? echo $_SESSION['aocurrent'][4]; ?>">
                <table cellpadding="0" cellspacing="0" style="width: 260px; margin: 0 20px;">
                <tr style="text-align: center;"><td>
                <strong>Item:</strong></td>
                <td width="80"><strong>Quantity:</strong></td></tr>
                <tr><td style="text-align: left;">
				
				<?php
                if($_SESSION['aitems'][0] == 0){
					$v1 = "t";
				}
				if($_SESSION['aitems'][1] == 0){
					$v2 = "t";
				}
				if($_SESSION['aitems'][2] == 0){
					$v3 = "t";
				}
				if($_SESSION['aitems'][3] == 0){
					$v4 = "t";
				}
				if($_SESSION['aitems'][4] == 0){
					$v5 = "t";
				}
				if($_SESSION['aitems'][5] == 0){
					$v6 = "t";
				}
				if($_SESSION['aitems'][6] == 0){
					$v7 = "t";
				}
				if($_SESSION['aitems'][7] == 0){
					$v8 = "t";
				}
				if($_SESSION['aitems'][8] == 0){
					$v9 = "t";
				}
				if($_SESSION['aitems'][9] == 0){
					$v10 = "t";
				}
				if($_SESSION['aitems'][10] == 0){
					$v11 = "t";
				}
				if($_SESSION['aitems'][11] == 0){
					$v12 = "t";
				}
				if($_SESSION['aitems'][12] == 0){
					$v13 = "t"; } if(!$_POST['actionattack']){
						?><input type="hidden" value="1" name="actionattack"/><?php
					}
					?>
					<?php if($changeout != 666){
						?><input type="hidden" value="1" name="actionattack"/><?php
					}
					?>
					<?php if($changeout != 666){
						?><input type="hidden" value="1" name="action"/><?php
					}
					?>
                    <input type="hidden" value="1" name="bat"/>
                        <input type="radio" name="item" <?php if($v1 != "t"){ echo "checked=\"checked\""; } if($v1 == "t"){ echo "disabled"; } ?> id="item1" value="Potion" checked="checked" /> <label for="item1">
                        
                        <img src="html/static/images/items/Potion.png" height="24" width="24" align="absmiddle"> <?php if($v1 == "t"){ echo "<s>"; } ?>Potion<?php if($v1 == "t"){ echo "</s>"; } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][0]; ?></td></tr>
                        <tr><td style="text-align: left;">

                        <input type="radio" <?php if($v1 == "t" && $v2 != "t"){ echo "checked=\"checked\""; } if($v2 == "t"){ echo "disabled"; } ?> name="item" id="item2" value="Super Potion" /> <label for="item2">
                        <img src="html/static/images/items/Super Potion.png" height="24" width="24" align="absmiddle"> <?php if($v2 == "t"){ ?><s><?php } ?>Super Potion<?php if($v2 == "t"){ ?></s><?php } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][1]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" <?php if($v1 == "t" && $v2 == "t" && $v3 != "t"){ echo "checked=\"checked\""; } if($v3 == "t"){ echo "disabled"; } ?> name="item" id="item3" value="Hyper Potion" /> <label for="item3">
                        <img src="html/static/images/items/Hyper Potion.png" height="24" width="24" align="absmiddle">
						<?php if($v3 == "t"){ echo "<s>"; } ?>Hyper Potion<?php if($v3 == "t"){ echo "</s>"; } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][2]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" name="item" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 != "t"){ echo "checked=\"checked\""; } if($v4 == "t"){ echo "disabled"; } ?> id="item4" value="Full Heal" /> <label for="item4">
                        <img src="html/static/images/items/Full Heal.png" height="24" width="24" align="absmiddle"> <?php if($v4 == "t"){ echo "<s>"; } ?>Full Heal<?php if($v4 == "t"){ echo "</s>"; } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][3]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" name="item" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 != "t"){ echo "checked=\"checked\""; } if($v5 == "t"){ echo "disabled"; } ?> id="item5" value="Awakening" /> <label for="item5">
                        <img src="html/static/images/items/Awakening.png" height="24" width="24" align="absmiddle"> <?php if($v5 == "t"){ echo "<s>"; } ?>Awakening<?php if($v5 == "t"){ echo "</s>"; } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][4]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" name="item" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 != "t"){ echo "checked=\"checked\""; } if($v6 == "t"){ echo "disabled"; } ?> id="item6" value="Parlyz Heal" /> <label for="item6">
                        <img src="html/static/images/items/Parlyz Heal.png" height="24" width="24" align="absmiddle"> <?php if($v6 == "t"){ echo "<s>"; } ?>Parlyz Heal<?php if($v6 == "t"){ echo "</s>"; } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][5]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" name="item" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 == "t" && $v7 != "t"){ echo "checked=\"checked\""; } if($v7 == "t"){ echo "disabled"; } ?> id="item7" value="Antidote" /> 
                        <img src="html/static/images/items/Antidote.png" height="24" width="24" align="absmiddle"> <?php if($v7 == "t"){ echo "<s>"; } ?>Antidote<?php if($v7 == "t"){ echo "</s>"; } ?></td>
                        <td align="center"><?php echo $_SESSION['aitems'][6]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" name="item" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 == "t" && $v7 == "t" && $v8 != "t"){ echo "checked=\"checked\""; } if($v8 == "t"){ echo "disabled"; } ?> id="item8" value="Burn Heal" /> 
                        <img src="html/static/images/items/Burn Heal.png" height="24" width="24" align="absmiddle">
						<?php if($v8 == "t"){ echo "<s>"; } ?>Burn Heal<?php if($v8 == "t"){ echo "</s>"; } ?></td>
                        <td align="center"><?php echo $_SESSION['aitems'][7]; ?></td></tr><tr><td style="text-align: left;">

					<input type="radio" name="item" id="item9" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 == "t" && $v7 == "t" && $v8 == "t" && $v9 != "t"){ echo "checked=\"checked\""; } if($v9 == "t"){ echo "disabled"; } ?> value="Ice Heal" /> <label for="item9">
                        <img src="html/static/images/items/Ice Heal.png" height="24" width="24" align="absmiddle"> <?php if($v9 == "t"){ echo "<s>"; } ?>Ice Heal<?php if($v9 == "t"){ echo "</s>"; } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][8]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 == "t" && $v7 == "t" && $v8 == "t" && $v9 == "t" && $v10 != "t"){ echo "checked=\"checked\""; } if($v10 == "t"){ echo "disabled"; } ?> name="item" id="item2" value="Pokeball" /> <label for="item10">
                        <img src="html/static/images/items/Poke Ball.png" height="24" width="24" align="absmiddle"> <?php if($v10 == "t"){ ?><s><?php } ?>Pok&eacute;ball<?php if($v10 == "t"){ ?></s><?php } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][9]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 == "t" && $v7 == "t" && $v8 == "t" && $v9 == "t" && $v10 == "t" && $v11 != "t"){ echo "checked=\"checked\""; } if($v11 == "t"){ echo "disabled"; } ?> name="item" id="item2" value="Great Ball" /> <label for="item11">
                        <img src="html/static/images/items/Great Ball.png" height="24" width="24" align="absmiddle"> <?php if($v11 == "t"){ ?><s><?php } ?>Great Ball<?php if($v11 == "t"){ ?></s><?php } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][10]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 == "t" && $v7 == "t" && $v8 == "t" && $v9 == "t" && $v10 == "t" && $v11 == "t" && $v12 != "t"){ echo "checked=\"checked\""; } if($v12 == "t"){ echo "disabled"; } ?> name="item" id="item2" value="Ultra Ball" /> <label for="item12">
                        <img src="html/static/images/items/Ultra Ball.png" height="24" width="24" align="absmiddle"> <?php if($v12 == "t"){ ?><s><?php } ?>Ultra Ball<?php if($v12 == "t"){ ?></s><?php } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][11]; ?></td></tr><tr><td style="text-align: left;">

                        <input type="radio" <?php if($v1 == "t" && $v2 == "t" && $v3 == "t" && $v4 == "t" && $v5 == "t" && $v6 == "t" && $v7 == "t" && $v8 == "t" && $v9 == "t" && $v10 == "t" && $v11 == "t" && $v12 == "t" && $v13 != "t"){ echo "checked=\"checked\""; } if($v13 == "t"){ echo "disabled"; } ?> name="item" id="item2" value="Master Ball" /> <label for="item13">
                        <img src="html/static/images/items/Master Ball.png" height="24" width="24" align="absmiddle"> <?php if($v13 == "t"){ ?><s><?php } ?>Master Ball<?php if($v13 == "t"){ ?></s><?php } ?></label></td>
                        <td align="center"><?php echo $_SESSION['aitems'][12]; ?></td></tr><tr><td style="text-align: center;">

                    <input type="hidden" name="action" value="use_item">
                    <input type="hidden" name="active_pokemon" value="1">
                    <input name="items" type="submit" value="Use Item" />
                    <br /></td></tr></table></form></td></td></tr></table>
					<?php
			}
		}
		elseif($var != "y"){
			mysql_query("UPDATE online SET activity = 'Battling a wild {$_SESSION['aop1'][0]}' WHERE id = '{$_SESSION['myid']}'");
			?>
            <input type="hidden" value="1" name="bat"/>
            <input type="hidden" value="1" name="action"/>
            <h2>Your Pok&eacute;mon Team:</h2>
			<?php 
			if($_SESSION['as1'][8] == 0){
				$sone = 2;
			}
			if($_SESSION['as2'][8] == 0){
				$stwo = 2;
			}
			if($_SESSION['as3'][8] == 0){
				$sthree = 2;
			}
			if($_SESSION['as4'][8] == 0){
				$sfour = 2;
			}
			if($_SESSION['as5'][8] == 0){
				$sfive = 2;
			}
			if($_SESSION['as6'][8] == 0){
				$ssix = 2;
			}
			if($_SESSION['aop1'][8] == 0){
				$oone = 2;
			}
			?>
            
            <h3>Select your next Pok&eacute;mon to battle:</h3>
            <table cellspacing="0" cellpadding="0" class="pokemonList">
            <tr>
            <td nowrap="nowrap" id="your_pokemon">
            <table cellpadding="3" cellspacing="0">
            <tr>
            <td>
            <input type="radio" name="active_pokemon" value="<?php echo $_SESSION['as1'][1]; ?>"<?php if($sone != 2){ ?> checked="checked"<?php } else { echo " disabled"; } ?> />
            <img src="html/static/images/pokemon/<?php echo $_SESSION['as1'][0]; ?>.gif" width="96" height="96" />
            </td>
            <td>
            <p>
            <strong>
            <a href="/pokedex.php?pid=<?php echo $_SESSION['as1'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as1'][1]; ?>', 1); return false;">
			<?php
            if($sone == 2){ echo "<s>"; } echo $_SESSION['as1'][0]; ?>
            </a>
            </strong>
            <br /><em>Level:</em> <?php echo $_SESSION['as1'][6]; ?>
            <br /><em>HP:</em> <?php echo $_SESSION['as1'][8]; if($sone == 2){ echo "</s>"; } ?>
            </p>
            </td>
            </tr>
            </table>
			<?php
            if(is_numeric($_SESSION['as2'][1])){
				?>
                <table cellpadding="3" cellspacing="0">
                <tr>
                <td>
                <input type="radio" name="active_pokemon" value="<?php echo $_SESSION['as2'][1]; ?>"<?php if($sone == 2 && $stwo != 2){ ?> checked="checked"<?php } elseif($stwo == 2){ echo " disabled"; } ?> />
                <img src="html/static/images/pokemon/<?php echo $_SESSION['as2'][0]; ?>.gif" width="96" height="96" />
                </td>
                <td>
                <p>
                <strong>
                <a href="/pokedex.php?pid=<?php echo $_SESSION['as2'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as2'][1]; ?>', 1); return false;">
				<?php if($stwo == 2){ echo "<s>"; } echo $_SESSION['as2'][0]; ?>
                </a>
                </strong>
                <br />
                <em>Level:</em> <?php echo $_SESSION['as2'][6]; 
				?>
                <br /><em>HP:</em> <?php echo $_SESSION['as2'][8]; if($stwo == 2){ echo "</s>"; } ?>
                </p>
                </td>
                </tr>
                </table>
				<?php
			}
			if(is_numeric($_SESSION['as3'][1])){
				?>
                <table cellpadding="3" cellspacing="0">
                <tr>
                <td>
                <input type="radio" name="active_pokemon" value="<?php echo $_SESSION['as3'][1]; ?>"<?php if($sone == 2 && $stwo == 2 && $sthree != 2){ ?> checked="checked"<?php } elseif($sthree == 2){ echo " disabled"; } ?> />
                <img src="html/static/images/pokemon/<?php echo $_SESSION['as3'][0]; ?>.gif" width="96" height="96" />
                </td>
                <td>
                <p>
                <strong>
                <a href="/pokedex.php?pid=<?php echo $_SESSION['as3'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as3'][1]; ?>', 1); return false;">
				<?php if($sthree == 2){ echo "<s>"; } echo $_SESSION['as3'][0]; ?>
                </a>
                </strong>
                <br />
                <em>Level:</em> <?php echo $_SESSION['as3'][6];
				?>
                <br /><em>HP:</em> <?php echo $_SESSION['as3'][8]; if($sthree == 2){ echo "</s>"; } ?>
                </p>
                </td>
                </tr>
                </table>
				<?php
			}
			if(is_numeric($_SESSION['as4'][1])){
				?>
                <table cellpadding="3" cellspacing="0">
                <tr>
                <td>
                <input type="radio" name="active_pokemon" value="<?php echo $_SESSION['as4'][1]; ?>"<?php if($sone == 2 && $stwo == 2 && $sthree == 2 && $sfour != 2){ ?> checked="checked"<?php } elseif($sfour == 2){ echo " disabled"; } ?> />
                <img src="html/static/images/pokemon/<?php echo $_SESSION['as4'][0]; ?>.gif" width="96" height="96" />
                </td>
                <td>
                <p>
                <strong>
                <a href="/pokedex.php?pid=<?php echo $_SESSION['as4'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as4'][1]; ?>', 1); return false;">
				<?php if($sfour == 2){ echo "<s>"; } echo $_SESSION['as4'][0]; ?>
                </a>
                </strong>
                <br />
                <em>Level:</em> <?php echo $_SESSION['as4'][6]; 
				?>
                <br /><em>HP:</em> <?php echo $_SESSION['as4'][8]; if($sfour == 2){ echo "</s>"; } ?>
                </p>
                </td>
                </tr>
                </table>
				<?php
			}
			if(is_numeric($_SESSION['as5'][1])){
				?>
                <table cellpadding="3" cellspacing="0">
                <tr>
                <td>
                <input type="radio" name="active_pokemon" value="<?php echo $_SESSION['as5'][1]; ?>"<?php if($sone == 2 && $stwo == 2 && $sthree == 2 && $sfour == 2 && $sfive != 2){ ?> checked="checked"<?php } elseif($sfive == 2){ echo " disabled"; } ?> />
                <img src="html/static/images/pokemon/<?php echo $_SESSION['as5'][0]; ?>.gif" width="96" height="96" />
                </td>
                <td>
                <p>
                <strong>
                <a href="/pokedex.php?pid=<?php echo $_SESSION['as5'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as5'][1]; ?>', 1); return false;">
				<?php if($sfive == 2){ echo "<s>"; } echo $_SESSION['as5'][0]; ?>
                </a>
                </strong>
                <br />
                <em>Level:</em> <?php echo $_SESSION['as5'][6]; 
				?>
                <br /><em>HP:</em> <?php echo $_SESSION['as5'][8]; if($sfive == 2){ echo "</s>"; } ?>
                </p>
                </td>
                </tr>
                </table>
				<?php
			}
			if(is_numeric($_SESSION['as6'][1])){
				?>
                <table cellpadding="3" cellspacing="0">
                <tr>
                <td>
                <input type="radio" name="active_pokemon" value="<?php echo $_SESSION['as6'][1]; ?>"<?php if($ssix != 2 && $sfive == 2 && $sfour == 2 && $sthree == 2 && $stwo == 2 && $sone == 2){ ?> checked="checked"<?php } elseif($ssix == 2){ echo " disabled"; } ?> />
                <img src="html/static/images/pokemon/<?php echo $_SESSION['as6'][0]; ?>.gif" width="96" height="96" />
                </td>
                <td>
                <p>
                <strong>
                <a href="/pokedex.php?pid=<?php echo $_SESSION['as6'][1]; ?>" onclick="pokedexTab('pid=<?php echo $_SESSION['as6'][1]; ?>', 1); return false;">
				<?php if($ssix == 2){ echo "<s>"; } echo $_SESSION['as6'][0]; ?>
                </a>
                </strong>
                <br /><em>Level:</em> <?php echo $_SESSION['as6'][6]; 
				?>
                <br /><em>HP:</em> <?php echo $_SESSION['as6'][8]; if($ssix == 2){ echo "</s>"; } ?>
                </p>
                </td>
                </tr>
                </table>
				<?php
			}
			?>
            </td>
            </tr>
            </table>
            <h2>Wild <?php echo $_SESSION['aop1'][0]; ?>:</h2>
            <table cellspacing="0" cellpadding="0" class="pokemonList">
            <tr>
            <td nowrap="nowrap" id="opponent_pokemon">
            <table cellpadding="3" cellspacing="0">
            <tr>
            <td>
            <img src="html/static/images/pokemon/<?php echo $_SESSION['aop1'][0]; ?>.gif" width="96" height="96" />
            </td>
            <td>
            <p>
            <strong>
            <a href="/pokedex.php?dex=<?php echo $_SESSION['aop1'][0]; ?>" onclick="pokedexTab('dex=<?php echo $_SESSION['aop1'][0]; ?>', 1); return false;">
			<?php if($oone == 2){ echo "<s>"; } echo $_SESSION['aop1'][0]; ?>
            </a>
            </strong>
            <br /><em>Level:</em> <?php echo $_SESSION['aop1'][5]; ?>
            <br /><em>HP:</em> <?php echo $_SESSION['aop1'][7]; if($oone == 2){ echo "</s>"; } ?>
            </p>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            <input type="hidden" name="action" value="select_attack" />
            <p>
            <input type="submit" value="Continue" />
            </p>
            </form>
			<?php
		}
	}
}
if(!$_REQUEST['ajax']){
	?>
    </div>
	<?php include('disclaimer.php'); ?>
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
include('pv_disconnect_from_db.php'); ?>