<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Advanced Warfare Recovery Services</title>
  <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
  <link href="http://advancedwarfarerecovery.com/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="http://advancedwarfarerecovery.com/css/flexslider.css" rel="stylesheet" >
  <link href="http://advancedwarfarerecovery.com/css/styles.css" rel="stylesheet">
  <link href="http://advancedwarfarerecovery.com/css/queries.css" rel="stylesheet">
  <link href="http://advancedwarfarerecovery.com/css/animate.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body id="top">
<header id="home">
<nav>
<div class="container-fluid">
<div class="row">
<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
<nav class="pull">
<ul class="top-nav">
<li><a href="#intro">Form<span class="indicator"><i class="fa fa-angle-right"></i></span></a></li>
</ul>
</nav>
</div>
</div>
</div>
</nav>
<section class="hero" id="hero">
<div class="container">
<div class="row">
<div class="col-md-12 text-right navicon"> <a id="nav-toggle" class="nav_slide_button" href="#"><span></span></a> </div>
</div>
<div class="row">
<div class="col-md-8 col-md-offset-2 text-center inner"> <img src="http://advancedwarfarerecovery.com/img/Logo.jpg" class="img-polaroid">
<h1 class="animated fadeInDown">RECOVERY SERVICES</span></h1>
<p class="animated fadeInUp 
</div>
</div>
<div class="row">
<div class="col-md-6 col-md-offset-3 text-center">
</div>
</div>
</div>
</section>
</header>
<section class="intro text-center section-padding" id="intro">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2 wp1">
<h1 class="animated fadeInDown">THANK YOU FOR PURCHASING</span></h1>
<h1 class="arrow">Lieutenant Package</h1>

<p>Thank you for purchasing from AdvancedWarfareRecovery.com! We'd like you to fill in the form so that our staff can complete your account as soon as possible!

