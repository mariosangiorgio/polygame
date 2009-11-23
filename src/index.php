<?php
session_start();
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