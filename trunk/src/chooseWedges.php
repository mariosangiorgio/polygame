<?php
session_start();
require("./businessLogic/databaseLogin.php");

?>
<FORM METHOD="POST" ACTION="./businessLogic/chooseGameWedges.php">
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	print "Choose wedges you want to be part of this game.<BR>";
	
	$query		= "SELECT `Wedge ID`, `Title`
				   FROM   `Wedges`
				   WHERE  `Wedge ID` NOT IN ( SELECT `Wedge ID`
				   							  FROM   `Game Wedges`
				   							  WHERE  `Game ID` = 
				   							  	(SELECT `Game ID`
				   							  	 FROM   `Game`
				   							  	 WHERE	`Organizer ID` = '".$_SESSION['username']."')
				   							  );";
	$data		= mysql_query($query,$connection);
	?>
	<table border=".1.">
	<?php
	while( $row	= mysql_fetch_array($data)){
		print "<TR><TD><input type=\"checkbox\" name=\"selectedWedges[]\" value=\"".$row['Wedge ID']."\"></TD><TD>".$row['Title']."</TD></TR>\n";
	}
	?>
	</table><BR>
	<?php
}
else {
	print "You must log in as an organizer to access this page!";
}
?>

<INPUT TYPE="submit" VALUE="Choose wedges">
</FORM>

<BR><A HREF=organize.php>Back to organize page</A><BR>
