<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['gameFinished-title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link href="css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/Javascript">
	(function($){
		$(document).ready( function() 
		{
			window.poll = function() {
				window.location.href = "./play.php";
			}
			setInterval("poll()", 1000*60*5 );
			
			$('button').button().click( function() {
				window.location.href = "./play.php";
			});
		});
	})(jQuery);
	</script>
	<style>
		#wrapper {
			text-align: center;
			padding: 5%;
		}
		#wrapper h1 {
			font-size: 2em;
		}
		#wrapper p {
			margin: 5em 0;
			text-align: center;
		}
	</style>
</head>
<body>
	<? include "./inc/header.inc"; ?>
	<div id="wrapper">
		<h1><? echo $TEXT['gameFinished-h1_1']; ?></h1>
		<p><? echo $TEXT['gameFinished-p_1']; ?></p>
	</div>
</body>
</html>
