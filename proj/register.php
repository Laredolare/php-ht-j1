<!DOCTYPE>
<html>
<head>
	<title>Rekisteröi uusi käyttäjä</title>
	<meta charset="iso-8859-1">
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

	if($_SESSION['SESS_ADMIN'] != 1)
	{
		header('location:access-denied.php');
	}
?>
<div class="row">
	<div class="listaus">
		<h3><a href="admin.php">Admin-työkalut</a></h3>
		<h3>Rekisteröi uusi käyttäjä</h3>
		<table>
		<form id="registerForm" name="registerForm" method="post" action="register-exec.php">
		<tr><td>Etunimi</td><td><input name="etunimi" type="text" class="textfield" id="etunimi" /></td></tr>
		<tr><td>Sukunimi</td><td><input name="sukunimi" type="text" class="textfield" id="sukunimi" /></td></tr>
		<tr><td>Sähköposti</td><td><input name="email" type="text" class="textfield" id="email" /></td></tr>
		<tr><td>Puhnro</td><td><input name="puhnro" type="text" class="textfield" id="puhnro" /></td></tr>
		<tr><td>Salasana</td><td><input name="salasana" type="password" class="textfield" id="salasana" /></td></tr>
		<tr><td>Salasana uudelleen</td><td><input name="csalasana" type="password" class="textfield" id="csalasana" /></td></tr>
		<tr><td></td><td><input type="submit" name="Submit" value="Rekisteröi" /></td></tr>
		</form>
		</table>
	</div>
</div>


</body>
</html>