<? 
	$query = "SELECT `Use email` as useEmail ".
			"FROM `game` WHERE `Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
	$dataType = mysql_fetch_array( $result );	
?>
<div id="divPhase3" class="phase3 phases">
<?
	if( $dataType['useEmail'] != NULL )
	{
		if( $dataType['useEmail'] )
			include "./inc/newGamePhase3_2.inc";
		else
			include "./inc/newGamePhase3_3.inc";
	}
	else
		include "./inc/newGamePhase3_1.inc";
?>
</div>
