<?php

require_once("db.inc");
session_start();

	echo '
<!DOCTYPE>
<html>
<head>
	<title>Pelaajataulu</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

	<canvas id="banner"></canvas>

<div id="pelaajataulu">';

// PELAAJAHAKU
echo '
	<div class="hakupalkki">
		<form name="form_haku_pelaaja" id="form_haku1" method="post" action="">
			<div class="hakupalkki_h2">
				<h2>Pelaajahaku</h2>
			</div>
			<img class="nuoli" alt="nuoli1" src="Palat/nuoli1.jpg">
			<div class="hakupalkki_table">	
				<table>
					<tr>
						<td>Etunimi</td>
						<td>Sukunimi</td>
						<td>Syntymävuosi</td>
						<td>Sukupuoli</td>
					</tr>
					<tr>
						<td><input type="text" name="pelaajahaku_etunimi"></td>
						<td><input type="text" name="pelaajahaku_sukunimi"></td>
						<td><input class="shortInput" type="text" name="pelaajahaku_syntymavuosi1">-<input class="shortInput" type="text" name="pelaajahaku_syntymavuosi2"></td>
						<td><select name="pelaajahaku_sukupuoli">
							<option value="" selected="selected"></option>
							<option value="Mies">Mies</option>
							<option value="Nainen">Nainen</option>
						</select></td>
					</tr>
				</table>
			</div>
			<img class="nuoli" alt="nuoli2" src="Palat/nuoli2.jpg">
			<div class="hakupainike">
				<input type="submit" name="haku" value="Hae">
			</div>

		</form>
	</div>';

// PELAAJALISTA

if(isset($_POST['haku']) ){

	$kysely="SELECT PELAAJA_ID, ETUNIMI, SUKUNIMI, SYNTYMAPAIVA, SUKUPUOLI, CONCAT(ETUNIMI, ' ', SUKUNIMI) AS NIMI FROM pelaaja";
	$etunimi = "'%" . $_POST['pelaajahaku_etunimi'] . "%'";
	$sukunimi = "'%" . $_POST['pelaajahaku_sukunimi'] . "%'";
	$x = 0;

	if (!empty($_POST['pelaajahaku_etunimi']) || !empty($_POST['pelaajahaku_sukunimi']) || !empty($_POST['pelaajahaku_sukupuoli']) || !empty($_POST['pelaajahaku_syntymavuosi1']) || !empty($_POST['pelaajahaku_syntymavuosi1']) ) {
		$kysely = $kysely . " WHERE";
	
		if (!empty($_POST['pelaajahaku_sukunimi'])) {
			$kysely = $kysely . " SUKUNIMI LIKE $sukunimi AND";
			$x = 1;
		}

		if (!empty($_POST['pelaajahaku_etunimi']) ) {
			$kysely = $kysely . " ETUNIMI LIKE $etunimi AND";
			$x = 1;
		}

		if (!empty($_POST['pelaajahaku_sukupuoli'])) {
			$sukupuoli = "'" . $_POST['pelaajahaku_sukupuoli'] . "'";
			$kysely = $kysely . 
			" SUKUPUOLI = $sukupuoli AND";	
			$x = 1;
		}

		if (!empty($_POST['pelaajahaku_syntymavuosi1']) && !empty($_POST['pelaajahaku_syntymavuosi2'])) {
			$syntymavuosi1 = "'" . $_POST['pelaajahaku_syntymavuosi1'] . "-01" . "-01'";
			$syntymavuosi2 = "'" . $_POST['pelaajahaku_syntymavuosi2'] . "-12" . "-31'";
			$kysely = $kysely . 
			" SYNTYMAPAIVA >= $syntymavuosi1 AND SYNTYMAPAIVA <= $syntymavuosi2 AND";
			$x = 1;
		}
		else if(!empty($_POST['pelaajahaku_syntymavuosi1'])){
			$syntymavuosi1 = "'" . $_POST['pelaajahaku_syntymavuosi1'] . "-01" . "-01'";
			$kysely = $kysely . 
			" SYNTYMAPAIVA >= $syntymavuosi1 AND";
			$x = 1;
		}
		else if(!empty($_POST['pelaajahaku_syntymavuosi2'])) {
			$syntymavuosi2 = "'" . $_POST['pelaajahaku_syntymavuosi2'] . "-12" . "-31'";
			$kysely = $kysely . 
			" SYNTYMAPAIVA <=  $syntymavuosi2 AND";
			$x = 1;
		}
			
		if ($x = 1) {
			$kysely = substr($kysely, 0, -4);
		}
	}
}
else{
		$kysely="SELECT PELAAJA_ID, ETUNIMI, SUKUNIMI, CONCAT(ETUNIMI, ' ', SUKUNIMI) AS NIMI FROM pelaaja";
	}

$tulos = mysql_query($kysely);

echo '
<div class="row">
	<div class="listaus">
	<h3>Pelaajalista</h3>
		<ul>
			<li id="" onclick="nayta_pelaaja(event);">Kaikki pelaajat</li> ';
if (mysql_num_rows($tulos) > 1){
	while($rivi = mysql_fetch_array($tulos)){
		if (!empty($_GET['pelaaja_id'])) {
			if ($_GET['pelaaja_id'] == $rivi['PELAAJA_ID']) {
				echo '<li class="valittuPelaaja" id="pelaaja_id=' .$rivi['PELAAJA_ID']. '" onclick="nayta_pelaaja(event);">' .$rivi['NIMI']. '</li>';
			}
			else{
				echo '<li id="pelaaja_id=' .$rivi['PELAAJA_ID']. '" onclick="nayta_pelaaja(event);">' .$rivi['NIMI']. '</li>';
			}
		}
		else{
			echo '<li id="pelaaja_id=' .$rivi['PELAAJA_ID']. '" onclick="nayta_pelaaja(event);">' .$rivi['NIMI']. '</li>';
		}
	}
}
else if (mysql_num_rows($tulos) == 1){
	$rivi = mysql_fetch_row($tulos);
	echo '<li id="pelaaja_id=' .$rivi[0]. '" onclick="nayta_pelaaja(event);">' .$rivi[4]. '</li>';
}
else{
	echo '<p>Pelaajia ei löytynyt</p>';
}

echo '	</ul>
	</div>';


include('sisalto.php'); 

?>
<script>

function nayta_pelaaja(event){
	event = event || window.event; // IE
    var target = event.target || event.srcElement; // IE
   	var id = target.id;
   	if (id == '') {window.location.href = "pelaajataulu.php"}
   		else{id = id + "&kp=kp";
   			window.location.href = "pelaajataulu.php?" + id}
	;
}

function nayta_patteri(event){
	event = event || window.event; // IE
    var target = event.target || event.srcElement; // IE
   	var id = target.id;
	document.getElementById('pelaajan_testit_tulokset').style.display = "block";
	window.location.href = "pelaajataulu.php?" + id;
}

function nayta_suoritukset(event){
	event = event || window.event; // IE
    var target = event.target || event.srcElement; // IE
   	var id = target.id;
   	id = 'suoritukset_' + id;
   	if (document.getElementById(id).style.display == "block"){
   		document.getElementById(id).style.display = "none";
   	}
   	else{
   		document.getElementById(id).style.display = "block";
   	}
}
</script>
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