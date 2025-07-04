else if($_SESSION['evname'] == 'Dark Spewpa'){
			$b = 7;
			$getvivi = mysql_query("SELECT * FROM members WHERE id = '{$_SESSION['myid']}'");
			if($getvivi['number'] = '1'){
				$see['ep'] = 'Dark Vivillon (Archipelago)';
			}
			if($getvivi['number'] = '2'){
				$see['ep'] = 'Dark Vivillon (Continental)';
			}
			if($getvivi['number'] = '3'){
				$see['ep'] = 'Dark Vivillon (Elegant)';
			}
			if($getvivi['number'] = '4'){
				$see['ep'] = 'Dark Vivillon (Garden)';
			}
			if($getvivi['number'] = '5'){
				$see['ep'] = 'Dark Vivillon (High Plains)';
			}
			if($getvivi['number'] = '6'){
				$see['ep'] = 'Dark Vivillon (Icy Snow)';
			}
			if($getvivi['number'] = '7'){
				$see['ep'] = 'Dark Vivillon (Jungle)';
			}
			if($getvivi['number'] = '8'){
				$see['ep'] = 'Dark Vivillon (Marine)';
			}
			if($getvivi['number'] = '9'){
				$see['ep'] = 'Dark Vivillon (Meadow)';
			}
			if($getvivi['number'] = '10'){
				$see['ep'] = 'Dark Vivillon (Modern)';
			}
			if($getvivi['number'] = '11'){
				$see['ep'] = 'Dark Vivillon (Monsoon)';
			}
			if($getvivi['number'] = '12'){
				$see['ep'] = 'Dark Vivillon (Ocean)';
			}
			if($getvivi['number'] = '13'){
				$see['ep'] = 'Dark Vivillon (Polar)';
			}
			if($getvivi['number'] = '14'){
				$see['ep'] = 'Dark Vivillon (River)';
			}
			if($getvivi['number'] = '15'){
				$see['ep'] = 'Dark Vivillon (Sandstorm)';
			}
			if($getvivi['number'] = '16'){
				$see['ep'] = 'Dark Vivillon (Savanna)';
			}
			if($getvivi['number'] = '17'){
				$see['ep'] = 'Dark Vivillon (Sun)';
			}
			if($getvivi['number'] = '18'){
				$see['ep'] = 'Dark Vivillon (Tundra)';
			}
			if($getvivi['number'] = '19'){
				$see['ep'] = 'Dark Vivillon (Pokeball)';
			}
			if($getvivi['number'] = '20'){
				$see['ep'] = 'Dark Vivillon (Fancy)';
			}
			$_SESSION['ev'] = $_REQUEST['pid'];
			$_SESSION['evpoke'] = $see['ep'];
		}