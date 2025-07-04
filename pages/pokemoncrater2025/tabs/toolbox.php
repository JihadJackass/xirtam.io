<?php
include('/var/www/html/kick.php');
if($_SESSION['access'] == 9){ // Check the user is logged in
	include('/var/www/html/pv_connect_to_db.php');


		// MESSAGE NOTIFICATIONS //
	
	if($_REQUEST['notify'] == 'show'){
		if($_SESSION['message_preferences'][0]=='0'){
			
			$get = mysql_query("SELECT * FROM message_notify WHERE id = '{$_SESSION['myid']}'");
			if(mysql_num_rows($get) > 0){
				$c = mysql_fetch_array($get);
				echo "You have just received a new message From <a href=\"/members.php?uid=". $c['sid'] ."\" onclick=\"membersTab('uid=". $c['sid'] ."', 1); return false;\">". $c['suser'] ."</a>. Subject is <a href=\"/messages.php\">". $c['subject'] ."</a>.";
			}
			else{
				echo '1';
			}
		}
	}
	else{
		mysql_query("DELETE FROM message_notify WHERE id = '{$_SESSION['myid']}'");
	}
}
include('/var/www/html/pv_disconnect_from_db.php');
?>
