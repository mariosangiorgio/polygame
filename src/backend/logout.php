<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/utils.inc");
	include_once("../inc/init.inc");
	
	if( !$gData['logged'] )
		redirectTo('../errorPage.php');
	
	$query = "UPDATE `users` SET `Nonce`=NULL ".
			"WHERE `Username`='".$gData['username']."' ".
			"AND `Password`='".$gData['password']."';";
	mysql_query( $query, $connection );
	
	header("Location: ../index.php");
?>