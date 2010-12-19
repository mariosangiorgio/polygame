<?php
	include_once("./inc/db_connect.php");
	include_once("./inc/init.php");
	
	$query = "UPDATE `users` SET `token`=NULL WHERE `username`='".$gData['username']."';";
	mysql_query( $query, $connection );
	
	header("Location: index.php");
?>