<?php
	session_start();
	//Cleaning up the session
	session_unset();
	session_destroy();
	header("Location: login.php");
?>