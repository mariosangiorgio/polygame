<?php 
	$db_host = "localhost";
	$db_username = "polygame";
	$db_password = "SanTri";
	$db = "polygame";
	
	$connection	= mysql_connect( $db_host, $db_username, $db_password );
	mysql_select_db( $db, $connection );
?>