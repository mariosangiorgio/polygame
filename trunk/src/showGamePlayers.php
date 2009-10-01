<?php
session_start();
require("./database/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$query		= "SELECT `Player ID` FROM `Game Players`
	              WHERE `Game ID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) ;";
	$data		= mysql_query($query,$connection);
	
	while( $row	= mysql_fetch_array($data)){
		print $row['Player ID']."<BR>";
	}
	
}
else {
	print "You must log in as an administrator to access this page!";
}
?>

<BR><A HREF=organize.php>Back to organize page</A><BR>