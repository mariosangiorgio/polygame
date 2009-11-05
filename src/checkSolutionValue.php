<?php
session_start();

require("./businessLogic/databaseLogin.php");

$query 	= 
	"SELECT `Solution`, `Error Tolerance`
	 FROM	`Wedges`, `Wedge Players`
	 WHERE	`Wedges`.`Wedge ID` = `Wedge Players`.`Wedge ID` and
	 		`Wedge Players`.`User ID`
	 			= '".$_SESSION['username']."'";
$data	= mysql_query($query,$connection);
$values = mysql_fetch_array($data);

$solution = (float) $_POST['solution'];
if(abs($solution - $values['Solution'])/$values['Solution']
		<
   $values['Error Tolerance']/100){
   print "Your solution is correct";
}
else{
   print "There is something wrong";
}
print "<BR><A HREF=\"./\">BACK</A>";
?>