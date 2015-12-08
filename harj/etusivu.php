<!DOCTYPE html> 
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fi" lang="fi">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="tyyli.css">
	</head>
	<body>
		<div id="main">
			<div id="navbar">
				<ul>
					<li><a href="toimintolista.php">Toimintolista</a></li>
				</ul>
				<hr>
			</div>
<?php
require_once("db.inc");
session_start();
include ('dbedit.php');

if(isset($_SESSION['kayttajatunnus'])) {
	header('Location: sovellus.php');
}

if(!isset($_GET['pId'])){
	header('Location: ?pId=login');
}
else{
	switch($_GET['pId']){
		default:
		case 'login':
			echo '
			<div class="center">
				<h2>KIRJAUDU SISÄÄN</h2>
				<form method="POST" action="">
					<label>Käyttäjätunnus: </label><br><input type="text" name="kayttajatunnus" value="" ><br>
					<label>Salasana: </label><br><input type="password" name="salasana" value="" ><br>
					<input type="submit" name="login" value="Kirjaudu" />
				</form>
				<p><a href="?pId=rek">Eikö sinulla ole käyttäjätunnusta? Rekisteröidy tästä.</a></p>
			</div>';
		break;

		case 'rek':
			echo '
				
			<div class="center">
				<h2>REKISTERÖIDY</h2>
				<form method="POST" action="">
					<label><span id="ptt">*</span>Käyttäjätunnus: </label><br><input type="text" name="kayttajatunnus" value="" /><br>
					<label><span id="ptt">*</span>Salasana: </label><br><input id="pw" type="password" name="salasana" value="" /><br>
					<label><span id="ptt">*</span>Salasana uudelleen: </label><br><input id="pw" type="password" name="salasana_re" value="" /><br>
					<label><span id="ptt">*</span>Nimi: </label><br><input type="text" name="nimi" value="" /><br>
					<label><span id="ptt">*</span>Käyntiosoite: </label><br><input type="text" name="kayntiosoite" value="" /><br>
					<label><span id="ptt">*</span>Laskutusosoite: </label><br><input type="text" name="laskutusosoite" value="" /><br>
					<label><span id="ptt">*</span>Puhelinnumero: </label><br><input type="text" name="puhelinnumero" value="" /><br>
					<label><span id="ptt">*</span>Sähköposti: </label><br><input type="text" name="sahkoposti" value="" /><br>
					<label>Asuntotyyppi: </label><br>
					<select name="asuntotyyppi">
						<option value="kerrostalo">Kerrostalo</option>
						<option value="maatila">Maatila</option>
						<option value="omakotitalo">Omakotitalo</option>
						<option value="rivitalo">Rivitalo</option>
						<option value="vapaa-ajan asunto">Vapaa-ajan asunto</option>
					</select><br>
					<label>Pinta-ala: </label><br><input type="text" name="pintaala" value="" /><br>
					<label>Tonttikoko: </label><br><input type="text" name="tonttikoko" value="" /><br>
					<input type="submit" name="register" value="Rekisteröidy" />
				</form>
				<a href="etusivu.php?pId=login">Kirjaudu sisään.</a>
				<p id="pt">Pakolliset tiedot ovat merkitty merkillä: <span id="ptt">*</span></p>
			</div>';
		break;
}}
?>
		</div>
	</body>
</html>