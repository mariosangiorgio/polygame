<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );

	if( !isSet( $_POST['phase'] ) || 
			$_POST['phase'] != 4 )
		redirectTo('../errorPage.php');
		
	if( !isSet( $_POST['numberOfGroups'] ) || 
			!is_numeric( $_POST['numberOfGroups'] ))
		redirectTo('../errorPage.php');
	
	$query = "SELECT `Game ID` as gameID ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	if( !( $game = mysql_fetch_array( $result )))
		redirectTo('../errorPage.php');
	
	$query = "DELETE FROM `plan groups` ".
			"WHERE `Game ID`='".$game['gameID']."'; ";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
	
	$groups = array();
	$query = "INSERT INTO `plan groups`(`game ID`, `group name`) VALUES ";
	for( $index = 0; $index < $_POST['numberOfGroups']; $index++ )
	{
		if( !isSet( $_POST['groupName'.$index] ))
			redirectTo('../errorPage.php');
		
		$groupName = mysql_real_escape_string( $_POST['groupName'.$index] );
		$query = $query."('".$game['gameID']."', '$groupName' )";
		
		if( $index != $_POST['numberOfGroups'] - 1 )
			$query = $query.", ";
	}
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
	
	$planGroups = array();
	$query = "SELECT `Plan ID` as planID, `Group name` as groupName ".
			"FROM `plan groups` ".
			"WHERE `Game ID`='".$game['gameID']."';";
	if( !( $result = mysql_query( $query, $connection )))
		redirectTo('../errorPage.php');
	while(( $row = mysql_fetch_array( $result )))
		$planGroups[$row['groupName']] = $row['planID'];
	
	$query = "SELECT p.`Player ID` as playerID, u.username as username ".
			"FROM `players` p, `users` u ".
			"WHERE p.`Game ID`='".$game['gameID']."' ".
			"AND p.`Player ID`=u.`User ID`;";
	if( !( $result = mysql_query( $query, $connection )))
		redirectTo('../errorPage.php');
	while(( $user = mysql_fetch_array( $result )))
	{
		if( !isSet( $_POST[$user['username']] ) || 
				!isSet( $planGroups[$_POST[$user['username']]]))
			redirectTo('../errorPage.php');
	
		$query = "UPDATE `players` ".
				"SET `Plan ID`='".$planGroups[$_POST[$user['username']]]."' ".
				"WHERE `player ID`='".$user['playerID']."'; ";
		mysql_query( $query, $connection );
	}
	
	$currentPhase = 5;
	// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
	setcookie( 'phase', $currentPhase , time() + 3600, '/' );	
	
	if( isSet( $_POST['usingAjax'] ) && 
			$_POST['usingAjax'] == "true" )
	{
		include('../inc/newGameBar.inc');
		include('../inc/newGamePhase'.$currentPhase.'.inc');
		exit();
	}
	redirectTo('../createNewGame.php');
?>