<?php
session_start();
require("./database/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Existing players:<BR>";
	
	$query		= "SELECT `username`, `role` FROM `Users`;";
	$data		= mysql_query($query,$connection);
	?>
	<table border=".1.">
	<?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"chosen\"></TD><TD>".$row['username']."</TD><TD>".$row['role']."</TD></TR>";
	}
	print "</table><BR>";
?>

<A HREF=newPlayer.php>Add a new player</A><BR>

<?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>