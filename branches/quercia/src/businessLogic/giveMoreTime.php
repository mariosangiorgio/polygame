<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer" and
	$_SESSION['gamePhase'] > 1 and 
	$_SESSION['gamePhase'] < 7 )
{
	require("./databaseLogin.php");
	
	//Sanitizing inputs
	$minutes	= mysql_real_escape_string($_POST['minutes']);
	//print $minutes." ";
	
	if($minutes < 0 or $minutes > 30) $minutes = 2;
	
	//Finds out current phase
	if ($_SESSION['gamePhase'] == 2)
	{
		$row = "Length 1a";
	} 
	else if ($_SESSION['gamePhase'] == 3)
	{
		$row = "Length 1b";		
	}
	else if ($_SESSION['gamePhase'] == 4)
	{
		$row = "Length 1c";		
	}
	else if ($_SESSION['gamePhase'] == 6)
	{
		$row = "Length 2";		
	}
	
	
	//Query
	$query		= 	"UPDATE `Game`
					SET `".$row."` = `".$row."` + 60*".$minutes."
					WHERE `Organizer ID` = '".$_SESSION['username']."'";
	$data		= 	mysql_query($query,$connection);
	//print $query;
	
	//Redirect to the main page
	header("Location: ../organize.php");
	
}

else{
	print "To perform this operation you must be logged in as an organizer and be in an active game!";
}

?>