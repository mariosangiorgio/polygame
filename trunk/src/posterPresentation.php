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
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color: #CCCCCC;
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
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
      <param name="movie" value="Flash/logostops.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
    </object>
  </p>
  <p>&nbsp;</p>
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
  </table>
  <BR>
  <A HREF=organize.php>Update table</A><BR>
</div>
<div align="center" class="Design"></div>
<div align="center" class="Design"></div>
