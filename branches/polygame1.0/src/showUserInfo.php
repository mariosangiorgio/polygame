<?php
session_start();
$username = $_SESSION['username'];
$firstPhase = $_SESSION['usernamePhaseOne'];
$secondPhase = $_SESSION['usernamePhaseTwo'];

echo "Player <B>$username</B> ";
if($firstPhase != $username or $secondPhase != $username){
	echo "groups: ";
	if($firstPhase != $username){
		echo "<B>$firstPhase</B>, ";
	}
	else{
		echo "<B>single player</B>, ";
	}
	if($secondPhase != $username){
		echo "<B>$secondPhase</B>";
	}
	else{
		echo "<B>single player</B>";
	}
}
echo "<BR><BR>";
?>