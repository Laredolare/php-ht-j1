<?php

require_once("db.inc");
session_start();

	echo '
<!DOCTYPE>
<html>
<head>
	<title>Patterin luonti</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<canvas id="banner"></canvas>
<div class="uusipatteri">
<form id="uusipatteri" method="post" target="">
';

if((!isset($_POST['uusipatteri_tallenna1']) && !isset($_POST['uusipatteri_tallenna2']) && !isset($_POST['uusipatteri_tallenna3'])) || isset($_POST['uusipatteri_muokkaa1']))
{
echo'
	<div class="uusipatteri_taso">
		<h3>TESTIPATTERI</h3>
		<label>Patterin nimi:</label>
		<input type="text" name="uusipatteri_nimi" value="';
		if (isset($_POST['uusipatteri_nimi']))
		{
			echo $_POST['uusipatteri_nimi'];
		}
echo '" />
	<br />
	<div class="tMdiv">
		<input class="tallennaMuutokset" type="submit" name="uusipatteri_tallenna1" value="TALLENNA MUUTOKSET" />
	</div>
	</div>
';
}

if(isset($_POST['uusipatteri_tallenna1']))
{
	echo '<div class="uusipatteri_taso">
		<h3>TESTIPATTERI</h3>
		<label>Patterin nimi:</label>
		<input type="text" name="uusipatteri_nimi" value="'. $_POST['uusipatteri_nimi'] .'" readonly/>
		<br />
	<div class="tMdiv">
		<input class="muokkaa" type="submit" name="uusipatteri_muokkaa1" value="MUOKKAA" />
	</div>
	</div>
	';

	$kysely="SELECT TESTI_ID, NIMI, MITTAYKSIKKO FROM testi";
	$tulos = mysql_query($kysely);
	?>
	
	<div class="uusipatteri_taso_testit">
		<h3>TESTIT</h3>
		<input class="lisaaTesti" type="button" name="uusipatteri_uusitesti1" value="LISÄÄ TESTI"  onClick="addRow('dataTable')" />
		<input class="poistaTesti" type="button" name="uusipatteri_poista1" value="POISTA VALITUT" onClick="deleteRow('dataTable')" />
		<input class="tallennaMuutokset" type="submit" name="uusipatteri_tallenna2" value="TALLENNA MUUTOKSET" />
		<table id="dataTable" class="form">
			<tbody>
			<tr><td ><input type="checkbox" name="chk[]" /></td>
			<td>
			<select name="uusipatteri_testit[]">
			
			<?php
			while($rivi = mysql_fetch_array($tulos)){
				echo '<option value="'.$rivi['TESTI_ID'].'">'.$rivi['NIMI'].'</option>';
			}
			?>
			
			</select></td></tr>
			</tbody>
		</table>
	</div>

<?php
}

if(isset($_POST['uusipatteri_tallenna2']))
{
	echo '<div class="uusipatteri_taso">
		<h3>TESTIPATTERI</h3>
		<label>Patterin nimi:</label>
		<input type="text" name="uusipatteri_nimi" value="'. $_POST['uusipatteri_nimi'] .'" readonly/>
		<br />
	<div class="tMdiv">
		<input class="peruuta" type="submit" name="uusipatteri_muokkaa1" value="PERUUTA" />
	</div>
	</div>
	';
	$testit = $_POST['uusipatteri_testit'];
	$_SESSION['testit'] = $testit;
	
	echo '<div class="uusipatteri_taso_testit">
	<h3>TESTIT</h3>
	<input onclick="return confirm(\'Haluatko varmasti luoda tämän patterin?\');" class="tallennaPatteri" type="submit" name="uusipatteri_tallenna3">';
	
	echo "<table id='dataTable' class='form'>
	<tbody>
	";
	
	
	foreach($_POST['uusipatteri_testit'] as $a => $b){
		$kysely="SELECT NIMI FROM testi WHERE TESTI_ID=$testit[$a]";
		$tulos = mysql_query($kysely);
		$rivi = mysql_fetch_assoc($tulos);
		?>
		<tr><td><label>Testi <?php echo $a+1; ?>:</label></td>
		<td><input type="text" name="" value="<?php echo $rivi['NIMI']; ?>" readonly></td></tr>
	<?php
	}
	
	echo '
	</tr>
	</tbody>
	</table>
	</div>';

}

if(isset($_POST['uusipatteri_tallenna3']))
{
	$testit = $_SESSION['testit'];
	unset($_SESSION['testit']);
	
	$kysely="INSERT INTO testipatteri(nimi, pvm) VALUES('". $_POST['uusipatteri_nimi'] ."','". date('Y-m-d') ."')";
	mysql_query($kysely);
	
	$kysely="SELECT patteri_id FROM testipatteri WHERE nimi='".$_POST['uusipatteri_nimi']."'";
	$tulos = mysql_query($kysely);
	$rivi2 = mysql_fetch_assoc($tulos);
	
	foreach($testit as $a => $b){
		$kysely="SELECT * FROM testi WHERE TESTI_ID=$testit[$a]";
		$tulos = mysql_query($kysely);
		$rivi = mysql_fetch_assoc($tulos);
		$kysely="INSERT INTO suoritus (patteri_id, testi_id) VALUES('". $rivi2['patteri_id'] ."','". $rivi['testi_id'] ."')";
		mysql_query($kysely);
	}
	echo "<h3>Patteri luotu onnistuneesti!</h3>";
	header('location:testitaulu.php');
}
?>
</form>

<script type="text/javascript">

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

function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 15){                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		}
	}else{
		 alert("Testien maksimimäärä on 15");
			   
	}
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			if(rowCount <= 1) { // limit the user from removing all the fields
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	}
}
</script>
</body>
</html>