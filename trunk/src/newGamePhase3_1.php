<div class="phase3_1">
<p><? echo $TEXT['newGamePhase3_1-p_1']; ?></p>
	<table class="tablePhase3">
	<tbody>
		<tr>
			<td>
				<h1><? echo $TEXT['newGamePhase3_1-h_1']; ?></h1>
			</td>
			<td>
				<h1><? echo $TEXT['newGamePhase3_1-h_2']; ?></h1>
			</td>
		</tr>
		<tr>
			<td>
				<p><? echo $TEXT['newGamePhase3_1-p_2']; ?></p>
			</td>
			<td>
				<p><? echo $TEXT['newGamePhase3_1-p_4']; ?></p>
			</td>
		</tr>
		<tr>
			<td>
				<p><em><? echo $TEXT['newGamePhase3_1-p_3']; ?></em></p>
			</td>
			<td>
				<p><em><? echo $TEXT['newGamePhase3_1-p_5']; ?></em></p>
			</td>
		</tr>
		<tr>
			<td>
				<button type="button"><? echo $TEXT['newGamePhase3_1-button_1']; ?></button>
				<input type="hidden" name="useEmail" value="false" />
			</td>
			<td>
				<button type="button"><? echo $TEXT['newGamePhase3_1-button_2']; ?></button>
				<input type="hidden" name="useEmail" value="true" />
			</td>
		</tr>
	</tbody>
	</table>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		$('div.phase3_1 button').button().click( function( event )
		{
			event.preventDefault();
			var url = "./createNewGame.php";
			var dataType = $(this).next().val();
			var dataToSend = { phase: 3,
							useEmail: dataType };
			var typeOfDataToReceive = 'html';
			var callback = function( response ) {
				$("#wrapper").html( response );
			};
			$.post( url, dataToSend, callback, typeOfDataToReceive );
		});
	});
})(jQuery);
</script>
