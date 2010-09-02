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
		$query = "SELECT `Title`, `Image`, `Introduction`, `Summary`, `History`, `Present use`,".
				 "`National situation`, `Emission reduction`, `References`". 
				 "FROM `wedges` WHERE Language='$lang' AND `Wedge ID`=$wedgeId";
		
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
			
			$("#tabs").tabs();
		});
	})(jQuery);
	</script> 
</head>
<body>
	<?
		include "header.php"; 
	?>
	<div id="wrapper">
		<div class="title">
			<div class="columnLeft">
				<h1><? echo $wedgeInfo['Title']; ?></h1>
			</div>
			<div class="columnRight">
				<h1>Other wedges...</h1>
			</div>			
		</div>
		<div class="columnLeft">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Introduction</a></li>
					<li><a href="#tabs-2">History</a></li>
					<li><a href="#tabs-3">Present Use</a></li>
					<li><a href="#tabs-4">National situation</a></li>
					<li><a href="#tabs-5">Emission reduction</a></li>
					<li><a href="#tabs-6">References</a></li>
				</ul>
				<div id="tabs-1">
					<p>
						<? echo htmlentities($wedgeInfo['Introduction']); ?>
					</p>
				</div>				
				<div id="tabs-2">
					<p><? echo htmlentities($wedgeInfo['History']); ?></p>
				</div>
				<div id="tabs-3">
					<p><? echo htmlentities($wedgeInfo['Present use']); ?></p>
				</div>
				<div id="tabs-4">					
					<p><? echo htmlentities($wedgeInfo['National situation']); ?></p>
				</div>				
				<div id="tabs-5">					
					<p><? echo htmlentities($wedgeInfo['Emission reduction']); ?></p>
				</div>				
				<div id="tabs-6">					
					<p><? echo htmlentities($wedgeInfo['References']); ?></p>
				</div>
			</div>
		</div>
		<div class="columnRight">
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