<?php

$query1		= "SELECT DISTINCT `GroupSecondPhase` as `Group`
			FROM `Groups`
			WHERE `GameID` =  ( SELECT `Game ID`
			                    FROM   `Game`
					    WHERE  `Organizer ID` = '".$_SESSION['username']."' )
			      AND `GroupSecondPhase`<>'0'
			UNION
			SELECT `Player ID` as `Group`
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
				 AND `GroupSecondPhase`<>'0')
			ORDER BY `Group`";
			
$players	= mysql_query($query1,$connection);
//print $query1;

if( mysql_num_rows($players) == 0 ) {
	print "No players in this game<BR>";
	return;
}

?>

<table border=".1.">
<TR><TD>User</TD><TD>Wedge selection</TD></TR>
<?php
	while( $row	= mysql_fetch_array($players))
	{
		// Username column
		print "<TR><TD>".$row['Group']."</TD>";
		
		// Result column
		$query2		= "SELECT `Wedge count` FROM `Plans`
		               WHERE `Player ID` = '".$row['Group']."';";
        //print $query2;
		$result 	= mysql_query($query2,$connection);
		if(mysql_num_rows($result) == 0)
		{
			print "<TD>Not submitted</TD>";
		}
		else
		{
			print "<TD>Submitted</TD></TR>";	
		}
		
	}
?>
</table><BR>
<A HREF=organize.php>Update table</A><BR>
