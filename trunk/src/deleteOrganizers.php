<?php
session_start();
require("./businessLogic/databaseLogin.php");

?><style type="text/css">
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
<link href="Design.css" rel="stylesheet" type="text/css" />


<link href="css/Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
-->
</style>
<FORM METHOD="POST" ACTION="./businessLogic/deleteOrganizer.php">
  <div align="center" class="Design">
    
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
	$_SESSION['role'] == "administrator"){
	
	print "Choose the organizers you want to delete.<BR>";
	print "Please note that you can't delete organizers that are currently associated to a game.<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'organizer'
				   AND username NOT IN ( SELECT `Organizer ID` from `Game`  );";
	$data		= mysql_query($query,$connection);
	?>
      </p>
    <table border=".1.">
      <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD></TR>\n";
	}
	?>
      </table>
    <p><BR>
      <?php
}
else {
	print "You must log in as an administrator to access this page!";
}
?>
      
      <INPUT TYPE="submit" VALUE="Delete selected organizer(s)">
    </p>
    <p>&nbsp;</p>
  </div>
</FORM>
<div align="center" class="Design"><BR>
    <A HREF=admin.php class="three style1">Back to administrator page</A><BR>
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
</div>
