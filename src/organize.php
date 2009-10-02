<?php
session_start();
require("./database/databaseLogin.php");

$query = "SELECT `Game ID` FROM `Game`
		  WHERE `Organizer ID` = '".$_SESSION['username']."';";
$data	= mysql_query($query,$connection);
$val	= mysql_fetch_array($data);

if($val != 0) $_SESSION['gamePhase']=1;
else $_SESSION['gamePhase']=0;

$query = "SELECT `Starting time` FROM `Game`
		  WHERE `Organizer ID` = '".$_SESSION['username']."'
		  AND `Starting time` < NOW() ;";
$data	= mysql_query($query,$connection);
$val	= mysql_fetch_array($data);
if($val != 0) $_SESSION['gamePhase']=2;


if ($_SESSION['gamePhase'] < 2) {
?>
<b>Organizer</b><BR>

<?php
if ($_SESSION['gamePhase'] == 0) {
	
}

if ($_SESSION['gamePhase'] == 0) {
?>
<A HREF=newGame.php>Create a new game</A><BR>
<?php }
else if ($_SESSION['gamePhase'] == 1) {
?>
<A HREF=deleteGame.php>Abandon game and delete all data linked to this game</A><BR>
<A HREF=chooseGamePlayers.php>Choose and view players in this game</A><BR>
<A HREF=newVoters.php>Add voters to this game</A><BR><BR>
<A HREF=showWedges.php>View the available wedges</A><BR>
<A HREF=chooseWedges.php>Choose and edit wedges</A><BR>
<A HREF=newWedge.php>Add a new wedge</A><BR><BR>

<A HREF=startGame.php>Start game NOW</A><BR>
<?php }
?>

<?php }

else {
?>

<A HREF=deleteGame.php>Abandon game and delete all data linked to this game</A><BR>
<A HREF=deleteGame.php>Give more time (not implemented)</A><BR>
<A HREF=deleteGame.php>Something else...</A><BR>

<?php }
?>


<A HREF=logout.php>Logout</A><BR>
