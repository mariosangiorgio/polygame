<?php
session_start();
require("./databaseLogin.php");

//Sanitizing inputs
$username	= mysql_real_escape_string($_POST['username']);
$password	= mysql_real_escape_string($_POST['password']);

$query		= "SELECT `username`,`role`,`password` FROM `Users` WHERE `username`='$username'";

$data		= mysql_query($query,$connection);
$row		= mysql_fetch_array($data);

if(sha1("polygame".$password) == $row['password']){
	$_SESSION['loggedIn']	= "yes";
	$_SESSION['username']	= $username;
	$_SESSION['role']		= $row['role'];
	
	header("Location: ../index.php");
	}
else{
	print "Login error. Please, double check your username and password.";
}

?>
