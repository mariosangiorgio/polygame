<?php

session_start();

require("./databaseLogin.php");

$query 	= 
	"INSERT INTO `polygame_polygame`.`Posters` (
	 `Player`, `Game ID`, `Wedge ID`, `Pros`,
	 `Cons`, `Notes`)
	 VALUES ( '".$_SESSION['username']."',
	 		  (SELECT `Game ID`
	 		   FROM `Game Players`
	 		   WHERE `Player ID` =
	 		   '".$_SESSION['username']."'),
	 		  '".$_SESSION['wedgeID']."',
	 		  '".mysql_real_escape_string($_POST['Pros'])."',
	 		  '".mysql_real_escape_string($_POST['Cons'])."',
	 		  '".mysql_real_escape_string($_POST['Notes'])."');";
$data	= mysql_query($query,$connection);
$_SESSION['posterSubmitted'] = true;

//Redirect to the main page
header("Location: ../showWedgeInformation.php");
?>