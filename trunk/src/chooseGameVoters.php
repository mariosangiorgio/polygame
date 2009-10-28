<?php
session_start();
require("./businessLogic/databaseLogin.php");

?>

Choose game voters |
<A HREF="./showGameVoters.php">View voters list</A> |
<A HREF="./newVoter.php">Add new voters</A> |
<A HREF="./deleteVoters.php">Delete voters from the database</A><BR><BR>

<FORM METHOD="POST" ACTION="./businessLogic/chooseGameVoter.php">
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Choose voters you want to be part of this game.<BR>";
	print "Please note that you won't be able to choose voters already involved in a game.<BR>";
	print "Voters will be added to the current game.<BR>";
	
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

<INPUT TYPE="submit" VALUE="Choose voters">
</FORM>

<BR><A HREF=organize.php>Back to organize page</A><BR>
