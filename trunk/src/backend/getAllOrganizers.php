<?php 
	session_start();
	include_once("../inc/db_connect.php");
	include_once("utils.php");
	
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
?>