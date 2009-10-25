<?php
session_start();
require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
?>

<A HREF="./chooseGamePlayers.php">Choose game players</A> |
<A HREF="./showGamePlayers.php">View players list</A> |
Add new players |
<A HREF="./deletePlayers.php">Delete players from the database</A><BR><BR>

Please enter username and password for the new player: <BR>

<FORM METHOD="POST" ACTION="./businessLogic/insertNewPlayer.php">
<TABLE>
<TR><TD>Name</TD><TD>Password</TD></TR>
<TR>
<TD><INPUT TYPE="text" NAME="username"></TD>
<TD><INPUT TYPE="password" NAME="password"></TD>
</TR>
</TABLE>

<INPUT TYPE="submit" VALUE="Insert">
</FORM>

<BR><BR>These are the players currently in the database:<BR>
<?php	
	$query		= "SELECT `username`, `role` FROM `Users`
					WHERE `role` = 'player';";
	//print $query;
	$data		= mysql_query($query,$connection);

	while( $row	= mysql_fetch_array($data)){
		print $row['username']."\n";
	}

}
else {
	print "You must log in as an organizer to access this page!";
}
?>

<BR><A HREF=organize.php>Back to organize page</A><BR>