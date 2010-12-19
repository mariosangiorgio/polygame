<?php
	include_once("./inc/common.php");
	include_once './lang/'.$lang_file;
	include_once("./inc/db_connect.php");
	include_once("./backend/utils.php");
	
	if( isSet( $_POST['destinationPhase'] ))
		// TODO: check if( $_POST['comingPhase'] < 0 || $_POST['comingPhase'] > 4 )
		$_COOKIE['phaseNumber'] = $_POST['destinationPhase'];
	else if( !$_COOKIE['phaseNumber'] )
		$_COOKIE['phaseNumber'] = 1;
	
	if( $_POST['comingPhase'] == 1 )
	{
		$query = "INSERT INTO `Game`(`Game ID`, `Organizer ID`, ".
						"`Starting time`, `Started`, ".
						"`Starting time Phase 2`, `Started Phase 2`, ". 
						"`Length 1a`, Length 1b`, `Length 1c`, `Length 2` ) ". 
				"VALUES( NULL, $organizerID, 0, 0, 0, 0, 
						$_POST['time1'],
						$_POST['time2'],
						$_POST['time3'],
						$_POST['time5'] )";
		
		$data = mysql_query( $query, $connection );
	}
	if( $_POST['comingPhase'] == 2 )
	{
		for( $index = 0; $index < $_POST['wedgesSelected']; $index++ )
		{
			$query = "INSERT INTO `Game wedges`(`Game ID`, `Wedge ID`) ".
					"VALUES ( $organizerID, $_POST['wedge'.$index] )";
			$data = mysql_query( $query, $connection );
		}
	}
	if( $_POST['comingPhase'] == 3 )
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
	if( $_SESSION['phaseNumber'] == 6 )
	{
		$_SESSION['phaseNumber']--;
		exit();
	}
	if(( isSet( $_POST['usingAjax'] ) && $_POST['usingAjax'] == 'true' ))
		include "newGamePhase".$_SESSION['phaseNumber'].".php";
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
		<? include "newGamePhase".$_SESSION['phaseNumber'].".php"; ?>
	</div>
</body>
</html>
<?
	}
?>
