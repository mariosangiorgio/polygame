<?php
session_start();
require("./databaseLogin.php");


if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$query = "SELECT `Started`
			   FROM   `Game`
			   WHERE	`Organizer ID` =
			   '".$_SESSION['username']."'";
	echo $query;
	
	$data	 = mysql_query($query,$connection);
	$value	 = mysql_fetch_array($data);
	
	// If already has already started return
	//print $value['Started'];
	if($value['Started'] != 0)
	{
		header("Location: ../organize.php");
		return;
	}
	
	$_SESSION['gamePhase'] = 2;
	
	$query		= "UPDATE `Game`
					SET `Starting time` = NOW(), `Started` = 1
					WHERE `Organizer ID` = '".$_SESSION['username']."';";
	$data		= mysql_query($query,$connection);
	
	sleep(1);
	header("Location: ../organize.php");
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
