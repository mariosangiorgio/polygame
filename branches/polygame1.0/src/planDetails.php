<?php
session_start();
require("./businessLogic/databaseLogin.php");
$team = mysql_real_escape_string($_GET['team']);
$voter = $_SESSION['username'];

$term = mysql_real_escape_string($_GET['term']);
if($term != "shortTerm" and $term != "longTerm"){
	echo "Unknown term";
	return;
}

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "voter"){
	echo "<B>Selected wedges</B><BR>";
	
	// Wedges
	$query = "SELECT `Title`, `Wedge Count`
			  FROM `Wedges`, `Plans`
			  WHERE `Wedges`.`Wedge ID` = `Plans`.`Wedge ID` AND
			  		`Player ID`='$team'
			  			AND
			  		`Term` = '$term'
			  			AND
			  		`Game ID`=  (SELECT `Game ID`
	                 			 FROM   `Game Voters`
	                 			 WHERE	`Voter ID`='$voter')";
	$data = mysql_query($query,$connection);
	echo "<TABLE>";
	while($result = mysql_fetch_array($data)){
		?>
		<TR><TD><?php echo $result['Title'];?></TD><TD><?php echo $result['Wedge Count'];?></TD></TR>
		<?php
	}
	echo "</TABLE>";
	
	
	// Poster
	$query = "SELECT * FROM `Plan Posters`
			  WHERE Player='$team'
			  			AND
			  		`Term` = '$term'
			  			AND
			  		`Game ID`=  (SELECT `Game ID`
	                 			 FROM   `Game Voters`
	                 			 WHERE	`Voter ID`='$voter')";
	$data = mysql_query($query,$connection);
	$result = mysql_fetch_array($data);
	echo "<B>Overview</B><BR>";
	echo $result['Overview'];
	echo "<BR><B>Reasons</B><BR>";
	echo $result['Reasons'];
}
?>