<?php
	include_once("../inc/db_connect.php");
	include_once("../inc/init.php");
	
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
		do
		{
			$token = generatePassword( $username );
			$password = sha1( $gData['salt'].sha1( $gData['salt'].$token ));
			$alreadyExist = false;
			$query = "INSERT INTO `users` (`username`, `password`, `role`)".
					"VALUES ('$username', '$password', 'organizer');";
			if( !mysql_query( $query, $connection ))
				if( mysql_errno( $connection ) == 1062 )
					$alreadyExist = true;
		} while( $alreadyExist );
		
		$subject = "Polygame Login data";
		$body = "\r\nHere are your login data:\r\n\r\n\t\tUsername: ".$username."\r\n\t\tPassword: ".$password."\r\n";

		$mailsend = mail( $mail, $subject, $body );
		if( $mailsend )
			$response = array( 
				'code' => '200', 
				'form' => "newAccountForm", 
				'message' => $TEXT['newUser-message_4']);
		else	// Errors occurred while delivering mail
			$response = array( 
				'code' => "404", 
				'form' => "newAccountForm",
				'message' => $TEXT['newUser-message_5'].' <i>'.$mail.'</i>' );
		
		$response = json_encode( $response );
		echo $response;
	}
?>