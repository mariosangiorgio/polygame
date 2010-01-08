<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
	require("./databaseLogin.php");
	
	$wedgeID = mysql_real_escape_string($_GET['wedgeID']);
	
	$query = "DELETE FROM `Wedges` WHERE `Wedge ID` = ".$wedgeID;
	mysql_query($query,$connection);
	
	header("Location: ../admin.php");
}
else{
	print "To perform this operation you must be logged in as an administrator!";
}
?>