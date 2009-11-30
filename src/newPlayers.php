<?php
session_start();

require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Existing players:<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = `player`;";
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
.style3 {
	color: #DD137B;
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
-->
    </style>
          <div align="center" class="Design">
        <div align="center">
        </div>
      <p align="center" class="Design">
      <div align="center"><span class="Design"><span class="Design">
      <table border=".1.">
      </span>
      </p>
      </span>
      </div>
      <p align="center" class="Design">&nbsp;</p>
	  <p align="center" class="Design">&nbsp;</p>
	  <p align="center">
	      <span class="Design">
	      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
	        <param name="movie" value="Flash/dots.swf" />
	        <param name="quality" value="high" />
	        <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
          </object>
          </span></p>
      <div align="center"><span class="Design">
      </div>
      </span>
        </div>
    <div align="center" class="Design">
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">
          <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"chosen\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD></TR>";
	}
	print "</table><BR>";
?>
          
          <A HREF=newPlayer.php><br />
          <span class="three style3">Add a new player</span></A><BR>
          
          <?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
        </p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
        <p class="Design">&nbsp;</p>
    </div>
    <div align="center" class="Design"></div>
    <div align="center" class="Design"></div>
    