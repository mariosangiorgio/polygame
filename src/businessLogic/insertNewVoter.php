<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");
	
	//Sanitizing inputs
	$username	= mysql_real_escape_string($_POST['username']);
	$password	= mysql_real_escape_string($_POST['password']);
	//Query
	if($password == ""){
		//Hashing and salting the password
		$password	= sha1("polygame".$password);
		$query = "INSERT INTO `Users`
				  (`username`,`role`,`password`,`PasswordValid`)
				  VALUES ('$username', 'voter', '$password',1);";
	}
	else{
		$query = "INSERT INTO `Users`
				  (`username`,`role`,`PasswordValid`)
				  VALUES ('$username', 'voter's,0);";
	}
	$data		= mysql_query($query,$connection);
	
	//Redirect to the main page
	header("Location: ../newVoter.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>