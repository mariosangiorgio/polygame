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
<FORM METHOD="POST" ACTION="./businessLogic/executeResetPassword.php">
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
	
		
	$query		= "SELECT `username`, `role` FROM `Users`
				   WHERE
				   ( (`role` = 'player' AND username IN ( SELECT `Player ID`
				   											from `Game Players`
				   										   WHERE `Game ID` = (SELECT `Game ID`
				   					  										FROM   `Game`
				   					  										WHERE	`Organizer ID` =
				   					         								'".$_SESSION['username']."')
				   											 ) )
				      OR (`role` = 'voter'  AND username IN ( SELECT `Voter ID` from `Game Voters`
				      										  WHERE `Game ID` = (SELECT `Game ID`
				   					  										FROM   `Game`
				   					  										WHERE	`Organizer ID` =
				   					         								'".$_SESSION['username']."')
				   					         				 ) ) ) 
				   ;";
	$data		= mysql_query($query,$connection);
	//print $query;
	
	if(mysql_num_rows($data)==0) print "No <u>player</u> or <u>voter</u> associated with this game yet.<BR>";
	else {
	
	print "Choose the user (<u>player</u> or <u>voter</u>) you want to reset the password of.<BR>";

	
	?>
    </p>
        <select name="mydropdown">
          <?php
	while( $row	= mysql_fetch_array($data)){
		print "<option name=\"user\" value=\"";
		print $row['username'];
		print "\">";
		print $row['username'];
		print "</option>";
	}
	
	?>
	
	  <INPUT TYPE="password" NAME="password">
      </select>
     <p>
     
               <INPUT TYPE="submit" VALUE="Change password">
        </p>
        <p>&nbsp;      </p>
  </div>
</FORM>
<div align="center" class="Design"><BR>
    <A HREF=organize.php class="three style1">Back to organize page</A><BR>
</div>
<div align="center" class="Design"></div>
<div align="center" class="Design">

</div>
     
     <?php
	}
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
          
