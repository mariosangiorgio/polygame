<?php 
	include_once("./inc/db_connect.php");
	include_once("./inc/init.php");
	include_once("./lang/".$gData['langFile']);
	include_once("./backend/utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['error-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link href="css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
	<style>
		.error p {
			text-align: center;
			font-size: 1.4em;
			color: red;
			padding: 2em 0;
		}
		.error p a {
			font-size: 0.8em;
		}
	</style>
</head>
<body>
	<? include "header.php"; ?>
	<div id="wrapper">
		<div class="error">
			<p><? echo $TEXT['errorPage-p_1_'.$errorCode]; ?></p>
			<p><a class="link" href="./index.php"><? echo $TEXT['errorPage-p_2']; ?></a></p>
		</div>
	</div>
</body>
</html>
