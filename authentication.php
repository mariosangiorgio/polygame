<?php
session_start();

require("./database/databaseLogin.php");

$username	= $_POST['username'];
$password	= $_POST['password'];

$query		= "SELECT `username`,`role`,`password` FROM `Users` WHERE `username`='$username'";

$data		= mysql_query($query,$connection);
$row		= mysql_fetch_array($data);

if(sha1("polygame".$password) == $row['password']){
	$_SESSION['loggedIn']	= "yes";
	$_SESSION['username']	= $username;
	$_SESSION['role']		= $row['role'];
	print "Login successful";
	}
else{
	print "Login error";
}

?>
