<?php

session_start();

require("./database/databaseLogin.php");

/*
 * Getting the time informations in order to
 * redirect users to the right page
 */
$query 	=
	"SELECT *
	 FROM  `Game`
	 WHERE `Game ID` = '".$wedge['Game ID']."'";
$data	= mysql_query($query,$connection);
$game	= mysql_fetch_array($data);

$now	= time();

$pahseOneBeginning = strtotime($game['Starting time']);
$pahseTwoBeginning = $phaseOneBeginning +
					 $game['Length 1a'] * 60 +
					 $game['Length 1a'] * 60 +
					 $game['Length 1a'] * 60;
$phaseTwoEnd	   = $phaseTwoBeginning +
					 $gmae['Length 2'] * 60;

if($now >= $pahseOneBeginning and 
   $now <= $pahseTwoBeginning){
   header("Location: showWedgeInformation.php");
}
if($now >= $pahseTwoBeginning and 
   $now <= $pahseTwoEnd){
   header("Location: createPlan.php");
}
header("Location: results.php");

?>