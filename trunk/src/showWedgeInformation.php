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
	require("./businessLogic/databaseLogin.php");
	
	//Loading wedge information
	if($_GET['wedgeID']){
		$wedgeID	= intval($_GET['wedgeID']);
		$query		=
		"SELECT *
		 FROM  `Wedges`
		 WHERE `Wedges`.`Wedge ID` = ".$wedgeID;
	}
	else{
		$query		=
		"SELECT *
		 FROM  `Wedges`, `Wedge Players`
		 WHERE `Wedges`.`Wedge ID` = `Wedge Players`.`Wedge ID`
		 	   and
		 	   `User ID` = '".$_SESSION['usernamePhaseOne']."'";
	}
	$data		= mysql_query($query,$connection);
	$wedge		= mysql_fetch_array($data);
	
	//Loading game information
	$query 	=
		"SELECT *
		 FROM  `Game`, `Game Players`
		 WHERE `Game`.`Game ID` = `Game Players`.`Game ID` and
			   `Game Players`.`Player ID` = '" .
				$_SESSION['username'] . "'";
	$data		= mysql_query($query,$connection);
	$game		= mysql_fetch_array($data);
	
	$now = time();
	
	$showAllInformationTime =
		strtotime($game['Starting time']) +
		$game['Length 1a'];
	
	$checkSolutionTime =
		$showAllInformationTime +
		$game['Length 1b'];
	
	$endPhase 		   =
		$checkSolutionTime +
		$game['Length 1c'];
	
	$_SESSION['checkSolutionTime']	= $checkSolutionTime;
	$_SESSION['endPhase'] 			= $endPhase;
	$_SESSION['wedgeID']			= $wedge['Wedge ID'];
	
	//Information always displayed
	print "<B>".$wedge['Title']."</B><BR>";
	print $wedge['Introduction']."<BR>";
	if( $now > $showAllInformationTime){
	    print "<B>HISTORY</B><BR>";
	    print $wedge['History']."<BR>";
	    print "<B>PRESENT USE</B><BR>";
		print $wedge['Present use']."<BR>";
		print "<B>NATIONAL SITUATION</B><BR>";
		print $wedge['National situation']."<BR>";	
		print "<B>EMISSION REDUCTION</B><BR>";
		print $wedge['Emission reduction']."<BR>";
		print "<B>REFERENCES</B><BR>";
		print $wedge['References']."<BR>";
		
		if($now > $checkSolutionTime){
			print "<A HREF=\"checkSolution.php\">Check solution</A>";
			print "<BR>";
		}
		if($now > $checkSolutionTime and
		   $now < $endPhase){
		   /*
		    * If there isn't any poster players can submit it,
		    * otherwise they are able to modify it.
		    */
		   if(!$_SESSION['posterSubmitted']){
		   	print "<A HREF=\"submitPoster.php\">Submit your poster</A>";
		   }
		   else{
		    print "<A HREF=\"editPoster.php\">Edit your poster</A>";
		   }
		}
	}
}
else
{
	print "You should be logged in as an user to view this page";
}
?>