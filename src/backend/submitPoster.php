<?
	include_once("../inc/db_connect.inc");
	include_once("../inc/init.inc");
	include_once("../inc/utils.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('player', 1 );
	
	if( !isSet( $_POST['pros'] ) ||
			!isSet( $_POST['cons'] ) ||
			!isSet( $_POST['notes'] ))
		redirectTo('../errorPage.php');
		
	$pros = mysql_real_escape_string( $_POST['pros']);
	$cons = mysql_real_escape_string( $_POST['cons']);
	$notes = mysql_real_escape_string( $_POST['notes']);
		
	$query = "UPDATE `wedge groups` ".
			"SET `pros`='$pros', ".
			"`cons`='$cons', ".
			"`notes`='$notes', ".
			"`Poster submitted`='1' ".
			"WHERE (`Game ID`,`Wedge ID`) IN ( ".
			" SELECT `Game ID`,`Wedge ID` ".
			" FROM `players` ".
			"WHERE `Player ID`='".$gData['userID']."' );";
	$result = mysql_query( $query, $connection );
	
	header("Location: ../play.php");
	exit();
?>