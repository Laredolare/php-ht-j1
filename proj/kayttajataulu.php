<?php
require_once("db.inc");
session_start();

	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		header("location: access-denied.php");
		exit();
	}
	
	if($_SESSION['SESS_ADMIN'] != 1)
	{
		header('location:access-denied.php');
	}
	echo '
<!DOCTYPE>
<html>
<head>
	<title>Käyttäjät</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

	<canvas id="banner"></canvas>

<div id="pelaajataulu">';

// KÄYTTÄJÄLISTA

$kysely="SELECT KAYTTAJA_ID, ETUNIMI, SUKUNIMI, CONCAT(ETUNIMI, ' ', SUKUNIMI) AS NIMI FROM kayttaja";
$tulos = mysql_query($kysely);

echo '
<div class="row">
	<div class="listaus">
	<h3><a href="admin.php">Admin-työkalut</a></h3>
	<h3>Käyttäjälistaus</h3>
		<ul>';

if (mysql_num_rows($tulos) >= 1){
	while($rivi = mysql_fetch_array($tulos)){
	echo '<li id="kayttaja_id=' .$rivi['KAYTTAJA_ID']. '" onclick="nayta_kayttaja(event);">' .$rivi['NIMI']. '</li>';
	}
}
else{
	echo '<p>Pelaajia ei löytynyt</p>';
}

echo '	</ul>
	</div>';


include('kayttajasisalto.php'); 

?>
<script>

function nayta_kayttaja(event){
	event = event || window.event; // IE
    var target = event.target || event.srcElement; // IE
   	var id = target.id;
	window.location.href = "kayttajataulu.php?" + id;
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