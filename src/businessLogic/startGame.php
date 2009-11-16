<?php
session_start();
require("./databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$_SESSION['gamePhase'] = 2;
	
	$query		= "UPDATE `Game`
					SET `Starting time` = NOW(), `Started` = 1
					WHERE `Organizer ID` = '".$_SESSION['username']."';";
	$data		= mysql_query($query,$connection);
	
	sleep(1);
	header("Location: ../organizer.php");
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
