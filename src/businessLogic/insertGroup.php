<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");
	
	//Sanitizing inputs
	$name	= mysql_real_escape_string($_POST['name']);
	$phase	= mysql_real_escape_string($_POST['phase']);

	$query		= "INSERT INTO `Game Groups`
					(`GameID`,
					 `GroupName`,
					 `Phase`)
				   VALUES (
				           (SELECT `Game ID`
				            FROM `Game`
				            WHERE `Organizer ID` ='".$_SESSION['username']."'),
				   		   '".$name."',
				   		   '".$phase."');";
	$data		= mysql_query($query,$connection);
	
	//Redirect to the main page
	header("Location: ../viewGroups.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>