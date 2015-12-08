<?php
require_once("db.inc");
session_start();
include('sisalto.php');
include('dbedit.php');


?>

<!DOCTYPE html> 
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fi" lang="fi">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="tyyli.css">
	</head>
	<body>
		<div id="main tttp">
			<div id="navbar">
				<ul>
					<li><a href="toimintolista.php">Toimintolista</a></li>
					<li><a href="sovellus.php?pId=tyotilaukset">Työtilaukset</a></li>
					<?php if($_SESSION['kayttajatunnus'] == 'admin' ){echo'<li><a href="sovellus.php?pId=asiakkaat">Asiakkaat</a></li>';}?>
					<li style="float:right">Olet kirjautunut käyttäjätunnuksella <a id="kayttajatunnus" href="sovellus.php?pId=muokkaa"><?php echo $_SESSION['kayttajatunnus'];?></a> <a href="sovellus.php?pId=logout">Kirjaudu ulos</a></li>
				</ul>
				<hr>
			</div>
<?php
if(isset($_SESSION['kayttajatunnus'])) {
	if(!isset($_GET['pId'])){
		header('Location: ?pId=tyotilaukset');
	}
	else{
		switch($_GET['pId']){
			default:
			case 'tyotilaukset':
				if(($_GET['pId'] = 'tyotilaukset') && isset($_SESSION['kayttajatunnus']) ){
					if(isset($_GET['asiakas']) && $_SESSION['kayttajatunnus'] = 'admin' ){
						$kysely1="SELECT AVAIN, TILAAJA, KUVAUS, TILAUSPVM, ALOITUSPVM, VALMISTUMISPVM, HYVAKSYMISPVM, TYOKOMMENTTI, TUNTIMAARA, TARVIKKEET, KUSTANNUSARVIO, STATUS FROM tyotilaukset WHERE TILAAJA = '".$_GET['asiakas']."' ";
					}
					else if($_SESSION['kayttajatunnus'] == 'admin'){
						$kysely1="SELECT AVAIN, TILAAJA, KUVAUS, TILAUSPVM, ALOITUSPVM, VALMISTUMISPVM, HYVAKSYMISPVM, TYOKOMMENTTI, TUNTIMAARA, TARVIKKEET, KUSTANNUSARVIO, STATUS FROM tyotilaukset";
					}
					else{
						$kysely1="SELECT AVAIN, TILAAJA, KUVAUS, TILAUSPVM, ALOITUSPVM, VALMISTUMISPVM, HYVAKSYMISPVM, TYOKOMMENTTI, TUNTIMAARA, TARVIKKEET, KUSTANNUSARVIO, STATUS FROM tyotilaukset WHERE TILAAJA = '".$_SESSION['kayttajatunnus']."' ";
					}
					$tulos1 = mysql_query($kysely1);

					if(isset($_GET['asiakas']) && $_SESSION['kayttajatunnus'] == 'admin' ){
						$kysely2="SELECT AVAIN, TILAAJA, KUVAUS, JATTAMISPVM, VASTAAMISPVM, KUSTANNUSARVIO, STATUS FROM tarjouspyynnot WHERE TILAAJA = '".$_GET['asiakas']."' ";
					}
					else if($_SESSION['kayttajatunnus'] == 'admin' ){
						$kysely2="SELECT AVAIN, TILAAJA, KUVAUS, JATTAMISPVM, VASTAAMISPVM, KUSTANNUSARVIO, STATUS FROM tarjouspyynnot";
					}
					else{
						$kysely2="SELECT AVAIN, TILAAJA, KUVAUS, JATTAMISPVM, VASTAAMISPVM, KUSTANNUSARVIO, STATUS FROM tarjouspyynnot WHERE TILAAJA = '".$_SESSION['kayttajatunnus']."' ";
					}
					$tulos2 = mysql_query($kysely2);
				}
			if(!empty($tulos1)){
				echo '
					<div class="lista tyotilaukset">
						<h2>TYÖTILAUKSET</h2>
						';
							if($_SESSION['kayttajatunnus'] != 'admin'){
								echo '<p><a href="sovellus.php?pId=UTT">Tee uusi työtilaus.</a></p>';
							}echo '
						<table>
							<tr>
								<td><label>Tilaaja </label></td>
								<td><label>Kuvaus työstä </label></td>
								<td><label>Tilauspvm </label></td>
								<td><label>Aloituspvm </label></td>
								<td><label>Valmistumispvm </label></td>
								<td><label>Hyväksymispvm </label></td>
								<td><label>Työn kommentti </label></td>
								<td><label>Tuntimäärä </label></td>
								<td><label>Kuluneet tarvikkeet </label></td>
								<td><label>Kustannusarvio </label></td>
								<td><label>STATUS </label></td>
							</tr>';
			
				while($rivi1 = mysql_fetch_array($tulos1) ){
					if(!empty($rivi1['TILAUSPVM'])){
						$TILAUSPVM = date("d.m.Y", strtotime($rivi1['TILAUSPVM']));
					}
					else{
						$TILAUSPVM = ' ';
					}
					if(!empty($rivi1['ALOITUSPVM'])){
						$ALOITUSPVM = date("d.m.Y", strtotime($rivi1['ALOITUSPVM']));
					}
					else{
						$ALOITUSPVM = ' ';
					}
					if(!empty($rivi1['VALMISTUMISPVM'])){
						$VALMISTUMISPVM = date("d.m.Y", strtotime($rivi1['VALMISTUMISPVM']));
					}
					else{
						$VALMISTUMISPVM = ' ';
					}
					if(!empty($rivi1['HYVAKSYMISPVM'])){
						$HYVAKSYMISPVM = date("d.m.Y", strtotime($rivi1['HYVAKSYMISPVM']));
					}
					else{
						$HYVAKSYMISPVM = ' ';
					}
				echo "
							<tr>
								<td>" .$rivi1['TILAAJA']."</td>
								<td>" .$rivi1['KUVAUS']. "</td>
								<td>" .$TILAUSPVM. "</td>
								<td>" .$ALOITUSPVM. "</td>
								<td>" .$VALMISTUMISPVM. "</td>
								<td>" .$HYVAKSYMISPVM. "</td>
								<td>" .$rivi1['TYOKOMMENTTI']. "</td>
								<td>" .$rivi1['TUNTIMAARA']. "</td>
								<td>" .$rivi1['TARVIKKEET']. "</td>
								<td>" .$rivi1['KUSTANNUSARVIO']. "</td>
								<td>" .$rivi1['STATUS']. "</td>			
				";			
							if($rivi1['STATUS'] == 'TILATTU' && $_SESSION['kayttajatunnus'] != 'admin' ){
								echo '<td><a href="sovellus.php?pId=PTT&avain='.$rivi1['AVAIN'].'">Poista</a></td>';
								echo '<td><a href="sovellus.php?pId=MTT&avain='.$rivi1['AVAIN'].'">Muokkaa</a></td>';
							}
							else if($rivi1['STATUS'] == 'TILATTU' && $_SESSION['kayttajatunnus'] == 'admin'){
								echo '<td><a href="sovellus.php?pId=ATT&avain='.$rivi1['AVAIN'].'">Merkitse aloituspvm</a></td>';
							}
							else if($rivi1['STATUS'] == 'ALOITETTU' && $_SESSION['kayttajatunnus'] == 'admin'){
								echo '<td><a href="sovellus.php?pId=VTT&avain='.$rivi1['AVAIN'].'">Merkitse valmistumispvm</a></td>';
							}
							else if($rivi1['STATUS'] == 'VALMIS' && $_SESSION['kayttajatunnus'] != 'admin'){
								echo '<td><a href="sovellus.php?pId=HTT&avain='.$rivi1['AVAIN'].'">Hyväksy työtilaus</a></td>';
							}
				}echo '		</tr>
						</table>
					</div>
				';
			}
			else if($_SESSION['kayttajatunnus'] != 'admin'){
				echo '<p><a href="sovellus.php?pId=UTP">Tee uusi tarjouspyyntö.</a></p>';
			}
			if(!empty($tulos1)){
				echo '
					<div class="lista tarjouspyynnot">
						<hr>
							<h2>TARJOUSPYYNNÖT</h2>';
							if($_SESSION['kayttajatunnus'] != 'admin'){
								echo '<p><a href="sovellus.php?pId=UTP">Tee uusi tarjouspyyntö.</a></p>';
							}echo '
							<table>
								<tr>
									<td><label>Tilaaja </label></td>
									<td><label>Kuvaus työstä </label></td>
									<td><label>Jättämispvm </label></td>
									<td><label>Vastaamispvm </label></td>
									<td><label>Kustannusarvio </label></td>
									<td><label>STATUS </label></td>
								</tr>';
				
				while($rivi2 = mysql_fetch_array($tulos2) ){
					if(!empty($rivi2['JATTAMISPVM'])){
						$JATTAMISPVM = date("d.m.Y", strtotime($rivi2['JATTAMISPVM']));
					}
					else{
						$JATTAMISPVM = ' ';
					}
					if(!empty($rivi2['VASTAAMISPVM'])){
						$VASTAAMISPVM = date("d.m.Y", strtotime($rivi2['VASTAAMISPVM']));
					}
					else{
						$VASTAAMISPVM = ' ';
					}
				echo "
							<tr>
									<td>" .$rivi2['TILAAJA']."</td>
									<td>" .$rivi2['KUVAUS']. "</td>
									<td>" .$JATTAMISPVM . "</td>
									<td>" .$VASTAAMISPVM. "</td>
									<td>" .$rivi2['KUSTANNUSARVIO']. "</td>
									<td>" .$rivi2['STATUS']. "</td>
									";
						if(($rivi2['STATUS'] == 'JÄTETTY' || $rivi2['STATUS'] == 'JATETTY' )&& $_SESSION['kayttajatunnus'] == 'admin'){
							echo '<td><a href="sovellus.php?pId=UTP&avain='.$rivi2['AVAIN'].'">Anna kustannusarvio</a></td>';
						}
						else if(($rivi2['STATUS'] == 'JÄTETTY' || $rivi2['STATUS'] == 'JATETTY' ) && $_SESSION['kayttajatunnus'] != 'admin'){
							echo '<td><a href="sovellus.php?pId=PTP&avain='.$rivi2['AVAIN'].'">Poista</a></td>';
						}
						else if($rivi2['STATUS'] == 'VASTATTU' && $_SESSION['kayttajatunnus'] != 'admin'){
							echo '<td><a href="sovellus.php?pId=hyvaksyTP&avain='.$rivi2['AVAIN'].'">Hyväksy</a></td><td><a href="sovellus.php?pId=hylkaaTP&avain='.$rivi2['AVAIN'].'">Hylkää</a></td>';
						}
					}
					echo '
							</tr>
						</table>
					</div>';
			}
			else if($_SESSION['kayttajatunnus' != 'admin']){
				echo '<p><a href="sovellus.php?pId=UTP">Tee uusi tarjouspyyntö.</a></p>';
			}
			break;
			//työtilaukset
			case 'PTT':
				if (isset($_GET['avain'])) {
					echo tyotilaus_poisto();
				}
				break;
			case 'UTT':
				echo tyotilaus_uusi();
				break;
			case 'ATT':
				if(isset($_GET['avain'])){
					echo tyotilaus_aloitus();
				}
				break;
			case 'VTT':
				if(isset($_GET['avain'])){
					echo tyotilaus_valmistuminen();
				}
				break;
			case 'HTT':
				if(isset($_GET['avain'])){
					echo tyotilaus_hyvaksyminen();
				}
				break;
			case 'MTT':
				if(isset($_GET['avain'])){
					echo tyotilaus_muokkaa();
				}
				break;
			//tarjouspyynnöt
			case 'UTP':
				if (isset($_GET['avain'])) {
					echo tarjouspyynto_kustannusarvio();
				}
				else{
					echo tarjouspyynto();
				}
				break;
			case 'PTP':
				if(isset($_GET['avain']) ){
					echo tarjouspyynto_poisto();
				}
				break;
			case 'asiakkaat':
				if(isset($_SESSION['kayttajatunnus']) ){
					if($_SESSION['kayttajatunnus'] == 'admin'){
						$kysely3="SELECT AVAIN, KAYTTAJATUNNUS, NIMI, KAYNTIOSOITE, LASKUTUSOSOITE, PUHELINNUMERO, SAHKOPOSTI, ASUNTOTYYPPI, PINTAALA, TONTTIKOKO, LUONTIPVM FROM asiakkaat";
						$tulos3 = mysql_query($kysely3);
					}	
				}
				if(!empty($tulos3)){
					echo '
						<div class="lista asiakkaat">
							<h2>ASIAKKAAT</h2>
							';
								if($_SESSION['kayttajatunnus'] != 'admin'){
									echo '<p><a href="sovellus.php?pId=UTT">Tee uusi työtilaus.</a></p>';
								}echo '
							<table>
								<tr>
									<td><label>Käyttäjätunnus/tilaajanimi </label></td>
									<td><label>Nimi </label></td>
									<td><label>Käyntiosoite </label></td>
									<td><label>Laskutusosoite </label></td>
									<td><label>Puhelinnumero </label></td>
									<td><label>Sähköposti </label></td>
									<td><label>Asuntotyyppi </label></td>
									<td><label>Pinta-ala </label></td>
									<td><label>Tonttikoko </label></td>
									<td><label>Luontipvm </label></td>
								</tr>';
				
					while($rivi3 = mysql_fetch_array($tulos3) ){
						if($rivi3['KAYTTAJATUNNUS'] != 'admin'){
							if(!empty($rivi3['LUONTIPVM'])){
								$LUONTIPVM = date("d.m.Y", strtotime($rivi3['LUONTIPVM']));
							}
							else{
								$LUONTIPVM = ' ';
							}
						echo "
							<tr>
								<td>" .$rivi3['KAYTTAJATUNNUS']."</td>
								<td>" .$rivi3['NIMI']. "</td>
								<td>" .$rivi3['KAYNTIOSOITE']. "</td>
								<td>" .$rivi3['LASKUTUSOSOITE']. "</td>
								<td>" .$rivi3['PUHELINNUMERO']. "</td>
								<td>" .$rivi3['SAHKOPOSTI']. "</td>
								<td>" .$rivi3['ASUNTOTYYPPI']. "</td>
								<td>" .$rivi3['PINTAALA']. "</td>
								<td>" .$rivi3['TONTTIKOKO']. "</td>
								<td>" .$LUONTIPVM. "</td>		
							";			
						echo '<td><a href="sovellus.php?pId=tyotilaukset&asiakas='.$rivi3['KAYTTAJATUNNUS'].'">Katso asiakkaan työtilaukset ja tarjouspyynnöt</a></td>';
						}	
					}
					echo '		</tr>
							</table>
						</div>
					';
				}	
				break;
			case 'muokkaa':
				echo muokkaa();
				break;
			case 'logout':
				unset($_SESSION['kayttajatunnus']);
				header('Location: etusivu.php?pId=login');
				break;
		}
	}
}
else{
	header('Location: etusivu.php?pId=login');
}
?>
		</div>
	</body>
</html>