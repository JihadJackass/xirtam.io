<?php
include('kick.php');
if(!$_SESSION['myid'] || $_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:/login.php?goawayxP=1");
	exit();
}
if($_SESSION['access'] == 9){
	include('pv_connect_to_db.php');
	
	if(isset($_POST['buy2'])){ // Request to buy a lottery ticket
		$cost = 1 * 50000;
		$r = mysql_query("SELECT tickets FROM lotto WHERE uid = '{$_SESSION['myid']}'");
		$rr = mysql_num_rows($r);
		$s = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
		$ss = mysql_fetch_array($s);
		$rrr = 1 + $rr;
		if($rr == '1' || $ss['money'] < $cost){ // If the user doesn't have enough money or has already bought a ticket, return error
			$error = 1;
		}
		
		else { // Give the user a lottery ticket
			$lo = mysql_query("UPDATE members SET money = money - $cost WHERE id = '{$_SESSION['myid']}'");
			$x = 1;
			mysql_query("INSERT INTO lotto (uid, tickets) VALUES ('{$_SESSION['myid']}', '$x')");
			$suc = 1;
		}
	}
	if(isset($_POST['buy'])){ // --------------------- Pokemart Items ------------------------ //
		$spcost = 1000; // Super Potion
		$pcost = 500; // Potion
		$hpcost = 2000; // Hyper Potion
		$fhcost = 1000; // Full Heal
		$awcost = 500; // Awakening
		$ancost = 500; // Antidote
		$bhcost = 500; // Burn Heal
		$ihcost = 500; // Ice Heal
		$phcost = 500; // Paralyz Heal
		$dascost = 5000; // Dawn Stone
		$duscost = 5000; // Dusk Stone
		$fscost = 3000; // Fire Stone
		$wscost = 3000; // Water Stone
		$tscost = 3000; // Thunder Stone
		$lscost = 3000; // Leaf Stone
		$mscost = 4000; // Moon Stone
		$suscost = 5000; // Sun Stone
		$shscost = 5000; // Shiny Stone
		$oscost = 5000; // Oval Stone
		$pbcost = 250; // Pokeball
		$gbcost = 500; // Great Ball
		$ubcost = 1500; // Ultra Ball
		$mbcost = 100000; // Master Ball
		$dsscost = 5000; // Deepseascale
		$dstcost = 5000; // Deepseatooth
		$drscost = 5000; // Dragon Scale
		$dudcost = 5000; // Dubious Disc
		$elecost = 5000; // Electirizer
		$magcost = 5000; // Magmarizer
		$kincost = 5000; // Kings Rock
		$metcost = 5000; // Metal Coat
		$pricost = 5000; // Prism Scale
		$procost = 5000; // Protector
		$razccost = 5000; // Razor Claw
		$razfcost = 5000; // Razor Fang
		$reacost = 5000; // Reaper Cloth
		$upgcost = 5000; // Up Grade
		$latiacost = 15000; // Latiasite
		$latiocost = 15000; // Latiosite
		$abocost = 15000; // Abomasite
		$abscost = 15000; // Absolite
		$aercost = 15000; // Aerodactylite
		$aggcost = 15000; // Aggronite
		$alacost = 15000; // Alakazite
		$ampcost = 15000; // Ampharosite
		$bancost = 15000; // Banettite
		$blacost = 15000; // Blastoisinite
		$blazcost = 15000; // Blazikenite
		$chxcost = 15000; // Charizardite X
		$chycost = 15000; // Charizardite Y
		$garccost = 15000; // Garchompite
		$gardcost = 15000; // Gardevoirite
		$gencost = 15000; // Gengarite
		$gyacost = 15000; // Gyaradosite
		$hercost = 15000; // Heracronite
		$houcost = 15000; // Houndoominite
		$kancost = 15000; // Kangaskhanite
		$luccost = 15000; // Lucarionite
		$mancost = 15000; // Manectite
		$mawcost = 15000; // Mawilite
		$medcost = 15000; // Medichamite
		$mewxcost = 15000; // Mewtwonite X
		$mewycost = 15000; // Mewtwonite Y
		$pincost = 15000; // Pinsirite
		$scicost = 15000; // Scizorite
		$tyrcost = 15000; // Tyranitarite
		$vencost = 15000; // Venusaurite
		$saccost = 5000; // Sachet
		$whicost = 5000; // Whipped Dream
		$icercost = 5000; // Ice Rock
		$mosrcost = 5000; // Moss Rock
		$altcost = 15000; // Altarianite
		$audcost = 15000; // Audinite
		$beecost = 15000; // Beedrillite
		$camcost = 15000; // Cameruptite
		$diacost = 15000; // Diancite
		$galcost = 15000; // Galladite
		$glacost = 15000; // Glalitite
		$lopcost = 15000; // Lopunnite
		$metacost = 15000; // Metagrossite
		$pidcost = 15000; // Pidgeotite
		$sabcost = 15000; // Sablenite
		$salcost = 15000; // Salamencite
		$scecost = 15000; // Sceptilite
		$shacost = 15000; // Sharpedonite
		$slocost = 15000; // Slowbronite
		$stecost = 15000; // Steelixite
		$swacost = 15000; // Swampertite
		
		
		$sp = $_POST['superpotion'] * $spcost; // Super Potion
		$p = $_POST['potion'] * $pcost; // Potion
		$hp = $_POST['hyperpotion'] * $hpcost; // Hyper Potion
		$fh = $_POST['fullheal'] * $fhcost; // Full Heal
		$aw = $_POST['awakening'] * $awcost; // Awakening
		$an = $_POST['antidote'] * $ancost; // Antidote
		$bh = $_POST['burnheal'] * $bhcost; // Burn Heal
		$ih = $_POST['iceheal'] * $ihcost; // Ice Heal
		$ph = $_POST['parlyzheal'] * $phcost; // Paralyz Heal
		$das = $_POST['dawnstone'] * $dascost; // Dawn Stone
		$dus = $_POST['duskstone'] * $duscost; // Dusk Stone
		$fs = $_POST['firestone'] * $fscost; // Fire Stone
		$ws = $_POST['waterstone'] * $wscost; // Water Stone
		$ts = $_POST['thunderstone'] * $tscost; // Thunder Stone
		$ls = $_POST['leafstone'] * $lscost; // Leaf Stone
		$ms = $_POST['moonstone'] * $mscost; // Moon Stone
		$sus = $_POST['sunstone'] * $suscost; // Sun Stone
		$shs = $_POST['shinystone'] * $shscost; // Shiny Stone
		$os = $_POST['ovalstone'] * $oscost; // Oval Stone
		$pb = $_POST['pokeball'] * $pbcost; // Pokeball
		$gb = $_POST['greatball'] * $gbcost; // Great Ball
		$ub = $_POST['ultraball'] * $ubcost; // Ultra Ball
		$mb = $_POST['masterball'] * $mbcost; // Master Ball
		$dss = $_POST['deepseascale'] * $dsscost; // Deepseascale
		$dst = $_POST['deepseatooth'] * $dstcost; // Deepseatooth
		$drs = $_POST['dragonscale'] * $drscost; // Dragon Scale
		$dud = $_POST['dubiousdisc'] * $dudcost; // Dubious Disc
		$ele = $_POST['electirizer'] * $elecost; // Electirizer
		$mag = $_POST['magmarizer'] * $magcost; // Magmarizer
		$kin = $_POST['kingsrock'] * $kincost; // Kings Rock
		$met = $_POST['metalcoat'] * $metcost; // Metal Coat
		$pri = $_POST['prismscale'] * $pricost; // Prism Scale
		$pro = $_POST['protector'] * $procost; // Protector
		$razc = $_POST['razorclaw'] * $razccost; // Razor Claw
		$razf = $_POST['razorfang'] * $razfcost; // Razor Fang
		$rea = $_POST['reapercloth'] * $reacost; // Reaper Cloth
		$upg = $_POST['upgrade'] * $upgcost; // Up Grade
		$latia = $_POST['latiasite'] * $latiacost; // Latiasite
		$latio = $_POST['latiosite'] * $latiocost; // Latiosite
		$abo = $_POST['abomasite'] * $abocost; // Abomasite
		$abs = $_POST['absolite'] * $abscost; // Absolite
		$aer = $_POST['aerodactylite'] * $aercost; // Aerodactylite
		$agg = $_POST['aggronite'] * $aggcost; // Aggronite
		$ala = $_POST['alakazite'] * $alacost; // Alakazite
		$amp = $_POST['ampharosite'] * $ampcost; // Ampharosite
		$ban = $_POST['banettite'] * $bancost; // Banettite
		$bla = $_POST['blastoisinite'] * $blacost; // Blastoisinite
		$blaz = $_POST['blazikenite'] * $blazcost; // Blazikenite
		$chx = $_POST['charizarditex'] * $chxcost; // Charizardite X
		$chy = $_POST['charizarditey'] * $chycost; // Charizardite Y
		$garc = $_POST['garchompite'] * $garccost; // Garchompite
		$gard = $_POST['gardevoirite'] * $gardcost; // Gardevoirite
		$gen = $_POST['gengarite'] * $gencost; // Gengarite
		$gya = $_POST['gyaradosite'] * $gyacost; // Gyaradosite
		$her = $_POST['heracronite'] * $hercost; // Heracronite
		$hou = $_POST['houndoomite'] * $houcost; // Houndoominite
		$kan = $_POST['kangaskhanite'] * $kancost; // Kangaskhanite
		$luc = $_POST['lucarionite'] * $luccost; // Lucarionite
		$man = $_POST['manectite'] * $mancost; // Manectite
		$maw = $_POST['mawilite'] * $mawcost; // Mawilite
		$med = $_POST['medichamite'] * $medcost; // Medichamite
		$mewx = $_POST['mewtwonitex'] * $mewxcost; // Mewtwonite X
		$mewy = $_POST['mewtwonitey'] * $mewycost; // Mewtwonite Y
		$pin = $_POST['pinsirite'] * $pincost; // Pinsirite
		$sci = $_POST['scizorite'] * $scicost; // Scizorite
		$tyr = $_POST['tyranitarite'] * $tyrcost; // Tyranitarite
		$ven = $_POST['venusaurite'] * $vencost; // Venusaurite
		$sac = $_POST['sachet'] * $saccost; // Sachet
		$whi = $_POST['whippeddream'] * $whicost; // Whipped Dream
		$icer = $_POST['icerock'] * $icercost; // Ice Rock
		$mosr = $_POST['mossrock'] * $mosrcost; // Moss Rock
		$alt = $_POST['altarianite'] * $altcost; // Altarianite
		$aud = $_POST['audinite'] * $audcost; // Audinite
		$bee = $_POST['beedrillite'] * $beecost; // Beedrillite
		$cam = $_POST['cameruptite'] * $camcost; // Cameruptite
		$dia = $_POST['diancite'] * $diacost; // Diancite
		$gal = $_POST['galladite'] * $galcost; // Galladite
		$gla = $_POST['glalitite'] * $glacost; // Glalitite
		$lop = $_POST['lopunnite'] * $lopcost; // Lopunnite
		$meta = $_POST['mesagrossite'] * $metacost; // Metagrossite
		$pid = $_POST['pidgeotite'] * $pidcost; // Pidgeotite
		$sab = $_POST['sablenite'] * $sabcost; // Sablenite
		$sal = $_POST['salamencite'] * $salcost; // Salamencite
		$sce = $_POST['sceptilite'] * $scecost; // Sceptilite
		$sha = $_POST['sharpedonite'] * $shacost; // Sharpedonite
		$slo = $_POST['slowbronite'] * $slocost; // Slowbronite
		$ste = $_POST['steelixite'] * $stecost; // Steelixite
		$swa = $_POST['swampertite'] * $swacost; // Swampertite
			
		// Add all requested items together for a total price
		
		$total = $alt + $aud + $bee + $cam + $dia + $gal + $gla + $lop + $meta + $pid + $sab + $sal + $sce + $sha + $slo + $ste + $swa + $sp + $p + $hp + $fh + $aw + $an + $bh + $ih + $ph + $das + $dus + $fs + $ws + $ts + $ls + $ms + $sus + $shs + $os + $pb + $gb + $ub + $mb + $dss + $dst + $drs + $dud + $ele + $mag + $kin + $met + $pri + $pro + $razc + $razf + $rea + $upg + $latia + $latio + $abo + $abs + $aer + $agg + $ala + $amp + $ban + $bla + $blaz + $chx + $chy + $garc + $gard + $gen + $gya + $her + $hou + $kan + $luc + $man + $maw + $med + $mewx + $mewy + $pin + $sci + + $tyr + $ven + $sac + $whi + $icer + $mosr;
		
		$moule = mysql_query("SELECT money FROM members WHERE id = '{$_SESSION['myid']}'"); // Make sure the user has enough money
		$moulat = mysql_fetch_array($moule);
		$moneyvar2 = $moulat['money'];
		if($moneyvar2 >= $total && $total >= '0'){
			$trans = "yes";
			$netmoney = $moneyvar2 - $total;
			mysql_query("UPDATE members SET money = '$netmoney' WHERE id = '{$_SESSION['myid']}'"); // Update the users money
			
			// Update the users items bought
			
			if($_POST['masterball'] > 0){
				mysql_query("UPDATE items SET Master_Ball = Master_Ball + {$_POST['masterball']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['ultraball'] > 0){
				mysql_query("UPDATE items SET Ultra_Ball = Ultra_Ball + {$_POST['ultraball']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['greatball'] > 0){
				mysql_query("UPDATE items SET Great_Ball = Great_Ball + {$_POST['greatball']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['pokeball'] > 0){
				mysql_query("UPDATE items SET Poke_ball = Poke_Ball + {$_POST['pokeball']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['ovalstone'] > 0){
				mysql_query("UPDATE items SET Oval_Stone = Oval_Stone + {$_POST['ovalstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['shinystone'] > 0){
				mysql_query("UPDATE items SET Shiny_Stone = Shiny_Stone + {$_POST['shinystone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['sunstone'] > 0){
				mysql_query("UPDATE items SET Sun_Stone = Sun_Stone + {$_POST['sunstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['leafstone'] > 0){
				mysql_query("UPDATE items SET Leaf_Stone = Leaf_Stone + {$_POST['leafstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['firestone'] > 0){
				mysql_query("UPDATE items SET Fire_Stone = Fire_Stone + {$_POST['firestone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['thunderstone'] > 0){
				mysql_query("UPDATE items SET Thunder_Stone = Thunder_Stone + {$_POST['thunderstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['moonstone'] > 0){
				mysql_query("UPDATE items SET Moon_Stone = Moon_Stone + {$_POST['moonstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['dawnstone'] > 0){
				mysql_query("UPDATE items SET Dawn_Stone = Dawn_Stone + {$_POST['dawnstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['duskstone'] > 0){
				mysql_query("UPDATE items SET Dusk_Stone = Dusk_Stone + {$_POST['duskstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['parlyzheal'] > 0){
				mysql_query("UPDATE items SET Parlyz_Heal = Parlyz_Heal + {$_POST['parlyzheal']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['iceheal'] > 0){
				mysql_query("UPDATE items SET Ice_Heal = Ice_Heal + {$_POST['iceheal']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['burnheal'] > 0){
				mysql_query("UPDATE items SET Burn_Heal = Burn_Heal + {$_POST['burnheal']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['awakening'] > 0){
				mysql_query("UPDATE items SET Awakening = Awakening + {$_POST['awakening']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['antidote'] > 0){
				mysql_query("UPDATE items SET Antidote = Antidote + {$_POST['antidote']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['fullheal'] > 0){
				mysql_query("UPDATE items SET Full_Heal = Full_Heal + {$_POST['fullheal']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['potion'] > 0){
				mysql_query("UPDATE items SET Potion = Potion + {$_POST['potion']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['superpotion'] > 0){
				mysql_query("UPDATE items SET Super_Potion = Super_Potion + {$_POST['superpotion']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['hyperpotion'] > 0){
				mysql_query("UPDATE items SET Hyper_Potion = Hyper_Potion + {$_POST['hyperpotion']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['waterstone'] > 0){
				mysql_query("UPDATE items SET Water_Stone = Water_Stone + {$_POST['waterstone']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['deepseascale'] > 0){
				mysql_query("UPDATE items SET Deepseascale = Deepseascale + {$_POST['deepseascale']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['deepseatooth'] > 0){
				mysql_query("UPDATE items SET Deepseatooth = Deepseatooth + {$_POST['deepseatooth']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['dragonscale'] > 0){
				mysql_query("UPDATE items SET Dragon_Scale = Dragon_Scale + {$_POST['dragonscale']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['dubiousdisc'] > 0){
				mysql_query("UPDATE items SET Dubious_Disc = Dubious_Disc + {$_POST['dubiousdisc']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['kingsrock'] > 0){
				mysql_query("UPDATE items SET Kings_Rock = Kings_Rock + {$_POST['kingsrock']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['magmarizer'] > 0){
				mysql_query("UPDATE items SET Magmarizer = Magmarizer + {$_POST['magmarizer']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['electirizer'] > 0){
				mysql_query("UPDATE items SET Electirizer = Electirizer + {$_POST['electirizer']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['metalcoat'] > 0){
				mysql_query("UPDATE items SET Metal_Coat = Metal_Coat + {$_POST['metalcoat']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['prismscale'] > 0){
				mysql_query("UPDATE items SET Prism_Scale = Prism_Scale + {$_POST['prismscale']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['protector'] > 0){
				mysql_query("UPDATE items SET Protector = Protector + {$_POST['protector']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['razorclaw'] > 0){
				mysql_query("UPDATE items SET Razor_Claw = Razor_Claw + {$_POST['razorclaw']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['razorfang'] > 0){
				mysql_query("UPDATE items SET Razor_Fang = Razor_Fang + {$_POST['razorfang']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['reapercloth'] > 0){
				mysql_query("UPDATE items SET Reaper_Cloth = Reaper_Cloth + {$_POST['reapercloth']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['upgrade'] > 0){
				mysql_query("UPDATE items SET Up_Grade = Up_Grade + {$_POST['upgrade']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['icerock'] > 0){
				mysql_query("UPDATE items SET Ice_Rock = Ice_Rock + {$_POST['icerock']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['mossrock'] > 0){
				mysql_query("UPDATE items SET Moss_Rock = Moss_Rock + {$_POST['mossrock']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['sachet'] > 0){
				mysql_query("UPDATE items SET Sachet = Sachet + {$_POST['sachet']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['whippeddream'] > 0){
				mysql_query("UPDATE items SET Whipped_Dream = Whipped_Dream + {$_POST['whippeddream']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['latiasite'] > 0){
				mysql_query("UPDATE items SET Latiasite = Latiasite + {$_POST['latiasite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['latiosite'] > 0){
				mysql_query("UPDATE items SET Latiosite = Latiosite + {$_POST['latiosite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['abomasite'] > 0){
				mysql_query("UPDATE items SET Abomasite = Abomasite + {$_POST['abomasite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['absolite'] > 0){
				mysql_query("UPDATE items SET Absolite = Absolite + {$_POST['absolite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['aerodactylite'] > 0){
				mysql_query("UPDATE items SET Aerodactylite = Aerodactylite + {$_POST['aerodactylite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['aggronite'] > 0){
				mysql_query("UPDATE items SET Aggronite = Aggronite + {$_POST['aggronite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['alakazite'] > 0){
				mysql_query("UPDATE items SET Alakazite = Alakazite + {$_POST['alakazite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['ampharosite'] > 0){
				mysql_query("UPDATE items SET Ampharosite = Ampharosite + {$_POST['ampharosite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['banettite'] > 0){
				mysql_query("UPDATE items SET Banettite = Banettite + {$_POST['banettite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['blastoisinite'] > 0){
				mysql_query("UPDATE items SET Blastoisinite = Blastoisinite + {$_POST['blastoisinite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['blazikenite'] > 0){
				mysql_query("UPDATE items SET Blazikenite = Blazikenite + {$_POST['blazikenite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['charizarditex'] > 0){
				mysql_query("UPDATE items SET CharizarditeX = CharizarditeX + {$_POST['charizarditex']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['charizarditey'] > 0){
				mysql_query("UPDATE items SET CharizarditeY = CharizarditeY + {$_POST['charizarditey']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['garchompite'] > 0){
				mysql_query("UPDATE items SET Garchompite = Garchompite + {$_POST['garchompite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['gardevoirite'] > 0){
				mysql_query("UPDATE items SET Gardevoirite = Gardevoirite + {$_POST['gardevoirite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['gengarite'] > 0){
				mysql_query("UPDATE items SET Gengarite = Gengarite + {$_POST['gengarite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['gyaradosite'] > 0){
				mysql_query("UPDATE items SET Gyaradosite = Gyaradosite + {$_POST['gyaradosite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['heracronite'] > 0){
				mysql_query("UPDATE items SET Heracronite = Heracronite + {$_POST['heracronite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['houndoominite'] > 0){
				mysql_query("UPDATE items SET Houndoominite = Houndoominite + {$_POST['houndoominite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['kangaskhanite'] > 0){
				mysql_query("UPDATE items SET Kangaskhanite = Kangaskhanite + {$_POST['kangaskhanite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['lucarionite'] > 0){
				mysql_query("UPDATE items SET Lucarionite = Lucarionite + {$_POST['lucarionite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['manectite'] > 0){
				mysql_query("UPDATE items SET Manectite = Manectite + {$_POST['manectite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['mawilite'] > 0){
				mysql_query("UPDATE items SET Mawilite = Mawilite + {$_POST['mawilite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['medichamite'] > 0){
				mysql_query("UPDATE items SET Medichamite = Medichamite + {$_POST['medichamite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['mewtwonitex'] > 0){
				mysql_query("UPDATE items SET MewtwoniteX = MewtwoniteX + {$_POST['mewtwonitex']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['mewtwonitey'] > 0){
				mysql_query("UPDATE items SET MewtwoniteY = MewtwoniteY + {$_POST['mewtwonitey']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['pinsirite'] > 0){
				mysql_query("UPDATE items SET Pinsirite = Pinsirite + {$_POST['pinsirite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['scizorite'] > 0){
				mysql_query("UPDATE items SET Scizorite = Scizorite + {$_POST['scizorite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['tyranitarite'] > 0){
				mysql_query("UPDATE items SET Tyranitarite = Tyranitarite + {$_POST['tyranitarite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['venusaurite'] > 0){
				mysql_query("UPDATE items SET Venusaurite = Venusaurite + {$_POST['venusaurite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['altarianite'] > 0){
				mysql_query("UPDATE items SET Altarianite = Altarianite + {$_POST['altarianite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['audinite'] > 0){
				mysql_query("UPDATE items SET Audinite = Audinite + {$_POST['audinite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['beedrillite'] > 0){
				mysql_query("UPDATE items SET Beedrillite = Beedrillite + {$_POST['beedrillite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['cameruptite'] > 0){
				mysql_query("UPDATE items SET Cameruptite = Cameruptite + {$_POST['cameruptite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['diancite'] > 0){
				mysql_query("UPDATE items SET Diancite = Diancite + {$_POST['diancite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['galladite'] > 0){
				mysql_query("UPDATE items SET Galladite = Galladite + {$_POST['galladite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['glalitite'] > 0){
				mysql_query("UPDATE items SET Glalitite = Glalitite + {$_POST['glalitite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['lopunnite'] > 0){
				mysql_query("UPDATE items SET Lopunnite = Lopunnite + {$_POST['lopunnite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['metagrossite'] > 0){
				mysql_query("UPDATE items SET Metagrossite = Metagrossite + {$_POST['metagrossite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['pidgeotite'] > 0){
				mysql_query("UPDATE items SET Pidgeotite = Pidgeotite + {$_POST['pidgeotite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['sablenite'] > 0){
				mysql_query("UPDATE items SET Sablenite = Sablenite + {$_POST['sablenite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['salamencite'] > 0){
				mysql_query("UPDATE items SET Salamencite = Salamencite + {$_POST['salamencite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['sceptilite'] > 0){
				mysql_query("UPDATE items SET Sceptilite = Sceptilite + {$_POST['sceptilite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['sharpedonite'] > 0){
				mysql_query("UPDATE items SET Sharpedonite = Sharpedonite + {$_POST['sharpedonite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['slowbronite'] > 0){
				mysql_query("UPDATE items SET Slowbronite = Slowbronite + {$_POST['slowbronite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['steelixite'] > 0){
				mysql_query("UPDATE items SET Steelixite = Steelixite + {$_POST['steelixite']} WHERE uid = '{$_SESSION['myid']}'");
			}
			if($_POST['swampertite'] > 0){
				mysql_query("UPDATE items SET Swampertite = Swampertite + {$_POST['swampertite']} WHERE uid = '{$_SESSION['myid']}'");
			}
		}
		
		if($moneyvar2 < $total){
			$trans = "no";
		}
	}
	
	if($_REQUEST['buy'] != "lotto"){
		$moul = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
		$moula = mysql_fetch_array($moul);
		$moneyvar = $moula['money'];
		$allitems = mysql_query("SELECT * FROM items WHERE uid = '{$_SESSION['myid']}'");
		$ai = mysql_fetch_array($allitems);
		
		$_SESSION['items'] = array("{$ai['Potion']}","{$ai['Super_Potion']}","{$ai['Hyper_Potion']}","{$ai['Full_Heal']}","{$ai['Awakening']}","{$ai['Parlyz_Heal']}","{$ai['Antidote']}","{$ai['Burn_Heal']}","{$ai['Ice_Heal']}","{$ai['Poke_Ball']}","{$ai['Great_Ball']}","{$ai['Ultra_Ball']}","{$ai['Master_Ball']}");
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript" src="html/static/js//v3/functions.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/menu.js"></script>
<script type="text/javascript" language="javascript" src="html/static/js//v3/suggest.js"></script>
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
	<script type="text/javascript" language="javascript" src="html/static/js//v3/ie6-.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie6-.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
	<script type="text/javascript" language="javascript" src="html/static/js//v3/ie7+.js"></script>
	<link rel="stylesheet" type="text/css" href="html/static/css/ie7+.css" media="screen" />
<![endif]-->
<noscript><link rel="stylesheet" type="text/css" href="html/static/css/noscript.css" media="all" /></noscript>
<link rel="icon" href="/favicon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="favicon.png" type="image/x-icon" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Pok&eacute;mon shqipe v3 - Pok&eacute;mart</title>
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
<?php include('includes/usernav.php'); ?>
<div id="contentContainer">
<div id="sidebar">
<div id="sidebarContainer">
<div id="sidebarLoading"></div>
<div id="sidebarContent"></div>
</div>
<ul id="sidebarTabs">
<li><a href="/pokedex.php" id="pokedexTab" class="deselected"><em>Pok&eacute;Dex</em></a></li>
<li><a href="/members.php" id="membersTab" class="deselected"><em>Members</em></a></li>
<li><a href="/options.php" id="optionsTab" class="deselected"><em>Options</em></a></li>
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
<?php if($_REQUEST['buy'] != "lotto"){
	mysql_query("UPDATE online SET activity = 'Purchasing items from the Pokemart' WHERE id = '{$_SESSION['myid']}'");
	if($trans == "yes"){ echo "<div class=\"actionMsg\">Transaction successful.</div>"; } if($trans == "no"){ echo "<div class=\"errorMsg\">You don't have enough money to make the requested transaction.</div>"; } ?>
<h2>Item Inventory and Pok&eacute;mart</h2><br/>
You currently have <img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;"/><?php echo number_format($moneyvar); ?> that can be spent. <p>[ <a href="items.php?buy=lotto">Click here for the Lottery</a> ]
<p><form method="POST">
<table style="margin-left: auto; border: 2px solid #000000; margin-right: auto;"><tr><td style="border: 1px solid #000000;" width="150" align="center"><strong>Item</strong></td><td width="150" style="border: 1px solid #000000;" align="center"><strong>Item Description</strong></td><td width="150" style="border: 1px solid #000000;"><strong>You have</strong></td><td width="220" align="center" style="border: 1px solid #000000;"><strong>Price & Purchase Quantity</strong></td></tr>
<br/>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Potion.png" style="vertical-align: middle;"> Potion</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine for wounds. It restores the HP of one Pok&eacute;mon by just 20 points.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Potion']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">500 each<br />Buy: <select name="potion"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Super Potion.png" style="vertical-align: middle;"> Super Potion</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine for wounds. It restores the HP of one Pok&eacute;mon by 50 points.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Super_Potion']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">1,000 each<br />Buy: <select name="superpotion"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Hyper Potion.png" style="vertical-align: middle;"> Hyper Potion</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine for wounds. It restores the HP of one Pok&eacute;mon by 200 points.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Hyper_Potion']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">2,000 each<br />Buy: <select name="hyperpotion"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Poke Ball.png" style="vertical-align: middle;"> Pok&eacute;ball</td><td width="150" style="border: 1px solid #000000;">A device for catching wild Pok&eacute;mon. It is thrown like a ball at the target. It is designed as a capsule system.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Poke_Ball']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">250 each<br />Buy: <select name="pokeball"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Great Ball.png" style="vertical-align: middle;"> Great Ball</td><td width="150" style="border: 1px solid #000000;">A good, high-performance Ball that provides a higher Pok&eacute;mon catch rate than a standard Pok&eacute;ball.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Great_Ball']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">800 each<br />Buy: <select name="greatball"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Ultra Ball.png" style="vertical-align: middle;"> Ultra Ball</td><td width="150" style="border: 1px solid #000000;">An ultra-performance Ball that provides a higher Pok&eacute;mon catch rate than a Great Ball.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Ultra_Ball']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">1,500 each<br />Buy: <select name="ultraball"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Master Ball.png" style="vertical-align: middle;"> Master Ball</td><td width="150" style="border: 1px solid #000000;">The best Ball with the ultimate level of performance. It will catch any wild Pok&eacute;mon without fail.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Master_Ball']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">100,000 each<br />Buy: <select name="masterball"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Full Heal.png" style="vertical-align: middle;"> Full Heal</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine. It heals all the status problems of a single Pok&eacute;mon.</td><td width="150" style="border: 1px solid #000000;" style="border: 1px solid #000000;"><?php echo $ai['Full_Heal']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">500 each<br />Buy: <select name="fullheal"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Antidote.png" style="vertical-align: middle;"> Antidote</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine. It lifts the effect of poison from one Pok&eacute;mon.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Antidote']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">500 each<br />Buy: <select name="antidote"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Parlyz Heal.png" style="vertical-align: middle;"> Parlyz Heal</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine. It eliminates paralysis from a single Pok&eacute;mon.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Parlyz_Heal']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">500 each<br />Buy: <select name="parlyzheal"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Burn Heal.png" style="vertical-align: middle;"> Burn Heal</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine. It heals a single Pok&eacute;mon that is suffering from a burn.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Burn_Heal']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">500 each<br />Buy: <select name="burnheal"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Ice Heal.png" style="vertical-align: middle;"> Ice Heal</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine. It defrosts a Pok&eacute;mon that has been frozen solid.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Ice_Heal']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">500 each<br />Buy: <select name="iceheal"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Awakening.png" style="vertical-align: middle;"> Awakening</td><td width="150" style="border: 1px solid #000000;">A spray-type medicine. It awakens a Pok&eacute;mon from the clutches of sleep.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Awakening']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">500 each<br />Buy: <select name="awakening"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Dawn Stone.png" style="vertical-align: middle;"> Dawn Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It sparkles like eyes.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Dawn_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="dawnstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Dusk Stone.png" style="vertical-align: middle;"> Dusk Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It is as dark as dark can be.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Dusk_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="duskstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Fire Stone.png" style="vertical-align: middle;"> Fire Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It is colored orange.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Fire_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">3,000 each<br />Buy: <select name="firestone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Leaf Stone.png" style="vertical-align: middle;"> Leaf Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It has a leaf pattern.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Leaf_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">3,000 each<br />Buy: <select name="leafstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Moon Stone.png" style="vertical-align: middle;"> Moon Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It is as black as the night sky.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Moon_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">4,000 each<br />Buy: <select name="moonstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Oval Stone.png" style="vertical-align: middle;"> Oval Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It is shaped like an egg.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Oval_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="ovalstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Shiny Stone.png" style="vertical-align: middle;"> Shiny Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It shines with a dazzling light.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Shiny_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="shinystone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Sun Stone.png" style="vertical-align: middle;"> Sun Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It is as red as the sun.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Sun_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="sunstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Thunder Stone.png" style="vertical-align: middle;"> Thunder Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It has a thunderbolt pattern.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Thunder_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">3,000 each<br />Buy: <select name="thunderstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Water Stone.png" style="vertical-align: middle;"> Water Stone</td><td width="150" style="border: 1px solid #000000;">A peculiar stone that makes certain species of Pok&eacute;mon evolve. It is a clear, light blue.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Water_Stone']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">3,000 each<br />Buy: <select name="waterstone"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Deepseascale.png" style="vertical-align: middle;"> Deepseascale</td><td width="150" style="border: 1px solid #000000;">An item to be held by Clamperl. A scale that shines a faint pink, it raises the Sp. Def stat.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Deepseascale']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="deepseascale"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Deepseatooth.png" style="vertical-align: middle;"> Deepseatooth</td><td width="150" style="border: 1px solid #000000;">An item to be held by Clamperl. A fang that gleams a sharp silver, it raises the Sp. Atk stat.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Deepseatooth']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="deepseatooth"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Dragon Scale.png" style="vertical-align: middle;"> Dragon Scale</td><td width="150" style="border: 1px solid #000000;">A thick and tough scale. Certain Dragon-type Pok&eacute;mon may evolve when holding this item.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Dragon_Scale']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="dragonscale"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Dubious Disc.png" style="vertical-align: middle;"> Dubious Disc</td><td width="150" style="border: 1px solid #000000;">A transparent device overflowing with dubious data. Its producer is unknown.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Dubious_Disc']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="dubiousdisc"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Electirizer.png" style="vertical-align: middle;"> Electirizer</td><td width="150" style="border: 1px solid #000000;">A box packed with a tremendous amount of electric energy. It is loved by a certain Pok&eacute;mon.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Electirizer']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="electirizer"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Magmarizer.png" style="vertical-align: middle;"> Magmarizer</td><td width="150" style="border: 1px solid #000000;">A box packed with a tremendous amount of magma energy. It is loved by a certain Pok&eacute;mon.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Magmarizer']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="magmarizer"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Kings Rock.png" style="vertical-align: middle;"> Kings Rock</td><td width="150" style="border: 1px solid #000000;">An item to be held by a Pok&eacute;mon. When the holder successfully inflicts damage, the target may also flinch.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Kings_Rock']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="kingsrock"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Metal Coat.png" style="vertical-align: middle;"> Metal Coat</td><td width="150" style="border: 1px solid #000000;">An item to be held by a Pok&eacute;mon. It is a special metallic film that can boost the power of Steel-type moves.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Metal_Coat']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="metalcoat"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Prism Scale.png" style="vertical-align: middle;"> Prism Scale</td><td width="150" style="border: 1px solid #000000;">A mysterious scale that causes a certain Pok&eacute;mon to evolve. It shines in rainbow colors.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Prism_Scale']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="prismscale"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Protector.png" style="vertical-align: middle;"> Protector</td><td width="150" style="border: 1px solid #000000;">A protective item of some sort. It is extremely stiff and heavy. It's loved by a certain Pok&eacute;mon.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Protector']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="protector"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Razor Claw.png" style="vertical-align: middle;"> Razor Claw</td><td width="150" style="border: 1px solid #000000;">An item to be held by a Pok&eacute;mon. This sharply hooked claw increases the holder's critical-hit ratio.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Razor_Claw']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="razorclaw"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Razor Fang.png" style="vertical-align: middle;"> Razor Fang</td><td width="150" style="border: 1px solid #000000;">An item to be held by a Pok&eacute;mon. When the holder successfully inflicts damage, the target may also flinch.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Razor_Fang']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="razorfang"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Reaper Cloth.png" style="vertical-align: middle;"> Reaper Cloth</td><td width="150" style="border: 1px solid #000000;">A cloth imbued with horrifyingly strong spiritual energy. It's loved by a certain Pok&eacute;mon.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Reaper_Cloth']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="reapercloth"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Up Grade.png" style="vertical-align: middle;"> Up Grade</td><td width="150" style="border: 1px solid #000000;">A transparent device somehow filled with all sorts of data. It was produced by Silph Co.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Up_Grade']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="upgrade"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Sachet.png" style="vertical-align: middle;"> Sachet</td><td width="150" style="border: 1px solid #000000;">A sachet filled with fragrant perfumes that are just slightly too overwhelming. Yet it's loved by a certain Pok&eacute;mon</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Sachet']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="sachet"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Whipped Dream.png" style="vertical-align: middle;"> Whipped Dream</td><td width="150" style="border: 1px solid #000000;">A soft and sweet treatmade of fluffy, puffy, whipped and whirled cream. It's loved by a certain Pok&eacute;mon</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Whipped_Dream']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="whippeddream"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Ice Rock.png" style="vertical-align: middle;"> Ice Rock</td><td width="150" style="border: 1px solid #000000;">A rock shard covered in ice. Certain pokemon are said to evolve when coming into contact with it.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Ice_Rock']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="icerock"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Moss Rock.png" style="vertical-align: middle;"> Moss Rock</td><td width="150" style="border: 1px solid #000000;">A rock shard covered in moss. Certain pokemon are said to evolve when coming into contact with it.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Moss_Rock']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">5,000 each<br />Buy: <select name="mossrock"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Abomasite.png" style="vertical-align: middle;"> Abomasite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Abomasnow hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Abomasite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="abomasite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Absolite.png" style="vertical-align: middle;"> Absolite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Absol hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Absolite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="absolite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Aerodactylite.png" style="vertical-align: middle;"> Aerodactylite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Aerodactyl hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Aerodactylite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="aerodactylite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Aggronite.png" style="vertical-align: middle;"> Aggronite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Aggron hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Aggronite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="aggronite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Alakazite.png" style="vertical-align: middle;"> Alakazite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Alakazam hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Alakazite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="alakazite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Altarianite.png" style="vertical-align: middle;"> Altarianite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Altaria hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Altarianite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="altarianite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Ampharosite.png" style="vertical-align: middle;"> Ampharosite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Ampharos hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Ampharosite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="ampharosite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Audinite.png" style="vertical-align: middle;"> Audinite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Audino hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Audinite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="audinite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Banettite.png" style="vertical-align: middle;"> Banettite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Banette hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Banettite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="banettite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Beedrillite.png" style="vertical-align: middle;"> Beedrillite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Beedrill hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Beedrillite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="beedrillite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Blastoisinite.png" style="vertical-align: middle;"> Blastoisinite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Blastoise hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Blastoisinite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="blastoisinite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Blazikenite.png" style="vertical-align: middle;"> Blazikenite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Blaziken hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Blazikenite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="blazikenite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Cameruptite.png" style="vertical-align: middle;"> Cameruptite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Camerupt hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Cameruptite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="cameruptite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/CharizarditeX.png" style="vertical-align: middle;"> Charizardite X</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Charizard hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['CharizarditeX']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="charizarditex"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/CharizarditeY.png" style="vertical-align: middle;"> Charizardite Y</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Charizard hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['CharizarditeY']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="http://static.pokemon-shqipe.co.ukimages/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="charizarditey"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Diancite.png" style="vertical-align: middle;"> Diancite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Diancie hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Diancite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="diancite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Galladite.png" style="vertical-align: middle;"> Galladite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Gallade hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Galladite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="galladite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Garchompite.png" style="vertical-align: middle;"> Garchompite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Garchomp hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Garchompite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="garchompite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Gardevoirite.png" style="vertical-align: middle;"> Gardevoirite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Gardevoir hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Gardevoirite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="gardevoirite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Gengarite.png" style="vertical-align: middle;"> Gengarite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Gengar hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Gengarite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="gengarite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Glalitite.png" style="vertical-align: middle;"> Glalitite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Glalie hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Glalitite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="glalitite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Gyaradosite.png" style="vertical-align: middle;"> Gyaradosite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Gyarados hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Gyaradosite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="gyaradosite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Heracronite.png" style="vertical-align: middle;"> Heracronite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Heracross hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Heracronite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="heracronite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Houndoominite.png" style="vertical-align: middle;"> Houndoominite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Houndoom hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Houndoominite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="houndoominite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Kangaskhanite.png" style="vertical-align: middle;"> Kangaskhanite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Kangaskhan hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Kangaskhanite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="kangaskhanite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Lopunnite.png" style="vertical-align: middle;"> Lopunnite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Lopunny hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Lopunnite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="lopunnite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Lucarionite.png" style="vertical-align: middle;"> Lucarionite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Lucario hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Lucarionite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="lucarionite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Manectite.png" style="vertical-align: middle;"> Manectite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Manectric hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Manectite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="manectite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Mawilite.png" style="vertical-align: middle;"> Mawilite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Mawile hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Mawilite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="mawilite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Medichamite.png" style="vertical-align: middle;"> Medichamite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Medicham hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Medichamite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="medichamite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Metagrossite.png" style="vertical-align: middle;"> Metagrossite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Metagross hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Metagrossite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="metagrossite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/MewtwoniteX.png" style="vertical-align: middle;"> Mewtwonite X</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Mewtwo hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['MewtwoniteX']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="mewtwonitex"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/MewtwoniteY.png" style="vertical-align: middle;"> Mewtwonite Y</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Mewtwo hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['MewtwoniteY']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="mewtwonitey"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Pidgeotite.png" style="vertical-align: middle;"> Pidgeotite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Pidgeot hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Pidgeotite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="pidgeotite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Pinsirite.png" style="vertical-align: middle;"> Pinsirite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Pinsir hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Pinsirite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="pinsirite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Sablenite.png" style="vertical-align: middle;"> Sablenite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Sableye hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Sablenite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="sablenite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Salamencite.png" style="vertical-align: middle;"> Salamencite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Salamence hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Salamencite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="salamencite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Sceptilite.png" style="vertical-align: middle;"> Sceptilite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Sceptile hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Sceptilite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="sceptilite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Scizorite.png" style="vertical-align: middle;"> Scizorite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Scizor hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Scizorite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="scizorite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Sharpedonite.png" style="vertical-align: middle;"> Sharpedonite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Sharpedo hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Sharpedonite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="sharpedonite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Slowbronite.png" style="vertical-align: middle;"> Slowbronite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Slowbro hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Slowbronite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="slowbronite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Steelixite.png" style="vertical-align: middle;"> Steelixite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Steelix hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Steelixite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="steelixite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Swampertite.png" style="vertical-align: middle;"> Swampertite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Swampert hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Swampertite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="swampertite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>

<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Tyranitarite.png" style="vertical-align: middle;"> Tyranitarite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Tyranitar hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Tyranitarite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="tyranitarite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
<tr><td width="75" height="80" align="center" style="border: 1px solid #000000;"><img src="html/static/images/items/Venusaurite.png" style="vertical-align: middle;"> Venusaurite</td><td width="150" style="border: 1px solid #000000;">One of the mysterious Mega Stones. Have Venusaur hold it, and this stone will enable it to Mega Evolve.</td><td width="150" style="border: 1px solid #000000;"><?php echo $ai['Venusaurite']; ?></td><td width="150" align="center" style="border: 1px solid #000000;"><img src="html/static/images/misc/pmoney.gif" style="vertical-align: middle;">15,000 each<br />Buy: <select name="venusaurite"><option>0</option><option>1</option><option>2</option><option>3</option><option>5</option><option>10</option><option>25</option><option>50</option><option>100</option></select></td></tr>
</table>
<input name="buy" type="submit" value="Buy Items">
</form>
	<?php
}
else {
	$drawn = 1;
	if($drawn == 1){
		echo '<div class="actionMsg">The lottery is not currently being run during the Beta.</div>';
	}
	else{
		if($suc == 1){
			?>
            <div class="actionMsg">You have bought 1 lottery ticket. Good luck, the winnings are given out once a month.</div>
			
			<?php
		}
		if($ezo == 1){
			?>
            <div class="errorMsg">The transaction you attempted failed.</div>
			<?php
		}
		if($error == 1){
			?>
            <div class="errorMsg">The transaction you are attempting to make puts you over the 1 ticket quota for this lottery, or you do not have enough money to buy one.</div>
			<?php
		}
		$m = mysql_query("SELECT COUNT(*) FROM lotto"); 
		$money = mysql_fetch_array($m);
		$momo = $money['COUNT(*)'] * 50000; 
		$r = mysql_query("SELECT tickets FROM lotto WHERE uid = '{$_SESSION['myid']}'");
		$rr = mysql_num_rows($r);
		$r = mysql_query("SELECT money FROM members WHERE id = '{$_SESSION['myid']}'");
		$re = mysql_fetch_array($r); ?>
        <div class="noticeMsg">The lottery will not be running during the BETA of v3.</div>
        <h2>Pok&eacute;mon Shqipe Lottery - Currently at <img src="html/static/images/misc/pmoney.gif" /><? echo number_format($momo); ?> You have purchased <?=$rr?> ticket already.</h2>
        <p>One member can buy <b>1</b> lottery ticket every month. Each lottery ticket gives a member a chance of earning a split prize of the lottery money, which is a sum of all the money spent on lottery tickets.
        <br />
        In addition, a rare pokemon unobtainable in the game (Ex. Deoxys or Arceus Forms). Each lottery cycle will last one month. The price for each ticket is <img src="html/static/images/misc/pmoney.gif" />50,000.
        <br />
        Just click 'Purchase!' to get your ticket and be entered into this month's lottery.</p><br /><strong>Money:</strong> <img src="html/static/images/misc/pmoney.gif" align="absmiddle"> <?php echo number_format($re['money']); ?>
        <br />
        <form name="lotto" method="post">
        <p><input type="submit" name="buy2" value="Purchase!" /></p>
        </form>
        <strong>This month's prize is:</strong><br><img src="html/static/images/pokemon/Shiny Missingno..gif"><br /><b>Shiny Missingno.</b>
        <p><div class="hr" style="width:300px;text-align:center;margin:0 auto;"></div></p>
		<?php
	}
	?>
    
    <h2>Previous Lottery Winners:</h2>
    <strong>The following users all won <img src="html/static/images/misc/pmoney.gif" />0.</strong><br /> ??? <br /> ??? <br /> ??? <br /> ??? <br /> ???
	<?php
} ?>
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
<?php }
else{
	include('pv_disconnect_from_db.php'); 
	header("location:login.php?goawayxP=1");
}
?>