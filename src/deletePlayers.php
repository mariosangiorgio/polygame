<?php
session_start();
require("./database/databaseLogin.php");

?>

<FORM METHOD="POST" ACTION="./businessLogic/deletePlayer.php">
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	?>
	<A HREF="./chooseGamePlayers.php">Choose game players</A> |
	<A HREF="./showGamePlayers.php">View players list</A> |
	<A HREF="./newPlayer.php">Add new players</A> |
	Delete players from the database<BR><BR>
	<?php
	
	print "Choose players you want to delete.<BR>";
	print "Please note that you can't delete players that are associated to a game.<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'player'
				   AND username NOT IN ( SELECT `Player ID` from `Game Players`  );";
	$data		= mysql_query($query,$connection);
	?>
	<table border=".1.">
	<?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD></TR>\n";
	}
	?>
	</table><BR>
	<?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>

<INPUT TYPE="submit" VALUE="Delete selected player(s)">
</FORM>
<BR><A HREF=organize.php>Back to organize page</A><BR>
