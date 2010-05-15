<?php
session_start();

$term = mysql_real_escape_string($_GET['term']);
if($term != "shortTerm" and $term != "longTerm"){
	echo "Unknown term";
	return;
}

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "voter"){
	require("./businessLogic/databaseLogin.php");
	
	//Checking if the voter is involved in a game
	$query = "SELECT *
			  FROM `Game Voters`
			  WHERE `Voter ID` = '".$_SESSION['username']."'";
	$data  = mysql_query($query,$connection);
	if(mysql_num_rows($data) == 0){
		print "Please wait to be inserted in a game<BR>";
		print "Try again later<BR>";
		return;
	}
	
	$query = "SELECT *
			  FROM `Votes`
			  WHERE
			  	`Term` = '$term'
			  		AND
			  	`Voter` = '".$_SESSION['username']."'
			  		AND
			  	`Game ID` = (SELECT `Game ID`
	                 			 FROM   `Game Voters`
	                 			 WHERE	`Voter ID`='".
	                 			 		 $_SESSION['username']."')";
	$data  = mysql_query($query,$connection);
	if(mysql_fetch_array($data)){
		?>
		You already voted for this term<BR>
		<A HREF='./vote.php'>Back</A>
		<?php
		return;
	}
	
	//Getting the plans sorted by teams
	//First getting all the wedges used in the Plans
	$query = "SELECT DISTINCT `Title`, `Plans`.`Wedge ID`
			  FROM `Plans`,`Wedges`
			  WHERE `Plans`.`Wedge ID`=`Wedges`.`Wedge ID`
			  			AND
			  		`Term` = '$term'
			  			AND
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
		                   WHERE  `Player ID`=`Player`
		                   				AND
		                    	  `Term` = '$term'
			  							AND
		                          `Wedge ID`=".$wedge['Wedge ID'].")
		                   as ".$wedge['Title']." ";
		$titles[$wedges] = $wedge['Title'];
		$wedges = $wedges + 1;
	}
	$query = $query."FROM  `Plans`
	                 WHERE  `Term` = '$term'
	                 			AND
	                 		`Game ID`=
	                 			(SELECT `Game ID`
	                 			 FROM   `Game Voters`
	                 			 WHERE	`Voter ID`='".
	                 			 		 $_SESSION['username']."')";
	$data  = mysql_query($query,$connection);
	?>
<link href="Design.css" rel="stylesheet" type="text/css" />
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
	<link href="css/Design.css" rel="stylesheet" type="text/css" />
<FORM method="POST" action="./businessLogic/insertVote.php">
	  <div align="center" class="Design">
	    <p class="Design">&nbsp;        </p>
	    <p class="Design">&nbsp;</p>
	    <p class="Design">&nbsp;</p>
	    <p>
	      
	      <span class="Design">
	      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
	        <param name="movie" value="Flash/logostops.swf" />
	        <param name="quality" value="high" />
	        <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
          </object>
        </span></p>
	    <p class="Design">&nbsp;</p>
	    <p class="Design">&nbsp;</p>
	    <TABLE>
	      <TR>
	        <TD class="Design">Player</TD>
	  <?php for($i=0;$i<$wedges;$i=$i+1){print "<TD>".$titles[$i]."</TD>";} ?>
	        <TD class="Design">Vote</TD>
	  </TR>
	      <?
	while($plan=mysql_fetch_array($data)){
		?>
		<TR>
		<TD>
		<A HREF="./planDetails.php?term=<?php echo $term;?>&team=<?php print $plan['Player'];?>">
		<?php print $plan['Player']; ?></A>
		</TD>
		<?
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
	    
	    <span class="Design">
	    <BR>
	    Write here a comment
	    <BR>
	    <TEXTAREA type="textarea" rows=5 cols=20 name="comment"></TEXTAREA>
	    <BR>
	    <input type="submit" id="submitButton">
	    <input type="hidden" name="term" value='<?php echo $term; ?>'>
        </span></div>
	</form>
      <?php
}
?>