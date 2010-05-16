<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	($_SESSION['role'] == "administrator" or
	$_SESSION['role'] == "organizer")){
	require("./databaseLogin.php");
	
	// Set values
	$user		= $_POST['user'];
	$password	= mysql_real_escape_string($_POST['password']);
	//Hashing and salting the password
	$password	= sha1("polygame".$password);
	
	// Checking that the user has the right to reset the password
	$query = "SELECT *
			  FROM   `Users`
			  WHERE	 `username` = '".$user."'";
	//echo $query;
	$data	 = mysql_query($query,$connection);
	$row	 = mysql_fetch_array($data);
	
	if(
	 ($_SESSION['role'] == "administrator" and $row['role'] == "organizer") or
	 ($_SESSION['role'] == "organizer" and $row['role'] == "player") or
	 ($_SESSION['role'] == "organizer" and $row['role'] == "voter")
	  ){
	
	$query		= 	"UPDATE `Users`
				   	SET `PasswordValid` = 0
					 WHERE `username` = '".$user."'";
	//		 SET `password` = '".$password."' 				 
	//print $user."!!";
	//print $query;
	$data		= 	mysql_query($query, $connection);
	
	//header("Location: ../index.php");
	print "Password successfully reset!";
	  }
else{
	print "Permission denied";
}	  
}
else{
	print "To perform this operation you must be logged in as an organizer or administrator!";
}
?>

<BR>
<A HREF="../index.php">Return to main page</A>
<BR>

