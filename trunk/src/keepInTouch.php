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
	<title><? echo $TEXT['main-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
</head>
<body>
	<div id='main' style="text-align:center;">
		<img src="images/logo_coming_soon.png"/ width="400px">
		<h1>We're still working on the PolyGame. Do you wish to be notified when it will be ready?</h1>
		<form id="subscription">
		<input type="radio" value="beta" name="radio" /><label for="beta">I wish to test the PolyGame and provide feedback even before it is in its final version</label><BR>
		<input type="radio" value="final" name="radio" checked="checked" /><label for="final">I wish to receive an email when the PolyGame is ready</label><BR><BR>
		Please email me at: <input type="text"  id="email"><button id="confirm">confirm</button>
		</form>
	</div>
	<br><br><br>
	<p style="text-align:center;">PolyGame was presented at SItE 2010 in Rome!<br>
	   View the presentation: <a href="presentation/PolyGame_SItE_Triverio.mov">QuickTime</a> | <a href="presentation/PolyGame_SItE_Triverio.pdf">PDF</a><br>
	</p>
	
</body>

<div id="successDialog" title="Success">
	<p>Thank you</p>
</div>
<div id="emailErrorDialog" title="Error">
	<p>e-mail error</p>
</div>

<script>
$( "#successDialog" ).dialog({autoOpen: false, closeOnEscape: false, modal: true});
$( "#emailErrorDialog" ).dialog({autoOpen: false,closeOnEscape: false, modal: true});

var confirm = $("#confirm");
var email 	= $("#email");
confirm.button();
confirm.click(function(){
	//e-mail check
	var address	= email.val();
	var what	= $('#subscription input:radio:checked').val();
	var filter	= /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(address)) {
		$("#emailErrorDialog").dialog("open");
	}
	else{
		var parameters = {
			address: address,
			what:	 what
			};
 		$.getJSON("backend/addSubscription.php",
 				parameters);
 		$("#successDialog").dialog("open");	
	}
	return false;
	});
</script>
</html>