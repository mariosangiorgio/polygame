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
<div align="center" class="Design">
  <p>&nbsp;  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <span class="Design">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
      <param name="movie" value="Flash/dots.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
    </object>
    </span></p>
  <p class="Design"><A HREF="./chooseGamePlayers.php" class="three style1">Choose game players</A> |
    View players list |
      <A HREF="./newPlayer.php" class="three style1">Add new players</A> |
      <A HREF="./deletePlayers.php" class="three style1">Delete players from the database</A><BR>
    <BR>
  </p>
</div>
<FORM METHOD="POST" ACTION="./businessLogic/deleteGamePlayers.php">
  <div align="center" class="Design">
    
    <?php
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$query		= "SELECT `Player ID` FROM `Game Players`
	              WHERE `Game ID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) ;";
	$data		= mysql_query($query,$connection);
	
	//while( $row	= mysql_fetch_array($data)){
	//	print $row['Player ID']."<BR>";
	//}
?>
    
    <table border=".1.">
      <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['Player ID']."\"></TD><TD>".$row['Player ID']."</TD></TR>\n";
	}
	?>
      </table>
    <BR>
    
    <?php	
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
    <br />
    <INPUT TYPE="submit" VALUE="Delete selected players from game">
    <br />
    </div>
</FORM>

<div align="center" class="Design">
  <p><BR>
  <A HREF=organize.php class="three style1">Back to organize page</A></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p><BR>
              </p>
</div>
<div align="center" class="Design"></div>
<div align="center" class="Design"></div>
