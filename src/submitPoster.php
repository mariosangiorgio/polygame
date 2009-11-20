<?php
session_start();
?>
<head>
<style type="text/css" media="all">
	@import "css/info.css";
	@import "css/main.css";
	@import "css/widgEditor.css";
</style>
<script type="text/javascript" src="scripts/widgEditor.js"></script>
</head>
<?php

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
?>
<FORM action="./businessLogic/insertPoster.php" method="post">
	Pros<BR>
	<TEXTAREA class="widgEditor" name="Pros" rows="20" cols="80"></TEXTAREA>
	<BR>
	Cons<BR>
	<TEXTAREA class="widgEditor" name="Cons" rows="20" cols="80"></TEXTAREA>
	<BR>
	Notes<BR>
	<TEXTAREA class="widgEditor" name="Notes" rows="20" cols="80"></TEXTAREA>
	<BR>
	<INPUT type="Submit" value="Submit">
</FORM>

<br><br><a href="showWedgeInformation.php">Back to wedge</a>

