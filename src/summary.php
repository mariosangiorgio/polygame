<?php
	include_once("./inc/common.php");
	include_once './lang/'.$lang_file;
	include_once("./inc/db_connect.php");
	include_once("./backend/utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['organization-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" href="./css/main.css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/JavaScript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
</head>
<body>
	<? include "header.php"; ?>
	<div id="wrapper">
		<table class="summaryTable">
		<tbody>
			<tr>
				<th rowspan="
<?
	if( isSet( $_SESSION['phase1']['time2'] ))
		echo "5";
	else
		echo "3";
?>				">Game duration</th>
				<td><? echo $TEXT['newGamePhase1-h_1']; ?></td>
				<td><? echo $_SESSION['phase1']['time1']; ?> min</td>
				<td rowspan="
<?
	if( isSet( $_SESSION['phase1']['time2'] ))
		echo "5";
	else
		echo "3";
?>				">
					<form
						action="./createNewGame.php"
						method="post"
					>
						<button type="submit" class="modifyButton" ><? echo $TEXT['newGamePhase3_2-button_modify']; ?></button>
						<input type="hidden" name="destinationPhase" value="1" />
					</form>
				</td>
			</tr>
<?
	if( isSet( $_SESSION['phase1']['time2'] ))
	{
?>
			<tr>
				<td><? echo $TEXT['newGamePhase1-p_2']; ?></td>
				<td><? echo $_SESSION['phase1']['time2']; ?> min</td>
			</tr>
			<tr>
				<td><? echo $TEXT['newGamePhase1-p_3']; ?></td>
				<td><? echo $_SESSION['phase1']['time3']; ?> min</td>
			</tr>
<?
	}
?>
			<tr>
				<td><? echo $TEXT['newGamePhase1-h_3']; ?></td>
				<td><? echo $_SESSION['phase1']['time4']; ?> min</td>
			</tr>
			<tr>
				<td><? echo $TEXT['newGamePhase1-h_5']; ?></td>
				<td><? echo $_SESSION['phase1']['time5']; ?> min</td>
			</tr>			
		</tbody>
		<tbody>
			<tr>
				<th>Wedges selected</th>
				<td></td>
				<td><a href="./viewWedgesSelected.php" class="link">View list</a></td>
				<td>
					<form
						action="./createNewGame.php"
						method="post"
					>
						<button type="submit" class="modifyButton" ><? echo $TEXT['newGamePhase3_2-button_modify']; ?></button>
						<input type="hidden" name="destinationPhase" value="2" />
					</form>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<th>Groups: phase 1</th>
				<td></td>
				<td><a href="./viewGroupsPhase1.php" class="link">View list</a></td>
				<td>
					<form
						action="./createNewGame.php"
						method="post"
					>
						<button type="submit" class="modifyButton" ><? echo $TEXT['newGamePhase3_2-button_modify']; ?></button>
						<input type="hidden" name="destinationPhase" value="3" />
					</form>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<th>Groups: phase 2</th>
				<td></td>
				<td><a href="./viewGroupsPhase2.php" class="link">View list</a></td>
				<td>
					<form
						action="./createNewGame.php"
						method="post"
					>
						<button type="submit" class="modifyButton" ><? echo $TEXT['newGamePhase3_2-button_modify']; ?></button>
						<input type="hidden" name="destinationPhase" value="4" />
					</form>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<th>Voters selected</th>
				<td></td>
				<td><a href="./viewVotersSelected.php" class="link">View list</a></td>
				<td>
					<form
						action="./createNewGame.php"
						method="post"
					>
						<button type="submit" class="modifyButton" ><? echo $TEXT['newGamePhase3_2-button_modify']; ?></button>
						<input type="hidden" name="destinationPhase" value="5" />
					</form>
				</td>
			</tr>
		</tbody>
		</table>
	</div>
</body>
</html>
<script type="text/javascript">
	(function($) {
		$(document).ready( function() 
		{
			$('button.modifyButton').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			
			$('a.link').click( function( event ) {
				event.preventDefault();
				newWind = window.open( $(this).attr('href'), "", "height=400,width=400,scrollbars");
			});
		});
	})(jQuery);
</script>