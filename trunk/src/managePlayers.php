<?php
session_start();
require_once("./businessLogic/databaseLogin.php");
require_once("./businessLogic/businessLogicArrayFunctions.php");

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
	$_SESSION['role'] == "organizer") {
	
	print "Choose players you want in the game.<BR>";
	print "Please note that you won't be able to choose players already involved in a game.<BR>";
	print "Players will be added to the current game.<BR>";
	
	// Only players created by current organizer should be handled!
	
	$query									= "SELECT `username` FROM `Users` WHERE `role` = 'player'
					   						   AND `creator` = '".$_SESSION['username']."' ;";
	$playersCreatedByOrganizer 				= mysql_query($query,$connection);
	$allPlayers 							= mysql_to_array($playersCreatedByOrganizer);
	//print_r($allPlayers);
	//print $query;
	
	$query									= "SELECT `Player ID` as username FROM `Game Players`
	        		  						    WHERE `Game ID` IN (SELECT `Game ID`
	                					   		 FROM `Game`
	                      				   		WHERE `Organizer ID` = '".
	                                       				$_SESSION['username']
	                                       				."' ) ;";
	$playersCreatedByOrganizerAndInGame	    = mysql_query($query,$connection);
	$gamePlayers 							= mysql_to_array($playersCreatedByOrganizerAndInGame);
	//print $query;
	
	$query									= "SELECT `username` FROM `Users`
	        		  						    WHERE `username` NOT IN (SELECT `Player ID`
	                					   		 						  FROM `Game Players`
	                      				   								 WHERE `Game ID`
	                    	  				   								 IN (SELECT `Game ID`
								                					   		 FROM `Game`
	                      										   		WHERE `Organizer ID` = '".
	                                       								$_SESSION['username']
	                                       								."' )
	                                       								)
	                                       		AND `creator` ='".
	                                       			$_SESSION['username']
	                                       		    ."'
	                                       		 ;";
	$playersCreatedByOrganizerAndNotInGame  = mysql_query($query,$connection);
	$nonGamePlayers							= mysql_to_array($playersCreatedByOrganizerAndNotInGame);
	//print_r($nonGamePlayers);
	//print $query;
	
	
	// End of querys
	
	?>
	
	<!-- Script to switch action -->
	<SCRIPT language="JavaScript">
	function OnSubmitForm()
	{
	  if(document.playersForm.operation[0].checked == true)
	  {
	    document.playersForm.action ="./businessLogic/chooseGamePlayer.php";
	  }
	  else
	  if(document.playersForm.operation[1].checked == true)
	  {
	    document.playersForm.action ="./businessLogic/deletePlayer.php";
	  }
	  return true;
	}
	</SCRIPT>
	
    <table border=".1."> <!-- MAIN TWO-COLUMN TABLE -->
		<TR><TD>

		<?php
			
			if(mysql_num_rows($playersCreatedByOrganizer)==0)
			{
				print "This organizer has created no players so far";
				foreach ($allPlayers as $i => $player) {
					print "<TR height=\"25\"><TD></TD><TD></TD></TR>\n";
				}
				reset($allPlayers);
			}
			else
			{
		?>
		   <FORM NAME="playersForm" METHOD="POST" onSubmit="return OnSubmitForm();">
    		</p>
        		<table border=".1." width="180" valign="bottom"> <!-- LEFT TABLE -->
        <?php
	       	foreach ($allPlayers as $i => $player) {
				$research = searchInArray($nonGamePlayers, $player);
				if( $research == 1 ) {
					print "<TR height=\"25\"><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$player."\"></TD><TD>".$player."</TD></TR>\n";
				}
				else print "<TR height=\"25\"><TD></TD><TD></TD></TR>\n";
			}
			reset($allPlayers);
		?>
      			</table>
			<BR>
			<INPUT TYPE="radio" name="operation" VALUE="1" checked>Add to game<BR>
			<INPUT TYPE="radio" name="operation" VALUE="2">Delete from database<BR>
		    <P>
			    <INPUT TYPE="SUBMIT" name="Submit" VALUE="Submit">
		    </P>
			</FORM>
		<?php
			}
		?>
		</TD>
		<TD>
		<?php
		
			if(mysql_num_rows($playersCreatedByOrganizerAndInGame)==0)
			{
				//print "No players in the game";
				foreach ($allPlayers as $i => $player) {
					print "<TR height=\"25\"><TD></TD><TD></TD></TR>\n";
				}
				reset($allPlayers);
			}
			else {
		?>
    	
    	<FORM METHOD="POST" ACTION="./businessLogic/deleteGamePlayers.php">
    	<table border=".1." width="180" valign="bottom"> <!-- right table -->
      	<?php
      		foreach ($allPlayers as $i => $player) {
				$research = searchInArray($gamePlayers, $player);
				if( $research == 1 ) {
					print "<TR height=\"25\"><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$player."\"></TD><TD>".$player."</TD></TR>\n";
				}
				else print "<TR height=\"25\"><TD></TD><TD></TD></TR>\n";
			}
				print "<BR><BR><BR><BR>";
				reset($allPlayers);
		?>
      	</table>
		<INPUT TYPE="submit" VALUE="Remove from game">

		<BR>
		</TD>
		</TR>
	</table> <!-- MAIN TWO-COLUMN TABLE -->
	</span>
	<BR><BR><BR>
	
    <?php
			}
    ?>
    
    <p class="Design"><?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>
<div align="center" class="Mainstyle">
  <A HREF=organize.php class="three style1">Back to organize page</A><BR>
</div>
     </p>


