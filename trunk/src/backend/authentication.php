<?php
	include_once("../inc/common.php");
	include_once '../lang/'.$lang_file;
	include_once("../inc/db_connect.php");

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
	{
		$_SESSION['response'] = $response;
		header("Location: ../index.php");
	}
	else
	{
		$query = "SELECT `username`,`role`,`password` FROM `Users` WHERE `username`='$username'";
		$result = mysql_query( $query, $connection );
		if( mysql_num_rows( $result ))	
		{
			// User exists, check if password is correct
			$user = mysql_fetch_array( $result );
			if( sha1( "polygame".$password ) == $user['password'] )
			{
				// Password is correct
				$_SESSION['loggedIn']	= "yes";
				$_SESSION['username']	= $username;
				$_SESSION['role']		= $user['role'];
			
				$response = array( 'code' => "200", 'form' => "loginForm", 'message' => 'OK' );
			}
			else
				// Password isn't correct
				$response = array( 'code' => "403", 'form' => "loginForm", 'message' => 'Invalid Password' );
		}
		else		
			// User not exists
			$response = array( 'code' => "404", 'form' => "loginForm", 'message' => 'User not exists' );
		if( $_POST['usingAjax'] == "false" )
		{
			$_SESSION['response'] = $response;
			header("Location: ../index.php ");
		}
		else if( $_POST['usingAjax'] == "true" )
		{
			$response = json_encode( $response );
			echo $response;
		}
	}
?>