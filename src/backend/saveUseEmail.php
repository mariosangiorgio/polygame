<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );

	if( !isSet( $_POST['phase'] ) || 
			$_POST['phase'] != 3 )
		redirectTo('../errorPage.php');
	
	if( !isSet( $_POST['useEmail'] ))
		redirectTo('../errorPage.php');
		
	$value = null;
	if( $_POST['useEmail'] == 'true' )
		$value = 1;
	else if( $_POST['useEmail'] == 'false' )
		$value = 0;
	else
		redirectTo('../errorPage.php');
	
	$query = "SELECT `Game ID` as gameID ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	if( !( $game = mysql_fetch_array( $result )))
		redirectTo('../errorPage.php');
	
	$query = "UPDATE `game` ".
			"SET `Use email`='$value' ".
			"WHERE `Game ID`='".$game['gameID']."';";
	mysql_query( $query, $connection );

	$query = "DELETE FROM `users` ".
			"WHERE `User ID` IN ( ".
			"SELECT `Player ID` ".
			"FROM players ".
			"WHERE `Game ID`='".$game['gameID']."' );";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
	
	$currentPhase = 3;
	// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
	setcookie( 'phase', $currentPhase , time() + 3600, '/' );
	
	if( isSet( $_POST['usingAjax'] ) && 
			$_POST['usingAjax'] == "true" )
	{
		include('../inc/newGameBar.inc'); 
?>
<div id="divPhase3" class="phase3 phases">
<?
		if( $_POST['useEmail'] != 'NULL' )
		{
			if( $_POST['useEmail'] == 'true' )
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