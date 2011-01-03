<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );
	
	if( !isSet( $_POST['phase'] ) || 
			$_POST['phase'] != 2 )
		redirectTo('../errorPage.php');

	if( !isSet( $_POST['wedgesSelected'] ) || 
			!is_numeric( $_POST['wedgesSelected'] ))
		redirectTo('../errorPage.php');
	
	$query = "SELECT `Game ID` as gameID, `Use email` as useEmail ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	$game = mysql_fetch_array( $result );
	if( !$game )
		redirectTo('../errorPage.php');
	
	$insertQuery = "INSERT INTO `wedge groups`(`game ID`, `wedge ID`) VALUES";
	for( $index = 0; $index < $_POST['wedgesSelected']; $index++ )
	{
		if( !isSet( $_POST['wedge'.$index] ) || 
				!is_numeric( $_POST['wedge'.$index]))
			redirectTo('../errorPage.php');
		
		$wedgeIndex = mysql_real_escape_string( $_POST['wedge'.$index] );
		
		$insertQuery = $insertQuery." ('".$game['gameID']."','$wedgeIndex')";
		if( $index != ( $_POST['wedgesSelected'] - 1 ))
			$insertQuery = $insertQuery.",";
	}
	
	// Remove existing wedges linked to the current game
	$deleteQuery = "DELETE FROM `wedge groups` ".
				"WHERE `Game ID`='".$game['gameID']."'; ";
	
	if( !mysql_query( $deleteQuery, $connection ))
		redirectTo('../errorPage.php');
	
	if( !mysql_query( $insertQuery, $connection ))
		redirectTo('../errorPage.php');
	
	// Remove existing player linked to the wedges removed
	$query = "DELETE FROM `users` ".
			"WHERE `User ID` IN ( ".
			" SELECT `Player ID` FROM `players` ".
			" WHERE `Game ID`='".$game['gameID']."' ".
			" AND `Wedge ID` NOT IN ( ".
			"  SELECT `Wedge ID` FROM `wedge groups` ".
			"  WHERE `Game ID`='".$game['gameID']."' ));";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
	
	$currentPhase = 3;
	// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
	setcookie( 'phase', $currentPhase, time() + 3600, '/' );
	
	if( isSet( $_POST['usingAjax'] ) && 
			$_POST['usingAjax'] == "true" )
	{
		include('../inc/newGameBar.inc'); 
?>
<div id="divPhase3" class="phase3 phases">
<?
		if( $game['useEmail'] != NULL )
		{
			if( $game['useEmail'] )
				include "../inc/newGamePhase3_2.inc";
			else
				include "../inc/newGamePhase3_3.inc";
		}
		else
			include "../inc/newGamePhase3_1.inc";
?>
</div>
<?
		exit();
	}
	redirectTo('../createNewGame.php');
?>