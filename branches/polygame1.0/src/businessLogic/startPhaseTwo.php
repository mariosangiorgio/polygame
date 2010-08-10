<?php
session_start();
require("./databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$_SESSION['gamePhase'] = 6;
	
	$query		= "UPDATE `Game`
					SET `Starting time Phase 2` = NOW(), `Started Phase 2` = 1
					WHERE `Organizer ID` = '".$_SESSION['username']."';";
	$data		= mysql_query($query,$connection);
	
	sleep(1);
	header("Location: ../organize.php");
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
