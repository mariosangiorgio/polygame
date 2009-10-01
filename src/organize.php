<?php
session_start();
if ($_SESSION['gamePhase'] < 2) {
?>
<b>Organizer</b><BR>
Organize a new PolyGame:<BR>
<A HREF=newPlayer.php>Add new players</A><BR>
<A HREF=deletePlayers.php>Remove players</A><BR><BR>

<?php
if ($_SESSION['gamePhase'] == 0) {
?>
<A HREF=newGame.php>Create a new game</A><BR>
<?php }
else if ($_SESSION['gamePhase'] == 1) {
?>
<A HREF=deleteGame.php>Abandon game</A><BR>
<A HREF=showGamePlayers.php>View game players for an existing game</A><BR>
<A HREF=chooseGamePlayers.php>Choose game players for an existing game</A><BR>
<A HREF=newVoters.php>Add voters to an existing game</A><BR><BR>
<A HREF=showWedges.php>View the available wedges</A><BR>
<A HREF=chooseWedges.php>Choose and edit wedges</A><BR>
<A HREF=newWedge.php>Add a new wedge</A><BR><BR>
<?php }
?>

<?php }

else {
?>

<A HREF=logout.php>Pause / remove / more time etc...</A><BR>

<?php }
?>

<A HREF=logout.php>Logout</A><BR>
