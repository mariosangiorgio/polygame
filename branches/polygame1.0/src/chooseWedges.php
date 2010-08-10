<?php
session_start();
require("./businessLogic/databaseLogin.php");

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
.style3 {
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #000000;
	background-image: url(../images/background.png);
	background-attachment: fixed;
	background-repeat: repeat;
	background-position: right bottom;
	font-size: 16pt;
	font-family: "HelveticaNeue LT 107 XBlkCn";
}
-->
</style>
<FORM METHOD="POST" ACTION="./businessLogic/chooseGameWedges.php">
  <div align="center">
    <p class="Design">&nbsp;    </p>
    <p class="Design">&nbsp;</p>
    <p class="Design">&nbsp;</p>
    <p class="Design">
      <span class="Design">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
        <param name="movie" value="Flash/dots.swf" />
        <param name="quality" value="high" />
        <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
      </object>
      </span></p>
    <p class="Design">
      <span class="Design">
      <?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	?>    
      Choose wedges |
    <A HREF="./showGameWedges.php" class="three style1">View and delete wedges</A> |
    <A HREF="./assignWedges.php" class="three style1">Assign wedges</A><BR>
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
      </span></p>
    <table border=".1.">
	  <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedWedges[]\" value=\"".$row['Wedge ID']."\"></TD><TD>".$row['Title']."</TD></TR>\n";
	}
	?>
	  </table>
	<p class="Design"><BR>
      <?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
	  
      <INPUT TYPE="submit" VALUE="Choose wedges">
    </p>
  </div>
</FORM>

<div align="center" class="Design"><BR>
    <A HREF=organize.php class="three style1">Back to organize page</A><BR>
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
</div>
