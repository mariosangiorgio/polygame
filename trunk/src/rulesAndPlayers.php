<BR><b>Rules</b><BR>
Polygame is a game which...<BR>
It is made of two phases: in the first one every user is assigned to a certain wedge which must be studied in order to summarize in a poster all the pros and cons.<br>
In the second one the users have to come up with the best mix of wedges to reduce CO2.<br>
Plans are voted and the best one is then shown at the end of the game.
<BR><BR>

<?php
if($_SESSION['loggedIn']) {
print "<b>Players</b>";


	$query		= "SELECT `GroupFirstPhase`, `Player` FROM `Groups`
	              WHERE `GameID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) order by `GroupFirstPhase`;";
	$data		= mysql_query($query,$connection);
	//print $query;
	
	$query2		= "SELECT `GroupSecondPhase`, `Player` FROM `Groups`
	              WHERE `GameID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) order by `GroupSecondPhase`;";
	$data2		= mysql_query($query2,$connection);
	//print $query2;
	
?>
	<BR><b>Phase 1</b><BR>
	<table border=".1.">
	<?php
	if( mysql_num_rows($data)==0 ) print "No players selected";
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD>".$row['GroupFirstPhase']."</TD><TD>".$row['Player']."</TD></TR>\n";
	}
	?>
	</table><BR>
	
	<BR><BR><b>Phase 2</b><BR>
	<table border=".1.">
	<?php
	if( mysql_num_rows($data2)==0 ) print "No players selected";
	while( $row	= mysql_fetch_array($data2)){
		print "<TR><TD>".$row['GroupSecondPhase']."</TD><TD>".$row['Player']."</TD></TR>\n";
	}
	?>
	</table><BR>
<?php
}	
	?>
