<?php

require_once("db.inc");
session_start();

$kysely="SELECT PELAAJA_ID, ETUNIMI, SUKUNIMI, SYNTYMAPAIVA, SUKUPUOLI, PUHNRO, EMAIL FROM pelaaja WHERE PELAAJA_ID = ". $_GET['pelaaja_id'] ." ";
$tulos = mysql_query($kysely);
$rivi = mysql_fetch_array($tulos);

list($vv, $kk, $pp) = explode('-', $rivi['SYNTYMAPAIVA']);

	echo '
<!DOCTYPE>
<html>
<head>
	<title>Pelaajan tietojen muokkaus</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<canvas id="banner"></canvas>
	<div id="tietojenmuokkaus">
		<div>	
			<h2>PELAAJAN TIEDOT</h2>
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
					<td>Syntymäaika</td>
					<td style="width:200px;">
						<input style="width:25px" type="text" name="syntymapp" value="' .$pp. '"><p style="display:inline"> pp</p>
						<input style="width:25px" type="text" name="syntymakk" value="' .$kk. '"><p style="display:inline"> kk</p>
						<input style="width:50px;" type="text" name="syntymavv" value="' .$vv. '"><p style="display:inline"> vvvv</p>
					</td>
				</tr>
				<tr>
					<td>Sukupuoli</td>
					<td>
						<select name="sukupuoli">';
							if ($rivi['SUKUPUOLI'] == 'Nainen') {
								echo '
								<option value="mies">Mies</option>
								<option value="nainen" selected="selected">Nainen</option></td>';
							}
							else{
								echo '
								<option value="mies" selected="selected">Mies</option>
								<option value="nainen">Nainen</option></td>';
							}
						echo '
						</select>
					</td>
				</tr>
				<tr>
					<td>Puhelinnumero</td><td><input type="text" name="puhnro" value="' .$rivi['PUHNRO']. '"></td>
				</tr>
				<tr>
					<td>Sähköposti</td><td><input type="text" name="email" value="' .$rivi['EMAIL']. '"></td>
				</tr>
			</table>

			<input onclick="return confirm(\'Haluatko varmasti tallentaa tiedot?\');" class="tallennaTiedot" type="submit" name="pelaaja_tallennaTiedot">
			<input class="poistaPelaaja" type="submit" name="pelaaja_poistaPelaaja">
			</form>
		</div>
	</div>
';

if(isset($_POST['pelaaja_tallennaTiedot'])){

	if(!empty($_POST['etunimi'])){
		mysql_query("UPDATE pelaaja SET ETUNIMI = '".$_POST['etunimi']."' WHERE PELAAJA_ID = '".$_GET['pelaaja_id']."' ");
	}

	if(!empty($_POST['sukunimi'])){
		mysql_query("UPDATE pelaaja SET SUKUNIMI = '".$_POST['sukunimi']."' WHERE PELAAJA_ID = '".$_GET['pelaaja_id']."' ");
	}

	if(!empty($_POST['syntymapp']) || !empty($_POST['syntymakk']) || !empty($_POST['syntymavv'])){
		$syntymapaiva = $_POST['syntymavv'] . "-" . $_POST['syntymakk'] . "-" . $_POST['syntymapp'];
		mysql_query("UPDATE pelaaja SET SYNTYMAPAIVA = '".$syntymapaiva."' WHERE PELAAJA_ID = '".$_GET['pelaaja_id']."' ");
	}

	if(!empty($_POST['sukupuoli'])){
		mysql_query("UPDATE pelaaja SET SUKUPUOLI = '".$_POST['sukupuoli']."' WHERE PELAAJA_ID = '".$_GET['pelaaja_id']."' ");
	}

	if(!empty($_POST['puhnro'])){
		mysql_query("UPDATE pelaaja SET PUHNRO = '".$_POST['puhnro']."' WHERE PELAAJA_ID = '".$_GET['pelaaja_id']."' ");
	}

	if(!empty($_POST['email'])){
		mysql_query("UPDATE pelaaja SET EMAIL = '".$_POST['email']."' WHERE PELAAJA_ID = '".$_GET['pelaaja_id']."' ");
	}

	header('Location: tietojenmuokkaus.php?pelaaja_id=' . $_GET['pelaaja_id']);
}

if(isset($_POST['pelaaja_poistaPelaaja'])){
	header('Location: pelaajataulu.php');
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