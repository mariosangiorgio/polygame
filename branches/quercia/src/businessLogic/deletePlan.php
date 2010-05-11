<?php
session_start();
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "player"){
	require("./databaseLogin.php");
	//TODO: Check that it is the time for the submission!
	$query = "DELETE
			  FROM `Plans`
			  WHERE `Player ID` = '".$_SESSION['username']."'";
	$data  = mysql_query($query,$connection);
	Header("Location: ../createPlan.php");
}
?>