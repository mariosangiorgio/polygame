<?php
session_start();
require("./businessLogicFunctions.php");
$connection = databaseLogin();

//Sanitizing inputs
$username	= mysql_real_escape_string($_POST['username']);
$password	= mysql_real_escape_string($_POST['password']);

$query		= "SELECT `username`,`role`,`password`,`PasswordValid` FROM `Users` WHERE `username`='$username'";

$data		= mysql_query($query,$connection);
$row		= mysql_fetch_array($data);

if($row['PasswordValid']==0){
	$_SESSION['loggedIn']	= "PasswordReset";
	$_SESSION['username']	= $username;
	$_SESSION['role']		= $row['role'];
	header("Location: ../setPassword.php");
	return;
}

if(sha1("polygame".$password) == $row['password']){
	$_SESSION['loggedIn']	= "yes";
	$_SESSION['username']	= $username;
	$_SESSION['role']		= $row['role'];
	
	header("Location: ../index.php");
	return;
	}
else{
	print "Login error. Please, double check your username and password.";
}

?>
