<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );

	if( !isSet( $_POST['phase'] ) || 
			$_POST['phase'] != 3 )
		redirectTo('../errorPage.php');
	
	if( !isSet( $_POST['numberOfUsers'] ) ||
			!is_numeric( $_POST['numberOfUsers'] ) || 
			$_POST['numberOfUsers'] < 0 )
		redirectTo('../errorPage.php');
	
	$query = "SELECT `Game ID` as gameID, `Use email` as useEmail ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	if( !( $game = mysql_fetch_array( $result )))
		redirectTo('../errorPage.php');
	
	$query = "DELETE FROM `users` ".
			"WHERE `User ID` IN ( ".
			"SELECT `Player ID` ".
			"FROM players ".
			"WHERE `Game ID`='".$game['gameID']."' );";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
		
	for( $index = 0; $index < $_POST['numberOfUsers']; $index++ )
	{
		if( !isSet( $_POST['wedge'.$index] ) || 
				!is_numeric( $_POST['wedge'.$index] ) ||
				!isSet( $_POST['user'.$index] ))
			redirectTo('../errorPage.php');
		
		$wedgeIndex = mysql_real_escape_string( $_POST['wedge'.$index] );
		$username = mysql_real_escape_string( $_POST['user'.$index] );
		$password = null;
		$token = null;
		do
		{
			$token = generatePassword( $username );
			$password = sha1( $gData['salt'].sha1( $gData['salt'].$token ));
			$alreadyExist = false;
			$query = "INSERT INTO `users` (`username`, `password`, `role`)".
					"VALUES ('$username', '$password', 'player');";
			if( !mysql_query( $query, $connection ))
				if( mysql_errno( $connection ) == 1062 )
					$alreadyExist = true;
		} while( $alreadyExist );
		
		$query = "SELECT `User ID` as userID ".
				"FROM `users` ". 
				"WHERE `username`='$username' AND `password`='$password'";
		$result = mysql_query( $query, $connection );
		if( !( $user = mysql_fetch_array( $result )))
			redirectTo('../errorPage.php');
		
		if( $game['useEmail'] )
		{
			if( !isSet( $_POST['email'.$index] ))
				redirectTo('../errorPage.php');
				
			$email = mysql_real_escape_string( $_POST['email'.$index] );
			$query = "INSERT INTO `players` ".
					"(`Player ID`, `Email`, `Game ID`, `Wedge ID`, `Token`) ".
					"VALUES ('".$user['userID']."', '$email', ".
					"'".$game['gameID']."', '$wedgeIndex', '$token' )";
		}
		else
			$query = "INSERT INTO `players`(`player ID`, `game ID`, `wedge ID`, `token`) ".
					"VALUES ('".$user['userID']."', '".$game['gameID']."', '$wedgeIndex', '$token' )";
		if( !mysql_query( $query, $connection ))
			redirectTo('../errorPage.php');
	}
	$query = "DELETE FROM `plan groups` ".
			"WHERE `Game ID`='".$game['gameID']."'; ";
	if( !mysql_query( $query, $connection ))
		redirectTo('../errorPage.php');
		
	$currentPhase = 4;
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