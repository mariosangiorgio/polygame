<?php
session_start();

//Redirect to the right page, depending on the status of the logged user
if( $_SESSION['loggedIn'] == "yes"){
	if( $_SESSION['role'] == "administrator"){
		header( 'Location: admin.php');
	}
	if( $_SESSION['role'] == "player"){
		header( 'Location: play.php');
	}
}
else{
	header( 'Location: login.php' ) ;
}
?>