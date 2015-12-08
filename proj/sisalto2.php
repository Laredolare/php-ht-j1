<?php
if(!empty($_GET['TT_patteri_id'])){
	PPT();
} else {
echo '
<div id="pelaajan_tiedot-testit">
		<div id="pelaajan_tiedot">
			<h4></h4>
			<p style="padding:0;margin:0% 0% 0% 1%">Patteria ei ole valittu. Lisää uusi testipatteri painamalla <a href="uusipatteri.php">tästä</a>.</p>
		</div>

	';
}

function PPT(){
	$patterin_tiedot_testit_kysely=
	"SELECT NIMI
	FROM testi
	WHERE testi.testi_id in
	      (SELECT testi_id
	       FROM suoritus join
	            testipatteri
	            on testipatteri.patteri_id = suoritus.patteri_id
	       WHERE testipatteri.patteri_id = ". $_GET['TT_patteri_id'] ."
	      )
	";
	$patterin_tiedot_testit_tulos = mysql_query($patterin_tiedot_testit_kysely);

	$patterin_tiedot_pelaajat_kysely=
	"SELECT CONCAT(ETUNIMI, ' ', SUKUNIMI),
	FROM pelaaja
	WHERE pelaaja.pelaaja_id in
	      (SELECT pelaaja_id
	       FROM suoritus join
	            testipatteri
	            on testipatteri.patteri_id = suoritus.patteri_id
	       WHERE testipatteri.patteri_id = ". $_GET['TT_patteri_id'] ."
	      )
	";

	echo '
		<div class="testipatteri_koko">
		<div class="testipatterin_tiedot">
			<h4>TESTIT</h4>
		';	
			$hakulause = "SELECT s.patteri_id, s.pelaaja_id, s.testi_id, p.pelaaja_id, p.etunimi, p.sukunimi, t.testi_id, t.nimi, t.mittayksikko 
			FROM pelaaja as p 
			INNER JOIN suoritus as s ON s.pelaaja_id = p.pelaaja_id 
			JOIN testi AS t ON s.testi_id = t.testi_id 
			WHERE s.patteri_id = ". $_GET['TT_patteri_id'] ."
			ORDER BY t.nimi ASC";
            
			$tulos = mysql_query($hakulause);
			
			if (mysql_num_rows($tulos) > 0)
			{
				echo '<form method="post" action="">';
				if($tulos !== FALSE)
				{
					echo '<table>';
					while($rivi = mysql_fetch_array($tulos))
					{
					echo '<tr>';
					echo '<td>' . $rivi['etunimi'] . ' ' . $rivi['sukunimi'] . '</td>';
					echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
					echo '<td>'. $rivi['nimi'] . '</td>';
					echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
					echo '<td><input type="text" name="tulos" value=""></td>';
					echo '<td>&nbsp;&nbsp;</td>';
					echo '<td>'. $rivi['mittayksikko'] . '</td>';
					echo '</tr>';
					}
					echo '</table>';
				}
				else
				{
					echo "ei toimi testihaku";
					die(mysql_error());
				}
				echo '<input class="tallennaTulokset" type="submit" name="testipatteri_tallenna" value="" />';
				echo '</form>';
			}
			else
			{
				echo '<p>Testipatteriin ei ole valittu yhtään testiä</p>';
			}
		
		echo '
		</div>
		</div>
	';
}
?>