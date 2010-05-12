<?php
session_start();
require("./databaseLogin.php");

//Getting the parameters
$user = mysql_real_escape_string($_GET['user']);

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator" or
	$_SESSION['role'] == "organizer"){
	
	// Checking that the user has the right to reset the password
	$query = "SELECT *
			  FROM   `Users`
			  WHERE	 `username` = '".$user."'";
	echo $query;
	$data	 = mysql_query($query,$connection);
	$row	 = mysql_fetch_array($data);
	
	if(
	 ($_SESSION['role'] == "administrator" and $row['role'] == "organizer") or
	 ($_SESSION['role'] == "organizer" and $row['role'] == "player") or
	 ($_SESSION['role'] == "organizer" and $row['role'] == "voter")
	  ){
	  $query = "UPDATE `Users`
	  			SET `PasswordValid` = 0
	  			WHERE `Username` = '".$user."'";
	  echo $query;
	  mysql_query($query,$connection);
	  header("Location: ../index.php");
	}
	else{
		echo "You don't have the right to reset the password for ".$user;
	}
	return;
}
else{
	echo "To access this page you should be logged in as an administrator or as an organizer";
	return;
}
?>