<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer" and
	$_SESSION['gamePhase'] >= 3  and $_SESSION['gamePhase'] <= 7  )
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
	
	
		if( $_SESSION['gamePhase'] == 3 ) //phase 1b
		{
			$deltaTime = $now - $starting1b;
			$phase = 'Length 1a';		
		}
		else if( $_SESSION['gamePhase'] == 4 ) //phase 1c
		{
			$deltaTime = $now - $starting1c;
			$phase = 'Length 1b';
		}
		else if( $_SESSION['gamePhase'] == 5 ) //break
		{
			$deltaTime = $now - $endingPhase1;
			$phase = 'Length 1c';		
		}
		else if( $_SESSION['gamePhase'] == 6 ) //end
		{
			//TODO
			//$deltaTime = $now - $endingTime;
			//$phase = 'Length 2';		
			//Redirect to the main page
			header("Location: ../organize.php");
		}
		else if( $_SESSION['gamePhase'] == 7 ) //end
		{
			$deltaTime = $now - $endingTime;
			$phase = 'Length 2';		
		}
				
		//Query
		$query		= 	"UPDATE `Game`
						SET `".$phase."` = `".$phase."` + ".$deltaTime." + 2*60
						WHERE `Organizer ID` = '".$_SESSION['username']."'";
		$data		= 	mysql_query($query, $connection);
		
		//print $query;
			
	}	
	
	//Redirect to the main page
	header("Location: ../organize.php");
	
}
else if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer" and
	$_SESSION['gamePhase'] == 2  )

{
	require("./databaseLogin.php");
	$_SESSION['gamePhase'] = 1;
	
	$query		= "UPDATE `Game`
					SET `Starting time` = '2035-12-12 11:11:11', `Started` = 0
					WHERE `Organizer ID` = '".$_SESSION['username']."';";
	$data		= mysql_query($query,$connection);
	//print $query;
	sleep(1);
	header("Location: ../organize.php");
}
else{
	print "To perform this operation you must be logged in as an organizer and be in an active game!";
}

?>