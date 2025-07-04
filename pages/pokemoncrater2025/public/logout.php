<?php
session_start();
session_destroy();
session_unset();
include('pv_disconnect_from_db.php');
header("location:http://www.pokemon-shqipe.co.uk/login.php?action=Logout"); 
?> 