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
		$query = "SELECT `User ID` as userID, `Username`, `Password`, `Role`, `Nonce` ".
				"FROM `users` ".
				"WHERE `Username`='$username'";
		$result = mysql_query( $query, $connection );
		while(( $row = mysql_fetch_array( $result )))
		{
			if( $token == sha1( $row['Nonce'].$row['Password'] ))
			{
				$gData['logged'] = true;
				$gData['userID'] = $row['userID'];
				$gData['username'] = $row['Username'];
				$gData['password'] = $row['Password'];
				$gData['role'] = $row['Role'];
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
			$gData['langFile'] = 'en.inc';
		break;
		case 'de':
			$gData['langFile'] = 'de.inc';
		break;
		case 'it':
			$gData['langFile'] = 'it.inc';
		break;
		default:
			$gData['langFile'] = 'en.inc';
	}
?>
