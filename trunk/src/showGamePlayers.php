<?php
session_start();
require("./businessLogic/databaseLogin.php");
?><style type="text/css">
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
<link href="Design.css" rel="stylesheet" type="text/css" />


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
  <p><A HREF="./chooseGamePlayers.php">Choose game players</A> |
    View players list |
    <A HREF="./newPlayer.php">Add new players</A> |
    <A HREF="./deletePlayers.php">Delete players from the database</A><BR>
    <BR>
    </p>
</div>
<FORM METHOD="POST" ACTION="./deleteGamePlayers.php">
  <div align="center">
    
    <span class="Design">
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
    </span>
    <table border=".1.">
      <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['Player ID']."\"></TD><TD>".$row['Player ID']."</TD></TR>\n";
	}
	?>
      </table>
    <span class="Design"><BR>
    
    <?php	
}
else {
	print "You must log in as an administrator to access this page!";
}
?>
    <INPUT TYPE="submit" VALUE="Delete selected players from game">
    </span></div>
</FORM>

<div align="center" class="Design"><BR>
  <A HREF=organize.php>Back to organize page</A><BR>
</div>
<div align="center" class="Design"></div>
<div align="center" class="Design"></div>
