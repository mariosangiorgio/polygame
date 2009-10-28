<?php

session_start();

$now = time();
$checkSolutionTime = $_SESSION['checkSolutionTime'];
$endPhase = $_SESSION['endPhase'];

if(
	//The user has the right to access this page
	$_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "player" and
	//It is the right time to access this page
	$now > $checkSolutionTime and
	$now < $endPhase
	){
	print "Poster:<BR>";
}
//Retreiving the existing poster from the database
require("./businessLogic/databaseLogin.php");

$query 	= 
	"SELECT *
	 FROM `Posters`
	 WHERE `Player`='".$_SESSION['username']."' and 
	 	   `Game ID` = (SELECT `Game ID`
	 	   				FROM `Game Players`
	 	   				WHERE `Player ID` ='".$_SESSION['username']."')
	 	   			and
	 	   `Wedge ID`='".$_SESSION['wedgeID']."';";
$data	= mysql_query($query,$connection);
$poster = mysql_fetch_array($data);
?>
<FORM action="./businessLogic/updatePoster.php" method="post">
	Pros<BR>
	<TEXTAREA name="Pros" rows="20" cols="80"><?php print $poster['Pros']; ?></TEXTAREA>
	<BR>
	Cons<BR>
	<TEXTAREA name="Cons" rows="20" cols="80"><?php print $poster['Cons']; ?></TEXTAREA>
	<BR>
	Notes<BR>
	<TEXTAREA name="Notes" rows="20" cols="80"><?php print $poster['Notes']; ?></TEXTAREA>
	<BR>
	<INPUT type="Submit" value="Submit">
	<INPUT type="reset">
</FORM>
