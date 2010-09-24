<?php
	include_once("../inc/common.php");
	include_once '../lang/'.$lang_file;
	include_once("../inc/db_connect.php");
	include_once("../backend/utils.php");
	
	$filename = $_FILES['playersList']['tmp_name'];
	$playersList = file( $filename );

	$numberOfWedges = 0;
	$numberOfUsers = 0;
	foreach( $playersList as $playerIndex => $player ) {
		$userId = htmlspecialchars( $player );
		$userId = preg_replace("/[\n\r]/", "", $userId ); 
		$userId = mysql_real_escape_string( $userId );
		
		$players[$numberOfUsers] = $userId;
		$numberOfUsers++;
	}
	$_SESSION['phase3']['numberOfUsers'] = $numberOfUsers;
	
	foreach( $_SESSION['phase2']['wedges'] as $keyValue => $wedgeId )
		$wedges[$numberOfWedges++] = $wedgeId;
	
	$vector = generateRandomSequence( 0, $numberOfUsers - 1 );
	for( $userIndex = 0, $wedgeIndex = 0; $userIndex < $numberOfUsers; $userIndex++ )
	{
		$users[$players[$vector[$userIndex]]]['wedgeId'] = $wedges[$wedgeIndex];
		$wedgeIndex = ( $wedgeIndex + 1 ) % $numberOfWedges;
	}
	
	$_SESSION['phase3']['users'] = $users;
	$_SESSION['phaseNumber'] = 3;
	header("Location: ../createNewGame.php ");
?>