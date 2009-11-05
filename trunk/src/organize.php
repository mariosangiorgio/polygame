<?php
session_start();
require("./businessLogic/databaseLogin.php");

// Phases of the game
// 0. No game associated with organizer
// 1. Game created but not started
// 2. Game started and not yet finished: phase 1a
// 3. Game started and not yet finished: phase 1b
// 4. Game started and not yet finished: phase 1c
// 5. Game started and not yet finished: phase 2
// 6. Game finished

// Sets default value
$_SESSION['gamePhase'] = 0;

// Finds if there are games associated with organizer
// (Basically chooses between phase 0 and 1)
$query = "SELECT `Game ID` FROM `Game`
		  WHERE `Organizer ID` = '".$_SESSION['username']."';";
$data	= mysql_query($query,$connection);
$val	= mysql_fetch_array($data);

if($val != 0) $_SESSION['gamePhase'] = 1;
else $_SESSION['gamePhase'] = 0;

// Finds out if game has started (doesn't check if it's finished)
// Phase 2 to 6 are possible in this state
$query = "SELECT `Starting time` FROM `Game`
		  WHERE `Organizer ID` = '".$_SESSION['username']."'
		  AND `Starting time` < NOW() ;";
$data	= mysql_query($query,$connection);
$val	= mysql_fetch_array($data);
if($val != 0) $_SESSION['gamePhase']=2;

// Finds out if game is finished (phase = 6)
$query 	=
	"SELECT *
	 FROM  `Game`
	 WHERE `Organizer ID` = '" .
	 	    $_SESSION['username'] . "'";
	 	    //print $query;
$data	= mysql_query($query,$connection);
$game	= mysql_fetch_array($data);
if($game != 0) {
$now	= time();
$gameIsStarted		= $game['Started'];
$startingTime		= strtotime($game['Starting time']);
$startingTimePhase2	= strtotime($game['Starting time Phase 2']);
$starting1b			= $startingTime +
					 $game['Length 1a'] * 60;
$starting1c			= $startingTime +
					 $game['Length 1a'] * 60 +
					 $game['Length 1b'] * 60;
$starting2			= $startingTimePhase2;
$endingPhase1		= $startingTime +
					 $game['Length 1a'] * 60 +
					 $game['Length 1b'] * 60 +
					 $game['Length 1c'] * 60;
$endingTime		   	= $starting2 +
					 $game['Length 2'] * 60;
//if($now < $endingTime) $_SESSION['gamePhase'] = 3;

if($gameIsStarted) {
	if($now < $endingTime)		$_SESSION['gamePhase'] = 5;
	if($now < $starting2)		$_SESSION['gamePhase'] = 4;
	if($now < $starting1c)		$_SESSION['gamePhase'] = 3;
	if($now < $starting1b)		$_SESSION['gamePhase'] = 2;
	if($now < $startingTime)	$_SESSION['gamePhase'] = 1;
	if($now > $endingTime) 		$_SESSION['gamePhase'] = 6;
}

//DEBUG
//print $gameIsStarted." ";
//print $now." ";
//print $startingTime." ";
//print $starting1b." ";
//print $starting1c." ";
//print $starting2." ";
//print $endingTime."      ";
//print $_SESSION['gamePhase']." ";

}

// Code that prints links on the page
?>
<b>Organizer</b><BR>

<?php

// Phase 0
if ($_SESSION['gamePhase'] == 0) {
?>
<A HREF=newGame.php>Create a new game</A><BR>
<?php }

// Phase 1
else if ($_SESSION['gamePhase'] == 1) {
?>
<A HREF=chooseGamePlayers.php>Choose and view <b>players</b></A><BR>
<A HREF=chooseGameVoters.php>Choose and view <b>voters</b></A><BR><BR>
<A HREF=chooseWedges.php>Choose and view <b>wedges</br></A><BR>
<A HREF=assignWedges.php>Assign wedges to users</A><BR>

<A HREF=startGame.php>Start NOW phase one of this game!</A><BR><BR><BR>

<A HREF=deleteGame.php>Abandon game and delete all data linked to this game</A><BR>
<?php }

// Phase 2
else if ($_SESSION['gamePhase'] > 1 and $_SESSION['gamePhase'] < 6) {

// Auto refresh code (every 30 seconds)
// <php tag>
//<script type="text/javascript">
//function reFresh() {
//	location.reload(true)
//}
//window.setInterval("reFresh()", 10000);
//</script>

$now	= time();
$countdown = 0;
if($_SESSION['gamePhase'] == 2)	
{
	print "We are currently in phase 1a<BR>";
	$countdown	= $starting1b - $now;
}
else if($_SESSION['gamePhase'] == 3)
{
	print "We are currently in phase 1b<BR>";
	$countdown	= $starting1c - $now;
}
else if($_SESSION['gamePhase'] == 4)
{
	print "We are currently in phase 1c<BR>";
	$countdown	= $starting2 - $now;
}
else if($_SESSION['gamePhase'] == 5)
{
	print "We are currently in phase 2<BR>";
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

<form name="counter"><input type="text" size="8" 
name="d2"></form> 

<script> 
<!-- 

<?php 
 print "var milisec = 0\n" ;
 print "var seconds = ".$remainingSeconds."\n";
 print "var minutes = ".$remainingMinutes."\n";
 
 ?>
 document.counter.d2.value = minutes+":"+seconds+"."+milisec 

function display(){ 
 milisec-=1 
 if (milisec<=-1){ 
    milisec=9 
    seconds-=1 
 } 
 if (seconds <= 0 && minutes > 0) {
 	seconds = 59
 	minutes -= 1
 }  
    document.counter.d2.value=minutes+":"+seconds+"."+milisec 
    if (seconds <= 0 && minutes <= 0 && milisec <=0){ 
    milisec = 0 
    seconds = 0
    minutes = 0
	location.reload(true)
	return
 	}
    setTimeout("display()",100) 
} 
display() 
--> 
</script> 


<FORM METHOD="POST" ACTION="./businessLogic/giveMoreTime.php">
Give 
<select name="minutes">
  <option VALUE=2> 2 </option>
  <option VALUE=5> 5 </option>
  <option VALUE=10> 10 </option>
  <option VALUE=15> 15 </option>
  <option VALUE=30> 30 </option>
</select>
more minutes
<INPUT TYPE="submit" VALUE="Set extra time">
</FORM> 
<A HREF=deleteGame.php>Abandon game and delete all data linked to this game</A><BR>

<?php }

else if ($_SESSION['gamePhase'] == 6) {
?>
The game is over! Hope everyone had fun...<BR>
<A HREF=deleteGame.php>Delete all data linked to this game and possibly start a new game</A><BR>
<?php
}
?>


<A HREF=logout.php>Logout</A><BR>
