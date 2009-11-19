<?php

session_start();

require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	//Printing existing groups
	$query = "SELECT `GroupName`, `Phase`
			  FROM   `Game Groups`
			  WHERE  `GameID` =
			  			(SELECT `Game ID`
				   		 FROM   `Game`
				   		 WHERE	`Organizer ID` = '".
				   		 		 $_SESSION['username']."')
			 ORDER BY `Phase` ASC;";
	$data  = mysql_query($query,$connection);
	print "<TABLE>";
	while($row = mysql_fetch_array($data)){
		print "<TR><TD>".$row['GroupName']."</TD><TD>".$row['Phase']."</TD></TR>";
	}
	print "</TABLE><BR>";
	print "<A href=newGroup.php>Add new group</A> <A href=organize.php>Back</A>";
	}

?>