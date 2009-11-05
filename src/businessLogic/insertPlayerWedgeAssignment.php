<?php
session_start();
require("./databaseLogin.php");

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	//Getting users
	$query		= "SELECT `Player ID`
				   FROM	  `Game Players`
				   WHERE  `Game ID` =
				   			(SELECT `Game ID`
				   			 FROM   `Game`
				   			 WHERE	`Organizer ID`
				   			 			= '".$_SESSION['username']."')";
	$data	 = mysql_query($query,$connection);
	$index = 0;
	while($player = mysql_fetch_array($data)){
		if($_POST[$player['Player ID']]){
			$assignment[$player['Player ID']] =
					$_POST[$player['Player ID']];
			$players[$index] = $player['Player ID'];
			$index = $index + 1;
		}
		else{
			print "ERROR, a user wedge is missing";
			return;
		}
	}
	//Checking for duplicates
	
	//Inserting data
	$index = $index - 1;
	while($index >= 0){
		$query = "INSERT INTO `Wedge Players`
				  	(`User ID`,
				  	 `Wedge ID`,
				  	 `Game ID`)
				  VALUES
				    ('".$players[$index]."',
				     ".$assignment[$players[$index]].",
				      (SELECT `Game ID`
				   	   FROM   `Game`
				   	   WHERE  `Organizer ID` = '".$_SESSION['username']."'
				   	   )
				   	 )";
		mysql_query($query,$connection);
		$index = $index - 1;
	}
	header("Location: ../organize.php");
}
?>