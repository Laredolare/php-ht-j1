<?php
require_once("db.inc");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Kirjautuminen onnistui</title>
	<meta charset="iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<canvas id="banner"></canvas>
<?php
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		include('form.php'); 
	} else {
		echo "<p>Olet kirjautunut sisään. <br><a href='logout.php'>Kirjaudu ulos</a></p>";
		header('location:pelaajataulu.php');
	  }
?>

<div class="row">
	<div class="listaus">
		<h3>Kirjautuminen onnistui.</h3>
	</div>
</div>

</body>
</html>