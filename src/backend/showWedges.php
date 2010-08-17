<?php 
	session_start();
	include_once("../inc/db_connect.php");
	
	$counter = 0;
	$lang = $_SESSION['lang'];
	$query = "SELECT `Wedge ID` as id, Title, Summary, Image FROM Wedges WHERE Language='$lang' ORDER BY Preferences DESC";
	
	$result = mysql_query( $query, $connection );
	while( $row = mysql_fetch_array( $result ))
	{
		$wedges['wedge'.$counter] = array(  'id' 		=> $row['id'],
											'title' 	=> $row['Title'],
											'summary' 	=> $row['Summary'],
											'image' 	=> $row['Image'] );
		$counter++;
	}
	
	$result = json_encode( $wedges );
	echo $result;
?>