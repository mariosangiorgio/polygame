<?php

$query1		= "SELECT `Player ID` FROM `Game Players`
              WHERE `Game ID` IN (SELECT `Game ID`
                                 FROM `Game`
                                 WHERE `Organizer ID` = '".
                                 $_SESSION['username']."' ) ;";
$players	= mysql_query($query1,$connection);
//print $query1;

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
		print "<TR><TD>".$row['Player ID']."</TD>";
		
		// Result column
		$query2		= "SELECT `Is correct`, `Result` FROM `Results`
		               WHERE `Player ID` = '".$row['Player ID']."';";
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
		               WHERE `Player` = '".$row['Player ID']."'
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
				$stringPoster = "Not final submission";
			}
		}

		print "<TD>".$stringPoster."</TD></TR>\n";		
		
	}
?>
</table><BR>
<A HREF=organize.php>Update table</A><BR>
