<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/init.inc");
	include_once("../inc/utils.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('player', 1 );
	
	$query = "SELECT `Plan ID` as planID, `Game ID` as gameID  ".
			"FROM `players`".
			"WHERE `Player ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	$player = mysql_fetch_array( $result );
	
	$query = "SELECT g.`Wedge ID` as wedgeID, `Title` ".
		"FROM `wedges` w, `wedge groups` g ".
		"WHERE w.`Wedge ID`=g.`Wedge ID` ".
		"AND g.`Game ID`='".$player['gameID']."';";
	$result = mysql_query( $query, $connection );
	$wedge = mysql_fetch_array( $result );
	
	
	$query = "INSERT INTO `plan wedges` ".
			"(`Plan ID`, `Wedge ID`, `Short term`, `Long term`) VALUES ";
	while( $wedge )
	{
		if( !isSet( $_POST['wedge'.$wedge['wedgeID']] ))
			redirectTo('../errorPage.php');
		list( $shortTerm, $longTerm ) = explode(':', $_POST['wedge'.$wedge['wedgeID']] );
		if( !is_numeric( $shortTerm ) ||
				!is_numeric( $longTerm ))
			redirectTo('../errorPage.php');
		
		$query = $query."('".$player['planID']."', '".$wedge['wedgeID']."', '$shortTerm', '$longTerm')";
		
		$wedge = mysql_fetch_array( $result );
		if( $wedge )
			$query = $query.", ";
	}
	$result = mysql_query( $query, $connection );
	
	$query = "UPDATE `plan groups` ".
			"SET `Plan submitted`='1' ".
			"WHERE `Plan ID`='".$player['planID']."'; ";
	$result = mysql_query( $query, $connection );
?>