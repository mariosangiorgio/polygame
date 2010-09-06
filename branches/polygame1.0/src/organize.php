<?php
session_start();
require("./businessLogic/databaseLogin.php");

// Phases of the game
// 0. No game associated with organizer
// 1. Game created but not started
// 2. Game started and not yet finished: phase 1a
// 3. Game started and not yet finished: phase 1b
// 4. Game started and not yet finished: phase 1c
// 5. Game is paused between phase 1 and 2
// 6. Game started and not yet finished: phase 2
// 7. Game finished

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){


// Sets default value
$_SESSION['gamePhase'] = 0;
$_SESSION['gameCanStart'] = 0;

// Queries to enable/disable "start game" button
$query		= "SELECT `Player ID` FROM `Game Players`
	           WHERE `Game ID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) ;";
$data		= mysql_query($query,$connection);
$numPlayers = mysql_num_rows($data);

$query		= "SELECT `Wedge ID` FROM `Game Wedges`
	           WHERE `Game ID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) ;";
$data		= mysql_query($query,$connection);
$numWedges  = mysql_num_rows($data);

$query		= "SELECT `User ID` FROM `Wedge Players`
	           WHERE `Game ID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) ;";
$data		= mysql_query($query,$connection);
$numAssociatedWedges  = mysql_num_rows($data);

$query		= "SELECT `Voter ID` FROM `Game Voters`
	           WHERE `Game ID` IN (SELECT `Game ID`
	                                 FROM `Game`
	                                 WHERE `Organizer ID` = '".
	                                 $_SESSION['username']
	                                 ."' ) ;";
$data		= mysql_query($query,$connection);
$numVoters  = mysql_num_rows($data);

// wedge-players
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
	$wedgePlayersCount	 = mysql_fetch_array($data);
	//print $query."<BR>";
	/*print $wedgePlayersCount['numberOfPlayers']."<BR>";
	print $wedgePlayersCount['numberOfGroups']."<BR>";
	print $wedgePlayersCount['numberOfWedges'];*/
		
//print $numPlayers." ".$numWedges." ".$numAssociatedWedges." ".$numVoters;


// Finds if there are games associated with organizer
// (Basically chooses between phase 0 and 1)
$query = "SELECT `Game ID` FROM `Game`
		  WHERE `Organizer ID` = '".$_SESSION['username']."';";
$data	= mysql_query($query,$connection);
$val	= mysql_fetch_array($data);

if($val != 0) $_SESSION['gamePhase'] = 1;
else $_SESSION['gamePhase'] = 0;

// Finds out if game has started (doesn't check if it's finished)
// Phase 2 to 7 are possible in this state
/*$query = "SELECT `Starting time` FROM `Game`
		  WHERE `Organizer ID` = '".$_SESSION['username']."'
		  AND `Starting time` < NOW() ;";
$data	= mysql_query($query,$connection);
$val	= mysql_fetch_array($data);
if($val != 0) $_SESSION['gamePhase']=2;*/

// Finds out if game is finished (phase = 7)
$query 	=
	"SELECT *
	 FROM  `Game`
	 WHERE `Organizer ID` = '" .
	 	    $_SESSION['username'] . "'";
$data	= mysql_query($query,$connection);
$game	= mysql_fetch_array($data);
if($game != 0) {
$now	= time();
$gameIsStarted		= $game['Started'];
$phaseTwoIsStarted	= $game['Started Phase 2'];
/*$stringTime1		= $game['Starting time']." GMT";
$stringTime2		= $game['Starting time Phase 2']." GMT";
echo $stringTime1;
echo $stringTime2;
echo $game['Starting time Phase 2']."<BR><BR><BR>";*/
$startingTime		= strtotime($game['Starting time']);
$startingTimePhase2	= strtotime($game['Starting time Phase 2']);
$starting2			= $startingTimePhase2; //for compatibility
//echo $starting2."<BR>";
if(!$starting2) echo $startingTimePhase2."<BR>";
$starting1b			= $startingTime +
					 $game['Length 1a'];
$starting1c			= $startingTime +
					 $game['Length 1a'] +
					 $game['Length 1b'];
$endingPhase1		= $startingTime +
					 $game['Length 1a'] +
					 $game['Length 1b'] +
					 $game['Length 1c'];
$endingTime		   	= $starting2 +
					 $game['Length 2'];

if(	$numPlayers >= 1 and
	$numWedges >= 1 and
	//$numAssociatedWedges == $numPlayers and
	$numVoters >= 1 and
	(($wedgePlayersCount['numberOfPlayers'] + $wedgePlayersCount['numberOfGroups']) == $wedgePlayersCount['numberOfWedges']) and
	!$gameIsStarted
	)
{
	$_SESSION['gameCanStart'] = 1;	
}

if($gameIsStarted) {
	if($phaseTwoIsStarted) {
		if($now > $endingTime) 		$_SESSION['gamePhase'] = 7; //end
		else						$_SESSION['gamePhase'] = 6; //phase 2
	}
	else {
		if($now < $starting2)		$_SESSION['gamePhase'] = 5; //break
		if($now < $endingPhase1)	$_SESSION['gamePhase'] = 4; //1c
		if($now < $starting1c)		$_SESSION['gamePhase'] = 3; //1b
		if($now < $starting1b)		$_SESSION['gamePhase'] = 2; //1a
	}
}
else{
	if($now < $startingTime)	$_SESSION['gamePhase'] = 1; //created
	
	
}

 //DEBUG
/*print $gameIsStarted." ".$phaseTwoIsStarted." ";
print "Now: ".$now." ";
print $startingTime." ";
print $starting1b." ";
print $starting1c." ";
print $endingPhase1." ";
print $starting2." ";
print $endingTime."      ";
print $_SESSION['gamePhase']." ";*/

}

// Code that prints links on the page
?><style type="text/css">
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
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
.style4 {font-size: 16px}
.style5 {font-size: 16}
.style7 {
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #000000;
	background-image: url(../images/background.png);
	background-attachment: fixed;
	background-repeat: repeat;
	background-position: right bottom;
	font-size: 16pt;
	font-family: "HelveticaNeue LT 107 XBlkCn";
}
.style8 {font-family: "HelveticaNeue LT 107 XBlkCn"; font-size: 16px; }
-->
</style>
<div align="center" class="Design">
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
  <p class="Design"><b>Organizer</b><BR>
    
    <?php

// Phase 0
if ($_SESSION['gamePhase'] == 0) {
?>
      <A HREF=newGame.php class="three style1">Create a new game</A><BR>
    <?php }

// Phase 1
else if ($_SESSION['gamePhase'] == 1) {
?>
      <span class="three style1 style4"><A HREF=chooseGamePlayers.php class="three">Choose and view <b>players</b></A></span><BR>
      <A HREF=newGroup.php class="three style1 style4">Create <b>groups</b></A><BR>
      <A HREF=assignPlayers.php class="three style1 style5">Assign <b>players to groups</b></A><BR>
      <A HREF=chooseWedges.php class="three style1 style5">Choose and view <b>wedges</b></A><BR>
      <A HREF=chooseGameVoters.php class="three style1 style5">Choose and view <b>voters</b></A><BR>
      
      <?php
      if($_SESSION['gameCanStart'] == 1)
      {?>
      	
      	<A HREF=businessLogic/startGame.php class="three style1">Start phase one NOW!</A><BR>
      <?php
      }?>
    <BR>
    <BR>
    <?php
include("rulesAndPlayers.php");?>
    <BR>
    <BR>
    <?php }

// Phase 2
else if ($_SESSION['gamePhase'] > 1
         and $_SESSION['gamePhase'] < 7
         and $_SESSION['gamePhase'] != 5 ) {


$now	= time();
$countdown = 0;
if($_SESSION['gamePhase'] == 2)	 //1a
{
	print "We are currently in the phase when only the topic is shown<BR>";
	$countdown	= $starting1b - $now;
}
else if($_SESSION['gamePhase'] == 3) //1b
{
	print "We are currently in the phase when all the data is shown<BR>";
	$countdown	= $starting1c - $now;
}
else if($_SESSION['gamePhase'] == 4)  //1c
{
	print "We are currently in the phase when players are expected to come up with a solution<BR>";
	$countdown	= $endingPhase1 - $now;
}
else if($_SESSION['gamePhase'] == 6)  //2
{
	print "We are currently in phase when players are expected to come up with a plan<BR>";
	$countdown	= $endingTime - $now;
}

$remainingMinutes = floor($countdown / 60);
$remainingSeconds = $countdown % 60;

/*print $now."<BR>";
print $startingTime."<BR>";
print $starting1a."<BR>";
print $starting1b."<BR>";
print $starting1c."<BR>";
print $starting2."<BR>";*/


?>
  </p>
</div>
<form name="counter">
  <div align="center">
    
    <span class="Design">
    <input type="text" size="8" 
name="d2">
    </span></div>
</form> 

<div align="center">
  
  <span class="Design">
  <script> 
<!-- 

<?php 
 //print "var millisec = 0\n" ;
 print "var seconds = ".$remainingSeconds."\n";
 print "var minutes = ".$remainingMinutes."\n";
 
 ?>
 document.counter.d2.value = minutes+":"+seconds//+"."+millisec 

function display(){ 
 /*millisec-=1 
 if (millisec<=-1){ 
    millisec=9 
    seconds-=1 
 } */
 seconds-=1
 if (seconds <= 0 && minutes > 0) {
 	seconds = 59
 	minutes -= 1
 }  
    document.counter.d2.value=minutes+":"+seconds //+"."+millisec 
    if (seconds <= 0 && minutes <= 0) {    // && millisec <=0)
    //millisec = 0 
    seconds = 0
    minutes = 0
	location.reload(true)
	return
 	}
    setTimeout("display()",1000) 
} 
display() 
--> 
  </script> 
  </span></div>
<FORM METHOD="POST" ACTION="./businessLogic/giveMoreTime.php">
  <div align="center" class="Design">Give 
      <select name="minutes">
        <option VALUE=2> 2 </option>
        <option VALUE=5> 5 </option>
        <option VALUE=10> 10 </option>
        <option VALUE=15> 15 </option>
        <option VALUE=30> 30 </option>
      </select>
more minutes
<INPUT TYPE="submit" VALUE="Set extra time">
  </div>
</FORM>

<div align="center" class="Design">
  
  <p>
    <?php }

// Reload script: used to update game status
if($_SESSION['gamePhase'] >= 2 &&
   $_SESSION['gamePhase'] <= 6 )
   {
   	
   if($_SESSION['gamePhase'] != 5 ) {	
// Auto refresh code (every 30 seconds)
?>
    <script type="text/javascript">
function reFresh() {
	location.reload(true)
}
window.setInterval("reFresh()", 45000);
    </script>
    <?php }

	// Game status
	if( $_SESSION['gamePhase'] == 6 ) {
		include("statusOfGamePhaseTwo.php");
	}
	else if( $_SESSION['gamePhase'] == 5 )
	{
		include("posterPresentation.php");
	}
	else {
		include("statusOfGamePhaseOne.php");
	}

  }

// Menu entries
if($_SESSION['gamePhase'] == 1) //game created
{
	print "<BR><BR><A HREF=./businessLogic/deleteGame.php>Abandon game and delete all data linked to this game</A><BR>";
}
else if($_SESSION['gamePhase'] == 2) //1a
{
	print "<a href=./businessLogic/goToPreviousPhase.php>Emergency stop of the game (use only if really needed)</a><BR><BR>";
	print "<a href=./businessLogic/goToNextPhase.php>Go to next phase (show players complete information about wedges)</a><BR>";
	print "<BR><BR><A HREF=./businessLogic/deleteGame.php>Abandon game and delete all data linked to this game</A><BR>";
}
else if($_SESSION['gamePhase'] == 3) //1b
{
	print "<a href=./businessLogic/goToPreviousPhase.php>Go to previous phase (show players only hints about wedges)</a><BR>";
	print "<a href=./businessLogic/goToNextPhase.php>Go to next phase (enable solution submission)</a><BR>";
	print "<BR><BR><A HREF=./businessLogic/deleteGame.php>Abandon game and delete all data linked to this game</A><BR>";
}
else if($_SESSION['gamePhase'] == 4) //1c
{
	print "<a href=./businessLogic/goToPreviousPhase.php>Go to previous phase (disable solution submission)</a><BR>";
	print "<a href=./businessLogic/goToNextPhase.php>Go to break between phase 1 and 2</a><BR>";
	print "<BR><BR><A HREF=./businessLogic/deleteGame.php>Abandon game and delete all data linked to this game</A><BR>";
}
else if($_SESSION['gamePhase'] == 5)
{
	print "Phase 1 is over, press the button to start phase 2<BR>";
	print "<A HREF=businessLogic/startPhaseTwo.php>Start phase 2 NOW</A><BR>";
	print "<a href=./businessLogic/goToPreviousPhase.php>Go back to phase 1 (enable solution submission once again)</a><BR>";
	print "<BR><BR><A HREF=./businessLogic/deleteGame.php>Abandon game and delete all data linked to this game</A><BR>";
}
else if($_SESSION['gamePhase'] == 6)
{
	print "<a href=./businessLogic/goToPreviousPhase.php>Go back to break between phase 1 and phase 2</a><BR>";
	print "<a href=./businessLogic/goToNextPhase.php>End game and view results</a><BR>";	
	print "<BR><BR><A HREF=./businessLogic/deleteGame.php>Abandon game and delete all data linked to this game</A><BR>";
}
else if ($_SESSION['gamePhase'] == 7) {
	print "The game is over! Hope everyone had fun...<BR>";
	print "<a href=./businessLogic/goToPreviousPhase.php>Go back to phase 2</a><BR>";
	
	print "<BR>";
	include("standings.php");
	
	print "<BR><BR><A HREF=./businessLogic/deleteGame.php>Abandon game and delete all data linked to this game</A><BR>";
}



if ($_SESSION['gamePhase'] > 0 && ($numPlayers > 0 or $numVoters > 0)) {
?>
	<span class="style7"><A HREF=resetUserPassword.php class="three ">Reset user password</A></span><BR>

   <span class="style7"><A HREF=logout.php class="three ">Logout</A></span></p>

<?php
}
	}
	else print "You must be logged in as organizer to access this page"
?>
