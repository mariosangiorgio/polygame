<?php

session_start();

require("./databaseLogin.php");

$query 	= 
	"UPDATE `Posters`
	 SET
	 	`Pros`	= '".mysql_real_escape_string($_POST['Pros'])."',
	 	`Cons`	= '".mysql_real_escape_string($_POST['Cons'])."', 
	 	`Notes`	= '".mysql_real_escape_string($_POST['Notes'])."'
	 WHERE `Player`='".$_SESSION['username']."' and 
	 	   `Game ID`= (SELECT `Game ID`
	 	   			   FROM `Game Players`
	 		   		   WHERE `Player ID` = '".$_SESSION['username']."')
	 		   		   and 
	 	   `Wedge ID`='".$_SESSION['wedgeID']."';";

$data	= mysql_query($query,$connection);
$_SESSION['posterSubmitted'] = true;

//Redirect to the main page
header("Location: ../showWedgeInformation.php");
?>