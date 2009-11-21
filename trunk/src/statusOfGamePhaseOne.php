<?php

$query = "SELECT DISTINCT `GroupFirstPhase` as `Group`
			FROM `Groups`
			WHERE `GameID` =  ( SELECT `Game ID`
			                    FROM   `Game`
					    WHERE  `Organizer ID` = '".$_SESSION['username']."' )
			      AND `GroupFirstPhase`<>'0'
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
				 AND `GroupFirstPhase`<>'0')
			ORDER BY `Group`";

$players		= mysql_query($query,$connection);

if( mysql_num_rows($players) == 0 ) {
	print "No players in this game<BR>";
	return;
}

?>

<table border=".1.">
<TR><TD>User</TD><TD>Solution</TD><TD>Poster</TD></TR>
<?php
	while( $row	= mysql_fetch_array($players))
	{
		// Username column
		print "<TR><TD>".$row['Group']."</TD>";
		
		// Result column
		$query2		= "SELECT `Is correct`, `Result` FROM `Results`
		               WHERE `ID` = '".$row['Group']."';";
        //print $query2;
		$result 	= mysql_query($query2,$connection);
		if(mysql_num_rows($result) == 0)
		{
			print "<TD>Not submitted</TD>";
		}
		else
		{
			$rowres 	= mysql_fetch_array($result);
			if( $rowres['Is correct'] == 1 )
			{
				$stringResult = "(Correct!)";
			}
			else
			{
				$stringResult = "(Wrong!)";
			}
			print "<TD>".$rowres['Result'].$stringResult."</TD>";	
		}
		
		// Poster column
		$query2		= "SELECT `Pros`, `Cons` FROM `Posters`
		               WHERE `Player` = '".$row['Group']."'
		               AND `Game ID` IN (SELECT `Game ID`
                                 FROM `Game`
                                 WHERE `Organizer ID` = '".
                                 $_SESSION['username']."' ) ;";
        //print $query2;
		$result 	= mysql_query($query2,$connection);
		if(mysql_num_rows($result) == 0 )
		{
			$stringPoster = "Not submitted";
		}
		else
		{
			$rowpos 	= mysql_fetch_array($result);
			$stringPoster = "Submitted";
			if( $rowpos['Pros']=="" or $rowpos['Cons']=="" )
			{
				$stringPoster = "Incomplete submission";
			}
		}

		print "<TD>".$stringPoster."</TD></TR>\n";		
		
	}
?>
</table><BR>
<A HREF=organize.php>Update table</A><BR>
