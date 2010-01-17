<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	require("./businessLogicFunctions.php");
	insertNewPlayer($_POST['username'], $_POST['password']);
	
	//Redirect to the main page
	header("Location: ../newPlayer.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>