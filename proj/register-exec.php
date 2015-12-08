<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('db.inc');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$etunimi = clean($_POST['etunimi']);
	$sukunimi = clean($_POST['sukunimi']);
	$email = clean($_POST['email']);
	$puhnro = clean($_POST['puhnro']);
	$salasana = clean($_POST['salasana']);
	$csalasana = clean($_POST['csalasana']);
	
	//Input Validations
	if($etunimi == '') {
		$errmsg_arr[] = 'Etunimi puuttuu';
		$errflag = true;
	}
	if($sukunimi == '') {
		$errmsg_arr[] = 'Sukunimi puuttuu';
		$errflag = true;
	}
	if($email == '') {
		$errmsg_arr[] = 'Sähköposti puuttuu';
		$errflag = true;
	}
	if($puhnro == '') {
		$errmsg_arr[] = 'Puhelinnro puuttuu';
		$errflag = true;
	}
	if($salasana == '') {
		$errmsg_arr[] = 'Salasana puuttuu';
		$errflag = true;
	}
	if($csalasana == '') {
		$errmsg_arr[] = 'Salasanan vahvistus puuttuu';
		$errflag = true;
	}
	if( strcmp($salasana, $csalasana) != 0 ) {
		$errmsg_arr[] = 'Salasanat eivät täsmää';
		$errflag = true;
	}
	
	//Check for duplicate login ID
	if($email != '') {
		$qry = "SELECT * FROM kayttaja WHERE email='$email'";
		$result = mysql_query($qry);
		if($result) {
			if(mysql_num_rows($result) > 0) {
				$errmsg_arr[] = 'Sähköposti on jo käytössä';
				$errflag = true;
			}
			@mysql_free_result($result);
		}
		else {
			die("Query failed");
		}
	}
	
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: register-failed.php");
		exit();
	}

	//Create INSERT query
	$qry = "INSERT INTO Kayttaja(etunimi, sukunimi, email, puhnro, salasana) VALUES('$etunimi','$sukunimi','$email','$puhnro','".md5($_POST['salasana'])."')";
	$result = @mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		header("location: register-success.php");
		exit();
	}else {
		die("Query failed");
	}
?>