<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "voter"){
	require("./businessLogic/databaseLogin.php");
	
	//Getting the plans sorted by teams
	//First getting all the wedges used in the Plans
	$query = "SELECT DISTINCT `Title`, `Plans`.`Wedge ID`
			  FROM `Plans`,`Wedges`
			  WHERE `Plans`.`Wedge ID`=`Wedges`.`Wedge ID` AND
			  		`Game ID`=  (SELECT `Game ID`
	                 			 FROM   `Game Voters`
	                 			 WHERE	`Voter ID`='".
	                 			 		 $_SESSION['username']."')";
	$data  = mysql_query($query,$connection);
	
	//Creating the query to have the data
	$query = "SELECT DISTINCT `Player ID` as `Player` ";
	$wedges = 0;
	while($wedge=mysql_fetch_array($data)){
		$query = $query.", (SELECT `Wedge Count`
		                   FROM   `Plans`
		                   WHERE  `Player ID`=`Player` AND
		                          `Wedge ID`=".$wedge['Wedge ID'].")
		                   as ".$wedge['Title']." ";
		$titles[$wedges] = $wedge['Title'];
		$wedges = $wedges + 1;
	}
	$query = $query."FROM  `Plans`
	                 WHERE `Game ID`=
	                 			(SELECT `Game ID`
	                 			 FROM   `Game Voters`
	                 			 WHERE	`Voter ID`='".
	                 			 		 $_SESSION['username']."')";
	$data  = mysql_query($query,$connection);
	?>
	<FORM method="POST" action="./businessLogic/insertVote.php">
	<TABLE>
	<TR>
	<TD>Player</TD>
	<?php for($i=0;$i<$wedges;$i=$i+1){print "<TD>".$titles[$i]."</TD>";} ?>
	<TD>Vote</TD>
	</TR>
	<?
	while($plan=mysql_fetch_array($data)){
		print "<TR><TD>".$plan['Player']."</TD>";
		for($i=0;$i<$wedges;$i=$i+1){
			print "<TD>".$plan[$titles[$i]]."</TD>";
		}
		print "<TD><input type=\"radio\"
		                  name=\"vote\"
		                  value=\"".$plan['Player']."\">
		       </TD></TR>";
	}
	?>
	</TABLE>
	<input type="submit" id="submitButton">
	</form>
<?php
}
?>