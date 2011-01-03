<?
	include_once("../inc/db_connect.inc");
	include_once("../inc/init.inc");
	include_once("../inc/utils.inc");
	include_once("../lang/".$gData['langFile']);
	
	checkAuthentication('player', 1 );
	
	if( !isSet( $_POST['solution'] ) ||
			!is_numeric( $_POST['solution'] ))
		redirectTo('../errorPage.php');
	
	$solution = $_POST['solution'];
	
	$query = "SELECT `Solution` as solution ".
			"FROM `players` p, `wedges` w ".
			"WHERE `Player ID`='".$gData['userID']."' ".
			"AND p.`Wedge ID`=w.`Wedge ID`;";
	$result = mysql_query( $query, $connection );
	$wedge = mysql_fetch_array( $result );
		
	if( $solution == $wedge['solution'] )
	{
		$query = "UPDATE `wedge groups` ".
				"SET `Result`='$solution' ".
				"WHERE (`Game ID`,`Wedge ID`) IN ( ".
				" SELECT `Game ID`,`Wedge ID` ".
				" FROM `players` ".
				"WHERE `Player ID`='".$gData['userID']."' );";
		$result = mysql_query( $query, $connection );
?>
<div id="stateBar" class="responseRight ui-corner-all">
	<h1>
		<? echo $TEXT['play_stateBar-h1_1_1'].
				$gData['username'].
				$TEXT['play_stateBar-h1_1_2']; ?>
	</h1>
	<p><? echo $TEXT['play_stateBar-p_5']; ?></p>
	<p><? echo $TEXT['play_stateBar-p_6']; ?></p>
	<form
		name="createPosterForm"
		action="./play.php"
		method="GET"
	>
		<button type="submit"><? echo $TEXT['play_stateBar-button_2']; ?></button>
	</form>
</div>
<?
	}
	else
	{
?>
<div id="stateBar" class="responseWrong ui-corner-all">
	<h1>
		<? echo $TEXT['play_stateBar-h1_1_1'].
				$gData['username'].
				$TEXT['play_stateBar-h1_1_2']; ?>
	</h1>
	<p><? echo $TEXT['play_stateBar-p_7']; ?></p>
 	<p><? echo $TEXT['play_stateBar-p_8_1']; ?><a href="TODO" class="link"><? echo $TEXT['play_stateBar-p_8_2']; ?></a><? echo $TEXT['play_stateBar-p_8_3']; ?></p>
	<form
		name="solutionForm"
		action="./backend/submitSolution.php"
		method="POST"
	>
		<input type="text" name="solution" value="<? echo $solution; ?>"/>
		<button type="submit"><? echo $TEXT['play_stateBar-button_1']; ?></button>
	</form>
</div>
<script type="text/Javascript"> 
(function($){
	$('form[name="solutionForm"]').submit( function( event )
	{
		event.preventDefault();
		var url = $(this).attr('action');
		var dataToSend = $(this).serialize();
		var typeOfDataToReceive = 'html';
		var callback = function( response ) {
			$('#stateBar').remove();
			$('#wrapper').append( response );
			$('button').button();
		};
		$.post( url, dataToSend, callback, typeOfDataToReceive );
	});
	$('input[name="solution"]').focus().select();
})(jQuery);
</script> 
<?		
	}
?>