<?php
session_start();
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "player"){
	require("./databaseLogin.php");
	//TODO: Check that it is the time for the submission!
	$query 	=
		"SELECT
			   `Wedges`.`Wedge ID` as `Wedge ID`, `Title`
		 FROM
			   `Game Players`,
			   `Game Wedges`,
			   `Wedges`
		 WHERE
			   `Game Wedges`.`Wedge ID` = `Wedges`.`Wedge ID` AND
			   `Game Wedges`.`Game ID` = `Game Players`.`Game ID` AND
			   `Game Players`.`Player ID` = '".
				$_SESSION['username'] . "'";
	$data	= mysql_query($query,$connection);
	
	$total = 0;
	while($wedge = mysql_fetch_array($data)){
		$count = intval($_POST[$wedge['Wedge ID']]);
		if($count > 0){
			$wedgesSelected[$wedge['Wedge ID']] = $count;
			$total = $total + $count;
		}
	}
	if($total < 20){
		print "ERROR. You must select at least 20 wedges!";
		return;
	}
	
	//Getting game ID
	$query 	=
		"SELECT
			   `Game ID`
		 FROM
			   `Game Players`
		 WHERE
			   `Game Players`.`Player ID` = '".
				$_SESSION['username'] . "'";
	$data	= mysql_query($query,$connection);
	$result = mysql_fetch_array($data);
	$gameID = $result['Game ID'];
	
	//Storing informations in the database
	foreach(array_keys($wedgesSelected) as $wedge){
			$query =
				"INSERT
					INTO `polygame_polygame`.`Plans`
						 (`Game ID`,`Player ID`,`Wedge ID`,`Wedge Count`)
					VALUES
						 (".$gameID.",
						   '".$_SESSION['usernamePhaseTwo']."',
						   ".$wedge.",
						   ".$wedgesSelected[$wedge].")";
			$total = $total + $count;
			$data	= mysql_query($query,$connection);
	}
	Header("Location: ../createPlan.php");
}
else{
	print "To perform this operation you must be logged in as a player!";
}
?>