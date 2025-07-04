<?php
setcookie("regg", 1, time()-3600);
setcookie("reggg", 1, time()-3600);
session_start();
session_destroy();
session_unset(); 
$ip = $_SERVER['REMOTE_ADDR'];
$DOWN_FOR_MAINTANCE = 0;
?>
<html>
<head></head>
<body>

			<?php
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Banned'){
				echo '<center><div class="errorMsg">This account has been banned by Pok&eacute;mon Shqipe</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ServerDown'){
				echo '<center><div class="errorMsg">The <b>Server</b> is currently down due to maintenance. Sorry for any inconvenience.</div></center>';
			}
			if(isset($_REQUEST['c'])){ 
				echo '<center><div class="actionMsg">Your password has been successfully changed, you may now login.</div></center>'; 
			}
			if(isset($_REQUEST['reg'])){ 
				echo '<center><div class="actionMsg">You are now registered and may login.</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Logout'){ 
				echo '<center><div class="actionMsg">You are now logged out.</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Attempts'){ 
				echo '<center><div class="errorMsg">Error: Too many incorrect guesses. The account is locked for 30 mins</div></center>';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Error'){ 
				if($_REQUEST['type'] == 'User_Pass'){
					echo '<center><div class="errorMsg">Username or Password you entered is incorrect.</div></center>';
				}
			}
			if(isset($_REQUEST['goawayxP'])){ 
				echo '<div class="errorMsg"><center>Your session has expired.</center></div>';
			}
			if($DOWN_FOR_MAINTANCE == 1){
				echo '<div style="text-align: center; margin: 0 auto;"><img src="http://static.pokemon-vortex.com/images/maintenance.png"></div><br/><div class="errorMsg"><center>Shqipe Battle Arena is down for maintenance and will be back up as soon as possible.<br/>Please refrain from asking questions about it on our <a href="http://facebook.com/pokemonshqipe" target="_BLANK">Facebook</a>, <a href="http://pokemon-shqipe.co.uk/chat/" target="_BLANK">Chatroom</a> and <a href="http://twitter.com/Pokemon_Shqipe" target="_BLANK">Twitter</a>.<br/> Thank you for your patience.</center></div>';
			}
			else{
				$actions = array('checklogin.php', 'checklogin.php'); 
				$which = rand(0,1); 
			?> 
			<form method="post" action="<?php echo $actions[$which]; ?>"><div style="text-align: center; margin: 0 auto;">	
<div class="errorMsg"><center>You must <a href="/signup">create a new account</a> to use v3 of Pok&eacute;mon Vortex even if you previously had an account in <a href="http://pokemon-shqipe.co.uk">v2</a>.<br />You cannot yet create accounts for v3 as it is not complete.<br />Follow us on <a href="http://facebook.com/pokemonshqipe">Facebook</a> to be notified when v3 is complete and ready for sign-ups.</center></div>
<h2 style="margin-top: 25px;">Enter your username and password to login:</h2>
		    <table border="0" cellspacing="0" cellpadding="4" style="margin: 0 auto 0 auto; text-align: left;">
              <tr><?php if(isset($_REQUEST['goo']) && $_REQUEST['goo'] == 1){ ?><input type="hidden" name="this" value="1" /><?php } ?>
                <td style="text-align: right;" valign="middle">Username:</td>
                <td><input name="myusername" type="text" id="myusername"<?php if(isset($_COOKIE['UCookie'])){ echo " value=\"{$_COOKIE['UCookie']}\""; } ?> /></td>
              </tr>
              <tr>
                <td style="text-align: right;" valign="middle">Password:</td>
                <td><input name="mypassword" type="password" id="mypassword"<?php if(isset($_COOKIE['PCookie'])){ echo " value=\"{$_COOKIE['PCookie']}\""; } ?>></td>
              </tr>
 <tr style="text-align: center;" valign="middle">
                <td colspan="2"></td>
              </tr>
              <tr style="text-align: center;" valign="middle">
                <td colspan="2"><input type="submit" name="Submit" value="Log in" onclick="this.disabled = true; this.value = 'Logging In...'; this.form.submit();">
				</td>
              </tr>
              <tr style="text-align: center;" valign="middle">
                <td colspan="2"><a href="about">Having trouble logging in?</a> | <a href="forgot_password">Forgot your password?</a> | <a href="http://pokemon-shqipe.co.uk/">Version 2</a></td>
              </tr>
            </table></div></form>
		<?php } ?>
<div class="noticeMsg"><strong>Notice:</strong> <em>Do not give your password to anyone else under any circumstances.</em><br />pokemon-shqipe.co.uk representatives will <strong>never</strong> ask for your password and you should <strong>never</strong> give it to anyone who does ask for it.</div><br />
</body>
</html>