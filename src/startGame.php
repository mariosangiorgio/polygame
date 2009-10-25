<?php
session_start();
require("./businessLogic/databaseLogin.php");
header("Location: organizer.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$_SESSION['gamePhase'] = 2;
	
	$query		= "UPDATE `Game`
					SET `Starting time` = NOW()
					WHERE `Organizer ID` = '".$_SESSION['username']."';";
	$data		= mysql_query($query,$connection);
	
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
