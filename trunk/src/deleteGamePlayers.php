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
<div align="center" class="Design"></div>
<div align="center" class="Design"></div>
<div align="center">
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">
    <?php
session_start();
header("Location: showGamePlayers.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
	require("./businessLogic/databaseLogin.php");

	foreach($_POST['selectedUsers'] as $value)  {
		//print $value;
		$query = "DELETE FROM `Game Players` WHERE `Player ID` = '$value';" ;
		//print $query;
		mysql_query($query,$connection);	
		
		$query = "DELETE FROM `Groups` WHERE `Player` = '$value';" ;
		//print $query;
		mysql_query($query,$connection);		
	} 
	
}
else{
	print "To perform this operation you must be logged in as an organizer!";
}
?>
          </p>
</div>
<div align="center" class="Design"></div>
<div align="center" class="Design">
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
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
