<div id="organizerBar" class="organizeBar">
	<span class="ui-buttonset">
<?
	$numberOfPhases = 5;
	for( $index = 1; $index <= $numberOfPhases; $index++ )
	{
?>
		<input type="radio" id="phase<? echo $index; ?>" class="ui-helper-hidden-accessible" />
		<label 
			for="phase<? echo $index; ?>"
<? 		
		$class = "ui-button ui-widget ui-state-default ui-button-text-only ";
		if( $_SESSION['phaseNumber'] >= $index )
		{
			$class = $class."reachable ";
			if( $_SESSION['phaseNumber'] == $index ) 
				$class = $class."ui-state-active "; 
		}
		else 
			$class = $class."unreachable ";
		
		if( $index == 1 )
			$class = $class."firstButtonBar ";
		if( $index == $numberOfPhases )
			$class = $class."lastButtonBar ";
			
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
		var loadPhaseFromBar = function() 
		{
			var $this = $(this);
			var phase = $(this).attr('for'); 
			var phaseNumber = phase.charAt( phase.length - 1 ); 
			$.ajax({
				type: 'POST',
				url: './createNewGame.php',
				data: { destinationPhase: phaseNumber,
						usingAjax: 'true' },
				dataType: 'html',
				success: function( response ) 
				{
					$("#wrapper").html( response );
				},
				error: function( xhr, textStatus, errorThrown ) 
				{
					// TODO: catch error states
				}
			});
		
		};
		$('#organizerBar label.reachable').click( loadPhaseFromBar );
	});
	
})(jQuery);
</script>