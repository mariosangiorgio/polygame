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
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color: #CCCCCC;
}
a:active {
	text-decoration: none;
}
-->
</style>
	<FORM method="POST" action="./businessLogic/insertVote.php">
	  <div align="center">
	    <p>&nbsp;        </p>
	    <p>&nbsp;</p>
	    <p>&nbsp;</p>
	    <p>
	      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
	        <param name="movie" value="Flash/logostops.swf" />
	        <param name="quality" value="high" />
	        <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
          </object>
        </p>
	    <p>&nbsp;</p>
	    <TABLE>
	      <TR>
	        <TD class="Design">Player</TD>
	  <?php for($i=0;$i<$wedges;$i=$i+1){print "<TD>".$titles[$i]."</TD>";} ?>
	        <TD class="Design">Vote</TD>
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
	    
	    <span class="Design">
	    <input type="text" name="comment">
	    <input type="submit" id="submitButton">
        </span></div>
	</form>
    <div align="center">
      
      <span class="Design">
      <?php
}
?>
      </span></div>
    <div align="center" class="Design"></div>
    <div align="center" class="Design"></div>
