<?php
session_start();
?>
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
<link href="Design.css" rel="stylesheet" type="text/css" />
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<div align="center" class="Design">
  <p>&nbsp;  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
      <param name="movie" value="Flash/dots.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
    </object>
  </p>
  <p>&nbsp;</p>
</div>
<div align="center" class="Design"></div>
<div align="center" class="Design">
  <p>
    <?php
require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$_SESSION['gamePhase'] = 2;
	
	$query		= "UPDATE `Game`
					SET `Starting time` = NOW(), `Started` = 1
					WHERE `Organizer ID` = '".$_SESSION['username']."';";
	$data		= mysql_query($query,$connection);
	
	sleep(1);
	header("Location: organizer.php");
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
</p>
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
  <p>&nbsp;  </p>
</div>
