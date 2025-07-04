<!DOCTYPE html>
<html>

<head><meta charset="UTF-8">
	<title>Pok&eacute;mon Vortex - Mobile</title>
	<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" />
	<meta name="viewport" content="width=device-width, initial-scale=0.85">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
	<link rel="stylesheet" href="assets/css/style.css" />
	<link rel="stylesheet" href="assets/css/carousel.css">
	<link rel="stylesheet" href="assets/css/theme.css">
	<link rel="stylesheet" href="assets/css/photoswipe.css">
	<style>
		.accent-color, .owl-theme .owl-controlls .owl-page span, .ui-btn-active {
			background: #666666!important;
		}
		.ui-checkbox-on .ui-icon, .ui-radio-on .ui-icon {
			background-color: #666666!important;
		}
		.svg-accent {
			fill: #666666!important;
		}
		.ui-btn-active {
			box-shadow: inset 0px 0px 3px #666666, 0px 0px 9px #666666!important;
			border: none!important;
		}
		.ui-focus, .ui-btn:focus { 
			box-shadow: inset 0px 0px 3px #666666, 0px 0px 9px #666666!important;
		}
	</style>
	<script type="text/javascript" src="assets/js/klass.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	<script type="text/javascript" src="assets/js/jstorage.js"></script>
	<script type="text/javascript" src="assets/js/carousel.min.js"></script>
	<script type="text/javascript" src="assets/js/code.photoswipe.jquery-3.0.5.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function () {
			// New Items Counter START
			var headerCount = 0;
			jQuery('.countable').each(function () {
				var itemId = jQuery(this).attr('id');
				var itemsCount = jQuery(this).find('a').attr('data-count');
				var itemsCount = parseInt(itemsCount, 10);
				var storageValue = jQuery.jStorage.get(itemId); // Check if "storageValue" exists in the storage
				if(!storageValue){ // if not - assign current number of items
					storageValue = itemsCount;
					jQuery.jStorage.set(itemId,storageValue, {TTL: 86400000}); // and save it
				}
				var diff = itemsCount-storageValue;
				if (diff > 0) {
					jQuery(this).find('.ui-li-count').html(diff).removeClass('hidden');
				}else if (diff < 0) {
					jQuery.jStorage.set(itemId,itemsCount, {TTL: 86400000}); // reset value if items have been removed
				}
				headerCount = headerCount+diff;
			});
			if (headerCount > 0) {
				jQuery('.counter-header').html(headerCount).removeClass('hidden');
			}
			jQuery('.countable').on('click', function() {
				var strKey = jQuery(this).attr('id');
				var strValue = jQuery(this).find('a').attr('data-count');
				jQuery.jStorage.set(strKey,strValue, {TTL: 86400000}); // null the counter
			});
			// New Items Counter END
		});
	</script>
	<script src="assets/js/custom.js"></script>
</head>
<body>

<div data-role="page" id="home">
	<div style="position: fixed; top: 0px;" data-role="panel" data-position="left" data-theme="a" data-display="push" id="left_panel">
	<ul data-role="listview" data-inset="false" data-theme="a">
		<li><div style="text-align: center;"><img src="assets/img/logo.png" alt="Logo"></div></li>
		<li><a data-transition="slide" href="index.php"><img src="assets/img/menu-icons/home.png" alt="Home" class="ui-li-icon">Home</a></li>
		<li data-role="collapsible" data-inset="false" data-theme="a" data-content-theme="c" data-iconpos="right">
			<h4>Game</h4>
			<ul data-role="listview" data-inset="false" data-theme="c">
				<li><a data-transition="slide" href="login.php"><img src="assets/img/menu-icons/key-c.png" alt="Admin" class="ui-li-icon">Log In</a></li>
				<li><a data-transition="slide" href="signup.php"><img src="assets/img/menu-icons/key-c.png" alt="Admin" class="ui-li-icon">Register</a></li>
			</ul>
		</li>
		<li id="menu_news" class="countable"><a data-transition="slide" data-count="3" href="news.php"><img src="assets/img/menu-icons/news.png" alt="News" class="ui-li-icon">News<span class="ui-li-count hidden accent-color"></span></a></li>
		<li id="menu_recipes" class="countable"><a data-transition="slide" data-count="2" href="contact.php"><img src="assets/img/menu-icons/star.png" alt="Contact Us" class="ui-li-icon">Contact Us<span class="ui-li-count hidden accent-color"></span></a></li>
		<li id="menu_blog" class="countable"><a data-transition="slide" data-count="3" href="about.php"><img src="assets/img/menu-icons/star.png" alt="FAQ" class="ui-li-icon">FAQ<span class="ui-li-count hidden accent-color"></span></a></li>
		<li id="menu_gallery" class="countable"><a data-transition="slide" data-count="0" href="http://forums.pokemon-vortex.com"><img src="assets/img/menu-icons/star.png" alt="Forums" class="ui-li-icon">Forums<span class="ui-li-count hidden accent-color"></span></a></li>
	</ul>
	<div style="position: relative; top: 15px;">
		<p>Socialize</p>
		<a href="http://mobile.twitter.com/Pokemon_Vortex" target="_BLANK"><img src="assets/img/panel/twitter.png" alt="Twitter"></a>
		<a href="http://m.facebook.com/pokemonvortex" target="_BLANK"><img src="assets/img/panel/facebook.png" alt="Facebook"></a>
		<a href="http://m.plus.google.com/+pokemonvortex" target="_BLANK"><img src="assets/img/panel/google.png" alt="Google+"></a>
		<a href="http://m.youtube.com/channel/UChOoUK9yE25rdeVubXY7kcQ" target="_BLANK"><img src="assets/img/panel/youtube.png" alt="YouTube"></a>
	</div>
