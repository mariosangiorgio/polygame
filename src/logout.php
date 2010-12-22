<?php
	include_once("./inc/db_connect.php");
	include_once("./inc/init.php");
	
	$query = "UPDATE `users` SET `nonce`=NULL ".
			"WHERE `username`='".$gData['username']."' AND `password`='".$gData['password']."';";
	mysql_query( $query, $connection );
	
	header("Location: index.php");
?>