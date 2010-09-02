<?php 
	session_start();
	
	include_once("../inc/db_connect.php");
	include_once("utils.php");
	
	if(!checkAuthorization("administrator")){
		return;
	}
	
	if( isSet( $_GET['operation']))
	{
		$operation = $_GET['operation'];
		switch($operation){
			case 'getAllOrganizers':
				getAllOrganizers();
				break;
			case 'deleteOrganizer':
				if( isSet( $_GET['username'])){
					$username = $_GET['username'];
					deleteOrganizer($username);
				}
				break;
		}
	}

// Implementation of the functions

function getAllOrganizers(){
	global $connection;
	$query = "SELECT `username` FROM `Users` WHERE `role`='organizer'";
	
	$result = mysql_query( $query, $connection );
	
	$counter = 0;
	while( $row = mysql_fetch_array( $result ))
	{
		$organizers[$counter] = array('name' => $row['username']);
		$counter++;
	}
	
	$index = 0;
	$result = array();
	while( $index < $counter )
	{
		$result[] = $organizers[$index];
		$index++;
	}
	
	$result = json_encode( $result );
	echo $result;
}

function deleteOrganizer($username){
	global $connection;
	$username = mysql_real_escape_string($username);
	
	$query = "DELETE FROM `Users` WHERE `username`='$username'";
	$result = mysql_query( $query, $connection );
}

?>