<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:hover {
	color: #CCCCCC;
	text-decoration: none;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<p align="center" class="Design">&nbsp;</p>
<?php
session_start();

require("./businessLogic/databaseLogin.php");

$query 	= 
	"SELECT `Solution`, `Error Tolerance`
	 FROM	`Wedges`, `Wedge Players`
	 WHERE	`Wedges`.`Wedge ID` = `Wedge Players`.`Wedge ID` and
	 		`Wedge Players`.`User ID`
	 			= '".$_SESSION['usernamePhaseOne']."'";
$data	= mysql_query($query,$connection);
$values = mysql_fetch_array($data);

$solution = (float) $_POST['solution'];
//print $values['Solution'];
if(abs($solution - $values['Solution'])/$values['Solution']
		<
   $values['Error Tolerance']/100){
   print "Your solution is correct and it has successfully been submitted!";
   $correctness = "1";	
}
else{
   print "There is something wrong";
   $correctness = "0";
}

	// Put this in database
	$queryDel = "DELETE FROM `Results`
				WHERE `ID` ='".$_SESSION['usernamePhaseOne']."' 
				AND `Game ID` IN
			    ( SELECT `Game ID` FROM `Game Players` WHERE `Player ID` =
			    '". $_SESSION['username']."' );" ;
	$data	= mysql_query($queryDel,$connection);
	//print $queryDel;
	
	mysql_query($query,$connection);	
	
	$queryIns = "INSERT INTO `Results` (`ID`, `Result`, `Is correct`, `Game ID`)
				VALUES ('".$_SESSION['usernamePhaseOne']."', '".$solution."', '".$correctness."', 
			    ( SELECT `Game ID` FROM `Game Players` WHERE `Player ID` =
			    '". $_SESSION['username']."' ));" ;
    //print $queryIns;
	$data	= mysql_query($queryIns,$connection);
	//print $queryIns;

print "<BR><A HREF=\"./\">Back to Wedge</A>";
?>