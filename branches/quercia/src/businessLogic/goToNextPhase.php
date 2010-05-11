<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer" and
	( $_SESSION['gamePhase'] >= 2  and $_SESSION['gamePhase'] <= 6 ) and
	$_SESSION['gamePhase'] != 5 )
{
	require("./databaseLogin.php");
	
	// Finds out if game is finished (phase = 7)
	$query 	=
		"SELECT *
		 FROM  `Game`
		 WHERE `Organizer ID` = '" .
		 	    $_SESSION['username'] . "'";
	$data	= mysql_query($query,$connection);
	$game	= mysql_fetch_array($data);
	
	if($game != 0) {
		$now	= time();
		$gameIsStarted		= $game['Started'];
		$phaseTwoIsStarted	= $game['Started Phase 2'];
		$startingTime		= strtotime($game['Starting time']);
		$startingTimePhase2	= strtotime($game['Starting time Phase 2']);
		$starting2			= $startingTimePhase2; //for compatibility
		$starting1b			= $startingTime +
							 $game['Length 1a'];
		$starting1c			= $startingTime +
							 $game['Length 1a'] +
							 $game['Length 1b'];
		$endingPhase1		= $startingTime +
							 $game['Length 1a'] +
							 $game['Length 1b'] +
							 $game['Length 1c'];
		$endingTime		   	= $starting2 +
							 $game['Length 2'];
	
	
		if( $_SESSION['gamePhase'] == 2 )
		{
			$deltaTime = $starting1b - $now;
			$phase = 'Length 1a';
		}
		else if( $_SESSION['gamePhase'] == 3 )
		{
			$deltaTime = $starting1c - $now;
			$phase = 'Length 1b';		
		}
		else if( $_SESSION['gamePhase'] == 4 )
		{
			$deltaTime = $endingPhase1 - $now;
			$phase = 'Length 1c';
		}
		else if( $_SESSION['gamePhase'] == 6 )
		{
			$deltaTime = $endingTime - $now;
			$phase = 'Length 2';		
		}
		
		//$deltaTime = $deltaTime / 60;
		
		//Query
		$query		= 	"UPDATE `Game`
						SET `".$phase."` = `".$phase."` - ".$deltaTime."
						WHERE `Organizer ID` = '".$_SESSION['username']."'";
		$data		= 	mysql_query($query, $connection);
		
		//print $query;
			
	}	
	
	//Redirect to the main page
	header("Location: ../organize.php");
	
}

else{
	print "To perform this operation you must be logged in as an organizer and be in an active game!";
}

?>