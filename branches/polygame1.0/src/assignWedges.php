<?php
session_start();
?>

<script type="application/javascript">
    
    function validate() {
    	var rows = document.getElementById('UsersWedges').rows.length;
    	var value;
    	
    	for($i=0; $i<rows; $i = $i+1){
    		value = document.getElementById('player'+$i).value;
    		//No empty values
    		if( value == "0" ){
    			document.getElementById('submitButton').disabled=true;
    			document.getElementById('status').innerHTML
    				="Please select a wedge for every player";
    			return;
    		}
    		//No duplicates
    		for($j=$i+1; $j<rows; $j = $j+1){
    			value2 = document.getElementById('player'+$j).value;
    			//alert("value:"+value+" value2: "+value2);
    			if(value == value2){
    			    document.getElementById('submitButton').disabled=true;
    			    document.getElementById('status').innerHTML
    			    	="Double check for duplicates";
    			    //alert("Duplicates");
    				return;
    			}
    		}
    	}
    	document.getElementById('submitButton').disabled=false;
    	document.getElementById('status').innerHTML
    			    	="Assignement is ok";
    }
</script>
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
p
{
	background-image: url(images/background.png);
	background-position: right bottom;
	background-repeat: repeat;
	background-attachment: fixed;
}
a.three:link {color: #DD137B}
a.three:visited {color: #DD137B}
a.three:hover {background: #DD137B}
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>

<link href="css/Mainstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 16pt;
	font-family: "HelveticaNeue LT 107 XBlkCn";
}
-->
</style>
<noscript>
<p>Your browser either does not support JavaScript, or you have JavaScript turned off.</p>
</noscript>
    
<?php
require("./businessLogic/databaseLogin.php");

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	
	?>

    <div align="center" class="Design">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><A HREF="./chooseWedges.php" class="three style1">Choose wedges</A> |
       <A HREF="./showGameWedges.php" class="three style1">View and delete wedges</A> | Assign wedges <BR>
        <BR>
        <BR>

        <?php
	
	//Checking if there are the right number of players and wedges
	$query = "SELECT
			 ( SELECT `Game ID`
			   FROM   `Game`
			   WHERE	`Organizer ID` =
			   '".$_SESSION['username']."'
			 ) as currentGameID,
			 ( SELECT count(DISTINCT `GroupFirstPhase`)
			 FROM `Groups`
			 WHERE `GameID` = currentGameID AND `GroupFirstPhase`<>''
			 ) as numberOfGroups,
			(SELECT count(*)
				FROM `Game Players`
				WHERE `Game ID` = currentGameID AND `Player ID` NOT IN
				(SELECT `Player`
				 FROM `Groups`
				 WHERE `GameID` = currentGameID AND `GroupFirstPhase`<>'')			
			) as numberOfPlayers,
	          (SELECT count(*)
	           FROM `Game Wedges`
	           WHERE `Game ID` = (SELECT `Game ID`
	                             FROM    `Game`
	                             WHERE   `Organizer ID` =
	                             '".$_SESSION['username']."')
	           ) as numberOfWedges";
	
	$data	 = mysql_query($query,$connection);
	$count	 = mysql_fetch_array($data);
	/*print $query."<BR>";
	print $count['numberOfPlayers']."<BR>";
	print $count['numberOfGroups']."<BR>";
	print $count['numberOfWedges'];*/
	
	
	if( ($count['numberOfPlayers'] + $count['numberOfGroups'])!= $count['numberOfWedges']){
		print "The number of players and the number of wedges should be the same";
		return;
	}
	
	//Getting the available wedges
	$query		= "SELECT `Wedge ID`, `Title`
				   FROM   `Wedges`
				   WHERE  `Wedge ID` IN ( SELECT `Wedge ID`
				   							  FROM   `Game Wedges`
				   							  WHERE  `Game ID` = 
				   							  	(SELECT `Game ID`
				   							  	 FROM   `Game`
				   							  	 WHERE	`Organizer ID` = '".$_SESSION['username']."')
				   							  );";
				   							  	
	//print "<BR><BR>".$query;
	$data	 = mysql_query($query,$connection);
	$options = "<OPTION VALUE=\"0\">Please choose a wedge";
	while($wedge = mysql_fetch_array($data)){
		$options = $options.
			"<OPTION VALUE=".$wedge['Wedge ID']." >".$wedge['Title'];
	}
	
	//Printing out user and their choice
	$query		= "SELECT `GroupFirstPhase` as `Player`
					FROM `Groups`
					WHERE `GameID` =  ( SELECT `Game ID`
						   FROM   `Game`
						   WHERE	`Organizer ID` =
						   '".$_SESSION['username']."'
						 )
					AND `GroupFirstPhase`<>''
					UNION
					SELECT `Player ID`
					FROM `Game Players`
					WHERE `Game ID` =  ( SELECT `Game ID`
						   FROM   `Game`
						   WHERE	`Organizer ID` =
						   '".$_SESSION['username']."' )
					AND `Player ID` NOT IN
					(SELECT `Player`
					 FROM `Groups`
					 WHERE `GameID` =  ( SELECT `Game ID`
						   FROM   `Game`
						   WHERE  `Organizer ID` =
						   '".$_SESSION['username']."'
						 )
					 AND `GroupFirstPhase`<>'')";
					 
	$data	 = mysql_query($query,$connection);
	?>
      </p>
    </div>
    <FORM METHOD="POST" ACTION='./businessLogic/insertPlayerWedgeAssignment.php'>
	<div align="center">
	  <TABLE ID="UsersWedges">
	    <?php
		$counter =0;
		while($player = mysql_fetch_array($data)){
			print "<TR><TD>".$player['Player']."</TD><TD>";
			print "<SELECT onChange=validate(); ID=player".$counter.
			      " NAME=\"".$player['Player']."\">";
			print $options;
			print "</SELECT>";
			print "</TD></TR>";
			$counter = $counter + 1;
		}
	?>
      </TABLE>
	  <span class="Design">
	  <input type="submit" id="submitButton" disabled="true">
	  </span></div>
	<div align="center" class="Design">
	<LABEL ID="status">Please select a wedge for every player</LABEL>
	</div>
	</form>
	<div align="center" class="Design">
	  <p><BR>
	        <A HREF=organize.php class="three style1">Back to organize page</A><BR>
        <?php
}

else{
	print "To perform this operation you must be logged in as an organizer!";
}


?>
</p>
</div>