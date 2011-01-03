<?php
	include_once("./inc/db_connect.inc");
	include_once("./inc/utils.inc");
	include_once("./inc/init.inc");
	include_once("./lang/".$gData['langFile']);
	
	checkAuthentication('organizer');
	
	$query = "SELECT `Game ID` as gameID, Defined ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	if(( $row = mysql_fetch_array( $result )))
	{
		$game['gameID'] = $row['gameID'];
		if( $row['Defined'] )
			redirectTo('./errorPage.php');
	}
	else
		redirectTo('./errorPage.php');
	
	if( isSet( $_GET['phase'] ))
	{
		$currentPhase = $_GET['phase'];
		// TODO: setcookie( 'phase', $currentPhase , time() + 3600, '/', 'baobab.elet.polimi.it' );
		setcookie( 'phase', $currentPhase , time() + 3600, '/' );
	}
	else if( isSet( $_COOKIE['phase'] ))
		$currentPhase = $_COOKIE['phase'];
	else
		$currentPhase = 1;

	if( isSet( $_GET['usingAjax'] ) && 
			$_GET['usingAjax'] == "true" )
	{
		include('./inc/newGameBar.inc');
		include('./inc/newGamePhase'.$currentPhase.'.inc');
		exit();
	}
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
	<? include "./inc/header.inc"; ?>
	<div id="wrapper">
		<? include('./inc/newGameBar.inc'); ?>
		<? include "./inc/newGamePhase".$currentPhase.".inc"; ?>
	</div>
</body>
</html>
