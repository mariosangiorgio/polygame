<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");

	foreach($_POST['selectedUsers'] as $value)  {
		$query = "DELETE FROM `Users` WHERE `role` = 'voter' and `username` = '".$value."';" ;
		mysql_query($query,$connection);		
	} 
	
	header("Location: ../deleteVoters.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>