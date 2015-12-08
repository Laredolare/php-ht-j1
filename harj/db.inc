<?php

	define("DB_NAME", "harjoitustyo");
	define("DB_USER", "root");
	define("DB_PASSWD", "");
	define("DB_HOST", "localhost");


	$conn = @mysql_connect(DB_HOST, DB_USER, DB_PASSWD) or die ("Tietokantapalvelimeen koneella " . DB_HOST . " ei saada yhteyttä (virhenro:" . mysql_errno() . " ja msg: " . mysql_error());



if ( !$conn )
{
	die ("Tietokantapalvelinta ei löydy");
}


	mysql_select_db(DB_NAME) or die ("Tietokantaan " . DB_NAME . " ei saada yhteyttä");
?>