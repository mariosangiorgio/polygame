<? include "newGameBar.php"; ?>
<div id="divPhase3" class="phases">
	<form
		name="phase12Form"
		action="./createNewGame.php"
		method="POST"
		enctype="multipart/form-data"
	>
		<p>You can load a list of names from a file:
			<input type="file" name="playersList" size="28" id="playersList" />
		</p>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="phase" value="<? echo ( $phaseNumber + 1 ); ?>" />
	<table>
	<tbody>
		<tr>
			<td>
				
			</td>
		</tr>
	</tbody>					
	<tfoot>
		<tr>
			<td colspan="2">
				<button id="forwardButton" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" >
					<span class="ui-button-text">I'm done with players!</span>
				</button>
			</td>
		</tr>
	</tfoot>					
	</table>					
	</div>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		$('#divPhase2 form').submit( function( event )
		{
			event.preventDefault();
			$('input[name="usingAjax"]', this ).val('true');
			var $this = $(this);
			var url = $this.attr('action');
			var formName = $this.attr('name');
			var dataToSend = $this.serialize();
			var typeOfDataToReceive = 'html';
			var callback = function( response )
			{
				$("#phases").html( response );
				$('#organizerBar label[for="phase<? echo $phaseNumber; ?>"]').removeClass('ui-state-active');
				$('#organizerBar label[for="phase<? echo ( $phaseNumber + 1 ); ?>"]').addClass('ui-state-active');
				$('#organizerBar label[for="phase<? echo ( $phaseNumber + 1 ); ?>"]').toggleClass('unreachable reachable');
			};
			
			$.post( url, dataToSend, callback, typeOfDataToReceive );	
		});
		
		$('#selectable li').click( function() {
			$(this).toggleClass('ui-selected ui-selectee');
			if( $('input[type="hidden"]', this ).attr('value') == "true" )
				 $('input[type="hidden"]', this ).val("false");
			else
				 $('input[type="hidden"]', this ).val("true");
		});
		
		$('#selectAll').click( function() {
			$('#selectable li').removeClass('ui-selectee');
			$('#selectable li').addClass('ui-selected');
			$('#selectable li input[type="hidden"]').val("true");
		});
		
		$('#deselectAll').click( function() {
			$('#selectable li').removeClass('ui-selected');
			$('#selectable li').addClass('ui-selectee');
			$('#selectable li input[type="hidden"]').val("false");
		});
	});
})(jQuery);
</script>