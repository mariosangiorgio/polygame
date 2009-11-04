<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "player"){
	require("./businessLogic/databaseLogin.php");
	
	//Loading wedge information
	if($_GET['wedgeID']){
		$wedgeID	= intval($_GET['wedgeID']);
		$query		=
		"SELECT *
		 FROM  `Posters`,`Game Players`
		 WHERE `Posters`.`Wedge ID` = ".$wedgeID." AND 
		 	   `Posters`.`Game ID`=`Game Players`.`Game ID` AND
		 	   `Game Players`.`Player`=".$_SESSION['username'];
		$data	= mysql_query($query,$connection);
		$poster	= mysql_fetch_array($data);
		print "<B>PROS</B><BR>";
		print $poster['PROS']."<BR>";
		print "<B>CONS</B><BR>";
		print $poster['CONS']."<BR>";
		print "<B>NOTES</B><BR>";
		print $poster['Notes']."<BR>";
		print "<A HREF=\"./\">BACK</A>";
	}
	else{
		return;
	}
}