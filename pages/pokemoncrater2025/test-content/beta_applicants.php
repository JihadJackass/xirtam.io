<?php
include('pv_connect_to_db.php');
function checkNum($number){
	return ($number%2) ? TRUE : FALSE;
}
if($_POST['delete'] && is_numeric($_POST['deleteid'])){
	$del = mysql_query("DELETE FROM beta_test WHERE id = '{$_POST['deleteid']}'");
	if($del){
		echo '<strong>Application deleted, they obviously never stood a chance</strong>';
	}
}
//----------------------------------------------DISPLAY----------------------------------------------------------//
		echo '
		<div class="list autowidth" style="width:90%">
		<table style="width: 100%;" border="1" cellpadding="3" cellspacing="0">
		<tbody><tr>
		<th>ID</th>
		<th>Username</th>
		<th>Forum Name</th>
		<th>Active?</th>
		<th>Weekly Play Time</th>
		<th>No. Of Accounts</th>
		<th>Age</th>
		<th>Reason</th>
		<th>Prev. Beta Tester?</th>
		<th>Games</th>
		<th>Contact</th>
		</tr>';
		if(is_numeric($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		}

		
		$number = 0;
		$gcm = mysql_query("SELECT * FROM beta_test WHERE id > 0  ORDER BY RAND() LIMIT 1");
		$countt = mysql_query("SELECT * FROM beta_test");
		$count = mysql_num_rows($countt);
		while($gm = mysql_fetch_array($gcm)){
			$i = 1;
			$number += $i;
			if(checkNum($number) === TRUE){
				$class = 'dark';
			}
			else{
				$class = 'light';
			}
			echo '<tr class="' . $class . '" nowrap="nowrap"><td style="text-align: left;">' . $gm['id'] . '</td><td>' . $gm['username'] . '</td><td>' . $gm['forum_name'] . '</td><td>' . $gm['active'] . '</td><td>' . $gm['play_time'] . '</td><td>' . $gm['account_count'] . '</td><td>' . $gm['age'] . '</td><td>' . $gm['reason'] . '</td><td>' . $gm['previous'] . '</td><td>' . $gm['games'] . '</td><td>' . $gm['email'] . '</td></tr>';
			echo '<form action="beta_applicants.php" id="action" method="post" onsubmit="get(\'beta_applicants.php\', \'\', this); disableSubmitButton(this); return false;"><input type="hidden" name="deleteid" id="deleteid" value="' . $gm['id'] . '" /><input type="hidden" name="delete" id="delete" value="delete" /><input type="submit" name="submit" value="Delete" /></form>';

		}
		echo '</table></div></p><br /><strong>If you find an application worth keeping, screenshot or c/p all the info then delete it anyway.<br />Just keep a list of worthy applicants and we\'ll go through the list again after narrowing it down to a shorter list.</strong><br /><br /><br />There are ' . number_format($count) . ' applications left.';
?>

