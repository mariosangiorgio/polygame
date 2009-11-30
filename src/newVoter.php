<?php
session_start();
require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
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
.style3 {font-style: normal; line-height: normal; font-weight: normal; font-variant: normal; text-transform: none; color: #000000; background-image: url(../images/background.png); background-attachment: fixed; background-repeat: repeat; background-position: right bottom; font-size: 12pt;}
.style4 {font-size: 16pt}
.style5 {font-family: "HelveticaNeue LT 107 XBlkCn"}
.style6 {font-size: 12pt; }
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
  <p class="Design"><A HREF="./chooseGameVoters.php" class="three style1">Choose game voters</A> |
      <A HREF="./showGameVoters.php" class="three style1">View voters list</A> |
Add new voters |
      <A HREF="./deleteGameVoters.php" class="three style1">Delete voters from the database</A><BR>
    <BR>

Please enter username and password for the new voter: <BR>
    </p>
</div>
<FORM METHOD="POST" ACTION="./businessLogic/insertNewVoter.php">
  <div align="center" class="Design">
  <TABLE>
    <TR><TD class="Design">Name</TD><TD class="Design">Password</TD></TR>
    <TR>
      <TD class="Design">        <INPUT TYPE="text" NAME="username">        </TD>
    <TD class="Design">      <INPUT TYPE="password" NAME="password">      </TD>
    </TR>
  </TABLE>
  
  <INPUT TYPE="submit" VALUE="Insert">
  <br />
  </div>
</FORM>
<div align="center">
  
  <span class="Design">
  <?php

	$query		= "SELECT `username`, `role` FROM `Users`
					WHERE `role` = 'voter';";
	$data		= mysql_query($query,$connection);

	while( $row	= mysql_fetch_array($data)){
		print $row['username'];
		print "<BR>";
	}

}
else {
	print "You must log in as an administrator to access this page!";
}
?>
  
  <BR>
  </span><span class="style3"><span class="style4"><span class="style5"><A HREF=organize.php class="three ">Back to organize page</A></span></span></span><span class="Design style4 style5"><span class="style6"></span></span><span class="Design"><BR>
  </span></div>
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
