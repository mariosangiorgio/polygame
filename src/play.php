<?php
	include_once("./inc/db_connect.inc");
	include_once("./inc/utils.inc");
	include_once("./inc/init.inc");
	include_once("./lang/".$gData['langFile']);
	
	checkAuthentication('player');
	
	$query = "SELECT `Wedge ID` as wedgeID, g.`Game ID` as gameID, `Plan ID` as planID, ".
			"`Phase 1` as phase1, `Phase 2` as phase2, `Length 1` as length1 ".
			"FROM `players` p, `game` g ".
			"WHERE `Player ID`='".$gData['userID']."' ".
			"AND p.`Game ID`=g.`Game ID`;";
	$result = mysql_query( $query, $connection );
	$game = mysql_fetch_array( $result );
	
	if( !$game['phase1'] )					// game hasn't yet started
		include "./inc/gameNotStarted.inc"; 
	else if( !$game['phase2'] )				// phase1 has already started
	{
		$query = "SELECT `Result` as result, `Poster submitted` as submitted ".
				"FROM `wedge groups` ".
				"WHERE `Game ID`='".$game['gameID']."' ".
				"AND `Wedge ID`='".$game['wedgeID']."';";
		$result = mysql_query( $query, $connection );
		$row = mysql_fetch_array( $result );
		
		if( !$row['result'] )
			include "./inc/playerFindSolution.inc";	// player doesn't find a solution yet
		else if( !$row['submitted'] )
			include "./inc/playerCreatePoster.inc";	// players doesn't finished to create the poster
		else
			include "./inc/phase2NotStarted.inc"; 
	}
	else
	{
		$query = "SELECT `Plan submitted` as submitted ".
				"FROM `plan groups` ".
				"WHERE `Plan ID`='".$game['planID']."';";
		$result = mysql_query( $query, $connection );
		$row = mysql_fetch_array( $result );
		
		if( !$row['submitted'] )
			include "./inc/playerPhase2.inc"; // phase1 has finished and phase2 has already started
		else
			include "./inc/gameFinished.inc";	// game has already finished
	}
?>