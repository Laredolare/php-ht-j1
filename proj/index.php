<?php
require_once("db.inc");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<canvas id="banner2"></canvas>
<?php

	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		include('form.php'); 
	} else {
		echo "<p>Olet kirjautunut sisään. <br><a href='logout.php'>Kirjaudu ulos</a></p>";
		header('location:pelaajataulu.php');
	  }
?>
</body>
</html>