If there are any problems or doubts, feel free to contact us. </p>
</div>
</div>
<?php
if ($_POST["submit"]) { // Once the form has been submitted
	// Protect the data in case it is later inserted into a database
	$name = mysql_real_escape_string($_POST['name']);
	$email = mysql_real_escape_string($_POST['email']);
	$message = mysql_real_escape_string($_POST['message']);
	$human = intval($_POST['human']);
	$order_id = mysql_real_escape_string($_POST['order_id']);
	$prestige = mysql_real_escape_string($_POST['prestige']);
	$rank = mysql_real_escape_string($_POST['rank']);
	$royalty_camo = mysql_real_escape_string($_POST['royalty_camo']);
	$stats = mysql_real_escape_string($_POST['stats']);
	$colored_classes = mysql_real_escape_string($_POST['colored_classes']);
	$elite_weapons = mysql_real_escape_string($_POST['elite_weapons']);
	$gmr_gear = mysql_real_escape_string($_POST['gmr_gear']);
	$from = 'Advanced Warfare Recovery Service';
	$to = 'iHaxel@mail.com'; 
	$subject = 'Lieutenant Package';

	$body = '<b>From:</b> ' . $name . '\n
			<br /><b>E-Mail:</b> ' . $email . '\n
			<br /><b>Message:</b> ' . $message . '\n
			<br /><b>Order ID:</b> ' . $order_id . '\n
			<br /><b>Prestige:</b> ' . $prestige . '
			<br /><b>Rank:</b> ' . $rank . '\n
			<br /><b>Royalty Camo:</b> ' . $royalty_camo . '\n
			<br /><b>Stats:</b> ' . $stats . '\n
			<br /><b>Colored Classes:</b> ' . $colored_classes . '\n
			<br /><b>Elite Weapons:</b> ' . $elite_weapons . '\n
			<br /><b>Grand Master Royalty Gear:</b> ' . $gmr_gear . '\n';
	// Check if name has been entered
	if (!$_POST['name']) {
		$errName = 'Please enter your name';
	}

	// Check if email has been entered and is valid
	if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errEmail = 'Please enter a valid email address';
	}
	
	// Check if the order ID has been entered
	if(!$_POST['order_id']){
		$errID = 'Please enter the order ID you were given by e-junkie';
	}
	
	// Check if the Prestige has been entered
	if(!$_POST['prestige']){
		$errPrestige = 'Please enter a Prestige level';
	}
	
	// Check if the rank has been entered
	if(!$_POST['rank']){
		$errRank = 'Please enter a rank';
	}
	
	// Check if the Royalty Camo was chosen
	if(!$_POST['royalty_camo']){
		$errCamo = 'Please Select if you would like Royalty Camo';
	}
	
	// Check if stats has been entered
	if(!$_POST['stats']){
		$errStats = 'Please enter what stats you would like';
	}
	
	// Check if colored classes has been entered
	if(!$_POST['colored_classes']){
		$errColoredclasses = 'Please enter Colored Classes';
	}
	
	// Check if elite weapons has been selected
	if(!$_POST['elite_weapons']){
		$errEliteweapons = 'Please choose if you would like Elite Weapons';
	}
	
	// Check if grand master royalty gear has been selected
	if(!$_POST['gmr_gear']){
		$errGmrgear = 'Please choose if you would like Grand Master Royalty Gear';
	}

	// Check if simple anti-bot test is correct
	if ($human !== 5) {
		$errHuman = 'Your anti-spam is incorrect';
	}
	
	// If there are no errors, send the email
	if (!$errName && !$errEmail && !$errHuman && !$errID && !$errPrestige && !$errRank && !$errCamo && !$errStats && !$errColoredclasses && !$errEliteweapons && !$errGmrgear) {
		$mail = mail($to, $subject, $body, $from);
		if ($mail) {
			$result='<div class="alert alert-success">Thank You! I will be in touch</div>';
		}
		else{
			$result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
		}
	}
}
?>
<center>
<form class="form-horizontal" role="form" method="post" action="checkout.php" style="width:70%;">
<h1 class="arrow">Form</h1>
<p>Fields marked with <font color="red">*</font> are required.</p><br />

  <div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
	  <?php echo $result; ?>	
    </div>
  </div>

  <div class="form-group">
    <label for="name" class="col-sm-2 control-label">Name<font color="red"> *</font></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php echo htmlspecialchars($_POST['name']); ?>">
	  <?php echo "<p class='text-danger'>$errName</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Email<font color="red"> *</font></label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo htmlspecialchars($_POST['email']); ?>">
	  <?php echo "<p class='text-danger'>$errEmail</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Order ID<font color="red"> *</font></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Order ID given by e-junkie" value="<?php echo htmlspecialchars($_POST['order_id']); ?>">
	  <?php echo "<p class='text-danger'>$errID</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Prestige<font color="red"> *</font></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="prestige" name="prestige" placeholder="Prestige Level" value="<?php echo htmlspecialchars($_POST['prestige']); ?>">
	  <?php echo "<p class='text-danger'>$errPrestige</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Rank<font color="red"> *</font></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="rank" name="rank" placeholder="Rank" value="<?php echo htmlspecialchars($_POST['rank']); ?>">
	  <?php echo "<p class='text-danger'>$errRank</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Royalty Camo<font color="red"> *</font></label>
    <div class="col-sm-10">
      <select name="royalty_camo" class="form-control" id="royalty_camo">
        <option value="" selected>Please Choose</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
      </select>
	  <?php echo "<p class='text-danger'>$errCamo</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Stats<font color="red"> *</font></label>
    <div class="col-sm-10">
      <select name="stats" class="form-control" id="stats">
        <option value="" selected>Please Choose</option>
        <option value="Yes">Legit</option>
        <option value="No">Low</option>
        <option value="High">High</option>
      </select>
	  <?php echo "<p class='text-danger'>$errStats</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Colored Classes<font color="red"> *</font></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="colored_classes" name="colored_classes" placeholder="Colored Classes" value="<?php echo htmlspecialchars($_POST['colored_classes']); ?>">
	  <?php echo "<p class='text-danger'>$errColoredclasses</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Elite Weapons<font color="red"> *</font></label>
    <div class="col-sm-10">
      <select name="elite_weapons" class="form-control" id="elite_weapons">
        <option value="" selected>Please Choose</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
      </select>
	  <?php echo "<p class='text-danger'>$errEliteweapons</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Grand Master Royalty Gear<font color="red"> *</font></label>
    <div class="col-sm-10">
      <select name="gmr_gear" class="form-control" id="gmr_gear">
        <option value="" selected>Please Choose</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
      </select>
	  <?php echo "<p class='text-danger'>$errGmrgear</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="message" class="col-sm-2 control-label">Message</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="4" name="message"><?php echo htmlspecialchars($_POST['message']);?></textarea>
	  <?php echo "<p class='text-danger'>$errMessage</p>";?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="human" class="col-sm-2 control-label">2 + 3 = ?<font color="red"> *</font></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
	  <?php echo "<p class='text-danger'>$errHuman</p>";?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
    </div>
  </div>
</form>
</center>

</section>
<footer>
<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
<img src="http://advancedwarfarerecovery.com/img/HaxelServices.png" class="img-polaroid">
<div class="col-md-6 credit">
</div>
</div>
</div>
</div>
</footer>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?2jq9PE68UQDCPBBgdHcJSxXjk3xxaa5R";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://advancedwarfarerecovery.com/js/waypoints.min.js"></script>
<script src="http://advancedwarfarerecovery.com/js/bootstrap.min.js"></script>
<script src="http://advancedwarfarerecovery.com/js/scripts.js"></script>
<script src="http://advancedwarfarerecovery.com/js/jquery.flexslider.js"></script>
<script src="http://advancedwarfarerecovery.com/js/modernizr.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>