<?php
require_once("db.inc");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Kirjautuminen ep�onnistui</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<canvas id="banner2"></canvas>
<?php
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		include('form.php'); 
	}
?>

<div class="row">
	<div class="listaus">
		<h3>Kirjautuminen ep�onnistui. Tarkista k�ytt�j�tunnus ja salasana.</h3>
	</div>
</div>

</body>
</html>