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
$email = clean($_POST['email']);
$salasana = clean($_POST['salasana']);

//Input Validations
if($email == '') {
	$errmsg_arr[] = 'Sähköposti puuttuu';
	$errflag = true;
}
if($salasana == '') {
	$errmsg_arr[] = 'Salasana puuttuu';
	$errflag = true;
}

//If there are input validations, redirect back to the login form
if($errflag) {
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	session_write_close();
	header("location: login-failed.php");
	exit();
}

//Create query
$qry="SELECT * FROM Kayttaja WHERE email='$email' AND salasana='".md5($_POST['salasana'])."'";
$result=mysql_query($qry);

//Check whether the query was successful or not
if($result) {
	if(mysql_num_rows($result) == 1) {
		//Login Successful
		session_regenerate_id();
		$member = mysql_fetch_assoc($result);
		$_SESSION['SESS_MEMBER_ID'] = $member['kayttaja_id'];
		$_SESSION['SESS_FIRST_NAME'] = $member['etunimi'];
		$_SESSION['SESS_LAST_NAME'] = $member['sukunimi'];
		$_SESSION['SESS_ADMIN'] = $member['admin'];
		session_write_close();
		header("location: login-success.php");
		exit();
	}else {
		//Login failed
		header("location: login-failed.php");
		exit();
	}
}else {
	die("Query failed");
}
?>