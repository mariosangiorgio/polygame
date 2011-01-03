<?php
	include_once("../inc/db_connect.inc");
	include_once("../inc/init.inc");
	include_once("../inc/utils.inc");
	include_once("../lang/".$gData['langFile']);
	
	if( $gData['role'] == 'voter' )
		checkAuthentication('voter', 1 );
	else
		checkAuthentication('player', 1 );
	
	if( !isSet( $_GET['wedgeID'] ) ||
			!is_numeric( $_GET['wedgeID'] ))
		redirectTo('../errorPage.php');
	
	if( $gData['role'] == 'voter' )
		$query = "SELECT `Game ID` as gameID ".
				"FROM `voters` ".
				"WHERE `Voter ID`='".$gData['userID']."';";
	else
		$query = "SELECT `Game ID` as gameID ".
				"FROM `players` ".
				"WHERE `Player ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	$player = mysql_fetch_array( $result );
	
	$query = "SELECT `Title`, `Image`, `Introduction`, `Summary`, `History`, ".
			"`Present use`, `National situation`, `Emission reduction`, `References`, ".
			"`Pros`, `Cons`, `Notes` ".
			"FROM `wedges` w, `wedge groups` g ".
			"WHERE g.`Wedge ID`='".$_GET['wedgeID']."' ".
			"AND g.`Game ID`='".$player['gameID']."';";	
	$result = mysql_query( $query, $connection );
	$wedgeInfo = mysql_fetch_array( $result );
?>
<div class="title">
	<h1><? echo $wedgeInfo['Title']; ?></h1>
</div>
<div class="columnLeft">
	<div id="wedgeDetails">
<?
	foreach( $TEXT['play-sections'] as $tab )
	{
?>
		<div>
			<h2><? echo $tab; ?></h2>
			<p><? echo htmlentities( $wedgeInfo[$tab] ); ?></p>
		</div>
<?
	}
?>
	</div>
</div>
<div class="columnRight">
	<div id="pros" class="ui-corner-all">
		<h1><? echo $TEXT['play_poster-h1_1']; ?></h1>
		<div><textarea name="pros" rows="10"><? echo $wedgeInfo['Pros']; ?></textarea></div>
	</div>
	<div id="cons" class="ui-corner-all">
		<h1><? echo $TEXT['play_poster-h1_2']; ?></h1>
		<div><textarea name="cons" rows="10"><? echo $wedgeInfo['Cons']; ?></textarea></div>
	</div>
	<div id="notes" class="ui-corner-all">
		<h1><? echo $TEXT['play_poster-h1_3']; ?></h1>
		<div><textarea name="notes" rows="5"><? echo $wedgeInfo['Notes']; ?></textarea></div>
	</div>
</div>