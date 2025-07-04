<?php include ('/var/www/html/pv_connect_to_db.php'); ?>
<html>
<head>
<title>Email a BETA applicant</title>
</head>
<body>
<?php
if($_POST['email']){
	$get_email = mysql_fetch_array(mysql_query("SELECT * FROM beta_emails ORDER BY RAND() LIMIT 1"));
	$get_code = mysql_fetch_array(mysql_query("SELECT * FROM beta_codes ORDER BY RAND() LIMIT 1"));
	if($get_email && $get_code){
		$to = $get_email['email'];
		$code = $get_code['code'];
		$subject = "Pokemon Vortex v3 BETA";
		$message = "Hello,

It is our great pleasure to inform you about your invitation to the closed BETA of Pokémon Vortex v3.

You can follow this link to get started:
http://v3.pokemon-vortex.com/beta_signups?id={$code}

This link can only be used once so please complete the entire registration process once you've started.
Please note the following:
We reserve the right to remove, wipe or ban your BETA account for violating our terms of service.
All BETA accounts will be deleted once the testing is over and we prepare for the full, public v3 release.
If you wish to give your BETA signup code to someone else if, for example, you don't have time to join us for it - You may do so. All we ask is you give it to a responsible person who would be of value to us and the other BETA testers. After all, you were hand picked for your application.
If you need to contact us during the BETA for any reason, all of our contact methods are on the in-game dashboard, please do not reply to this message as it will not get read.

SO, that being said, welcome to v3 of Pokémon Vortex - We hope you enjoy it.

Patrick,
Pokémon Vortex Administrator.";
		$headers = "From: v3@pokemon-vortex.com";
		mail($to,$subject,$message,$headers);
		$mail = done;
		if($mail){
			echo '<center><div style="border: 1px dotted;">Email successfully sent.</div></center><br />';
			mysql_query("DELETE FROM beta_emails WHERE email = '$to'");
		}
		else{
			echo '<center><div style="border: 1px dotted;">Email failed to send.</div></center><br />';
		}
	}
	else{
		echo '<center><div style="border: 1px dotted;">Error getting beta code or email.</div></center><br />';
	}
}
?>
<form method="post">
<table border="1" cellspacing="2" cellpadding="2" style="margin: 0 auto 0 auto; text-align: left;">
<tr style="text-align: center;" valign="middle">
<td colspan="2"><input type="submit" name="email" value="Email"></td></tr></form></table>
</body>
</html>

