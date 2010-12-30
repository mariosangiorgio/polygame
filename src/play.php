<?php
	session_start();
	include_once("./inc/db_connect.php");
	include_once("./inc/common.php");
	include_once("./backend/utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['administration-page_title']; ?></title>
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
<?
	include "header.php";
	if(!checkAuthorization("player")){
?>
	<div id="wrapper">
	<div class="singleColumn">
		<? echo $TEXT['player-page_login-error-message']; ?>
	</div>
	</div>
<?
	return;
	}
	else{
		//Getting the wedge the player has to work on
		$query = "";
	}
?>
<div id="wrapper">
	<div class="title">
	<div class="columnLeft">
	<h1><?
				if($edit){
					?>
				<textarea
					id='editor-title'
					style='width: 40%'
					rows="1">Insert here the title of your wedge</textarea><?
				}
				else{
					echo $wedgeInfo['Title'];
				}
				?></h1>
			</div>
			<div class="columnRight">
				<h1>
				<?
				if(!$edit){
					echo "Other wedges...";
				}
				else{
					echo "Checklist";
				}
				?>
				</h1>
			</div>
		</div>
		<div class="columnLeft">
		</div>

</body>
</html>