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
a:hover {
	text-decoration: none;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<link href="css/Mainstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
-->
</style>
<div align="center">
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">
    
    <span class="Design">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
      <param name="movie" value="Flash/dots.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
    </object>
    </span></p>
  <p class="Design">Choose game voters |
      <A HREF="./showGameVoters.php" class="three style2">View voters list</A> |
      <A HREF="./newVoter.php" class="three style2">Add new voters</A> |
      <A HREF="./deleteVoters.php" class="three style2">Delete voters from the database</A><BR>
    <BR>
  </p>
</div>
<FORM METHOD="POST" ACTION="./businessLogic/chooseGameVoter.php">
    <div align="center">
        
        <span class="Design">
        <?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Choose voters you want to be part of this game.<BR>";
	print "Please note that you won't be able to choose voters already involved in a game.<BR>";
	print "Voters will be added to the current game.<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'voter'
					   AND username NOT IN ( SELECT `Voter ID` from `Game Voters`  );";
	$data		= mysql_query($query,$connection);
	?>
        </span>
        <table border=".1.">
          <?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD></TR>\n";
	}
	?>
          </table>
        <p class="Design"><?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
          </p>
        <p class="Design">
          <INPUT TYPE="submit" VALUE="Choose voters">
        </p>
  </div>
</FORM>

<div align="center" class="Design"><BR>
      <A HREF=organize.php class="three style2">Back to organize page</A><BR>
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
</div>
