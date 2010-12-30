<?php
include_once("../inc/db_connect.php");
if( isSet( $_GET['address']) and isSet( $_GET['what'])){
	$address = mysql_real_escape_string($_GET['address']);
	$what	 = mysql_real_escape_string($_GET['what']);
	
	if($what == 'beta'){
		$what = 1;
	}
	else{
		$what = 0;
	}
	
	$query	 = "INSERT INTO `Subscriptions` (email,beta) VALUES('$address',$what)";
	echo $query;
	$result	 = mysql_query( $query, $connection );
}
?>