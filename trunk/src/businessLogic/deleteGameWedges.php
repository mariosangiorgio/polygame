<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");

	foreach($_POST['selectedUsers'] as $value)  {
		//print $value;
		$query = "DELETE FROM `Game Wedges` WHERE `Wedge ID` = '$value';" ;
		//print $query;
		mysql_query($query,$connection);			
	} 
	
	header("Location: ../showGameWedges.php");
	
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>