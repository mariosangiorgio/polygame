<?php
session_start();
require("./businessLogic/databaseLogin.php");

?>

<FORM METHOD="POST" ACTION="./businessLogic/deleteVoter.php">
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	?>
	<A HREF="./chooseGameVoters.php">Choose game voters</A> |
	<A HREF="./showGameVoters.php">View voters list</A> |
	<A HREF="./newVoter.php">Add new voters</A> |
	Delete voters from the database<BR><BR>
	<?php
	
	print "Choose players you want to delete.<BR>";
	print "Please note that you can't delete players that are associated to a game.<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'voter'
				   AND username NOT IN ( SELECT `Voter ID` from `Game Voters`  );";
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

<INPUT TYPE="submit" VALUE="Delete selected voter(s)">
</FORM>
<BR><A HREF=organize.php>Back to organize page</A><BR>
