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
<link href="Design.css" rel="stylesheet" type="text/css" />
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

<div align="center" class="Design">
  <p>&nbsp;  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <span class="Design">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
      <param name="movie" value="Flash/logostops.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
    </object>
    </span></p>
  <p>&nbsp;</p>
  <table border=".1.">
    <TR><TD class="Design">User</TD><TD class="Design">Solution</TD><TD class="Design">Poster</TD></TR>
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
  </table>
  <span class="Design"><BR>
  <A HREF=organize.php>Update table</A><BR>
  </span></div>
<div align="center" class="Design"></div>