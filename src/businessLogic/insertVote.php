<?php
session_start();
require("./databaseLogin.php");

$term = mysql_real_escape_string($_POST['term']);
if($term != "shortTerm" and $term != "longTerm"){
	echo "Unknown term";
	return;
}

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "voter"){
	
	$vote = mysql_real_escape_string($_POST['vote']);
	$comment = mysql_real_escape_string($_POST['comment']);
	$query = "INSERT INTO `Votes`
			  (`Voter`, `Game ID`, `Player`, `Comment`,`Term`)
			  VALUES
			  ('".$_SESSION['username']."',
			   (SELECT `Game ID` FROM `Game Voters`
			   	WHERE `Voter ID`='".$_SESSION['username']."'),
			   '$vote','$comment','$term')";
	mysql_query($query,$connection);
	Header("Location: ../vote.php");
}
?>