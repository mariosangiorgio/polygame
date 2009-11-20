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
	$references			= mysql_real_escape_string($_POST['references']);
	$solution			= (float) mysql_real_escape_string($_POST['solution']);
	$tolerance			= (float) mysql_real_escape_string($_POST['tolerance']);

	$query		= "INSERT INTO `Wedges` (
					`Title`,
					`Introduction`,
					`History`,
					`Present use`,
					`National situation`,
					`Emission reduction`,
					`References`,
					`Solution`,
					`Error Tolerance`)
				   VALUES (
				    '$title',
				    '$introduction',
				    '$history',
				    '$presentUse',
				    '$nationalSituation',
				    '$emissionReduction',
				    '$references',
				    $solution,
				    $tolerance);";
	mysql_query($query,$connection);
	//Redirect to the main page
	header("Location: ../index.php");
}
else{
	print "To perform this operation you must be logged in as an administrator!";
}
?>