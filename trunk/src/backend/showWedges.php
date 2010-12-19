<?php 
	include_once("../inc/db_connect.php");
	include_once("../inc/init.php");
	include_once("./utils.php");
	
	$query = "SELECT `Wedge ID` as id, Title, Summary, Image FROM Wedges WHERE Language='".$gData['lang']."';";
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
	
	$vector = generateRandomSequence( 0, $counter - 1 );
	
	$index = 0;
	$result = array();
	while( $counter > 0 )
	{
		$result['wedge'.$index] = $wedges[$vector[$index]];
		$index++;
		$counter--;
	}
	
	$result = json_encode( $result );
	echo $result;
?>