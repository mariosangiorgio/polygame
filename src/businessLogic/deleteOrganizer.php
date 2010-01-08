<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
	require("./databaseLogin.php");

	foreach($_POST['selectedUsers'] as $value)  {
		$query = "DELETE FROM `Users` WHERE `role` = 'organizer' and `username` = '".$value."';" ;
		mysql_query($query,$connection);		
	} 
	
	header("Location: ../deleteOrganizers.php");
}
else{
	print "To perform this operation you must be logged in as an administrator!";
}
?>