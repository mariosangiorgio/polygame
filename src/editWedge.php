<?php
session_start();
require("./database/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
	
	$wedge	= mysql_real_escape_string($_GET['wedge']);
	$query	= "SELECT * FROM `Wedges` WHERE `Title` = '".$wedge."';";
	$data	= mysql_query($query,$connection);
	$row	= mysql_fetch_array($data);
	
	print "<TABLE>";
	print "<TR><TD>Title</TD><TD>".$row['Title']."</TD></TR>";
	print "<TR><TD>Introduction</TD><TD>".$row['Introduction']."</TD></TR>";
	print "<TR><TD>History</TD><TD>".$row['History']."</TD></TR>";
	print "<TR><TD>Present use</TD><TD>".$row['Present use']."</TD></TR>";
	print "<TR><TD>National situation</TD><TD>".$row['National situation']."</TD></TR>";
	print "<TR><TD>Emission reduction</TD><TD>".$row['Emission reduction']."</TD></TR>";
	print "<TR><TD>Pros</TD><TD>".$row['Pros']."</TD></TR>";
	print "<TR><TD>Cons</TD><TD>".$row['Cons']."</TD></TR>";
	print "<TR><TD>references</TD><TD>".$row['References']."</TD></TR>";
	print	"</TABLE>";
}	
else {
	print "You must log in as an administrator to access this page!";
}
?>