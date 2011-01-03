<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );

	if( !isSet( $_POST['phase'] ) || 
			$_POST['phase'] != 5 )
		redirectTo('../errorPage.php');
		
	if( !isSet( $_POST['numberOfVoters'] ) || 
			!is_numeric( $_POST['numberOfVoters'] ))
		redirectTo('../errorPage.php');
	
	$query = "SELECT `Game ID` as gameID ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	if( !( $game = mysql_fetch_array( $result )))
		redirectTo('../errorPage.php');
	
	$query = "DELETE FROM users ".
			"WHERE `User ID` IN ( ".
			"SELECT `Voter ID` ".
			"FROM `voters` ".
			"WHERE `Game ID`='".$game['gameID']."' );";
	mysql_query( $query, $connection );
		
	for( $index = 0; $index < $_POST['numberOfVoters']; $index++ )
	{
		if( !isSet( $_POST['voter'.$index] ))
			redirectTo('../errorPage.php');
				
		$username = mysql_real_escape_string( $_POST['voter'.$index] );
		$password = null;
		$token = null;
		do
		{
			$token = generatePassword( $username );
			$password = sha1( $gData['salt'].sha1( $gData['salt'].$token ));
			$alreadyExist = false;
			$query = "INSERT INTO `users` (`username`, `password`, `role`)".
					"VALUES ('$username', '$password', 'voter');";
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
				
		$query = "INSERT INTO `voters`(`voter ID`, `game ID`, `token`) ".
				"VALUES ('".$user['userID']."', '".$game['gameID']."', '$token')";
		if( !mysql_query( $query, $connection ) )
			redirectTo('../errorPage.php');
	}
	
	$query = "UPDATE `game` SET `Defined`='1'".
			"WHERE `Game ID`='".$game['gameID']."';";
	if( !mysql_query( $query, $connection ) )
		redirectTo('../errorPage.php');
	
	// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
	setcookie( 'phase', '', time() + 3600, '/' );
?>