<?php
	include_once("../inc/db_connect.php");
	include_once("../inc/init.php");
	include_once("../lang/".$gData['langFile']);
	include_once("../backend/utils.php");
	
	if( $gData['logged'] && $gData['role'] == "organizer" )
	{
		$query = "SELECT `Game ID` as id, Defined, Started FROM `game` ".
				"WHERE `Organizer ID`='".$gData['userID']."';";
		$result = mysql_query( $query, $connection );
		
		if(( $row = mysql_fetch_array( $result )))
		{
			$gData['gameID'] = $row['id']; 
			if( $row['Defined'] )
				;// TODO: Redirect to an error page (current organizer has a game already defined)
		}
		else
			;// TODO: Redirect to an error page (current organizer hasn't an existing game)
	}
	else
	{
		$errorCode = 401;	// Unauthorized
		include "errorPage.php";
		exit();
	}
	
	$query = "DELETE FROM users ".
			"WHERE `User ID` IN ( ".
			"SELECT `Player ID` ".
			"FROM players ".
			"WHERE `Game ID`='".$gData['gameID']."' );";
	mysql_query( $query, $connection );
	
	$query = "SELECT `Wedge ID` as wedgeID ".
			"FROM `wedge groups` ".
			"WHERE `Game ID`='".$gData['gameID']."';";
	$result = mysql_query( $query, $connection );
	
	$wedges = array();
	$wedgeIndex  = 0;
	$numberOfWedges = 0;
	while(( $row = mysql_fetch_array( $result )))
		$wedges[$numberOfWedges++] = $row['wedgeID'];	
	
	$filename = $_FILES['playersList']['tmp_name'];
	$playersList = file( $filename );
	$numberOfPlayer = 0;
	foreach( $playersList as $playerIndex => $player ) {
		$userId = htmlspecialchars( $player );
		$userId = preg_replace("/[\n\r]/", "", $userId ); 
		$userId = mysql_real_escape_string( $userId );
	
		$wedgeIndex = ( $wedgeIndex + 1 ) % $numberOfWedges;
		$password = null;
		$token = null;
		do
		{
			$token = uniqid();
			$password = sha1( $gData['salt'].sha1( $gData['salt'].$token ));
			$alreadyExist = false;
			$query = "INSERT INTO `users` (`username`, `password`, `role`)".
					"VALUES ('".$userId."', '$password', 'player');";
			if( !mysql_query( $query, $connection ))
				if( mysql_errno( $connection ) == 1062 )
					$alreadyExist = true;
		} while( $alreadyExist );
		
		$query = "SELECT `User ID` as id FROM `users`". 
				"WHERE `username`='$userId' AND `password`='$password'";
		$result = mysql_query( $query, $connection );
		$user = mysql_fetch_array( $result );
		
		$query = "INSERT INTO `players`(`player ID`, `game ID`, `wedge ID`, `token`) ".
				"VALUES ('".$user['id']."', '".$gData['gameID']."', '$wedges[$wedgeIndex]', '$token' )";
		$result = mysql_query( $query, $connection );
		
		if( !$result )
			;// TODO: invalid data
		
		$numberOfPlayer++;
	}
	
	$query = "SELECT DISTINCT (username) ".
			"FROM `users` u, `players` p ".
			"WHERE p.`Game ID` = '4' ".
			"AND p.`Player ID` = u.`User ID`;";
	$result = mysql_query( $query, $connection );
	$numberOfRows = mysql_num_rows( $result );
	if( $numberOfRows != $numberOfPlayer )
	{
		$query = "DELETE FROM users ".
				"WHERE `User ID` IN ( ".
				"SELECT `Player ID` ".
				"FROM players ".
				"WHERE `Game ID`='".$gData['gameID']."' );";
		mysql_query( $query, $connection );
	}
	
	header("Location: ../createNewGame.php ");
?>