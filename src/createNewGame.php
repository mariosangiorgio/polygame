<?php
	include_once("./inc/db_connect.php");
	include_once("./inc/init.php");
	include_once("./lang/".$gData['langFile']);
	include_once("./backend/utils.php");
	
	if( $gData['logged'] && $gData['role'] == "organizer" )
	{
		$query = "SELECT `Game ID` as id, Defined, Started FROM `game` WHERE `Organizer ID`='".$gData['username']."';";
		$result = mysql_query( $query, $connection );
		
		if(( $row = mysql_fetch_array( $result )))
		{
			$gData['gameID'] = $row['id']; 
			if( $row['Defined'] )
				;// TODO: Redirect to an error page (current organizer has a game already defined)
		}
		else
		{
			$query = "INSERT INTO `game`(`Game ID`, `Organizer ID`, ".
					"`Length 1a`, `Length 1b`, `Length 1c`, `Length 2`) ".
					"VALUES( NULL, ".$gData['username'].", '55', '10', '150', '0' );";
			$result = mysql_query( $query, $connection );
			
			$query = "SELECT `Game ID` as id FROM `Game` WHERE `Organizer ID`='".$gData['username']."';";
			$result = mysql_query( $query, $connection );
		
			if(( $row = mysql_fetch_array( $result )))
				$gData['gameID'] = $row['id']; 
		}
	}
	else
		;// TODO: Redirect to an error page (unauthorized)
	
	if( isSet( $_GET['phase'] ))
		$currentPhase = $_GET['Phase'];
	else
		$currentPhase = 1;
	
	if( $_POST['phase'] == 1 )
	{
		$query = "UPDATE `Game` SET ";
		if( isSet( $_POST['time1'] ))
			if( is_numeric( $_POST['time1'] ))
				$query = $query." `Length 1a`='".$_POST['time1']."'";
		if( isSet( $_POST['time2'] ))
			if( is_numeric( $_POST['time2'] ))
				$query = $query.", `Length 2`='".$_POST['time2']."'";
		
		$query = $query."WHERE `Game ID`='".$gData['gameID']."';";
		mysql_query( $query, $connection );
	}
	if( $_POST['phase'] == 2 )
	{
		if( !isSet( $_POST['wedgesSelected'] ) || 
			!is_numeric( $_POST['wedgesSelected'] ))
			;// TODO: invalid data
		for( $index = 0; $index < $_POST['wedgesSelected']; $index++ )
		{
			if( !isSet( $_POST['wedge'.$index] ) || !is_numeric( $_POST['wedge'.$index]))
				;// TODO: invalid data
			
			$wedgeIndex = mysql_real_escape_string( $_POST['wedge'.$index] );
			
			$query = "INSERT INTO `Game wedges`(`Game ID`, `Wedge ID`) ".
					"VALUES ('".$gData['gameID']."', '$wedgeIndex' )";
			$result = mysql_query( $query, $connection );
			if( !$result )
				;// TODO: invalid data
		}
	}
	if( $_POST['phase'] == 3 )
	{
		if( isSet( $_POST['dataType'] ))
			$_SESSION['phase3']['dataType'] = $_POST['dataType'];
		if( isSet( $_POST['numberOfUsers'] ))
		{
			if( $_POST['numberOfUsers'])
			{
				$_SESSION['phase3']['numberOfUsers'] = $_POST['numberOfUsers'];
				for( $index = 0; $index < $_POST['numberOfUsers']; $index++ )
					$users[$_POST['user'.$index]]['wedgeId'] = $_POST['wedge'.$index];
				
				$_SESSION['phase3']['users'] = $users;
			}
			else
				unset( $_SESSION['phase3']);
		}
	}
	if( $_POST['comingPhase'] == 4 )
	{
		$parameters['numberOfGroups'] = $_POST['numberOfGroups'];
		for( $index = 0; $index < $_POST['numberOfGroups']; $index++ )
			$parameters['groups'][$index] = $_POST['groupName'.$index];
		
		for( $index = 0; $index < $_SESSION['phase3']['numberOfUsers']; $index++ )
			$_SESSION['phase3']['users'][$_POST['user'.$index]]['group'] = $_POST['group'.$index];
			
		$_SESSION['phase4'] = $parameters;
	}
	if( $_POST['comingPhase'] == 5 )
	{
		$parameters['numberOfVoters'] = $_POST['numberOfVoters'];
		for( $index = 0; $index < $_POST['numberOfVoters']; $index++ )
			$parameters['voters'][$index] = $_POST['voter'.$index];
		
		$_SESSION['phase5'] = $parameters;
		
		include "./backend/saveGameData.php";
	}
	if( isSet( $_GET['phase'] ))
		include "newGamePhase".$currentPhase.".php";
	else
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['organization-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" href="./css/main.css" rel="stylesheet" />
	<link type="text/css" href="./css/createNewGame.css" rel="stylesheet" />
	<link type="text/css" href="./css/orizontalBar.css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/JavaScript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
</head>
<body>
	<? include "header.php"; ?>
	<div id="wrapper">
		<? include "newGamePhase".$currentPhase.".php"; ?>
	</div>
</body>
</html>
<?
	}
?>
