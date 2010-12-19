<?php
	include_once("../inc/db_connect.php");
	include_once("./inc/init.php");
	
	//Sanitizing inputs
	$username = mysql_real_escape_string( $_POST['username']);
	$mail = mysql_real_escape_string( $_POST['mail']);

	$username_re = '^[a-zA-Z0-9]{6,12}$';
	$mail_re = '^.+@.+\..+$';
	
	if( !$username )
		$response = array( 'code' => "401", 'form' => "newAccountForm", 'message' => $TEXT['main-username_1'] );
	else
	{
		if( strlen( $username ) < 6 || strlen( $username ) > 12 )
			$response = array( 'code' => "401", 'form' => "newAccountForm", 'message' => $TEXT['main-username_2'] );
		else if( !ereg( $username_re, $username ))
			$response = array( 'code' => "401", 'form' => "newAccountForm", 'message' => $TEXT['main-username_3'] );
	}
	if( !$response )
	{
		if( !$mail )
			$response = array( 'code' => "402", 'form' => "newAccountForm", 'message' => $TEXT['main-mail_1'] );
		else if( !ereg( $mail_re, $mail ))
			$response = array( 'code' => "402", 'form' => "newAccountForm", 'message' => $TEXT['main-mail_2'] );
	}
	if( $response )
		header("Location: ../index.php");
	else
	{
		$query = "SELECT `username` FROM `Users` WHERE `username`='$username'";
		$result = mysql_query( $query, $connection );
		if( mysql_num_rows( $result ))	
			// User already exists
			$response = array( 
				'code' => "402", 
				'form' => "newAccountForm", 
				'message' => $TEXT['newUser-message_1_1'].' <i>'.$username.'</i> '.$TEXT['newUser-message_1_2']);
		else
		{
			$password = generatePassword( $username );
			
			$subject = "Polygame Login data";
			$body = "\r\nHere are your login data:\r\n\r\n\t\tUsername: ".$username."\r\n\t\tPassword: ".$password."\r\n";

			$mailsend = mail( $mail, $subject, $body );
			if( $mailsend )
			{
				// Email correctly sended
				$password = sha1( $gData['salt'].sha1( $gData['salt'].$password ));
				$query = "INSERT INTO `Users` ( `username`, `role`, `password` )".
						 "VALUES ( '$username', 'player', '".$password."' )";
				$result = mysql_query( $query, $connection );
				if( !$result )
					$response = array( 
						'code' => '403', 
						'form' => "newAccountForm", 
						'message' => $TEXT['newUser-message_3']);
				else
					$response = array( 
						'code' => '200', 
						'form' => "newAccountForm", 
						'message' => $TEXT['newUser-message_4']);
			}
			else
				// Errors occurred while delivering mail
				$response = array( 
					'code' => "404", 
					'form' => "newAccountForm",
					'message' => $TEXT['newUser-message_5'].' <i>'.$mail.'</i>' );
		}
		
		$response = json_encode( $response );
		echo $response;
	}
?>