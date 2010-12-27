<?php
	include_once("./inc/db_connect.php");
	include_once("./inc/init.php");
	include_once("./lang/".$gData['langFile']);
	include_once("./backend/utils.php");
	
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
		{
			$query = "INSERT INTO `game`(`Game ID`, `Organizer ID`) ".
					"VALUES( NULL, '".$gData['userID']."');";
			$result = mysql_query( $query, $connection );

			$query = "SELECT `Game ID` as id FROM `game` ".
					"WHERE `Organizer ID`='".$gData['userID']."';";
			$result = mysql_query( $query, $connection );
		
			if(( $row = mysql_fetch_array( $result )))
				$gData['gameID'] = $row['id']; 
		}
	}
	else
	{
		$errorCode = 401;	// Unauthorized
		include "errorPage.php";
		exit();
	}
		
	
	if( isSet( $_GET['phase'] ))
	{
		$currentPhase = $_GET['phase'];
		// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
		setcookie( 'phase', $currentPhase , time() + 3600, '/' );
	}
	else if( isSet( $_COOKIE['phase'] ))
		$currentPhase = $_COOKIE['phase'];
	else
		$currentPhase = 1;
	
	if( $_POST['phase'] == 1 )
	{
		$query = "UPDATE `game` SET ";
		
		if( !isSet( $_POST['time1'] ) || 
				!is_numeric( $_POST['time1'] ))
			;// TODO: invalid data
		$query = $query." `Length 1`='".$_POST['time1']."', ";

		if( !isSet( $_POST['time5'] ) || 
				!is_numeric( $_POST['time5'] ))
			;// TODO: invalid data
		$query = $query."`Length 2`='".$_POST['time5']."', ";

		if( !isSet( $_POST['time6'] ) || 
				!is_numeric( $_POST['time6'] ))
			;// TODO: invalid data
		$query = $query."`Length 3`='".$_POST['time6']."'";
		
		if( isSet( $_POST['advanced'] ))
		{
			if( $_POST['advanced'] == "true" )
			{
				$query = $query.", `Advanced`='1', ";
				
				if( !isSet( $_POST['time2'] ) || 
						!is_numeric( $_POST['time2'] ))
					;// TODO: invalid data
				$query = $query."`Length 1a`='".$_POST['time2']."', ";
			
				if( !isSet( $_POST['time3'] ) || 
						!is_numeric( $_POST['time3'] ))
					;// TODO: invalid data
				$query = $query."`Length 1b`='".$_POST['time3']."', ";
				
				if( !isSet( $_POST['time4'] ) || 
						!is_numeric( $_POST['time4'] ))
					;// TODO: invalid data
				$query = $query."`Length 1c`='".$_POST['time4']."'";
			}
			else if( $_POST['advanced'] == "false" )
				$query = $query.", `Advanced`='0'";
			else
				; // TODO: invalid data
		}
		$query = $query." WHERE `game ID`='".$gData['gameID']."';";
		mysql_query( $query, $connection );
		
		$currentPhase = 2;
		// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
		setcookie( 'phase', $currentPhase , time() + 3600, '/' );
	}
	if( $_POST['phase'] == 2 )
	{
		if( !isSet( $_POST['wedgesSelected'] ) || 
				!is_numeric( $_POST['wedgesSelected'] ))
			;// TODO: invalid data
		
		$query = "DELETE FROM `wedge groups` WHERE `Game ID`='".$gData['gameID']."';";
		$result = mysql_query( $query, $connection );
		
		$query = "INSERT INTO `wedge groups`(`game ID`, `wedge ID`) VALUES";
		for( $index = 0; $index < $_POST['wedgesSelected']; $index++ )
		{
			if( !isSet( $_POST['wedge'.$index] ) || 
					!is_numeric( $_POST['wedge'.$index]))
				;// TODO: invalid data
			
			$wedgeIndex = mysql_real_escape_string( $_POST['wedge'.$index] );
			
			$query = $query." ('".$gData['gameID']."', '$wedgeIndex' )";
			if( $index != ( $_POST['wedgesSelected'] - 1 ))
				$query = $query.",";
		}
		$result = mysql_query( $query, $connection );
		if( !$result )
			;// TODO: invalid data
		
		$query = "DELETE FROM `users` ".
				"WHERE `User ID` IN ( ".
				" SELECT `Player ID` FROM `players` ".
				" WHERE `Game ID`='".$gData['gameID']."' ".
				" AND `Wedge ID` NOT IN ( ".
				"  SELECT `Wedge ID` FROM `wedge groups` ".
				"  WHERE `Game ID`='".$gData['gameID']."' ));";
		$result = mysql_query( $query, $connection );
		
		$currentPhase = 3;
		// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
		setcookie( 'phase', $currentPhase , time() + 3600, '/' );
	}
	if( $_POST['phase'] == 3 )
	{
		if( isSet( $_POST['useEmail'] ))
		{
			$value = null;
			if( $_POST['useEmail'] == "true" )
				$value = 1;
			else if( $_POST['useEmail'] == "false" )
				$value = 0;
			else
				;// TODO: invalid data
			
			$query = "UPDATE `game` SET `Use email`='$value' ".
					"WHERE `game ID`='".$gData['gameID']."';";
			mysql_query( $query, $connection );
			$currentPhase = 3;
		}
		else if( isSet( $_POST['numberOfUsers'] ))
		{ 
			if( !is_numeric( $_POST['numberOfUsers'] ))
				;// TODO: invalid data
		
			$query = "DELETE FROM users ".
					"WHERE `User ID` IN ( ".
					"SELECT `Player ID` ".
					"FROM players ".
					"WHERE `Game ID`='".$gData['gameID']."' );";
			mysql_query( $query, $connection );
			
			if( $_POST['numberOfUsers'])
			{
				for( $index = 0; $index < $_POST['numberOfUsers']; $index++ )
				{
					if( !isSet( $_POST['wedge'.$index] ) || 
						!is_numeric( $_POST['wedge'.$index] ) ||
						!isSet( $_POST['user'.$index] ))
						;// TODO: invalid data
					
					$wedgeIndex = mysql_real_escape_string( $_POST['wedge'.$index] );
					$username = mysql_real_escape_string( $_POST['user'.$index] );
					$password = null;
					$token = null;
					do
					{
						$token = uniqid();
						$password = sha1( $gData['salt'].sha1( $gData['salt'].$token ));
						$alreadyExist = false;
						$query = "INSERT INTO `users` (`username`, `password`, `role`)".
								"VALUES ('$username', '$password', 'player');";
						if( !mysql_query( $query, $connection ))
							if( mysql_errno( $connection ) == 1062 )
								$alreadyExist = true;
					} while( $alreadyExist );
					
					$query = "SELECT `User ID` as id FROM `users`". 
							"WHERE `username`='$username' AND `password`='$password'";
					$result = mysql_query( $query, $connection );
					$user = mysql_fetch_array( $result );
					
					$query = "INSERT INTO `players`(`player ID`, `game ID`, `wedge ID`, `token`) ".
							"VALUES ('".$user['id']."', '".$gData['gameID']."', '$wedgeIndex', '$token' )";
					$result = mysql_query( $query, $connection );
					if( !$result )
						;// TODO: invalid data
				}
				
				$query = "DELETE FROM `plan groups` ".
						"WHERE `Game ID`='".$gData['gameID']."'; ";
				mysql_query( $query, $connection );
				
				$currentPhase = 4;
			}
			else
			{
				$query = "UPDATE `game` SET `Use email`=NULL ".
						"WHERE `game ID`='".$gData['gameID']."';";
				mysql_query( $query, $connection );
				$currentPhase = 3;
			}
		}
		else
			;// TODO: invalid data
		// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
		setcookie( 'phase', $currentPhase , time() + 3600, '/' );
	}
	if( $_POST['phase'] == 4 )
	{
		if( !isSet( $_POST['numberOfGroups'] ) || 
				!is_numeric( $_POST['numberOfGroups'] ))
			;// TODO: invalid data
		
		if( $_POST['numberOfGroups'])
		{
			$query = "DELETE FROM `plan groups` ".
					"WHERE `Game ID`='".$gData['gameID']."'; ";
			mysql_query( $query, $connection );
			
			$groups = array();
			for( $index = 0; $index < $_POST['numberOfGroups']; $index++ )
			{
				if( !isSet( $_POST['groupName'.$index] ) || 
						!is_numeric( $_POST['groupName'.$index]))
					;// TODO: invalid data
				
				$groupName = mysql_real_escape_string( $_POST['groupName'.$index] );
				$query = "INSERT INTO `plan groups`(`game ID`, `group name`) VALUES ".
						"('".$gData['gameID']."', '$groupName' )";
				$result = mysql_query( $query, $connection );
				if( !$result )
					;// TODO: invalid data
				
				$groups[$groupName] = mysql_insert_id( $connection );
			}
			
			$query = "SELECT p.`Player ID` as playerID, u.username as username ".
					"FROM `players` p, `users` u ".
					"WHERE p.`Game ID`='".$gData['gameID']."' ".
					"AND p.`Player ID`=u.`User ID`;";
			$result = mysql_query( $query, $connection );
			while(( $user = mysql_fetch_array( $result )))
			{
				if( !isSet( $_POST[$user['username']] ) || 
						!isSet( $groups[$_POST[$user['username']]]))
					;// TODO: invalid data
			
				$query = "UPDATE `players` ".
						"SET `Plan ID`='".$groups[$_POST[$user['username']]]."' ".
						"WHERE `player ID`='".$user['playerID']."'; ";
				mysql_query( $query, $connection );
			}
			
			$currentPhase = 5;
			// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
			setcookie( 'phase', $currentPhase , time() + 3600, '/' );	
		}
	}
	if( $_POST['phase'] == 5 )
	{
		if( !isSet( $_POST['numberOfVoters'] ) || 
				!is_numeric( $_POST['numberOfVoters'] ))
			;// TODO: invalid data
		
		$query = "DELETE FROM users ".
				"WHERE `User ID` IN ( ".
				"SELECT `Voter ID` ".
				"FROM `voters` ".
				"WHERE `Game ID`='".$gData['gameID']."' );";
		mysql_query( $query, $connection );
			
		for( $index = 0; $index < $_POST['numberOfVoters']; $index++ )
		{
			if( !isSet( $_POST['voter'.$index] ))
				;// TODO: invalid data
					
			$username = mysql_real_escape_string( $_POST['voter'.$index] );
			$password = null;
			$token = null;
			
			do
			{
				$token = uniqid();
				$password = sha1( $gData['salt'].sha1( $gData['salt'].$token ));
				$alreadyExist = false;
				$query = "INSERT INTO `users` (`username`, `password`, `role`)".
						"VALUES ('$username', '$password', 'player');";
				if( !mysql_query( $query, $connection ))
					if( mysql_errno( $connection ) == 1062 )
						$alreadyExist = true;
			} while( $alreadyExist );
					
			$query = "SELECT `User ID` as id FROM `users`". 
					"WHERE `username`='$username' AND `password`='$password'";
			$result = mysql_query( $query, $connection );
			$user = mysql_fetch_array( $result );
					
			$query = "INSERT INTO `voters`(`voter ID`, `game ID`, `token`) ".
					"VALUES ('".$user['id']."', '".$gData['gameID']."', '$token')";
			$result = mysql_query( $query, $connection );
			if( !$result )
				;// TODO: invalid data
		}
		
		// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
		setcookie( 'phase', '', time() + 3600, '/' );
		header('Location: ./index.php');
		exit();
	}
	if( isSet( $_GET['phase'] ) || isSet( $_POST['phase'] ))
		include "newGamePhase".$currentPhase.".php";
	else
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['organization-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" href="./css/main.css" rel="stylesheet" />
	<link type="text/css" href="./css/createNewGame.css" rel="stylesheet" />
	<link type="text/css" href="./css/orizontalBar.css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/JavaScript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
</head>
<body>
	<? include "header.php"; ?>
	<div id="wrapper">
		<? include "newGamePhase".$currentPhase.".php"; ?>
	</div>
</body>
</html>
<?
	}
?>
