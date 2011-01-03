<div id="createNewGameBar" class="orizontalBar">
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
		if( $currentPhase > $index )
			$class = $class."reachable ";
		else 
		{
			if( $currentPhase == $index ) 
				$class = $class."ui-state-active "; 
			$class = $class."unreachable ";
		}
		
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
			var phase = $(this).attr('for'); 
			var phaseNumber = phase.charAt( phase.length - 1 );
			var url = "./createNewGame.php";
			var dataToSend = "phase=" + phaseNumber + "&usingAjax=true";
			var typeOfDataToReceive = 'html';
			var callback = function( response ) {
				$("#wrapper").html( response );
			};
			$.get( url, dataToSend, callback, typeOfDataToReceive );
		};
		$('#createNewGameBar label.reachable').click( loadPhaseFromBar );
	});
	
})(jQuery);
</script>
