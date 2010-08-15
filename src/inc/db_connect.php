<?php 
	$db_host = "localhost";
	$db_username = "ciku";
	$db_password = "cikuitr3ti";
	$db = "polygame";
	
	$connection	= mysql_connect( $db_host, $db_username, $db_password );
	mysql_select_db( $db, $connection );
?>