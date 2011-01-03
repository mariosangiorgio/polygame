<?php
	$query = "SELECT `Group name` as groupName ".
			"FROM `plan groups` ".
			"WHERE `Plan ID`='".$game['planID']."' ".
			"AND `Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
	$groupName = mysql_fetch_array( $result );
	
	$query = "SELECT g.`Wedge ID` as wedgeID, `Title` ".
			"FROM `wedges` w, `wedge groups` g ".
			"WHERE w.`Wedge ID`=g.`Wedge ID` ".
			"AND g.`Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
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
			$('div.slider').slider({ 
				range: "min", 
				min: 0, 
				max: 40,
				slide: function( event, ui ) {
					if( $(this).parent().attr('class') == "shortTerm" )
					{
						$(this).parents('tr').find('td.shortTermWeight').html( ui.value );
						var value = 0;
						$('#planTable tbody td.shortTermWeight').each( function() {
							value += parseInt( $(this).text());
						});
						$('#planTable tfoot td.shortTerm').html( value );
					}
					else
					{
						$(this).parents('tr').find('td.longTermWeight').html( ui.value );
						var value = 0;
						$('#planTable tbody td.longTermWeight').each( function() {
							value += parseInt( $(this).text());
						});
						$('#planTable tfoot td.longTerm').html( value );	
					}
				}
			});
			
			$('.submitButton button').button().click( function()
			{
				var url = "./backend/submitPlan.php";
				var dataToSend = "";
				
				
				$('#planTable tbody tr').each( function()
				{
					if( dataToSend )
						dataToSend += "&";
					dataToSend += "wedge" + $('td.wedgeID', $(this)).text() +
								"=" + $('td.shortTermWeight', $(this)).text() +
								":" + $('td.longTermWeight', $(this)).text();
				});
				var typeOfDataToReceive = 'html';
				var callback = function( response ) {
					window.location.reload(true);
				};
				$.post( url, dataToSend, callback, typeOfDataToReceive ); 
				
			});
			
			$('.wedgeTitle a').click( function( event )
			{
				event.preventDefault();
				var url = "./backend/showWedgeAndPoster.php";
				var dataToSend = "wedgeID=" + $(this).parents('tr').find('td.wedgeID').text();
				var typeOfDataToReceive = 'html';
				var callback = function( response ) {
					$('#wedgePoster').html( response );
				};
				$.get( url, dataToSend, callback, typeOfDataToReceive ); 
			});
			
		});
	})(jQuery);
	</script> 
</head>
<body>
	<? include "./inc/header.inc"; ?>
	<div id="wrapper" class="poster">
		<div id="planDiv">
			<h1><? echo $groupName['groupName']; ?></h1>
			<table id="planTable" class="ui-corner-all">
			<thead>
				<th></th>
				<th class="shortTerm"><? echo $TEXT['play_phase2-th_1']; ?></th>
				<th></th>
				<th class="longTerm"><? echo $TEXT['play_phase2-th_2']; ?></th>
				<th></th>
			</thead>
			<tfoot>
				<tr>
					<td class="wedgeTitle"><? echo $TEXT['play_phase2-tfoot_1']; ?></td>
					<td class="shortTerm">0</td>
					<td></td>
					<td class="longTerm">0</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="5" class="submitButton">
						<button type="button"><? echo $TEXT['play_phase2-button_1']; ?></button>
					</td>
				</tr>
			</tfoot>
			<tbody>
<?
	$index = 0;
	while(( $wedge = mysql_fetch_array( $result )))
	{
?>	
				<tr>
					<td class="wedgeID"><? echo $wedge['wedgeID']; ?></td>
					<td class="wedgeTitle"><a class="link"><? echo $wedge['Title']; ?></a></td>
					<td class="shortTerm"><div class="slider"></div></td>
					<td class="shortTermWeight">0</td>
					<td class="longTerm"><div class="slider"></div></td>
					<td class="longTermWeight">0</td>
				</tr>
<?
		$index++;
	}
?>
			</tbody>
			</table>
		</div>
		<p id="showDetails"><? echo $TEXT['play_phase2-p_1']; ?></p>
		<div id="wedgePoster">
		</div>
	</div>
</body>
</html>