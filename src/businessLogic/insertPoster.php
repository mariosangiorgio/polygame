<?php

session_start();

require("./databaseLogin.php");

$query 	= 
	"INSERT INTO `polygame_polygame`.`Posters` (
	 `Player`, `Game ID`, `Wedge ID`, `Pros`,
	 `Cons`, `Notes`)
	 VALUES ( '".$_SESSION['username']."',
	 		  '".$_SESSION['gameID']."',
	 		  '".$_SESSION['wedgeID']."',
	 		  '".$_POST['Pros']."',
	 		  '".$_POST['Cons']."',
	 		  '".$_POST['Notes']."');";
$data	= mysql_query($query,$connection);
$_SESSION['posterSubmitted'] = true;

//Redirect to the main page
header("Location: showWedgeInformation.php");
?>