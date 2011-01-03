<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );
	
	if( !isSet( $_POST['phase'] ) || 
			$_POST['phase'] != 1 )
		redirectTo('../errorPage.php');
		
	if( !isSet( $_POST['time1'] ) || 
			!is_numeric( $_POST['time1'] ))
		redirectTo('../errorPage.php');
	
	if( !isSet( $_POST['time5'] ) || 
			!is_numeric( $_POST['time5'] ))
		redirectTo('../errorPage.php');
	
	if( !isSet( $_POST['time6'] ) || 
			!is_numeric( $_POST['time6'] ))
		redirectTo('../errorPage.php');
	
	if( !isSet( $_POST['advanced'] ))
		redirectTo('../errorPage.php');
	
	$query = "UPDATE `game` SET ".
			"`Length 1`='".$_POST['time1']."', ".
			"`Length 2`='".$_POST['time5']."', ".	
			"`Length 3`='".$_POST['time6']."'";
	
	if( $_POST['advanced'] == "true" )
	{
		if( !isSet( $_POST['time2'] ) || 
				!is_numeric( $_POST['time2'] ))
			redirectTo('../errorPage.php');
		
		if( !isSet( $_POST['time3'] ) || 
				!is_numeric( $_POST['time3'] ))
			redirectTo('../errorPage.php');
		
		if( !isSet( $_POST['time4'] ) || 
				!is_numeric( $_POST['time4'] ))
			redirectTo('../errorPage.php');
		
		$query = $query.", `Advanced`='1',".
						" `Length 1a`='".$_POST['time2']."',".
						" `Length 1b`='".$_POST['time3']."',".
						" `Length 1c`='".$_POST['time4']."'";
	}
	else if( $_POST['advanced'] == "false" )
		$query = $query.", `Advanced`='0' ";
	else
		redirectTo('../errorPage.php');

	$query = $query." WHERE `Organizer ID`='".$gData['userID']."';";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
	
	$currentPhase = 2;
	// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
	setcookie( 'phase', $currentPhase, time() + 3600, '/' );
	
	if( isSet( $_POST['usingAjax'] ) && 
			$_POST['usingAjax'] == "true" )
	{
		$query = "SELECT `Game ID` as gameID ".
				"FROM `game` ".
				"WHERE `Organizer ID`='".$gData['userID']."';";
		$result = mysql_query( $query, $connection );
	
		if(( $row = mysql_fetch_array( $result )))
			$game['gameID'] = $row['gameID']; 
		else
			redirectTo('../errorPage.php');
		
		include('../inc/newGameBar.inc');
		include('../inc/newGamePhase'.$currentPhase.'.inc');
		exit();
	}
	redirectTo('../createNewGame.php');
?>