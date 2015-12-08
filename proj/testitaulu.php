<?php

require_once("db.inc");
session_start();

?>
<!DOCTYPE>
<html>
<head>
	<title>Testitaulu</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<canvas id="banner"></canvas>

<!-- PATTERIHAKU -->

<div class="hakupalkki">
	<form name="form_haku_patteri" id="form_haku_2" method="get" action="">
		<div class="hakupalkki_h2">
			<h2>Patterihaku</h2>
		</div>
		<img class="nuoli" alt="nuoli1" src="img/nuoli1.jpg">
		<div class="hakupalkki_table">	
			<table>
				<tr>
					<td>Hakusana</td>
					<td>Aikaväli(kk/vvvv - kk/vvvv)</td>
				</tr>
				<tr>
					<td><input type="text" name="patterihaku_hakusana"></td>
					<td>
						<input class="ShortInput" type="text" name="patterihaku_kuukausi1"> /
						<input class="ShortInput" type="text" name="patterihaku_vuosi1"> - 
						<input class="ShortInput" type="text" name="patterihaku_kuukausi2"> /
						<input class="ShortInput" type="text" name="patterihaku_vuosi2">
					</td>
				</tr>
			</table>
		</div>
		<img class="nuoli" alt="nuoli2" src="img/nuoli2.jpg">
		<div class="hakupainike">
			<input type="submit" name="haku" value="Hae">
		</div>
	</form>
</div>

<?php
// PATTERILISTA
$patterilista_kysely="SELECT PATTERI_ID, NIMI FROM testipatteri";
$patterilista_tulos = mysql_query($patterilista_kysely);

echo '
	<div class="listaus">
		<h3>Patterilista</h3>
		<ul>';

while($patterilista_rivi = mysql_fetch_array($patterilista_tulos)){
	echo '<li class="patterilista_patteri" id="TT_patteri_id=' .$patterilista_rivi['PATTERI_ID']. '" onclick="nayta_patterin_tiedot(event);">' .$patterilista_rivi['NIMI']. '</li>';
}
echo '	</ul>
	</div>';

include('sisalto2.php');
?>

<script>

function nayta_patterin_tiedot(event){
	event = event || window.event; // IE
    var target = event.target || event.srcElement; // IE
   	var id = target.id;
	window.location.href = "testitaulu.php?" + id;
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
