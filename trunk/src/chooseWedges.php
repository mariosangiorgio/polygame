<?php
session_start();
require("./businessLogic/databaseLogin.php");

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
<FORM METHOD="POST" ACTION="./businessLogic/chooseGameWedges.php">
  <div align="center">
    <p class="Design">&nbsp;    </p>
    <p class="Design">&nbsp;</p>
    <p class="Design">&nbsp;</p>
    <p class="Design">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
        <param name="movie" value="Flash/dots.swf" />
        <param name="quality" value="high" />
        <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
      </object>
    </p>
    <p class="Design">
      <?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	?>    Choose wedges |
      <A HREF="./assignWedges.php">Assign wedges to users</A>
      <BR>
      <BR>
      
      <?php
	
	print "Choose wedges you want to be part of this game.<BR>";
	
	$query		= "SELECT `Wedge ID`, `Title`
				   FROM   `Wedges`
				   WHERE  `Wedge ID` NOT IN ( SELECT `Wedge ID`
				   							  FROM   `Game Wedges`
				   							  WHERE  `Game ID` = 
				   							  	(SELECT `Game ID`
				   							  	 FROM   `Game`
				   							  	 WHERE	`Organizer ID` = '".$_SESSION['username']."')
				   							  );";
	$data		= mysql_query($query,$connection);
	?>
    </p>
    <table border=".1.">
	  <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedWedges[]\" value=\"".$row['Wedge ID']."\"></TD><TD>".$row['Title']."</TD></TR>\n";
	}
	?>
	  </table>
	<span class="Design"><BR>
	<?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>

    <INPUT TYPE="submit" VALUE="Choose wedges">
    </span></div>
</FORM>

<div align="center" class="Design"><BR>
  <A HREF=organize.php>Back to organize page</A><BR>
</div>
<div align="center" class="Design"></div>
