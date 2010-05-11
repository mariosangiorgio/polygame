<?php

function searchInArray($array, $searchKey) {
	//print_r($array);
	foreach ($array as $value) {
    	if($value == $searchKey) return 1;
	}
	reset($array);
	return 0;
}

function mysql_to_array( $mysql_array ) {
	$array = array();
	while( $row = mysql_fetch_array($mysql_array) ){
		$array[] = $row['username'];
	}
	//print "Array conversion... ";
	//print_r($array);
	return $array;
}


?>