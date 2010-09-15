<?php
	include_once("./inc/common.php");
	include_once './lang/'.$lang_file;
	include_once("./inc/db_connect.php");
	include_once("./backend/utils.php");
	
	if( isset( $_POST['phase'] ))
		// TODO: check if( $_POST['phase'] < 0 || $_POST['phase'] > 4 )
		$phaseNumber = $_POST['phase'];
	else
		$phaseNumber = 1;
	
	if( $phaseNumber == 2 )
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
		if( $parameters )
			$_SESSION['phase1'] = $parameters;
	}
	if( $phaseNumber == 3 )
	{
		if( isSet( $_POST['wedgesSelected'] ))
		{
			if( $_POST['wedgesSelected'] != 0 )
			{
				$parameters['wedgesSelected'] = $_POST['wedgesSelected'];
				for( $index = 0; $index < $_POST['wedgesSelected']; $index++ )
					if( $_POST['wedge'.$index] )
						$parameters['wedges']['wedge'.$_POST['wedge'.$index]] = $_POST['wedge'.$index];
				$_SESSION['phase2'] = $parameters;
			}
			else
				unSet( $_SESSION['phase2'] );
		}
	}
	if(( isSet( $_POST['usingAjax'] ) && $_POST['usingAjax'] == 'true' ))
		include "newGamePhase".$phaseNumber.".php";
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
		<? include "newGamePhase".$phaseNumber.".php"; ?>
	</div>
</body>
</html>
<?
	}
?>