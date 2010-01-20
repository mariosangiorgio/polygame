<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");
	
	$user		= $_POST['mydropdown'];
	$password	= mysql_real_escape_string($_POST['password']);
	//Hashing and salting the password
	$password	= sha1("polygame".$password);
	
	$query		= 	"UPDATE `Users`
					 SET `password` = '".$password."' 
					 WHERE `username` = '".$user."'";
	//print $user."!!";
	//print $query;
	$data		= 	mysql_query($query, $connection);
	
	header("Location: ../organize.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>