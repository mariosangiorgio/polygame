<div id="organizerBar" class="organizeBar">
	<span class="ui-buttonset">
<?
	$numberOfPhases = 4;
	for( $index = 1; $index <= $numberOfPhases; $index++ )
	{
?>
		<input type="radio" id="phase<? echo $index; ?>" class="ui-helper-hidden-accessible" />
		<label 
			for="phase<? echo $index; ?>"
<? 		
		$class = "ui-button ui-widget ui-state-default ui-button-text-only ";
		if( $phaseNumber >= $index )
		{
			$class = $class."reachable ";
			if( $phaseNumber == $index ) 
				$class = $class."ui-state-active "; 
		}
		else 
			$class = $class."unreachable";
		
		echo "class=\"".$class."\"";
?>
			role="button"
			aria-pressed="false" 
			aria-disabled="false"
		>
			<span class="ui-button-text"><? echo $TEXT['newGameBar-phase_'.$index]?></span>
		</label>
<?
	}
?>
	</span>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		$('#organizerBar label.reachable').click( function() 
		{
			var $this = $(this);
			var phase = $(this).attr('for'); 
			var phaseNumber = phase.charAt( phase.length - 1 ); 
			$.ajax({
				type: 'POST',
				url: './createNewGame.php',
				data: { phase: phaseNumber,
						usingAjax: 'true' },
				dataType: 'html',
				success: function( response ) 
				{
					$("#phases").html( response );
					$('#organizerBar label.ui-state-active').removeClass('ui-state-active');
					$($this).addClass('ui-state-active');
					
					var currentPhase = $($this).attr('for'); 
					var currentPhaseNumber = currentPhase.charAt( currentPhase.length - 1 ); 
					
					var labels = $('#organizerBar label');
					for( var index = 0; index < labels.length; index++ )
					{
						var phase = $(labels[index]).attr('for'); 
						var phaseNumber = phase.charAt( phase.length - 1 );
						if( phaseNumber <= currentPhaseNumber )
							$(labels[index]).removeClass('unreachable').addClass('reachable');
						else
							$(labels[index]).removeClass('reachable').addClass('unreachable');
					}
				},
				error: function( xhr, textStatus, errorThrown ) 
				{
					// TODO: catch error states
				}
			});
		
		});
	});
})(jQuery);
</script>