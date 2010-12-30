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
			case 'submitWedge':
				submitWedge();
				break;
		}
	}

// Implementation of the functions



?>