<?php

session_start();

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
	$id					= (int)	  mysql_real_escape_string($_POST['tolerance']);

	$query		= "UPDATE `Wedges` 
					SET
					`Title` 			= '$title',
					`Introduction`		= '$introduction',
					`History`			= '$history',
					`Present use`		= '$presentUse',	
					`National situation`= '$nationalSituation',
					`Emission reduction`= '$emissionReduction',
					`References`		= '$references',
					`Solution`			= '$solution',
					`Error Tolerance`	= '$tolerance'
					WHERE `Wedge ID` = $id";
	mysql_query($query,$connection);
	//Redirect to the main page
	header("Location: ../index.php");
?>