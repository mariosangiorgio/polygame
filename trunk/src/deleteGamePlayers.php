<?php
session_start();
header("Location: showGamePlayers.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./database/databaseLogin.php");

	foreach($_POST['selectedUsers'] as $value)  {
		//print $value;
		$query = "DELETE FROM `Game Players` WHERE `Player ID` = '$value';" ;
		//print $query;
		mysql_query($query,$connection);		
	} 
	
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>