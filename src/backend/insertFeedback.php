<?php 
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('organizer', 1 );
	
	if( !isSet( $_POST['feedback']))
		redirectTo('../errorPage.php');
	
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
?>