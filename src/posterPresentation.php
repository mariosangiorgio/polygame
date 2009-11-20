<?php

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
	return;
}

?>

<table border=".1.">
<TR><TD>Team name</TD><TD>Assigned wedge</TD></TR>
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
		print "<TD><A HREF=\"./showPoster.php?wedgeID=".$row['Wedge ID']."\">".$title['Title']."</A></TD>";	
		
	}
?>
</table><BR>
<A HREF=organize.php>Update table</A><BR>
