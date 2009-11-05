<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./databaseLogin.php");
	
	//Getting users
//	$query		= "SELECT `Player ID`
//				   FROM	  `Game Players`
//				   WHERE  `Game ID` =
//				   			(SELECT `Game ID`
//				   			 FROM   `Game`
//				   			 WHERE	`Organizer ID`
//				   			 			= '".$_SESSION['username']."')";
//	$data	 = mysql_query($query,$connection);
//	$index = 0;
//	
//	// check to see if all users are present
//	while($player = mysql_fetch_array($data)){
//		if($_POST[$player['Player ID']]){
//			$assignment[$player['Player ID']] =
//					$_POST[$player['Player ID']];
//			$players[$index] = $player['Player ID'];
//			$index = $index + 1;
//		}
//		else{
//			print "ERROR, a user type is missing";
//			return;
//		}
//	}
	
	
	foreach($_POST['selectedUsers'] as $value)  {
		$query		= "INSERT INTO `Game Players` (`Game ID`,`Player ID`, `Associated Phases`)
				   VALUES (
				   ( SELECT `Game ID` FROM `Game`
					WHERE `Organizer ID` = '".$_SESSION['username']."' )
				   , '".mysql_real_escape_string($value)."', ";
		
		if($_POST["_____type".$value]=="0")
		{
			$query = $query."'allPhases'";
		}
		else if($_POST["_____type".$value]=="1")
		{
			$query = $query."'phaseOne'";
		}
		else if($_POST["_____type".$value]=="2")
		{
			$query = $query."'phaseTwo'";
		}
		else
		{
			//print("Error in user type");
		}
		
		$query = $query.");";
		//print($query);
		$data		= mysql_query($query,$connection);
	} 
	
		header("Location: ../chooseGamePlayers.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>