<?php 
	session_start();
	include_once("../inc/db_connect.php");
	include_once("utils.php");
	
	$query = "SELECT min(`Wedge ID`) as min, max(`Wedge ID`) as max FROM `Wedges`";
	$result = mysql_query( $query, $connection );
	$wedgeIdLimit = mysql_fetch_array( $result );
	
	$vector = generateRandomSequence( $wedgeIdLimit['min'], $wedgeIdLimit['max'] );
	$lang = $_SESSION['lang'];	
	
	$query = "SELECT `Wedge ID` as id, Title, Summary, Image FROM Wedges WHERE Language='$lang'";
	$result = mysql_query( $query, $connection );
	
	$counter = 0;
	while( $row = mysql_fetch_array( $result ))
	{
		$wedges[$counter] = array(  'id' 		=> $row['id'],
									'title' 	=> $row['Title'],
									'summary' 	=> $row['Summary'],
									'image' 	=> $row['Image'] );
		$counter++;
	}
	
	$index = 0;
	$result = array();
	while( $counter > 0 )
	{
		$result['wedge'.$index] = $wedges[$vector[$index]-1];
		$index++;
		$counter--;
	}
	
	$result = json_encode( $result );
	echo $result;
?>