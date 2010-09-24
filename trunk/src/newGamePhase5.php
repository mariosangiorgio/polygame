<? include "newGameBar.php"; ?>
<div id="divPhase5" class="phase5 phases">
	<p><? echo $TEXT['newGamePhase5-p_1']; ?></p>
	<div class="playerList ui-corner-all">
		<p><? echo $TEXT['newGamePhase5-p_2']; ?></p>
		<table class="playerTable">
		<tbody>
<?			
	if( isSet( $_SESSION['phase5'] ))
	{
		for( $counter = 0; $counter < $_SESSION['phase5']['numberOfVoters']; $counter++ )
		{
?>
			<tr>
				<td class="firstColumn"><? echo $_SESSION['phase5']['voters'][$counter]; ?></td>
				<td class="secondColumn"><button type="button" class="removePlayer" ><? echo $TEXT['newGamePhase3_2-button_delete']; ?></button></td>
			</tr>
<?
		}
	}
	else
	{
?>
			<tr class="emptyRow">
				<td colspan="2"><? echo $TEXT['newGamePhase5-noVoters_1']; ?></td>
			</tr>
<?
	}
?>
		</tbody>
		</table>
		<div class="errorClass ui-corner-all">
			<span class="ui-icon ui-icon-info"></span>
			<strong></strong>
		</div>
	</div>
	<div class="addGroup ui-corner-all">
		<table>
		<tbody>
			<tr>
				<td class="firstColumn">
					<input type="text"  size="40" value="<? echo $TEXT['newGamePhase5-input_1']; ?>" name="newVoter" />
				</td>			
				<td class="secondColumn">
					<button type="button" class="addPlayer" ><? echo $TEXT['newGamePhase3_2-button_add']; ?></button>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="errorClass ui-corner-all">
						<span class="ui-icon ui-icon-info"></span>
						<strong></strong>
					</div>
				</td>
			</tr>
		</tbody>
		</table>
	</div>
	<div id="nextPhaseButton">
		<button type="submit"><? echo $TEXT['newGamePhase5-button_1']; ?></button>
	</div>		
	</div>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		var voterDefaultValue = "<? echo $TEXT['newGamePhase5-input_1']; ?>";
		var deleteButton = "<button type=\"button\" class=\"removePlayer\" ><? echo $TEXT['newGamePhase3_2-button_delete']; ?></button>";
		var emptyRow = "<tr class=\"emptyRow\"><td colspan=\"3\"><? echo $TEXT['newGamePhase5-noVoters_1']; ?></td></tr>";
		
		$('div.addGroup button.addPlayer').click( function()
		{
			var newVoterName = $('div.addGroup input[name="newVoter"]').val();
			var errorStr = checkVoterName( newVoterName );
			if( !errorStr )
			{
				$('div.playerList div.errorClass strong, div.addGroup div.errorClass strong').html('');
				$('div.playerList div.errorClass:visible, div.addGroup div.errorClass:visible').slideUp();
				$('div.addGroup input[name="newVoter"]').attr('value', voterDefaultValue );
				var row = "<tr><td class=\"firstColumn\">" + newVoterName + "</td><td class=\"secondColumn\">" + 
							deleteButton + "</td></tr>";
				if( !$('div.playerList tbody tr:not(.emptyRow)').length )
					$('div.playerList tbody').html('');
				$('div.playerList tbody').append( row );
				
				$('button.removePlayer').button( {
					icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
				});
			}
			else
			{
				$('div.addGroup div.errorClass strong').html( errorStr );
				$('div.addGroup div.errorClass').slideDown();
			}
		});
		$('table.playerTable tbody td.secondColumn button.removePlayer').live('click', function()
		{
			var table = $(this).parents('table');
			var tbody = $(this).parents('tbody');
			var row = $(this).parents('tr');
			$(row).remove();
			if( !$('tr', $(tbody)).length )
				$(table).append( emptyRow );
		});
		$('button.addPlayer').button( {
			icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
		});
		$('button.removePlayer').button( {
			icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
		});
		$('div.addGroup input[name="newVoter"]').focus( function() {
			$(this).removeAttr('value');
		});
		$('div.addGroup input[name="newVoter"]').blur( function() {
			if( !$(this).attr('value'))
				$(this).attr('value', voterDefaultValue );
		});
		$('#nextPhaseButton button[type="submit"]').button().click( function( event )
		{
			event.preventDefault();
			var rows = $('div.playerList table.playerTable tbody tr:not(.emptyRow)');
			
			if( !$(rows).length )
			{
				var errorDiv = $('div.playerList').find('div.errorClass');
				$('strong', $(errorDiv)).html("<? echo $TEXT['newGamePhase5-noVoters_2']; ?>");
				$(errorDiv).slideDown();
			}
			else
			{
				var dataString = "usingAjax=true&comingPhase=5&destinationPhase=5";
				var voterIndex = 0;
				$(rows).each( function() 
				{
					var voterId = $('td.firstColumn', $(this)).text();
					dataString += "&voter" + voterIndex + "=" + voterId;
					voterIndex++;
				});
				dataString += "&numberOfVoters=" + voterIndex;
				var url = "./createNewGame.php";
				var dataToSend = dataString;
				var typeOfDataToReceive = 'html';
				var callback = function( response ) {
					$("#wrapper").html( response );
				};
				$.post( url, dataToSend, callback, typeOfDataToReceive );
			}
		});
		
		function checkVoterName( currentVoter )
		{
			if( currentVoter == voterDefaultValue )
				return "<? echo $TEXT['newGamePhase5-error_1']; ?>";
			var result = "";
			var rows = $('div.playerList tbody tr:not(.emptyRow)');
			$(rows).each( function() 
			{
				var voter = $('td.firstColumn', $(this)).text();
				if( voter == currentVoter )
				{
					result = "<? echo $TEXT['newGamePhase5-error_2']; ?>";
					return ;
				}
			});
			return result;
		}
	});
})(jQuery);
</script>