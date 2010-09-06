<?php 
	session_start();
	
	include_once("../inc/db_connect.php");
	include_once("utils.php");
	
	if(!checkAuthorization("organizer")){
		return;
	}
	
	if( isSet( $_GET['operation']))
	{
		$operation = $_GET['operation'];
		switch($operation){
			case 'submitFeedback':
				if(isSet( $_GET['feedback'])){
					$feedback	= $_GET['feedback'];
					submitFeedback($feedback);
				}
				break;
		}
	}

// Implementation of the functions
function submitFeedback($feedback){
	global $connection;
	$author	  = $_SESSION['username'];
	$feedback = mysql_real_escape_string($feedback);
	
	$query = "INSERT INTO `Feedbacks` (`author`,`feedback`) VALUES ('$author','$feedback')";
	$result = mysql_query( $query, $connection );
	}
	
?>