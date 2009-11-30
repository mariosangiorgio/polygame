<?php
session_start();
?><head>
<style type="text/css" media="all">
	@import "css/info.css";
	@import "css/main.css";
	@import "css/widgEditor.css";
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
</style>
<script type="text/javascript" src="scripts/widgEditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
-->
</style>
</head>
<?php

$now = time();
$checkSolutionTime = $_SESSION['checkSolutionTime'];
$endPhase = $_SESSION['endPhase'];

if(
	//The user has the right to access this page
	$_SESSION['loggedIn'] == "yes" and
	$_SESSION['role']     == "player" and
	//It is the right time to access this page
	$now > $checkSolutionTime and
	$now < $endPhase
	){
	print "Poster:<BR>";
}
?>

<FORM action="./businessLogic/insertPoster.php" method="post">
	<div align="center" class="Design">
	  <p class="Design">Pros<BR>
        <TEXTAREA class="widgEditor" name="Pros" rows="20" cols="80"></TEXTAREA>
      <BR>
	Cons<BR>
	<TEXTAREA class="widgEditor" name="Cons" rows="20" cols="80"></TEXTAREA>
	<BR>
	Notes<BR>
	<TEXTAREA class="widgEditor" name="Notes" rows="20" cols="80"></TEXTAREA>
	  </p>
	  <p>&nbsp;</p>
	  <p>
	    
	    <span class="Design">
	    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
	      <param name="movie" value="Flash/dots.swf" />
	      <param name="quality" value="high" />
	      <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
        </object>
        </span></p>
	  <p>&nbsp;</p>
	  <p class="Design"><BR>
      <INPUT type="Submit" value="Submit">
            </p>
  </div>
</FORM>

<div align="center" class="Design"><br>
  <br>
    <a href="showWedgeInformation.php" class="three style1">Back to wedge</a></div>
