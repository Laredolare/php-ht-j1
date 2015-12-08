<?php

if(!empty($_GET['pelaaja_id'])){
	$kysely2="SELECT PELAAJA_ID, ETUNIMI, SUKUNIMI, SYNTYMAPAIVA, SUKUPUOLI, PUHNRO, EMAIL FROM pelaaja WHERE PELAAJA_ID = ". $_GET['pelaaja_id'] ." ";
	$tulos2 = mysql_query($kysely2);
	$rivi2 = mysql_fetch_array($tulos2);

	list($vv, $kk, $pp) = explode('-', $rivi2['SYNTYMAPAIVA']);
	$syntymapaiva = $pp . '.' . $kk . '.' . $vv;
	echo '
	<div id="pelaajan_tiedot-testit">
		<div id="pelaajan_tiedot">
			<h4>PELAAJAN TIEDOT</h4>
			<table>
				<tr>
					<td>Etunimi</td>
					<td>Sukunimi</td>
					<td>Syntymäpäivä</td> 
					<td>Sukupuoli</td>
					<td>Puhelinnumero</td> 
					<td>Sähköposti</td>
				</tr>
				<tr>
					<td>' .$rivi2['ETUNIMI']. '</td>
					<td>' .$rivi2['SUKUNIMI']. '</td>
					<td>' .$syntymapaiva. '</td>
					<td>' .$rivi2['SUKUPUOLI'] .'</td>
					<td>' .$rivi2['PUHNRO']. '</td>
					<td>' .$rivi2['EMAIL']. '</td>
					<form method="post" action="">
					<td><input class="muokkaaTietoja" type="submit" name="pelaajan_tiedot_muokkaa"></td>
					</form>
				</tr>
			</table>
		</div>
	';

	echo '
		<div id="pelaajan_testit">
			<h4>PELAAJAN TESTIT</h4>
			<div id="pelaajan_testit_ikaryhmat">
				<ul>
					<li onclick="window.location.replace(\'pelaajataulu.php?pelaaja_id=' . $_GET['pelaaja_id'] . '&kp=kp\');">Kaikki suoritukset</li>';
		$kysely3="SELECT PATTERI_ID, NIMI
		FROM testipatteri
		WHERE testipatteri.patteri_id in
		      (SELECT patteri_id 
		       FROM suoritus join
		            pelaaja 
		            on pelaaja.pelaaja_id = suoritus.pelaaja_id
		       WHERE suoritus.pelaaja_id = ". $_GET['pelaaja_id'] ."
		      )
		";
		$tulos3 = mysql_query($kysely3);
		while($rivi3 = mysql_fetch_array($tulos3)){
			if (!empty($_GET['patteri_id'])) {
				if ($_GET['patteri_id'] == $rivi3['PATTERI_ID']) {
					echo '<li class="valittuPatteri" onclick="nayta_patteri(event);" id="pelaaja_id='. $_GET['pelaaja_id'] .'&patteri_id=' .$rivi3['PATTERI_ID']. '" >' .$rivi3['NIMI']. '
					<span style="display:inline;font-size:10px;padding-left: 5%; float:right"> patteri_id =   '. $rivi3['PATTERI_ID'] .'</span></li>';
				}
				else{
					echo '<li onclick="nayta_patteri(event);" id="pelaaja_id='. $_GET['pelaaja_id'] .'&patteri_id=' .$rivi3['PATTERI_ID']. '" >' .$rivi3['NIMI']. '
					<span style="display:inline;font-size:10px;padding-left: 5%; float:right"> patteri_id =   '. $rivi3['PATTERI_ID'] .'</span></li>';
				}
			}
			else{
				echo '<li onclick="nayta_patteri(event);" id="pelaaja_id='. $_GET['pelaaja_id'] .'&patteri_id=' .$rivi3['PATTERI_ID']. '" >' .$rivi3['NIMI']. '
				<span style="display:inline;font-size:10px;padding-left: 5%; float:right"> patteri_id =   '. $rivi3['PATTERI_ID'] .'</span></li>';
			}
		}

		echo '
					</ul>
					<div id="pelaajan_testit_ikaryhmat_footer"> 
					</div>
				</div>

				<div id="pelaajan_testit_tulokset">
					<table>';
	if(!empty($_GET['pelaaja_id']) && (!empty($_GET['patteri_id']) || !empty($_GET['kp']) )) {
		if (!empty($_GET['kp'])) {
			$kysely4="SELECT testi.testi_id as testi_id, testi.nimi as nimi, testi.mittayksikko as mittayksikko
			FROM testi
			WHERE testi.testi_id in
			      (SELECT testi_id
			       FROM suoritus join
			            testipatteri
			            on testipatteri.patteri_id = suoritus.patteri_id
			       WHERE suoritus.pelaaja_id= ". $_GET['pelaaja_id'] ."
			      )
			";

			$kysely4a="SELECT tulos, pvm, patteri_id
			FROM suoritus join 
			testi
			on testi.testi_id = suoritus.testi_id
			WHERE suoritus.pelaaja_id = ". $_GET['pelaaja_id'] ."
			";

			$tulos4 = mysql_query($kysely4);
			$tulos4a = mysql_query($kysely4a);

			while($rivi4 = mysql_fetch_array($tulos4)){
				$rivi4a = mysql_fetch_array($tulos4a);
				list($vv, $kk, $pp) = explode('-', $rivi4a['pvm']);
				$suorituspvm = $pp . '.' . $kk . '.' . $vv;
			
				echo '	<p style="color:rgb(231, 138, 69); display:inline; padding-right:5%">'. $rivi4['nimi'] .'</p>
						<p style="display:inline;padding-right:1%">'. $rivi4a['tulos'] .'</p>
						<p style="display:inline;padding-right:5%">'. $rivi4['mittayksikko'] .'</p>
						<p style="display:inline;">'. $rivi4a['pvm'] .'</p>
						<span style="display:inline;font-size:10px;padding-left: 5%"> patteri_id =   '. $rivi4a['patteri_id'] .'</span><br>';

			}
		}
		else{
			$kysely4="SELECT testi_id, nimi, mittayksikko
			FROM testi
			WHERE testi.testi_id in
			      (SELECT testi_id
			       FROM suoritus join
			            testipatteri
			            on testipatteri.patteri_id = suoritus.patteri_id
			       WHERE testipatteri.patteri_id = ". $_GET['patteri_id'] ." AND suoritus.pelaaja_id= ". $_GET['pelaaja_id'] ."
			      )
			";

			$kysely4a="SELECT tulos, pvm, patteri_id
			FROM suoritus join 
			testi
			on testi.testi_id = suoritus.testi_id
			WHERE suoritus.pelaaja_id = ". $_GET['pelaaja_id'] ." AND suoritus.patteri_id = ". $_GET['patteri_id'] ."
			";

			$tulos4 = mysql_query($kysely4);
			$tulos4a = mysql_query($kysely4a);

			while($rivi4 = mysql_fetch_array($tulos4)){
				$rivi4a = mysql_fetch_array($tulos4a);
				echo '<p style="color:rgb(231, 138, 69); display:inline; padding-right:5%">'. $rivi4['nimi'] .'</p>
					<p style="display:inline;padding-right:1%">'. $rivi4a['tulos'] .'</p>
					<p style="display:inline;padding-right:5%">'. $rivi4['mittayksikko'] .'</p>
					<p style="display:inline">'. $rivi4a['pvm'] .'</p>
					<span style="display:inline; font-size:10px; padding-left:5%"> patteri_id =		'. $rivi4a['patteri_id'] .'</span><br>';
			}
		}	
	}
		echo '
					</table>
				</div>
			</div>
		</div>
	</div>
	';
}
else{
	echo '
	<div id="pelaajan_tiedot-testit">
		<div id="pelaajan_tiedot">
			<h4></h4>
			<p style="padding:0;margin:0% 0% 0% 1%">Pelaajaa ei ole valittu. Lisää uusi pelaaja painamalla <a href="uusipelaaja.php">tästä</a>.</p>
		</div>

	';

	echo '
		<div id="pelaajan_testit">
			<h4>PELAAJAN TESTIT</h4>
			<div id="pelaajan_testit_ikaryhmat">
				<ul>
				<li onclick="window.location.replace(\'pelaajataulu.php?kp=kp\');">Kaikki suoritukset</li>';

	$kysely3="SELECT PATTERI_ID, NIMI FROM testipatteri;";
	$tulos3 = mysql_query($kysely3);

	while($rivi3 = mysql_fetch_array($tulos3)){
			if (!empty($_GET['patteri_id'])) {
				if ($_GET['patteri_id'] == $rivi3['PATTERI_ID']) {
					echo '<li class="valittuPatteri" onclick="nayta_patteri(event);" id="patteri_id=' .$rivi3['PATTERI_ID']. '" >' .$rivi3['NIMI']. '
					<span style="display:inline;font-size:10px;padding-left: 5%; float:right"> patteri_id =   '. $rivi3['PATTERI_ID'] .'</span></li>';
				}
				else{
					echo '<li onclick="nayta_patteri(event);" id="patteri_id=' .$rivi3['PATTERI_ID']. '" >' .$rivi3['NIMI']. '
					<span style="display:inline;font-size:10px;padding-left: 5%; float:right"> patteri_id =   '. $rivi3['PATTERI_ID'] .'</span></li>';
				}
			}
			else{
				echo '<li onclick="nayta_patteri(event);" id="patteri_id=' .$rivi3['PATTERI_ID']. '" >' .$rivi3['NIMI']. '
				<span style="display:inline;font-size:10px;padding-left: 5%; float:right"> patteri_id =   '. $rivi3['PATTERI_ID'] .'</span></li>';
			}
		}

	echo '
				</ul>
				<div id="pelaajan_testit_ikaryhmat_footer"> 
				</div>
			</div>
			<div id="pelaajan_testit_tulokset">
	';

	if (!empty($_GET['patteri_id'])) {
		$kysely4="SELECT suoritus.pelaaja_id as pelaaja_id, suoritus.tulos as tulos, suoritus.pvm as pvm, suoritus.patteri_id as patteri_id, testi.mittayksikko as mittayksikko, testi.nimi as nimi FROM suoritus join testi on testi.testi_id = suoritus.testi_id WHERE suoritus.patteri_id = ". $_GET['patteri_id'] ." ORDER BY pelaaja_id";
		$kysely4a="SELECT pelaaja.pelaaja_id as pelaaja_id, CONCAT(pelaaja.etunimi, ' ', pelaaja.sukunimi) AS pelaaja FROM pelaaja join suoritus on suoritus.pelaaja_id = pelaaja.pelaaja_id WHERE suoritus.patteri_id = ". $_GET['patteri_id'] ." GROUP BY pelaaja_id ORDER BY pelaaja_id";	
	}
	else{
		$kysely4="SELECT suoritus.pelaaja_id as pelaaja_id, suoritus.tulos as tulos, suoritus.pvm as pvm,  suoritus.patteri_id as patteri_id, testi.mittayksikko as mittayksikko, testi.nimi as nimi FROM suoritus join testi on testi.testi_id = suoritus.testi_id ORDER BY pelaaja_id";
		$kysely4a="SELECT pelaaja_id, CONCAT(etunimi, ' ', sukunimi) AS pelaaja FROM pelaaja ORDER BY pelaaja_id";	
	}

	$tulos4 = mysql_query($kysely4);
	$rivi4 = mysql_fetch_array($tulos4);
	$tulos4a = mysql_query($kysely4a);	

	while($rivi4a = mysql_fetch_array($tulos4a)){


		if ($rivi4['pelaaja_id'] == $rivi4a['pelaaja_id']) {
			echo '<div class="pelaaja">
				<p style="display:inline">'. $rivi4a['pelaaja'] .'</p><input id="'. $rivi4a['pelaaja_id'] .'" onclick="nayta_suoritukset(event)" type="button" value="+">
				<div class="pelaaja_suoritukset" id="suoritukset_'. $rivi4a['pelaaja_id'] .'">';
		}
		else{
			echo '<div class="pelaaja">
				<p style="display:inline">'. $rivi4a['pelaaja'] .'</p><input id="'. $rivi4a['pelaaja_id'] .'" onclick="nayta_suoritukset(event)" type="button" value="+">
				<div class="pelaaja_suoritukset" id="suoritukset_'. $rivi4a['pelaaja_id'] .'">';
		}	

		while ($rivi4['pelaaja_id'] == $rivi4a['pelaaja_id']) {
			list($vv, $kk, $pp) = explode('-', $rivi4['pvm']);
			$suorituspvm = $pp . '.' . $kk . '.' . $vv;
		
			echo '	<p style="color:rgb(231, 138, 69); display:inline; padding-right:5%">'. $rivi4['nimi'] .'</p>
					<p style="display:inline;padding-right:1%">'. $rivi4['tulos'] .'</p>
					<p style="display:inline;padding-right:5%">'. $rivi4['mittayksikko'] .'</p>
					<p style="display:inline">'. $rivi4['pvm'] .'</p>
					<span style="display:inline; font-size:10px; padding-left:5%"> patteri_id =		'. $rivi4['patteri_id'] .'</span><br>';

			$rivi4 = mysql_fetch_array($tulos4);
		}

		echo '
				</div>
				</div>';	
	}
}

if (!empty($_POST['pelaajan_tiedot_muokkaa'])){
	header('Location: tietojenmuokkaus.php?pelaaja_id=' . $_GET['pelaaja_id']);
}
?>

