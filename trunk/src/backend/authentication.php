<?php
	session_start();
	include_once("../inc/db_connect.php");

	//Sanitizing inputs
	$username = mysql_real_escape_string( $_POST['username']);
	$password = mysql_real_escape_string( $_POST['password']);

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
		
			if( $_POST['usingAjax'])
				$response = array(  'code' => "200",
									'message' => 'OK' );
		}
		else
		{
			// Password isn't correct
			if( $_POST['usingAjax'])
				$response = array(  'code' => "401",
									'message' => 'Invalid Password' );
		}
	}
	else{
		// User not exists
		$response = array(  'code' => "402",
							'message' => 'User not exists' );
	}
	
	$response = json_encode( $response );
	echo $response;
?>