<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color: #CCCCCC;
}
a:active {
	text-decoration: none;
}
-->
</style><div align="center" class="Design"></div>
<div align="center" class="Design"></div>
<?php
session_start();
header("Location: showGamePlayers.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./businessLogic/databaseLogin.php");

	foreach($_POST['selectedUsers'] as $value)  {
		//print $value;
		$query = "DELETE FROM `Game Players` WHERE `Player ID` = '$value';" ;
		//print $query;
		mysql_query($query,$connection);	
		
		$query = "DELETE FROM `Groups` WHERE `Player` = '$value';" ;
		//print $query;
		mysql_query($query,$connection);		
	} 
	
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>