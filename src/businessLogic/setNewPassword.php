<?php
session_start();
require("./businessLogicFunctions.php");
$connection = databaseLogin();

if($_SESSION['loggedIn'] == "PasswordReset"){
	//Sanitizing inputs
	$username	= $_SESSION['username'];
	$password	= mysql_real_escape_string($_POST['password']);
	$password	= sha1("polygame".$password);
	
	$query		= "UPDATE `Users`
				   SET	  `password` =  '".$password."',
				   		  `PasswordValid` =  '1'
				   WHERE  `username` =  '".$username."'";
				   
	$data		= mysql_query($query,$connection);
	
	$_SESSION['loggedIn']	= "yes";
	header("Location: ../index.php");
}
else{
	print "To access this page ask the administrator to reset your password.";
}

?>
