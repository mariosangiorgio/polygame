<?php
	include_once("./inc/db_connect.inc");
	include_once("./inc/utils.inc");
	include_once("./inc/init.inc");
	include_once("./lang/".$gData['langFile']);
	
	checkAuthentication('organizer');
	
	$link = "./createNewGame.php";
	$query = "SELECT `Defined`, `Phase 1` as phase1 ".
			"FROM `game` ".
			"WHERE `Organizer ID`='".$gData['userID']."';";
	$result = mysql_query( $query, $connection );
	if(( $row = mysql_fetch_array( $result )))
	{
		if( $row['Defined'] )
		{
			if( $row['phase1'] )
				$case = 4;
			else
			{
				$link = "./play.php";
				$case = 3;
			}
		}
		else
			$case = 2;
	}
	else
	{
		$case = 1;
		$link = "./backend/createNewGame.php";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['organization-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="./css/main.css" type="text/css" rel="stylesheet" />
	<link href="./css/organize.css" type="text/css" rel="stylesheet" />
	<link href="./css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />	
	<script src="./lib/jquery-1.4.1.min.js" type="text/JavaScript"></script>
	<script src="./lib/jquery-ui-1.8.4.custom.min.js" type="text/JavaScript"></script>
	<script type="text/JavaScript">
	(function($) {
		$(document).ready( function() 
		{
			var defaultValue1 = "<? echo $TEXT['organizer-page_default-feedback_1']; ?>";
			var defaultValue2 = "<? echo $TEXT['organizer-page_default-feedback_2']; ?>";
			
			var dialogOptions = { autoOpen: false,
				closeOnEscape: true,
				height: 100,
				modal: true,
				resizable: false
			};
			
			$("#response").dialog( dialogOptions );
			
			$('#feedback').focus( function( event ) {
				event.preventDefault();
				$(this).select();
			});
			
			$('button').button();
			
			$('#newGameButton button').click( function() {
				window.location.href = $('a', $(this)).attr('href');
			});
			
			$('#feedbackButton button').click( function()
			{
				var feedbackText = $('#feedback').val();
				if( feedbackText &&
					feedbackText != defaultValue1 &&
					feedbackText != defaultValue2 )
				{
					var dataToSend = "feedback=" + feedbackText;
					var url = $('a', $(this)).attr('href');
					var typeOfDataToReceive = 'json';
					var callback = function( response )
					{
						$('#response').dialog( "option", "title", response.title );
						$('#response p').text( response.text );
						$('#response').dialog("open");
					};
					$.post( url, dataToSend, callback, typeOfDataToReceive );
				}
				else {
					$('#feedback').val( defaultValue2 );
					$('#feedback').focus();
				}
			});
		});
	})(jQuery);
	</script>
</head>
<body>
	<? include "./inc/header.inc"; ?>
	<div id="wrapper">
		<div id="firstRow">
			<h1><? echo $TEXT['organizer-page_intro-title_'.$case]; ?></h1>
			<p><? echo $TEXT['organizer-page_intro-content_'.$case]; ?></p>
			<ul>
<?
	if( $case == 3 ) {	
?>	
				<li><? echo $TEXT['organizer-page_li_1_1']; ?><a href="./reviewGame.php" class="link"><? echo $TEXT['organizer-page_li_1_2']; ?></a></li>
				<li><? echo $TEXT['organizer-page_li_2_1']; ?><a href="./printPassword.php" class="link"><? echo $TEXT['organizer-page_li_2_2']; ?></a><? echo $TEXT['organizer-page_li_2_3']; ?></li>
<?
	}
?>
				<li><? echo $TEXT['organizer-page_li_3_1']; ?><a href="./rules.php" class="link"><? echo $TEXT['organizer-page_li_3_2']; ?></a></li>
			</ul>
<?
	if( $case != 1 ) {	
?>			
			<p><a href="./backend/deleteGame.php" class="link"><? echo $TEXT['organizer-page_delete-link_1']; ?></a><? echo $TEXT['organizer-page_delete-link_2']; ?></p>
<?
	}
?>			
			<!-- TODO: add link to the rules of the game -->
			<div id="newGameButton">
				<button type="button">
					<a href="<? echo $link; ?>">
						<? echo $TEXT['organizer-page_button_'.$case]; ?>
					</a>
				</button>
			</div>
		</div>
		<div id="secondRow">
			<div id="suggestions">
				<h1><? echo $TEXT['organizer-page_suggestions-title']; ?></h1>
				<p><? echo $TEXT['organizer-page_suggestions-feedback']; ?>
				<a class="link"><? echo $TEXT['organizer-page_suggestions-propose-wedge']; ?></a></p>
			</div>
			<div id="textwrapper">
				<textarea id="feedback" rows="5"><? echo $TEXT['organizer-page_default-feedback_1']; ?></textarea>
			</div>
			<div id="feedbackButton">
				<button type="button">
					<a href="./backend/insertFeedback.php">
						<? echo $TEXT['organizer-page_send-your-feedback']; ?>
					</a>
				</button>
			</div>
		</div>
	</div>
	<!-- Confirmation dialog -->
	<div id="response">
		<p></p>
	</div>
</body>
</html>