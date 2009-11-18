<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./businessLogic/databaseLogin.php");
	
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
	$data = mysql_query($query,$connection);
	print "Players:";
	print "<TABLE>";
	while( $row = mysql_fetch_array($data) ){
		print "<TR><TD>".$row['Player ID']."</TD></TR>";
	}
	print "</TABLE>";
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>