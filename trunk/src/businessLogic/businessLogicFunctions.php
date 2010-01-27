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

// Function to fix up PHP's messing up POST input containing dots, etc.
function getRealPOST() {
    $pairs = explode("&", file_get_contents("php://input"));
    $vars = array();
    foreach ($pairs as $pair) {
        $nv = explode("=", $pair);
        $name = urldecode($nv[0]);
        $value = urldecode($nv[1]);
        $vars[$name] = $value;
    }
    return $vars;
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

function searchInArray($array, $searchKey) {
	foreach ($array as $i => $value) {
    	if($array[$i] == $serachKey) return 1;
	}
	return 0;
}

function mysql_to_array( $mysql_array ) {
	while( $row = mysql_fetch_array($mysql_array) ){
		$array[] = $row['username'];
	}
	//print "Array conversion... ";
	//print_r($array);
	return $array;
}


?>