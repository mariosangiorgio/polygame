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
<link href="Design.css" rel="stylesheet" type="text/css" />
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
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>

<link href="css/Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
-->
</style>
<div align="center" class="Design">
 
  <table border=".1.">
    <TR><TD class="Design">User</TD><TD class="Design">Short-term wedge mix</TD><TD class="Design">Long-term wedge mix</TD></TR>
    <?php
	while( $row	= mysql_fetch_array($players))
	{
		// Username column
		print "<TR><TD>".$row['Group']."</TD>";
		
		// Result column
		$query_short	= "SELECT `Wedge count` FROM `Plans`
		               WHERE `Player ID` = '".$row['Group']."'
		               AND `Term` = 'shortTerm';";
		$result_short 	= mysql_query($query_short,$connection);
		
		$query_long		= "SELECT `Wedge count` FROM `Plans`
		               WHERE `Player ID` = '".$row['Group']."'
		               AND `Term` = 'longTerm';";
        $result_long 	= mysql_query($query_long,$connection);
        
        /*print $query_short."<BR>";
        print $query_long."<BR>";
		
        print $result_short."<BR>";
        print $result_long."<BR>";	
        print mysql_num_rows($result_short)."<BR>";
        print mysql_num_rows($result_long)."<BR>";*/
        
		if(mysql_num_rows($result_short) == 0)
		{
			print "<TD>Not submitted</TD>";
		}
		else
		{
			print "<TD>Submitted</TD>";	
		}
		
		if(mysql_num_rows($result_long) == 0)
		{
			print "<TD>Not submitted</TD>";
		}
		else
		{
			print "<TD>Submitted</TD>";	
		}
		print "</TR>";
		
	}
?>
  </table>
  <BR>
  <A HREF=organize.php class="three style1">Update table</A><BR>
  </div>
<div align="center" class="Design"></div>
<div align="center" class="Design">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
