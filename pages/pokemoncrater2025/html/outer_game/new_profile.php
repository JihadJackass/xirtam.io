<html lang="eng">
<head>
<script src="http://code.jquery.com/jquery-1.10.1.min.js" ></script>
<script src="popup.js"></script>
<style type="text/css">
*
{
	margin: 0;
	padding: 0;
}

html,body
{
	font-family: Verdana,Arial,Helvetica,sans-serif;
	font-size: 11px;
	font-weight: normal;
}

table
{
	font-size: 11px;
	text-align: center;
}

ul,li
{
	list-style-type: none;
}

h4
{
	font-weight: normal;
	padding: 10px;
}

a:link, a:visited
{
	color: #000000;
	text-decoration: none;
}

a:active,a:hover
{
	color: #000000;
	text-decoration: underline;
}

a:focus
{
	-moz-outline: none;
	outline: none;
}

a:hover.profile
{
	color: #FFF;
	text-decoration: underline;
	background-color: #383838;
	padding: 5px;
}

#head
{
	color: #FFF;
	text-align: center;
	background-color: #1a1a1a;
	border: 1px solid #000;
	margin-bottom: 5px;
	padding: 2px;
}

.ava,#info
{
	background-color: #dbdbdb;
	border: 2px solid #cfcfcf;
}

input,textarea
{
	background-color: #FFF;
	border: 1px solid #cfcfcf;
	padding: 5px;
}

.red
{
	color: #ff0034;
}

#element_to_pop_up
{
	background-color:#fff;
	border-radius:15px;
	color:#000;
	display:none;
	padding:20px;
	width:600px;
	height:400px;
	overflow-y:scroll;
}

.b-close{
	cursor:pointer;
	position:absolute;
	right:10px;
	top:5px;
}
</style>
</head>
<body>
<center>
<h1 style="padding: 20px;">Your Profile</h1>
<!-- Profile Information -->
<table cellspacing="20" cellpadding="0">
	<tr>
		<!-- Avatar -->
		<td>
		<h4>(<a href="#" id="pop-up">Change Avatar</a>)</h4>
        <div id="element_to_pop_up">
        <a class="b-close"><img src="html/static/images/close.gif"></a>
        <?php include('change_avatar.php'); ?>
        </div>
		<img class="ava" src="images/11.gif" />
		</td>
		<!-- Player Info -->
		<td style="text-align: left;">
		<h2 id="head">x</h2>
		<ul>
			<li><font class="red">x</font> Wins and <font class="red">x</font> Losses</li>
			<li><font class="red">x</font> Points</li>
			<li><font class="red">x</font> out of <font class="red">x</font> Unique Pok&eacute;mon</li>
			<li><font class="red">x</font> Total Experience</li>
			<li><font class="red">x</font> Average Experience</font></li>
			<li><img src="html/static/images/misc/pmoney.gif" /><font class="red">x</font> Pok&eacute;dollar(s)</li>
			<li>Joined <font class="red">x</font></li>
		</ul>
		</td>
		<!-- Clan Info -->
		<td style="text-align: left;">
		<h2 id="head" style="margin-top: -25px;">Clan</h2>
		<ul>
			<li>You are a <font class="red">x</font></li>
			<li><font class="red">x</font> in your ranks</li>
			<li><font class="red">x</font> Points</li>
			<li><font class="red">x</font> Experience</li>
			<li><font class="red">x</font> Wins and <font class="red">x</font> Losses</li>
		</ul>
		</td>
		<!-- Contact Info -->
		<td>
		<h2 id="head" style="margin-top: -18px;">Contact (x)</h2>
		<ul>
			<li><b>Email:</b> x</li>
			<li><b>Skype:</b> x</li>
			<li><b>Forums:</b> x</li>
		</ul>
		<h4>(<a href="#">Edit Profile</a>)</h4>
		</td>
	</tr>
</table>
<!-- Comments and Account Settings (HEADERS) -->
<table cellspacing="20" cellpadding="0">
	<tr>
		<!-- Comments (HEADER) -->
		<td id="head" style="font-size: 18px; font-weight: bold; width: 448px;">Comments</td>
		<!-- Account Settings (HEADER) -->
		<td id="head" style="font-size: 18px; font-weight: bold; width: 322px;">Account Settings</td>
	</tr>
</table>
<!-- Comments and Account Settings -->
<table cellspacing="20" cellpadding="0" style="margin-top: -35px;">
	<tr>
		<!-- Comments -->
		<td id="info" style="width: 450px;">
		<h4><i>Other players will be able to read what you type by viewing your profile.</i></h4>
		<textarea cols="56" rows="10">xxxxxxxxxx</textarea><br /><br />
		<input type="submit" value="Update" /><br /><br />
		</td>
		<!-- Account Settings -->
		<td id="info" style="width: 325px;">
		<h4 style="font-weight: bold; margin-top: -15px;">Allow Messages</h4>
		<a class="profile" href="#" style="padding: 5px;">On</a> / <a class="profile" href="#" style="padding: 5px;">Off</a>
		<h4><i>Disabling this will stop all messages received.</i></h4>
		<h4 style="font-weight: bold;">Show Message Notifications</h4>
		<a class="profile" href="#" style="padding: 5px;">On</a> / <a class="profile" href="#" style="padding: 5px;">Off</a>
		<h4><i>Turning this off will stop all notifications received.</i></h4>
		<h4 style="font-weight: bold;">Layout (Pick a color)</h4>
		<a class="profile" href="#" style="padding: 5px;">Blue</a> / <a class="profile" href="#" style="padding: 5px;">Red</a> / <a class="profile" href="#" style="padding: 5px;">Black</a>
		</td>
	</tr>
</table>
<!-- Checks to see if they can find legendaries or not -->
<h1 class="red">X</h1>
<!-- Badge display -->
</center>
</body>
</html>