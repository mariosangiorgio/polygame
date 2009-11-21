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
	<div align="center">
	  <p><span class="Design">
      <table border=".1.">
	  </span></p>
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	  <p>
	      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
	        <param name="movie" value="Flash/dots.swf" />
	        <param name="quality" value="high" />
	        <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
                </object>
      </p>
</div>
	<div align="center">
	  <span class="Design">
	  <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"chosen\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD></TR>";
	}
	print "</table><BR>";
?>
	  
      <A HREF=newPlayer.php>Add a new player</A><BR>
	  
      <?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
      </span></div>
    <div align="center" class="Design"></div>
