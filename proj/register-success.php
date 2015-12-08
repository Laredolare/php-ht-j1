<!DOCTYPE html>
<html>
<head>
	<title>Rekisteröinti onnistui</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<canvas id="banner"></canvas>
<?php
	require_once("db.inc");
	session_start();
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		include('form.php'); 
	}
?>

<div class="row">
	<div class="listaus">
		<h3>Tunnuksen rekisteröinti onnistui.</h3>
	</div>
</div>

</body>
</html>