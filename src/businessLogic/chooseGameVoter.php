<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");
	header("Location: ../chooseGameVoters.php");
	
	foreach($_POST['selectedUsers'] as $value)  {
		$query		= "INSERT INTO `Game Voters` (`Game ID`,`Voter ID`)
				   VALUES (
				   ( SELECT `Game ID` FROM `Game`
					WHERE `Organizer ID` = '".$_SESSION['username']."' )
				   , '$value');";
		$data		= mysql_query($query,$connection);
	} 

}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>