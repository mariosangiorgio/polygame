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
  <p>Choose game players |
    <A HREF="./showGamePlayers.php">View players list</A> |
    <A HREF="./newPlayer.php">Add new players</A> |
    <A HREF="./deletePlayers.php">Delete players from the database</A><BR>
    <BR>
    </p>
</div>
<FORM METHOD="POST" ACTION="./businessLogic/chooseGamePlayer.php">
  <div align="center">
    <span class="Design">
    <?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Choose players you want in the game.<BR>";
	print "Please note that you won't be able to choose players already involved in a game.<BR>";
	print "Players will be added to the current game.<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'player'
					   AND username NOT IN ( SELECT `Player ID` from `Game Players`  );";
	$data		= mysql_query($query,$connection);
	?>
    </span>
    <table border=".1.">
      <?php
	
	// Generates the options
	$options = "<OPTION VALUE=\"0\"> is a single user who takes part in both phases</option>";
	$options = $options."<OPTION VALUE=\"1\"> is a group who takes part in phase 1 only</option>";
	$options = $options."<OPTION VALUE=\"2\"> is a group who takes part in phase 2 only</option>";

	
	// Generate table and menus
	print "<TR><TD></TD><TD>Name</TD><TD>Role</TD></TR>";
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD>";
		
		print "<TD>".$row['role'];
		//print "<SELECT NAME=_____type".$row['username'].">";
		//print $options;
		//print "</SELECT>";
		print "</TD></TR>";
		
		//print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD><TD><input type=\"radio\" name=\"radio1\"><input type=\"radio\" name=\"radio1\"><input type=\"radio\" name=\"radio1\" checked><br></td></TR>\n";
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
    
    <INPUT TYPE="submit" VALUE="Choose players">
    </span></div>
</FORM>

<div align="center" class="Design"><BR>
  <A HREF=organize.php>Back to organize page</A><BR>
</div>
