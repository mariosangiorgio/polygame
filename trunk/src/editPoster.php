<?php
session_start();
require("./showUserInfo.php");
?><head>
<style type="text/css" media="all">
	@import "css/info.css";
	@import "css/main.css";
	@import "css/widgEditor.css";
	
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

a:hover {
	text-decoration: none;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
<script type="text/javascript" src="scripts/widgEditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body,td,th {
	font-family: HelveticaNeueLT Pro 45 Lt, HelveticaNeueLT Pro 35 Th;
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
}
//Retreiving the existing poster from the database
require("./businessLogic/databaseLogin.php");

$query 	= 
	"SELECT *
	 FROM `Posters`
	 WHERE `Player`='".$_SESSION['usernamePhaseOne']."' and 
	 	   `Game ID` = (SELECT `Game ID`
	 	   				FROM `Game Players`
	 	   				WHERE `Player ID` ='".$_SESSION['username']."')
	 	   			and
	 	   `Wedge ID`='".$_SESSION['wedgeID']."';";
$data	= mysql_query($query,$connection);
$poster = mysql_fetch_array($data);
?>

<FORM action="./businessLogic/updatePoster.php" method="post">
  <div align="center" class="Design">
    <p class="Design">Pros<BR>
        <TEXTAREA class="widgEditor" name="Pros" rows="20" cols="80"><?php print $poster['Pros']; ?></TEXTAREA>
      <BR>
    Cons<BR>
    <TEXTAREA class="widgEditor" name="Cons" rows="20" cols="80"><?php print $poster['Cons']; ?></TEXTAREA>
    <BR>
    Notes<BR>
    <TEXTAREA class="widgEditor" name="Notes" rows="20" cols="80"><?php print $poster['Notes']; ?></TEXTAREA>
    <BR>
    <INPUT type="Submit" value="Submit">
    </p>
  </div>
</FORM>
  <p class="Design"><br>
      <a href="showWedgeInformation.php" class="three style1">Back to wedge</a></p>
</div>
