<?php
session_start();
?>
<HEAD>
<meta http-equiv="Refresh" content="60; url=showWedgeInformation.php">
</HEAD>
<?php
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "player"){
	require("./database/databaseLogin.php");
	
	//Loading wedge information
	$query		=
		"SELECT *
		 FROM  `Wedges`, `Wedge Players`
		 WHERE `Wedges`.`Wedge ID` = `Wedge Players`.`Wedge ID`
		 	   and
		 	   `User ID` = '".$_SESSION['username']."'";
	$data		= mysql_query($query,$connection);
	$wedge		= mysql_fetch_array($data);
	
	//Loading game information
	$query		=
		"SELECT *
		 FROM  `Game`
		 WHERE `Game ID` = '".$wedge['Game ID']."'";
	$data		= mysql_query($query,$connection);
	$game		= mysql_fetch_array($data);
	
	$now = time();
	$showAllInformationTime =
		strtotime($game['Starting time']) +
		$game['Length 1a'] * 60;
	$checkSolutionTime = $showAllInformationTime + $game['Length 1b'] * 60;
	$endPhase = $checkSolutionTime + $game['Length 1c'] * 60;
	
	
	//Information always displayed
	print $wedge['Title']."<BR>";
	print $wedge['Introduction']."<BR>";
	if( $now > $showAllInformationTime){
		print $wedge['History']."<BR>";
		print $wedge['Present use']."<BR>";
		print $wedge['National situation']."<BR>";	
		print $wedge['Emission reduction']."<BR>";
		print $wedge['Pros']."<BR>";
		print $wedge['Cons']."<BR>";
		print $wedge['References']."<BR>";
		
		if($now > $checkSolutionTime){
			print "<A HREF=\"checkSolution.php\">Check solution</A>";
		}
		if($now > $checkSolutionTime and
		   $now < $phaseEnd){
			print "<A HREF=\"submitPoster.php\">Submit your poster</A>";
		}
	}
}
else
{
	print "You should be logged in as an user to view this page";
}
?>