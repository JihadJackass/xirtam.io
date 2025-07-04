<!DOCTYPE html>
<html>
<head>
<style>
#getPkmn {
	width: 300px;
	height: 151px;
	font-family: Helvetica, Arial, sans-serif;
	background-image: url('http://static.pokemon-vortex.com/images/Pokeball.PNG');
	background-repeat:no-repeat;
}
</style>
<script src="http://code.jquery.com/jquery-1.11.1.min.js" ></script>
<script type="text/javascript">
function updatePkmn() {
	var url="feed.php";
	jQuery("#getPkmn").load(url).hide().fadeIn(3000);
}
setInterval("updatePkmn()", 5000);
</script>
</head>
<body>
<p /><div id="getPkmn"></div>
</body>
</html>