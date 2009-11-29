<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
p
{
	background-image: url(images/background.png);
	background-position: right bottom;
	background-repeat: repeat;
	background-attachment: fixed;
}
a.three:link {color: #DD137B}
a.three:visited {color: #DD137B}
a.three:hover {background: #DD137B}
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<div align="center" class="Design"></div>
<div align="center" class="Design">
  <?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./businessLogic/databaseLogin.php");
	
	$_SESSION['gamePhase'] = 0;

	// Delete from Game Players
	$query = "DELETE FROM `Game Players` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);
	
	// Delete from Game Wedges
	$query = "DELETE FROM `Game Wedges` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);
	
	// Delete Results
	$query = "DELETE FROM `Results` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);
	//print $query;	
	
	// Delete Posters
	$query = "DELETE FROM `Posters` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);		
	//print $query;
	
	// Delete Plans
	$query = "DELETE FROM `Plans` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);	
	//print $query;
	
	// Delete Groups
	$query = "DELETE FROM `Groups` WHERE `GameID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);	
	//print $query;
	
	// Delete Groups
	$query = "DELETE FROM `Game Groups` WHERE `GameID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);	
	
	// Delete Wedge Players
	$query = "DELETE FROM `Wedge Players` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);
	//print $query;	
	
	// Delete Votes
	$query = "DELETE FROM `Votes` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);	
	//print $query;		
	
	// Delete Voters
	$query = "DELETE FROM `Game Voters` WHERE `Game ID` = 
			  ( SELECT `Game ID` FROM `Game` WHERE `Organizer ID` =
			  '". $_SESSION['username']."' );" ;
	mysql_query($query,$connection);
	
	// Delete from Game
	$query = "DELETE FROM `Game` WHERE `Organizer ID` = '".$_SESSION['username']."';" ;
	mysql_query($query,$connection);
		
	header("Location: organize.php");
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>
</div>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
