<?php
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		header("location: access-denied.php");
		exit();
	}
	
	if($_SESSION['SESS_ADMIN'] != 1)
	{
		header('location:access-denied.php');
	}

if(!empty($_GET['kayttaja_id'])){
	PTT();
}


// KAYTTAJAN TIEDOT
function PTT(){
$kysely2="SELECT KAYTTAJA_ID, ETUNIMI, SUKUNIMI, HETU, PUHNRO, EMAIL FROM kayttaja WHERE KAYTTAJA_ID = ". $_GET['kayttaja_id'] ." ";
$tulos2 = mysql_query($kysely2);
$rivi2 = mysql_fetch_array($tulos2);

echo '
<div id="pelaajan_tiedot-testit">
	<div id="pelaajan_tiedot">
		<h4>KÄYTTÄJÄN TIEDOT</h4>
		<table>
			<tr>
				<td>Etunimi</td>
				<td>Sukunimi</td>
				<td>Puhelinnumero</td> 
				<td>Sähköposti</td>
			</tr>
			<tr>
				<td>' .$rivi2['ETUNIMI']. '</td>
				<td>' .$rivi2['SUKUNIMI']. '</td>';
		echo '
				<td>' .$rivi2['PUHNRO']. '</td>
				<td>' .$rivi2['EMAIL']. '</td>
				<form method="post" action="">
				<td><input class="muokkaaTietoja" type="submit" name="kayttajan_tiedot_muokkaa"></td>
				</form>
			</tr>
		</table>
	</div>
';
}

if (!empty($_POST['kayttajan_tiedot_muokkaa'])){
	header('Location: kayttajamuokkaus.php?kayttaja_id=' . $_GET['kayttaja_id']);
}
?>