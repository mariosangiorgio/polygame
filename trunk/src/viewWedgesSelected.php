<?php
	include_once("./inc/common.php");
	include_once './lang/'.$lang_file;
	include_once("./inc/db_connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Wedges selected</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css">
		table {
			margin: 2% 10%;
			width: 80%;
			border-collapse: collapse;
		}
		tbody td {
			background: none repeat scroll 0 0 #D7EBF9;
			border-bottom: 2px solid #FFFFFF;
			color: #666699;
			padding: 0.4em;
			font-size: 1.2em;
			text-indent: 1em;
		}
		tbody tr:hover td {
			background: none repeat scroll 0 0 #FFFFFF;
			color: #000099;
		}
	</style>
</head>
<body>
	<table>
	<tbody>
<?
	$index = 1;
	foreach( $_SESSION['phase2']['wedges'] as $keyValue => $wedgeId )
	{
		$query = "SELECT `Wedge ID` as Id, Title ". 
			 "FROM Wedges ".
			 "WHERE Language='$lang' AND `Wedge ID`=".$wedgeId;
		$data = mysql_query( $query, $connection );
		$wedge = mysql_fetch_array( $data )
?>
		<tr>
			<td><? echo $index; ?></td>
			<td><? echo $wedge['Title']; ?></td>
		</tr>
<?
		$index++;
	}
?>
	</tbody>									
	</table>
</body>
</html>