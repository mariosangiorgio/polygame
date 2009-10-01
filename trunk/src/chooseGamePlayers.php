<?php
session_start();
require("./database/databaseLogin.php");

?>

<FORM METHOD="POST" ACTION="./chooseGamePlayer.php">
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Choose players you want in the game.<BR>";
	print "Please note that you won't be able to choose players already involved in a game.<BR>";
	print "Users will automatically be added to the last game created.<BR>";
	
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

<INPUT TYPE="submit" VALUE="Choose players">
</FORM>

<BR><A HREF=organize.php>Back to organize page</A><BR>
