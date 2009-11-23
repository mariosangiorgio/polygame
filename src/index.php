<?php
session_start();

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
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="431" height="144">
      <param name="movie" value="Flash/logostops.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="431" height="144"></embed>
    </object>
  </p>
  <p>&nbsp;</p>
</div>
<div align="center" class="Design"></div>
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--

//Redirect to the right page, depending on the status of the logged user
// There are four possible roles:
//		1.Administrator (root of the PolyGame)
//		2.Organizer (root of an instance of PolyGame)
//		3.Player (player of an instance)
//		4.Voter (who votes the winner)
if( $_SESSION['loggedIn'] == "yes"){
	if( $_SESSION['role'] == "administrator"){
		header( 'Location: admin.php');
	}
	if( $_SESSION['role'] == "player"){
		header( 'Location: play.php');
	}
	if( $_SESSION['role'] == "organizer"){
		header( 'Location: organize.php');
	}
	if( $_SESSION['role'] == "voter"){
		header( 'Location: vote.php');
	}
}
//if not logged redirect to login page
else{
	header( 'Location: login.php' ) ;
}
?>