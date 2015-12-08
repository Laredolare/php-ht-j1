<?php

require_once("db.inc");
session_start();

	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		header("location: access-denied.php");
		exit();
	}

$kysely="SELECT KAYTTAJA_ID, ETUNIMI, SUKUNIMI, PUHNRO, EMAIL FROM kayttaja WHERE KAYTTAJA_ID = ". $_SESSION['SESS_MEMBER_ID'] ." ";
$tulos = mysql_query($kysely);
$rivi = mysql_fetch_array($tulos);

echo '
<!DOCTYPE>
<html>
<head>
	<title>Käyttäjän tietojen muokkaus</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<canvas id="banner"></canvas>
	<div id="tietojenmuokkaus">
		<div>	
			<h2>KÄYTTÄJÄN TIEDOT</h2>
		</div>
		<div>
			<form method="post" action="">
			<table>
				<tr>
					<td>Etunimi</td><td><input type="text" name="etunimi" value="' .$rivi['ETUNIMI']. '"></td>				
				</tr>
				<tr>
					<td>Sukunimi</td><td><input type="text" name="sukunimi" value="' .$rivi['SUKUNIMI']. '"></td>			
				</tr>
				<tr>
					<td>Puhelinnumero</td><td><input type="text" name="puhnro" value="' .$rivi['PUHNRO']. '"></td>
				</tr>
				<tr>
					<td>Sähköposti</td><td><input type="text" name="email" value="' .$rivi['EMAIL']. '"></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>Uuden salasanan vaihto</td><td><input type="password" name="salasana" value=""></td>
				</tr>
				<tr>
					<td>Salasana uudelleen</td><td><input type="password" name="csalasana" value=""></td>
				</tr>
			</table>

			<input onclick="return confirm(\'Haluatko varmasti tallentaa tiedot?\');" class="tallennaTiedot" type="submit" name="pelaaja_tallennaTiedot">
			</form>
		</div>
	</div>
';

if(isset($_POST['pelaaja_tallennaTiedot'])){

	if(!empty($_POST['etunimi'])){
		mysql_query("UPDATE kayttaja SET ETUNIMI = '".$_POST['etunimi']."' WHERE KAYTTAJA_ID = '".$_SESSION['SESS_MEMBER_ID']."' ");
	}

	if(!empty($_POST['sukunimi'])){
		mysql_query("UPDATE kayttaja SET SUKUNIMI = '".$_POST['sukunimi']."' WHERE KAYTTAJA_ID = '".$_SESSION['SESS_MEMBER_ID']."' ");
	}

	if(!empty($_POST['puhnro'])){
		mysql_query("UPDATE kayttaja SET PUHNRO = '".$_POST['puhnro']."' WHERE KAYTTAJA_ID = '".$_SESSION['SESS_MEMBER_ID']."' ");
	}

	if(!empty($_POST['email'])){
		mysql_query("UPDATE kayttaja SET EMAIL = '".$_POST['email']."' WHERE KAYTTAJA_ID = '".$_SESSION['SESS_MEMBER_ID']."' ");
	}
	
	if(!empty($_POST['salasana']) && !empty($_POST['csalasana']))
	{
		if(strcmp($_POST['salasana'], $_POST['csalasana']) != 0 ) {
			echo '<script language="javascript">';
			echo 'alert("Salasanat eivät täsmää")';
			echo '</script>';
		} else {
			mysql_query("UPDATE kayttaja SET salasana = '".md5($_POST['salasana'])."' WHERE KAYTTAJA_ID = '".$_SESSION['SESS_MEMBER_ID']."' ");
		}
	}
	
	header('Location:omattiedot.php');
}
?>

<script>

Canvas = document.getElementById('banner');
Context = Canvas.getContext('2d');

var Banner = new Image();
Banner.src = "img/banner2.jpg";
Canvas.onclick = function(event){
	var x = event.offsetX;
	var y = event.offsetY;

/*
	document.form_haku.pelaajahaku_etunimi.value = "x: " + x;
	document.form_haku.pelaajahaku_sukunimi.value = "y: " + y;
*/

	if(x > 200 && x < 500 && y > 38 &&  y < 95){
		window.location.replace("pelaajataulu.php");
	}

	if(x > 765  && x < 1018 && y < 85 && y > 38 ){
		window.location.replace("testitaulu.php");
	}

	if(x > 512  && x < 740 && y < 125 && y > 96 ){
		window.location.replace("omattiedot.php");
	}
}
</script>

</body>
</html>