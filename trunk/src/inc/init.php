<?php			
	$gData['salt'] = "polyGAM3";
	$gData['logged'] = false;
	$gData['userID'] = null;
	$gData['username'] = null;
	$gData['password'] = null;
	$gData['role'] = null;
	$gData['lang'] = null;
	$gData['langFile'] = null;
	
	// Check authentication
	if( isSet( $_COOKIE['at']))
	{
		list( $username, $token ) = explode( ':', $_COOKIE['at'] );
		$username = mysql_real_escape_string( $username );
		$query = "SELECT `User ID`,`username`,`password`,`role`,`nonce` FROM `users` WHERE `username`='$username'";
		$result = mysql_query( $query, $connection );
		while(( $row = mysql_fetch_array( $result )))
		{
			if( $token == sha1( $row['nonce'].$row['password'] ))
			{
				$gData['logged'] = true;
				$gData['userID'] = $row['User ID'];
				$gData['username'] = $row['username'];
				$gData['password'] = $row['password'];
				$gData['role'] = $row['role'];
				break;
			}
		}
	}
	// Check language
	if( isSet( $_GET['lang']))
	{
		$gData['lang'] = $_GET['lang'];
		// TODO: setcookie( 'at', $username.":".$token, time() + 3600 * 24, '/', 'baobab.elet.polimi.it' );
		setcookie( 'lang', $gData['lang'] , time() + ( 3600 * 24 * 30 ), '/' );
	}
	else if( isSet( $_COOKIE['lang']))
		$gData['lang'] = $_COOKIE['lang'];
	else
		$gData['lang'] = 'en';
	
	switch( $gData['lang'] ) 
	{
		case 'en':
			$gData['langFile'] = 'en.php';
		break;
		case 'de':
			$gData['langFile'] = 'de.php';
		break;
		case 'it':
			$gData['langFile'] = 'it.php';
		break;
		default:
			$gData['langFile'] = 'en.php';
	}
?>
