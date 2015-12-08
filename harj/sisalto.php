<?php
function muokkaa(){
	if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
	if($_GET['pId'] == 'muokkaa' && isset($_SESSION['kayttajatunnus']) ){
		$kayttajatunnus = $_SESSION['kayttajatunnus'];
		$kysely="SELECT KAYTTAJATUNNUS, SALASANA, NIMI, KAYNTIOSOITE, LASKUTUSOSOITE, PUHELINNUMERO, SAHKOPOSTI, ASUNTOTYYPPI, PINTAALA, TONTTIKOKO, LUONTIPVM FROM asiakkaat WHERE kayttajatunnus = '$kayttajatunnus' ";
		$tulos = mysql_query($kysely);
		$rivi = mysql_fetch_array($tulos);
		if(!empty($rivi['LUONTIPVM'])){
			$LUONTIPVM = date("d.m.Y", strtotime($rivi['LUONTIPVM']));
		}
		else{
			$LUONTIPVM = ' ';
		}
	}
	return '
	<div class="center">
		<h2>MUOKKAA TIETOJA</h2>
		<table>
			<form method="POST" action="">
							<tr>
								<td><label>Käyttäjätunnus: </label></td>
					<td>' .$rivi['KAYTTAJATUNNUS']. '</td>
				</tr>
							<tr>
								<td><label>Salasana: </label></td>
				
					<td><input type="text" name="salasana" value="' .$rivi['SALASANA']. '" /></td>
				</tr>
							<tr>
								<td><label>Nimi: </label></td>
				
					<td><input type="text" name="nimi" value="' .$rivi['NIMI']. '" /></td>
				</tr>
							<tr>
								<td><label>Käyntiosoite: </label></td>
				
					<td><input type="text" name="kayntiosoite" value="' .$rivi['KAYNTIOSOITE']. '" /></td>
				</tr>
							<tr>
								<td><label>Laskutusosoite: </label></td>
					<td><input type="text" name="laskutusosoite" value="' .$rivi['LASKUTUSOSOITE']. '" /></td>
				</tr>
							<tr>
								<td><label>Puhelinnumero: </label></td>
					<td><input type="text" name="puhelinnumero" value="' .$rivi['PUHELINNUMERO']. '" /></td>
				</tr>
							<tr>
								<td><label>Sähköposti: </label></td>

					<td><input type="text" name="sahkoposti" value="' .$rivi['SAHKOPOSTI']. '" /></td>
				</tr>
				<tr>
								<td><label>Asuntotyyppi: </label></td>
					<td><input type="text" name="asuntotyyppi" value="' .$rivi['ASUNTOTYYPPI']. '" /></td>
				<tr>
								<td><label>Pinta-ala: </label></td>
					<td><input type="text" name="pintaala" value="' .$rivi['PINTAALA']. '" /></td>
				</tr>
				<tr>
								<td><label>Tonttikoko: </label></td>
					<td><input type="text" name="tonttikoko" value="' .$rivi['TONTTIKOKO']. '" /></td>
				</tr>
				<tr>
								<td><label>Luontipvm: </label></td>
					<td>' .$LUONTIPVM. '</td>
				</tr>
				<tr>
					<td><input type="submit" name="muokkaa" value="Muokkaa" /></td>
					<td><input type="reset" name="reset" value="Tyhjennä" /></td>
				</tr>
			</form>
		</table>
	</div>
		';
}
function tarjouspyynto(){
	if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
	$kayttajatunnus = $_SESSION['kayttajatunnus'];
	return '
	<div class="center">
		<h2>LÄHETÄ TARJOUSPYYNTÖ</h2>
		<form id="UTP" method="POST" action="">
			<label>Käyttäjätunnus: </label>' . $kayttajatunnus . '<br>
			<label>Työn kuvaus: </label><br><textarea name="kuvaus" form="UTP"></textarea><br>
			<input type="submit" name="UTP" value="Lähetä" />
		</form>
	</div>
	';
}
function tarjouspyynto_kustannusarvio(){
	if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
	$kayttajatunnus = $_SESSION['kayttajatunnus'];
	$kysely="SELECT AVAIN, TILAAJA, KUVAUS, JATTAMISPVM, VASTAAMISPVM, KUSTANNUSARVIO, STATUS FROM tarjouspyynnot WHERE AVAIN = '".$_GET['avain']."'";
	$tulos = mysql_query($kysely);
	$rivi = mysql_fetch_array($tulos);
	if(!empty($rivi['JATTAMISPVM'])){
		$JATTAMISPVM = date("d.m.Y", strtotime($rivi['JATTAMISPVM']));
	}
	else{
		$JATTAMISPVM = ' ';
	}
	return '
	<div class="center">
		<h2>ANNA KUSTANNUSARVIO</h2>
		<form id="UTP" method="POST" action="sovellus.php?pId=UTP&avain='.$rivi['AVAIN'].' ">
			<label>Tilaaja: </label>'.$rivi['TILAAJA'].'<br>
			<label>Työn kuvaus: </label><br>'.$rivi ['KUVAUS'].'<br>
			<label>Jättämispvm </label>'.$JATTAMISPVM.'<br>
			<label>Kustannusarvio: </label><br><input type="text" name="kustannusarvio"><br>
			<label>STATUS: </label>'.$rivi['STATUS'].'<br>
			<input type="submit" name="UTP_kustannusarvio" value="Lähetä" />
		</form>
	</div>
	';
}
function tarjouspyynto_poisto(){
	if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
	$kayttajatunnus = $_SESSION['kayttajatunnus'];
	$kysely="SELECT AVAIN, TILAAJA, KUVAUS, JATTAMISPVM, VASTAAMISPVM, KUSTANNUSARVIO, STATUS FROM tarjouspyynnot WHERE AVAIN = '".$_GET['avain']."' AND TILAAJA = '".$kayttajatunnus."' ";
	$tulos = mysql_query($kysely);
	$rivi = mysql_fetch_array($tulos);
	if(!empty($rivi['JATTAMISPVM'])){
		$JATTAMISPVM = date("d.m.Y", strtotime($rivi['JATTAMISPVM']));
	}
	else{
		$JATTAMISPVM = ' ';
	}
	return '
	<div class="center">
		<h2 id="poisto">TARJOUSPYYNNÖN POISTO</h2>
		<p>Oletko varma että haluat poistaa tarjouspyynnön:</p>
		<form id="PTP" method="POST" action="sovellus.php?pId=PTP&avain='.$rivi['AVAIN'].' ">
			<label>Tilaaja: </label>'.$rivi['TILAAJA'].'<br>
			<label>Työn kuvaus: </label><br>'.$rivi ['KUVAUS'].'<br>
			<label>Jättämispvm: </label>'.$JATTAMISPVM.'<br>
			<label>STATUS: </label>'.$rivi['STATUS'].'<br>
			<input type="submit" name="PTP" value="Poista" />
			<a href="sovellus.php?pId=tyotilaukset">Peruuta</a>
		</form>
	</div>
	';
}
function tyotilaus_uusi(){
	if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
	$kayttajatunnus = $_SESSION['kayttajatunnus'];
	return '
	<div class="center">
		<h2>LÄHETÄ TYÖTILAUS</h2>
		<form id="UTT" method="POST" action="">
			<label>Käyttäjätunnus: </label>' . $kayttajatunnus . '<br>
			<label>Työn kuvaus: </label><br><textarea name="kuvaus" form="UTT"></textarea><br>
			<input type="submit" name="UTT" value="Lähetä" />
		</form>
	</div>
	';
}
function tyotilaus_poisto(){
	if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
	$kayttajatunnus = $_SESSION['kayttajatunnus'];
	$kysely="SELECT AVAIN, TILAAJA, KUVAUS, TILAUSPVM, STATUS FROM tyotilaukset WHERE AVAIN = '".$_GET['avain']."' AND TILAAJA = '".$kayttajatunnus."' ";
	$tulos = mysql_query($kysely);
	$rivi = mysql_fetch_array($tulos);
	if(!empty($rivi['TILAUSPVM'])){
		$TILAUSPVM = date("d.m.Y", strtotime($rivi['TILAUSPVM']));
	}
	else{
		$TILAUSPVM = ' ';
	}
	return '
	<div class="center">
		<h2 íd="poisto">TYÖTILAUKSEN POISTO</h2>
		<p>Oletko varma että haluat poistaa työtilauksen:</p>
		<form id="PTT" method="POST" action="sovellus.php?pId=UTP&avain='.$rivi['AVAIN'].' ">
			<label>Tilaaja: </label>'.$rivi['TILAAJA'].'<br>
			<label>Työn kuvaus: </label><br>'.$rivi ['KUVAUS'].'<br>
			<label>Tilauspvm: </label>'.$TILAUSPVM.'<br>
			<label>STATUS: </label>'.$rivi['STATUS'].'<br>
			<input type="submit" name="PTT" value="Poista" />
			<a href="sovellus.php?pId=tyotilaukset">Peruuta</a>
		</form>
	</div>
	';
}
function tyotilaus_muokkaa(){
	if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
	$kayttajatunnus = $_SESSION['kayttajatunnus'];
	$kysely="SELECT AVAIN, TILAAJA, KUVAUS, TILAUSPVM, STATUS FROM tyotilaukset WHERE AVAIN = '".$_GET['avain']."' AND TILAAJA = '".$kayttajatunnus."' ";
	$tulos = mysql_query($kysely);
	$rivi = mysql_fetch_array($tulos);
	if(!empty($rivi['TILAUSPVM'])){
		$TILAUSPVM = date("d.m.Y", strtotime($rivi['TILAUSPVM']));
	}
	else{
		$TILAUSPVM = ' ';
	}
	if(!isset($_SESSION['kayttajatunnus'])) {
		header('Location: etusivu.php?pId=login');
	}
	return '
	<div class="center">
		<h2>TYÖTILAUKSEN MUOKKAUS</h2>
		<form id="MTT" method="POST" action="sovellus.php?pId=MTT&avain='.$rivi['AVAIN'].' ">
			<label>Tilaaja: </label>'.$rivi['TILAAJA'].'<br>
			<label>Tilauspvm: </label>'.$TILAUSPVM.'<br>
			<label>STATUS: </label>'.$rivi['STATUS'].'<br>
			<label>Vanha työn kuvaus: </label>'.$rivi['KUVAUS'].'<br>
			<label>Uusi työn kuvaus: </label><br><textarea form="MTT" name="kuvaus"></textarea><br>
			<input type="submit" name="MTT" value="Muokkaa" />
			<a href="sovellus.php?pId=tyotilaukset">Peruuta</a>
		</form>
	</div>
	';
}
function tyotilaus_aloitus(){
	if($_GET['pId'] == 'ATT' && isset($_SESSION['kayttajatunnus']) ){
		if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
		$kysely="SELECT TILAAJA, KUVAUS, TILAUSPVM, STATUS FROM tyotilaukset WHERE AVAIN = '".$_GET['avain']."' ";
		$tulos = mysql_query($kysely);
		$rivi = mysql_fetch_array($tulos);
		$_SESSION['avain'] = $_GET['avain'];
		if(!empty($rivi['TILAUSPVM'])){
			$TILAUSPVM = date("d.m.Y", strtotime($rivi['TILAUSPVM']));
		}
		else{
			$TILAUSPVM = ' ';
		}
	}
	return '
	<div class="center">
		<h2>ALOITA TYÖTILAUS</h2>
		<table>
			<form method="POST" action="">
				<tr>
					<td><label>Tilaaja: </label></td> 
					<td>' .$rivi['TILAAJA']. '</td>
				</tr>
				<tr>
					<td><label>Työn kuvaus: </label></td>
					<td>' .$rivi['KUVAUS']. '</td>
				</tr>
				<tr>
					<td><label>Tilauspvm: </label></td>
					<td>' .$TILAUSPVM. '</td>
				</tr>
				<tr>
					<td><label>STATUS: </label></td>
					<td>' .$rivi['STATUS']. '</td>
				</tr>
				<tr>
					<td><label style="color:red">Merkitse aloituspvm: </label></td>
					<td><input type="text" name="aloituspvm"></td>
				</tr>
				<tr>
					<td><input type="submit" name="aloitus" value="Lähetä" /></td>
					<td><a href="sovellus.php?pId=tyotilaukset">Peruuta</a></td>	
				</tr>
			</form>
		</table>
	</div>
		';
}
function tyotilaus_valmistuminen(){
	if($_GET['pId'] == 'VTT' && isset($_SESSION['kayttajatunnus']) ){
		if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
		$kysely="SELECT TILAAJA, KUVAUS, TILAUSPVM, ALOITUSPVM, STATUS FROM tyotilaukset WHERE AVAIN = '".$_GET['avain']."' ";
		$tulos = mysql_query($kysely);
		$rivi = mysql_fetch_array($tulos);
		$_SESSION['avain'] = $_GET['avain'];
		if(!empty($rivi['TILAUSPVM'])){
			$TILAUSPVM = date("d.m.Y", strtotime($rivi['TILAUSPVM']));
		}
		else{
			$TILAUSPVM = ' ';
		}
		if(!empty($rivi['ALOITUSPVM'])){
			$ALOITUSPVM = date("d.m.Y", strtotime($rivi['ALOITUSPVM']));
		}
		else{
			$ALOITUSPVM = ' ';
		}
	}
	return '
	<div class="center">
		<h2>VALMIS TYÖTILAUS</h2>
		<table>
			<form id="VTT" method="POST" action="">
				<tr>
					<td><label>Tilaaja: </label></td> 
					<td>' .$rivi['TILAAJA']. '</td>
				</tr>
				<tr>
					<td><label>Työn kuvaus: </label></td>
					<td>' .$rivi['KUVAUS']. '</td>
				</tr>
				<tr>
					<td><label>Tilauspvm: </label></td>
					<td>' .$TILAUSPVM. '</td>
				</tr>
				<tr>
					<td><label>Aloituspvm: </label></td>
					<td>' .$ALOITUSPVM. '</td>
				</tr>
				<tr>
					<td><label>STATUS: </label></td>
					<td>' .$rivi['STATUS']. '</td>
				</tr>
				<tr>
					<td><label>Työkommentti: </label></td>
					<td><textarea name="tyokommentti" form="VTT"></textarea></td>
				</tr>
				<tr>
					<td><label>Tuntimäärä: </label></td>
					<td><input type="text" name="tuntimaara"></td>
				</tr>
				<tr>
					<td><label>Tarvikkeet: </label></td>
					<td><textarea form="VTT" name="tarvikkeet"></textarea></td>
				</tr>
				<tr>
					<td><label>Kustannusarvio: </label></td>
					<td><input type="text" name="kustannusarvio"></td>
				</tr>
				<tr>
					<td><label style="color:red">Merkitse valmistumispvm: </label></td>
					<td><input type="text" name="valmistumispvm"></td>
				</tr>
				<tr>
					<td><input type="submit" name="valmistuminen" value="Lähetä" /></td>
					<td><a href="sovellus.php?pId=tyotilaukset">Peruuta</a></td>
				</tr>
			</form>
		</table>
	</div>
		';
}
function tyotilaus_hyvaksyminen(){
	if($_GET['pId'] == 'HTT' && isset($_SESSION['kayttajatunnus']) ){
		if(!isset($_SESSION['kayttajatunnus'])) {header('Location: etusivu.php?pId=login');}
		$kysely="SELECT TILAAJA, KUVAUS, TILAUSPVM, ALOITUSPVM, VALMISTUMISPVM, TYOKOMMENTTI, TUNTIMAARA, TARVIKKEET, KUSTANNUSARVIO, STATUS FROM tyotilaukset WHERE AVAIN = '".$_GET['avain']."' ";
		$tulos = mysql_query($kysely);
		$rivi = mysql_fetch_array($tulos);
		$_SESSION['avain'] = $_GET['avain'];
		if(!empty($rivi['TILAUSPVM'])){
			$TILAUSPVM = date("d.m.Y", strtotime($rivi['TILAUSPVM']));
		}
		else{
			$TILAUSPVM = ' ';
		}
		if(!empty($rivi['ALOITUSPVM'])){
			$ALOITUSPVM = date("d.m.Y", strtotime($rivi['ALOITUSPVM']));
		}
		else{
			$ALOITUSPVM = ' ';
		}
		if(!empty($rivi['VALMISTUMISPVM'])){
			$VALMISTUMISPVM = date("d.m.Y", strtotime($rivi['VALMISTUMISPVM']));
		}
		else{
			$VALMISTUMISPVM = ' ';
		}
	}
	return '
	<div class="center">
		<h2>HYVÄKSY TYÖTILAUS</h2>
		<table>
			<form id="VTT" method="POST" action="">
				<tr>
					<td><label>Tilaaja: </label></td> 
					<td>' .$rivi['TILAAJA']. '</td>
				</tr>
				<tr>
					<td><label>Työn kuvaus: </label></td>
					<td>' .$rivi['KUVAUS']. '</td>
				</tr>
				<tr>
					<td><label>Tilauspvm: </label></td>
					<td>' .$TILAUSPVM. '</td>
				</tr>
				<tr>
					<td><label>Aloituspvm: </label></td>
					<td>' .$ALOITUSPVM. '</td>
				</tr>
				<tr>
					<td><label>Valmistumispvm: </label></td>
					<td>' .$VALMISTUMISPVM. '</td>
				</tr>
				<tr>
					<td><label>Työkommentti: </label></td>
					<td>' .$rivi['TYOKOMMENTTI']. '</td>
				</tr>
				<tr>
					<td><label>Tuntimäärä: </label></td>
					<td>' .$rivi['TUNTIMAARA']. '</td>
				</tr>
				<tr>
					<td><label>Tarvikkeet: </label></td>
					<td>' .$rivi['TARVIKKEET']. '</td>
				</tr>
				<tr>
					<td><label>Kustannusarvio: </label></td>
					<td>' .$rivi['KUSTANNUSARVIO']. '</td>
				</tr>
				<tr>
					<td><label>STATUS: </label></td>
					<td>' .$rivi['STATUS']. '</td>
				</tr>
				<tr>
					<td><label style="color:red">Merkitse hyväksymispäivämäärä: </label></td>
					<td><input  type="text" name="hyvaksymispvm"></td>
				</tr
				<tr>
					<td><input type="submit" name="hyvaksyminen" value="Hyväksy" /></td>
					<td><a href="sovellus.php?pId=tyotilaukset">Peruuta</a></td>
				</tr>
			</form>
		</table>
	</div>
		';
}
?>

