<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:hover {
	color: #CCCCCC;
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
<div align="center" class="Design">
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
      <param name="movie" value="Flash/logostops.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
    </object>
  </p>
  <p class="Design"><BR>
    <b>Rules</b><BR>
Polygame is a game which...<BR>
It is made of two phases: in the first one every user is assigned to a certain wedge which must be studied in order to summarize in a poster all the pros and cons.<br>
In the second one the users have to come up with the best mix of wedges to reduce CO2.<br>
Plans are voted and the best one is then shown at the end of the game.
<BR>
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
	<b>Phase 1</b><BR>
  
  </p>
  <table border=".1.">
	<?php
	if( mysql_num_rows($data)==0 ) print "No players selected";
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD>".$row['Group']."</TD><TD>".$row['Player']."</TD></TR>\n";
	}
	?>
	</table>
  <BR>
	
  <b>Phase 2</b><BR>
  
  <table border=".1.">
	<?php
	if( mysql_num_rows($data2)==0 ) print "No players selected";
	while( $row	= mysql_fetch_array($data2)){
		print "<TR><TD>".$row['Group']."</TD><TD>".$row['Player']."</TD></TR>\n";
	}
	?>
	</table>
  <BR>
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
  
  <table border=".1.">
  <TR><TD class="Design">Team name</TD><TD class="Design">Assigned wedge</TD></TR>
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
  <BR>

  <?php
}
	?>
  </div>
<div align="center" class="Design"></div>