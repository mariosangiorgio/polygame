<?php
	include_once("./inc/db_connect.php");
	include_once("./inc/init.php");
	include_once("./lang/".$gData['langFile']);
	include_once("./backend/utils.php");
	
	if( $gData['logged'] && $gData['role'] == "organizer" )
	{
		$query = "SELECT Defined, Started FROM `game` ".
				"WHERE `Organizer ID`='".$gData['userID']."';";
		$result = mysql_query( $query, $connection );
		
		if(( $row = mysql_fetch_array( $result )))
		{
			if( $row['Defined'] )
			{
				if( $row['Started'] )
					$case = 4;
				else
					$case = 3;
			}
			else
				$case = 2;
		}
		else
			$case = 1;
	}
	else
	{
		$errorCode = 401;	// Unauthorized
		include "errorPage.php";
		exit();
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
</head>
<body>
	<? include "header.php"; ?>
	<div id="wrapper">
		<div id="firstRow">
			<h1><? echo $TEXT['organizer-page_intro-title_'.$case]; ?></h1>
			<p><? echo $TEXT['organizer-page_intro-content_'.$case]; ?></p>
			<p><a class="link"><? echo $TEXT['organizer-page_rule-link']; ?></a></p>
			<!-- TODO: add link to the rules of the game -->
			<div id="newGameButton">
				<button type="button">
					<a href="./createNewGame.php">
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

</body>
</html>