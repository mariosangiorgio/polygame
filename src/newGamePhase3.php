<? 
	include "newGameBar.php"; 
	
	$query = "SELECT `Use email` as useEmail ".
			"FROM `game` WHERE `Game ID`='".$gData['gameID']."';";
	$result = mysql_query( $query, $connection );
	$dataType = mysql_fetch_array( $result );	
?>
<div id="divPhase3" class="phase3 phases">
<?
	if( $dataType['useEmail'] != NULL )
		include "./newGamePhase3_2.php";
	else
		include "./newGamePhase3_1.php";
?>
</div>