</div>
<div style="position: fixed; top: 0px;" data-role="panel" data-theme="a" data-position="right" data-display="push" id="right_panel">
	<div style="text-align: center;">
		<h4 style="margin-top: 0px;">Share this page on:</h4>
		<div class="panel-social-wrap">
			<a title="Share link on Facebook" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fpokemon-vortex.com%2Findex.php" rel="nofollow">
				<div class="panel-social panel-social-twitter accent-color">
					<img src="assets/img/facebook.png" alt="Facebook">
				</div>
			</a>
			<div class="panel-social-counter">0</div>
		</div>
		<div class="panel-social-wrap">
			<a title="Share link on Twitter" target="_blank" href="http://twitter.com/intent/tweet?text=Check%20out%20&amp;url=http%3A%2F%2Fpokemon-vortex.com%2Findex.php" >
				<div class="panel-social panel-social-facebook accent-color">
					<img src="assets/img/twitter.png" alt="Twitter">
				</div>
			</a>
			<div class="panel-social-counter">0</div>
		</div>
		<div class="panel-social-wrap">
			<a title="Share link on Google+" target="_blank" href="https://plus.google.com/share?url=http%3A%2F%2Fpokemon-vortex.com%2Findex.php" rel="nofollow">
				<div class="panel-social panel-social-google accent-color">
					<img src="assets/img/google.png" alt="Google+">
				</div>
			</a>
			<div class="panel-social-counter">0</div>
		</div>
	</div>
</div>	<div id="header" data-role="header" data-position="fixed" data-theme="c">
		<div class="header_wrapper">
			<a style="border-left: none;" class="header_button" href="#left_panel" data-inline="true" data-role="button" data-corners="false" data-theme="c">
				<img class="header-btn-image" style="width: 100%; height: 100%;" src="assets/img/menu.png" alt="Menu">
				<span class="menu-btn-background"></span>
				<span class="counter-header hidden accent-color" style="color: #ffffff;"></span>
			</a>
			<span class="page_title">Home</span>
			<a style="float: right; border: none;" class="header_button" href="#" data-inline="true" data-rel="back" data-role="button" data-corners="false" data-theme="c">
				<img style="width: 100%; height: 100%;" src="assets/img/back.png" alt="Back">
				<span class="btn-background"></span>
			</a>
			<a style="float: right;" class="header_button" href="#right_panel" data-inline="true" data-role="button" data-corners="false" data-theme="c">
				<img style="width: 100%; height: 100%;" src="assets/img/share.png" alt="Share">
				<span class="btn-background share-btn-background"></span>
			</a>
			<div style="clear: both"></div>
		</div>
	</div><!-- /header -->
	<div id="homepage_content" data-role="content">
		<div class="page-tagline">
			<img src="assets/img/logo.png" alt="Logo">
		</div>



NEEEEEEEEEEEEEEWS




		</div>
			<div>
					<h6 class="footer-text">&copy; 2008 Pok&eacute;mon Vortex</h6>
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
		<script type="text/javascript" src="assets/js/retina-1.1.0.js"></script>
	</body>
</html>