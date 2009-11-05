<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "organizer"){
	require("./businessLogic/databaseLogin.php");
	
	$query = "SELECT `Player`, count(*) as `Votes`
			  FROM `Votes`
			  WHERE `Game ID`=(SELECT `Game ID`
	                 		   FROM   `Game`
	                 		   WHERE  `Organizer ID`=
	                 		   		  '".$_SESSION['username']."')
			  GROUP BY `Player`
			  ORDER BY `Votes` DESC";
	$data = mysql_query($query,$connection);
	print "<TABLE><TR><TD>Player</TD><TD>Votes</TD></TR>";
	while($row = mysql_fetch_array($data)){
		print "<TR><TD>".$row['Player']."</TD><TD>".$row['Votes']."</TD></TR>";
	}
	print "</TABLE>";
}
?>