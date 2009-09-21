<?php
session_start();
require("./database/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
	
	$query		= "SELECT `Title` FROM `Wedges`;";
	$data		= mysql_query($query,$connection);
	
	while( $row	= mysql_fetch_array($data)){
		print "<A HREF=editWedge.php?wedge=".$row['Title'].">".$row['Title']."</A><BR>";
	}
	
}
else {
	print "You must log in as an administrator to access this page!";
}
?>