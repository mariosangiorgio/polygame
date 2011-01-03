<?php
	$query = "SELECT `Title`, `Image`, `Introduction`, `Summary`, `History`, ".
			"`Present use`, `National situation`, `Emission reduction`, `References` ".
			"FROM `wedges` WHERE `Wedge ID`='".$game['wedgeID']."'";
	$result = mysql_query( $query, $connection );
	$wedgeInfo = mysql_fetch_array( $result );
	// TODO: check date and time!!!
	list( $date, $time ) = explode(' ', $game['phase1']);
	list( $year, $month, $day ) = explode('-', $date );
	list( $hour, $minute, $second ) = explode(':', $time );
	
	$timeElapsed = ( time() - mktime( $hour, $minute, $second, $month, $day, $year )) / 60;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $wedgeInfo['Title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="./css/main.css" type="text/css" rel="stylesheet" />
	<link href="./css/play.css" type="text/css" rel="stylesheet" />
	<link href="./css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/javascript" src="wymeditor/jquery.wymeditor.min.js"></script>
	<script type="text/Javascript"> 
	(function($){
		$(document).ready( function() 
		{
			$('button').button();
			
			$('form[name="solutionForm"]').submit( function( event )
			{
				event.preventDefault();
				var url = $(this).attr('action');
				var dataToSend = $(this).serialize();
				var typeOfDataToReceive = 'html';
				var callback = function( response ) {
					$('#stateBar').remove();
					$('#wrapper').append( response );
					$('button').button();
				};
				$.post( url, dataToSend, callback, typeOfDataToReceive );
			});
		});
	})(jQuery);
	</script> 
</head>
<body>
	<? include "./inc/header.inc"; ?>
	<div id="wrapper">
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
		<div id="stateBar" class="ui-corner-all">
			<h1>
				<? echo $TEXT['play_stateBar-h1_1_1'].
						$gData['username'].
						$TEXT['play_stateBar-h1_1_2']; ?>
			</h1>
<?
	if( $timeElapsed > $game['length1'] )
	{
?>	
			<p><? echo $TEXT['play_stateBar-p_3']; ?></p>
			<p><? echo $TEXT['play_stateBar-p_4_1']; ?><a href="TODO" class="link"><? echo $TEXT['play_stateBar-p_4_2']; ?></a><? echo $TEXT['play_stateBar-p_4_3']; ?></p>
			<form
				name="solutionForm"
				action="./backend/submitSolution.php"
				method="POST"
			>
				<input type="text" name="solution" />
				<button type="submit"><? echo $TEXT['play_stateBar-button_1']; ?></button>
			</form>
<?
	}
	else
	{
?>
			<p>
				<? echo $TEXT['play_stateBar-p_1_1'].
						"<em>".$wedgeInfo['Title']."</em>".
						$TEXT['play_stateBar-p_1_2']; ?>
			</p>
			<p><? echo $TEXT['play_stateBar-p_2']; ?></p>
<?
	}
?>
		</div>
	</div>
</body>
</html>