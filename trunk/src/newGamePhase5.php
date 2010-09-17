<? include "newGameBar.php"; ?>
<div id="divPhase4" class="phase5 phases">
	<p>Finally choose the voters that will examine the solutions proposed</p>
	<form
		name="phase5Form"
		action="./createNewGame.php"
		method="POST"
	>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="phase" value="<? echo ( $_SESSION['phaseNumber'] + 1 ); ?>" />
	<table class="phaseTable">
	<tbody>
		<tr>
			<td>
				<div id="selectingButton">
					<a id="selectAll" class="link">Select all</a>
					<a id="deselectAll" class="link">Deselect all</a>
				</div>
				<ol id="selectable">
<? 
	$query = "SELECT username ". 
			 "FROM Users ".
			 "WHERE role='voter'";
	$data = mysql_query( $query, $connection );
	
	$index = 0;
	while( $voter = mysql_fetch_array( $data )) 
	{
?>
					<li class="ui-corner-all ui-selectee">
						<input 
							type="checkbox"
							name="voter<? echo $index; ?>"
							value="<? echo $voter['username']; ?>"
							class="ui-helper-hidden-accessible" />
						<? echo $voter['username']; ?>
					</li>
<?
		$index++;
	}
?>
				</ol>
			</td>
		</tr>
	</tbody>									
	</table>				
	<div id="nextPhaseButton">
		<button type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" >
			<span class="ui-button-text">I'm done with voters!</span>
		</button>
	</div>
	</form>				
	</div>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		$('#selectable li').click( function() 
		{
			$(this).toggleClass('ui-selected ui-selectee');
			var checkbox = $('input[type="checkbox"]', this );
			if( $(checkbox).attr('checked'))
				$(checkbox).removeAttr('checked');
			else
				$(checkbox).attr('checked', true );
		});
		
		$('#selectAll').click( function() 
		{
			var elements = $('#selectable li');
			$(elements).removeClass('ui-selectee');
			$(elements).addClass('ui-selected');
			$('input[type="checkbox"]', $(elements)).attr('checked', true );
		});
		
		$('#deselectAll').click( function() 
		{
			var elements = $('#selectable li');
			$(elements).removeClass('ui-selected');
			$(elements).addClass('ui-selectee');
			$('input[type="checkbox"]', $(elements)).removeAttr('checked');
		});
	});
})(jQuery);
</script>