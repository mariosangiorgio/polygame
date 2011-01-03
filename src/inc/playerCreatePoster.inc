<?
	$query = "SELECT `Title`, `Image`, `Introduction`, `Summary`, `History`, ".
			"`Present use`, `National situation`, `Emission reduction`, `References` ".
			"FROM `wedges` WHERE `Wedge ID`='".$game['wedgeID']."'";
	$result = mysql_query( $query, $connection );
	$wedgeInfo = mysql_fetch_array( $result );
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
		});
	})(jQuery);
	</script> 
</head>
<body>
	<? include "./inc/header.inc"; ?>
	<div id="wrapper" class="poster">
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
		<div class="columnRight">
		<form
			name="submitPosterForm"
			action="./backend/submitPoster.php"
			method="POST"
		>
			<div id="rightHeader">
				<h1>Compile your poster and then submit it!</h1>
				<button type="submit">Submit poster</button>
			</div>
			<div id="pros" class="ui-corner-all">
				<h1><? echo $TEXT['play_poster-h1_1']; ?></h1>
				<div><textarea name="pros" rows="10"></textarea></div>
			</div>
			<div id="cons" class="ui-corner-all">
				<h1><? echo $TEXT['play_poster-h1_2']; ?></h1>
				<div><textarea name="cons" rows="10"></textarea></div>
			</div>
			<div id="notes" class="ui-corner-all">
				<h1><? echo $TEXT['play_poster-h1_3']; ?></h1>
				<div><textarea name="notes" rows="5"></textarea></div>
			</div>
		</form>
		</div>
	</div>
</body>
</html>