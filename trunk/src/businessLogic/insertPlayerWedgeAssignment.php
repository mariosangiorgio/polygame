<?php
session_start();
require("./businessLogicFunctions.php");
require("./databaseLogin.php");

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	//Cleaning up old data!
	$query = "DELETE
			  FROM `Wedge Players`
			  WHERE `Game ID` =  ( SELECT `Game ID`
			  					  FROM   `Game`
								  WHERE  `Organizer ID` =
								  		'".$_SESSION['username']."') ";
	mysql_query($query,$connection);
	
	//Getting users
	$query		= "SELECT `GroupFirstPhase` as `Player`
					FROM `Groups`
					WHERE `GameID` =  ( SELECT `Game ID`
						   FROM   `Game`
						   WHERE	`Organizer ID` =
						   '".$_SESSION['username']."'
						 )
					AND `GroupFirstPhase`<>''
					UNION
					SELECT `Player ID`
					FROM `Game Players`
					WHERE `Game ID` =  ( SELECT `Game ID`
						   FROM   `Game`
						   WHERE	`Organizer ID` =
						   '".$_SESSION['username']."' )
					AND `Player ID` NOT IN
					(SELECT `Player`
					 FROM `Groups`
					 WHERE `GameID` =  ( SELECT `Game ID`
						   FROM   `Game`
						   WHERE  `Organizer ID` =
						   '".$_SESSION['username']."'
						 )
					 AND `GroupFirstPhase`<>'')";
					 
	$data	 = mysql_query($query,$connection);
	$index = 0;
	while($player = mysql_fetch_array($data)){
		/*
		$underMnk = str_replace(' ', '_', $player['Player']);
		if($_POST[$underMnk]){
			$assignment[$underMnk] =
					$_POST[$underMnk];
			$players[$index] = $underMnk;
			$index = $index + 1;
		}
		*/
		
		$REAL_POST = getRealPOST();
		
		$underMnk = $player['Player'];
		if($REAL_POST[$underMnk]){
			$assignment[$underMnk] =
					$REAL_POST[$underMnk];
			$players[$index] = $underMnk;
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
else{
	echo "ERROR: To access this page you must be an organizer";
}
?>