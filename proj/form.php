<?php 
echo '
<div id="index">
	<div class="hakupalkki">
		<form id="loginForm" name="loginForm" method="post" action="login-exec.php">
			<div class="hakupalkki_h2">
				<h2>Kirjautuminen</h2>
			</div>
			<img class="nuoli" alt="nuoli1" src="Palat/nuoli1.jpg">
			<div class="hakupalkki_table">	
				<table>
					<tr>
						<td>Käyttäjätunnus</td>
						<td>Salasana</td>
					</tr>
					<tr>
						<td><input name="email" type="text" class="textfield" id="email" /></td>
						<td><input name="salasana" type="password" class="textfield" id="salasana" />
					</tr>
				</table>
			</div>
			<img class="nuoli" alt="nuoli2" src="Palat/nuoli2.jpg">
			<div class="hakupainike_index">
				<input type="submit" name="Submit" value="Kirjaudu" />
			</div>
		</form>
		<p id="versionumero">Versio 0.77</p>
	</div>
</div>';
?>