<?php
session_start();
require("./databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$length1a	= mysql_real_escape_string($_POST['length1a']) * 60;
	$length1b	= mysql_real_escape_string($_POST['length1b']) * 60;
	$length1c	= mysql_real_escape_string($_POST['length1c']) * 60;
	$length2	= mysql_real_escape_string($_POST['length2']) * 60;
	
	if( $length1a < 0 or $length1b < 0 or $length1c < 0 or $length2 < 0 )
	{
		print "Please check the values!\n";
		print "<BR><A HREF=../newGame.php>Back to insert</A><BR>"	;
	}
	else {	
		$query = "DELETE FROM `Game` WHERE `Organizer ID` = '".$_SESSION['username']."';" ;
		$data		= mysql_query($query,$connection);
		
		$query		= "INSERT INTO `Game` (`Organizer ID`,`Starting time`, 
					  `Length 1a`,`Length 1b`,`Length 1c`,`Length 2`, `Starting time Phase 2`)
					   VALUES ('".$_SESSION['username']."', '2999-12-12 11:11:11' ,".$length1a.
					   ", ".$length1b.", 
					   ".$length1c.", 
					   ".$length2.",
					   '2999-12-12 11:11:11' );";
		$data		= mysql_query($query,$connection);
		
		header("Location: ../organize.php");
	}

	
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
