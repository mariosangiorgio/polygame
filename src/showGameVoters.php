<?php
session_start();
require("./businessLogic/databaseLogin.php");
?>

<A HREF="./chooseGameVoters.php">Choose game voters</A> |
View voters list |
<A HREF="./newVoter.php">Add new voters</A> |
<A HREF="./deleteVoters.php">Delete voters from the database</A><BR><BR>

<FORM METHOD="POST" ACTION="./deleteGameVoters.php">
<?php
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	$query		= "SELECT `Voter ID` FROM `Game Voters`
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
		print "<TR><TD><input type=\"checkbox\" name=\"selectedUsers[]\" value=\"".$row['Voter ID']."\"></TD><TD>".$row['Voter ID']."</TD></TR>\n";
	}
	?>
	</table><BR>

<?php	
}
else {
	print "You must log in as an administrator to access this page!";
}
?>
<INPUT TYPE="submit" VALUE="Delete selected voters from game">
</FORM>

<BR><A HREF=organize.php>Back to organize page</A><BR>
