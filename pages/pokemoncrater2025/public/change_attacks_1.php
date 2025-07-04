<?php
include('kick.php');
session_start();
if($_SESSION['access'] != 9){
	include('pv_disconnect_from_db.php');
	header("location:http://www.pokemon-shqipe.co.uk/login.php?goawayxP=1");
}
include('pv_connect_to_db.php');

$pid = mysql_real_escape_string($_POST['pid']);

if(!$_POST['cattack'] || !$_POST['attack']){
	header("location:change_attacks.php?pid={$pid}&error=1");
}

$attt = mysql_query("SELECT * FROM pokemon WHERE id = '$pid'");
$att = mysql_fetch_array($attt);

if($_POST['cattack'] == $att['a1'] || $_POST['cattack'] == $att['a2'] || $_POST['cattack'] == $att['a3'] || $_POST['cattack'] == $att['a4']){
	header("location:change_attacks.php?pid={$pid}&error=4");
}
else{
	$take_money = '0';
	if($_POST['cattack'] == 'Spore' || $_POST['cattack'] == 'Supersonic' || $_POST['cattack'] == 'Rototiller' || $_POST['cattack'] == 'Kinesis' || $_POST['cattack'] == 'Entrainment' || $_POST['cattack'] == 'Swagger' || $_POST['cattack'] == 'Endure' || $_POST['cattack'] == 'Endeavor' || $_POST['cattack'] == 'Encore' || $_POST['cattack'] == 'Kings Shield' || $_POST['cattack'] == 'Embargo' || $_POST['cattack'] == 'Swallow' || $_POST['cattack'] == 'Role Play' || $_POST['cattack'] == 'Sunny Day' || $_POST['cattack'] == 'Fairy Lock' || $_POST['cattack'] == 'Flower Shield' || $_POST['cattack'] == 'Flatter' || $_POST['cattack'] == 'Stealth Rock' || $_POST['cattack'] == 'Flash' || $_POST['cattack'] == 'Sticky Web' || $_POST['cattack'] == 'Stockpile' || $_POST['cattack'] == 'String Shot' || $_POST['cattack'] == 'Stun Spore' || $_POST['cattack'] == 'Substitute' || $_POST['cattack'] == 'Feather Dance' || $_POST['cattack'] == 'Fake Tears' || $_POST['cattack'] == 'Sharpen' || $_POST['cattack'] == 'Electrify' || $_POST['cattack'] == 'Electric Terrain' || $_POST['cattack'] == 'Magic Coat' || $_POST['cattack'] == 'Magic Room' || $_POST['cattack'] == 'Dragon Dance' || $_POST['cattack'] == 'Tail Whip' || $_POST['cattack'] == 'Tailwind' || $_POST['cattack'] == 'Magnet Rise' || $_POST['cattack'] == 'Magnetic Flux' || $_POST['cattack'] == 'Rest' || $_POST['cattack'] == 'Taunt' || $_POST['cattack'] == 'Teeter Dance' || $_POST['cattack'] == 'Mat Block' || $_POST['cattack'] == 'Telekinesis' || $_POST['cattack'] == 'Roar' || $_POST['cattack'] == 'Tail Glow' || $_POST['cattack'] == 'Rock Polish' || $_POST['cattack'] == 'Eerie Impulse' || $_POST['cattack'] == 'Leer' || $_POST['cattack'] == 'Light Screen' || $_POST['cattack'] == 'Sweet Scent' || $_POST['cattack'] == 'Lock-On' || $_POST['cattack'] == 'Lovely Kiss' || $_POST['cattack'] == 'Switcheroo' || $_POST['cattack'] == 'Swords Dance' || $_POST['cattack'] == 'Lucky Chant' || $_POST['cattack'] == 'Synthesis' || $_POST['cattack'] == 'Lunar Dance' || $_POST['cattack'] == 'Teleport' || $_POST['cattack'] == 'Splash' || $_POST['cattack'] == 'Sleep Powder' || $_POST['cattack'] == 'Soft-Boiled' || $_POST['cattack'] == 'Sing' || $_POST['cattack'] == 'Simple Beam' || $_POST['cattack'] == 'Haze' || $_POST['cattack'] == 'Harden' || $_POST['cattack'] == 'Happy Hour' || $_POST['cattack'] == 'Shift Gear' || $_POST['cattack'] == 'Hail' || $_POST['cattack'] == 'Shell Smash' || $_POST['cattack'] == 'Hone Claws' || $_POST['cattack'] == 'Howl' || $_POST['cattack'] == 'Sweet Kiss' || $_POST['cattack'] == 'Heal Bell' || $_POST['cattack'] == 'Heal Bell' || $_POST['cattack'] == 'Heal Block' || $_POST['cattack'] == 'Slack Off' || $_POST['cattack'] == 'Smokescreen' || $_POST['cattack'] == 'Snatch' || $_POST['cattack'] == 'Leech Seed' || $_POST['cattack'] == 'Helping Hand' || $_POST['cattack'] == 'Skill Swap' || $_POST['cattack'] == 'Sketch' || $_POST['cattack'] == 'Heart Swap' || $_POST['cattack'] == 'Soak' || $_POST['cattack'] == 'Healing Wish' || $_POST['cattack'] == 'Heal Pulse' || $_POST['cattack'] == 'Heal Order' || $_POST['cattack'] == 'Guard Swap' || $_POST['cattack'] == 'Guard Split' || $_POST['cattack'] == 'Sand Attack' || $_POST['cattack'] == 'Safeguard' || $_POST['cattack'] == 'Imprison' || $_POST['cattack'] == 'Spikes' || $_POST['cattack'] == 'Ingrain' || $_POST['cattack'] == 'Ion Deluge' || $_POST['cattack'] == 'Spiky Shield' || $_POST['cattack'] == 'Forests Curse' || $_POST['cattack'] == 'Foresight' || $_POST['cattack'] == 'Spite' || $_POST['cattack'] == 'Follow Me' || $_POST['cattack'] == 'Sleep Talk' || $_POST['cattack'] == 'Gastro Acid' || $_POST['cattack'] == 'Sandstorm' || $_POST['cattack'] == 'Grudge' || $_POST['cattack'] == 'Growth' || $_POST['cattack'] == 'Growl' || $_POST['cattack'] == 'Gravity' || $_POST['cattack'] == 'Grassy Terrain' || $_POST['cattack'] == 'Grass Whistle' || $_POST['cattack'] == 'Hypnosis' || $_POST['cattack'] == 'Glare' || $_POST['cattack'] == 'Screech' || $_POST['cattack'] == 'Scary Face' || $_POST['cattack'] == 'Spider Web' || $_POST['cattack'] == 'Geomancy' || $_POST['cattack'] == 'Focus Energy' || $_POST['cattack'] == 'Quick Guard' || $_POST['cattack'] == 'Quash' || $_POST['cattack'] == 'Block' || $_POST['cattack'] == 'Nightmare' || $_POST['cattack'] == 'Noble Roar' || $_POST['cattack'] == 'Whirlwind' || $_POST['cattack'] == 'Odor Sleuth' || $_POST['cattack'] == 'Wide Guard' || $_POST['cattack'] == 'Bestow' || $_POST['cattack'] == 'Belly Drum' || $_POST['cattack'] == 'Psycho Shift' || $_POST['cattack'] == 'Will-O-Wisp' || $_POST['cattack'] == 'Baton Pass' || $_POST['cattack'] == 'Nasty Plot' || $_POST['cattack'] == 'Water Sport' || $_POST['cattack'] == 'Rage Powder' || $_POST['cattack'] == 'Mirror Move' || $_POST['cattack'] == 'Mist' || $_POST['cattack'] == 'Bulk Up' || $_POST['cattack'] == 'Recycle' || $_POST['cattack'] == 'Protect' || $_POST['cattack'] == 'Misty Terrain' || $_POST['cattack'] == 'Venom Drench' || $_POST['cattack'] == 'Recover' || $_POST['cattack'] == 'Moonlight' || $_POST['cattack'] == 'Morning Sun' || $_POST['cattack'] == 'Rain Dance' || $_POST['cattack'] == 'Reflect' || $_POST['cattack'] == 'Mud Sport' || $_POST['cattack'] == 'Barrier' || $_POST['cattack'] == 'Pain Split' || $_POST['cattack'] == 'Amnesia' || $_POST['cattack'] == 'Ally Switch' || $_POST['cattack'] == 'Power Trick' || $_POST['cattack'] == 'Yawn' || $_POST['cattack'] == 'Agility' || $_POST['cattack'] == 'After You' || $_POST['cattack'] == 'Power Swap' || $_POST['cattack'] == 'Poison Gas' || $_POST['cattack'] == 'Acupressure' || $_POST['cattack'] == 'Power Split' || $_POST['cattack'] == 'Poison Powder' || $_POST['cattack'] == 'Acid Armor' || $_POST['cattack'] == 'Powder' || $_POST['cattack'] == 'Play Nice' || $_POST['cattack'] == 'Aqua Ring' || $_POST['cattack'] == 'Worry Seed' || $_POST['cattack'] == 'Baby-Doll Eyes' || $_POST['cattack'] == 'Wish' || $_POST['cattack'] == 'Autotomize' || $_POST['cattack'] == 'Withdraw' || $_POST['cattack'] == 'Wonder Room' || $_POST['cattack'] == 'Attract' || $_POST['cattack'] == 'Parting Shot' || $_POST['cattack'] == 'Psych Up' || $_POST['cattack'] == 'Work Up' || $_POST['cattack'] == 'Assist' || $_POST['cattack'] == 'Aromatic Mist' || $_POST['cattack'] == 'Aromatherapy' || $_POST['cattack'] == 'Perish Song' || $_POST['cattack'] == 'Defense Curl' || $_POST['cattack'] == 'Crafty Shield' || $_POST['cattack'] == 'Torment' || $_POST['cattack'] == 'Transform' || $_POST['cattack'] == 'Coil' || $_POST['cattack'] == 'Mimic' || $_POST['cattack'] == 'Trick' || $_POST['cattack'] == 'Trick Room' || $_POST['cattack'] == 'Trick-or-Treat' || $_POST['cattack'] == 'Topsy-Turvy' || $_POST['cattack'] == 'Mind Reader' || $_POST['cattack'] == 'Cotton Guard' || $_POST['cattack'] == 'Minimize' || $_POST['cattack'] == 'Confide' || $_POST['cattack'] == 'Confuse Ray' || $_POST['cattack'] == 'Metal Sound' || $_POST['cattack'] == 'Toxic Spikes' || $_POST['cattack'] == 'Cotton Spore' || $_POST['cattack'] == 'Toxic' || $_POST['cattack'] == 'Cosmic Power' || $_POST['cattack'] == 'Copycat' || $_POST['cattack'] == 'Conversion 2' || $_POST['cattack'] == 'Conversion' || $_POST['cattack'] == 'Metronome' || $_POST['cattack'] == 'Milk Drink' || $_POST['cattack'] == 'Charm' || $_POST['cattack'] == 'Reflect Type' || $_POST['cattack'] == 'Quiver Dance' || $_POST['cattack'] == 'Memento' || $_POST['cattack'] == 'Mean Look' || $_POST['cattack'] == 'Disable' || $_POST['cattack'] == 'Destiny Bond' || $_POST['cattack'] == 'Defog' || $_POST['cattack'] == 'Meditate' || $_POST['cattack'] == 'Calm Mind' || $_POST['cattack'] == 'Detect' || $_POST['cattack'] == 'Camoflage' || $_POST['cattack'] == 'Captivate' || $_POST['cattack'] == 'Celebration' || $_POST['cattack'] == 'Curse' || $_POST['cattack'] == 'Miracle Eye' || $_POST['cattack'] == 'Tickle' || $_POST['cattack'] == 'Thunder Wave' || $_POST['cattack'] == 'Charge' || $_POST['cattack'] == 'Dark Void' || $_POST['cattack'] == 'Me First' || $_POST['cattack'] == 'Defend Order' || $_POST['cattack'] == 'Refresh')
	{
		$take_money = '800000000';
	}

	if($_POST['cattack'] == 'Poison Sting' || $_POST['cattack'] == 'Bind' || $_POST['cattack'] == 'Wrap')
	{
		$take_money = '11250';
	}

	if($_POST['cattack'] == 'Constrict' || $_POST['cattack'] == 'Mud-Slap' || $_POST['cattack'] == 'Rage' || $_POST['cattack'] == 'Nuzzle' || $_POST['cattack'] == 'Stored Power' || $_POST['cattack'] == 'Rapid Spin' || $_POST['cattack'] == 'Absorb' || $_POST['cattack'] == 'Infestation' || $_POST['cattack'] == 'Smog' || $_POST['cattack'] == 'Lick' || $_POST['cattack'] == 'Leech Life')
	{
		$take_money = '15000';
	}

	if($_POST['cattack'] == 'Tail Slap')
	{
		$take_money = '18750';
	}

	if($_POST['cattack'] == 'Fell Stinger' || $_POST['cattack'] == 'Struggle Bug' || $_POST['cattack'] == 'Rollout' || $_POST['cattack'] == 'Triple Kick' || $_POST['cattack'] == 'Feint' || $_POST['cattack'] == 'Incinerate' || $_POST['cattack'] == 'Astonish')
	{
		$take_money = '22500';
	}

	if($_POST['cattack'] == 'Sand Tomb' || $_POST['cattack'] == 'Vine Whip' || $_POST['cattack'] == 'Whirlpool' || $_POST['cattack'] == 'Peck')
	{
		$take_money = '26250';
	}

	if($_POST['cattack'] == 'Water Gun' || $_POST['cattack'] == 'Thunder Shock' || $_POST['cattack'] == 'Bubble' || $_POST['cattack'] == 'Vaccuum Wave' || $_POST['cattack'] == 'Power-Up Punch' || $_POST['cattack'] == 'Acid' || $_POST['cattack'] == 'Acid Spray' || $_POST['cattack'] == 'Aqua Jet' || $_POST['cattack'] == 'Bullet Punch' || $_POST['cattack'] == 'Powder Snow' || $_POST['cattack'] == 'Twister' || $_POST['cattack'] == 'Pay Day' || $_POST['cattack'] == 'Pound' || $_POST['cattack'] == 'Pursuit' || $_POST['cattack'] == 'Disarming Voice' || $_POST['cattack'] == 'Mega Drain' || $_POST['cattack'] == 'Gust' || $_POST['cattack'] == 'Fairy Wind' || $_POST['cattack'] == 'Storm Throw' || $_POST['cattack'] == 'Shadow Sneak' || $_POST['cattack'] == 'False Swipe' || $_POST['cattack'] == 'Fake Out' || $_POST['cattack'] == 'Mach Punch' || $_POST['cattack'] == 'Scratch' || $_POST['cattack'] == 'Ember' || $_POST['cattack'] == 'Echoed Voice' || $_POST['cattack'] == 'Dual Chop' || $_POST['cattack'] == 'Ice Shard' || $_POST['cattack'] == 'Rock Smash' || $_POST['cattack'] == 'Dragon Rage' || $_POST['cattack'] == 'Quick Attack')
	{
		$take_money = '30000';
	}

	if($_POST['cattack'] == 'Double Slap' || $_POST['cattack'] == 'Barrage' || $_POST['cattack'] == 'Water Shuriken' || $_POST['cattack'] == 'Fury Swipes' || $_POST['cattack'] == 'Pin Missile' || $_POST['cattack'] == 'Spike Cannon' || $_POST['cattack'] == 'Fury Attack' || $_POST['cattack'] == 'Bullet Seed' || $_POST['cattack'] == 'Arm Thrust' || $_POST['cattack'] == 'Rock Blast')
	{
		$take_money = '33750';
	}

	if($_POST['cattack'] == 'Struggle' || $_POST['cattack'] == 'Rock Throw' || $_POST['cattack'] == 'Tackle' || $_POST['cattack'] == 'Smack Down' || $_POST['cattack'] == 'Snore' || $_POST['cattack'] == 'Twineedle' || $_POST['cattack'] == 'Weather Ball' || $_POST['cattack'] == 'Poison Tail' || $_POST['cattack'] == 'Assurance' || $_POST['cattack'] == 'Draining Kiss' || $_POST['cattack'] == 'Clamp' || $_POST['cattack'] == 'Fury Cutter' || $_POST['cattack'] == 'Clear Smog' || $_POST['cattack'] == 'Comet Punch' || $_POST['cattack'] == 'Cut' || $_POST['cattack'] == 'Night Shade' || $_POST['cattack'] == 'Parabolic Charge' || $_POST['cattack'] == 'Metal Claw' || $_POST['cattack'] == 'Payback' || $_POST['cattack'] == 'Confusion' || $_POST['cattack'] == 'Poison Fang' || $_POST['cattack'] == 'Bone Rush' || $_POST['cattack'] == 'Karate Chop' || $_POST['cattack'] == 'Hex' || $_POST['cattack'] == 'Flame Charge' || $_POST['cattack'] == 'Charge Beam' || $_POST['cattack'] == 'Bonemerang')
	{
		$take_money = '37500';
	}

	if($_POST['cattack'] == 'Icy Wind' || $_POST['cattack'] == 'Mud Shot' || $_POST['cattack'] == 'Razor Leaf' || $_POST['cattack'] == 'Vice Grip' || $_POST['cattack'] == 'Fire Spin' || $_POST['cattack'] == 'Snarl' || $_POST['cattack'] == 'Air Cutter' || $_POST['cattack'] == 'Electroweb')
	{
		$take_money = '41250';
	}

	if($_POST['cattack'] == 'Hidden Power (Bug)' || $_POST['cattack'] == 'Hidden Power (Dark)' || $_POST['cattack'] == 'Hidden Power (Dragon)' || $_POST['cattack'] == 'Hidden Power (Electric)' || $_POST['cattack'] == 'Hidden Power (Fairy)' || $_POST['cattack'] == 'Hidden Power (Fighting)' || $_POST['cattack'] == 'Hidden Power (Fire)' || $_POST['cattack'] == 'Hidden Power (Flying)' || $_POST['cattack'] == 'Hidden Power (Ghost)' || $_POST['cattack'] == 'Hidden Power (Grass)' || $_POST['cattack'] == 'Hidden Power (Ground)' || $_POST['cattack'] == 'Hidden Power (Ice)' || $_POST['cattack'] == 'Hidden Power (Normal)' || $_POST['cattack'] == 'Hidden Power (Poison)' || $_POST['cattack'] == 'Hidden Power (Psychic)' || $_POST['cattack'] == 'Hidden Power (Rock)' || $_POST['cattack'] == 'Hidden Power (Steel)' || $_POST['cattack'] == 'Hidden Power (Water)' || $_POST['cattack'] == 'Covet' || $_POST['cattack'] == 'Shock Wave' || $_POST['cattack'] == 'Seismic Toss' || $_POST['cattack'] == 'Circle Throw' || $_POST['cattack'] == 'Force Palm' || $_POST['cattack'] == 'Counter' || $_POST['cattack'] == 'Shadow Punch' || $_POST['cattack'] == 'Flame Wheel' || $_POST['cattack'] == 'Silver Wind' || $_POST['cattack'] == 'Heart Stamp' || $_POST['cattack'] == 'Sonic Boom' || $_POST['cattack'] == 'Double Kick' || $_POST['cattack'] == 'Dragon Breath' || $_POST['cattack'] == 'Dragon Tail' || $_POST['cattack'] == 'Swift' || $_POST['cattack'] == 'Smelling Salts' || $_POST['cattack'] == 'Sky Drop' || $_POST['cattack'] == 'Thief' || $_POST['cattack'] == 'Feint Attack' || $_POST['cattack'] == 'Pluck' || $_POST['cattack'] == 'Low Sweep' || $_POST['cattack'] == 'Magical Leaf' || $_POST['cattack'] == 'Revenge' || $_POST['cattack'] == 'Magnet Bomb' || $_POST['cattack'] == 'Mirror Coat' || $_POST['cattack'] == 'Bite' || $_POST['cattack'] == 'Round' || $_POST['cattack'] == 'Ancientpower' || $_POST['cattack'] == 'Beat Up' || $_POST['cattack'] == 'Nature Power' || $_POST['cattack'] == 'Needle Arm' || $_POST['cattack'] == 'Wing Attack' || $_POST['cattack'] == 'Psywave' || $_POST['cattack'] == 'Avalanche' || $_POST['cattack'] == 'Aerial Ace' || $_POST['cattack'] == 'Ominous Wind' || $_POST['cattack'] == 'Present' || $_POST['cattack'] == 'Water Pulse' || $_POST['cattack'] == 'Bug Bite' || $_POST['cattack'] == 'Wake-Up Slap' || $_POST['cattack'] == 'Bulldoze' || $_POST['cattack'] == 'Rolling Kick' || $_POST['cattack'] == 'Rock Tomb')
	{
		$take_money = '45000';
	}

	if($_POST['cattack'] == 'Octazooka' || $_POST['cattack'] == 'Bubblebeam' || $_POST['cattack'] == 'Venoshock' || $_POST['cattack'] == 'Knock Off' || $_POST['cattack'] == 'Mystical Fire' || $_POST['cattack'] == 'Fire Fang' || $_POST['cattack'] == 'Spark' || $_POST['cattack'] == 'Aurora Beam' || $_POST['cattack'] == 'Brine' || $_POST['cattack'] == 'Stomp' || $_POST['cattack'] == 'Psybeam' || $_POST['cattack'] == 'Ice Fang' || $_POST['cattack'] == 'Steamroller' || $_POST['cattack'] == 'Sludge' || $_POST['cattack'] == 'Bide' || $_POST['cattack'] == 'Mud Bomb' || $_POST['cattack'] == 'Horn Attack' || $_POST['cattack'] == 'Chatter' || $_POST['cattack'] == 'Thunder Fang' || $_POST['cattack'] == 'Mirror Shot' || $_POST['cattack'] == 'Leaf Tornado' || $_POST['cattack'] == 'Bone Club' || $_POST['cattack'] == 'Glaciate')
	{
		$take_money = '48750';
	}

	if($_POST['cattack'] == 'Synchronoise' || $_POST['cattack'] == 'Volt Switch' || $_POST['cattack'] == 'Steel Wing' || $_POST['cattack'] == 'Luster Purge' || $_POST['cattack'] == 'Flame Burst' || $_POST['cattack'] == 'Chip Away' || $_POST['cattack'] == 'Secret Power' || $_POST['cattack'] == 'Facade' || $_POST['cattack'] == 'Power Gem' || $_POST['cattack'] == 'Vital Throw' || $_POST['cattack'] == 'Magnitude' || $_POST['cattack'] == 'Psycho Cut' || $_POST['cattack'] == 'Cross Poison' || $_POST['cattack'] == 'Shadow Claw' || $_POST['cattack'] == 'Slash' || $_POST['cattack'] == 'Retaliate' || $_POST['cattack'] == 'Dizzy Punch' || $_POST['cattack'] == 'Headbutt' || $_POST['cattack'] == 'Double Hit' || $_POST['cattack'] == 'Freeze-Dry' || $_POST['cattack'] == 'U-turn' || $_POST['cattack'] == 'Mist Ball' || $_POST['cattack'] == 'Night Slash')
	{
		$take_money = '52500';
	}

	if($_POST['cattack'] == 'Crush Claw' || $_POST['cattack'] == 'Brick Break' || $_POST['cattack'] == 'Air Slash' || $_POST['cattack'] == 'Thunder Punch' || $_POST['cattack'] == 'Drain Punch' || $_POST['cattack'] == 'Signal Beam' || $_POST['cattack'] == 'Ice Punch' || $_POST['cattack'] == 'Giga Drain' || $_POST['cattack'] == 'Rock Slide' || $_POST['cattack'] == 'Fire Punch' || $_POST['cattack'] == 'Relic Song' || $_POST['cattack'] == 'Icicle Spear' || $_POST['cattack'] == 'Razor Shell' || $_POST['cattack'] == 'Horn Leech')
	{
		$take_money = '56250';
	}

	if($_POST['cattack'] == 'Hyper Fang' || $_POST['cattack'] == 'Slam' || $_POST['cattack'] == 'Scald' || $_POST['cattack'] == 'Dark Pulse' || $_POST['cattack'] == 'Shadow Ball' || $_POST['cattack'] == 'Hyperspace Hole' || $_POST['cattack'] == 'Tri Attack' || $_POST['cattack'] == 'Crunch' || $_POST['cattack'] == 'Seed Bomb' || $_POST['cattack'] == 'Oblivion Wing' || $_POST['cattack'] == 'Iron Head' || $_POST['cattack'] == 'Zen Headbutt' || $_POST['cattack'] == 'Poison Jab' || $_POST['cattack'] == 'X-Scissor' || $_POST['cattack'] == 'Psyshock' || $_POST['cattack'] == 'Natural Gift' || $_POST['cattack'] == 'Waterfall' || $_POST['cattack'] == 'Mega Punch' || $_POST['cattack'] == 'Low Kick' || $_POST['cattack'] == 'Water Pledge' || $_POST['cattack'] == 'Dig' || $_POST['cattack'] == 'Lava Plume' || $_POST['cattack'] == 'Dazzling Gleam' || $_POST['cattack'] == 'Fire Pledge' || $_POST['cattack'] == 'Fiery Dance' || $_POST['cattack'] == 'Dragon Claw' || $_POST['cattack'] == 'Flash Cannon' || $_POST['cattack'] == 'Extreme Speed' || $_POST['cattack'] == 'Flying Press' || $_POST['cattack'] == 'Submission' || $_POST['cattack'] == 'Extrasensory' || $_POST['cattack'] == 'Drill Peck' || $_POST['cattack'] == 'Drill Run' || $_POST['cattack'] == 'Grass Pledge' || $_POST['cattack'] == 'Sucker Punch' || $_POST['cattack'] == 'Heat Crash' || $_POST['cattack'] == 'Dive' || $_POST['cattack'] == 'Discharge' || $_POST['cattack'] == 'Strength')
	{
		$take_money = '60000';
	}

	if($_POST['cattack'] == 'Blaze Kick' || $_POST['cattack'] == 'Bounce' || $_POST['cattack'] == 'Body Slam' || $_POST['cattack'] == 'Sky Uppercut' || $_POST['cattack'] == 'Night Daze' || $_POST['cattack'] == 'Secret Sword' || $_POST['cattack'] == 'Techno Blast (Electric)' || $_POST['cattack'] == 'Techno Blast (Normal)' || $_POST['cattack'] == 'Techno Blast (Aqua)' || $_POST['cattack'] == 'Techno Blast (Fire)' || $_POST['cattack'] == 'Techno Blast (Ice)' || $_POST['cattack'] == 'Icicle Crash')
	{
		$take_money = '63750';
	}

	if($_POST['cattack'] == 'Aura Sphere' || $_POST['cattack'] == 'Energy Ball' || $_POST['cattack'] == 'Phantom Force' || $_POST['cattack'] == 'Petal Blizzard' || $_POST['cattack'] == 'Aqua Tail' || $_POST['cattack'] == 'Muddy Water' || $_POST['cattack'] == 'Psychic' || $_POST['cattack'] == 'Super Fang' || $_POST['cattack'] == 'Attack Order' || $_POST['cattack'] == 'Play Rough' || $_POST['cattack'] == 'Wild Charge' || $_POST['cattack'] == 'Surf' || $_POST['cattack'] == 'Earth Power' || $_POST['cattack'] == 'Sludge Bomb' || $_POST['cattack'] == 'Thunderbolt' || $_POST['cattack'] == 'Hyper Voice' || $_POST['cattack'] == 'Ice Beam' || $_POST['cattack'] == 'Dragon Pulse' || $_POST['cattack'] == 'Take Down' || $_POST['cattack'] == 'Bug Buzz' || $_POST['cattack'] == 'Sacred Sword' || $_POST['cattack'] == 'Flamethrower' || $_POST['cattack'] == 'Rock Climb' || $_POST['cattack'] == 'Leaf Blade' || $_POST['cattack'] == 'Uproar' || $_POST['cattack'] == 'Fly' || $_POST['cattack'] == 'Lands Wrath')
	{
		$take_money = '67500';
	}

	if($_POST['cattack'] == 'Ice Ball' || $_POST['cattack'] == 'Sludge Wave' || $_POST['cattack'] == 'Moonblast' || $_POST['cattack'] == 'Foul Play')
	{
		$take_money = '71250';
	}

	if($_POST['cattack'] == 'Judgment (???)' || $_POST['cattack'] == 'Judgment (Bug)' || $_POST['cattack'] == 'Judgment (Dark)' || $_POST['cattack'] == 'Judgment (Dragon)' || $_POST['cattack'] == 'Judgment (Electric)' || $_POST['cattack'] == 'Judgment (Fairy)' || $_POST['cattack'] == 'Judgment (Fighting)' || $_POST['cattack'] == 'Judgment (Fire)' || $_POST['cattack'] == 'Judgment (Flying)' || $_POST['cattack'] == 'Judgment (Ghost)' || $_POST['cattack'] == 'Judgment (Grass)' || $_POST['cattack'] == 'Judgment (Ground)' || $_POST['cattack'] == 'Judgment (Ice)' || $_POST['cattack'] == 'Judgment (Normal)' || $_POST['cattack'] == 'Judgment (Poison)' || $_POST['cattack'] == 'Judgment (Psychic)' || $_POST['cattack'] == 'Judgment (Rock)' || $_POST['cattack'] == 'Judgment (Steel)' || $_POST['cattack'] == 'Judgment (Water)' || $_POST['cattack'] == 'Meteor Mash' || $_POST['cattack'] == 'Metal Burst' || $_POST['cattack'] == 'Skull Bash' || $_POST['cattack'] == 'Searing Shot' || $_POST['cattack'] == 'Sacred Fire' || $_POST['cattack'] == 'Iron Tail' || $_POST['cattack'] == 'Inferno' || $_POST['cattack'] == 'Egg Bomb' || $_POST['cattack'] == 'Jump Kick' || $_POST['cattack'] == 'Spit Up' || $_POST['cattack'] == 'Dream Eater' || $_POST['cattack'] == 'Cramhammer' || $_POST['cattack'] == 'Cross Chop' || $_POST['cattack'] == 'Diamond Storm' || $_POST['cattack'] == 'Stone Edge' || $_POST['cattack'] == 'Psystrike' || $_POST['cattack'] == 'Dragon Rush' || $_POST['cattack'] == 'Dynamicpunch' || $_POST['cattack'] == 'Earthquake' || $_POST['cattack'] == 'Electro Ball' || $_POST['cattack'] == 'Fusion Bolt' || $_POST['cattack'] == 'Fusion Flare' || $_POST['cattack'] == 'Heat Wave' || $_POST['cattack'] == 'Hammer Arm' || $_POST['cattack'] == 'Spacial Rend' || $_POST['cattack'] == 'Aeroblast' || $_POST['cattack'] == 'Wring Out' || $_POST['cattack'] == 'Future Sight' || $_POST['cattack'] == 'Grass Knot' || $_POST['cattack'] == 'Gear Grind')
	{
		$take_money = '75000';
	}

	if($_POST['cattack'] == 'Frustration' || $_POST['cattack'] == 'Return')
	{
		$take_money = '76500';
	}

	if($_POST['cattack'] == 'Fire Blast' || $_POST['cattack'] == 'Origin Pulse' || $_POST['cattack'] == 'Thunder' || $_POST['cattack'] == 'Blizzard' || $_POST['cattack'] == 'Steam Eruption' || $_POST['cattack'] == 'Acrobatics' || $_POST['cattack'] == 'Hydro Pump')
	{
		$take_money = '82500';
	}

	if($_POST['cattack'] == 'Double-Edge' || $_POST['cattack'] == 'Belch' || $_POST['cattack'] == 'Brave Bird' || $_POST['cattack'] == 'Heavy Slam' || $_POST['cattack'] == 'Magma Storm' || $_POST['cattack'] == 'Thrash' || $_POST['cattack'] == 'Mega Kick' || $_POST['cattack'] == 'Power Whip' || $_POST['cattack'] == 'Crush Grip' || $_POST['cattack'] == 'Close Combat' || $_POST['cattack'] == 'Outrage' || $_POST['cattack'] == 'Petal Dance' || $_POST['cattack'] == 'Volt Tackle' || $_POST['cattack'] == 'Zap Cannon' || $_POST['cattack'] == 'Wood Hammer' || $_POST['cattack'] == 'Flare Blitz' || $_POST['cattack'] == 'Shadow Force' || $_POST['cattack'] == 'Focus Blast' || $_POST['cattack'] == 'Gunk Shot' || $_POST['cattack'] == 'Hurricane' || $_POST['cattack'] == 'Frost Breath' || $_POST['cattack'] == 'Solar Beam' || $_POST['cattack'] == 'Seed Flare' || $_POST['cattack'] == 'Head Charge' || $_POST['cattack'] == 'Mega Horn' || $_POST['cattack'] == 'Superpower')
	{
		$take_money = '90000';
	}

	if($_POST['cattack'] == 'Overheat' || $_POST['cattack'] == 'Leaf Storm' || $_POST['cattack'] == 'Fling' || $_POST['cattack'] == 'Draco Meteor' || $_POST['cattack'] == 'High Jump Kick' || $_POST['cattack'] == 'Naughty List' || $_POST['cattack'] == 'Bolt Strike' || $_POST['cattack'] == 'Blue Flare' || $_POST['cattack'] == 'Nose Glow' || $_POST['cattack'] == 'Pumpkin Smash')
	{
		$take_money = '97500';
	}

	if($_POST['cattack'] == 'Freeze Shock' || $_POST['cattack'] == 'Precipice Blades' || $_POST['cattack'] == 'Sky Attack' || $_POST['cattack'] == 'Boom Burst' || $_POST['cattack'] == 'Last Resort' || $_POST['cattack'] == 'Psycho Boost' || $_POST['cattack'] == 'Final Gambit' || $_POST['cattack'] == 'Doom Desire' || $_POST['cattack'] == 'Ice Burn')
	{
		$take_money = '105000';
	}

	if($_POST['cattack'] == 'Giga Impact' || $_POST['cattack'] == 'Gyro Ball' || $_POST['cattack'] == 'Eruption' || $_POST['cattack'] == 'Roar of Time' || $_POST['cattack'] == 'Head Smash' || $_POST['cattack'] == 'Focus Punch' || $_POST['cattack'] == 'Frenzy Plant' || $_POST['cattack'] == 'Hydro Cannon' || $_POST['cattack'] == 'Rock Wrecker' || $_POST['cattack'] == 'Hyper Beam' || $_POST['cattack'] == 'Blast Burn' || $_POST['cattack'] == 'Flail' || $_POST['cattack'] == 'Water Spout')
	{
		$take_money = '112500';
	}

	if($_POST['cattack'] == 'V-create')
	{
		$take_money = '135000';
	}

	if($_POST['cattack'] == 'Self-Destruct' || $_POST['cattack'] == 'Trump Card' || $_POST['cattack'] == 'Reversal' || $_POST['cattack'] == 'Punishment' || $_POST['cattack'] == 'Dragon Ascent')
	{
		$take_money = '150000';
	}

	if($_POST['cattack'] == 'Explosion')
	{
		$take_money = '187500';
	}

	if($_POST['cattack'] == 'Horn Drill' || $_POST['cattack'] == 'Guillotine' || $_POST['cattack'] == 'Sheer Cold' || $_POST['cattack'] == 'Fissure')
	{
		$take_money = '225000';
	}

	if($take_money == '0'){
		header("location:change_attacks.php?pid={$pid}&error=2");
	}
	$mon = mysql_query("SELECT money FROM members WHERE id = '{$_SESSION['myid']}'");
	$mo = mysql_fetch_array($mon);
	$gmo = $mo['money'];
	if($take_money > $gmo){
		header("location:change_attacks.php?pid={$pid}&error=3");
	}

	if($_POST['cattack'] && $_POST['attack'] &&  $take_money < $gmo && $take_money > 0){
		$om = $gmo - $take_money;
		$do = mysql_query("UPDATE members SET money = '{$om}' WHERE id = '{$_SESSION['myid']}'");
		$at = mysql_real_escape_string($_POST['attack']);
		$q = mysql_query("UPDATE pokemon SET $at = '{$_POST['cattack']}' WHERE id = '$pid' AND owner = '{$_SESSION['myid']}'");
	
	
		if($q && $do){
			header("location:change_attacks.php?pid={$pid}&updated=1");
		}
	}
}
include('pv_disconnect_from_db.php'); ?>