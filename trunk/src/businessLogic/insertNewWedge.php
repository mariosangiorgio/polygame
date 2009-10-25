<?php
session_start();
if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
	require("./databaseLogin.php");
	//Sanitizing inputs
	$title				= mysql_real_escape_string($_POST['title']);
	$introduction		= mysql_real_escape_string($_POST['introduction']);
	$history			= mysql_real_escape_string($_POST['history']);
	$presentUse			= mysql_real_escape_string($_POST['presentUse']);
	$nationalSituation	= mysql_real_escape_string($_POST['nationalSituation']);
	$emissionReduction	= mysql_real_escape_string($_POST['emissionReduction']);
	$pro				= mysql_real_escape_string($_POST['pro']);
	$cons				= mysql_real_escape_string($_POST['cons']);
	$references			= mysql_real_escape_string($_POST['references']);

	$query		= "INSERT INTO `Wedges` (
					`Title`,
					`Introduction`,
					`History`,
					`Present use`,
					`National situation`,
					`Emission reduction`,
					`Pros`,
					`Cons`,
					`References`)
				   VALUES (
				    '$title',
				    '$introduction',
				    '$history',
				    '$presentUse',
				    '$nationalSituation',
				    '$emissionReduction',
				    '$pro',
				    '$cons',
				    '$references');";
	mysql_query($query,$connection);
	//Redirect to the main page
	header("Location: ../index.php");
}
else{
	print "To perform this operation you must be logged in as an administrator!";
}
?>