<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");
	
	//Sanitizing inputs
	$username	= mysql_real_escape_string($_POST['username']);
	$password	= mysql_real_escape_string($_POST['password']);
	//Hashing and salting the password
	$password	= sha1("polygame".$password);
	
	//Insert new player in USERS table
	$query		= "INSERT INTO `Users` (`username`,`role`,`password`)
				   VALUES ('$username', 'player', '$password');";
	$data		= mysql_query($query,$connection);
	
	//Redirect to the main page
	header("Location: ../newPlayer.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>