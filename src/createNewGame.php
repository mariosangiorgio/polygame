<?php
	session_start();
	include_once("./inc/db_connect.php");
	include_once("./inc/common.php");
	include_once("./backend/utils.php");
	
	if( isset( $_GET['phase'] ))
		// TODO: check if( $_GET['phase'] < 0 || $_GET['phase'] > 4 )
		$phaseNumber = $_GET['phase'];
	else
		$phaseNumber = 1;
	if(( isSet( $_GET['usingAjax'] ) && $_GET['usingAjax'] == 'true' ))
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
		<? include "newGameBar.php"; ?>
		<div id="phases" class="phases">
			<? include "newGamePhase".$phaseNumber.".php"; ?>
		</div>			
	</div>
</body>
</html>
<?
	}
?>