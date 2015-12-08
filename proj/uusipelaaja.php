<?php

require_once("db.inc");
session_start();
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
					<td>Etunimi</td><td><input type="text" name="etunimi" value=""></td>				
				</tr>
				<tr>
					<td>Sukunimi</td><td><input type="text" name="sukunimi" value=""></td>			
				</tr>
				<tr>
					<td>Syntymäaika</td>
					<td style="width:200px;">
						<input style="width:25px" type="text" name="syntymapp" value=""><p style="display:inline"> pp</p>
						<input style="width:25px" type="text" name="syntymakk" value=""><p style="display:inline"> kk</p>
						<input style="width:50px;" type="text" name="syntymavv" value=""><p style="display:inline"> vvvv</p>
					</td>
				</tr>
				<tr>
					<td>Sukupuoli</td>
					<td>
						<select name="sukupuoli">
								<option value="mies">Mies</option>
								<option value="nainen">Nainen</option></td>
						</select>
					</td>
				</tr>
				<tr>
					<td>Puhelinnumero</td><td><input type="text" name="puhnro" value=""></td>
				</tr>
				<tr>
					<td>Sähköposti</td><td><input type="text" name="email" value=""></td>
				</tr>
			</table>

			<input onclick="return confirm(\'Haluatko varmasti tallentaa tiedot?\');" class="tallennaTiedot" type="submit" name="pelaaja_uusiPelaaja">
			<input class="poistaPelaaja" type="submit" name="pelaaja_poistaPelaaja">
			</form>
		</div>
	</div>
';

if (isset($_GET['t'])) {
	echo '<p style="text-align:center; color:green">Pelaaja tallennettu! Palaa painamalla pelaajatauluun <a href="pelaajataulu.php">tästä</a>.</p>';	
}

if(isset($_POST['pelaaja_uusiPelaaja'])){
	if (!empty($_POST['etunimi']) && !empty($_POST['sukunimi']) && !empty($_POST['syntymapp']) && !empty($_POST['syntymakk']) && 
		!empty($_POST['syntymavv']) && !empty($_POST['sukupuoli']) && !empty($_POST['puhnro']) && !empty($_POST['email'])){

		$syntymapaiva = $_POST['syntymavv'] . "-" . $_POST['syntymakk'] . "-" . $_POST['syntymapp'];

		mysql_query("INSERT INTO pelaaja (etunimi, sukunimi, syntymapaiva, sukupuoli, puhnro, email)
		VALUES ('".$_POST['etunimi']."', '".$_POST['sukunimi']."', '".$syntymapaiva."', '".$_POST['sukupuoli']."', '".$_POST['puhnro']."', '".$_POST['email']."') ");
		
		header('Location: uusipelaaja.php?t=t');
	}
	else{
		echo '<p style="text-align:center; color:red">Täytä kaikki kentät!</p>';
	}

	
	
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