<div id="organizerBar" class="organizeBar">
	<span class="ui-buttonset">
		<input type="radio" id="phase1" class="ui-helper-hidden-accessible" />
		<label for="phase1" class="ui-state-active ui-button ui-widget ui-state-default ui-button-text-only ui-corner-left" aria-pressed="true" role="button" aria-disabled="false">
			<span class="ui-button-text">Choose game duration</span>
		</label>
		<input type="radio" id="phase2" class="ui-helper-hidden-accessible">
		<label for="phase2" aria-pressed="false" class="ui-button ui-widget ui-state-default ui-button-text-only" role="button" aria-disabled="false">
			<span class="ui-button-text">Choose wedges</span>
		</label>
		<input type="radio" id="phase3" class="ui-helper-hidden-accessible">
		<label for="phase3" aria-pressed="false" class="ui-button ui-widget ui-state-default ui-button-text-only" role="button" aria-disabled="false">
			<span class="ui-button-text">Make groups</span>
		</label>
		<input type="radio" id="phase4" class="ui-helper-hidden-accessible">
		<label for="phase4" aria-pressed="false" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-right" role="button" aria-disabled="false">
			<span class="ui-button-text">Choose voters</span>
		</label>
	</span>
</div>
<script type="text/javascript">
	$( function() {
		$('#organizerBar label').click( function() 
		{
			var $this = $(this);
			var phase = $(this).attr('for'); 
			var phaseNumber = phase.charAt( phase.length - 1 ); 
			$.ajax({
				type: 'GET',
				url: './createNewGame.php',
				data: { phase: phaseNumber,
						usingAjax: 'true' },
				dataType: 'html',
				success: function( response ) 
				{
					$("#phases").html( response );
					$('#organizerBar label.ui-state-active').removeClass('ui-state-active');
					$( $this ).addClass('ui-state-active');
				},
				error: function( xhr, textStatus, errorThrown ) 
				{
					// TODO: catch error states
				}
			});
		
		});
	});
</script>