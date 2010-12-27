<?php 
	include_once("../inc/db_connect.php");
	include_once("../inc/init.php");
	include_once("../lang/".$gData['langFile']);
	include_once("../backend/utils.php");
	
	if( !$gData['logged'] || !$gData['role'] == "organizer" )
	{
		$errorCode = 401;	// Unauthorized
		include "errorPage.php";
		exit();
	}
	
	if( isSet( $_POST['feedback']))
	{
		$feedback = mysql_real_escape_string( $_POST['feedback']);
		$query = "INSERT INTO `feedbacks` (`author`,`feedback`) ".
				"VALUES ('".$gData['username']."','$feedback')";
		if( mysql_query( $query, $connection ))
			$response = array( 'title' => $TEXT['organizer-page_confirmation-dialog-title-ok'], 
						'text' => $TEXT['organizer-page_confirmation-dialog-message-ok'] );
		else
			$response = array( 'title' => $TEXT['organizer-page_confirmation-dialog-title-no'], 
						'text' => $TEXT['organizer-page_confirmation-dialog-message-no'] );
		echo json_encode( $response );
	}
	else
		; // TODO: redirect to an error page
?>