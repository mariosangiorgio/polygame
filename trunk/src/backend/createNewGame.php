<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );
	
	$query = "SELECT `Game ID` as gameID ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	if( !mysql_num_rows( $result ))
	{
		$query = "INSERT INTO `game`(`Game ID`, `Organizer ID`) ".
				"VALUES( NULL, '".$gData['userID']."');";
		if( !mysql_query( $query, $connection ) )
			redirectTo('./errorPage.php');

		$query = "SELECT `Game ID` as gameID ".
				"FROM `game` ".
				"WHERE `Organizer ID`='".$gData['userID']."';";
		$result = mysql_query( $query, $connection );
		if(( $row = mysql_fetch_array( $result )))
			$game['gameID'] = $row['gameID'];
		else
			redirectTo('../errorPage.php');
	}
	else
		redirectTo('../errorPage.php');
		
	redirectTo('../createNewGame.php');
?>