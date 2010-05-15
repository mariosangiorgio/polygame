<?php
session_start();
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "player"){
	require("./databaseLogin.php");
	
	$term = mysql_real_escape_string($_POST['term']);
	if($term != "shortTerm" and $term != "longTerm"){
		echo "Unknown term";
		return;
	}
	
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
					INTO `Plans`
						 (`Game ID`,`Player ID`,`Wedge ID`,`Wedge Count`,`Term`)
					VALUES
						 (".$gameID.",
						   '".$_SESSION['usernamePhaseTwo']."',$wedge,
						   ".$wedgesSelected[$wedge].",'$term')";
			$total = $total + $count;
			$data	= mysql_query($query,$connection);
	}
	
	//Storing the poster for the Plan
	$overview = mysql_real_escape_string($_POST['Overview']);
	$reasons  = mysql_real_escape_string($_POST['Reasons']); 
	$query =
		"INSERT
			INTO `Plan Posters`
				 (`Game ID`, `Player`, `Overview`,`Reasons`,`Term`)
			VALUES
				 ($gameID, '".$_SESSION['usernamePhaseTwo']."', '$overview', '$reasons', '$term')";
	$total = $total + $count;
	$data	= mysql_query($query,$connection);
	
	Header("Location: ../createPlan.php");
}
else{
	print "To perform this operation you must be logged in as a player!";
}
?>