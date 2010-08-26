<?php
	session_start();
	include_once("./inc/db_connect.php");
	include_once("./inc/common.php");
	include_once("./backend/utils.php");
	
	$wedgeInfo = null;
	$wedgeId = null;
	
	if( isSet( $_GET['id']))
	{
		$wedgeId = $_GET['id'];
		$lang = $_SESSION['lang'];
		$query = "SELECT Title, Introduction, History, Image FROM Wedges WHERE Language='$lang' AND `Wedge ID`=$wedgeId";

		$result = mysql_query( $query, $connection );
		$wedgeInfo = mysql_fetch_array( $result );
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $wedgeInfo['Title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/Javascript"> 
	
	( function($) {
		$(document).ready( function() 
		{
			var accordionOption = { collapsible: true, 
									active : false, 
									autoHeight: false, 
									animated: 'bounceslide' };
			
			$("#wedgeList").accordion( accordionOption );
		});
	})(jQuery);
	</script> 
</head>
<body>
	<?
		include "header.php"; 
	?>
	<div id="wrapper">
		<div id="columnLeft">
			<div id="top">
				<h1><? echo $wedgeInfo['Title']; ?></h1>
				<p><? echo $wedgeInfo['Introduction']; ?></p>
			</div>
			<div id="image">
				<img src="<? echo $wedgeInfo['Image']; ?>" />
			</div>
			<div id="bottom">
				<p><? echo $wedgeInfo['History']; ?></p>
			</div>
		</div>
		<div id="columnRight">
			<div id="wedgeList" class="accordion">
<? 
	$query = "SELECT `Wedge ID` as id, Title, Summary, Image ". 
			 "FROM Wedges ".
			 "WHERE Language='$lang' AND ( `Wedge ID` <> $wedgeId )";
	$data = mysql_query( $query, $connection );
	
	$counter = 0;
	while( $wedge = mysql_fetch_array( $data )) 
	{
		$wedges[$counter] = array(  'Id' 		=> $wedge['id'],
									'Title' 	=> $wedge['Title'],
									'Summary' 	=> $wedge['Summary'],
									'Image' 	=> $wedge['Image'] );
		$counter++;
	}
	
	$vector = generateRandomSequence( 0, $counter );
	$index = 0;
	while( $counter > 0 )
	{
		$wedge = $wedges[$vector[$index]];
?>
				<h3><a><? echo $wedges[$vector[$index]]['Title']; ?></a></h3>
				<div>
					<img src="<? echo $wedge['Image']; ?>" width="66px" height="84px" />
					<p class="accordionText">
						<? echo $wedge['Summary']; ?>
					</p>
					<p class="accordionLink">
						<a href="wedgeInfo.php?id=<? echo $wedge['Id']; ?>"><? echo $TEXT['main-a_1']; ?></a>
					</p>
				</div>
<?		
		$counter--;
		$index++;
	}
?>
			</div>
		</div>
	</div>
</body>
</html>