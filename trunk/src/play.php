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
a:hover {
	text-decoration: none;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="Design.css" rel="stylesheet" type="text/css" />
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<div align="center" class="Design"></div>
<div align="center" class="Design">
  <p class="Design">
    <span class="Design">
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

print "ERROR";
?>
    </span></p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
</div>
