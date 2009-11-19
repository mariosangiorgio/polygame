<?php
session_start();
require("./databaseLogin.php");

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	//Getting users
	$query = "SELECT `Player ID`
			  FROM	 `Game Players`
			  WHERE  `Game ID` =
			  			(SELECT `Game ID`
				         FROM `Game`
				         WHERE `Organizer ID` ='".$_SESSION['username']."')
				         and
			  		 `Player ID` NOT IN
			  		 	(SELECT `Player`
			  		 	 FROM `Groups`
			  		 	 WHERE `GameID` = `Game ID`)";

	$data	 = mysql_query($query,$connection);
	$index = 0;
	while($player = mysql_fetch_array($data)){
			$assignment["ONE".$player['Player ID']] =
					$_POST["ONE".$player['Player ID']];
			$assignment["TWO".$player['Player ID']] =
					$_POST["TWO".$player['Player ID']];
			$players[$index] = $player['Player ID'];
			$index = $index + 1;

	}

	//Inserting data
	$index = $index - 1;
	while($index >= 0){
		if($assignment["ONE".$players[$index]] !='0' &&
		   $assignment["TWO".$players[$index]] !='0'){
		$query = "INSERT INTO `Groups`
				  	(`Player`,
				  	 `GroupFirstPhase`,
				  	 `GroupSecondPhase`,
				  	 `GameID`)
				  VALUES
				    ('".$players[$index]."',
				     '".$assignment["ONE".$players[$index]]."',
 				     '".$assignment["TWO".$players[$index]]."',
				      (SELECT `Game ID`
				   	   FROM   `Game`
				   	   WHERE  `Organizer ID` = '".$_SESSION['username']."'
				   	   )
				   	 );";
		mysql_query($query,$connection);
		}
		$index = $index - 1;
	}
	header("Location: ../organize.php");
}
?>