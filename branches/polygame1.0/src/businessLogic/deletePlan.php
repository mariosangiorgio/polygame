<?php

$term = mysql_real_escape_string($_GET['term']);
if($term != "shortTerm" and $term != "longTerm"){
	echo "Unknown term";
	return;
}

session_start();
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "player"){
	require("./databaseLogin.php");
	//TODO: Check that it is the time for the submission!
	$query = "DELETE
			  FROM `Plans`
			  WHERE
			  	`Term` = '$term'
			  		AND
			  	`Player ID` = '".$_SESSION['usernamePhaseTwo']."'";
	$data  = mysql_query($query,$connection);
	Header("Location: ../createPlan.php");
}
?>