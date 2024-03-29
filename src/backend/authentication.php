<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/init.inc");
	
	if( !isSet( $_POST['username'] ) || 
			!isSet( $_POST['password'] ))
		redirectTo('../errorPage.php');
	
	//Sanitizing inputs
	$username = mysql_real_escape_string( $_POST['username']);
	$password = mysql_real_escape_string( $_POST['password']);

	$username_re = '^[a-zA-Z0-9]{6,12}$';
	$password_re = '^[a-zA-Z0-9]{6,12}$';
	
	if( !$username )
		$response = array( 'code' => "401", 'message' => $TEXT['main-username_1'] );
	else
	{
		if( strlen( $username ) < 6 || strlen( $username ) > 12 )
			$response = array( 'code' => "401", 'form' => "loginForm", 'message' => $TEXT['main-username_2'] );
		else if( !ereg( $username_re, $username ))
			$response = array( 'code' => "401", 'form' => "loginForm", 'message' => $TEXT['main-username_3'] );
	}
	if( !$response )
	{
		if( !$password )
			$response = array( 'code' => "402", 'form' => "loginForm", 'message' => $TEXT['main-password_1'] );
		else
		{
			if( strlen( $password ) < 6 || strlen( $password ) > 12 )
				$response = array( 'code' => "402", 'form' => "loginForm", 'message' => $TEXT['main-password_2'] );
			else if( !ereg( $password_re, $password ))
				$response = array( 'code' => "402", 'form' => "loginForm", 'message' => $TEXT['main-password_3'] );
		}
	}
	if( $response )
		redirectTo('../index.php');
	else
	{
		$query = "SELECT `Username`,`Role`,`Password` FROM `users` WHERE `Username`='$username'";
		$result = mysql_query( $query, $connection );
		if( mysql_num_rows( $result ))	
		{
			// User exists, check if password is correct
			$realPassword = sha1( $gData['salt'].sha1( $gData['salt'].$password ));
			// Assuming that password isn't correct
			$response = array( 'code' => "403", 'form' => "loginForm", 'message' => 'Invalid Password' );
			while(( $user = mysql_fetch_array( $result )))
			{
				if( $realPassword == $user['Password'] )
				{
					// Password is correct
					$nonce = uniqid();
					$query = "UPDATE `users` SET `Nonce`='$nonce' WHERE `Username`='$username' AND `Password`='$realPassword';";
					mysql_query( $query, $connection );
					$token = sha1( $nonce.$user['Password'] );
					// TODO: setcookie( 'at', $username.":".$token, time() + 3600 * 24, '/', 'localhost' );
					setcookie( 'at', $username.":".$token, 0, '/' );
					$response = array( 'code' => "200", 'form' => "loginForm", 'message' => 'OK' );
					break;
				}
			}
		}
		else	// User not exists
			$response = array( 'code' => "404", 'form' => "loginForm", 'message' => 'User not exists' );

		$response = json_encode( $response );
		echo $response;
	}
?>