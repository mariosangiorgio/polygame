<?php
session_start();
require("./businessLogic/databaseLogin.php");

?>

<FORM METHOD="POST" ACTION="./businessLogic/deleteGroup.php">
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	?>
<A HREF=assignPlayers.php>Assign <b>players to groups</b></A><BR> |
<A HREF=newGroup.php>Add a new group</A> |
Delete groups<BR>
	<?php
	
	print "Choose groups you want to delete.<BR>";
	// TODO check if this is correct!!!!!!!!!!!!!!!!
	$query		= "SELECT `username`, `role` FROM `Groups` WHERE `role` = 'player'
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
