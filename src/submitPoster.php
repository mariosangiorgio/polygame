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
?>
<FORM action="insertPoster.php" method="post">
	Pros
	<TEXTAREA name="Pros" rows="20" cols="80"></TEXTAREA>
	<TEXTAREA name="Cons" rows="20" cols="80"></TEXTAREA>
	<TEXTAREA name="Notes" rows="20" cols="80"></TEXTAREA>
	<INPUT type="Submit" value="Submit"><INPUT type="reset">
</FORM>
