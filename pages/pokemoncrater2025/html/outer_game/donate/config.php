<?php
// Fill your PayPal email below.
// This is where you will receive the donations.

$myPayPalEmail = '';


// The paypal URL:
$payPalURL = '';


// Your goal in USD:
$goal = 1000;


// Demo mode is set - set it to false to enable donations.
// When enabled PayPal is bypassed.

$demoMode = false;

if($demoMode)
{
	$payPalURL = 'demo_mode.php';
}
?>