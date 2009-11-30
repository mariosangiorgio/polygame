<?php
session_start();

require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Existing voters:<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = `voter`;";
	$data		= mysql_query($query,$connection);
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
.style4 {
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
	font-family: "HelveticaNeueLT Pro 45 Lt", "HelveticaNeueLT Pro 35 Th";
	font-size: 16;
}
.style5 {font-family: "HelveticaNeue LT 107 XBlkCn"}
-->
      </style>
      <span class="Design">
      <div align="center" class="Design">
      </span>
      <p align="center">&nbsp;      </p>
      <p align="center">&nbsp;</p>
      <p align="center">&nbsp;</p>
      <p align="center">
        <span class="Design">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
          <param name="movie" value="Flash/dots.swf" />
          <param name="quality" value="high" />
          <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
        </object>
        </span>
      <span class="Design">
        <table border=".1.">
        </p>
	    </div>
      </span>
<div align="center">
        <p><span class="Design">
        <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"chosen\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD></TR>";
	}
	print "</table><BR>";
?>
        </span><span class="style4"><A HREF=newPlayer.php class="three  style5">Add a new voter</A></span><span class="Design"><BR>
            
        <?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
        </span></p>
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
    <div align="center" class="Design"></div>
    <div align="center" class="Design"></div>
