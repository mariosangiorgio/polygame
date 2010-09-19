<?php
	include_once("./inc/common.php");
	include_once './lang/'.$lang_file;
	include_once("./inc/db_connect.php");
	include_once("./backend/utils.php");
	
	if( isSet( $_POST['destinationPhase'] ))
		// TODO: check if( $_POST['comingPhase'] < 0 || $_POST['comingPhase'] > 4 )
		$_SESSION['phaseNumber'] = $_POST['destinationPhase'];
	else if( !$_SESSION['phaseNumber'] )
		$_SESSION['phaseNumber'] = 1;
	
	if( $_POST['comingPhase'] == 1 )
	{	
		if( isSet( $_POST['time1'] ))
			$parameters['time1'] = $_POST['time1'];
		if( isSet( $_POST['time4'] ))
			$parameters['time4'] = $_POST['time4'];
		if( isSet( $_POST['time5'] ))
			$parameters['time5'] = $_POST['time5'];
		if( isSet( $_POST['advanced'] ) && $_POST['advanced'] == "true" )
		{
			if( isSet( $_POST['time2'] ))
				$parameters['time2'] = $_POST['time2'];
			if( isSet( $_POST['time3'] ))
				$parameters['time3'] = $_POST['time3'];
		}
		$_SESSION['phase1'] = $parameters;
	}
	if( $_POST['comingPhase'] == 2 )
	{
		$parameters['wedgesSelected'] = $_POST['wedgesSelected'];
		for( $index = 0; $index < $_POST['wedgesSelected']; $index++ )
			if( $_POST['wedge'.$index] )
				$parameters['wedges']['wedge'.$_POST['wedge'.$index]] = $_POST['wedge'.$index];
		$_SESSION['phase2'] = $parameters;
	}
	if( $_POST['comingPhase'] == 3 )
	{
		if( isSet( $_POST['dataType'] ))
			$_SESSION['phase3']['dataType'] = $_POST['dataType'];
		if( isSet( $_POST['numberOfUsers'] ))
		{
			$_SESSION['phase3']['numberOfUsers'] = $_POST['numberOfUsers'];
			for( $index = 0; $index < $_POST['numberOfUsers']; $index++ )
				$users[$_POST['user'.$index]]['wedgeId'] = $_POST['wedge'.$index];
			
			$_SESSION['phase3']['users'] = $users;
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
	<link href="css/main.css" type="text/css" rel="stylesheet" />
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