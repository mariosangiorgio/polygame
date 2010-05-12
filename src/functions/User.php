<?php
require("../businessLogic/businessLogicFunctions.php");

function insertNewAdministrator($username,$password,$creator,$information){
	insertNewUser($username, $password, "Administrator", 1, $information, $creator);
}
function insertNewAdministratorWithoutPassword($username,$creator,$information){
	insertNewUser($username, "", "Administrator", 1, $information, $creator);
}

function insertNewOrganizer($username,$password,$creator,$information){
	insertNewUser($username, $password, "Organizer", 1, $information, $creator);
}
function insertNewOrganizerWithoutPassword($username,$creator,$information){
	insertNewUser($username, "", "Organizer", 0, $information, $creator);
}

function insertNewPlayer($username,$password,$creator,$information){
	insertNewUser($username, $password, "Player", 1, $information, $creator);
}
function insertNewPlayerWithoutPassword($username,$creator,$information){
	insertNewUser($username, "", "Player", 0, $information, $creator);
}

function insertNewVoter($username,$password,$creator,$information){
	insertNewUser($username, $password, "Voter", 1, $information, $creator);
}
function insertNewVoterWithoutPassword($username,$creator,$information){
	insertNewUser($username, "", "Voter", 0, $information, $creator);
}

//function deleteUser($username);
//function resetPassword($username);

function insertNewUser($username, $password, $role, $PasswordValid, $information, $creator){
	$connection = databaseLogin();
	
	//Sanitizing inputs
	$username		= $connection->real_escape_string($username);
	$password		= $connection->real_escape_string($password);
	//Hashing and salting the password
	$password		= sha1("polygame".$password);
	$role			= $connection->real_escape_string($role);
	$PasswordValid	= $connection->real_escape_string($PasswordValid);
	$information	= $connection->real_escape_string($information);
	$creator 		= $connection->real_escape_string($creator);
	
	$connection->prepare("INSERT
						  INTO `Users`	(`username`,
						  				 `role`,
						  				 `password`,
						  				 `creator`,
						  				 `PasswordValid`,
						  				 `information`)
						  VALUES		(':username',
						  				 ':role',
						  				 ':password',
						  				 ':creator',
						  				 ':PasswordValid',
						  				 ':information');");
	$statement->bind_param(":name", $name);
	$statement->bind_param(":role", $role);
	$statement->bind_param(":password", $password);
	$statement->bind_param(":creator", $creator);
	$statement->bind_param(":PasswordValid", $PasswordValid);
	$statement->bind_param(":information", $information);
	
	$statement->execute();	
}

insertNewPlayerWithoutPassword('bimbo','Stefano Lavori','Designer')
?>