<?php
session_start();
require("./databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "voter"){
	
	$vote = mysql_real_escape_string($_POST['vote']);
	$comment = mysql_real_escape_string($_POST['comment']);
	$query = "INSERT INTO `Votes`
			  (`Voter`, `Game ID`, `Player`, `Comment`)
			  VALUES
			  ('".$_SESSION['username']."',
			   (SELECT `Game ID` FROM `Game Voters`
			   	WHERE `Voter ID`='".$_SESSION['username']."'),
			   '".$vote."','".$comment."')";
	mysql_query($query,$connection);
	print "Thank you";
}
?>