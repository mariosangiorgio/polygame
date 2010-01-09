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
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
	color: #DD137B;
}
-->
</style>
<div align="center" class="Design">
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  
  <p class="Design"><BR>
    <b class="three style1">Rules</b><BR>
Polygame is a game which...<BR>
It is made of two phases: in the first one every user is assigned to a certain wedge which must be studied in order to summarize in a poster all the pros and cons.<br>
In the second one the users have to come up with the best mix of wedges to reduce CO2.<br>
Plans are voted and the best one is then shown at the end of the game.<br />
20 Wedges below make the possible mix of achieving the Kyoto Protocol 2012. <br />
<br />
<img src="images/icons.png" alt="Wedges" width="672" height="762" /><BR>
<BR>

<?php
if($_SESSION['loggedIn']) {
print "<b>Players</b>";

$query = "SELECT `GroupFirstPhase` as `Group`, `Player`
			FROM `Groups`
			WHERE `GameID` =  ( SELECT `Game ID`
			                    FROM   `Game`
					    WHERE  `Organizer ID` = '".$_SESSION['username']."' )
			      AND `GroupFirstPhase`<>'0'
			UNION
			SELECT '-' as `Group`, `Player ID` as `Player`
			FROM `Game Players`
			WHERE `Game ID` =  ( SELECT `Game ID`
					     FROM   `Game`
			                     WHERE	`Organizer ID` ='".$_SESSION['username']."' )
			      AND `Player ID` NOT IN (SELECT `Player`
						      FROM `Groups`
						      WHERE `GameID` =  ( SELECT `Game ID`
									   FROM   `Game`
									   WHERE  `Organizer ID` =
									   '".$_SESSION['username']."'
									 )
								 AND `GroupFirstPhase`<>'0')";
$data		= mysql_query($query,$connection);
								 
$query2 = "SELECT `GroupSecondPhase` as `Group`, `Player`
			FROM `Groups`
			WHERE `GameID` =  ( SELECT `Game ID`
			                    FROM   `Game`
					    WHERE  `Organizer ID` = '".$_SESSION['username']."' )
			      AND `GroupSecondPhase`<>'0'
			UNION
			SELECT '-' as `Group`, `Player ID` as `Player`
			FROM `Game Players`
			WHERE `Game ID` =  ( SELECT `Game ID`
					     FROM   `Game`
			                     WHERE	`Organizer ID` ='".$_SESSION['username']."' )
			      AND `Player ID` NOT IN (SELECT `Player`
						      FROM `Groups`
						      WHERE `GameID` =  ( SELECT `Game ID`
									   FROM   `Game`
									   WHERE  `Organizer ID` =
									   '".$_SESSION['username']."'
									 )
					 AND `GroupSecondPhase`<>'0')";
$data2		= mysql_query($query2,$connection);					 

//	$query		= "SELECT `GroupFirstPhase`, `Player` FROM `Groups`
//	              WHERE `GameID` IN (SELECT `Game ID`
//	                                 FROM `Game`
//	                                 WHERE `Organizer ID` = '".
//	                                 $_SESSION['username']
//	                                 ."' ) order by `GroupFirstPhase`;";
//	$data		= mysql_query($query,$connection);
//	//print $query;
//	
//	$query2		= "SELECT `GroupSecondPhase`, `Player` FROM `Groups`
//	              WHERE `GameID` IN (SELECT `Game ID`
//	                                 FROM `Game`
//	                                 WHERE `Organizer ID` = '".
//	                                 $_SESSION['username']
//	                                 ."' ) order by `GroupSecondPhase`;";
//	$data2		= mysql_query($query2,$connection);
	//print $query2;
	
?>
	<BR>
	<b class="style1">Phase 1</b><BR>
  </p>
  <table border=".1.">
	<?php
	if( mysql_num_rows($data)==0 ) print "No players selected";
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD>".$row['Group']."</TD><TD>".$row['Player']."</TD></TR>\n";
	}
	?>
	</table>
  <span class="Design"><BR>
	
  <b class="style1">Phase 2</b><BR>
  </span>
  <table border=".1.">
	<?php
	if( mysql_num_rows($data2)==0 ) print "No players selected";
	while( $row	= mysql_fetch_array($data2)){
		print "<TR><TD>".$row['Group']."</TD><TD>".$row['Player']."</TD></TR>\n";
	}
	?>
	</table>
  <span class="Design"><BR>
  <?php
}
	print "<BR><BR><b>Wedges association</b><BR>";
	
	// Extract all game wedges
$query1		= "SELECT `Wedge ID`, `User ID` FROM `Wedge Players`
              WHERE `Game ID` IN (SELECT `Game ID`
                                 FROM `Game`
                                 WHERE `Organizer ID` = '".
                                 $_SESSION['username']."' ) ;";
$wedges 	= mysql_query($query1,$connection);
//print $query1;

if( mysql_num_rows($wedges) == 0 ) {
	print "No wedges in this game<BR>";
}
else
{

?>
  </span>
  <table border=".1.">
  <TR><TD class="style1">Team name</TD><TD class="style1">Assigned wedge</TD></TR>
  <?php
	while( $row	= mysql_fetch_array($wedges))
	{
		// Username column
		print "<TR><TD>".$row['User ID']."</TD>";
		
		// Extract wedge name
		$query2		= "SELECT `Title` FROM `Wedges`
              WHERE `Wedge ID` = ".$row['Wedge ID']." ;";
        //print $query2;
		$qtitle	= mysql_query($query2,$connection);
		$title	= mysql_fetch_array($qtitle);
		
		// Link column
		print "<TD>".$title['Title']."</TD>";	
		
	}
?>
    </table>
  <p class="Design"><BR>
    
    <?php
}
	?>
  </p>
</div>
<div align="center" class="Design"></div>
