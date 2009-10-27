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
	
	$i = 0;
	while($wedge = mysql_fetch_array($data)){
		print "Wedge:";
		print $wedge['Wedge ID'];
		print " ".intval($_POST['wedge'.$wedge['Wedge ID']])."<BR>";	
	}
	
}
else{
	print "To perform this operation you must be logged in as a player!";
}
?>