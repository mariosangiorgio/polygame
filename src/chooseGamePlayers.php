<?php
session_start();
require("./businessLogic/databaseLogin.php");

?>


Choose game players |
<A HREF="./showGamePlayers.php">View players list</A> |
<A HREF="./newPlayer.php">Add new players</A> |
<A HREF="./deletePlayers.php">Delete players from the database</A><BR><BR>

<FORM METHOD="POST" ACTION="./businessLogic/chooseGamePlayer.php">
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
	<table border=".1.">
	<?php
	print "<TR><TD></TD><TD>Name</TD><TD>Role</TD><TD>Phase 1, Phase 2 or both</TD></TR>";
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD><TD><input type=\"radio\" name=\"radio1\"><input type=\"radio\" name=\"radio1\"><input type=\"radio\" name=\"radio1\" checked><br></td></TR>\n";
	}
	?>
	</table><BR>
	<?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>

<INPUT TYPE="submit" VALUE="Choose players">
</FORM>

<BR><A HREF=organize.php>Back to organize page</A><BR>
