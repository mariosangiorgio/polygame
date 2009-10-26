<?php

session_start();

require("./businessLogic/databaseLogin.php");

/*
 * Getting the time informations in order to
 * redirect users to the right page
 */

$query 	=
	"SELECT *
	 FROM  `Game`, `Game Players`
	 WHERE `Game`.`Game ID` = `Game Players`.`Game ID` and
	 	   `Game Players`.`Player ID` = '" .
	 	    $_SESSION['username'] . "'";
$data	= mysql_query($query,$connection);
$game	= mysql_fetch_array($data);

$now	= time();

$phaseOneBeginning = strtotime($game['Starting time']);
$phaseTwoBeginning = $phaseOneBeginning +
					 $game['Length 1a'] * 60 +
					 $game['Length 1b'] * 60 +
					 $game['Length 1c'] * 60;
$phaseTwoEnd	   = $phaseTwoBeginning +
					 $game['Length 2'] * 60;
/*
print $now;
print "<BR>";
print $phaseOneBeginning;
print"<BR>";
print $phaseTwoBeginning;
print"<BR>";
print $phaseTwoEnd;
print"<BR>";
*/

if($game['Started']){
	if($now >= $phaseOneBeginning and 
	   $now <  $phaseTwoBeginning){
	   header("Location: showWedgeInformation.php");
	   return;
	}
	if($now >= $phaseTwoBeginning and
	   $now <= $phaseTwoEnd){
	   header("Location: createPlan.php");
	   return;
	}
	header("Location: results.php");
	return;
}
else{
	header("Location: waitPage.php");
	return;
}

print "ERROR";
?>