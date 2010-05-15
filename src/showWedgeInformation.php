<HEAD>
<meta http-equiv="Refresh" content="60; url=index.php">
<link href="Design.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><style type="text/css">
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
</HEAD>
<?php
session_start();
require("./showUserInfo.php");
?>

<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">&nbsp;</p>
<p align="center" class="Design">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
    <param name="movie" value="Flash/dots.swf" />
    <param name="quality" value="high" />
    <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
  </object>
</p>
<p align="center" class="Design">&nbsp;</p>
<div align="center">
  <p class="Design">
    <?php
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "player"){
	require("./businessLogic/databaseLogin.php");
	//Loading wedge information
	if($_GET['wedgeID']){
		$wedgeID	= intval($_GET['wedgeID']);
		$query		=
		"SELECT *
		 FROM  `Wedges`
		 WHERE `Wedges`.`Wedge ID` = ".$wedgeID;
	}
	else{
		$query		=
		"SELECT *
		 FROM  `Wedges`, `Wedge Players`
		 WHERE `Wedges`.`Wedge ID` = `Wedge Players`.`Wedge ID`
		 	   and
		 	   `User ID` = '".$_SESSION['usernamePhaseOne']."'";
	}
	$data		= mysql_query($query,$connection);
	$wedge		= mysql_fetch_array($data);
	
	//Loading game information
	$query 	=
		"SELECT *
		 FROM  `Game`, `Game Players`
		 WHERE `Game`.`Game ID` = `Game Players`.`Game ID` and
			   `Game Players`.`Player ID` = '" .
				$_SESSION['username'] . "'";
	$data		= mysql_query($query,$connection);
	$game		= mysql_fetch_array($data);
	
	$now = time();
	
	$showAllInformationTime =
		strtotime($game['Starting time']) +
		$game['Length 1a'];
	
	$checkSolutionTime =
		$showAllInformationTime +
		$game['Length 1b'];
	
	$endPhase 		   =
		$checkSolutionTime +
		$game['Length 1c'];
	
	$_SESSION['checkSolutionTime']	= $checkSolutionTime;
	$_SESSION['endPhase'] 			= $endPhase;
	$_SESSION['wedgeID']			= $wedge['Wedge ID'];
	
	//Information always displayed
	print "<B>".$wedge['Title']."</B><BR>";
	print "<A HREF=\"./data.pdf\">Show all data</A><BR>";
	print $wedge['Introduction']."<BR>";
	if( $now > $showAllInformationTime){
	    print "<B>HISTORY</B><BR>";
	    print $wedge['History']."<BR>";
	    print "<B>PRESENT USE</B><BR>";
		print $wedge['Present use']."<BR>";
		print "<B>NATIONAL SITUATION</B><BR>";
		print $wedge['National situation']."<BR>";	
		print "<B>EMISSION REDUCTION</B><BR>";
		print $wedge['Emission reduction']."<BR>";
		print "<B>REFERENCES</B><BR>";
		print $wedge['References']."<BR>";
		
		if($now > $checkSolutionTime){
			print "<A HREF=\"checkSolution.php\">Check solution</A>";
			print "<BR>";
		}
		if($now > $checkSolutionTime and
		   $now < $endPhase){
		   /*
		    * If there isn't any poster players can submit it,
		    * otherwise they are able to modify it.
		    */
		   if(!$_SESSION['posterSubmitted']){
		   	print "<A HREF=\"submitPoster.php\">Submit your poster</A>";
		   }
		   else{
		    print "<A HREF=\"editPoster.php\">Edit your poster</A>";
		   }
		}
	}
	print "<BR><A HREF=\"./Logout.php\">Logout</A><BR>";
}
else
{
	print "You should be logged in as an user to view this page";
}
?></p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
</div>
