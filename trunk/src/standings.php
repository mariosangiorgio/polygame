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
<link href="Design.css" rel="stylesheet" type="text/css" />
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
    <param name="movie" value="Flash/logostops.swf" />
    <param name="quality" value="high" />
    <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
  </object>
</p>
<p align="center" class="Design">&nbsp;</p>
<div align="center" class="Design">
  <p>
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
	print "<TABLE><TR><TD>#</TD><TD>Player</TD><TD>Votes</TD></TR>";
	$count = 1;
	while($row = mysql_fetch_array($data)){
		if($count==1){
			$winner = $row['Player'];
		}
		print "<TR><TD>".$count."</TD><TD>".$row['Player']."</TD><TD>".$row['Votes']."</TD></TR>";
		$count = $count + 1;
	}
	print "</TABLE>";
	
	print "Comments<BR>";
	$query = "
		      SELECT `Comment`
			  FROM `Votes`
			  WHERE `Game ID`=(SELECT `Game ID`
	                 		   FROM   `Game`
	                 		   WHERE  `Organizer ID`=
	                 		   		  '".$_SESSION['username']."')
	                 AND `Player` ='".$winner."'";
	$data = mysql_query($query,$connection);
	while($row = mysql_fetch_array($data)){
		print $row['Comment']."<BR>";
	}
}
?>
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
