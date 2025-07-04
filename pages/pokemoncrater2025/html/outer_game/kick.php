<?php

/* $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$webos = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$wii = strpos($_SERVER['HTTP_USER_AGENT'],"Wii");
$psp = strpos($_SERVER['HTTP_USER_AGENT'],"PSP");
$ps3 = strpos($_SERVER['HTTP_USER_AGENT'],"PLAYSTATION 3");

if ($iphone || $android || $webos || $ipod || $berry || $wii || $psp || $ps3 == true) 
{ 
  header('Location: http://sigma.pokemon-shqipe.co.uk/mobile/');
}
 */
session_start();
header('location: http://www.pokemon-shqipe.co.uk/login.php');
exit();
?>