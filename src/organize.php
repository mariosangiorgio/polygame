<?php
	include_once("./inc/common.php");
	include_once 'lang/'.$lang_file;
	include_once("./inc/db_connect.php");
	include_once("./backend/utils.php");
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
	<style>
	.delete{
		float:right;
		}
	</style>
</head>
<body>
<div id="wrapper">
	<?
		include "header.php";
		if(!checkAuthorization("organizer")){
			?>
			<div class="singleColumn">
			<?
			echo $TEXT['organizer-page_login-error-message'];
			?>
			</div>
			<?
			return;
		}
		else{
			?>
			<div class="columnLeft">
				<DIV id=intro>
					<h1><? echo $TEXT['organizer-page_intro-title']; ?></h1>
					<p><? echo $TEXT['organizer-page_intro-content']; ?></p>
					</p><A HREF="#"><? echo $TEXT['organizer-page_rule-link']; ?></A></p>
					<!-- TODO add link to the rules of the game -->
				</div>
				<DIV id=suggestions>
					<h1><? echo $TEXT['organizer-page_suggestions-title']; ?></h1>
					<p><? echo $TEXT['organizer-page_suggestions-feedback']; ?>
					<a href='#'><? echo $TEXT['organizer-page_suggestions-propose-wedge']; ?></a></p>
				</div>
				<div id=textwrapper>
				<textarea id=feedback style='width: 100%;'><? echo $TEXT['organizer-page_default-feedback']; ?>
				</textarea>
				</div>
			</div>
			
			<div class="columnRight">
				<DIV id="newGameLink">
				<BUTTON><? echo $TEXT['organizer-page_new-game-button']; ?></BUTTON>
				</DIV>
				<DIV id="feedbackLink">
				<BUTTON><? echo $TEXT['organizer-page_send-your-feedback']; ?></BUTTON>
				</DIV>
			</div>
			<?
		}
	?>
</div>

<!-- Confirmation dialog -->
<div id="submission-confirmation" title="<? echo $TEXT['organizer-page_confirmation-dialog-title']; ?>">
<p><? echo $TEXT['organizer-page_confirmation-dialog-message']; ?></p>
</div>


<script type="text/JavaScript">
var textEdited = false;

var feedbackTextbox = $('#feedback');
feedbackTextbox.focus(
	function(){
		if(! textEdited){
			feedbackTextbox.val("");
			textEdited = true;
		}
	}
);

var createNewGameButton = $('button',"#newGameLink");
createNewGameButton.button();
createNewGameButton.click(function(){window.location.href='./createNewGame.php';});

var dialog = $("#submission-confirmation").dialog(
				{autoOpen: false,
				 resizable: false,
				 modal: true
				 }
				 );


var sendFeedbackButton = $('button',"#feedbackLink");
sendFeedbackButton.button();
sendFeedbackButton.click(
	function(){
		var feedbackText = feedbackTextbox.val();
		var parameters = {
			operation:	'submitFeedback',
			feedback:	feedbackText
			};
		$.getJSON(
			"backend/organization.php",
			parameters,
			function(data){
				dialog.dialog("open");
				feedbackTextbox.val("");
			}
		);
	}
);
</script>

</body>
</html>