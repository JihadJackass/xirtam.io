<?php include('/var/www/html/pv_connect_to_db.php'); ?>
<html>
<head>
<title>Add BETA Emails</title>
</head>
<body>
<?php
if($_POST['add']){
	$num = rand(48,923876347264423);
	$code = md5($num);
	$add_email = mysql_query("INSERT INTO beta_emails (email) VALUES ('{$_POST['email']}')");
	$add_code = mysql_query("INSERT INTO beta_codes (code) VALUES ('$code')");
	if($add_email && $add_code){
		echo '<center><div style="border: 1px dotted;">Email successfully added.</div></center><br />';
	}
	else{
		echo '<center><div style="border: 1px dotted;">AN ERROR OCCURRED, PLEASE TRY AGAIN!</div></center><br />';
	}
}
?>
<form method="post">
<table border="1" cellspacing="2" cellpadding="2" style="margin: 0 auto 0 auto; text-align: left;">
<tr><td style="text-align: right;" valign="middle">Email:</td> <td><input type="text" name="email" value=""></td></tr><br/>
<tr style="text-align: center;" valign="middle">
<td colspan="2"><input type="submit" name="add" value="Add"></td></tr></form></table>
</body>
</html>