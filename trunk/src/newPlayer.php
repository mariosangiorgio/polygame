<?php
session_start();
require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
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
  <p class="Design"><A HREF="./chooseGamePlayers.php">Choose game players</A> |
      <A HREF="./showGamePlayers.php">View players list</A> |
Add new players |
      <A HREF="./deletePlayers.php">Delete players from the database</A><BR>
    <BR>

Please enter username and password for the new player: <BR>
  </p>
</div>
<FORM METHOD="POST" ACTION="./businessLogic/insertNewPlayer.php">
  <div align="center">
  <TABLE>
    <TR><TD class="Design">Name</TD><TD class="Design">Password</TD></TR>
    <TR>
      <TD class="Design">        <span class="Design">
        <INPUT TYPE="text" NAME="username">        
        </span></TD>
    <TD class="Design">      <span class="Design">
      <INPUT TYPE="password" NAME="password">      
      </span></TD>
    </TR>
  </TABLE>
  
  <span class="Design">
  <INPUT TYPE="submit" VALUE="Insert">
  </span></div>
</FORM>

<div align="center" class="Design"><BR>
  <BR>
  Those are the players currently in the database:<BR>
  <?php	
	$query		= "SELECT `username`, `role` FROM `Users`
					WHERE `role` = 'player';";
	$data		= mysql_query($query,$connection);

	while( $row	= mysql_fetch_array($data)){
		print $row['username'];
		print "<BR>";
	}

}
else {
	print "You must log in as an organizer to access this page!";
}
?>

  <BR>
  <A HREF=organize.php>Back to organize page</A><BR>
</div>
<div align="center" class="Design"></div>
