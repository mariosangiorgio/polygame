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


<link href="css/Mainstyle.css" rel="stylesheet" type="text/css" />
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 16pt}
.style4 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
.style5 {font-family: "HelveticaNeue LT 107 XBlkCn"}
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
</div>

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
    <table border=".0."> <!-- MAIN TWO-COLUMN TABLE -->
		<TR><TD>
		
	    <FORM METHOD="POST" ACTION="./businessLogic/chooseGamePlayer.php">
		<FORM METHOD="POST" ACTION="./businessLogic/deletePlayer.php">

		<?php
			$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'player'
				   		   AND username NOT IN ( SELECT `Player ID` from `Game Players`  );";
			$data		= mysql_query($query,$connection);
			
			if(mysql_num_rows($data)==0)
				print "No players available";
			else {
		?>
    		</p>
        		<table border=".0." width="180" valign="bottom"> <!-- LEFT TABLE -->
        <?php
			while( $row	= mysql_fetch_array($data))
			{
				print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD></TR>\n";
			}
		?>
      			</table>
			<BR>
			<INPUT TYPE="submit" VALUE="Add to game"><BR><BR>
			</FORM>
			<INPUT TYPE="submit" VALUE="Permanentely delete">
			</FORM>
		<?php
			}
		?>
		</TD>
		<TD>
		<?php
		
			$query		= "SELECT `Player ID` FROM `Game Players`
	        		      WHERE `Game ID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) ;";
			$data		= mysql_query($query,$connection);
			if(mysql_num_rows($data)==0)
				print "No players available";
			else {
		?>
    	
    	<FORM METHOD="POST" ACTION="./businessLogic/deleteGamePlayers.php">
    	<table border=".0." width="180" valign="bottom"> <!-- right table -->
      	<?php
			while( $row	= mysql_fetch_array($data))
			{
				print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['Player ID']."\"></TD><TD>".$row['Player ID']."</TD></TR>\n";
			}
		?>
      	</table>
		<BR>
		<INPUT TYPE="submit" VALUE="Remove from game">
		</TD>
		</TR>
	</table> <!-- MAIN TWO-COLUMN TABLE -->

    <?php
			}
    ?>
    
    <p class="Design"><?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
     </p>

<div align="center" class="Mainstyle"><BR>
  <A HREF=organize.php class="three style1">Back to organize page</A><BR>
</div>
