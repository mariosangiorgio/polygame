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

$now = time();

$phaseOneStarted = $game['Started'];
$phaseTwoStarted = $game['Started Phase 2'];

$phaseOneBeginning = strtotime($game['Starting time']);
$phaseTwoBeginning = $phaseOneBeginning +
					 $game['Length 1a'] * 60 +
					 $game['Length 1b'] * 60 +
					 $game['Length 1c'] * 60;
$phaseTwoEnd	   = $phaseTwoBeginning +
					 $game['Length 2'] * 60;

if($game['Started']){
	//Getting the userID for the two phases
	$query 	= "SELECT `GroupFirstPhase`, `GroupSecondPhase`
			   FROM   `Groups`
			   WHERE  `Player` = '".$_SESSION['username']."'";
	$data	= mysql_query($query,$connection);
	
	if( $game	= mysql_fetch_array($data) ){
		if($game['GroupFirstPhase'] != '0'){
			$_SESSION['usernamePhaseOne'] = $game['GroupFirstPhase'];
		}
		else{
			$_SESSION['usernamePhaseOne'] = $_SESSION['username'];			
		}
		if($game['GroupSecondPhase'] != '0'){
			$_SESSION['usernamePhaseTwo'] = $game['GroupSecondPhase'];
		}
		else{
			$_SESSION['usernamePhaseTwo'] = $_SESSION['username'];			
		}

	}
	else{
		$_SESSION['usernamePhaseOne'] = $_SESSION['username'];
		$_SESSION['usernamePhaseTwo'] = $_SESSION['username'];
	}
	if($phaseOneStarted and !$phaseTwoStarted and
		$now <  $phaseTwoBeginning){
		header("Location: showWedgeInformation.php");
		return;
	}
	if($phaseOneStarted and $phaseTwoStarted and
	   $now <  $phaseTwoEnd){
		header("Location: createPlan.php");
		return;
	}
}
else{
	header("Location: waitPage.php");
	return;
}

print "An error occurred, please logout and then login again.<BR>";
print "<A HREF='./logout.php'>Logout</A>";
?>