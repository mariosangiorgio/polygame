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
<TR><TD>User</TD><TD>Wedge selection</TD></TR>
<?php
	while( $row	= mysql_fetch_array($players))
	{
		// Username column
		print "<TR><TD>".$row['Player ID']."</TD>";
		
		// Result column
		$query2		= "SELECT `Wedge count` FROM `Plans`
		               WHERE `Player ID` = '".$row['Player ID']."';";
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
