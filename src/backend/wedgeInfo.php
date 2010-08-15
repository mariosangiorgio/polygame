<?php
	include_once("../inc/db_connect.php");
	session_start();
	
	$lang = $_SESSION['lang'];
	
	if( isSet( $_GET['id']))
	{
		$wedgeId = $_GET['id'];
		$query = "SELECT Title, Summary, Image FROM Wedges WHERE Language='$lang' AND `Wedge ID`=$wedgeId";

		$result = mysql_query( $query, $connection );
		$wedgeInfo = mysql_fetch_array( $result );
		
		echo $wedgeInfo['Title']."<br />".$wedgeInfo['Summary'];	
	}
?>