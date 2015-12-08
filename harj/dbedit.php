<?php
//KIRJAUTUMINEN
{
	if( isset($_POST['login']) ){
		if(!empty($_POST['kayttajatunnus']) &&  !empty($_POST['salasana']) ){

			$kayttajatunnus = $_POST['kayttajatunnus'];
			$salasana = $_POST['salasana'];

			$kysely="SELECT KAYTTAJATUNNUS, SALASANA FROM asiakkaat WHERE kayttajatunnus = '$kayttajatunnus' AND salasana = '$salasana' ";
			$tulos = mysql_query($kysely);		
			$rivimaara = mysql_num_rows($tulos);
			
			if($rivimaara == 1){
				$_SESSION['kayttajatunnus'] = $kayttajatunnus;
			}
			else{
				echo '<div class="virhe"><p>Käyttäjätunnus tai salasana oli väärin!</p></div>';
			}
		}	
		else{
			echo '<div class="virhe"><p>Täytä kaikki kentät!</p></div>';
			}
	}
}
//REKISTERÖINTI
{
	if( isset($_POST['register']) ){
		if(!empty($_POST['kayttajatunnus']) &&  !empty($_POST['salasana']) && !empty($_POST['salasana_re']) && !empty($_POST['nimi']) && !empty($_POST['kayntiosoite']) && !empty($_POST['laskutusosoite']) && !empty($_POST['puhelinnumero']) && !empty($_POST['sahkoposti']) ){
				$kayttajatunnus = $_POST['kayttajatunnus'];

				if(mysql_num_rows(mysql_query("SELECT KAYTTAJATUNNUS FROM asiakkaat WHERE kayttajatunnus = '$kayttajatunnus' ")) == 0){
					if($_POST['salasana'] == $_POST['salasana_re']){
						mysql_query("INSERT INTO asiakkaat (KAYTTAJATUNNUS, SALASANA, NIMI, KAYNTIOSOITE, LASKUTUSOSOITE, PUHELINNUMERO, SAHKOPOSTI, ASUNTOTYYPPI, PINTAALA, TONTTIKOKO, LUONTIPVM)
						VALUES ('".$_POST['kayttajatunnus']."' , '".$_POST['salasana']."' , '".$_POST['nimi']."' , '".$_POST['kayntiosoite']."' , '".$_POST['laskutusosoite']."' , '".$_POST['puhelinnumero']."' , '".$_POST['sahkoposti']."' , '".$_POST['asuntotyyppi']."' , '".$_POST['pintaala']."' , '".$_POST['tonttikoko']."', '".date( 'Y-m-d')."' ) ");

						echo '<p>Kiitos rekisteröinnistä!</p>';
					}
					else{
						echo '<div class="virhe"><p>Salasanat eivät täsmää!</p></div>';
					}
				}
				else{
					echo '<div class="virhe"><p>Käyttäjätunnus on jo käytössä!</p></div>';
				}
		}
		else{
			echo '<div class="virhe"><p>Täytä kaikki pakolliset kentät!</p></div>';
		}
	}
}
//MUOKKAA
{
	if(isset($_POST['muokkaa'])){
		$kayttajatunnus = $_SESSION['kayttajatunnus'];
		if(!empty($_POST['salasana'])){
		mysql_query("UPDATE asiakkaat SET SALASANA = '".$_POST['salasana']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}

		if(!empty($_POST['nimi'])){
			mysql_query("UPDATE asiakkaat SET NIMI = '".$_POST['nimi']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}

		if(!empty($_POST['kayntiosoite'])){
			mysql_query("UPDATE asiakkaat SET KAYNTIOSOITE = '".$_POST['kayntiosoite']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}

		if(!empty($_POST['laskutusosoite'])){
			mysql_query("UPDATE asiakkaat SET LASKUTUSOSOITE = '".$_POST['laskutusosoite']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}

		if(!empty($_POST['puhelinnumero'])){
			if (strlen($_POST['puhelinnumero']) > 13){
				echo '<p class="virhe">Liian pitkä puhelinnumero!</p>';
			}
			else if (strlen($_POST['puhelinnumero']) < 5){
				echo '<p class="virhe">Liian lyhyt puhelinnumero!</p>';
			}
			else{
				mysql_query("UPDATE asiakkaat SET PUHELINNUMERO = '".$_POST['puhelinnumero']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
			}
		}

		if(!empty($_POST['sahkoposti'])){
			mysql_query("UPDATE asiakkaat SET SAHKOPOSTI = '".$_POST['sahkoposti']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}

		if(!empty($_POST['asuntotyyppi'])){
			mysql_query("UPDATE asiakkaat SET ASUNTOTYYPPI = '".$_POST['asuntotyyppi']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}

		if(!empty($_POST['pintaala'])){
			mysql_query("UPDATE asiakkaat SET PINTAALA = '".$_POST['pintaala']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}

		if(!empty($_POST['tonttikoko'])){
			mysql_query("UPDATE asiakkaat SET TONTTIKOKO = '".$_POST['tonttikoko']."' WHERE kayttajatunnus = '".$_SESSION['kayttajatunnus']."' ");
		}
	}
}

//TYÖTILAUKSET
{
	//UUSI
	if(isset($_POST['UTT'])){
		if(!empty($_POST['kuvaus']) ){
			mysql_query("INSERT INTO tyotilaukset (TILAAJA, KUVAUS, TILAUSPVM, STATUS) VALUES ('".$_SESSION['kayttajatunnus']."', '".$_POST['kuvaus']."', '".date( 'Y-m-d')."', 'TILATTU') ");
			header('Location:sovellus.php?pId=tyotarjoukset');
		}
		else{
			echo '<p class="virhe">Kirjoita työn kuvaus!</p>';
		}
	}
	//POISTAMINEN
	if(isset($_POST['PTT'])){
			mysql_query("DELETE FROM tyotilaukset WHERE TILAAJA = '".$_SESSION['kayttajatunnus']."' AND AVAIN = '".$_GET['avain']."' ");
			header('Location: sovellus.php?pId=tyotarjoukset');
		}

	//ALOITUS
	if(isset($_POST['aloitus'])){
		if(!empty($_POST['aloituspvm'])){
			$c_aloituspvm = date_create_from_format("d.m.Y", $_POST['aloituspvm']);
			if($c_aloituspvm == TRUE && strlen($_POST['aloituspvm']) < 11){
				$aloituspvm = date("d.m.Y", strtotime($_POST['aloituspvm']) );
				mysql_query("UPDATE tyotilaukset SET ALOITUSPVM = '".$aloituspvm."', STATUS = 'ALOITETTU' WHERE avain = '".$_SESSION['avain']."' ");
				header('Location: sovellus.php?pId=tyotarjoukset');
			}
			else{
				echo '<p class="virhe">Kirjoita aloituspvm muodossa pp.kk.vvvv!</p>';
			}		
		}
		else{
			echo '<p class="virhe">Kirjoita aloituspvm!</p>';
		}
	}

	//VALMISTUMINEN
	if(isset($_POST['valmistuminen'])){
		if(!empty($_POST['tyokommentti']) && !empty($_POST['tuntimaara']) && !empty($_POST['tarvikkeet']) && !empty($_POST['kustannusarvio']) && !empty($_POST['valmistumispvm'])){
			if(ctype_digit($_POST['tuntimaara'])){
				$tuntimaara = intval($_POST['tuntimaara']);

				$c_valmistumispvm = date_create_from_format("d.m.Y", $_POST['valmistumispvm']);
				if($c_valmistumispvm == TRUE && strlen($_POST) < 11){
					$valmistumispvm = date("d.m.Y", strtotime($_POST['valmistumispvm']) );
					mysql_query("UPDATE tyotilaukset SET VALMISTUMISPVM = '".$valmistumispvm."', TYOKOMMENTTI = '".$_POST['tyokommentti']."', TARVIKKEET = '".$_POST['tarvikkeet']."', 
					KUSTANNUSARVIO = '".$_POST['kustannusarvio']."', TUNTIMAARA = '".$tuntimaara."', STATUS = 'VALMIS' WHERE avain = '".$_SESSION['avain']."' ");
					header('Location: sovellus.php?pId=tyotarjoukset');
				}
				else{
					echo '<p class="virhe">Kirjoita valmistumispvm muodossa pp.kk.vvvv!</p>';
				}		
			}
			else{
				echo '<p class="virhe">Anna tuntimäärä oikeassa muodossa(vain kokonaisia tunteja)!</p>';
			}
		}
		else{
			echo '<p class="virhe">Täytä kaikki kentät!</p>';
		}
	}

	//HYVÄKSYMINEN
	if(isset($_POST['hyvaksyminen'])){
		if(!empty($_POST['hyvaksymispvm'])){
			$c_hyvaksymispvm = date_create_from_format("d.m.Y", $_POST['hyvaksymispvm']);
			if($c_hyvaksymispvm == TRUE && strlen($_POST) < 11){
				$hyvaksymispvm = date("d.m.Y", strtotime($_POST['hyvaksymispvm']) );
				mysql_query("UPDATE tyotilaukset SET HYVAKSYMISPVM = '".$hyvaksymispvm."', STATUS = 'HYVÄKSYTTY' WHERE avain = '".$_SESSION['avain']."' ");
				header('Location: sovellus.php?pId=tyotarjoukset');
			}
			else{
				echo '<p class="virhe">Kirjoita hyväksymispvm muodossa pp.kk.vvvv!</p>';
			}
		}
		else{
			echo '<p class="virhe">Kirjoita hyväksymispäivämäärä!</p>';
		}
	}

	//MUOKKAA TT
	if(isset($_POST['MTT'])){
		if(!empty($_POST['kuvaus']) ){
			mysql_query("UPDATE tyotilaukset SET KUVAUS = '".$_POST['kuvaus']."' WHERE avain = '".$_GET['avain']."' ");
			header('Location: sovellus.php?pId=tyotilaukset');
		}
		else{
			echo '<p class="virhe">Täytä kuvaus-kenttä!</p>';
		}
	}
}
//TARJOUSPYYNNÖT
{
	if (isset($_POST['UTP']) && isset($_SESSION['kayttajatunnus'])  ){
		if(!empty($_POST['kuvaus']) ){
			$kayttajatunnus = $_SESSION['kayttajatunnus'];
		$STATUS = 'JÄTETTY';
		mysql_query("INSERT INTO tarjouspyynnot (TILAAJA, KUVAUS, JATTAMISPVM, STATUS)
		VALUES ('".$kayttajatunnus."' , '".$_POST['kuvaus']."' , '".date( 'Y-m-d')."' , '".$STATUS."')");

		header('Location: sovellus.php?pId=tyotilaukset');
		}
		else{
			echo '<p class="virhe">Et voi lähetää tyhjää tarjouspyyntöä!</p>';
		}
	}
		//KUSTANNUSARVIO
	if(isset($_POST['UTP_kustannusarvio'])){
		if(empty($_POST['kustannusarvio']) ){
			echo '<p class="virhe">Sinun on täytettävä kustannusarvio!</p>';
		}
		else{
			mysql_query("UPDATE tarjouspyynnot SET KUSTANNUSARVIO = '".$_POST['kustannusarvio']."', VASTAAMISPVM = '".date( 'Y-m-d')."', STATUS = 'VASTATTU' WHERE avain = '".$_GET['avain']."' ");
			header('Location: sovellus.php?pId=tyotarjoukset');
		}
	}
		//POISTO
	if(isset($_POST['PTP'])){
		mysql_query("DELETE FROM tarjouspyynnot WHERE tilaaja = '".$_SESSION['kayttajatunnus']."' AND avain = '".$_GET['avain']."' ");
		header('Location: sovellus.php?pId=tyotarjoukset');
	}
		//HYVÄKSYMINEN
	if($_GET['pId'] == 'hyvaksyTP'){
		mysql_query("UPDATE tarjouspyynnot SET STATUS = 'HYVÄKSYTTY' WHERE tilaaja = '".$_SESSION['kayttajatunnus']."' AND AVAIN = '".$_GET['avain']."' ");
		$kysely="SELECT TILAAJA, KUVAUS FROM tarjouspyynnot WHERE tilaaja = '".$_SESSION['kayttajatunnus']."' AND AVAIN = '".$_GET['avain']."' ";
		$tulos = mysql_query($kysely);
		$rivi = mysql_fetch_array($tulos);
		mysql_query("INSERT INTO tyotilaukset (TILAAJA, KUVAUS, TILAUSPVM, STATUS) VALUES ('".$rivi['TILAAJA']."', '".$rivi['KUVAUS']."', '".date( 'Y-m-d')."' ,'TILATTU') ");
		header('Location: sovellus.php?pId=tyotilaukset');
	}
		//HYLKÄÄMINEN
	if($_GET['pId'] == 'hylkaaTP'){
		mysql_query("UPDATE tarjouspyynnot SET STATUS = 'HYLÄTTY' WHERE tilaaja = '".$_SESSION['kayttajatunnus']."' AND AVAIN = '".$_GET['avain']."' ");
		header('Location: sovellus.php?pId=tyotilaukset');
	}
}
//ASIAKKAAT


?>