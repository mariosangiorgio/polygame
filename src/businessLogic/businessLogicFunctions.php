<?php

function databaseLogin(){
	$host		= "mysql.netsons.com";
	$database	= "polygame_polygame";
	$username	= "polygame_user";
	$password	= "12qwaszx";
	$connection	= mysql_connect($host,$username,$password);
	mysql_select_db($database,$connection);
	
	return $connection;
}

function insertNewPlayer($username, $password){
	$connection = databaseLogin();
	
	//Sanitizing inputs
	$username	= mysql_real_escape_string($username);
	$password	= mysql_real_escape_string($password);
	//Hashing and salting the password
	$password	= sha1("polygame".$password);
	
	//Insert new player in USERS table
	$query		= "INSERT INTO `Users` (`username`,`role`,`password`)
				   VALUES ('$username', 'player', '$password');";
	
	$data		= mysql_query($query,$connection);
}

function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

?>