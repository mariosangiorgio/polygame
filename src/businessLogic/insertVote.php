<?php
session_start();
require("./databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "voter"){
	
	$vote = mysql_real_escape_string($_POST['vote']);
	$query = "INSERT INTO `Votes`
			  (`Voter`, `Game ID`, `Player`)
			  VALUES
			  ('".$_SESSION['username']."',
			   (SELECT `Game ID` FROM `Game Voters`
			   	WHERE `Voter ID`='".$_SESSION['username']."'),
			   '".$vote."')";
	mysql_query($query,$connection);
}
?>