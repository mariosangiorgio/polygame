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
	if( !( $game = mysql_fetch_array( $result )))
		redirectTo('../errorPage.php');
	
	$query = "DELETE FROM `users` ".
			"WHERE `User ID` IN ( ".
			"   SELECT `Player ID` ".
			"   FROM `players` ".
			"   WHERE `Game ID`='".$game['gameID']."' ) ".
			"OR `User ID` IN ( ".
			"   SELECT `Voter ID` ".
			"   FROM `voters` ".
			"   WHERE `Game ID`='".$game['gameID']."' );";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
		
	$query = "DELETE FROM `game` ".
			"WHERE `Game ID`='".$game['gameID']."';";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
	
	redirectTo('../organize.php');
?>