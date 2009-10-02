<?php
session_start();
require("./database/databaseLogin.php");
?>

<A HREF="./chooseGamePlayers.php">Choose game players</A> |
View players list |
<A HREF="./newPlayer.php">Add new players</A> |
<A HREF="./deletePlayers.php">Delete players from the database</A><BR><BR>

<FORM METHOD="POST" ACTION="./deleteGamePlayers.php">
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
	</table><BR>

<?php	
}
else {
	print "You must log in as an administrator to access this page!";
}
?>
<INPUT TYPE="submit" VALUE="Delete selected players from game">
</FORM>

<BR><A HREF=organize.php>Back to organize page</A><BR>
