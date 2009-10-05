<?php
session_start();
require("./database/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$length1a	= mysql_real_escape_string($_POST['length1a']);
	$length1b	= mysql_real_escape_string($_POST['length1b']);
	$length1c	= mysql_real_escape_string($_POST['length1c']);
	$length2	= mysql_real_escape_string($_POST['length2']);
	
	$query = "DELETE FROM `Game` WHERE `Organizer ID` = '".$_SESSION['username']."';" ;
	$data		= mysql_query($query,$connection);
	
	//Automatic start: NOW() + 10800
	$query		= "INSERT INTO `Game` (`Organizer ID`,`Starting time`, 
				  `Length 1a`,`Length 1b`,`Length 1c`,`Length 2`)
				   VALUES ('".$_SESSION['username']."', '2999-12-12 11:11:11' ,".$length1a.
				   ", ".$length1b.", 
				   ".$length1c.", 
				   ".$length2." );";
	$data		= mysql_query($query,$connection);

	if ($data == 1) {
		header("Location: organize.php");
		$_SESSION['gamePhase'] = 1;
	}
	else {
		print "Please check the values!\n";
		print "<BR><A HREF=newGame.php>Back to insert</A><BR>"	;
	}
	
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
