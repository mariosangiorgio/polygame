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
-->
</style>
<FORM METHOD="POST" ACTION="./businessLogic/deletePlayer.php">
  <div align="center" class="Design">
        
        <p>&nbsp;      </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>
          <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="166">
            <param name="movie" value="Flash/dots.swf" />
            <param name="quality" value="high" />
            <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="166"></embed>
          </object>
      </p>
<p>
          <?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	?>
          <A HREF="./chooseGamePlayers.php" class="three style1">Choose game players</A> |
          <A HREF="./showGamePlayers.php" class="three style1">View players list</A> |
          <A HREF="./newPlayer.php" class="three style1">Add new players</A> |
      Delete players from the database<BR>
      <BR>
      <?php
	
	print "Choose players you want to delete.<BR>";
	print "Please note that you can't delete players that are associated to a game.<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'player'
				   AND username NOT IN ( SELECT `Player ID` from `Game Players`  );";
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
        <p><?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
          
          <INPUT TYPE="submit" VALUE="Delete selected player(s)">
        </p>
        <p>&nbsp;      </p>
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
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>