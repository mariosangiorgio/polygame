<?php
session_start();
require("./database/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
	
	$wedge		= mysql_real_escape_string($_GET['wedge']);
	
	$query		= "SELECT * FROM `Wedges` WHERE `Title` = '".$wedge.";";
	$data		= mysql_query($query,$connection);
	
	$row	= mysql_fetch_array($data, MYSQL_BOTH);
	
	print	"<TABLE>";
	for($i=0;$i<9;$i++){
		print "<TR><TD>".$row[i]."</TD></TR>";
	}
	print	"</TABLE>";
}	
else {
	print "You must log in as an administrator to access this page!";
}
?>