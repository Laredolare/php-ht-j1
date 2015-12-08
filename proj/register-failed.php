<!DOCTYPE html>
<html>
<head>
	<title>Rekisteröinti epäonnistui</title>
	<meta charset="iso-8859-1" />
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
		<h3>Tunnuksen rekisteröinti epäonnistui. Palaa takaisin ja tarkista tietojen oikeellisuus.</h3>
	</div>
</div>


	<?php
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<li>',$msg,'</li>'; 
		}
		echo '</ul>';
		unset($_SESSION['ERRMSG_ARR']);
	}
	?>
	
</body>
</html>