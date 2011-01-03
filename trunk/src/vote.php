<?php
	include_once("./inc/db_connect.inc");
	include_once("./inc/utils.inc");
	include_once("./inc/init.inc");
	include_once("./lang/".$gData['langFile']);
	
	checkAuthentication('voter');
	
	$query = "SELECT `Game ID` as gameID ".
			"FROM `voters` ".
			"WHERE `Voter ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	$game = mysql_fetch_array( $result );
	
	$query = "SELECT `Plan submitted` ".
			"FROM `plan groups` ".
			"WHERE `Game ID`='".$game['gameID']."' ".
			"AND `Plan submitted`='0';";
	$result = mysql_query( $query, $connection );
	
	if( mysql_num_rows( $result ))
	{
		include('./inc/voterWaitForPlans.inc');
		exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['errorPage_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link href="css/play.css" type="text/css" rel="stylesheet" />
	<link href="css/vote.css" type="text/css" rel="stylesheet" />
	<link href="css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/JavaScript">
	(function($) {
		$(document).ready( function() 
		{
			var accordionOption = { collapsible: true, 
									active : false, 
									autoHeight: false, 
									animated: 'bounceslide' };
			
			$('#accordion').accordion( accordionOption );
			$('button').button();
			
			$('td.wedgeTitle a').click( function( event )
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
	<div id="wrapper">
		<h1>Pick the plan you like the most</h1>
		<p>If you feel like, you can also add a comment</p>
		<div id="accordion" class="accordion">
<?
	$query = "SELECT `Plan ID` as planID, `Group name` as groupName ".
			"FROM `plan groups` ".
			"WHERE `Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
	while( $planGroup = mysql_fetch_array( $result ))
	{
?>
			<h3><a><? echo $planGroup['groupName']; ?></a></h3>
			<div>
				<table>
				<thead>
					<tr>
						<th class="wedgeTitle">Wedge</th>
						<th class="wedgeWeight">Short term</th>
						<th class="wedgeWeight">Long term</th>
					</tr>
				</thead>
				<tbody>
<?
		$query = "SELECT g.`Wedge ID` as wedgeID, `Title` as title, ".
				"`Short term` as shortTerm, `Long term` as longTerm ".
				"FROM `plan wedges` g, `wedges` w ".
				"WHERE g.`Wedge ID`=w.`Wedge ID` ".
				"AND `Plan ID`='".$planGroup['planID']."';";
		$innerResult = mysql_query( $query, $connection );
		while(( $wedge = mysql_fetch_array( $innerResult )))
		{
?>
					
					<tr>
						<td class="wedgeID"><? echo $wedge['wedgeID']; ?></td>
						<td class="wedgeTitle"><a class="link"><? echo $wedge['title']; ?></a></td>
						<td class="wedgeWeight"><? echo $wedge['shortTerm']; ?></td>
						<td class="wedgeWeight"><? echo $wedge['longTerm']; ?></td>
					</tr>
<?
		}
?>							
				</tbody>							
				</table>							
				<div class="comment">
					<textarea rows="5">Add your comment here</textarea>
				</div>
				<div class="submit">
					<button type="button">Submit your vote</button>
				</div>							
			</div>
<?
	}
?>
		</div>
	</div>
	<p id="showDetails"><? echo $TEXT['play_phase2-p_1']; ?></p>
	<div id="wedgePoster">
	</div>
</body>
</html>