<!DOCTYPE html>
<html>
<head>
	<title>Ty�kalut</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<canvas id="banner"></canvas>
<?php
	require_once("db.inc");
	session_start();

	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		header("location: access-denied.php");
		exit();
	}
	
	if($_SESSION['SESS_ADMIN'] != 1)
	{
		header('location:access-denied.php');
	}
?>

<div class="row">
	<div class="listaus">
		<h3>Admin-ty�kalut</h3>
		<table>
		<tr><td><a href="kayttajataulu.php">K�ytt�j�listaus</a></td></tr>
		<tr><td><a href="register.php">Rekister�i uusi k�ytt�j�</a></td></tr>
		</table>
	</div>
</div>
</body>
</html>
