<?php

session_start();

require("./databaseLogin.php");

$query 	= 
	"UPDATE `Posters`
	 SET
	 	`Pros`	= '".$_POST['Pros']."',
	 	`Cons`	= '".$_POST['Cons']."', 
	 	`Notes`	= '".$_POST['Notes']."'
	 WHERE `Player`='".$_SESSION['username']."' and 
	 	   `Game ID`='".$_SESSION['gameID']."' and 
	 	   `Wedge ID`='".$_SESSION['wedgeID']."';";

$data	= mysql_query($query,$connection);
$_SESSION['posterSubmitted'] = true;

//Redirect to the main page
header("Location: ../showWedgeInformation.php");
?>