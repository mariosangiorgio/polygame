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
	$teamsPhaseOne = "<OPTION VALUE=\"\">Single player";
	$teamsPhaseTwo = "<OPTION VALUE=\"\">Single player";
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
				         WHERE `Organizer ID` ='".$_SESSION['username']."')";
	$data = mysql_query($query,$connection);
	
	print "<FORM METHOD=\"POST\"
	             ACTION='./businessLogic/assignPlayersToGroups.php'>";
	print "<TABLE>";
	print "<TR><TD>Player</TD><TD>Phase One Team</TD><TD>Phase Two Team</TD><TD>Reset</TD></TR>";
	
	$counter =0;
	while($player = mysql_fetch_array($data)){
		$alreadyAssignedQuery = "SELECT `Player`, `GroupFirstPhase`, `GroupSecondPhase`
								 FROM	`Groups`
								 WHERE  `Player` ='".$player['Player ID']."' AND
								 		`GameID` = (SELECT `Game ID`
								 					FROM   `Game`
								 					WHERE	`Organizer ID` ='".$_SESSION['username']."');";
		$alreadyAssignedData = mysql_query($alreadyAssignedQuery,$connection);
		
		if($groups = mysql_fetch_array($alreadyAssignedData)){
			print "<TR><TD>".$player['Player ID']."</TD><TD>";
			print "<SELECT
					DISABLED = 'disabled'
					ID=player".$counter.
				  " NAME=ONE".$player['Player ID'].">";
			print str_replace("VALUE=\"".$groups['GroupFirstPhase']."\"","SELECTED VALUE=\"".$groups['GroupFirstPhase']."\"",$teamsPhaseOne);
			print "</SELECT>";
			print "</TD><TD>";
			print "<SELECT
						DISABLED = 'disabled'
						ID=player".$counter.
				  " NAME=TWO".$player['Player ID'].">";
			print str_replace("VALUE=\"".$groups['GroupSecondPhase']."\"","SELECTED VALUE=\"".$groups['GroupSecondPhase']."\"",$teamsPhaseTwo);
			print "</SELECT>";
			print "</TD><TD NAME=EDIT".$player['Player ID']."
						<A href=null
						   onclick='document.getElementsByName(\"ONE".$player['Player ID']."\")[0].disabled=false;".
						           "document.getElementsByName(\"TWO".$player['Player ID']."\")[0].disabled=false;".
						           "document.getElementsByName(\"EDIT".$player['Player ID']."\")[0].innerHTML=\"\";".
						           "return false'
						 >EDIT</A></TD></TR>";
		}
		else{
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
			print "</TD><TD></TD></TR>";
		}
		$counter = $counter + 1;
	}
	print "</TABLE>";
	print "<input type=\"submit\" id=\"submitButton\" ></form>";

	?>
	<div align="center" class="Design"><BR>
    <A HREF=organize.php class="three style1">Back to organizer page</A><BR>
</div>
	<?php

}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>
    </span></p>
</div>