<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
-->
</style><p align="center" class="Design">&nbsp;</p>
<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./businessLogic/databaseLogin.php");
	
	//Getting the possible teams
	$query		= "SELECT `GroupName`, `Phase`
				   FROM   `Game Groups`
				   WHERE  `GameID` = (SELECT `Game ID`
				   					  FROM   `Game`
				   					  WHERE	`Organizer ID` =
				   					         '".$_SESSION['username']."');";
	$data	 = mysql_query($query,$connection);
	$teamsPhaseOne = "<OPTION VALUE=\"0\">Single player";
	$teamsPhaseTwo = "<OPTION VALUE=\"0\">Single player";
	while($row = mysql_fetch_array($data)){
		if($row['Phase'] == 'One'){
			$teamsPhaseOne = $teamsPhaseOne . 
							"<OPTION VALUE=\"".$row['GroupName']."\">".$row['GroupName'];
		}
		if($row['Phase'] == 'Two'){
			$teamsPhaseTwo = $teamsPhaseTwo . 
							"<OPTION VALUE=\"".$row['GroupName']."\">".$row['GroupName'];
		}
	}
	
	$query = "SELECT `Player ID`
			  FROM	 `Game Players`
			  WHERE  `Game ID` =
			  			(SELECT `Game ID`
				         FROM `Game`
				         WHERE `Organizer ID` ='".$_SESSION['username']."')
				         and
			  		 `Player ID` NOT IN
			  		 	(SELECT `Player`
			  		 	 FROM `Groups`
			  		 	 WHERE `GameID` = `Game ID`)";
	$data = mysql_query($query,$connection);
	
	print "<FORM METHOD=\"POST\"
	             ACTION='./businessLogic/assignPlayersToGroups.php'>";
	print "<TABLE>";
	print "<TR><TD>Player</TD><TD>Phase One Team</TD><TD>Phase Two Team</TD></TR>";
	
	$counter =0;
	while($player = mysql_fetch_array($data)){
		print "<TR><TD>".$player['Player ID']."</TD><TD>";
		print "<SELECT ID=player".$counter.
		      " NAME=ONE".$player['Player ID'].">";
		print $teamsPhaseOne;
		print "</SELECT>";
		print "</TD><TD>";
		print "<SELECT ID=player".$counter.
		      " NAME=TWO".$player['Player ID'].">";
		print $teamsPhaseTwo;
		print "</SELECT>";
		print "</TD></TR>";
		$counter = $counter + 1;
	}
	print "</TABLE>";
	print "<input type=\"submit\" id=\"submitButton\" ></form>";

}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>