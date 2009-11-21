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
</style><div align="center" class="Design">
  <p>&nbsp;  </p>
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
</div>
<div align="center" class="Design"></div>
<div align="center" class="Design"></div>
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