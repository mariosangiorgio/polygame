<?php
session_start();
require("./database/databaseLogin.php");

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./database/databaseLogin.php");

	foreach($_POST['selectedUsers'] as $value)  {
		$query = "DELETE FROM `Users` WHERE `username` = '$value';" ;
		mysql_query($query,$connection);		
	} 
	
	header("Location: deletePlayers.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>